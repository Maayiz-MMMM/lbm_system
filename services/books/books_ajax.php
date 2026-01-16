
<?php
require_once __DIR__.'/../../config.php';
require_once __DIR__.'/../../models/book.php';
require_once __DIR__.'/../../helpers/file_uploader.php';
require_once __DIR__.'/../../models/borrowing.php';
require_once __DIR__.'/../../models/category.php';


header('Content-Type: application/json');

//method == post start

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$target_dir = BASE_PATH . "/assets/uploads/";

    //action start
    if(isset($_POST['action']) ){
        //create_book start
        if ( $_POST['action'] === 'create_book') {
            try {

                $title = trim($_POST['title'])??'';
                $author = trim($_POST['author'])??'';
                $category_id = trim($_POST['category_id'])??'';
                $total_qty = trim($_POST['total_qty'])??'';
                $isbn = trim($_POST['isbn'])??'';



             $fields = [ 'Title'   => trim($_POST['title']),
                              'Author'  => trim($_POST['author']),];

                $pattern = '/^[A-Za-z]{2,}(?: [A-Za-z]{2,})*$/';

                foreach ($fields as $name => $value) {
                    if (!preg_match($pattern, $value)) {
                        echo json_encode([
                            'status'  => 'error',
                            'message' => "$name must contain only letters with one space between words (min 2 letters per word)."
                        ]);
                        exit;
                    }
                }
              

              if (empty($title) || empty($author) || empty($category_id) || empty($total_qty) || empty($isbn)) {
                    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
                    exit;
                }

                
                $imageFileName = null;
                 $bookmodel = new Book();
                 $bookmodel->startTransaction();



                 if (!empty($_FILES['cover_image'])) {
            $imageFileName = uploadImage(
                $_FILES['cover_image'],
                BASE_PATH . '/assets/uploads/books/',
                500000 
            );
                      }
       


               
             $available_qty = $total_qty;
                
                $result = $bookmodel->add_new_book($title, $author, $category_id, $imageFileName, $total_qty,$available_qty,$isbn);
   
              
                
                if ($result) {
                    $bookmodel->commit();
                    echo json_encode(['status' => 'success', 'message' => 'Book created successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'authors or title already exist']);
                }
            } catch (Exception $e) {
                $bookmodel->rollback();
                echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
            }
        }
   //create_book end

   //get_book_details start
        if ( $_POST['action'] === 'get_book_details') {
            try {

                $id = trim($_POST['book_id'])??'';
               
                if (empty($id)) {
                    echo json_encode(['status' => 'error', 'message' => 'Book is required.']);
                    exit;
                }
                $bookmodel = new Book();
                $book = $bookmodel->getById($id);

                $categorymodel = new Category();
                $categories = $categorymodel->getAllCategory();
                
                if ($book) {
                    echo json_encode([ 'status' => 'success',  'data' => $book, 'categories' => $categories ]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Book not found.']);
                }
             
              
              
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
            }
        }
        //get_book_details end

        //update_book start
       //update_book start
    if ($_POST['action'] === 'update_book') {

    try {
        $id          = trim($_POST['book_id'] ?? '');
        $title       = trim($_POST['title'] ?? '');
        $author      = trim($_POST['author'] ?? '');
        $category_id    = trim($_POST['category_id'] ?? '');
        $total_qty   = trim($_POST['total_qty'] ?? '');
        $isbn        = trim($_POST['isbn'] ?? '');
        $old_image   = $_POST['old_cover_image'] ?? '';
        $new_cover_image = $_FILES['cover_image'] ?? null;
        $is_active = $_POST['is_active'] ?? true;
        

             $fields = [ 'Title'   => trim($_POST['title']),
                              'Author'  => trim($_POST['author'])
                            ];

                $pattern = '/^[A-Za-z]{2,}(?: [A-Za-z]{2,})*$/';

                foreach ($fields as $name => $value) {
                    if (!preg_match($pattern, $value)) {
                        echo json_encode([
                            'status'  => 'error',
                            'message' => "$name must contain only letters with one space between words (min 2 letters per word)."
                        ]);
                        exit;
                    }
                }

        if (empty($id) || empty($title) || empty($author) || empty($category_id) || empty($total_qty) || empty($isbn)) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
            exit;
        }

        $bookmodel = new Book();
        $bookmodel->startTransaction();

        $book = $bookmodel->getBookUseBookId($id);

        if (!empty($new_cover_image) && $new_cover_image['error'] !== UPLOAD_ERR_NO_FILE) {
            $imageFileName = uploadImage(
                $_FILES['cover_image'],
                BASE_PATH . '/assets/uploads/books/',
                500000 
            );
        } else {
            $imageFileName = $old_image;
        }

        $oldTotal     = $book['total_qty'];
        $oldAvailable = $book['available_qty'];
        $borrowedQty  = $oldTotal - $oldAvailable;

        if ($total_qty < $borrowedQty) {
            echo json_encode([
                'status'  => 'error',
                'message' => "Cannot reduce total quantity below borrowed quantity ({$borrowedQty})"
            ]);
            exit;
        }

        $available_qty = $total_qty - $borrowedQty;

      $result =   $bookmodel->saveCall($title,$author,$category_id,$imageFileName,$available_qty,$total_qty,$isbn,$is_active,$id);


        if ($result) {
            $bookmodel->commit();
            echo json_encode(['status' => 'success', 'message' => 'Book updated successfully']);
        } else {
            $bookmodel->rollback();
            echo json_encode(['status' => 'error', 'message' => 'Failed to update book']);
        }

    } catch (Exception $e) {
        $bookmodel->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

        //update_book end
        //delete_book start
        if ($_POST['action'] === 'delete_book') {
            try {
                $id = trim($_POST['book_id'] ?? '');

                if (empty($id)) {
                    echo json_encode(['status' => 'error', 'message' => 'Book ID is required.']);
                    exit;
                }


                $bookmodel = new Book();
                $book = $bookmodel->getById($id);

                if (!$book) {
                    echo json_encode(['status' => 'error', 'message' => 'Book not found.']);
                    exit;
                }
                $bookmodel->startTransaction();

                $borrowModel = new Borrowing();
                $borrowCount = $borrowModel->bookBorrowCheck($id);
                if ($borrowCount > 0) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'This book cannot be deleted because it has borrow history.'
                    ]);
                    exit;
                }
                $target_dir = BASE_PATH . '/assets/uploads/books/';
                if (!empty($book['cover_image']) && file_exists($target_dir . $book['cover_image'])) {
                    unlink($target_dir . $book['cover_image']);
                }

                $bookmodel->setId($id);
                $result = $bookmodel->deleteRec($id);

                if ($result) {
                    $bookmodel->commit();
                    echo json_encode(['status' => 'success', 'message' => 'Book deleted successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to delete book.']);
                }
            } catch (Exception $e) {
                $bookmodel->rollback();
                echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
            }
        }

        //delete_book end

            
    //action end

   
   
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
    }
   
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}


?>