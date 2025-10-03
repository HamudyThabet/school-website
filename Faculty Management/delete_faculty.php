<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

$faculty_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = ''; // Not used here, but for consistency

if ($faculty_id <= 0) {
    $message = "Invalid faculty ID.";
    header('Location: view_faculty.php?msg=' . urlencode($message));
    exit();
}

// Fetch faculty name for confirmation
$sql = "SELECT name FROM faculty WHERE id = " . $conn->real_escape_string($faculty_id);
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    $message = "Faculty not found.";
    header('Location: view_faculty.php?msg=' . urlencode($message));
    exit();
}

$faculty = $result->fetch_assoc();

// Handle deletion (on POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $delete_sql = "DELETE FROM faculty WHERE id = " . $conn->real_escape_string($faculty_id);
    
    if ($conn->query($delete_sql)) {
        $message = "Faculty deleted successfully.";
    } else {
        $message = "Error deleting faculty: " . $conn->error;
    }
    
    header('Location: view_faculty.php?msg=' . urlencode($message));
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Faculty</title>
</head>
<body>
    <h2>Delete Faculty Confirmation</h2>
    <p>Are you sure you want to delete <strong><?= htmlspecialchars($faculty['name']) ?></strong>?</p>
    <p>This action cannot be undone.</p>
    
    <form method="POST" style="display: inline;">
        <input type="submit" value="Yes, Delete" onclick="return confirm('Final confirmation: Delete this faculty?');" />
    </form>
    <a href="view_faculty.php">No, Cancel</a>
    <p><a href="admin_dashboard.php">Back to Dashboard</a></p>
</body>
</html>