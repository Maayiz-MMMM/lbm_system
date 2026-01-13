<?php

require_once __DIR__ . '/../config.php';
require_once 'AppManager.php';

class AuthManager
{
    private $sm;

    public function __construct()
    {
        $this->sm = AppManager::getSM();
    }

    public function checkLogin()
    {
        if ($this->sm->getAttribute('logged_in') !== true) {
            header("Location: " . url('view/auth/login.php'));
            exit;
        }
    }
    public function checkBan (){
        if ($this->sm->getAttribute('ban') === true){
              header("Location: " . url('services/logout.php'));
            exit;
        }
    }

    public function role()
    {
        return $this->sm->getAttribute('role');
    }

    public function allow(array $roles)
    {
        $this->checkLogin();

        if (!in_array($this->role(), $roles, true)) {
            header("Location: " . url('view/auth/unauthorized.php'));
            exit;
        }
    }

    public function redirectByRole()
    {
        $this->checkLogin();

        $routes = [
            'Admin'  => 'view/admin/dashboard.php',
            'member' => 'view/member/dashboard.php'
        ];

        $role = $this->role();

        header("Location: " . url($routes[$role] ?? 'view/auth/login.php'));
        exit;
    }

    public function isLoggedIn(): bool
{
    return $this->sm->getAttribute('logged_in') === true;
}



}
