<?php
require_once "core/config.php";
session_start();

// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $grade = $_POST['grade'];

    // Auto-compute kay Sir yan
    $remark = ($grade >= 75) ? "Pass" : "Fail";

    $sql = "INSERT INTO grades (student_id, course_id, grade, remark) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iids", $student_id, $course_id, $grade, $remark);

    if ($stmt->execute()) {
        header("Location: view_grades.php");
        exit;
    } else {
        echo "Error adding grade.";
    }
}

// Fetch students & courses for dropdown
$students = $conn->query("SELECT * FROM students");
$courses = $conn->query("SELECT * FROM courses");
?>
<!DOCTYPE html>
<html>
<head><title>Add Grade</title></head>
<body>
    <h2>Add Grade</h2>
    <form method="POST">
        <label>Student:</label>
        <select name="student_id" required>
            <?php while ($s = $students->fetch_assoc()): ?>
                <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Course:</label>
        <select name="course_id" required>
            <?php while ($c = $courses->fetch_assoc()): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['course_name']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Grade:</label>
        <input type="number" step="0.01" name="grade" required><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
