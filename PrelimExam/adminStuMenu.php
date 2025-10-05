<?php
include "addlog.php";
require "db.php";

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM students WHERE id=?");
    $stmt->execute([$_GET['delete']]);
}

$students = $pdo->query("SELECT * FROM students")->fetchAll();
include "head.php";
?>
<h2>Manage Students</h2>
<a href="students_edit.php">Add New Student</a>
<table class="table">
<tr><th>ID</th><th>Name</th><th>Year</th><th>Actions</th></tr>
<?php foreach ($students as $s): ?>
<tr>
  <td><?= $s['student_id'] ?></td>
  <td><?= $s['first_name'] ?> <?= $s['last_name'] ?></td>
  <td><?= $s['year_level'] ?></td>
  <td>
    <a href="students_edit.php?id=<?= $s['id'] ?>">Edit</a> |
    <a href="?delete=<?= $s['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
  </td>
</tr>
<?php endforeach; ?>
</table>
<?php include "foot.php"; ?>
