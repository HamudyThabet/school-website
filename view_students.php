<?php
require_once "core/config.php";
session_start();

$sql = "
    SELECT g.id, s.name AS student, c.course_name, g.grade, g.remark
    FROM grades g
    JOIN students s ON g.student_id = s.id
    JOIN courses c ON g.course_id = c.id
    ORDER BY s.name, c.course_name
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head><title>View Grades</title></head>
<body>
    <h2>Grades</h2>
    <a href="add_grade.php">Add Grade</a>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th><th>Student</th><th>Course</th><th>Grade</th><th>Remark</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['student']) ?></td>
            <td><?= htmlspecialchars($row['course_name']) ?></td>
            <td><?= $row['grade'] ?></td>
            <td><?= $row['remark'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
