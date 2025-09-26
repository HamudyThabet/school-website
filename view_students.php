<?php
require_once "core/config.php";
session_start();

$sql = "SELECT * FROM students";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head><title>View Students</title></head>
<body>
    <h2>Student List</h2>
    <a href="add_student.php">Add Student</a>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th><th>Name</th><th>Age</th><th>Grade</th><th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= $row['age'] ?></td>
            <td><?= htmlspecialchars($row['grade']) ?></td>
            <td>
                <a href="edit_student.php?id=<?= $row['id'] ?>">Edit</a> | 
                <a href="delete_student.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this student?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
