<?php
include 'connection.php';
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = trim($_POST["username"]);
    $password = $_POST["password"];
    $sql = "SELECT username, password FROM users WHERE username = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($user = mysqli_fetch_assoc($result)){
            
            if(password_verify($password, $user['password'])){
                $_SESSION["logged_in"] = true;
                $_SESSION["user"] = $user['username'];
                header("Location: index.php");
                exit;
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No account found with that username.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form </title>
</head>
<body>
   <form method = post action = "">
<label for = "Username">Username: </label>
<input type = "text" name = "username" required><br><br>
<label for = "Password"> Password:</label>
<input type = "password" name = "password" required><br><br>
<input type = "submit" name = "submit" value ="Submit"> 
</form>
<a href = "register.php">Register</a>
</body>
</html>
<?php if(isset($error))echo $error;
?>

