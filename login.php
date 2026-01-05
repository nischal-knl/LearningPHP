<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST["username"];
    $password = $_POST["password"];
    if($name == "Nischal" && $password == "nischal123" ){
        $_SESSION["logged_in"] = true;
        $_SESSION["user"] = $name;
        header("Location:dashboard.php");
        exit;
        }else{
            $error = "Invalid username and password";
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
</body>
</html>
<?php if(isset($error))echo $error;
?>

