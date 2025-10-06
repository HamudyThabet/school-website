<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = '';

if ($student_id <= 0) {
    $message = "Invalid student ID.";
} else {
    // Fetch student
    $sql = "SELECT * FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $message = "Student not found.";
    } else {
        $student = $result->fetch_assoc();

        // Handle update
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $student_id_field = $_POST['student_id'];
            $name = $_POST['name'];
            $age = intval($_POST['age']);
            $course_id = intval($_POST['course_id']);
            $year_level = intval($_POST['year_level']);

            $update_sql = "UPDATE students SET student_id = ?, name = ?, age = ?, course_id = ?, year_level = ? WHERE id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("ssiiii", $student_id_field, $name, $age, $course_id, $year_level, $student_id);

            if ($stmt->execute()) {
                header("Location: view_students.php");
                exit;
            } else {
                $message = "Error updating student: " . $stmt->error;
            }
        }
    }
}

// Courses for dropdown
$courses = $conn->query("SELECT id, course_name FROM courses ORDER BY course_name");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
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
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="form-container">
        <h2>Edit Student</h2>
        <?php if ($message): ?>
            <p style="color: red; text-align:center;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <?php if (isset($student)): ?>
        <form method="POST">
            <label>Student ID:</label>
            <input type="text" name="student_id" value="<?= htmlspecialchars($student['student_id']) ?>" required>

            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>

            <label>Age:</label>
            <input type="number" name="age" min="16" max="100" value="<?= htmlspecialchars($student['age']) ?>" required>

            <label>Course:</label>
            <select name="course_id" required>
                <?php while ($row = $courses->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>" <?= ($student['course_id'] == $row['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['course_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label>Year Level:</label>
            <input type="number" name="year_level" value="<?= htmlspecialchars($student['year_level']) ?>" min="1" max="6" required>

            <button type="submit"><i class="fas fa-save"></i> Update Student</button>
        </form>
        <a href="view_students.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Student List</a>
        <?php else: ?>
            <a href="view_students.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Student List</a>
        <?php endif; ?>
    </div>
</body>
</html>
