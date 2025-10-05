<?php
$host = "localhost";
$user = "root";     // default XAMPP user
$pass = "";         // default is empty
$db   = "git_school";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function uploadFacultyPhoto($file, $faculty_id) {
    $target_dir = "Assets/faculty";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 2 * 1024 * 1024; // 2MB
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false; // Upload error
    }
    
    if (!in_array($file['type'], $allowed_types) || $file['size'] > $max_size) {
        return false; // Invalid type/size
    }
    
    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = "faculty_" . $faculty_id . "_" . time() . "." . $extension;
    $target_file = $target_dir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return $target_file; // Return path
    }
    return false;
}
?>