<?php
// Note: session_start() and connection are already handled by index.php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['pic'])) {
    $file = $_FILES['pic'];
    $fileType = $file['type'];
    $isImage = strpos($fileType, "image") !== false;
    $isPDF = ($fileType === "application/pdf");
    
    if (($isImage || $isPDF) && $file['size'] <= 2 * 1024 * 1024) {
        // Strip spaces to make filename "URL friendly"
        $cleanName = str_replace(" ", "", $file['name']);
        $uniqueName = session_id() . "_" . $cleanName;
        $path = "uploads/" . $uniqueName;
        
        if (move_uploaded_file($file['tmp_name'], $path)) {
            $_SESSION['user_file'] = $path;
            $_SESSION['file_type'] = $fileType;
        }
    } else {
        echo "<p style='color:red;'>Error: Only Images/PDFs under 2MB allowed.</p>";
    }
}
?>

<h2>Dashboard - File Upload</h2>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="pic" required>
    <button type="submit">Upload & View</button>
</form>

<hr>

<?php if(isset($_SESSION['user_file'])): ?>
    <?php if(strpos($_SESSION['file_type'], "image") !== false): ?>
        <img src="<?php echo $_SESSION['user_file']; ?>" width="300" alt="Uploaded Image">
    <?php else: ?>
        <p>PDF Uploaded: <a href="<?php echo $_SESSION['user_file']; ?>" target="_blank">Open PDF</a></p>
    <?php endif; ?>
<?php endif; ?>