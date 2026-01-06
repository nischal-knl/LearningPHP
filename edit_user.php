<?php
include 'connection.php';
session_start();
if (!isset($_GET['id'])) {
    header("Location: list_users.php");
    exit;
}

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $dob = $_POST['dob'];
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    $update_sql = "UPDATE users SET username = ?, dob = ?, email = ? WHERE user_id = ?";
    if ($stmt = mysqli_prepare($conn, $update_sql)) {
        mysqli_stmt_bind_param($stmt, "sssi", $username, $dob, $email, $id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: usertable.php?msg=updated");
            exit;
        } else {
            $error = "Update failed. Please try again.";
        }
        mysqli_stmt_close($stmt);
    }
}
$sql = "SELECT username, dob, email FROM users WHERE user_id = ? AND deleted_at IS NULL";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

if (!$user) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <style>
        .form-container { 
            width: 300px;
             margin: 50px auto;
              font-family: sans-serif; 
            }
        input { 
            width: 100%;
             padding: 8px; 
             margin: 10px 0; 
             box-sizing: border-box; 
            }
        .save-btn { background: #28a745;
             color: white;
              border: none; 
              cursor: pointer; 
            }
        .back-link { 
            display: block;
             margin-top: 10px; 
             text-align: center;
              color: #666;
             }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Edit User</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        
        <label>DOB:</label>
        <input type="date" name="dob" value="<?php echo $user['dob']; ?>" required>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        
        <input type="submit" value="Update User" class="save-btn">
    </form>
    <a href="usertable.php" class="back-link">Cancel and Go Back</a>
</div>

</body>
</html>