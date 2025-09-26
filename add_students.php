<?php
require_once "core/config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $grade = $_POST['grade'];

    $sql = "INSERT INTO students (name, age, grade) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $name, $age, $grade);

    if ($stmt->execute()) {
        header("Location: view_students.php");
        exit;
    } else {
        echo "Error adding student.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Add Student</title></head>
<body>
    <h2>Add Student</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required><br><br>

        <label>Age:</label>
        <input type="number" name="age" required><br><br>

        <label>Grade:</label>
        <input type="text" name="grade" required><br><br>

        <button type="submit">Add</button>
    </form>
</body>
</html>
