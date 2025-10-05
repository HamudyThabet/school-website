<?php include "addlog.php"; ?>
<?php include "head.php"; ?>
<h2>Admin Dashboard</h2>
<p>Welcome, <?= htmlspecialchars($_SESSION['fullname']) ?>!</p>
<ul>
  <li><a href="students.php">Manage Students</a></li>
  <li><a href="courses.php">Manage Courses</a></li>
  <li><a href="faculty.php">Manage Faculty</a></li>
  <li><a href="messages.php">View Messages</a></li>
</ul>
<?php include "foot.php"; ?>
