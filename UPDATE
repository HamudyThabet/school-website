<?php
require_once "core/config.php";
session_start();

$id = $_GET['id'] ?? null;
if (!$id) { die("No student ID provided."); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $grade = $_POST['grade'];

    $sql = "UPDATE students SET name=?, age=?, grade=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $name, $age, $grade, $id);

    if ($stmt->execute()) {
        header("Location: view_students.php");
        exit;
    } else {
        echo "Error updating student.";
    }
} else {
    $sql = "SELECT * FROM students WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $student = $stmt->get_result()->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Student</title></head>
<body>
    <h2>Edit Student</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required><br><br>

        <label>Age:</label>
        <input type="number" name="age" value="<?= $student['age'] ?>" required><br><br>

        <label>Grade:</label>
        <input type="text" name="grade" value="<?= htmlspecialchars($student['grade']) ?>" required><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
