<?php require_once('layouts/header.php');
require_once __DIR__ . '/../../models/user.php';
require_once __DIR__ . '/../../helpers/authmanager.php';

$auth = new AuthManager();
$sm = AppManager::getSM();
$auth->allow(['member']);
$memberModel = new User();
$member = $memberModel->getBorrowedBooks($_SESSION['userId']);

?>


<div class="page-heading">
    <!-- card body start  -->
    <div class="card-body">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">

                <li class="breadcrumb-item"><a href="#">dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Borrowed Books</li>
            </ol>
        </nav>

    </div>

    <!-- card body end -->




      
            <!-- table striped -->

            <!-- table start -->
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            
                            <th>title</th>
                            <th>books ISBN</th>
                            <th>Issue date</th>
                                                        
                            <th>last date</th>
                            <th>return date</th>
                            <th>qty</th>
                            <th>status</th>
                            <th>fine</th>
                              <th>fine status</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($member as $borrowi): ?>
                            <tr>
                                <td><?= htmlspecialchars($borrowi['title']??'') ?></td>
                                <td><?= htmlspecialchars($borrowi['isbn']??'') ?></td>
                                <td><?= htmlspecialchars($borrowi['issue_date']??'') ?></td>
                                <td><?= htmlspecialchars($borrowi['last_date']??'') ?></td>
                                <td><?= htmlspecialchars($borrowi['return_date']??' Not returned') ?></td>
                                <td><?= htmlspecialchars($borrowi['qty']??'') ?></td>
                                <td><?= htmlspecialchars($borrowi['status']??'') ?></td>

                              
                                    <td >
                                        <?php if($borrowi['fine_amount'] > 0): ?>
                                        <span class="badge bg-danger status-badge">LKR <?=$borrowi['fine_amount']?? '' ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-primary status-badge">Nothing</span>
                                        <?php endif; ?>
                                    </td>

                                    <td >
                                        <?php if($borrowi['fine_status']==='paid'): ?>
                                        <span class="badge bg-success status-badge"><?=$borrowi['fine_status']?? '' ?></span>
                                        <?php elseif($borrowi['fine_status']==='pending'): ?>
                                            <span class="badge bg-danger status-badge"><?=$borrowi['fine_status']?? '' ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-primary status-badge">Nothing</span>
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



   

 
<?php require_once('layouts/footer.php'); ?>

   

  

<script src="<?= asset('assets/form_ajax/books.js') ?>"></script>