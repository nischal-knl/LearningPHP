<?php
session_start();
include 'connection.php';

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.php");
    exit;
}

$route = $_GET['route'] ?? 'home'; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My App - <?php echo ucfirst($route); ?></title>
    <style>
        nav { background: #f4f4f4; padding: 10px; margin-bottom: 20px; }
        nav a { margin-right: 15px; text-decoration: none; color: blue; }
        .container { font-family: sans-serif; padding: 20px; }
    </style>
</head>
<body>

<nav>
    <strong>Welcome, <?php echo htmlspecialchars($_SESSION["user"]); ?>!</strong> |
    <a href="index.php?route=home">Home</a>
    <a href="index.php?route=dashboard">Dashboard</a>
    <a href="index.php?route=users">User Table</a>
    <a href="logout.php" style="color:red;">Logout</a>
</nav>

<div class="container">
    <?php
    switch ($route) {
        case 'dashboard':
            include 'dashboard.php';
           
            break;

        case 'users':
            echo "<h2>User Management</h2>";
            include 'usertable.php';
            break;

        case 'home':
        default:
            echo "<h2>Main Page</h2><p>You are successfully logged in to the system.</p>";
            break;
    }
    ?>
</div>

</body>
</html>