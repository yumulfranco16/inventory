<?php
require_once __DIR__ . '/../models/User.php';
class AuthController {
    private $user;
    public function __construct($conn){ $this->user=new User($conn); }
    public function login(){
        if(session_status()===PHP_SESSION_NONE) session_start();
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $username=trim($_POST['username']??''); $password=$_POST['password']??'';
            $user=$this->user->findByUsername($username);
            if($user && $user['status']==='active' && password_verify($password,$user['password'])){
                session_regenerate_id(true);
                $_SESSION['user_id']=$user['id']; $_SESSION['username']=$user['username'];
                $_SESSION['role']=$user['role'];
                header('Location: index.php?action=dashboard'); exit;
            }
            $error = $user && $user['status']!=='active' ? 'This account is inactive. Contact an administrator.' : 'Invalid username or password.';
        }
        require __DIR__.'/../views/login.php';
    }
    public function logout(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Remove all session data.
        $_SESSION = [];

        // Remove the session cookie using the exact parameters used by PHP.
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                (bool)$params['secure'],
                (bool)$params['httponly']
            );
        }

        session_destroy();

        // Prevent the browser from displaying protected pages from cache.
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Always return to the login page through the public router.
        header('Location: index.php?action=login', true, 303);
        exit;
    }
}
