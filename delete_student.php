<?php
require_once "core/config.php";
session_start();

$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "DELETE FROM students WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
header("Location: view_students.php");
exit;
?>
