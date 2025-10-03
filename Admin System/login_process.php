<?php
require_once "db.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit();
}

$username = $conn->real_escape_string($_POST['username']);
$password = $_POST['password']; // Not escaped—handled by password_verify

// Query for user
$sql = "SELECT id, password FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // Verify password
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username; // Optional: for display
        header('Location: admin_dashboard.php');
        exit();
    } else {
        $error = "Invalid username or password.";
    }
} else {
    $error = "Invalid username or password.";
}

// On error, redirect back to login with message
header('Location: login.php?error=' . urlencode($error));
exit();
?>