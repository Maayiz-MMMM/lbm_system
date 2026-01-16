<?php require_once('layouts/header.php');
require_once __DIR__ . '/../../models/book.php';

$booksModel = new Book();
$books = $booksModel->getAllBook();

?>

<div class="page-heading">
    <!-- card body start  -->
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="#">dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Books</li>
            </ol>
        </nav>

    </div>
    <!-- Search bar start -->
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"></span>
        <input type="text" class="form-control" placeholder="Search books" aria-label="Search books" aria-describedby="button-addon2" id="search_books" data-url="<?= url('services/search_books/search_books.php') ?>" data-baseurl="<?= url('/') ?>">

        <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="bi bi-search"> Search </i></button>
    </div>

    <!-- Search bar end -->
    <!-- card body end -->


    <div class="card">
        <div class="card-content">

            <!-- table start -->
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>isbn number</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>category</th>
                            <th>cover image</th>
                            <th>available_qty</th>
                        </tr>
                    </thead>
                    <tbody id="all_books_table">
                        <?php foreach ($books as $book): ?>
                              <?php if($book['is_active']=== 1)  :?>
                            <tr>
                                <td><?= htmlspecialchars($book['isbn'] ?? '') ?></td>
                                <td><?= htmlspecialchars($book['title']?? '') ?></td>
                                <td><?= htmlspecialchars($book['author']?? '') ?></td>
                                <td><?= htmlspecialchars($book['category']?? '') ?></td>
                                <?php if (isset($book['cover_image']) && !empty($book['cover_image'])) : ?>
                                    <td><img src="<?= asset('assets/uploads/books/' . $book['cover_image']?? '') ?>" alt="user-avatar" class="table-book-img" width="80" id="uploadedAvatar"></td>
                                <?php endif; ?>
                                <td><?= htmlspecialchars($book['available_qty']?? '') ?></td>
                            </tr>
                              <?php endif  ?>
                        <?php endforeach; ?>

                    </tbody>

                    <tbody id="search_result"></tbody>
                </table>
            </div>

            <!-- table end  -->
        </div>

    </div>







    <?php require_once('layouts/footer.php');
    ?>

        <script src="<?= asset('assets/form_ajax/search_books.js')?>?v=<?= filemtime(BASE_PATH.'/assets/form_ajax/search_books.js') ?>"></script>
