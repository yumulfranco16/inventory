<?php

require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $user;

    public function __construct($conn)
    {
        $this->user = new User($conn);
    }

    public function login()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $user = $this->user->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                header("Location: index.php?action=dashboard");
                exit;
            }

            $error = "Invalid username or password";
        }

        require __DIR__ . '/../views/login.php';
    }

    public function logout()
    {
        session_start();

        session_destroy();

        header("Location: index.php?action=login");
        exit;
    }
}