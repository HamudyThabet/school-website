<?php
require "db.php";
$courses_result = $conn->query("SELECT * FROM courses");

$sql = "SELECT s.*, c.course_name
        FROM students s
        LEFT JOIN courses c ON s.course_id = c.id";
$result = $conn->query($sql);

$showSuccess = false; // ✅ Flag to trigger popup

if (isset($_POST['add_student'])) {
    $student_id = $conn->real_escape_string($_POST['student_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $age = intval($_POST['age']);
    $course_id = $conn->real_escape_string($_POST['course_id']);
    $year_level = intval($_POST['year_level']);

    $sql_insert = "INSERT INTO students (student_id, name, age, course_id, year_level) 
                   VALUES ('$student_id', '$name', $age, '$course_id', $year_level)";

    if ($conn->query($sql_insert) === TRUE) {
        $showSuccess = true; // ✅ Mark success
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}

include "head.php";
?>

<section class="hero" style ="background: url('https://media.craiyon.com/2025-08-19/xObSp9jqSu27BohHHqTG_w.webp') center center / cover no-repeat;">
  <div class="overlay"></div>
  <h1>Welcome, GITizens! Let’s innovate and grow together!</h1>
</section>

<section id="courses" style ="background: url('https://images.unsplash.com/photo-1712397943847-e104395a1a8b?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTV8fGRhcmslMjBibHVlJTIwYWVzdGhldGljfGVufDB8fDB8fHww') center center / cover no-repeat;">

<section class="contact-form" style="margin-top: 0; display: flex; flex-direction: column; align-items: center; gap: 20px; background: url('https://wallpapers.com/images/hd/aesthetic-desktop-city-a56svyv07wefmq5y.jpg') center center / cover no-repeat;" >
  <section id="faq" style="padding: 60px 20px; max-width: 900px; margin: 0 auto; background: rgba(255, 255, 255, 0.9); border-radius: 10px;">
    <div class="section-title" style="text-align: center; margin-bottom: 40px;">
      <h2>Register Now at GIT</h2>
    </div>

    <form method="post" style="display: flex; flex-direction: column; max-width: 500px; gap: 10px; margin: 0 auto;">
      <input type="text" name="student_id" placeholder="Student ID (e.g., 2025-001)" required style="padding: 8px; border-radius: 5px; border: 1px solid #ccc;">
      <input type="text" name="name" placeholder="Full Name" required style="padding: 8px; border-radius: 5px; border: 1px solid #ccc;">
      <input type="number" name="age" placeholder="Age" min="16" max="100" required style="padding: 8px; border-radius: 5px; border: 1px solid #ccc;">

      <label>Course</label>
      <select name="course_id" required style="padding: 8px; border-radius: 5px; border: 1px solid #ccc;">
        <option value="" disabled selected>Select a course</option>
        <?php while($course = $courses_result->fetch_assoc()) { ?>
            <option value="<?= $course['id'] ?>"><?= $course['course_name'] ?></option>
        <?php } ?>
      </select>

      <input type="number" name="year_level" placeholder="Year Level" min="1" max="6" required style="padding: 8px; border-radius: 5px; border: 1px solid #ccc;">

      <div style="background: #f9f9f9; border: 1px solid #ccc; padding: 10px; border-radius: 5px; font-size: 0.9em; color: #333;">
        <p style="margin-bottom: 8px; text-align: justify;">
          <strong>Data Privacy Notice:</strong> By submitting this form, you consent to the collection and processing 
          of your personal data by GIT for enrollment and academic purposes, in accordance with the 
          Data Privacy Act of 2012 (Republic Act No. 10173). Your information will be kept confidential 
          and used only for legitimate institutional activities.
        </p>
        <label style="display: flex; align-items: center; gap: 8px;">
          <input type="checkbox" required>
          I have read and agree to the Data Privacy Notice.
        </label>
      </div>

      <button type="submit" name="add_student" style="padding: 10px; background-color: #00796b; color: #fff; border: none; border-radius: 5px; font-weight: bold;">Add Student</button>
    </form>
  </section>
</section>

<?php include "foot.php"; ?>

<?php if ($showSuccess): ?>
  <script>
    alert("Registration Successful! Welcome to GIT!");
    window.location.href = window.location.href;
  </script>
<?php endif; ?>
