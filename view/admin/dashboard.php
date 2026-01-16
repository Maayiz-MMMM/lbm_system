<?php require_once('layouts/header.php') ?>
<?php $page = 'dashboard'; ?>


<?php $membersModel = new User();
$member = $membersModel->getMemberById($_SESSION['userId']);

?>

<div class="page-heading">
    <h3>Welcome <?= $loginnerName ?> </h3>
</div>

<div class="card">
    <div class="card-body py-4 px-5">

        <div class="d-flex align-items-center">
            <div class="avatar avatar-xl">
                <?php if (!$member['profile_image']): ?>
                    <img src="<?= asset('assets/uploads/profile/default.jpg') ?>" alt="" srcset="">
                <?php else: ?>
                    <img src="<?= asset('assets/uploads/profile/' . $member['profile_image']) ?>" alt="" srcset="">
                <?php endif ?>
            </div>
            <div class="ms-3 name">
                <h5 class="font-bold"><?= $loginnerName ?></h5>
                <h6 class="text-muted mb-0">@<?= $loginnerName ?></h6>

            </div>
         
        </div>
    </div>
</div>

<section class="list-group-navigation">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">

                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-lg-3 col-sm-12 col-md-4">
                                <div class="list-group" role="tablist">
                                    <a class="list-group-item list-group-item-action active" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-selected="true">Profile</a>
                                    <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-selected="false">Picture</a>

                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-sm-12 col-md-8 mt-1">
                                <div class="tab-content text-justify" id="nav-tabContent">
                                    <div class="tab-pane show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title"><?= $loginnerName ?></h4>

                                            </div>
                                            <div class="card-content">
                                                <div class="card-body">
                                                    <form class="form form-horizontal">
                                                        <div class="form-body">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label>Full Name</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="form-group has-icon-left">
                                                                        <div class="position-relative">
                                                                            <input type="text" class="form-control" placeholder="Name" value="<?= $member['name'] ?>" disabled>
                                                                            <div class="form-control-icon">
                                                                                <i class="bi bi-person"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label>Email</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="form-group has-icon-left">
                                                                        <div class="position-relative">
                                                                            <input type="email" class="form-control" placeholder="Email" value="<?= $member['email'] ?>" disabled>
                                                                            <div class="form-control-icon">
                                                                                <i class="bi bi-envelope"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label>Mobile</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="form-group has-icon-left">
                                                                        <div class="position-relative">
                                                                            <input type="number" class="form-control" placeholder="Mobile" value="<?= $member['phone'] ?>" disabled>
                                                                            <div class="form-control-icon">
                                                                                <i class="bi bi-phone"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label>Password</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="form-group has-icon-left">
                                                                        <div class="position-relative">
                                                                            <input type="password" class="form-control" placeholder="Password" value="<?= $member['password'] ?>" disabled>
                                                                            <div class="form-control-icon">
                                                                                <i class="bi bi-lock"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Role</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="form-group has-icon-left">
                                                                        <div class="position-relative">
                                                                            <input type="text" class="form-control" placeholder="Role" value="<?= $member['role'] ?>" disabled>
                                                                            <div class="form-control-icon">
                                                                                <i class="bi bi-person-badge"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <label>Created</label>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <div class="form-group has-icon-left">
                                                                        <div class="position-relative">
                                                                            <input type="text" class="form-control" placeholder="Created" id="first-name-icon" value="<?= $member['created_at'] ?>" disabled>
                                                                            <div class="form-control-icon">
                                                                                <i class="bi bi-calendar-plus"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="card">
                                                <div class="card-content">
                                                    <?php if (!$member['profile_image']): ?>
                                                        <img class="img-fluid w-100" src="<?= asset('assets/uploads/profile/default.jpg') ?>" alt="Card image cap">
                                                </div>
                                            <?php else: ?>
                                                <img class="img-fluid w-100" src="<?= asset('assets/uploads/profile/' . $member['profile_image']) ?>" alt="Card image cap">
                                            </div>
                                        <?php endif ?>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once('layouts/footer.php'); ?>