<?php
include 'connection.php';
session_start();

if (!isset($_SESSION["logged_in"])) { exit; }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $id = $_POST['user_id'];
    $sql = "UPDATE users SET deleted_at = NOW() WHERE user_id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
header("Location: index.php?page=usertable"); 
exit;
?>