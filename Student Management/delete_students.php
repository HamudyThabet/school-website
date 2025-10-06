<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}

require_once "db.php";

$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($student_id <= 0) {
    header("Location: view_students.php?msg=" . urlencode("Invalid student ID."));
    exit();
}

// Check if student exists
$sql = "SELECT name FROM students WHERE id = " . $conn->real_escape_string($student_id);
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    header("Location: view_students.php?msg=" . urlencode("Student not found."));
    exit();
}

// Delete directly
$delete_sql = "DELETE FROM students WHERE id = " . $conn->real_escape_string($student_id);

if ($conn->query($delete_sql)) {
    $msg = "Student deleted successfully.";
} else {
    $msg = "Error deleting student: " . $conn->error;
}

header("Location: view_students.php?msg=" . urlencode($msg));
exit();
