<?php

class User
{
    private $conn;

    public function __construct($conn) { $this->conn = $conn; }

    public function findByUsername($username)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username); $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function find($id)
    {
        $stmt = $this->conn->prepare("SELECT id, username, role, status, created_at FROM users WHERE id = ?");
        $stmt->bind_param("i", $id); $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getAll()
    {
        return $this->conn->query("SELECT id, username, role, status, created_at FROM users ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
    }

    public function create($username, $password, $role='user', $status='active')
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, role, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashed, $role, $status);
        return $stmt->execute();
    }

    public function update($id, $username, $role, $status)
    {
        $stmt = $this->conn->prepare("UPDATE users SET username=?, role=?, status=? WHERE id=?");
        $stmt->bind_param("sssi", $username, $role, $status, $id);
        return $stmt->execute();
    }

    public function updatePassword($id, $password)
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->bind_param("si", $hashed, $id); return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id); return $stmt->execute();
    }

    public function countAdmins($excludeId=0)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) c FROM users WHERE role='admin' AND status='active' AND id<>?");
        $stmt->bind_param("i", $excludeId); $stmt->execute();
        return (int)$stmt->get_result()->fetch_assoc()['c'];
    }
}
