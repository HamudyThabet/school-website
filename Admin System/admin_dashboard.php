<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once "db.php";

$username = $_SESSION['username'] ?? 'Admin';
$sql = "SELECT username FROM users WHERE id = " . intval($_SESSION['user_id']);
$result = $conn->query($sql);
if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $username = $user['username'];
}

include "../admin_header.php";
?>

<style>
    .hero {
        position: relative;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        background: linear-gradient(rgba(0, 100, 0, 0.4), rgba(0, 100, 0, 0.6)),
                    url('https://www.shutterstock.com/image-photo/blurred-background-vibrant-modern-university-600nw-2550498515.jpg') center center / cover no-repeat;
        color: white;
        overflow: hidden;
    }

    .hero h2 {
        font-size: 2.5em;
        margin-bottom: 20px;
        animation: fadeInDown 1s ease-out;
    }

    .hero p {
        font-size: 1.2em;
        animation: fadeInUp 1.2s ease-out;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .hero h2 {
            font-size: 2em;
        }
        .hero p {
            font-size: 1em;
        }
    }
</style>

<section class="hero">
    <div>
        <h2>Welcome to Admin Dashboard, <?= htmlspecialchars($username) ?>!</h2>
        <p>You are logged in successfully.</p>
    </div>
</section>

<?php include "../admin_footer.php"; ?>
