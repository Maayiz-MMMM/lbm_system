
<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../models/book.php';

require_once __DIR__ . '/../../models/borrowing.php';
require_once __DIR__ . '/../../models/fine.php';

header('Content-Type: application/json');


//method == post start

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $target_dir = BASE_PATH . "/assets/uploads/";

    //action start
    if (isset($_POST['action'])) {
        //create_book start
        if ($_POST['action'] === 'pay_fine') {
            try {
                $borrow_id = trim($_POST['pay_borrows_id']) ?? '';
                $fine_id = trim($_POST['pay_fine_id']) ?? '';

                if (empty($borrow_id) || empty($fine_id)) {
                    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
                    exit;
                }

                $fineModel = new Fine();
                $borrowModel = new Borrowing();
                $result = $fineModel->markFineAsPaid($fine_id);
                if ($result) {
                    $borrowModel->clearBorrowingFine($borrow_id);

                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Fine paid successfully'
                    ]);
                    exit;
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Failed to update fine'
                    ]);
                }
                exit;



                if ($result) {
                    echo json_encode(['status' => 'success', 'message' => 'borrowing created successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to create borrowing.']);
                }
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
            }
        }
    }  
    
    else {
                    echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
                }
                //action end
}





?>