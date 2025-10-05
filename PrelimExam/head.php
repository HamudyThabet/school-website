<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Greenfield Institute of Technology</title>
  <link rel="icon" type="image/x-icon" href="logo.png">
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
    <nav>
      <div class="logo-title">
        <a href="index.php"><img src="logo.png" alt="Greenfield Logo" class="logo"></a>
        <h1>Greenfield Institute<br>of Technology</h1>
      </div>
      <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="courses.php">Courses</a></li>
        <li><a href="faculty.php">Faculty</a></li>
        <li><a href="studentRegist.php">Students</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
  </div>
</header>
<div class="container">