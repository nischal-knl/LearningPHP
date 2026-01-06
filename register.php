<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
</head>
<body>
    <form action = "" method = "POST">
        <label for = "Username">Username:</label>
        <input type = "text" name = "username"/><br><br>
        <label for = "DOB">DOB:</label>
        <input type = "date" name = "date_of_birth"/><br><br>
        <label for ="email">Email: </label>
        <input type = "email" name = "email"/><br><br>
        <label for = "Password">Password:</label>
        <input type = "password" name = "password"/><br><br>
        <label for = "Confirm Password">Confirm Password</label>
        <input type = "password" name = "confirm_password"/><br><br>
        <input type = "submit" value = "Submit" name = "Submit"/>
</body>
</html>
<?php
include "connection.php";
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = htmlspecialchars(trim($_POST['username']));
    $dob      = $_POST['date_of_birth'];
    $email    = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); 
    $pass     = $_POST['password'];
    $conf_pass = $_POST['confirm_password'];
    if($pass !== $conf_pass) {
        die("Passwords do not match.");
    }

    if(empty($username) || empty($pass) || empty($dob)) {
        die("Please fill in all fields.");
    }
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (username, dob, email, password) VALUES (?, ?, ?, ?)";
    
    if($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssss", $username, $dob, $email, $hashed_password);
        
        if(mysqli_stmt_execute($stmt)) {
            echo "Registration successful!";
            header("Location:login.php");
        } else {
            echo "Error: Could not execute. " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}