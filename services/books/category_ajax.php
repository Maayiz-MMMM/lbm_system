
<?php
require_once __DIR__.'/../../config.php';
require_once __DIR__.'/../../models/category.php';
require_once __DIR__.'/../../models/book.php';


header('Content-Type: application/json');

//method == post start

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //action start
    if(isset($_POST['action']) ){
        //create_book start
        if ( $_POST['action'] === 'create_category') {
            try {

                $category_name = trim($_POST['name'])??'';



             $fields = [ 'name'   => trim($_POST['name']) ];

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
              

              if (empty($category_name) ) {
                    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
                    exit;
                }
                
                 $categorymodel = new Category;
                 $categorymodel->startTransaction();
                
                $result = $categorymodel->add_new_category($category_name);

              
                
                if ($result) {
                    $categorymodel->commit();
                    echo json_encode(['status' => 'success', 'message' => 'Category created successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Category already exist']);
                }
            } catch (Exception $e) {
                $categorymodel->rollback();
                echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
            }
        }
   //create_book end

   //get_book_details start
        if ( $_POST['action'] === 'get_category_details') {
            try {

                $id = trim($_POST['category_id'])??'';
               
                if (empty($id)) {
                    echo json_encode(['status' => 'error', 'message' => 'category is required.']);
                    exit;
                }
                $categorymodel = new Category();
                $category = $categorymodel->getById($id);
                
                if ($category) {
                    echo json_encode(['status' => 'success', 'data' => $category]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'category not found.']);
                }
             
              
              
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
            }
        }
        //get_book_details end

        //update_book start
       //update_book start
    if ($_POST['action'] === 'update_category') {

    try {
        $id          = trim($_POST['category_id'] ?? '');
        $category_name =  trim($_POST['name'] ?? '');
        $is_active = $_POST['is_active'] ?? true;
        

             $fields = [ 'category name'   => trim($_POST['name']),
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

        if (empty($id) || empty($category_name)) {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
            exit;
        }

        $categorymodel = new Category();
        $categorymodel->startTransaction();

      $result =   $categorymodel->saveCall($category_name,$is_active,$id);


        if ($result) {
            $categorymodel->commit();
            echo json_encode(['status' => 'success', 'message' => 'Category updated successfully']);
        } else {
            $categorymodel->rollback();
            echo json_encode(['status' => 'error', 'message' => 'This Category already exists']);
        }

    } catch (Exception $e) {
        $bookmodel->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

        //update_book end
        //delete_book start
        if ($_POST['action'] === 'delete_category') {
            try {
                $id = trim($_POST['category_id'] ?? '');

                if (empty($id)) {
                    echo json_encode(['status' => 'error', 'message' => 'category is required.']);
                    exit;
                }


                $categorymodel = new Category();
                $category = $categorymodel->getById($id);

                if (!$category) {
                    echo json_encode(['status' => 'error', 'message' => 'category not found.']);
                    exit;
                }
                $categorymodel->startTransaction();

                $bookModel = new Book();
                $category_use = $bookModel->getCategoryByCtgId($id);
                if (!empty($category_use)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'This category cannot be deleted because it has book history.'
                    ]);
                    exit;
                }
                $categorymodel->setId($id);
                $result = $categorymodel->deleteRec($id);

                if ($result) {
                    $categorymodel->commit();
                    echo json_encode(['status' => 'success', 'message' => 'category deleted successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to delete category.']);
                }
            } catch (Exception $e) {
                $categorymodel->rollback();
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