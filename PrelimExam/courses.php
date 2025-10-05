<?php 
include "db.php";
$sql = "SELECT * FROM courses";
$result = $conn->query($sql);

include "head.php"; 
?>
<section class="hero" style ="background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.5)), url('https://www.shutterstock.com/image-photo/blurred-background-vibrant-modern-university-600nw-2550498515.jpg') center center / cover no-repeat;">
  <div class="overlay"></div>
  <h1>What we offer at Greenfield Institute of Technology</h1>
</section>
<section id="courses" style="background: url('https://img.freepik.com/free-photo/sunset-background-pastel-sky_53876-129041.jpg?semt=ais_hybrid&w=740&q=80') center center / cover no-repeat;">
  <div class="container" style="background: rgba(255, 255, 255, 0.9); padding: 20px; border-radius: 10px;">
    <div class="section-title">
      <h2>Courses Offered</h2>
    </div>
    <div class="grid">
      <a href="studentRegist.php?course=BSCS" class="card">
        <img src="https://techthatthrills.wordpress.com/wp-content/uploads/2020/08/iron-man.jpg" alt="Computer Science">
        <div class="card-body">
          <h3>BS Computer Science</h3>
          <p>Study software, algorithms, and computing theory.</p>
        </div>
      </a>

      <a href="studentRegist.php?course=BSIT" class="card">
        <img src="https://informatics.njit.edu/sites/informatics/files/styles/16x9/public/cds-business-info-systems.jpg?itok=NRcliJo2" alt="Information Technology">
        <div class="card-body">
          <h3>BS Information Technology</h3>
          <p>Learn about networking, systems, and web technologies.</p>
        </div>
      </a>

      <a href="studentRegist.php?course=BSBA" class="card">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVChagNhtTB5_qX4W859UKY02BhBO5gVUZSFo658-JiSdehYEXdvTqKbEh4_MhJFjA8Ys&usqp=CAU" alt="Business Administration">
        <div class="card-body">
          <h3>BS Business Administration</h3>
          <p>Learn management, finance, and organizational skills.</p>
        </div>
      </a>

      <a href="studentRegist.php?course=BSEE" class="card">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-ZrMtctHjJyEl9TWdcKCW-iibYmLGSA25IQ&s" alt="Electrical Engineering">
        <div class="card-body">
          <h3>BS Electrical Engineering</h3>
          <p>Learn about electrical systems, circuits, and technology.</p>
        </div>
      </a>
    </div><br>
    <div class="section-title">
      <h2>More Details</h2>
    </div>
    <table border="1">
      <tr>
        <th>Course ID</th>
        <th>Course Name</th>
        <th>Course Description</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['course_name'] ?></td>
        <td><?= $row['description'] ?></td>
      </tr>
      <?php } ?>
    </table>
  </div>
</section>
<?php include "foot.php"; ?>
