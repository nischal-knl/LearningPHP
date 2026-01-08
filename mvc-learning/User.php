<?php
class User {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllUsers() {
        $sql = "SELECT user_id, username, email, dob FROM " . $this->table . " WHERE deleted_at IS NULL";
        return $this->conn->query($sql);
    }

    public function update($id, $username, $email, $dob) {
        $sql = "UPDATE " . $this->table . " SET username=?, email=?, dob=? WHERE user_id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $email, $dob, $id);
        return $stmt->execute();
    }
}