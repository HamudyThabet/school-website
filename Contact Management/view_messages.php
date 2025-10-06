<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../Admin System/login.php');
    exit();
}
require_once "../db.php";

// Fetch messages
$sql = "SELECT id, name, email, message, submitted_at FROM contacts ORDER BY submitted_at DESC";
$result = $conn->query($sql);

include "../admin_header.php";
?>

<style>
    body.messages-view-page {
        background: url('https://img.freepik.com/free-photo/green-mailbox-with-letter-near-road_23-2148757503.jpg') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
        position: relative;
    }

    body.messages-view-page .messages-page::before {
        content: "";
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
        z-index: 0;
    }

    body.messages-view-page .messages-page {
        position: relative;
        z-index: 1;
        padding-top: 100px;
        padding-bottom: 60px;
        min-height: 100vh;
    }

    body.messages-view-page .container {
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

    body.messages-view-page h2 {
        font-size: 2em;
        margin-bottom: 20px;
    }

    body.messages-view-page .nav-links2 {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    body.messages-view-page .nav-links2 a {
        color: white;
        text-decoration: none;
        padding: 8px 16px;
        border: 1px solid white;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    body.messages-view-page .nav-links2 a:hover {
        background-color: white;
        color: #4CAF50;
    }

    body.messages-view-page table {
        width: 100%;
        border-collapse: collapse;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    body.messages-view-page th, 
    body.messages-view-page td {
        padding: 12px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    body.messages-view-page th {
        background-color: rgba(255, 255, 255, 0.2);
        font-weight: bold;
    }

    body.messages-view-page tr:nth-child(even) {
        background-color: rgba(255, 255, 255, 0.05);
    }

    body.messages-view-page tr:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    body.messages-view-page td.message-cell {
        text-align: left;
        white-space: pre-line;
    }

    @media (max-width: 768px) {
        body.messages-view-page .container {
            padding: 10px;
            margin: 10px;
            max-width: 100%;
        }

        body.messages-view-page table {
            font-size: 0.9em;
        }

        body.messages-view-page th, 
        body.messages-view-page td {
            padding: 8px;
        }
    }
</style>

<script>
    document.body.classList.add('messages-view-page');
</script>

<div class="messages-page">
    <div class="container">
        <h2>Inbox</h2>

        <div class="nav-links2">
            <a href="../Admin System/admin_dashboard.php">Back to Dashboard</a>
        </div>

        <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td class="message-cell"><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                <td><?= $row['submitted_at'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
            <p>No messages found.</p>
        <?php endif; ?>
    </div>
</div>
