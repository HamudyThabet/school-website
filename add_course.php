<?php
require_once "db.php";
session_start();

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
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        form { max-width: 400px; padding: 15px; border: 1px solid #ccc; border-radius: 8px; }
        label { display: block; margin-top: 10px; }
        input, textarea, button { width: 100%; padding: 8px; margin-top: 5px; }
        button { background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
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