<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $course_id = $_POST['course_id'];
    $year_level = $_POST['year_level'];

    $sql = "INSERT INTO students (student_id, name, age, course_id, year_level) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiii", $student_id, $name, $age, $course_id, $year_level);

    if ($stmt->execute()) {
        header("Location: view_students.php");
        exit;
    } else {
        echo "Error adding student: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('https://cdn.i-scmp.com/sites/default/files/styles/1200x800/public/d8/images/canvas/2023/08/02/698850e2-8f70-48b6-9024-cfab791fcdba_aeee3702.jpg?itok=BURF_kQi&v=1690979975') no-repeat center center fixed;
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

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #2e7d32;
        }

        input, select {
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
        <h2>Add Student</h2>
        <form method="POST">
            <label>Student ID:</label>
            <input type="text" name="student_id" placeholder="e.g. 2025-001" required>

            <label>Name:</label>
            <input type="text" name="name" required>

            <label>Age:</label>
            <input type="number" name="age" required>

            <label>Course:</label>
            <select name="course_id" required>
                <?php
                $courses = $conn->query("SELECT id, course_name FROM courses");
                while ($row = $courses->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['course_name'] . "</option>";
                }
                ?>
            </select>

            <label>Year Level:</label>
            <input type="number" name="year_level" min="1" max="6" required>

            <button type="submit"><i class="fas fa-plus-circle"></i> Add Student</button>
        </form>
        <a href="view_students.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Student List</a>
    </div>
</body>
</html>
