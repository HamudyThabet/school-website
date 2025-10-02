<?php
require_once "db.php";
session_start();

$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = ''; // For success/error messages

if ($student_id <= 0) {
    $message = "Invalid student ID.";
    header("Location: view_students.php?msg=" . urlencode($message));
    exit();
}

// Fetch student name for confirmation
$sql = "SELECT name FROM students WHERE id = " . $conn->real_escape_string($student_id);
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    $message = "Student not found.";
    header("Location: view_students.php?msg=" . urlencode($message));
    exit();
}

$student = $result->fetch_assoc();

// Handle deletion (on POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delete_sql = "DELETE FROM students WHERE id = " . $conn->real_escape_string($student_id);
    
    if ($conn->query($delete_sql)) {
        $message = "Student deleted successfully.";
    } else {
        $message = "Error deleting student: " . $conn->error;
    }
    
    header("Location: view_students.php?msg=" . urlencode($message));
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Student</title>
</head>
<body>
    <h2>Delete Student Confirmation</h2>
    <p>Are you sure you want to delete the student <strong><?= htmlspecialchars($student['name']) ?></strong>?</p>
    <p>This action cannot be undone and will also delete any associated grades.</p>
    
    <form method="POST" style="display: inline;">
        <input type="submit" value="Yes, Delete" onclick="return confirm('Final confirmation: Delete this student?');" />
    </form>
    <a href="view_students.php">No, Cancel</a>
</body>
</html>