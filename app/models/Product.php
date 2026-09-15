<?php

class Product
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM products ORDER BY id DESC";

        $result = $this->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM products WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function create($name, $price, $stock)
    {
        $sql = "INSERT INTO products (name, price, stock)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sdi", $name, $price, $stock);

        if (!$stmt->execute()) {
            return false;
        }

        // Record initial stock
        if ($stock > 0) {
            $productId = $stmt->insert_id;

            $this->recordTransaction(
                $productId,
                "IN",
                $stock
            );
        }

        return true;
    }

    public function update($id, $name, $price)
    {
        $sql = "UPDATE products
                SET name = ?, price = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sdi", $name, $price, $id);

        return $stmt->execute();
    }

    public function delete($id)
    {
        // Remove the product's transaction history first because
        // inventory_transactions.product_id has a foreign key to products.id.
        $this->conn->begin_transaction();

        try {
            $sql = "DELETE FROM inventory_transactions WHERE product_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);

            if (!$stmt->execute()) {
                throw new Exception("Failed to delete transaction history.");
            }

            $sql = "DELETE FROM products WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);

            if (!$stmt->execute() || $stmt->affected_rows === 0) {
                throw new Exception("Product not found.");
            }

            $this->conn->commit();
            return true;
        } catch (Throwable $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function stockIn($id, $quantity)
    {
        if ($quantity <= 0) {
            return false;
        }

        $sql = "UPDATE products
                SET stock = stock + ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $id);

        if (!$stmt->execute()) {
            return false;
        }

        $this->recordTransaction($id, "IN", $quantity);

        return true;
    }

    public function stockOut($id, $quantity)
    {
        if ($quantity <= 0) {
            return false;
        }

        /*
         * Important:
         * Only subtract if enough stock exists.
         */
        $sql = "UPDATE products
                SET stock = stock - ?
                WHERE id = ?
                AND stock >= ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "iii",
            $quantity,
            $id,
            $quantity
        );

        $stmt->execute();

        if ($stmt->affected_rows == 0) {
            return false;
        }

        $this->recordTransaction($id, "OUT", $quantity);

        return true;
    }

    private function recordTransaction($productId, $type, $quantity)
    {
        $sql = "INSERT INTO inventory_transactions
                (product_id, type, quantity)
                VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "isi",
            $productId,
            $type,
            $quantity
        );

        return $stmt->execute();
    }
}