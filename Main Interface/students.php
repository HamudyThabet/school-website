<?php
//db require here


//adasdasdsadsaa
include "Header.php";
?>
<h2>Student Registration</h2>
<!--<?php //if ($msg): ?><p style="color:green"><?= //$msg ?></p><?php //endif; ?> -->
<form method="post">
  <label>Student ID</label><input name="student_id" required>
  <label>First Name</label><input name="first_name" required>
  <label>Last Name</label><input name="last_name" required>
  <label>Age</label><input type="number" name="age">
  <label>Year Level</label>
  <select name="year_level"><option>1</option><option>2</option><option>3</option><option>4</option></select>
  <button type="submit">Register</button>
</form>
<?php include "Footer.php"; ?>
