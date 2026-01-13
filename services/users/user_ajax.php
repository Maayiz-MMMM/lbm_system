
<?php
require_once __DIR__.'/../../config.php';
require_once __DIR__.'/../../models/User.php';
require_once __DIR__.'/../../models/borrowing.php';

require_once __DIR__.'/../../helpers/file_uploader.php';
header('Content-Type: application/json');

//method == post start

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //action start
    if(isset($_POST['action']) ){
        //create_user
        if ( $_POST['action'] === 'create_user') {
            try {

                $name = trim($_POST['full_name'])??'';
                $email = trim($_POST['email'])??'';
                $password = trim($_POST['password'])??'';
                $role = trim($_POST['role'])??'member';
                    $phone = trim($_POST['phone_number'])??'';
                    $profile_image = $_FILES['profile_image'] ?? null;

                $fields = [
                    'full name'   => trim($_POST['full_name']),
                ];

                $pattern = '/^[A-Za-z]{2,}(?: [A-Za-z]{2,})*$/';

                foreach ($fields as $names => $value) {
                    if (!preg_match($pattern, $value)) {
                        echo json_encode([
                            'status'  => 'error',
                            'message' => "$names must contain only letters with one space between words (min 2 letters per word)."
                        ]);
                        exit;
                    }
                }
                    
              

                // Check if password and confirm password match
              if (empty($name) || empty($email) || empty($password) || empty($phone)) {
                    echo json_encode(['status' => 'error', 'message' => 'Username, email, and password are required.']);
                    exit;
                }
                if ($_POST['password'] !== $_POST['confirm_password']) {
                    echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
                    exit;
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Please enter a valid email address.'
                    ]);
                    exit;
                }

                $usermodel = new User();

              $usermodel->startTransaction();
                if( $profile_image){
                     $profile_image_name = uploadImage(
                        $profile_image,
                        BASE_PATH . '/assets/uploads/profile/', 
                        500000 );
                }
                
                $result = $usermodel->add_new_user($name,$password, $role, $email,  $phone,$profile_image_name);
             
                
                if ($result) {
                        $usermodel->commit();
                    echo json_encode(['status' => 'success', 'message' => 'User created successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to create user. Username or email may already exist.']);
                }
            } catch (Exception $e) {
                    $usermodel->rollback();
                echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
    }

   if($_POST['action'] ==='update_user') {
    try {

        $user_id = trim($_POST['user_id'])??'';
        $name = trim($_POST['full_name'])??'';
        $email = trim($_POST['email'])??'';
        $role = trim($_POST['role'])??'member';
        
            $phone = trim($_POST['phone_number'])??'';
            $password = trim($_POST['password'])??'';
            $confirm_password = trim($_POST['confirm_password'])??'';
             $is_active = trim($_POST['is_active'])??true;


             $fields = [ 'name'   => trim($_POST['full_name']),
                            ];

                $pattern = '/^[A-Za-z]{2,}(?: [A-Za-z]{2,})*$/';

                foreach ($fields as $names => $value) {
                    if (!preg_match($pattern, $value)) {
                        echo json_encode([
                            'status'  => 'error',
                            'message' => "$names must contain only letters with one space between words (min 2 letters per word)."
                        ]);
                        exit;
                    }
                }

            $new_profile_image = $_FILES['profile_picture'] ?? null;
            $old_profile_image = $_POST['old_profile_image'] ?? null;
           if(!empty($new_profile_image) && $new_profile_image!==null&&$old_profile_image) {
            $profile_image = $new_profile_image;

           }else if(!$new_profile_image && $new_profile_image==null&&$old_profile_image) {
             $profile_image = $old_profile_image;
           } else {
            echo json_encode(['status' => 'error', 'message' => 'Please fill profile image.']);
                exit;
           }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                   echo json_encode([
                  'status' => 'error',
                    'message' => 'Please enter a valid email address.'
                            ]);
    exit;
}

            if ($password !== $confirm_password) {
                echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
                exit;
            }

      if (empty($name) || empty($email) || empty($user_id) || empty($phone)) {
            echo json_encode(['status' => 'error', 'message' => 'Username, email, and password are required.']);
            exit;
        }
      
        $usermodel = new User();
       
    $usermodel ->startTransaction();
        if( $profile_image){
             $profile_image_name = uploadImage(
                $profile_image,
                BASE_PATH . '/assets/uploads/profile/', 
                500000 );
               
        }
       

        $result = $usermodel->updateUser($user_id,$name,$password, $role, $email,$phone,$profile_image_name??null,$is_active);
     
        
        if ($result) {
                $usermodel->commit();
            echo json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update user. Username or email may already exist.']);
        }
    } catch (Exception $e) {
          $usermodel->rollback();
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
}

if ($_POST['action'] === 'delete_user') {
    try {
        $user_id = trim($_POST['user_id']) ?? '';

        if (empty($user_id)) {
            echo json_encode(['status' => 'error', 'message' => 'User ID is required.']);
            exit;
        }

        $userModel = new User();
        $userModel->startTransaction();
        
        $borrowingModel = new Borrowing();

        $borrowingResult = $borrowingModel->getBorrowDetails($user_id);
  if($borrowingResult){
     echo json_encode(['status' => 'error', 'message' => 'this user cannot be deleted because it has borrow history.']);
     exit;
  } 
        $user = $userModel->getById($user_id);

        
                 $target_dir = BASE_PATH . '/assets/uploads/profile/';
                if (!empty($user['profile_image']) && file_exists($target_dir . $user['profile_image'])) {
                    unlink($target_dir . $user['profile_image']);
                }
        $result = $userModel->deleteRec($user_id);
     
            
       

        


        if ($result) {
            $userModel->commit();
            echo json_encode(['status' => 'success', 'message' => 'User deleted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete user.']);
        }
    } catch (Exception $e) {
        $userModel->rollback();
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
}

 if($_POST['action']==='get_user_details'){
        try{
            
            $user_id = $_POST['user_id']??'';

            if (! $user_id){
                echo json_encode(['status' => 'error', 'message' => 'User ID is required.']);
                exit;
            }
            $userModel = new User();
            $result = $userModel->getById($user_id);
            if ($result) {
                  echo json_encode(['status' => 'success', 'data' => $result]);
            }
            else {
                 echo json_encode(['status' => 'error', 'message' => 'USER NOT FOUND']);

            }
        }
        catch (Exception $e){
           echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
        }

    }
//action end
   
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}


?>