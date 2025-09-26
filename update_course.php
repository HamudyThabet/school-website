<?php
require_once "core/config.php";
session_start();

$id = $_GET['id'] ?? null;
if (!$id) { die("No course ID provided."); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];

    $sql = "UPDATE courses SET course_name=?, description=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $course_name, $description, $id);

    if ($stmt->execute()) {
        header("Location: view_courses.php");
        exit;
    } else {
        echo "Error updating course.";
    }
} else {
    $stmt = $conn->prepare("SELECT * FROM courses WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $course = $stmt->get_result()->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Course</title></head>
<body>
    <h2>Edit Course</h2>
    <form method="POST">
        <label>Course Name:</label>
        <input type="text" name="course_name" value="<?= htmlspecialchars($course['course_name']) ?>" required><br><br>

        <label>Description:</label>
        <textarea name="description"><?= htmlspecialchars($course['description']) ?></textarea><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
