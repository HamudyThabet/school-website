<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $specialization = $conn->real_escape_string($_POST['specialization']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $photo_path = null;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_result = uploadFacultyPhoto($_FILES['photo'], 0);
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
            $message = "Faculty added successfully.";
            header('Location: view_faculty.php?msg=' . urlencode($message));
            exit();
        } else {
            $message = "Error adding faculty: " . $conn->error;
            if ($photo_path && file_exists($photo_path)) unlink($photo_path);
        }
    }
}

function uploadFacultyPhoto($file, $faculty_id = 0) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 2 * 1024 * 1024;

    if ($file['error'] !== UPLOAD_ERR_OK) return false;
    if (!in_array($file['type'], $allowed_types) || $file['size'] > $max_size) return false;

    $upload_dir = __DIR__ . '/../Faculty Management/uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'faculty_' . time() . '_' . uniqid() . '.' . $ext;
    $destination = $upload_dir . $filename;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return '../Faculty Management/uploads/' . $filename;
    }

    return false;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Faculty</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('https://images.theconversation.com/files/369533/original/file-20201116-13-yae7w.jpg?ixlib=rb-4.1.0&rect=0%2C113%2C4000%2C2000&q=50&auto=format&w=1336&h=668&fit=crop&dpr=2') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .overlay {
            background-color: rgba(0, 100, 0, 0.6);
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 0;
        }

        .form-container {
            position: relative;
            z-index: 1;
            max-width: 600px;
            margin: 100px auto;
            background-color: #ffffffdd;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            color: #2e7d32;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
        }

        th {
            text-align: left;
            padding-bottom: 10px;
            color: #2e7d32;
        }

        td {
            padding-bottom: 20px;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #388e3c;
        }

        .cancel-link,
        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #2e7d32;
            text-decoration: none;
            font-weight: bold;
        }

        .cancel-link:hover,
        .back-link:hover {
            text-decoration: underline;
        }

        p.message {
            text-align: center;
            color: red;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .form-container {
                margin: 50px 20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="form-container">
        <h2>Add New Faculty</h2>
        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <table>
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
                    <th>Photo:</th>
                    <td><input type="file" name="photo" accept="image/*" required /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Add Faculty" />
                    </td>
                </tr>
            </table>
        </form>
        <a href="view_faculty.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Faculty List</a>
    </div>
</body>
</html>
