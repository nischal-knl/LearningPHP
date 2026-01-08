<?php
session_start();
require_once 'Database.php';
require_once 'User.php';
require_once 'UserController.php';

// Initialize Database and Models
$database = new Database();
$db = $database->getConnection();
$userModel = new User($db);
$controller = new UserController($userModel);

// Basic Auth Restriction
if (!isset($_SESSION['logged_in']) && $_GET['page'] != 'login') {
    header("Location: ../login.php");
    exit;
}

$page = $_GET['page'] ?? 'home';

// Routing
switch($page) {
    case 'usertable':
        $controller->showUserTable();
        break;
    case 'dashboard':
        include 'dashboard_view.php';
        break;
    default:
        echo "<h1>Welcome Home</h1>";
        break;
}