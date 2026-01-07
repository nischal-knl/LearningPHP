<?php
// Note: connection and login checks are inherited from index.php

$sql = "SELECT user_id, username, email, dob FROM users WHERE deleted_at IS NULL";
$result = mysqli_query($conn, $sql);
?>

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