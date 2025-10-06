<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Greenfield Institute of Technology</title>
  <link rel="icon" type="image/x-icon" href="../Main Interface/logoicon.png">
  <link rel="stylesheet" href="../Main Interface/css.css">
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
        <a href="../Admin System/admin_dashboard.php"><img src="../Main Interface/logo.png" alt="Greenfield Logo" class="logo"></a>
      </div>

      <ul class="nav-links">
        <li><a href="../Course Management/view_courses.php">View Courses</a></li>
        <li><a href="../Faculty Management/view_faculty.php">View Faculty</a></li>
        <li><a href="../Student Management/view_students.php">View Students</a></li>
        <li><a href="../Contact Management/view_messages.php">View Messages</a></li>
      </ul>

      <div class="admin-login">
        <a href="../Admin System/logout.php" class="admin-btn">logout</a>
      </div>
    </nav>

  </div>
</header>
<div class="container">