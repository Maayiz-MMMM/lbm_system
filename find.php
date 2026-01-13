<?php

include __DIR__ . '/config.php';
include __DIR__ . '/helpers/authmanager.php';

$auth = new AuthManager();

$auth->checkLogin();
$auth->redirectByRole();



    // header('location: '.dirname($_SERVER['PHP_SELF']).'/view/auth/login.php');



