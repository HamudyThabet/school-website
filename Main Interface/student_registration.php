<?php
require_once "db.php";

$message = ''; // For success/error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $conn->real_escape_string($_POST['student_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $age = intval($_POST['age']);
    $course_id = intval($_POST['course_id']);
    $year_level = intval($_POST['year_level']);
    
    // Basic validation
    if (empty($student_id) || empty($name) || $age < 16 || $course_id <= 0 || $year_level < 1 || $year_level > 5) {
        $message = "Please fill all required fields correctly. Age must be 16+, Year Level 1-5.";
    } else {
        $sql = "INSERT INTO students (student_id, name, age, course_id, year_level) 
                VALUES ('$student_id', '$name', $age, $course_id, $year_level)";
        
        if ($conn->query($sql)) {
            $message = "Registration successful!";
        } else {
            $message = "Error registering: " . $conn->error . " (Student ID might already exist.)";
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
    <title>Student Registration</title>
</head>
<body>
    <h2>Student Registration Form</h2>
    <?php if ($message): ?>
        <p style="color: <?php echo strpos($message, 'Error') !== false || strpos($message, 'Please') !== false ? 'red' : 'green'; ?>;">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>
    
    <form method="POST">
        <table border="1" cellpadding="10">
            <tr>
                <th>Student ID (e.g., 2025-001):</th>
                <td><input type="text" name="student_id" required /></td>
            </tr>
            <tr>
                <th>Name:</th>
                <td><input type="text" name="name" required /></td>
            </tr>
            <tr>
                <th>Age:</th>
                <td><input type="number" name="age" min="16" max="100" required /></td>
            </tr>
            <tr>
                <th>Course:</th>
                <td>
                    <select name="course_id" required>
                        <option value="">Select Course</option>
                        <?php if ($courses_result && $courses_result->num_rows > 0): ?>
                            <?php while ($course = $courses_result->fetch_assoc()): ?>
                                <option value="<?= $course['id'] ?>">
                                    <?= htmlspecialchars($course['course_name']) ?>
                                </option>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <option value="">No courses available</option>
                        <?php endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Year Level:</th>
                <td><input type="number" name="year_level" min="1" max="5" required /></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Register" />
                </td>
            </tr>
        </table>
    </form>
    <p><a href="index.php">Home</a> | <a href="login.php">Admin Login</a></p>
</body>
</html>