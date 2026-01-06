<?php 
include 'connection.php';
$sql = "CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    dob DATE NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";

if($conn ->query($sql) == TRUE){
echo "Table created successfully";
}
else {
    die("Table creation failed");
}
$sql2 = "ALTER TABLE users ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL";
if($conn ->query($sql2) == TRUE){
    echo "Altered table";

}else{
    die("Failed to alter table");
}
?>