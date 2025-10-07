<?php include "head.php"; ?>

<style>
/* --- ABOUT SECTION --- */
.about-section {
    position: relative;
    width: 100%;
    min-height: 100vh; /* allow it to expand beyond viewport */
    background: url('campus.jpg') center center / cover no-repeat fixed;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 100px 20px;
    color: #fff;
    overflow: hidden;
    animation: bgZoom 25s ease-in-out infinite alternate;
}

@keyframes bgZoom {
    0% { transform: scale(1); }
    100% { transform: scale(1.07); }
}

.about-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom right, rgba(0,0,0,0.7), rgba(0,50,80,0.6));
    z-index: 1;
    backdrop-filter: blur(3px);
}

.about-content {
    position: relative;
    z-index: 2;
    max-width: 1000px;
    background: rgba(0, 0, 0, 0.45);
    padding: 60px 50px;
    border-radius: 20px;
    box-shadow: 0 0 25px rgba(0,0,0,0.5);
    transition: all 1s ease;
    margin-bottom: 80px;
}

/* Animation */
.about-content h2,
.about-content h3,
.about-content p {
    opacity: 0;
    transform: translateY(40px);
    transition: all 1s ease;
}

.about-content.show h2 { opacity: 1; transform: translateY(0); transition-delay: 0.2s; }
.about-content.show h3, 
.about-content.show p { opacity: 1; transform: translateY(0); transition-delay: 0.4s; }

.about-content h2 {
    font-size: clamp(2rem, 4vw, 3.5rem);
    color: #00ffc6;
    text-shadow: 0 0 15px rgba(0,255,198,0.6);
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 30px;
    font-weight: 800;
    text-align: center;
}

.about-content h3 {
    font-size: 1.8em;
    color: #00e5b0;
    margin-top: 40px;
    margin-bottom: 10px;
    font-weight: 700;
    text-align: left;
}

.about-content p {
    font-size: 1.15em;
    color: #f5f5f5;
    line-height: 1.9;
    margin-bottom: 15px;
    text-align: justify;
}

/* Glowing border */
.about-content::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 20px;
    padding: 2px;
    background: linear-gradient(45deg, #00ffc6, #00796b, #00ffc6);
    -webkit-mask: 
        linear-gradient(#fff 0 0) content-box, 
        linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    animation: borderGlow 5s linear infinite;
}

@keyframes borderGlow {
    0% { filter: hue-rotate(0deg); }
    100% { filter: hue-rotate(360deg); }
}

@media (max-width: 768px) {
    .about-content {
        padding: 30px 20px;
    }
    .about-content h2 {
        font-size: 2rem;
    }
}
</style>

<div class="about-section">
  <div class="about-overlay"></div>
  <div class="about-content" id="aboutContent">
    <h2>About Greenfield Institute of Technology</h2>

    <h3>Our History</h3>
    <p>
      Established in 2001 by visionary educator <strong>Hamud Habibi</strong>, the Greenfield Institute of Technology (GIT) began as a small
      computer training center with a single goal — to bring the power of digital literacy and innovation to every Filipino student.
      Over the years, GIT has evolved into a recognized academic institution, producing graduates who now lead in the fields of
      information technology, business, and engineering. The institute’s growth reflects its founder’s belief that education
      is the cornerstone of national progress.
    </p>

    <h3>Vision</h3>
    <p>
      To be a <strong>globally respected center of excellence</strong> in technology, innovation, and entrepreneurship —
      empowering students to transform ideas into solutions that make a difference in society.
    </p>

    <h3>Mission</h3>
    <p>
      GIT is committed to <strong>nurturing competent, ethical, and future-ready professionals</strong> through quality education,
      research, and community involvement. We aim to provide a dynamic learning environment that blends academic rigor
      with real-world experience, preparing our students for the demands of a rapidly evolving digital world.
    </p>

    <h3>Core Values</h3>
    <p>
      <strong>Integrity.</strong> We uphold honesty, transparency, and accountability in everything we do.<br>
      <strong>Innovation.</strong> We foster curiosity, creativity, and a growth mindset in our students and staff.<br>
      <strong>Excellence.</strong> We strive to achieve the highest standards in education, research, and service.<br>
      <strong>Collaboration.</strong> We believe that progress is best achieved through teamwork and shared purpose.
    </p>

    <h3>Academic Philosophy</h3>
    <p>
      At GIT, education extends beyond classrooms. Our programs combine theory with hands-on application through projects,
      research, and industry partnerships. We believe in continuous learning — where students don’t just consume knowledge,
      but create and apply it. Through innovation hubs, hackathons, and internships, our learners gain the confidence to lead
      in a global, technology-driven future.
    </p>

    <h3>Community & Innovation</h3>
    <p>
      GIT is more than a school — it’s a community of thinkers, creators, and changemakers. From environmental initiatives to
      digital literacy outreach programs, we actively engage with local communities to promote sustainable development and
      inclusive progress. Every GITizen is encouraged to dream boldly, act ethically, and innovate responsibly.
    </p>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const aboutContent = document.getElementById("aboutContent");
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        aboutContent.classList.add("show");
      }
    });
  }, { threshold: 0.2 });
  observer.observe(aboutContent);
});
</script>

<?php include "foot.php"; ?>
