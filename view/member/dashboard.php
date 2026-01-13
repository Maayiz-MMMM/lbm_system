<?php
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/../../models/user.php';
require_once __DIR__ . '/../../models/borrowing.php';


$auth = new AuthManager();
$auth->checkLogin('member');

$sm = AppManager::getSM();



$membersModel = new User();
$member = $membersModel->getMemberById($_SESSION['userId']);


$borrowingModel = new Borrowing();
$borrowing = $borrowingModel->getBorrowedStatusMmbr($_SESSION['userId']);

$totalFines = $borrowingModel->getTotalFines($_SESSION['userId']);
?>

<div class="page-heading">
    <h3>Welcome <?= $member['name'] ?> </h3>

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
                <h5 class="font-bold"><?= $member['name'] ?></h5>
                <h6 class="text-muted mb-0">@<?= $member['name'] ?></h6>

            </div>
            <div>
                <a href="<?= asset('services/logout.php') ?>" class="btn btn-primary rounded-pill">Logout</a>
            </div>
        </div>
    </div>
</div>
<!-- member profile section start -->
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
                                    <a class="list-group-item list-group-item-action" id="list-return-list" data-bs-toggle="list" href="#list-return" role="tab" aria-selected="false">Return pending</a>
                                    <a class="list-group-item list-group-item-action" id="list-fine-list" data-bs-toggle="list" href="#list-fine" role="tab" aria-selected="false">Total Fines</a>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 col-sm-12 col-md-8 mt-1">
                                <div class="tab-content text-justify" id="nav-tabContent">
                                    <div class="tab-pane show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title"><?= $member['name'] ?></h4>

                                            </div>
                                            <!-- member form details start -->
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
                                                                            <input type="text" class="form-control" placeholder="Name"  value="<?= $member['name'] ?>" disabled>
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
                                                                            <input type="text" class="form-control" placeholder="Role"  value="<?= $member['role'] ?>" disabled>
                                                                            <div class="form-control-icon">
                                                                                <i class="bi bi-people"></i> 
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
                                                                            <input type="text" class="form-control" placeholder="Created" value="<?= $member['created_at'] ?>" disabled>
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

                                            <!-- member form details end -->
                                        </div>
                                    </div>
                                        
                                        <!-- member picture start -->
                                    <div class="tab-pane" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="card">
                                                <div class="card-content">
                                                    <?php if (!$member['profile_image']): ?>
                                                        <img class="img-fluid w-100" src="<?= asset('assets/uploads/profile/default.jpg') ?>" alt="Card image cap">
                                                </div>
                                            <?php else: ?>
                                                <img class="img-fluid w-100" src="<?= asset('assets/uploads/profile/' . $member['profile_image']?? '') ?>" alt="Card image cap">
                                            </div>
                                        <?php endif ?>

                                        </div>
                                    </div>
                                                <!-- member picture end -->
                                    </div>
                                                 <!-- member return pending start -->
                                    <div class="tab-pane" id="list-return" role="tabpanel" aria-labelledby="list-return-list">
                                        <div class="table-responsive">
                                            
                                        <table class="table table-light mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Book name</th>
                                                    <th>Book qty</th>
                                                    <th>Get Date</th>
                                                    <th>Last Date</th>
                                                    <th>Status</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if($borrowing) :  ?>
                                                <?php foreach ($borrowing as $borrow) ?>
                                                <tr>
                                                    <td class="text-bold-500"><?= $borrow['book_name']?? ''?></td>
                                                    <td><?=$borrow['qty']  ?></td>
                                                    <td class="text-bold-500"><?=$borrow['issue_date']?? ''?></td>
                                                    <td><?=$borrow['last_date']?? ''?></td>
                                                    <td><?=$borrow['status']?? ''?></td>

                                            </tr>
                                            <?php else :?>
                                              <tr>  
                                                <td  style="text-align:center;" class="dataTables-empty" colspan="5">You have no books to return.</td> </tr>
                                            <?php endif;?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                    <!-- member return pending end -->
                                                 <!-- member fines start -->
                                    <div class="tab-pane" id="list-fine" role="tabpanel" aria-labelledby="list-fine-list">
                                        

                                    
                                       
                                            <?php foreach ($totalFines as $totalFine): ?>
                                            <h1 class="price">LKR <?= $totalFine['total_fine']?? '' ?>/=</h1>
                                            <?php endforeach; ?>
                                            
                                            
                                    

                                    </div>
                                    <!-- member fines end -->

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
                </div>
            </div>
        </div>
    </div>
</section>
<!-- member profile section start -->



<?php require_once('layouts/footer.php'); ?>