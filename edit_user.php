<?php
include 'connection.php';
if (!isset($_GET['id'])) {
    header("Location: index.php?page=usertable");
    exit;
}

$id = $_GET['id'];

// --- UPDATE LOGIC ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars(trim($_POST['username']));
    $dob = $_POST['dob'];
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    $update_sql = "UPDATE users SET username = ?, dob = ?, email = ? WHERE user_id = ?";
    if ($stmt = mysqli_prepare($conn, $update_sql)) {
        mysqli_stmt_bind_param($stmt, "sssi", $username, $dob, $email, $id);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>window.location.href='index.php?page=usertable&msg=updated';</script>";
            exit;
        } else {
            $error = "Update failed. Please try again.";
        }
        mysqli_stmt_close($stmt);
    }
}

// --- FETCH LOGIC ---
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

<div class="form-container">
    <h2>Edit User</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    
    <form method="POST" action="index.php?page=edit_user&id=<?php echo $id; ?>">
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        
        <label>DOB:</label>
        <input type="date" name="dob" value="<?php echo $user['dob']; ?>" required>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        
        <input type="submit" value="Update User" class="save-btn" style="padding: 10px; background: #28a745; color: white; border: none; cursor: pointer; width: 100%;">
    </form>
    <a href="index.php?page=usertable" class="back-link">Cancel and Go Back</a>
</div>