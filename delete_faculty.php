<?php
require_once "core/config.php";
session_start();

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM faculty WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: view_faculty.php");
exit;
?>
