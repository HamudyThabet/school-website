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

// Handle form submission (update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $specialization = $conn->real_escape_string($_POST['specialization']);
    $contact = $conn->real_escape_string($_POST['contact']);
    
    $update_sql = "UPDATE faculty SET 
                   name = '$name', 
                   specialization = '$specialization', 
                   contact = '$contact' 
                   WHERE id = $faculty_id";
    
    if ($conn->query($update_sql)) {
        $message = "Faculty updated successfully.";
        header('Location: view_faculty.php?msg=' . urlencode($message));
        exit();
    } else {
        $message = "Error updating faculty: " . $conn->error;
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
    
    <form method="POST">
        <table border="1" cellpadding="10">
            <tr>
                <th>Name:</th>
                <td><input type="text" name="name" value="<?= htmlspecialchars($faculty['name']) ?>" required /></td>
            </tr>
            <tr>
                <th>Specialization:</th>
                <td><input type="text" name="specialization" value="<?= htmlspecialchars($faculty['specialization'] ?? '') ?>" /></td>
            </tr>
            <tr>
                <th>Contact:</th>
                <td><input type="text" name="contact" value="<?= htmlspecialchars($faculty['contact'] ?? '') ?>" placeholder="Email or Phone" /></td>
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