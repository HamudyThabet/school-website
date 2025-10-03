<?php
session_start();
// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: admin_dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <?php if (isset($_GET['error'])): ?>
    <p style="color: red;"><?= htmlspecialchars($_GET['error']) ?></p>
<?php endif; ?>
    <form method="POST" action="login_process.php">
        <table border="1" cellpadding="10">
            <tr>
                <th>Username:</th>
                <td><input type="text" name="username" required /></td>
            </tr>
            <tr>
                <th>Password:</th>
                <td><input type="password" name="password" required /></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Login" />
                </td>
            </tr>
        </table>
    </form>
    <p><a href="../User Interface/index.html">Back to Homepage</a></p>
</body>
</html>