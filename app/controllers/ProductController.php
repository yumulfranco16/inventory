<?php

require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    private $product;

    public function __construct($conn)
    {
        $this->product = new Product($conn);
    }

    private function checkLogin()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit;
        }
    }

    public function index()
    {
        $this->checkLogin();

        $products = $this->product->getAll();

        require __DIR__ . '/../views/products/index.php';
    }

    public function create()
    {
        $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = trim($_POST['name']);
            $price = (float) $_POST['price'];
            $stock = (int) $_POST['stock'];

            if ($name === '' || $price < 0 || $stock < 0) {
                $error = "Invalid product information.";
            } else {

                if ($this->product->create(
                    $name,
                    $price,
                    $stock
                )) {

                    header("Location: index.php?action=products");
                    exit;
                }

                $error = "Failed to create product.";
            }
        }

        require __DIR__ . '/../views/products/create.php';
    }

    public function edit()
    {
        $this->checkLogin();

        $id = (int) ($_GET['id'] ?? 0);
        $product = $this->product->find($id);

        if (!$product) {
            die("Product not found.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $price = (float) ($_POST['price'] ?? 0);

            if ($name === '' || $price < 0) {
                $error = "Invalid product information.";
            } elseif ($this->product->update($id, $name, $price)) {
                header("Location: index.php?action=products");
                exit;
            } else {
                $error = "Failed to update product.";
            }

            // Keep submitted values in the form after validation failure.
            $product['name'] = $name;
            $product['price'] = $price;
        }

        require __DIR__ . '/../views/products/edit.php';
    }

    public function delete()
    {
        $this->checkLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?action=products");
            exit;
        }

        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            die("Invalid product ID.");
        }

        if ($this->product->delete($id)) {
            header("Location: index.php?action=products");
            exit;
        }

        die("Unable to delete product. Products with inventory transaction history cannot be deleted.");
    }

    public function stockIn()
    {
        $this->checkLogin();

        $id = (int) $_POST['id'];
        $quantity = (int) $_POST['quantity'];

        if ($this->product->stockIn($id, $quantity)) {
            header("Location: index.php?action=products");
            exit;
        }

        die("Invalid stock-in quantity.");
    }

    public function stockOut()
    {
        $this->checkLogin();

        $id = (int) $_POST['id'];
        $quantity = (int) $_POST['quantity'];

        if ($this->product->stockOut($id, $quantity)) {
            header("Location: index.php?action=products");
            exit;
        }

        die("Insufficient stock or invalid quantity.");
    }
}