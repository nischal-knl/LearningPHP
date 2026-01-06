<?php
include 'connection.php';
session_start();
if (!isset($_SESSION["logged_in"])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT user_id, username, email, dob FROM users WHERE deleted_at IS NULL";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <style>
        table { 
            width: 80%; 
            border-collapse: collapse;
             margin: 20px auto; 
            }
        th, td { 
            border: 1px solid #ddd;
             padding: 12px;
              text-align: left; 
            }
        th { 
            background-color: #f4f4f4; 
        }
        .btn { 
            padding: 5px 10px;
             text-decoration: none; 
             border-radius: 3px;
             }
        .edit-btn { 
            background-color: #ffc107;
             color: black;
             }
        .delete-btn { 
            background-color: #dc3545;
             color: white;
              border: none;
               cursor: pointer;
             }
    </style>
</head>
<body>

<h2 style="text-align:center;">User Management</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>DOB</th>
        <th>Actions</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['user_id']; ?></td>
        <td><?php echo htmlspecialchars($row['username']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo $row['dob']; ?></td>
        <td>
            <a href="edit_user.php?id=<?php echo $row['user_id']; ?>" class="btn edit-btn">Edit</a>
            
            <form action="delete_user.php" method="POST" style="display:inline;" 
                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                <button type="submit" class="btn delete-btn">Delete</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
<a href = "logout.php">Logout</a>
</body>
</html>