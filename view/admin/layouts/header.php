<?php require_once __DIR__ . '/../../../config.php';
require_once(__DIR__ . '/../../../helpers/AuthManager.php');
require_once(__DIR__ . '/../../../helpers/AppManager.php');
require_once(__DIR__ . '/../../../models/user.php');


$auth = new AuthManager();
$sm = AppManager::getSM();
$loginnerName = $sm->getAttribute("name");
$loginnerEmail = $sm->getAttribute("email");

$auth->checkLogin();
$auth->checkBan();
$auth->allow(['Admin']);

$currentUrl =  $_SERVER['SCRIPT_NAME'];

$currentFilename = basename($currentUrl);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Puttalam Library</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('assets/themes/mazer-theme/assets/css/bootstrap.css') ?>">

    <link rel="stylesheet" href="<?= asset('assets/themes/mazer-theme/assets/vendors/iconly/bold.css') ?>">

    <link rel="stylesheet" href="<?= asset('assets/themes/mazer-theme/assets/vendors/perfect-scrollbar/perfect-scrollbar.css ') ?>">
    <link rel="stylesheet" href="<?= asset('assets/themes/mazer-theme/assets/vendors/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= asset('assets/themes/mazer-theme/assets/css/app.css ') ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="<?= asset('assets/css/calender.css') ?>" rel="stylesheet">
    <link rel="icon" href="<?= asset('assets/images/Puttalam-Smart-Library.png')  ?>">
    <link href="<?= asset('assets/css/tables.css') ?>" rel="stylesheet">






</head>

<body>
    <div id="app">
        <!-- sidebar start  -->
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <!-- home navigate start  -->
                        <div class="logo">
                            <a href="<?= url('index.php') ?>"> <button class="btn btn-light d-flex align-items-center gap-2">
                                    <svg class="icon-back" viewBox="0 0 448 512">
                                        <path fill="currentColor"
                                            d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z" />
                                    </svg>
                                    Home
                                </button></a>
                        </div>
                         <!-- home navigate end  -->
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>
                        <li class="sidebar-item  <?= $currentFilename == 'dashboard.php' ? 'active' : '' ?>">
                            <a href="dashboard.php" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item  <?= $currentFilename == 'users.php' ? 'active' : '' ?>">
                            <a href="users.php" class='sidebar-link'>
                                <i class="bi fa-solid fa-user"></i>
                                <span>Users</span>
                            </a>
                        </li>
                        <li class="sidebar-item  <?= $currentFilename == 'books.php' ? 'active' : '' ?>">
                            <a href="books.php" class='sidebar-link'>
                                <i class="bi fa-solid fa-book"></i>
                                <span>Books</span>
                            </a>
                        </li>
                        <li class="sidebar-item  <?= $currentFilename == 'borrowing.php' ? 'active' : '' ?>">
                            <a href="borrowing.php" class='sidebar-link'>
                                <i class="bi fa-solid fa-book-open-reader"></i>
                                <span>Borrowing</span>
                            </a>
                        </li>
                        <li class="sidebar-item  <?= $currentFilename == 'fines.php' ? 'active' : '' ?>">
                            <a href="fines.php" class='sidebar-link'>
                                <i class="bi fa-solid fa-money-bill-wave"></i>
                                <span>Fine</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <button class=" sidebar-toggler btn x"><i data-feather="x"></i></button>
                </div>
            </div>
            <!-- sidebar end  -->
            <div id="main">
                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                </header>