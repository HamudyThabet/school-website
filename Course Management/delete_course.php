<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // ensure it's an integer

    try {
        $sql = "DELETE FROM courses WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: view_courses.php");
            exit;
        } else {
            echo "An unexpected error occurred while deleting the course.";
        }
    } catch (mysqli_sql_exception $e) {
        // MySQL foreign key constraint error
        if ($e->getCode() == 1451) {
            echo "This course cannot be deleted because there are students currently enrolled in it. 
                  Please remove or transfer the enrolled students before deleting the course.";
        } else {
            echo "Database Error: " . $e->getMessage();
        }
    }
} else {
    echo "Invalid request.";
}
