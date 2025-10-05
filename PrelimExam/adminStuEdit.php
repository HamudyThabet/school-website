<?php
include "addlog.php";
require "db.php";

$id = $_GET['id'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($id) {
        $stmt = $pdo->prepare("UPDATE students SET first_name=?, last_name=?, age=?, year_level=? WHERE id=?");
        $stmt->execute([$_POST['first_name'], $_POST['last_name'], $_POST['age'], $_POST['year_level'], $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO students (student_id, first_name, last_name, age, year_level) VALUES (?,?,?,?,?)");
        $stmt->execute([$_POST['student_id'], $_POST['first_name'], $_POST['last_name'], $_POST['age'], $_POST['year_level']]);
    }
    header("Location: students.php");
    exit;
}
$student = null;
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id=?");
    $stmt->execute([$id]);
    $student = $stmt->fetch();
}
include "head.php";
?>
<h2><?= $id ? "Edit" : "Add" ?> Student</h2>
<form method="post">
  <?php if (!$id): ?>
    <label>Student ID</label><input name="student_id" required>
  <?php endif; ?>
  <label>First Name</label><input name="first_name" value="<?= $student['first_name'] ?? '' ?>" required>
  <label>Last Name</label><input name="last_name" value="<?= $student['last_name'] ?? '' ?>" required>
  <label>Age</label><input type="number" name="age" value="<?= $student['age'] ?? '' ?>">
  <label>Year Level</label>
  <select name="year_level">
    <?php for($i=1;$i<=4;$i++): ?>
      <option <?= ($student['year_level'] ?? '')==$i ? 'selected' : '' ?>><?= $i ?></option>
    <?php endfor; ?>
  </select>
  <button type="submit">Save</button>
</form>
<?php include "foot.php"; ?>
