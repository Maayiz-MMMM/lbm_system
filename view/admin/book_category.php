<?php require_once('layouts/header.php');
require_once __DIR__ . '/../../models/category.php';


$categoryModel = new Category();
$category = $categoryModel->getAllCategory();

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
                data-bs-target="#add_category_modal">
                Add New Category
            </button>
        </div>
    </div>

    <!-- Create User button end -->
    <!-- card body end -->


    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Book Category</h4>
        </div>


        <div class="card-content">


            <!-- table start -->
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Book Status</th>
                            <th>Action</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($category  as $cat): ?>
                            <tr>
                                <td><?= htmlspecialchars($cat['name'] ?? '') ?></td>
                                <td>
                                    <?= $cat['is_active'] == 1
                                        ? '<span class="badge status-badge bg-success">Active</span>'
                                        : '<span class="badge status-badge bg-danger">In Active</span>'
                                    ?>
                                </td>

                                <td>
                                    <div class="d-flex justify-content-center gap-2 flex-nowrap">
                                        <button
                                            class="btn btn-primary btn-sm action-btn edit_category_btn"
                                            data-id="<?= $cat['id'] ?>">
                                            Edit
                                        </button>

                                        <button
                                            class="btn btn-danger btn-sm action-btn delete_category_btn"
                                            data-id="<?= $cat['id'] ?>">
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
    <div class="modal fade" id="add_category_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Create Book Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="create_category_form" action="<?= url('services/books/category_ajax.php') ?>" novalidate>
                <div class="modal-body">

                    <label>Category Name</label>
                    <input type="text"
                        name="name"
                        class="form-control"
                        placeholder="Category name"
                        required>

                    <!-- <div class="mt-3">
                        <label>Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div> -->

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="create_category_btn">Create</button>
                </div>
            </form>

        </div>
    </div>
</div>


    <!-- Create User Modal end -->


    <?php require_once('layouts/footer.php'); ?>

    <script>
        const category_AJAX_URL = "<?= url('services/books/category_ajax.php') ?>";
    </script>
    <script src="<?= asset('assets/form_ajax/categories.js') ?>?v=<?= filemtime(BASE_PATH . '/assets/form_ajax/categories.js') ?>"></script>