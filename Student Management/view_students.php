<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

$sql = "SELECT s.*, c.course_name, g.grade 
        FROM students s 
        LEFT JOIN courses c ON s.course_id = c.id 
        LEFT JOIN grades g ON s.id = g.student_id AND s.course_id = g.course_id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head><title>View Students</title></head>
<body>
    <h2>Student List</h2>
    <p><a href="add_student.php">Add Student</a> | <p><a href="../Admin System/admin_dashboard.php">Back to Dashboard</a></p>
    <table border="1" cellpadding="10">
        <tr>
            <th>Student ID</th><th>Name</th><th>Age</th><th>Course</th><th>Year Level</th><th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['student_id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= $row['age'] ?? 'N/A' ?></td>
            <td><?= htmlspecialchars($row['course_name']) ?? 'No Course' ?></td>
            <td><?= $row['year_level'] ?? 'N/A' ?></td>
            <td>
                <a href="edit_student.php?id=<?= $row['id'] ?>">Edit</a> | 
                <a href="delete_student.php?id=<?= $row['id'] ?>">Delete</a>
            </td>
        </tr>
        <a href="../Admin System/admin_dashboard.php">Back</a>
        <?php endwhile; ?>
    </table>
</body>
</html>