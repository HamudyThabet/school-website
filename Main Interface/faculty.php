<?php include "head.php"; ?>
<?php require_once "db.php";
$sql = "SELECT * FROM faculty";
$result = $conn->query($sql);
?>

<style>
/* keep your same CSS */
.video-section {
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: hidden;
}
.video-section video {
    position: absolute;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 0;
}
.video-overlay {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.3);
    z-index: 1;
}
.faculty-container {
    position: relative;
    z-index: 2;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    gap: 60px;
    flex-wrap: wrap;
}
.faculty-card {
    width: 260px;
    height: 380px;
    border-radius: 18px;
    overflow: hidden;
    position: relative;
    box-shadow: 0px 6px 12px rgba(0,0,0,0.4);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 4px solid transparent;
    background-clip: padding-box;
    background-size: cover;
    background-position: center;
    color: white;
}
.faculty-card:hover {
    transform: scale(1.08);
    box-shadow: 0px 15px 25px rgba(0,0,0,0.5);
    z-index: 3;
}
.faculty-card::before {
    content: "";
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.4);
    z-index: 1;
}
.faculty-card .info {
    position: absolute;
    bottom: 15px;
    left: 0;
    width: 100%;
    padding: 10px;
    text-align: center;
    z-index: 2;
}
.faculty-card h3, 
.faculty-card p {
    margin: 6px 0;
    color: white;
    text-shadow: 2px 2px 4px black;
    font-weight: bold;
}
.faculty-card:nth-child(3n+1) { border-color: #e74c3c; }
.faculty-card:nth-child(3n+2) { border-color: #27ae60; }
.faculty-card:nth-child(3n+3) { border-color: #2980b9; }
</style>

<div class="video-section">
    <video autoplay muted loop>
        <source src="../Faculty Management/uploads/whitestairs.mp4" type="video/mp4">
    </video>
    <div class="video-overlay"></div>

    <div class="faculty-container">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="faculty-card" style="background-image: url('<?= htmlspecialchars($row['photo_path']) ?>');">
            <div class="info">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <p><?= htmlspecialchars($row['specialization']) ?></p>
                <p>Contact: <?= htmlspecialchars($row['contact']) ?></p>
            </div>
        </div>
    <?php endwhile; ?>
</div>
</div>

<?php include "foot.php"; ?>
