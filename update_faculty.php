<?php
require_once "core/config.php";
session_start();

$id = $_GET['id'] ?? null;
if (!$id) { die("No faculty ID provided."); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $department = $_POST['department'];
    $email = $_POST['email'];

    $sql = "UPDATE faculty SET name=?, department=?, email=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $department, $email, $id);

    <?php
require_once "core/config.php";
session_start();

$id = $_GET['id'] ?? null;
if (!$id) { die("No faculty ID provided."); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $department = $_POST['department'];
    $email = $_POST['email'];

    $sql = "UPDATE faculty SET name=?, department=?, email=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $department, $email, $id);

    if ($stmt->execute()) {
        header("Location: view_faculty.php");
        exit;
    } else {
        echo "Error updating faculty.";
    }
} else {
    $stmt = $conn->prepare("SELECT * FROM faculty WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $faculty = $stmt->get_result()->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Faculty</title></head>
<body>
    <h2>Edit Faculty</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($faculty['name']) ?>" required><br><br>

        <label>Department:</label>
        <input type="text" name="department" value="<?= htmlspecialchars($faculty['department']) ?>" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($faculty['email']) ?>" required><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
