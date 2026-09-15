<?php

header("Content-Type: application/json");

require_once "../config/database.php";

$sql = "SELECT id, name, price, stock
        FROM products
        ORDER BY id DESC";

$result = $conn->query($sql);

$products = [];

while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

echo json_encode([
    "success" => true,
    "data" => $products
]);