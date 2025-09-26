<?php
require_once "core/config.php";
session_start();

$result = $conn->query("SELECT * FROM faculty");
?>
<!DOCTYPE html>
<html>
<head><title>View Faculty</title></head>
<body>
    <h2>Faculty List</h2>
    <a href="add_faculty.php">Add Faculty</a>
    <table border="1" cellpadding="10">
        <tr><th>ID</th><th>Name</th><th>Department</th><th>Email</th><th>Actions</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['department']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td>
                <a href="edit_faculty.php?id=<?= $row['id'] ?>">Edit</a> | 
                <a href="delete_faculty.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this faculty?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
