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
    
    $sql = "INSERT INTO faculty (name, specialization, contact) VALUES ('$name', '$specialization', '$contact')";
    
    if ($conn->query($sql)) {
        $message = "Faculty added successfully.";
        header('Location: view_faculty.php?msg=' . urlencode($message));
        exit();
    } else {
        $message = "Error adding faculty: " . $conn->error;
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
    
    <form method="POST">
        <table border="1" cellpadding="10">
            <tr>
                <th>Name:</th>
                <td><input type="text" name="name" required /></td>
            </tr>
            <tr>
                <th>Specialization:</th>
                <td><input type="text" name="specialization" /></td>
            </tr>
            <tr>
                <th>Contact:</th>
                <td><input type="text" name="contact" placeholder="Email or Phone" /></td>
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