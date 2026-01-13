<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../helpers/AppManager.php';
require_once __DIR__ . '/../models/user.php';






try {
    $pm = AppManager::getPM();
    $sm = AppManager::getSM();

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']) ? true : false;




    if (empty($email) || empty($password)) {
        $sm->setAttribute("error", 'Please fill all required fields!');
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../login.php'));
        exit;
    }


    $param = array(':email' => $email);

    $user = $pm->run("SELECT * FROM members WHERE email = :email", $param, true);
        if ($user['is_active'] === 0){
             $sm->setAttribute("ban", $user['name'].' has been suspended!');
             $sm->setAttribute("error", $user['name'].' has been suspended!');
              header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '/logout.php'));
        exit;
             exit;
        }

    if ($user != null) {
        $correct = password_verify($password, $user['password']);


        if ($correct) {
            $sm->setAttribute("userId", $user['id']);
            $sm->setAttribute("role", $user['role']);
            $sm->setAttribute("name", $user['name']);
            $sm->setAttribute("email", $user['email']);
            $sm->setAttribute('logged_in', true);


            if ($remember) {
                $cookie_time = time() + (30 * 24 * 60 * 60);
                setcookie('remember_email', $email, $cookie_time, '/', '', false, true);
            } else {
                if (isset($_COOKIE['remember_email'])) {
                    setcookie('remember_email', '', time() - 3600, '/', '', false, true);
                }
            }

            header('Location: ../find.php');
            exit;
        } else {
            $sm->setAttribute("error", 'Invalid email or password!');
        }
    } else {
        $sm->setAttribute("error", 'Invalid email or password!');
    }

    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../login.php'));
    exit;
} catch (Exception $e) {
    $sm->setAttribute("error", 'An internal error occurred. Please try again later.');

    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? '../login.php'));
    exit;
}
