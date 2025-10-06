<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($course_id <= 0) {
    echo "<script>
        alert('Invalid course ID.');
        window.location.href='view_courses.php';
    </script>";
    exit();
}

try {
    $sql = "DELETE FROM courses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();

    // ✅ Success → reload the list page (no white screen)
    echo "<script>
        window.location.href='view_courses.php';
    </script>";
    exit();

} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        $msg = "Cannot delete this course. Students are still enrolled, drop or transfer them first.";
    } else {
        $msg = "Database Error: " . $e->getMessage();
    }

    echo "<script>
        alert(" . json_encode($msg) . ");
        window.location.href='view_courses.php';
    </script>";
    exit();
}
?>