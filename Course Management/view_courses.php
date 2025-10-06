<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "../db.php";

$sql = "SELECT * FROM courses ORDER BY id DESC";
$result = $conn->query($sql);

include "../admin_header.php";
?>


<style>
    body.course-view-page {
        background: url('https://www.shutterstock.com/shutterstock/videos/1031819273/thumb/4.jpg?ip=x480') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
        position: relative;
    }

    body.course-view-page .course-page::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
        z-index: 0;
    }

    body.course-view-page .course-page {
        position: relative;
        z-index: 1;
        padding-top: 100px;
        padding-bottom: 60px;
        min-height: 100vh;
    }

    body.course-view-page .container {
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

    body.course-view-page .container {
        color: white !important;
    }

    body.course-view-page h2 {
        font-size: 2em;
        margin-bottom: 20px;
    }

    body.course-view-page .nav-links2 {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    body.course-view-page .nav-links2 a {
        color: white;
        text-decoration: none;
        padding: 8px 16px;
        border: 1px solid white;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    body.course-view-page .nav-links2 a:hover {
        background-color: white;
        color: #4CAF50;
    }

    body.course-view-page table {
        width: 100%;
        border-collapse: collapse;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    body.course-view-page th,
    body.course-view-page td {
        padding: 12px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    body.course-view-page th {
        background-color: rgba(255, 255, 255, 0.2);
        font-weight: bold;
    }

    body.course-view-page tr:nth-child(even) {
        background-color: rgba(255, 255, 255, 0.05);
    }

    body.course-view-page tr:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    body.course-view-page .actions a {
        color: white;
        text-decoration: none;
        margin: 0 5px;
        padding: 5px 10px;
        border: 1px solid white;
        border-radius: 3px;
        transition: all 0.3s ease;
    }

    body.course-view-page .actions a:hover {
        background-color: white;
        color: #4CAF50;
    }

    body.course-view-page .delete-link {
        color: #ffcccc;
        border: 1px solid #ffcccc;
    }

    body.course-view-page .delete-link:hover {
        background-color: #ffcccc;
        color: #4CAF50;
    }

    @media (max-width: 768px) {
        body.course-view-page .container {
            padding: 10px;
            margin: 10px;
            max-width: 100%;
        }

        body.course-view-page table {
            font-size: 0.9em;
        }

        body.course-view-page th,
        body.course-view-page td {
            padding: 8px;
        }
    }
</style>

<script>
    document.body.classList.add('course-view-page');
</script>

<div class="course-page">
    <div class="container">

        <h2>Courses</h2>

        <div class="nav-links2">
            <a href="add_course.php">Add New Course</a>
            <a href="../Admin System/admin_dashboard.php">Back to Dashboard</a>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['course_name']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td class="actions">
                            <a href="edit_course.php?id=<?= $row['id'] ?>">Edit</a>
                            <a href="delete_course.php?id=<?= $row['id'] ?>" class="delete-link" onclick="return confirm('Delete this course?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No courses found. <a href="add_course.php" style="color:#90EE90; text-decoration:underline;">Add one</a>.</p>
        <?php endif; ?>
    </div>
</div>
</div>
<?php if (isset($_GET['msg'])): ?>
<script>
    confirm("<?= htmlspecialchars($_GET['msg']) ?>");
</script>
<?php endif; ?>

<?php include "../admin_footer.php"; ?>