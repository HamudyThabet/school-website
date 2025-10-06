<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

$faculty_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = '';

if ($faculty_id <= 0) {
    $message = "Invalid faculty ID.";
    header('Location: view_faculty.php?msg=' . urlencode($message));
    exit();
}

$sql = "SELECT * FROM faculty WHERE id = " . $conn->real_escape_string($faculty_id);
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    $message = "Faculty not found.";
    header('Location: view_faculty.php?msg=' . urlencode($message));
    exit();
}

$faculty = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $specialization = $conn->real_escape_string($_POST['specialization']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $new_photo_path = $faculty['photo_path'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_result = uploadFacultyPhoto($_FILES['photo'], $faculty_id);
        if ($upload_result) {
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
            if ($new_photo_path && $new_photo_path !== $faculty['photo_path'] && file_exists($new_photo_path)) {
                unlink($new_photo_path);
            }
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
    <title>Edit Faculty</title>
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

        img.preview {
            display: block;
            margin: 10px 0;
            border-radius: 8px;
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
        <h2>Edit Faculty</h2>
        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <table>
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
                    <td><input type="text" name="contact" value="<?= htmlspecialchars($faculty['contact'] ?? '') ?>" required /></td>
                </tr>
                <tr>
                    <th>Current Photo:</th>
                    <td>
                        <?php if ($faculty['photo_path'] && file_exists($faculty['photo_path'])): ?>
                            <img src="<?= htmlspecialchars($faculty['photo_path']) ?>" alt="Current Photo" width="120" height="120" class="preview" />
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
                    </td>
                </tr>
            </table>
        </form>
        <a href="view_faculty.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Faculty List</a>
</body>
</html>
