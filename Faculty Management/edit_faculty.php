<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

$faculty_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = ''; // For success/error

if ($faculty_id <= 0) {
    $message = "Invalid faculty ID.";
    header('Location: view_faculty.php?msg=' . urlencode($message));
    exit();
}

// Fetch current faculty data
$sql = "SELECT * FROM faculty WHERE id = " . $conn->real_escape_string($faculty_id);
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    $message = "Faculty not found.";
    header('Location: view_faculty.php?msg=' . urlencode($message));
    exit();
}

$faculty = $result->fetch_assoc();

// Fetch current faculty data
$sql = "SELECT * FROM faculty WHERE id = " . $conn->real_escape_string($faculty_id);
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    $message = "Faculty not found.";
    header('Location: view_faculty.php?msg=' . urlencode($message));
    exit();
}

$faculty = $result->fetch_assoc();

// Handle form submission (update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $specialization = $conn->real_escape_string($_POST['specialization']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $new_photo_path = $faculty['photo_path']; // Keep existing by default
    
    // Handle new photo upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_result = uploadFacultyPhoto($_FILES['photo'], $faculty_id);
        if ($upload_result) {
            // Delete old photo if exists
            if ($faculty['photo_path'] && file_exists($faculty['photo_path'])) {
                unlink($faculty['photo_path']);
            }
            $new_photo_path = $upload_result;
        } else {
            $message = "Invalid photo: Must be JPG/PNG/GIF under 2MB.";
        }
    }
    
    if (empty($message)) {
        $update_sql = "UPDATE faculty SET 
                       name = '$name', 
                       specialization = '$specialization', 
                       contact = '$contact', 
                       photo_path = " . ($new_photo_path ? "'" . $conn->real_escape_string($new_photo_path) . "'" : "NULL") . " 
                       WHERE id = $faculty_id";
        
        if ($conn->query($update_sql)) {
            $message = "Faculty updated successfully.";
            header('Location: view_faculty.php?msg=' . urlencode($message));
            exit();
        } else {
            $message = "Error updating faculty: " . $conn->error;
            // Clean up new photo if DB fails
            if ($new_photo_path && $new_photo_path !== $faculty['photo_path'] && file_exists($new_photo_path)) {
                unlink($new_photo_path);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Faculty</title>
</head>
<body>
    <h2>Edit Faculty</h2>
    <?php if ($message): ?>
        <p style="color: red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <table border="1" cellpadding="10">
            <tr>
                <th>Name:</th>
                <td><input type="text" name="name" value="<?= htmlspecialchars($faculty['name']) ?>" required /></td>
            </tr>
            <tr>
                <th>Specialization:</th>
                <td><input type="text" name="specialization" value="<?= htmlspecialchars($faculty['specialization'] ?? '') ?>" required /></td>
            </tr>
            <tr>
                <th>Contact:</th>
                <td><input type="text" name="contact" value="<?= htmlspecialchars($faculty['contact'] ?? '') ?>" placeholder="Email or Phone" required /></td>
            </tr>
            <tr>
                <th>Current Photo:</th>
                <td>
                    <?php if ($faculty['photo_path'] && file_exists($faculty['photo_path'])): ?>
                        <img src="<?= htmlspecialchars($faculty['photo_path']) ?>" alt="Current Photo" width="100" height="100" />
                        <br><small>New upload will replace this.</small>
                    <?php else: ?>
                        <span>No current photo</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>New Photo:</th>
                <td><input type="file" name="photo" accept="image/*" /></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Update Faculty" />
                    <a href="view_faculty.php">Cancel</a>
                </td>
            </tr>
        </table>
    </form>
    <p><a href="../Admin System/admin_dashboard.php">Back to Dashboard</a></p>
</body>
</html>