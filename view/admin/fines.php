<?php require_once('layouts/header.php');
require_once __DIR__ . '/../../models/book.php';
require_once __DIR__ . '/../../models/user.php';
require_once __DIR__ . '/../../models/borrowing.php';
require_once __DIR__ . '/../../models/fine.php';



$booksModel = new Book();
$books = $booksModel->getAll();

$usermodel = new User();
$users = $usermodel->getAll();

$borrowingModel = new Borrowing();
$borrowed = $borrowingModel->getAllBorrowings();

$fineModel = new Fine();
$fines = $fineModel->getAllFines();

?>


<div class="page-heading">
    <!-- card body start  -->
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="#">dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fines</li>
            </ol>
        </nav>

    </div>
    <!-- Create User button start -->
    <div class="row">
        <div class="col-12 d-flex justify-content-center mb-3">

            <h4 class="text-center">Fine Details</h4>
        </div>
    </div>

    <!-- Create User button end -->
    <!-- card body end -->


    <div class="card">
        <div class="card-header">
            <h4 class="card-title">borrowing</h4>
        </div>


        <div class="card-content">

            <!-- table start -->
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>member</th>
                            <th>books ISBN</th>
                            <th>qty</th>
                            <th>status</th>
                            <th>Amount</th>
                            <th>paid_at</th>
                            <th>Action</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fines as $fine): ?>
                            <tr>
                                <td class="fine_member"><?= htmlspecialchars($fine['member_name'] ?? '') ?></td>
                                <td class="fine_isbn"><?= htmlspecialchars($fine['book_isbn'] ?? '') ?></td>

                                <td><?= htmlspecialchars($fine['qty'] ?? '') ?></td>
                                <td>

                                    <span class="badge status-badge  <?= $fine['fine_status'] == 'pending' ? 'bg-danger' : 'bg-success' ?>"> <?= htmlspecialchars($fine['fine_status'] ?? '') ?></span>
                                </td>


                                <td>

                                    <span class="badge fine_amount status-badge <?= $fine['fine_status'] === 'pending' ? 'bg-danger' : 'bg-success' ?> ">LKR <?= number_format($fine['fine_amount']) ?></span>

                                </td>
                                <td><?= htmlspecialchars($fine['paid_at'] ?? 'Not Paid') ?></td>


                                <td><a>


                                        <button class="btn btn-sm pay_amount action-btn <?= $fine['fine_status'] == 'pending' ? 'btn-primary' : 'btn-success' ?>" data-borrow-id='<?= $fine['borrow_id'] ?>' data-fine-id='<?= $fine['fine_id'] ?>' <?= $fine['fine_status'] == 'pending' ? '' : 'disabled' ?>>
                                            <?= $fine['fine_status'] == 'pending' ? 'Pay amount' : 'paid' ?> </button>


                                    </a></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <!-- table end -->
        </div>

    </div>








    <!-- Pay fine Modal -->


    <div class="modal fade text-left pay_amount_modal scrollShow" id="inlineForm" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Fines Pay </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>

                <form action=" <?= url('services/fines/fine_ajax.php') ?>" id="fine_amount_form" enctype="multipart/form-data">
                    <div class="modal-body scrollShow-body">
                        <input type="hidden" class="pay_borrow_id" name="pay_borrows_id" value="">
                        <input type="hidden" class="pay_fine_id" name="pay_fine_id" value="">

                        <label>Name: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Name" name="member_name" class="form-control member_name" disabled>
                        </div>

                        <label>Book ISBN: </label>
                        <div class="form-group">
                            <input type="text" placeholder="Book ISBN" name="isbn_number" class="form-control book_isbn" disabled>
                        </div>

                        <!-- pay start -->
                        <label>Pay : </label>
                        <div class="input-group mb-3">
                            <div class="input-group-text">

                                <input class="form-check-input checked_check" type="checkbox" value="" aria-label="Checkbox for following text input">
                            </div>
                            <input type="text" class="form-control fine_amount" name="payment_amount" aria-label="Text input with checkbox" value="" disabled>
                        </div>
                        <!-- pay end  -->
                    </div>
                    <div class="modal-footer">
    
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary payment_submit_btn fine_submit_btn" id="edit_borrowing_btn" disabled>Pay</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Pay fine Modal END -->


    <?php require_once('layouts/footer.php'); ?>



    <script src="<?= asset('assets/form_ajax/fine.js') ?>?v=<?= filemtime(BASE_PATH.'/assets/form_ajax/fine.js') ?>"></script>