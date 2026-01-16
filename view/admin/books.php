<?php require_once('layouts/header.php');
require_once __DIR__ . '/../../models/book.php';
require_once __DIR__ . '/../../models/category.php';


$booksModel = new Book();
$books = $booksModel->getAllBook();

$categoryModel = new Book();
$categories = $categoryModel->getCategories();

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
    <!-- Create User button start -->
    <div class="row">
        <div class="col-12 d-flex justify-content-end mb-3">
            <button type="button"
                class="btn btn-outline-primary"
                data-bs-toggle="modal"
                data-bs-target="#add_book_modal">
                Add New Book
            </button>
        </div>
    </div>

    <!-- Create User button end -->
    <!-- card body end -->


    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Users</h4>
        </div>


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
                            <th>cover_image</th>
                            <th>available_qty</th>
                            <th>total_qty</th>
                            <th>Book Status</th>
                            <th>Action</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td><?= htmlspecialchars($book['isbn'] ?? '') ?></td>
                                <td><?= htmlspecialchars($book['title']) ?></td>
                                <td><?= htmlspecialchars($book['author']) ?></td>
                                <td><?= htmlspecialchars($book['category']) ?></td>
                                <?php if (isset($book['cover_image']) && !empty($book['cover_image'])) : ?>
                                    <td> <img src="<?= asset('assets/uploads/books/' . $book['cover_image']) ?>" alt="user-avatar" class="table-book-img" width="80" id="uploadedAvatar">
                                  
                                     <?php else :?>
                                        <img src="<?= asset('assets/uploads/books/' . 'book_default.jpg') ?>"  class="table-book-img" width="80" id="uploadedAvatar">
                                </td>
                                <?php endif; ?>
                                <td><?= htmlspecialchars($book['available_qty']) ?></td>
                                <td><?= htmlspecialchars($book['total_qty']) ?></td>
                                <td>
                                   <?= $book['is_active'] == 1
                                       ? '<span class="badge status-badge bg-success">Active</span>'
                                       : '<span class="badge status-badge bg-danger">In Active</span>'
                                   ?>
                               </td>

                                <td>
    <div class="d-flex justify-content-center gap-2 flex-nowrap">
        <button
            class="btn btn-primary btn-sm action-btn edit_book_btn"
            data-id="<?= $book['id'] ?>">
            Edit
        </button>

        <button
            class="btn btn-danger btn-sm action-btn delete_book_btn"
            data-id="<?= $book['id'] ?>">
            Delete
        </button>
    </div>
</td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <!-- table end -->
        </div>

    </div>




    <!-- Create User Modal -->
    <div class="modal add_book_modal fade text-left scrollShow" id="add_book_modal" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Create Book </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>

                <form id="create_book_form" action="<?= url('services/books/books_ajax.php') ?>" enctype="multipart/form-data">
                    <div class="modal-body scrollShow-body">
                        <label>Title: </label>
                        <div class="form-group">
                            <input type="text" name="title"
                                class="form-control"
                                placeholder="Title"
                                required
                                pattern="[A-Za-z ]+">
                            <div class="invalid-feedback">Title required</div>
                        </div>

                        <label>Author:</label>
                        <div class="form-group">
                            <input type="text" name="author"
                                class="form-control"
                                placeholder="Author"
                                required
                                pattern="[A-Za-z ]+">
                            <div class="invalid-feedback">Author required</div>

                        </div>
                       <label>Category:</label>
<div class="form-group">
    <select name="category_id" class="form-control" required>
        <option value="">-- Select Category --</option>

        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>">
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <div class="invalid-feedback">Category is required</div>
</div>


                        <label>Total qty: </label>
                        <div class="form-group">
                            <input type="number"
                                name="total_qty"
                                class="form-control"
                                placeholder="Total Quantity"
                                required
                                min="1">
                            <div class="invalid-feedback">Enter a valid quantity</div>
                        </div>
                        <input type="hidden" name="isbn" value="<?php echo generateISBN13(); ?>">

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Default file input
                                example</label>
                            <input class="form-control"
                                name="cover_image"
                                type="file"
                                required
                                accept="image/*">
                            <div class="invalid-feedback">Cover image is required</div>
                        </div>

                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="create_book_btn">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


   <!-- Create User Modal end -->


    <?php require_once('layouts/footer.php'); ?>




    <?php function generateISBN13()
    {
        $isbn = '978';

        for ($i = 0; $i < 9; $i++) {
            $isbn .= rand(0, 9);
        }

        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $digit = (int)$isbn[$i];
            $sum += ($i % 2 === 0) ? $digit : $digit * 3;
        }

        $checksum = (10 - ($sum % 10)) % 10;

        return $isbn . $checksum;
    } ?>

    <script>
        const BOOK_AJAX_URL = "<?= url('services/books/books_ajax.php') ?>";
        const upload_URL = "<?= asset('assets/uploads/books/') ?>";
    </script>
    <script src="<?= asset('assets/form_ajax/books.js') ?>?v=<?= filemtime(BASE_PATH.'/assets/form_ajax/books.js') ?>"></script>