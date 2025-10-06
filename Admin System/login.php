<?php
session_start();
// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: admin.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: url('cyberbg.jpg') no-repeat center center/cover; /* background image */
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 0;
        }
        .login-box {
            position: relative;
            z-index: 1;
            width: 350px;
            padding: 30px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(8px);
            border-radius: 15px;
            text-align: center;
            color: white;
            box-shadow: 0px 8px 20px rgba(0,0,0,0.6);
        }
        .login-box img {
            width: 80px;
            margin-bottom: 20px;
        }
        .login-box h2 {
            margin-bottom: 20px;
            font-size: 1.8em;
            letter-spacing: 1px;
        }
        .login-box form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .login-box input[type="text"], 
        .login-box input[type="password"] {
            padding: 12px;
            border: none;
            border-radius: 8px;
            outline: none;
            font-size: 1em;
        }
        .login-box input[type="submit"] {
            padding: 12px;
            background: #27ae60;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }
        .login-box input[type="submit"]:hover {
            background: #219150;
        }
        .login-box a {
            color: #ddd;
            text-decoration: none;
            font-size: 0.9em;
        }
        .login-box a:hover {
            text-decoration: underline;
        }
        .error {
            color: #ff6b6b;
            margin-bottom: 15px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="login-box">
        <img src="../Main Interface/logoicon.png" alt="Logo"> <!-- Add your school or site logo -->
        <h2>Admin Login</h2>
        
        <?php if (isset($_GET['error'])): ?>
        <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif; ?>
        
        <form method="POST" action="login_process.php">
            <input type="text" name="username" placeholder="Enter Username" required />
            <input type="password" name="password" placeholder="Enter Password" required />
            <input type="submit" value="Login" />
        </form>
        <p><a href="../Main Interface/index.php">← Back to Homepage</a></p>
    </div>
</body>
</html>
