<?php

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function findByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function create($username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password)
                VALUES (?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashedPassword);

        return $stmt->execute();
    }
}