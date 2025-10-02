<?php
require_once "db.php";
session_start();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // make sure it's an integer

    // Delete course
    $sql = "DELETE FROM courses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: view_courses.php");
        exit;
    } else {
        echo "Error deleting course.";
    }
} else {
    echo "Invalid request.";
}
