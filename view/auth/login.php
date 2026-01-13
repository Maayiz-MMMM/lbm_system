<?php
require_once __DIR__.'/../../config.php';
require_once __DIR__ . '/../../helpers/AppManager.php';
require_once __DIR__ . '/../../helpers/AuthManager.php';

$auth = new AuthManager();
$sm   = AppManager::getSM();

// If already logged in → redirect
if ($auth->isLoggedIn()) {
    $auth->redirectByRole();
}

$rememberEmail = $_COOKIE['remember_email'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= asset('assets/css/login.css') ?>" rel="stylesheet">

    <!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    

    <style>
  .password-wrapper {
    position: relative;
}

.password-toggle {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 1.2rem;
    color: #666;
}

.eye-show { display: inline; }
.eye-hide { display: none; }

    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-card"> 
        <div class="text-start mb-3">
            <a href="<?= url('/') ?>" class="btn btn-sm btn-primary">
                &larr; Home
            </a>
        </div>
        <h1>Welcome Back </h1>
        <p class="subtitle">Login with your email & password</p>

        <?php
        $error = $sm->getAttribute('error');
        if ($error):
        ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php
            $sm->removeAttribute('error');
        endif;
        ?>

       <form action="<?= url('services/auth.php') ?>" method="POST">
    <input type="email" name="email" class="form-control mb-3" placeholder="Email Address" value="<?= htmlspecialchars($rememberEmail) ?>" required>

    <div class="password-wrapper mb-3 position-relative">
        <input type="password" name="password" class="form-control" placeholder="Password" required id="password">
        <span class="password-toggle position-absolute" data-target="password" style="top:50%; right:15px; cursor:pointer; transform: translateY(-50%);">
                   <i class="fas fa-eye eye-show"></i> 
                                <i class="fas fa-eye-slash eye-hide"></i> 
      
        </span>
    </div>

    <div class="remember-me mb-3">
        <input type="checkbox" name="remember" id="remember" <?= $rememberEmail ? 'checked' : '' ?> >
        <label for="remember">Remember Me</label>
    </div>

    <button type="submit" class="btn btn-login w-100">Login</button>
</form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome JS (optional, icons are CSS only, but for fallback) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/js/all.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/js/all.min.js"></script>
<script src="<?= asset('assets/js/login.js')  ?>">  </script>


</body>
</html>
