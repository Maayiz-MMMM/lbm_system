<?php require_once __DIR__ . '/config.php';
require_once __DIR__ . '/models/book.php';

$bookModel = new Book();
$books = $bookModel->getAll();

$categories = $bookModel->getCategories();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Puttalam Smart Library</title>
    <link rel="icon" href="<?= asset('assets/images/Puttalam-Smart-Library.png')  ?>">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="assets/themes/st-theme/lib/animate/animate.min.css" />
    <link href="<?= asset('assets/themes/st-theme/lib/lightbox/css/lightbox.min.css') ?>" rel="stylesheet">
    <link href="assets/themes/st-theme/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <link href="<?= asset('assets/themes/st-theme/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?= asset('assets/themes/st-theme/css/style.css') ?>" rel="stylesheet">
    <link href="assets/css/index.css" rel="stylesheet">

</head>


<body>



    <!-- Topbar Start -->
    <div class="container-fluid topbar bg-light px-5 d-none d-lg-block">
        <div class="row gx-0 align-items-center">


            <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-flex flex-wrap">
                    <span class="text-muted small me-4">
                        <i class="fas fa-book text-primary me-2"></i>
                        City Public Library
                    </span>
                    <a href="tel:+94756481382" class="text-muted small me-4">
                        <i class="fas fa-phone-alt text-primary me-2"></i>
                        +94 75 648 1382
                    </a>
                    <a href="mailto:library@gmail.com" class="text-muted small me-0">
                        <i class="fas fa-envelope text-primary me-2"></i>
                        Maayiz@gmail.com
                    </a>
                </div>
            </div>


            <div class="col-lg-4 text-center text-lg-end">
                <div class="d-inline-flex align-items-center" style="height: 45px;">



                    <a href="<?= asset('view/auth/login.php') ?>" class="me-3 text-dark">
                        <small>
                            <i class="fa fa-sign-in-alt text-primary me-2"></i>
                            Login
                        </small>
                    </a>



                </div>
            </div>

        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar & Hero Start -->
    <div class="container-fluid position-relative p-0">
        <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
            <a href="" class="navbar-brand p-0">
                <h1 class="text-primary"><i class="bi bi-book"></i> </i> Puttalam Smart Library</h1>

            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="index.php" class="nav-item nav-link active">Home</a>
                    <a href="#all_books_table" class="nav-item nav-link">Books</a>
                    <a href="<?= asset('view/auth/login.php') ?>" class="nav-item nav-link">Login</a>
                    <a href="#footer_nav" class="nav-item nav-link">Contact Us</a>
                </div>
                <a href="#search_bar_nav" class="btn btn-primary rounded-pill py-2 px-4 my-3 my-lg-0 flex-shrink-0">
                    <i class="bi bi-search me-1"></i> Search Books
                </a>
            </div>
        </nav>

        <!-- Carousel Start -->
        <div class="header-carousel owl-carousel">
            <div class="header-carousel-item">
                <img src="assets/images/lib-backround-1.jpg" class="img-fluid w-100" alt="Image">
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row gy-0 gx-5">
                            <div class="col-lg-0 col-xl-5"></div>
                            <div class="col-xl-7 animated fadeInLeft">
                                <div class="text-sm-center text-md-end">
                                    <h4 class="text-primary text-uppercase fw-bold mb-4">Step Into a World of Knowledge</h4>
                                    <h1 class="display-4 text-uppercase text-white mb-4">Discover, Borrow & Enjoy Your Favorite Books</h1>
                                    <p class="mb-5 fs-5"> Browse our vast collection, check availability instantly, and manage your reading journey effortlessly. Your next adventure awaits in every page.
                                    </p>
                                    <div class="d-flex justify-content-center justify-content-md-end flex-shrink-0 mb-4">
                                        <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2" href="#all_books_table">
                                            <i class="fas fa-sign-in-alt me-2"></i> Start Reading Now
                                        </a>

                                        <a class="btn btn-primary rounded-pill py-3 px-4 px-md-5 ms-2" href="#all_books_table">
                                            <i class="fas fa-book me-2"></i> Explore the Library
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-carousel-item">
                <img src="assets/images/lib-backround-2.jpg" class="img-fluid w-100" alt="Image">
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row g-5">
                            <div class="col-12 animated fadeInUp">
                                <div class="text-center">
                                    <h4 class="text-primary text-uppercase fw-bold mb-4">Your Personal Library Dashboard</h4>
                                    <h1 class="display-4 text-uppercase text-white mb-4">Manage Your Books, Track Due Dates & Fines Easily</h1>
                                    <p class="mb-5 fs-5"> Keep track of all your borrowed books, view return history, and stay on top of fines—all from one convenient dashboard. Reading made simple.
                                    </p>
                                    <div class="d-flex justify-content-center flex-shrink-0 mb-4">
                                        <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2" href="<?= asset('view/auth/login.php') ?>">
                                            <i class="fas fa-user me-2"></i> Login to Your Account
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-carousel-item">
                <img src="assets/images/lib-backround-3.jpg" class="img-fluid w-100" alt="Image">
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row g-5">
                            <div class="col-12 animated fadeInUp">
                                <div class="text-center">
                                    <h4 class="text-primary text-uppercase fw-bold mb-4">Librarian & Admin Panel</h4>
                                    <h1 class="display-4 text-uppercase text-white mb-4"> Manage Books, Members & Borrowing</h1>
                                    <p class="mb-5 fs-5"> Librarians can add books, manage members, issue and return books, and calculate fines efficiently.
                                    </p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel End -->


    </div>
    <!-- Navbar & Hero End -->


    <!-- About Start -->
    <div class="container-fluid about py-5" id="library_rule_nav">
    <div class="container py-5">
        <div class="row g-5 align-items-center">

            <!-- Left Content -->
            <div class="col-xl-7 wow fadeInLeft" data-wow-delay="0.2s">
                <div>
                    <h4 class="text-primary">Welcome to Your Smart Library</h4>
                    <h1 class="display-5 mb-4">Your Gateway to Knowledge & Reading</h1>

                    <p class="mb-4">
                        Discover a smarter way to manage your library! Our Library Management System empowers 
                        members to find books instantly, borrow and return them seamlessly, and stay on top of due dates. 
                        Librarians can efficiently manage books, members, and transactions with just a few clicks. 
                        A modern, fast, and secure platform for everyone who loves reading.
                    </p>

                    <div class="row g-4">

                        <div class="col-md-6">
                            <div class="d-flex">
                                <div>
                                    <i class="fas fa-book fa-3x text-primary"></i>
                                </div>
                                <div class="ms-4">
                                    <h4>Smart Book Management</h4>
                                    <p>Add, update, and organize books effortlessly. Track stock and availability in real time.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex">
                                <div>
                                    <i class="fas fa-users fa-3x text-primary"></i>
                                </div>
                                <div class="ms-4">
                                    <h4>Easy Member Management</h4>
                                    <p>Keep track of all members, borrowing history, and upcoming return dates instantly.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex">
                                <div>
                                    <i class="fas fa-clock fa-3x text-primary"></i>
                                </div>
                                <div class="ms-4">
                                    <h4>Borrow & Return Instantly</h4>
                                    <p>Issue and return books with ease while calculating late fines automatically.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex">
                                <div>
                                    <i class="fas fa-lock fa-3x text-primary"></i>
                                </div>
                                <div class="ms-4">
                                    <h4>Secure & Reliable</h4>
                                    <p>Role-based access ensures secure login for members and administrators alike.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <a href="#books" class="btn btn-primary rounded-pill py-3 px-5">
                                Explore Books Now
                            </a>
                        </div>

                        <div class="col-sm-6">
                            <div class="d-flex">
                                <i class="fas fa-user-shield fa-2x text-primary me-4"></i>
                                <div>
                                    <h4>Librarian Support</h4>
                                    <p class="mb-0 fs-6">Full access to admin panel for smooth library management</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Right Image -->
            <div class="col-xl-5 wow fadeInRight" data-wow-delay="0.2s">
                <div class="bg-primary rounded position-relative overflow-hidden">
                    <img src="<?=  asset('assets/images/librarian-1.jpg') ?>" class="img-fluid rounded w-100" alt="Library Image">
                </div>
            </div>

        </div>
    </div>
</div>
    <!-- About End -->


    <!-- books details show Start -->
    <div class="container-fluid service pb-5" id="search_bar_nav">
        <div class="container pb-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;" ">
                    <h4 class=" text-primary">Library Catalog</h4>
                <h1 class="display-5 mb-4">Browse & Borrow Books Easily</h1>
                <p class="mb-0">Explore available books, check details, and manage borrowing through our library system
                </p>
            </div>

            <!-- book search bar start -->

            <!-- Search & Filter Bar -->
            <div class="row mb-4" >
                <div class="col-md-3" >
                    <select class="form-select" id="search_type">
                        <option value="title">Search by Title</option>
                        <option value="author">Search by Author</option>
                    </select>
                </div>

                <div class="col-md-5">
                    <input type="text"
                        id="search_books"
                        class="form-control"
                        placeholder="Type to search..."
                        data-url="<?= url('services/search_books/search_books.php') ?>">
                </div>

                <div class="col-md-4">
                    <select class="form-select" id="filter_category">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option>
                                <?= htmlspecialchars($cat['category']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- RESULTS -->
            <div class="row g-4" id="search_result" style="display:none;"></div>

            <div class="row g-4" id="all_books_table">
                <?php foreach ($books as $book): ?>
                      <?php if($book['is_active']===1):  ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="service-item book-card">
                            <div class="service-img book-img">
                                <?php if (!empty($book['cover_image'])): ?>
                                    <img src="<?= asset('assets/uploads/books/' . $book['cover_image']) ?>" alt="Book cover">
                                <?php else: ?>
                                    <img src="<?= asset('assets/images/b-cover-book-title.jpg') ?>" alt="Book cover">
                                <?php endif; ?>

                                <span class="book-status <?= $book['available_qty'] > 0 ? 'bg-success' : 'bg-danger' ?>">
                                    <?= $book['available_qty'] > 0 ? 'Available' : 'Out of Stock' ?>
                                </span>
                            </div>

                            <div class="rounded-bottom p-4 bg-white">
                                <h5 class="fw-bold"><?= htmlspecialchars($book['title']) ?></h5>
                                <p class="mb-1"><strong>ISBN:</strong> <?= htmlspecialchars($book['isbn']) ?></p>
                                <p class="mb-1"><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>
                                <p class="mb-1"><strong>Category:</strong> <?= htmlspecialchars($book['category']) ?></p>
                                <p class="mb-0"><strong>Qty:</strong> <?= htmlspecialchars($book['available_qty']) ?></p>
                            </div>
                        </div>
                    </div>
                      <?php endif  ?>
                <?php endforeach; ?>
            </div>




        </div>
    </div>
    </div>
    <!-- books detrails show End -->

   <!-- Features Start -->
<!-- <div class="container-fluid feature pb-5">
    <div class="container pb-5">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h4 class="text-primary">Library Features</h4>
            <h1 class="display-5 mb-4">All-in-One Smart Library System</h1>
            <p class="mb-0">Discover a powerful platform to manage books, members, borrowing, and returns—all in one place. Fast, secure, and easy to use!</p>
        </div>
        <div class="row g-4">

            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.2s">
                <div class="feature-item p-4 text-center">
                    <div class="feature-icon p-4 mb-4">
                        <i class="fas fa-book fa-4x text-primary"></i>
                    </div>
                    <h4>Smart Book Management</h4>
                    <p class="mb-4">Add, update, and organize your library’s books quickly with real-time availability tracking.</p>
                    <a class="btn btn-primary rounded-pill py-2 px-4" href="#books">Explore Books</a>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.4s">
                <div class="feature-item p-4 text-center">
                    <div class="feature-icon p-4 mb-4">
                        <i class="fas fa-users fa-4x text-primary"></i>
                    </div>
                    <h4>Member Management</h4>
                    <p class="mb-4">Track members, borrowing history, and fines easily. Keep your community organized and informed.</p>
                    <a class="btn btn-primary rounded-pill py-2 px-4" href="#members">View Members</a>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.6s">
                <div class="feature-item p-4 text-center">
                    <div class="feature-icon p-4 mb-4">
                        <i class="fas fa-exchange-alt fa-4x text-primary"></i>
                    </div>
                    <h4>Effortless Borrow & Return</h4>
                    <p class="mb-4">Issue and return books in seconds, with automatic updates for availability and late fines.</p>
                    <a class="btn btn-primary rounded-pill py-2 px-4" href="#borrow-return">Start Borrowing</a>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.8s">
                <div class="feature-item p-4 text-center">
                    <div class="feature-icon p-4 mb-4">
                        <i class="fas fa-user-shield fa-4x text-primary"></i>
                    </div>
                    <h4>Librarian Dashboard</h4>
                    <p class="mb-4">Full control for librarians to manage books, members, and system operations efficiently and securely.</p>
                    <a class="btn btn-primary rounded-pill py-2 px-4" href="#dashboard">Admin Panel</a>
                </div>
            </div>

        </div>
    </div>
</div> -->

    <!-- Features End -->




    <!-- Testimonial End -->

    <!-- Footer Start -->
    <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s" id="footer_nav">
        <div class="container py-5 border-start-0 border-end-0" style="border: 1px solid; border-color: rgb(255, 255, 255, 0.08);">
            <div class="row g-5">
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="footer-item">
                        <a href="index.html" class="p-0">
                            <h4 class="text-white"><i class="bi bi-book me-3"></i> Public Library</h4>

                        </a>
                        <p class="mb-4">Manage and explore books, members, and borrowing easily with our Library Management System.</p>


                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-2">
                    <div class="footer-item">
                        <h4 class="text-white mb-4">Quick Links</h4>
                        <a href="index.php"><i class="fas fa-angle-right me-2"></i> Home</a>
                        <a href="#footer_nav"><i class="fas fa-angle-right me-2"></i> About</a>
                        <a href="#all_books_table"><i class="fas fa-angle-right me-2"></i> Books</a>
                        <a href="<?= asset('view/auth/login.php') ?>"><i class="fas fa-angle-right me-2"></i> Members</a>
                        <a href="#footer_nav"><i class="fas fa-angle-right me-2"></i> Contact Us</a>

                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item">
                        <h4 class="text-white mb-4">Support</h4>
                        <a href="#library_rule_nav"><i class="fas fa-angle-right me-2"></i> Library Rules</a>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Membership Policy</a>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> FAQs</a>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Help Desk</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item">
                        <h4 class="text-white mb-4">Contact Info</h4>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt text-primary me-3"></i>
                            <p class="text-white mb-0">61 Library St, mannar road, puttalam</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-envelope text-primary me-3"></i>
                            <p class="text-white mb-0">Maayiz@publiclibrary.lk</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fa fa-phone-alt text-primary me-3"></i>
                            <p class="text-white mb-0">+94 76 548 1382</p>
                        </div>


                    </div>




                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Footer End -->




    <a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= asset('assets/themes/st-theme/lib/wow/wow.min.js') ?>?v=1.0"></script>
    <script src="<?= asset('assets/themes/st-theme/lib/easing/easing.min.js') ?>?v=1.0"></script>
    <script src="<?= asset('assets/themes/st-theme/lib/waypoints/waypoints.min.js') ?>?v=1.0"></script>
    <script src="<?= asset('assets/themes/st-theme/lib/counterup/counterup.min.js') ?>?v=1.0"></script>
    <script src="<?= asset('assets/themes/st-theme/lib/lightbox/js/lightbox.min.js') ?>?v=1.0"></script>
    <script src="<?= asset('assets/themes/st-theme/lib/owlcarousel/owl.carousel.min.js') ?>?v=1.0"></script>

    <!-- Template Javascript -->
    <script src="<?= asset('assets/themes/st-theme/js/main.js') ?>?v=1.0"></script>

    <script>
        const baseAssets = "<?= asset('assets/uploads/books/') ?>";
        const defaultCover = "<?= asset('assets/images/book_default.jpg') ?>";
    </script>

    <!-- AJAX and custom scripts -->
    <script src="<?= asset('assets/form_ajax/search_books_index.js') ?>?v=<?= filemtime(BASE_PATH.'/assets/form_ajax/search_books_index.js') ?>"></script>
    <script src="<?= asset('assets/themes/mazer-theme/assets/js/extensions/sweetalert2.js?v=1.0') ?>"></script>

</body>

</html>