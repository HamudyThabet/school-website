<?php
require_once "db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $course_name = trim($_POST['course_name']);
    $description = trim($_POST['description']);

    // Adjust column names if your database uses different ones
    $sql = "INSERT INTO courses (course_name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $course_name, $description);

    if ($stmt->execute()) {
        header("Location: view_courses.php?success=1");
        exit;
    } else {
        echo "❌ Error adding course: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Course</title>
</head>
<body>
    <h2>Add Course</h2>
    <form method="POST">
        <label>Course Name:</label><br>
        <input type="text" name="course_name" required><br><br>

        <label>Description:</label><br>
        <textarea name="description"></textarea><br><br>

        <button type="submit">Add Course</button>
    </form>
</body>
</html>