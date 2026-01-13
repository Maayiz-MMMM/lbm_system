<?php require_once('layouts/header.php');
require_once __DIR__ . '/../../models/user.php';

$usersModel = new User();
$users = $usersModel->getAll();

?>


<div class="page-heading">
    <!-- card body start  -->
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="#">dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Users</li>
            </ol>
        </nav>

    </div>
    <!-- Create User button start -->
    <div class="row">
        <div class="col-12 d-flex justify-content-end mb-3">
            <button type="button"
                class="btn btn-outline-primary"
                data-bs-toggle="modal"
               data-bs-target="#create_new_user">
                Create User
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
                            <th>Name</th>
                            <th>User Image</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Phone No</th>
                            <th>User Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['name']) ?></td>

                                <td>
                                    <img src="<?= asset('assets/uploads/profile/' . (!empty($user['profile_image']) ? $user['profile_image'] : 'default.jpg')) ?>" alt="user-avatar" class="table-book-img" width="80" id="uploadedAvatar">
                                </td>

                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['role']) ?></td>
                                <td><?= htmlspecialchars($user['phone']) ?></td>
                                 <td>
                                  <?= $user['is_active'] == 1
                                       ? '<span class="badge status-badge bg-success">Active</span>'
                                       : '<span class="badge status-badge bg-danger">In Active</span>'
                                   ?></td>

                                <td>
                                    <?php if ($loginnerEmail === htmlspecialchars($user['email'])): ?>

                                    <?php else: ?>
                                        <button type="button" class="btn btn-danger btn-sm delete_user_btn action-btn" data-id='<?= $user['id'] ?>'>Delete</button>
                                        <button type="button"
                                            class="btn btn-primary btn-sm edit_user_btn action-btn"
                                            data-id="<?= $user['id'] ?>"
                                            data-name="<?= htmlspecialchars($user['name']) ?>"
                                            data-email="<?= htmlspecialchars($user['email']) ?>"
                                            data-role="<?= htmlspecialchars($user['role']) ?>"
                                            data-phone="<?= htmlspecialchars($user['phone']) ?>"
                                            >
                                            
                                            Edit
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



    <!-- Create User Modal -->
    <div class="modal fade create_user_modal scrollShow" id="create_new_user" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Create User</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="create_user_form" action="<?= url('services/users/user_ajax.php') ?>">
                    <div class="modal-body scrollShow-body">

                        <label>Full Name:</label>
                        <div class="form-group">
                            <input type="text" name="full_name" placeholder="Full Name" class="form-control" required>
                            <div class="invalid-feedback">Full Name is required!</div>
                        </div>
                        <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="Email" class="form-control" value="" required>
                         </div>               
                        <label>Phone Number:</label>
                        <div class="form-group">
                            <input type="number" name="phone_number" min="1" placeholder="Phone Number" class="form-control" required>
                            <div class="invalid-feedback">Phone Number is required!</div>
                        </div>

                        <label>Password:</label>
                        <div class="form-group position-relative">
                            <input type="password" minlength="6" name="password" id="password"
                                placeholder="Password" class="form-control pe-5" required>

                            <span class="password-toggle position-absolute" style="top:50%; right:15px; cursor:pointer;" data-target="password">
                                <i class="fas fa-eye eye-show"></i> <!-- initially visible -->
                                <i class="fas fa-eye-slash eye-hide"></i> <!-- initially hidden -->
                            </span>
                            <div class="invalid-feedback">Password is required!</div>
                        </div>

                        <label>Confirm Password:</label>
                        <div class="form-group position-relative">
                            <input type="password" minlength="6" name="confirm_password" id="confirm_password"
                                placeholder="Confirm Password" class="form-control pe-5" required>

                            <span class="password-toggle position-absolute" style="top:50%; right:15px; cursor:pointer;" data-target="confirm_password">
                                <i class="fas fa-eye eye-show"></i>
                                <i class="fas fa-eye-slash eye-hide"></i>
                            </span>
                            <div class="invalid-feedback">Please confirm your password!</div>
                        </div>


                        <label>Role</label>
                        <div class="form-group">
                            <select name="role" class="form-control" required>
                                <option value="">-- Select Role --</option>
                                <option value="Admin">Admin</option>
                                <option value="member">Member</option>
                            </select>
                            <div class="invalid-feedback">Please select a role!</div>
                        </div>

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Profile Image</label>
                            <input class="form-control" name="profile_image" type="file" id="formFile" required>
                            <div class="invalid-feedback">Profile image is required!</div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="create_user_btn" data-bs-target="#inlineForm">Create</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- create models end-->

  


    <!-- Edit User Modal start-->

    <?php require_once('layouts/footer.php'); ?>

    <script>
        const user_AJAX_URL = "<?= url('services/users/user_ajax.php') ?>";
        const upload_URL = "<?= asset('assets/uploads/profile/') ?>";
    </script>
    <script src="<?= asset('assets/form_ajax/users.js') ?>?v=<?= filemtime(BASE_PATH . '/assets/form_ajax/users.js') ?>"></script>



    </body>

    </html>