<?php include "head.php"; ?>

<style>
.about-section {
    position: relative;
    width: 100%;
    height: 100vh;
    background: url('campus.jpg') no-repeat center center/cover; 
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: white;
    overflow: hidden;
}

.about-overlay {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.55); 
    z-index: 1;
}

.about-content {
    position: relative;
    z-index: 2;
    max-width: 900px;
    padding: 20px;
    text-align: center;
}

.about-content h2, 
.about-content p {
    opacity: 0;
    transform: translateY(40px);
    transition: all 0.8s ease;
}

.about-content.show h2 {
    opacity: 1;
    transform: translateY(0);
    transition-delay: 0.1s;
}

.about-content.show p:nth-child(2) { transition-delay: 0.5s; opacity: 1; transform: translateY(0); }
.about-content.show p:nth-child(3) { transition-delay: 0.8s; opacity: 1; transform: translateY(0); }
.about-content.show p:nth-child(4) { transition-delay: 1.1s; opacity: 1; transform: translateY(0); }
.about-content.show p:nth-child(5) { transition-delay: 1.4s; opacity: 1; transform: translateY(0); }

.about-content h2 {
    font-size: 3.2em;
    margin-bottom: 25px;
    font-weight: bold;
    letter-spacing: 1px;
}

.about-content p {
    font-size: 1.4em;
    margin: 15px 0;
    line-height: 1.7;
}
</style>

<div class="about-section">
    <div class="about-overlay"></div>
    <div class="about-content" id="aboutContent">
        <h2>About Us</h2>
        <p><strong>History:</strong> Greenfield Institute of Technology was founded in 2001 by Hamud Habibi.</p>
        <p><strong>Vision:</strong> To be a leading institution in IT and business education.</p>
        <p><strong>Mission:</strong> Develop competent and ethical professionals.</p>
        <p><strong>Core Values:</strong> Integrity, Innovation, Excellence.</p>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
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
