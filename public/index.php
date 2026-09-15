<?php

require_once __DIR__ . '/../config/database.php';

require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/ProductController.php';
require_once __DIR__ . '/../app/controllers/UserController.php';

$authController = new AuthController($conn);
$productController = new ProductController($conn);
$userController = new UserController($conn);

$action = $_GET['action'] ?? 'login';

switch ($action) {

    case 'login':
        $authController->login();
        break;

    case 'logout':
        $authController->logout();
        break;

    case 'dashboard':
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }

        require __DIR__ . '/../app/views/dashboard.php';
        break;

    case 'users':
        $userController->index();
        break;

    case 'create_user':
        $userController->create();
        break;

    case 'edit_user':
        $userController->edit();
        break;

    case 'change_password':
        $userController->changePassword();
        break;

    case 'toggle_user_status':
        $userController->toggleStatus();
        break;

    case 'delete_user':
        $userController->delete();
        break;

    case 'products':
        $productController->index();
        break;

    case 'create':
        $productController->create();
        break;

    case 'edit':
        $productController->edit();
        break;

    case 'delete':
        $productController->delete();
        break;

    case 'stock_in':
        $productController->stockIn();
        break;

    case 'stock_out':
        $productController->stockOut();
        break;

    default:
        echo "Page not found.";
}