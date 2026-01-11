<?php
header("Content-Type: application/json");
include '../connection.php';

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $sql = "SELECT user_id, username, email, dob FROM users WHERE deleted_at IS NULL";
        $result = mysqli_query($conn, $sql);
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
        echo json_encode($users);
        break;

    case 'POST':
        
        $data = json_decode(file_get_contents("php://input"), true);
        $hashed_pass = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (username, dob, email, password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $data['username'], $data['dob'], $data['email'], $hashed_pass);
        
        if(mysqli_stmt_execute($stmt)) {
            echo json_encode(["message" => "User created successfully"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Failed to create user"]);
        }
        break;

    case 'DELETE':
        
        $data = json_decode(file_get_contents("php://input"), true);
        $sql = "UPDATE users SET deleted_at = NOW() WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $data['user_id']);
        
        if(mysqli_stmt_execute($stmt)) {
            echo json_encode(["message" => "User soft-deleted"]);
        }
        break;
}
?>