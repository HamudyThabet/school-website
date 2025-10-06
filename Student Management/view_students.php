<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

$sql = "SELECT s.*, c.course_name
        FROM students s
        LEFT JOIN courses c ON s.course_id = c.id";
$result = $conn->query($sql);

include "../admin_header.php";
?>

<style>
    body.student-view-page {
        background: url('https://epe.brightspotcdn.com/53/66/b17323e84e668e02e25d5b4a7a93/teacher-students-classroom.jpg') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
        position: relative;
    }

    body.student-view-page .student-page::before {
        content: "";
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
        z-index: 0;
    }

    body.student-view-page .student-page {
        position: relative;
        z-index: 1;
        padding-top: 100px;
        padding-bottom: 60px;
        min-height: 100vh;
    }

    body.student-view-page .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background-color: #4CAF50;
        color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
        position: relative;
        z-index: 2;
    }

    body.student-view-page .container  {
        color: white !important;
    }

    body.student-view-page h2 {
        font-size: 2em;
        margin-bottom: 20px;
    }

    body.student-view-page .nav-links2 {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    body.student-view-page .nav-links2 a {
        color: white;
        text-decoration: none;
        padding: 8px 16px;
        border: 1px solid white;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    body.student-view-page .nav-links2 a:hover {
        background-color: white;
        color: #4CAF50;
    }

    body.student-view-page table {
        width: 100%;
        border-collapse: collapse;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    body.student-view-page th, 
    body.student-view-page td {
        padding: 12px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    body.student-view-page th {
        background-color: rgba(255, 255, 255, 0.2);
        font-weight: bold;
    }

    body.student-view-page tr:nth-child(even) {
        background-color: rgba(255, 255, 255, 0.05);
    }

    body.student-view-page tr:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    body.student-view-page .actions a {
        color: white;
        text-decoration: none;
        margin: 0 5px;
        padding: 5px 10px;
        border: 1px solid white;
        border-radius: 3px;
        transition: all 0.3s ease;
    }

    body.student-view-page .actions a:hover {
        background-color: white;
        color: #4CAF50;
    }

    body.student-view-page .delete-link {
        color: #ffcccc;
        border: 1px solid #ffcccc;
    }

    body.student-view-page .delete-link:hover {
        background-color: #ffcccc;
        color: #4CAF50;
    }

    @media (max-width: 768px) {
        body.student-view-page .container {
            padding: 10px;
            margin: 10px;
            max-width: 100%;
        }

        body.student-view-page table {
            font-size: 0.9em;
        }

        body.student-view-page th, 
        body.student-view-page td {
            padding: 8px;
        }
    }
</style>

<script>
    document.body.classList.add('student-view-page');
</script>

<div class="student-page">
    <div class="container">
        <h2>Student List</h2>

        <div class="nav-links2">
            <a href="add_students.php">Add Student</a>
            <a href="../Admin System/admin_dashboard.php">Back to Dashboard</a>
        </div>

        <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Course</th>
                <th>Year Level</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['student_id']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= $row['age'] ?? 'N/A' ?></td>
                <td><?= htmlspecialchars($row['course_name'] ?? 'No Course') ?></td>
                <td><?= $row['year_level'] ?? 'N/A' ?></td>
                <td class="actions">
                    <a href="edit_students.php?id=<?= $row['id'] ?>">Edit</a>
                    <a href="delete_students.php?id=<?= $row['id'] ?>" class="delete-link" onclick="return confirm('Delete this student?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
            <p>No students found. <a href="add_students.php" style="color:#90EE90; text-decoration:underline;">Add one</a>.</p>
        <?php endif; ?>
    </div>
</div>
        </div>
<?php include "../admin_footer.php"; ?>
