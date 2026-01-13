<?php

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../models/book.php';
require_once __DIR__ . '/../../models/borrowing.php';
require_once __DIR__ . '/../../models/fine.php';

header('Content-Type: application/json');

//POST start
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action'])) {


        // Create Borrowing

        if ($_POST['action'] === 'create_borrowing') {
            try {
                $member_id  = trim($_POST['member']) ?? '';
                $book_id    = trim($_POST['book']) ?? '';
                $issue_date = trim($_POST['issue_date']) ?? '';
                $qty        = trim($_POST['qty']) ?? '';
                $status     = trim($_POST['status']) ?? '';

                $last_date = date('Y-m-d', strtotime($issue_date . ' +7 days'));

                if (empty($member_id) || empty($book_id) || empty($issue_date) || empty($qty) || empty($status) || empty($last_date)) {
                    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
                    exit;
                }

                $bookModel = new Book();
                $book_quantaties = $bookModel->getBookUseBookId($book_id);

                if ($qty > $book_quantaties['available_qty']) {
                    if ($book_quantaties['available_qty'] == 0) {
                        echo json_encode(['status' => 'error', 'message' => 'This book is currently out of stock.']);
                        exit;
                    }
                    echo json_encode(['status' => 'error', 'message' => 'Requested quantity exceeds available stock.']);
                    exit;
                }

                $bookModel->decreaseAvailableQty($book_id, $qty);

                $borrowedModel = new Borrowing();
                $result = $borrowedModel->add_new_borrowing($member_id, $book_id, $issue_date, $qty, $status, $last_date);

                if ($result) {
                    echo json_encode(['status' => 'success', 'message' => 'Borrowing created successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to create borrowing.']);
                }
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
            }
        }


        // Create Return Date

        if ($_POST['action'] === 'create_return_date') {
            try {
                $borrow_id   = trim($_POST['borrow_id'] ?? '');
                $return_date = trim($_POST['return_date'] ?? '');

                if (empty($borrow_id) || empty($return_date)) {
                    echo json_encode(['status' => 'error', 'message' => 'Missing data']);
                    exit;
                }

                $borrowModel = new Borrowing();
                $bookModel   = new Book();
                $fineModel   = new Fine();

                
                $borrowing = $borrowModel->getBorrowingsWithMembersAndBooksByborrowID($borrow_id);
                $borrowing['issue_date'];
                $return_date ;
                if ($return_date < $borrowing['issue_date']){
                        echo json_encode([
    'status' => 'error',
    'message' => "Oops! Return date must be after your issue date ({$borrowing['issue_date']})."
]);
    exit;
                }
                   

                if (!$borrowing) {
                    echo json_encode(['status' => 'error', 'message' => 'Borrow record not found']);
                    exit;
                }

                if ($borrowing['status'] === 'returned') {
                    echo json_encode(['status' => 'error', 'message' => 'This book is already returned']);
                    exit;
                }

                $last_date = new DateTime($borrowing['last_date']);
                $return_dt = new DateTime($return_date);
                $fine = 0;
                if ($return_dt > $last_date) {
                    $fine = $last_date->diff($return_dt)->days * FINE_PER_DAY;
                }

                $borrowModel->startTransaction();

                $borrowModel->updateBorrowingReturn($borrow_id, $return_date, $fine, 'returned');

                $bookModel->increase_available_book($borrowing['book_id'], $borrowing['qty']);


                if ($fine > 0) {
                    $fineModel->addFine($borrow_id, $borrowing['member_id'], $fine, 'pending');
                }

                $borrowModel->commit();

                echo json_encode(['status' => 'success', 'message' => 'Book returned successfully', 'fine' => $fine]);
                exit;
            } catch (Exception $e) {
                if (isset($borrowModel)) {
                    $borrowModel->rollback();
                }
                echo json_encode(['status' => 'error', 'message' => 'Transaction failed: ' . $e->getMessage()]);
                exit;
            }
        }


        // Get Borrowing

        if ($_POST['action'] === 'get_borrowing') {
            $borrow_id = trim($_POST['borrow_id'] ?? '');

            if (empty($borrow_id)) {
                echo json_encode(['status' => 'error', 'message' => 'Missing borrow ID.']);
                exit;
            }

            try {
                $borrowModel = new Borrowing();
                $borrowing = $borrowModel->getBorrowingsWithMembersAndBooksByborrowID($borrow_id);

                if ($borrowing) {
                    echo json_encode(['status' => 'success', 'data' => $borrowing]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Borrowing record not found.']);
                }
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
            }
        }


        // Edit Borrowing

        if ($_POST['action'] === 'edit_borrowing') {
            $borrowingModel = new Borrowing();
            $bookModel      = new Book();

            try {
                $borrow_id  = trim($_POST['borrow_id'] ?? '');
                $member_id  = trim($_POST['member_id'] ?? '');
                $book_id    = trim($_POST['book_id'] ?? '');
                $issue_date = trim($_POST['issue_date'] ?? '');
                $qty        = (int)($_POST['qty'] ?? 0);
                $status     = trim($_POST['status'] ?? '');

                if (!$borrow_id || !$member_id || !$book_id || !$issue_date || $qty <= 0 || !$status) {
                    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
                    exit;
                }

                $current = $borrowingModel->getBorrowingsWithMembersAndBooksByborrowID($borrow_id);

                if (!$current) {
                    echo json_encode(['status' => 'error', 'message' => 'Borrowing record not found']);
                    exit;
                }
                

             $bookallDetails =   $bookModel->getById($book_id);

           $nowAvailableBookQty =   $bookallDetails['available_qty'];

                $old_qty   =$current['qty'];
                $old_book  =$current['book_id'];
                $old_status = $current['status'];
              $already_borrowed_qty =  $borrowingModel->getBooksQtyByBorrowid($borrow_id);

                $old_qty    = (int)$current['qty'];
                $new_qty    = (int)$qty;
                $diff_qty   = $new_qty - $old_qty;

                         $borrowingModel->startTransaction();
                         if ($diff_qty > 0 && $diff_qty > $nowAvailableBookQty) {
                         echo json_encode([
                         'status' => 'error','message' => 'Requested quantity exceeds available stock.' ]);
                          exit;
                        }
                



                if ($status === 'borrowed') {
                    $issue = new DateTime($issue_date);
                    $last  = clone $issue;
                    $last->modify('+7 days');
                    $last_date = $last->format('Y-m-d');

                    if ($book_id == $old_book) {
                        $diff = $qty - $old_qty;
                        if ($diff > 0) {
                            $bookModel->decreaseAvailableQty($book_id, $diff);
                        } elseif ($diff < 0) {
                            $bookModel->increase_available_book($book_id, abs($diff));
                        }
                    } else {
                        $bookModel->increase_available_book($old_book, $old_qty);
                        $bookModel->decreaseAvailableQty($book_id, $qty);
                    }

                    $borrowingModel->updateBorrowingWithLastDate($borrow_id, $member_id, $book_id, $issue_date, $qty, 'borrowed', $last_date, null);
                } elseif ($status === 'returned') {
                    if ($old_status === 'borrowed') {
                        $bookModel->increase_available_book($old_book, $old_qty);
                    }
                }

                $borrowingModel->commit();
                echo json_encode(['status' => 'success', 'message' => 'Borrowing updated successfully']);
                exit;
            } catch (Exception $e) {
                $borrowingModel->rollback();
                echo json_encode(['status' => 'error', 'message' => 'Transaction failed: ' . $e->getMessage()]);
                exit;
            }
        }


        // Delete Borrow

        if ($_POST['action'] === 'delete_borrow') {
            try {
                $borrow_id = $_POST['borrow_id'] ?? null;

                if (!$borrow_id) {
                    echo json_encode(['status' => 'error', 'message' => 'Invalid Borrow Details.']);
                    exit;
                }

                $borrowModel = new Borrowing();
                $bookDtls = $borrowModel->getBooksQtyByBorrowid($borrow_id);
                $bookQty = $bookDtls['qty'];
                $book_id = $bookDtls['book_id'];

                $borrowModel->startTransaction();
                $bookModel = new Book();
                $bookModel->increase_available_book($book_id, $bookQty);

                $borrow_delete_result = $borrowModel->deleteRec($borrow_id);
                if ($borrow_delete_result) {
                    $borrowModel->commit();
                    echo json_encode(['status' => 'success', 'message' => 'Borrow Deleted Successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Borrow details not deleted.']);
                }
            } catch (Exception $e) {
                $borrowingModel->rollback();
                echo json_encode(['status' => 'error', 'message' => 'Transaction failed: ' . $e->getMessage()]);
                exit;
            }
        }

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}


?>
