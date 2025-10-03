<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
if (session_id()) {
    session_destroy();
}

// Optional: Clear session cookie
setcookie(session_name(), '', time() - 3600, '/');

// Redirect to login
header('Location: login.php');
exit();
?>