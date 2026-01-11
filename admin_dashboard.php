<?php
session_start();
if (!isset($_SESSION["logged_in"]) || $_SESSION["role"] !== 'admin') {
    header("Location: login.php");
    exit;
}

echo "Welcome to the Admin Panel, " . $_SESSION["user"];
?>