<?php
require_once "core/config.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $department = $_POST['department'];
    $email = $_POST['email'];

    $sql = "INSERT INTO faculty (name, department, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $department, $email);

    if ($stmt->execute()) {
        header("Location: view_faculty.php");
        exit;
    } else {
        echo "Error adding faculty.";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Add Faculty</title></head>
<body>
    <h2>Add Faculty</h2>
    <form method="POST">
        <label>Name:</label>
        <input type="text" name="name" required><br><br>

        <label>Department:</label>
        <input type="text" name="department" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" required><br><br>

        <button type="submit">Add</button>
    </form>
</body>
</html>
