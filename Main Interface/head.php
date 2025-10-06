<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Greenfield Institute of Technology</title>
  <link rel="icon" type="image/x-icon" href="logoicon.png">
  <link rel="stylesheet" href="css.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<script>
  window.addEventListener('scroll', function() {
    const header = document.querySelector('header');
    if (window.scrollY > 50) { // scroll threshold
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });
</script>
<body>
<header>
  <div class="container">
    <nav class="main-nav">
  <div class="logo-title">
    <a href="index.php"><img src="logo.png" alt="Greenfield Logo" class="logo" style="height: auto; width: 230px;"></a>
  </div>

  <ul class="nav-links">
    <li><a href="index.php">Home</a></li>
    <li><a href="about.php">About</a></li>
    <li><a href="courses.php">Courses</a></li>
    <li><a href="faculty.php">Faculty</a></li>
    <li><a href="studentRegist.php">Students</a></li>
    <li><a href="contact.php">Contact</a></li>
  </ul>

  <div class="admin-login">
    <a href="../Admin System/login.php" class="admin-btn">Admin Login</a>
  </div>
</nav>

  </div>
</header>
<div class="container">