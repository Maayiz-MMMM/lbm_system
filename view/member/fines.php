<?php require_once('layouts/header.php');
require_once __DIR__ . '/../../models/user.php';
require_once __DIR__ . '/../../helpers/authmanager.php';

$auth = new AuthManager();
$sm = AppManager::getSM();
$auth->allow(['member']);
$memberModel = new User();
$fines= $memberModel->getFines($_SESSION['userId']);



?>


<div class="page-heading">
    <!-- card body start  -->
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="#">dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">fine</li>
            </ol>
        </nav>

    </div>

    <div class="row">
        <div class="col-12 d-flex justify-content-center mb-3">

               <h4 class="text-center">Fine Details</h4>
        </div>
    </div>




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
                            <th>books ISBN</th>
                            <th>amount</th>
                          
                            <th>status</th>
                            <th>paid_at</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fines as $fine): ?>
                            <tr>
                                <td class="fine_member"><?= htmlspecialchars($fine['book_isbn'] ?? '') ?></td>
                                <td class="fine_isbn"><?= htmlspecialchars($fine['fine_amount'] ?? '') ?></td>

                               
                                    <td >
                                        <?php if($fine['fine_status']==='paid'): ?>
                                        <span class="badge bg-success status-badge"><?=$fine['fine_status']?? '' ?></span>
                                        <?php elseif($fine['fine_status']==='pending'): ?>
                                            <span class="badge bg-danger status-badge"><?=$fine['fine_status']?? '' ?></span>
                                        
                                        <?php endif; ?>
                                    </td>

                                
                                    
                                
                                    <td>
                                    <?php if ($fine['fine_paid_at']):?>    
                                    <?= htmlspecialchars($fine['fine_paid_at']?? '') ?>
                                     <?php else:?>  
                                        <span>Not Paid</span>  
                                     <?php endif;?>  

                                
                                </td>
                                
                              
                            </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <!-- table end -->
        </div>

    </div>
 
<?php require_once('layouts/footer.php')?>

    <script src="<?= asset('assets/form_ajax/fine.js') ?>"></script>