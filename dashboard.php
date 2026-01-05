<?php
session_start();
if(!isset($_SESSION['logged_in'])) { header("Location: login.php"); exit; }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['pic'])) {
    $file = $_FILES['pic'];

    
    if (strpos($file['type'], "image") !== false && $file['size'] <= 2 * 1024 * 1024) {
        
        $path = "uploads/" . $file['name'];
        if (move_uploaded_file($file['tmp_name'], $path)) {
            $_SESSION['user_pic'] = $path;
        }
    } else {
        echo "Error: Only images under 2MB allowed.";
    }
}
?>

<h2>Dashboard</h2>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="pic" accept="image/*" required>
    <button type="submit">Upload & View</button>
</form>

<?php if(isset($_SESSION['user_pic'])): ?>
    <p>Your uploaded image:</p>
    <img src="<?php echo $_SESSION['user_pic']; ?>" width="300" style="border: 1px solid #000;">
<?php endif; ?>

<p><a href="logout.php">Logout</a></p>