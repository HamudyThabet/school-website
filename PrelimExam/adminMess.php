<?php
include "add.php";
require "db.php";

$messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();
include "head.php";
?>
<h2>Messages</h2>
<table class="table">
<tr><th>Name</th><th>Email</th><th>Message</th><th>Date</th></tr>
<?php foreach ($messages as $m): ?>
<tr>
  <td><?= htmlspecialchars($m['name']) ?></td>
  <td><?= htmlspecialchars($m['email']) ?></td>
  <td><?= htmlspecialchars($m['message']) ?></td>
  <td><?= $m['created_at'] ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php include "foot.php"; ?>
