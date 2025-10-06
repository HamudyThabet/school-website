<?php 
include "db.php";
$sql = "SELECT * FROM courses";
$result = $conn->query($sql);

include "head.php"; 
?>
<section class="hero" style="background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.5)), url('https://www.shutterstock.com/image-photo/blurred-background-vibrant-modern-university-600nw-2550498515.jpg') center center / cover no-repeat;">
  <div class="overlay"></div>
  <h1>What we offer at Greenfield Institute of Technology</h1>
</section>

<section id="courses" style="background: url('https://img.freepik.com/free-photo/sunset-background-pastel-sky_53876-129041.jpg?semt=ais_hybrid&w=740&q=80') center center / cover no-repeat;">
  <div class="container" style="background: rgba(255, 255, 255, 0.9); padding: 20px; border-radius: 10px;">
    
    <div class="section-title">
      <h2>Courses Offered</h2>
    </div>
    
    <div class="grid">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <a href="studentRegist.php?course=<?= urlencode($row['course_name']) ?>" class="card">
            <div class="card-body">
              <h3><?= htmlspecialchars($row['course_name']) ?></h3>
              <p><?= htmlspecialchars($row['description']) ?></p>
            </div>
          </a>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="text-align:center;">No courses available right now.</p>
      <?php endif; ?>
    </div>
    
  </div>
</section>

<?php include "foot.php"; ?>
