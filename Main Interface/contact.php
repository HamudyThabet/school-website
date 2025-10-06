<?php
include "head.php";
require_once "db.php";

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $msg = $conn->real_escape_string($_POST['message']);

  if (empty($name) || empty($email) || empty($msg)) {
    $message = "Please fill all fields.";
  } else {
    $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$msg')";
    if ($conn->query($sql)) {
      // Send optional email
      $to = 'admin@school.edu';
      $subject = 'New Contact from ' . $name;
      $body = "Name: $name\nEmail: $email\nMessage: $msg";
      $headers = 'From: ' . $email;

      if (mail($to, $subject, $body, $headers)) {
        $message = "Thank you! Message sent and saved.";
      } else {
        $message = "Saved successfully, but email failed.";
      }

      header('Location: contact.php?success=1');
      exit();
    } else {
      $message = "Error saving: " . $conn->error;
    }
  }
}
$success = isset($_GET['success']);
?>

<!-- Hero Section -->
<section class="hero" style="background: url('https://www.shutterstock.com/image-photo/blurred-background-urban-landscape-modern-260nw-2580056531.jpg') center center / cover no-repeat;">
  <div class="overlay"></div>
  <h1>Have a question? Our team at GIT is here to help and guide you.</h1>
</section>

<section class="contact-form" style="margin-top: 0; display: flex; flex-direction: column; align-items: center; gap: 20px; background: url('https://wallpapers.com/images/hd/aesthetic-desktop-city-a56svyv07wefmq5y.jpg') center center / cover no-repeat;">
  <section id="faq" style="padding: 60px 20px; max-width: 900px; margin: 0 auto; background: rgba(255, 255, 255, 0.9); border-radius: 10px;">
    <div class="section-title" style="text-align: center; margin-bottom: 40px;">
      <h2>Frequently Asked Questions (FAQ)</h2>
    </div>

    <div class="faq-item">
      <button class="faq-question">
        1. What programs does Greenfield Institute of Technology (GIT) offer?
      </button>
      <div class="faq-answer">
        <p>GIT currently offers undergraduate programs in Computer Science, Information Technology, Business Administration, and Electrical Engineering. Each program is carefully designed to meet industry standards, combining both theoretical knowledge and hands-on experience. Our goal is to prepare students for success in their chosen career paths, whether in technology, research, entrepreneurship, or management.</p>
      </div>
    </div>
    <div class="faq-item"> <button class="faq-question"> 2. How can I apply for admission to GIT? </button>
      <div class="faq-answer">
        <p>Prospective students can apply for admission through our online enrollment system or by visiting the GIT Admissions Office. The application process typically includes:</p>
        <ul class="none">
          <li>Filling out the student registration form</li>
          <li>Submitting required documents (report cards, birth certificate, ID photo, etc.)</li>
          <li>Taking the entrance examination and interview</li>
          <li>Paying the enrollment fee once accepted</li>
        </ul>
        <p>For detailed instructions, visit our Admissions page or contact the Registrar’s Office.</p>
      </div>
    </div>
    <div class="faq-item"> <button class="faq-question"> 3. What are the admission requirements? </button>
      <div class="faq-answer">
        <ul class="none">
          <li>Fully accomplished application form</li>
          <li>Photocopy of high school report card (Form 138)</li>
          <li>Good moral certificate from the previous school</li>
          <li>Photocopy of PSA/NSO Birth Certificate</li>
          <li>Two (2) 2x2 ID pictures</li>
          <li>Entrance exam result and interview slip</li>
          <li>For transfer students, an official transcript of records and honorable dismissal are also required</li>
        </ul>
      </div>
    </div>
    <div class="faq-item"> <button class="faq-question"> 4. Does GIT offer scholarships or financial assistance? </button>
      <div class="faq-answer">
        <p>Yes. GIT offers a variety of scholarship and financial aid programs for qualified students:</p>
        <ul class="none">
          <li>Academic Scholarship for students with outstanding grades</li>
          <li>Leadership Scholarship for student leaders and officers</li>
          <li>Athletic Scholarship for varsity players representing GIT in competitions</li>
          <li>Financial Assistance Programs for students in need, subject to evaluation</li>
        </ul>
        <p>Interested applicants may visit the Scholarship Office for requirements and application schedules.</p>
      </div>
    </div>
    <div class="faq-item"> <button class="faq-question"> 5. How can I contact my professors or the faculty office? </button>
      <div class="faq-answer">
        <p>Faculty members can be contacted through their official GIT email addresses found on the Faculty page of the website. You may also visit the Academic Affairs Office during office hours for faculty consultation or academic-related concerns.</p>
      </div>
    </div>
    <div class="faq-item"> <button class="faq-question"> 6. How does the grading system work? </button>
      <div class="faq-answer">
        <p>GIT uses a percentage-based grading system. Instructors input grades through the Student Information System (SIS), which automatically computes the final grade and determines the student’s remarks:</p>
        <ul class="none">
          <li>75% and above – <span style="color: green; font-weight: bold;">Passed</span></li>
          <li>Below 75% – <span style="color: red; font-weight: bold;">Failed</span></li>
        </ul>
        <p>Grades are recorded securely in the database and can be viewed by both students and administrators through their respective portals.</p>
      </div>
  </section>
</section>

<script>
  const faqButtons = document.querySelectorAll('.faq-question');
  faqButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const answer = btn.nextElementSibling;
      answer.classList.toggle('open');
    });
  });
</script>

<section class="mission">
  <div class="mission-text">
    <h2>Contact Us</h2>
    <p>We value communication and encourage you to reach out to us with your questions, concerns, or feedback. Whether you’re a student, parent, alumni, or visitor, we’re here to assist you.</p>

    <h3>Get in Touch</h3>
    <p>📍 Address: Greenfield Avenue, Philippines</p>
    <p>📞 Phone: +63 (02) 123-4567</p>
    <p>✉️ Email: info@git.edu</p>

    <p>Or simply fill out our contact form with your name, email, and message, and our team will get back to you as soon as possible.</p>
  </div>
  <div class="mission-image" style="flex: 1 1 400px;">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d30838.285853337744!2d120.8907903!3d14.949026250000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sph!4v1759639553006!5m2!1sen!2sph" width="600" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
    </iframe>
  </div>
</section>

<section class="contact-form" style="margin-top: 20px; display: flex; flex-direction: column; align-items: center; gap: 20px; background: url('https://static.vecteezy.com/system/resources/thumbnails/008/195/226/small_2x/abstract-elegant-white-and-gray-background-abstract-white-pattern-squares-texture-vector.jpg') center center / cover no-repeat;">
  <div class="section-title" style="text-align: center; margin-bottom: 40px;">
    <h2>Message Us</h2>
  </div>

  <?php if ($success): ?>
    <p style="color: green; font-weight: bold;">Thank you for contacting us!</p>
  <?php elseif ($message): ?>
    <p style="color: red; font-weight: bold;"><?= htmlspecialchars($message) ?></p>
  <?php endif; ?>

  <form method="post" style="display: flex; flex-direction: column; gap: 15px; width: 100%; max-width: 600px;">
    <label>Name</label>
    <input name="name" required style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">

    <label>Email</label>
    <input type="email" name="email" required style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;">

    <label>Message</label>
    <textarea name="message" rows="6" style="padding: 10px; border-radius: 5px; border: 1px solid #ccc;"></textarea>

    <button type="submit" style="padding: 12px 20px; background-color: #00796b; color: #fff; border: none; border-radius: 5px; font-weight: bold; cursor: pointer;">Send</button>
  </form>
</section>

<?php include "foot.php"; ?>