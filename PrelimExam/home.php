<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Greenfield Institute of Technology</title>
  <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
<header>
  <h1>Greenfield Institute of Technology</h1>
  <nav>
    <ul>
      <li><a href="/public/index.php">Home</a></li>
      <li><a href="/public/about.php">About</a></li>
      <li><a href="/public/courses.php">Courses</a></li>
      <li><a href="/public/faculty.php">Faculty</a></li>
      <li><a href="/public/students_register.php">Students</a></li>
      <li><a href="/public/contact.php">Contact</a></li>
    </ul>
  </nav>
</header>
<div class="container">
</div>
<footer class="footer">
  <p>&copy; <?= date("Y") ?> Greenfield Institute of Technology</p>
</footer>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

