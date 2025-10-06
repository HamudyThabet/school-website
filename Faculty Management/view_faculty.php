<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "db.php";

$message = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : '';

$sql = "SELECT * FROM faculty ORDER BY name";
$result = $conn->query($sql);

include "../admin_header.php";
?>

<style>
    body.faculty-view-page {
        background: url('https://media.istockphoto.com/id/517188688/photo/mountain-landscape.jpg?s=612x612&w=0&k=20&c=A63koPKaCyIwQWOTFBRWXj_PwCrR4cEoOw2S9Q7yVl8=') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
        position: relative;
    }

    body.faculty-view-page .faculty-page::before {
        content: "";
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
        z-index: 0;
    }

    body.faculty-view-page .faculty-page {
        position: relative;
        z-index: 1;
        padding-top: 100px;
        padding-bottom: 60px;
        min-height: 100vh;
    }

    body.faculty-view-page .container {
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

    body.faculty-view-page .container {
        color: white !important;
    }

    body.faculty-view-page h2 {
        font-size: 2em;
        margin-bottom: 20px;
    }

    body.faculty-view-page .nav-links2 {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    body.faculty-view-page .nav-links2 a {
        color: white;
        text-decoration: none;
        padding: 8px 16px;
        border: 1px solid white;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    body.faculty-view-page .nav-links2 a:hover {
        background-color: white;
        color: #4CAF50;
    }

    body.faculty-view-page table {
        width: 100%;
        border-collapse: collapse;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    body.faculty-view-page th, 
    body.faculty-view-page td {
        padding: 12px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    body.faculty-view-page th {
        background-color: rgba(255, 255, 255, 0.2);
        font-weight: bold;
    }

    body.faculty-view-page tr:nth-child(even) {
        background-color: rgba(255, 255, 255, 0.05);
    }

    body.faculty-view-page tr:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    body.faculty-view-page img {
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.2s ease;
    }

    body.faculty-view-page img:hover {
        transform: scale(1.05);
    }

    body.faculty-view-page .no-image {
        font-style: italic;
        opacity: 0.8;
    }

    body.faculty-view-page .actions a {
        color: white;
        text-decoration: none;
        margin: 0 5px;
        padding: 5px 10px;
        border: 1px solid white;
        border-radius: 3px;
        transition: all 0.3s ease;
    }

    body.faculty-view-page .actions a:hover {
        background-color: white;
        color: #4CAF50;
    }

    body.faculty-view-page .delete-link {
        color: #ffcccc;
        border: 1px solid #ffcccc;
    }

    body.faculty-view-page .delete-link:hover {
        background-color: #ffcccc;
        color: #4CAF50;
    }

    @media (max-width: 768px) {
        body.faculty-view-page .container {
            padding: 10px;
            margin: 10px;
            max-width: 100%;
        }

        body.faculty-view-page table {
            font-size: 0.9em;
        }

        body.faculty-view-page th, 
        body.faculty-view-page td {
            padding: 8px;
        }

        body.faculty-view-page img {
            width: 60px;
            height: 60px;
        }
    }
</style>

<script>
    document.body.classList.add('faculty-view-page');
</script>

<div class="faculty-page">
    <div class="container">
        <h2>Faculty List</h2>
        <?php if ($message): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>

        <div class="nav-links2">
            <a href="add_faculty.php">Add New Faculty</a>
            <a href="../Admin System/admin_dashboard.php">Back to Dashboard</a>
        </div>

        <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Specialization</th>
                <th>Contact</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td>
                    <?php if (!empty($row['photo_path'])): ?>
                        <?php 
                            $imgPath = (strpos($row['photo_path'], '../Faculty Management/uploads/') === 0) 
                                ? $row['photo_path'] 
                                : '../Faculty Management/uploads/' . $row['photo_path'];
                        ?>
                        <img src="<?= htmlspecialchars($imgPath) ?>" alt="Faculty Photo" width="100" height="100" />
                    <?php else: ?>
                        <span class="no-image">No Image</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['specialization'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($row['contact'] ?? 'N/A') ?></td>
                <td class="actions">
                    <a href="edit_faculty.php?id=<?= $row['id'] ?>">Edit</a>
                    <a href="delete_faculty.php?id=<?= $row['id'] ?>" class="delete-link" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
            <p class="no-faculty">No faculty found. <a href="add_faculty.php">Add one</a>.</p>
        <?php endif; ?>
    </div>
</div>
        </div>
<?php include "../admin_footer.php"; ?>
