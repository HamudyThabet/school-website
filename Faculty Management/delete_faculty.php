<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

$faculty_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($faculty_id <= 0) {
    header('Location: view_faculty.php?msg=' . urlencode("Invalid faculty ID."));
    exit();
}

// Check if faculty exists
$sql = "SELECT * FROM faculty WHERE id = " . $conn->real_escape_string($faculty_id);
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    header('Location: view_faculty.php?msg=' . urlencode("Faculty not found."));
    exit();
}

$faculty = $result->fetch_assoc();

// Delete faculty (also remove photo if exists)
$delete_sql = "DELETE FROM faculty WHERE id = " . $conn->real_escape_string($faculty_id);

if ($conn->query($delete_sql)) {
    if (!empty($faculty['photo_path']) && file_exists($faculty['photo_path'])) {
        unlink($faculty['photo_path']);
    }
    $msg = "Faculty deleted successfully.";
} else {
    $msg = "Error deleting faculty: " . $conn->error;
}

header('Location: view_faculty.php?msg=' . urlencode($msg));
exit();
