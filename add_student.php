<?php
require_once "db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $course_id = $_POST['course_id'];
    $year_level = $_POST['year_level'];

    $sql = "INSERT INTO students (student_id, name, age, course_id, year_level) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiii", $student_id, $name, $age, $course_id, $year_level);

    if ($stmt->execute()) {
        header("Location: view_students.php");
        exit;
    } else {
        echo "Error adding student: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Add Student</title></head>
<body>
    <h2>Add Student</h2>
    <form method="POST">
        <label>Student ID:</label>
        <input type="text" name="student_id" placeholder="e.g. 2025-001" required><br><br>

        <label>Name:</label>
        <input type="text" name="name" required><br><br>

        <label>Age:</label>
        <input type="number" name="age" required><br><br>

        <label>Course:</label>
        <select name="course_id" required>
            <?php
            // populate courses from DB
            $courses = $conn->query("SELECT id, course_name FROM courses");
            while ($row = $courses->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['course_name'] . "</option>";
            }
            ?>
        </select><br><br>

        <label>Year Level:</label>
        <input type="number" name="year_level" min="1" max="6" required><br><br>

        <button type="submit">Add</button>
    </form>
</body>
</html>
