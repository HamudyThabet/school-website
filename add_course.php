<?php
require_once "core/config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];

    $sql = "INSERT INTO courses (course_name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $course_name, $description);

    if ($stmt->execute()) {
        header("Location: view_courses.php");
        exit;
    } else {
        echo "Error adding course.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Add Course</title></head>
<body>
    <h2>Add Course</h2>
    <form method="POST">
        <label>Course Name:</label>
        <input type="text" name="course_name" required><br><br>

        <label>Description:</label>
        <textarea name="description"></textarea><br><br>

        <button type="submit">Add</button>
    </form>
</body>
</html>
