<h2>User Management</h2>
<table>
    <tr><th>ID</th><th>Username</th><th>Email</th><th>Actions</th></tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['user_id'] ?></td>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><a href="index.php?page=edit&id=<?= $row['user_id'] ?>">Edit</a></td>
    </tr>
    <?php endwhile; ?>
</table>