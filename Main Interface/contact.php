<?php
require_once "db.php";

$message = ''; // Success/error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $msg = $conn->real_escape_string($_POST['message']);
    
    if (empty($name) || empty($email) || empty($msg)) {
        $message = "Please fill all fields.";
    } else {
        // Save to DB
        $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$msg')";
        if ($conn->query($sql)) {
            // Optional: Send email
            $to = 'admin@school.edu'; // Change to your email
            $subject = 'New Contact from ' . $name;
            $body = "Name: $name\nEmail: $email\nMessage: $msg";
            $headers = 'From: ' . $email;
            if (mail($to, $subject, $body, $headers)) {
                $message = "Thank you! Message sent and saved.";
            } else {
                $message = "Saved successfully, but email failed.";
            }
            // Clear form: Redirect or reset
            header('Location: contact.php?success=1');
            exit();
        } else {
            $message = "Error saving: " . $conn->error;
        }
    }
}

$success = isset($_GET['success']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
</head>
<body>
    <h2>Contact Form</h2>
    <?php if ($success): ?>
        <p style="color: green;">Thank you for contacting us!</p>
    <?php elseif ($message): ?>
        <p style="color: red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <table border="1" cellpadding="10">
            <tr>
                <th>Name:</th>
                <td><input type="text" name="name" required /></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><input type="email" name="email" required /></td>
            </tr>
            <tr>
                <th>Message:</th>
                <td><textarea name="message" rows="5" required></textarea></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Send Message" />
                </td>
            </tr>
        </table>
    </form>
    <p><a href="index.php">Home</a></p>
</body>
</html>