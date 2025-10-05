<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

if (!isset($_GET['id'])) {
    echo "Invalid request.";
    exit;
}

$id = intval($_GET['id']);

// Fetch course details
$sql = "SELECT * FROM courses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Course not found.";
    exit;
}

$course = $result->fetch_assoc();

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];

    $sql = "UPDATE courses SET course_name = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $course_name, $description, $id);

    if ($stmt->execute()) {
        header("Location: view_courses.php");
        exit;
    } else {
        echo "Error updating course.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
</head>
<body>
    <h2>Edit Course</h2>
    <form method="POST">
        <label>Course Name:</label>
        <input type="text" name="course_name" value="<?= htmlspecialchars($course['course_name']) ?>" required><br><br>

        <label>Description:</label>
        <textarea name="description" required><?= htmlspecialchars($course['description']) ?></textarea><br><br>

        <button type="submit">Update</button>
    </form>
    <a href="../Admin System/admin_dashboard.php">Back to Dashboard</a>
</body>
</html>