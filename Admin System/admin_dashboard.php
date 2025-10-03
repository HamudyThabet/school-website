<?php
session_start();

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once "db.php";

// Optional: Fetch user info for display
$username = $_SESSION['username'] ?? 'Admin';
$sql = "SELECT username FROM users WHERE id = " . intval($_SESSION['user_id']);
$result = $conn->query($sql);
if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $username = $user['username'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Welcome to Admin Dashboard, <?= htmlspecialchars($username) ?>!</h2>
    <p>You are logged in successfully.</p>
    
    <h3>Quick Links</h3>
    <ul>
        <li><a href="view_students.php">View Students</a></li>
        <li><a href="add_student.php">Add Student</a> <!-- Assuming you have this file --></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
    
    <p><a href="login.php">Login Page</a> (for testing)</p>
</body>
</html>