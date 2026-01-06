<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_db";

try {
   
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset("utf8mb4");

} catch (Exception $e) {
    die("Database connection failed.");
}
?>