<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = ''; // For success/error messages

if ($student_id <= 0) {
    $message = "Invalid student ID.";
} else {
    // Fetch current student data
    $sql = "SELECT s.*, c.course_name FROM students s LEFT JOIN courses c ON s.course_id = c.id WHERE s.id = " . $conn->real_escape_string($student_id);
    $result = $conn->query($sql);
    
    if ($result->num_rows === 0) {
        $message = "Student not found.";
    } else {
        $student = $result->fetch_assoc();
        
        // Handle form submission (update)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $conn->real_escape_string($_POST['name']);
            $age = intval($_POST['age']);
            $course_id = intval($_POST['course_id']);
            $year_level = intval($_POST['year_level']);
            $student_id_field = $conn->real_escape_string($_POST['student_id']); // The unique student_id field
            
            $update_sql = "UPDATE students SET 
                           student_id = '$student_id_field', 
                           name = '$name', 
                           age = $age, 
                           course_id = $course_id, 
                           year_level = $year_level 
                           WHERE id = $student_id";
            
            if ($conn->query($update_sql)) {
                $message = "Student updated successfully.";
                // Refresh the student data after update
                $sql = "SELECT s.*, c.course_name FROM students s LEFT JOIN courses c ON s.course_id = c.id WHERE s.id = " . $conn->real_escape_string($student_id);
                $result = $conn->query($sql);
                $student = $result->fetch_assoc();
            } else {
                $message = "Error updating student: " . $conn->error;
            }
        }
    }
}

// Fetch all courses for the dropdown
$courses_sql = "SELECT id, course_name FROM courses ORDER BY course_name";
$courses_result = $conn->query($courses_sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>
    <h2>Edit Student</h2>
    <?php if ($message): ?>
        <p style="color: <?php echo strpos($message, 'Error') !== false || strpos($message, 'Invalid') !== false ? 'red' : 'green'; ?>;">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>
    
    <?php if (isset($student) && $message !== "Student not found."): ?>
    <form method="POST">
        <table border="1" cellpadding="10">
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Student ID:</td>
                <td><input type="text" name="student_id" value="<?= htmlspecialchars($student['student_id']) ?>" required /></td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required /></td>
            </tr>
            <tr>
                <td>Age:</td>
                <td><input type="number" name="age" value="<?= htmlspecialchars($student['age']) ?>" min="16" max="100" /></td>
            </tr>
            <tr>
                <td>Course:</td>
                <td>
                    <select name="course_id" required>
                        <?php while ($course = $courses_result->fetch_assoc()): ?>
                            <option value="<?= $course['id'] ?>" <?= ($student['course_id'] == $course['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($course['course_name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Year Level:</td>
                <td><input type="number" name="year_level" value="<?= htmlspecialchars($student['year_level']) ?>" min="1" max="5" /></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Update Student" />
                    <a href="view_students.php">Back</a>
                </td>
            </tr>
        </table>
    </form>
    <?php else: ?>
        <p><a href="view_students.php">Back to Student List</a></p>
    <?php endif; ?>
</body>
</html>