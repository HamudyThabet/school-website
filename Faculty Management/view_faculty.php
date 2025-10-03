<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

$message = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : '';

// Fetch all faculty
$sql = "SELECT * FROM faculty ORDER BY name";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Faculty</title>
</head>
<body>
    <h2>Faculty List</h2>
    <?php if ($message): ?>
        <p style="color: green;"><?= $message ?></p>
    <?php endif; ?>
    
    <p><a href="add_faculty.php">Add New Faculty</a> | <p><a href="../Admin System/admin_dashboard.php">Back to Dashboard</a></p></p>
    
    <?php if ($result && $result->num_rows > 0): ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Specialization</th>
            <th>Contact</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['specialization'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($row['contact'] ?? 'N/A') ?></td>
            <td>
                <a href="edit_faculty.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete_faculty.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p>No faculty found. <a href="add_faculty.php">Add one</a>.</p>
    <?php endif; ?>
</body>
</html>