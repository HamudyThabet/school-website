<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT id, password_hash, fullname FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        // login success
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];
        header("Location: adminMenu.php");
        exit;
    } else {
        $error = "Invalid login. Try again.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Login - GIT</title>
  <link rel="stylesheet" href="css.css">
</head>
<body>
<div class="container">
  <h2>Admin Login</h2>
  <?php if (!empty($error)): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
  <form method="post">
    <div class="form-group">
      <label>Username</label>
      <input type="text" name="username" required>
    </div>
    <div class="form-group">
      <label>Password</label>
      <input type="password" name="password" required>
    </div>
    <button class="btn" type="submit">Login</button>
  </form>
</div>
</body>
</html>
