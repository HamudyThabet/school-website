<?php
require_once "core/config.php";
session_start();

$result = $conn->query("SELECT * FROM courses");
?>
<!DOCTYPE html>
<html>
<head><title>View Courses</title></head>
<body>
    <h2>Course List</h2>
    <a href="add_course.php">Add Course</a>
    <table border="1" cellpadding="10">
        <tr><th>ID</th><th>Course</th><th>Description</th><th>Actions</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['course_name']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td>
                <a href="edit_course.php?id=<?= $row['id'] ?>">Edit</a> | 
                <a href="delete_course.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this course?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
