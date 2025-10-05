<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

$message = ''; // For success/error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $specialization = $conn->real_escape_string($_POST['specialization']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $photo_path = null;
    
    // Handle photo upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_result = uploadFacultyPhoto($_FILES['photo'], 0); // ID 0 for new
        if ($upload_result) {
            $photo_path = $upload_result;
        } else {
            $message = "Invalid photo: Must be JPG/PNG/GIF under 2MB.";
        }
    }
    
    if (empty($message)) {
        $sql = "INSERT INTO faculty (name, specialization, contact, photo_path) 
                VALUES ('$name', '$specialization', '$contact', " . ($photo_path ? "'" . $conn->real_escape_string($photo_path) . "'" : "NULL") . ")";
        
        if ($conn->query($sql)) {
            $new_id = $conn->insert_id;
            $message = "Faculty added successfully.";
            header('Location: view_faculty.php?msg=' . urlencode($message));
            exit();
        } else {
            $message = "Error adding faculty: " . $conn->error;
            // Clean up uploaded file if DB fails
            if ($photo_path && file_exists($photo_path)) unlink($photo_path);
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Faculty</title>
</head>
<body>
    <h2>Add New Faculty</h2>
    <?php if ($message): ?>
        <p style="color: red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data"> <!-- enctype for file upload -->
        <table border="1" cellpadding="10">
            <tr>
                <th>Name:</th>
                <td><input type="text" name="name" required /></td>
            </tr>
            <tr>
                <th>Specialization:</th>
                <td><input type="text" name="specialization" required /></td>
            </tr>
            <tr>
                <th>Contact:</th>
                <td><input type="text" name="contact" placeholder="Email or Phone" required /></td>
            </tr>
            <tr>
                <th>Photo</th>
                <td><input type="file" name="photo" accept="image/*" required /></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Add Faculty" />
                    <a href="view_faculty.php">Cancel</a>
                </td>
            </tr>
        </table>
    </form>
    <p><a href="../Admin System/admin_dashboard.php">Back to Dashboard</a></p>
</body>
</html>