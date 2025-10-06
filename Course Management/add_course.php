<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "../db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_name = trim($_POST['course_name']);
    $description = trim($_POST['description']);

    if (!empty($course_name)) {
        $sql = "INSERT INTO courses (course_name, description) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $course_name, $description);

        if ($stmt->execute()) {
            header("Location: view_courses.php");
            exit;
        } else {
            echo "❌ Error adding course: " . $conn->error;
        }
    } else {
        echo "❌ Course name is required!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Course</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('https://www.computersciencedegreehub.com/wp-content/uploads/2023/01/shutterstock_1062915392-scaled.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .overlay {
            background-color: rgba(34, 139, 34, 0.6); /* forest green overlay */
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

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #2e7d32;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1em;
        }

        button {
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

        button:hover {
            background-color: #388e3c;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #2e7d32;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
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
        <h2>Add Course</h2>
        <form method="POST" action="">
            <label>Course Name:</label>
            <input type="text" name="course_name" required>

            <label>Description:</label>
            <textarea name="description" rows="4" required></textarea>

            <button type="submit"><i class="fas fa-plus-circle"></i> Add Course</button>
        </form>
        <a href="view_courses.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Course List</a>
    </div>
</body>
</html>
