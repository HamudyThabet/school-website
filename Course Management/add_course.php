<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = trim($_POST['course_name']);
    $description = trim($_POST['description']);

    if (!empty($course_name)) {
        $sql = "INSERT INTO courses (course_name, description) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $course_name, $description);

        if ($stmt->execute()) {
            header("Location: view_courses.php");
            exit;
        } else {
            echo "❌ Error adding course: " . $conn->error;
        }
    } else {
        echo "❌ Course name is required!";
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
    <form method="POST" action="">
        <label>Course Name:</label>
        <input type="text" name="course_name" required>

        <label>Description:</label>
        <textarea name="description"></textarea>

        <button type="submit">Add Course</button>
    </form>
</body>
</html>