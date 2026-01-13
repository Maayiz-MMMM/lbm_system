<?php require_once('layouts/header.php');
require_once __DIR__ . '/../../models/book.php';
require_once __DIR__ . '/../../models/user.php';
require_once __DIR__ . '/../../models/borrowing.php';


$booksModel = new Book();
$books = $booksModel->getAll();

$usermodel = new User();
$users = $usermodel->getAll();

$borrowingModel = new Borrowing();
$borrowed = $borrowingModel->getAllBorrowings();

?>


<div class="page-heading">
    <!-- card body start  -->
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="#">dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">borrowings</li>
            </ol>
        </nav>

    </div>
    <!-- Create User button start -->
    <div class="row">
        <div class="col-12 d-flex justify-content-end mb-3">
            <button type="button"
                class="btn btn-outline-primary"
                data-bs-toggle="modal"
                data-bs-target="#add_borrowing_modal">
                Add New borrwing
            </button>
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
                            <th>Member</th>
                            <th>Books ISBN</th>
                            <th>Issue date</th>
                            <th>Last date</th>
                            <th>Return date</th>
                            <th>Qty</th>
                            <th>Fine</th>
                            <th>Fine status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($borrowed as $borrowi): ?>
                            <tr>

                                <td>
                                    <?= htmlspecialchars($borrowi['member_name'] ?? '') ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($borrowi['isbn'] ?? '') ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($borrowi['issue_date'] ?? '') ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($borrowi['last_date'] ?? '') ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($borrowi['return_date'] ?? 'Not returned') ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($borrowi['qty'] ?? '') ?>
                                </td>


                                <td>
                                    <span class="badge status-badge
        <?= $borrowi['fine_amount'] > 0 ? 'bg-danger' : 'bg-primary' ?>">
                                        <?= $borrowi['fine_amount'] > 0
                                            ? 'LKR ' . number_format($borrowi['fine_amount'])
                                            : 'Nothing' ?>
                                    </span>
                                </td>


                                <td class="text-center align-middle">
                                    <span class="badge status-badge
        <?= $borrowi['fine_status'] === 'paid' ? 'bg-success' : ($borrowi['fine_status'] === 'pending' ? 'bg-danger' : 'bg-primary') ?>">
                                        <?= ucfirst($borrowi['fine_status'] ?? 'Nothing') ?>
                                    </span>
                                </td>


                                <td class="text-center align-middle">
                                    <?php if ($borrowi['status'] === 'borrowed'): ?>
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <button class="btn btn-primary btn-sm action-btn edit_borrowing"
                                                data-id="<?= $borrowi['borrow_id'] ?>">
                                                Edit
                                            </button>

                                            <button class="btn btn-danger btn-sm action-btn delete_borrowing"
                                                data-id="<?= $borrowi['borrow_id'] ?>">
                                                Delete
                                            </button>

                                            <button class="btn btn-warning btn-sm action-btn return_date_submit"
                                                data-id="<?= $borrowi['borrow_id'] ?>">
                                                Return
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <button class="btn btn-success btn-sm action-btn" disabled>
                                            Returned
                                        </button>
                                    <?php endif; ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- table end -->
        </div>

    </div>




    <!-- Create borrowing Modal -->
    <div class="modal add_borrowing_modal fade text-left scrollShow" id="add_borrowing_modal" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Create Borrowing</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>

                <form id="create_borrowing_form" action="<?= url('services/borrowing/borrowing_ajax.php') ?>" enctype="multipart/form-data" novalidate>
                    <div class="modal-body scrollShow-body">

                        <div class="form-group">
                            <label>Select Member:</label>
                            <select name="member" class="form-control" required>
                                <option value="" selected disabled>-- Select Member --</option>

                                <?php foreach ($users as $user): ?>
                                    <?php  if ($user['is_active']===1): ?>
                                    <?php  if ($user['role']==='member'): ?>

                                    <option value="<?= $user['id'] ?>">
                                        <?= htmlspecialchars($user['name']) ?>
                                    </option>
                                    <?php endif  ?>
                                    <?php endif  ?>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">member select is required!</div>
                        </div>

                        <div class="form-group">
                            <label>book :</label>
                            <select name="book" class="form-control" required>
                                <option value="" selected disabled>-- Select book --</option>

                                <?php foreach ($books as $book): ?>
                                     <?php  if ($book['is_active']===1): ?>
                                    <?php if ($book['available_qty'] > 0): ?>
                                        <option value="<?= $book['id'] ?>">
                                            <?= htmlspecialchars("Title: " . $book['title']) ?>
                                            <?= htmlspecialchars("Author: " . $book['author']) ?>
                                        </option>
                                          <?php endif  ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">book select is required!</div>
                        </div>

                        <div class="form-group">
                            <label>issue date</label>
                            <div class="date-picker">
                                <input
                                    type="text"
                                    name="issue_date"
                                    class="form-control date-input"
                                    placeholder="Select issue date"
                                    readonly>
                                <div class="calendar"></div>
                            </div>
                            <div class="invalid-feedback">issue date is required!</div>
                        </div>

                        <label>Status:</label>
                        <div class="form-group">
                            <select name="status" class="form-control" required>
                                <option value="" selected disabled>-- Select status --</option>
                                <option value="borrowed">borrowed</option>
                            </select>
                            <div class="invalid-feedback">Select status is required!</div>
                        </div>

                        <label>qty: </label>
                        <div class="form-group">
                            <input type="number" name="qty" min="0" placeholder="Quantity" class="form-control" required>
                            <div class="invalid-feedback">qty is required!</div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="create_borrowing_btn">Create</button>


                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Create borrowing Modal-->



    <!-- Create return Modal -->
    <div class="modal add_return_date_modal fade text-left scrollShow" id="returnDateModal" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Add Return Date </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="create_return_date_form" action="<?= url('services/borrowing/borrowing_ajax.php') ?>" enctype="multipart/form-data" novalidate >
                    <div class="modal-body scrollShow-body">

                        <div class="form-group">
                            <label>retur Date</label>
                            <input
                                type="date"
                                name="return_date"
                                class="form-control"
                                required
                                min="<?= date('Y-m-d') ?>">
                            <div class="invalid-feedback">return date is required!</div>
                        </div>

                        <input type="hidden" name="borrows_id" id="borrow_id" value="">
                        <label>Status:</label>
                        <div class="form-group">
                            <select name="status" class="form-control" required>
                                <option value="" selected disabled>-- Select status --</option>
                                <option value="returned">returned</option>
                            </select>
                            <div class="invalid-feedback">select status is required!</div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="create_return_date_btn">Create</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Create return Modal-->

<!-- edit_borrowing_modal Modal -->
    <div class="modal edit_borrowing_modal fade text-left scrollShow" id="inlineForm" tabindex="-1" aria-labelledby="myModalLabel33" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit borrowing</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>

                <form id="edit_borrowing_form" action="<?= url('services/borrowing/borrowing_ajax.php') ?>" enctype="multipart/form-data" novalidate>
                    <div class="modal-body scrollShow-body">

                        <div class="form-group">
                            <label>Select Member:</label>
                            <input type="hidden" name="borrow_id" id="borrow_id_edit">
                            <select name="member_id" id="edit_member" class="form-control" required>
                                <option value="" disabled>-- Select Member --</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id'] ?>">
                                        <?= htmlspecialchars($user['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">member select is required!</div>
                        </div>

                        <div class="form-group">
                            <label>book :</label>
                            <select name="book_id" id="edit_book" class="form-control" required>
                                <option value="" disabled>-- Select book --</option>
                                <?php foreach ($books as $book): ?>
                                    <option value="<?= $book['id'] ?>">
                                        <?= htmlspecialchars($book['title']) ?> - <?= htmlspecialchars($book['author']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">book select is required!</div>
                        </div>

                        <div class="form-group">
                            <label>issue date</label>
                            <div class="date-picker">
                                <input id="edit_issue_date" type="text" class="form-control date-input" name="issue_date" readonly>
                                <div class="invalid-feedback">issue date is required!</div>
                                <div class="calendar issue_date"></div>
                            </div>
                        </div>



                        <label>Status:</label>
                        <div class="form-group">
                            <select name="status" id="status_edit" class="form-control">
                                <option value="borrowed">borrowed</option>
                            </select>
                            <div class="invalid-feedback">borrow status is required!</div>
                        </div>

                        <label>qty: </label>
                        <div class="form-group">
                            <input type="number" name="qty" id="edit_qty" placeholder="Quantity" class="form-control" required>
                            <div class="invalid-feedback">qty is required!</div>
                        </div>

                    </div>
                    <div class="modal-footer">
                         <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="edit_borrowing_btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- edit_borrowing_modal Modal -->

    <?php require_once('layouts/footer.php'); ?>

    <script src="<?= asset('assets/form_ajax/borrowings.js') ?>?v=<?= filemtime(BASE_PATH.'/assets/form_ajax/borrowings.js') ?>"></script>