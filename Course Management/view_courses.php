<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

// Fetch all courses
$sql = "SELECT * FROM courses ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Courses</title>
</head>
<body>
    <h2>Courses</h2>
    <p><a href="add_course.php">Add New Course</a> | <p><a href="../Admin System/admin_dashboard.php">Back to Dashboard</a></p></p>
    <br><br>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Course Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['course_name']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td>
                        <a href="edit_course.php?id=<?= $row['id'] ?>">Edit</a> | 
                        <a href="delete_course.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this course?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4">No courses found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>