<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/pagination.php"); ?>
<?php
$head_title = "Blogs – Nuro";
$page_title = "Blogs";
?>

<?php require("./partials/layout/top-layout.php"); ?>

<?php require("./partials/page-title.php"); ?>

<!-- News Section -->
<section class="section py-5 my-5">
  <div class="b-container">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-4">
      <div class="col">
        <div class="card news-card shadow-lg" data-aos="fade-up" data-aos-easing="ease-out-cubic"
          data-aos-delay="250" data-aos-duration="1000">
          <div class="position-relative w-100"
            style="height: 250px;background-image: url('./assets/image/Place-Holder-1920x1280.jpg'); background-size: cover; background-position: center;">
            <div class="position-absolute bg-dark" style="opacity: .1; top: 0; left:0; right: 0; bottom: 0;"></div>
            <div
              class="position-absolute text-white d-flex flex-column justify-content-center align-items-center bg-primary-color"
              style="bottom: 0; left: 0; width: 55px; height: 55px;">
              <h5 class="fw-bolder mb-0">27</h5>
              <small class="mt-0">Mar</small>
            </div>
            <a href="blogs.php"><span class="position-absolute px-2 py-1 text-white rounded-1 bg-primary-color"
                style="top:15px; left: 20px;">Depression</span></a>
          </div>
          <div class="card-body p-4">
            <a href="blog-detail.php" class="card-title">The Role of Self-Care in Reducing Stress
              Levels</a>
            <p class="text-muted-color">This group provides a compassionate and confidential environment where
              individuals can openly discuss their fears, learn healthy coping mechanisms, and understand that they
              are not alone in their struggles with constant worry and unease...</p>
          </div>
        </div>

      </div>

      <div class="col">
        <div class="card news-card shadow-lg" data-aos="fade-up" data-aos-easing="ease-out-cubic"
          data-aos-delay="500" data-aos-duration="1000">
          <div class="position-relative w-100"
            style="height: 250px;background-image: url('./assets/image/Place-Holder-1920x1280.jpg'); background-size: cover; background-position: center;">
            <div class="position-absolute bg-dark" style="opacity: .1; top: 0; left:0; right: 0; bottom: 0;"></div>
            <div
              class="position-absolute text-white d-flex flex-column justify-content-center align-items-center bg-primary-color"
              style="bottom: 0; left: 0; width: 55px; height: 55px;">
              <h5 class="fw-bolder mb-0">17</h5>
              <small class="mt-0">Feb</small>
            </div>
            <a href="blogs.php"><span class="position-absolute px-2 py-1 text-white rounded-1 bg-primary-color"
                style="top:15px; left: 20px;">Anxiety</span></a>
          </div>
          <div class="card-body p-4">
            <a href="blog-detail.php" class="card-title">Simple Steps to Build Emotional Resilience Daily</a>
            <p class="text-muted-color">Through guided conversations and shared stories, members are encouraged to
              reconnect with themselves and others, gradually rebuilding emotional strength, motivation, and hope in
              a space that prioritizes healing and patience...</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card news-card shadow-lg" data-aos="fade-up" data-aos-easing="ease-out-cubic"
          data-aos-delay="750" data-aos-duration="1000">
          <div class="position-relative w-100"
            style="height: 250px;background-image: url('./assets/image/Place-Holder-1920x1280.jpg'); background-size: cover; background-position: center;">
            <div class="position-absolute bg-dark" style="opacity: .1; top: 0; left:0; right: 0; bottom: 0;"></div>
            <div
              class="position-absolute text-white d-flex flex-column justify-content-center align-items-center bg-primary-color"
              style="bottom: 0; left: 0; width: 55px; height: 55px;">
              <h5 class="fw-bolder mb-0">06</h5>
              <small class="mt-0">Jan</small>
            </div>
            <a href="blogs.php"><span class="position-absolute px-2 py-1 text-white rounded-1 bg-primary-color"
                style="top:15px; left: 20px;">Wellness</span></a>
          </div>
          <div class="card-body p-4">
            <a href="blog-detail.php" class="card-title">Signs You Might Need Professional Mental Health
              Support</a>
            <p class="text-muted-color">Participants learn to identify stress triggers and replace negative
              responses with practical, mindful strategies, all while benefiting from the encouragement and
              accountability of a supportive and understanding peer community...</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card news-card shadow-lg" data-aos="fade-up" data-aos-easing="ease-out-cubic"
          data-aos-delay="250" data-aos-duration="1000">
          <div class="position-relative w-100"
            style="height: 250px;background-image: url('./assets/image/Place-Holder-1920x1280.jpg'); background-size: cover; background-position: center;">
            <div class="position-absolute bg-dark" style="opacity: .1; top: 0; left:0; right: 0; bottom: 0;"></div>
            <div
              class="position-absolute text-white d-flex flex-column justify-content-center align-items-center bg-primary-color"
              style="bottom: 0; left: 0; width: 55px; height: 55px;">
              <h5 class="fw-bolder mb-0">06</h5>
              <small class="mt-0">Jan</small>
            </div>
            <a href="blogs.php"><span class="position-absolute px-2 py-1 text-white rounded-1 bg-primary-color"
                style="top:15px; left: 20px;">Mindfulness</span></a>
          </div>
          <div class="card-body p-4">
            <a href="blog-detail.php" class="card-title">Mindfulness Practices to Improve Mental Well-Being</a>
            <p class="text-muted-color">Designed to help individuals navigate the complex emotions that follow a
              loss, this group offers comfort, empathy, and guidance through meaningful dialogue, shared
              remembrance, and connection with others on a similar journey...</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card news-card shadow-lg" data-aos="fade-up" data-aos-easing="ease-out-cubic"
          data-aos-delay="500" data-aos-duration="1000">
          <div class="position-relative w-100"
            style="height: 250px;background-image: url('./assets/image/Place-Holder-1920x1280.jpg'); background-size: cover; background-position: center;">
            <div class="position-absolute bg-dark" style="opacity: .1; top: 0; left:0; right: 0; bottom: 0;"></div>
            <div
              class="position-absolute text-white d-flex flex-column justify-content-center align-items-center bg-primary-color"
              style="bottom: 0; left: 0; width: 55px; height: 55px;">
              <h5 class="fw-bolder mb-0">06</h5>
              <small class="mt-0">Jan</small>
            </div>
            <a href="blogs.php"><span class="position-absolute px-2 py-1 text-white rounded-1 bg-primary-color"
                style="top:15px; left: 20px;">Depression</span></a>
          </div>
          <div class="card-body p-4">
            <a href="blog-detail.php" class="card-title">Effective Strategies to Overcome Negative Thinking
              Patterns</a>
            <p class="text-muted-color">Focusing on personal empowerment and mental flexibility, this group helps
              individuals develop inner strength, regulate emotions, and handle life’s challenges with a renewed
              sense of control and self confidence to a new chapter...</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card news-card shadow-lg" data-aos="fade-up" data-aos-easing="ease-out-cubic"
          data-aos-delay="750" data-aos-duration="1000">
          <div class="position-relative w-100"
            style="height: 250px;background-image: url('./assets/image/Place-Holder-1920x1280.jpg'); background-size: cover; background-position: center;">
            <div class="position-absolute bg-dark" style="opacity: .1; top: 0; left:0; right: 0; bottom: 0;"></div>
            <div
              class="position-absolute text-white d-flex flex-column justify-content-center align-items-center bg-primary-color"
              style="bottom: 0; left: 0; width: 55px; height: 55px;">
              <h5 class="fw-bolder mb-0">06</h5>
              <small class="mt-0">Jan</small>
            </div>
            <a href="blogs.php"><span class="position-absolute px-2 py-1 text-white rounded-1 bg-primary-color"
                style="top:15px; left: 20px;">Anxiety</span></a>
          </div>
          <div class="card-body p-4">
            <a href="blog-detail.php" class="card-title">How to Manage Anxiety in Everyday Life</a>
            <p class="text-muted-color">Guided by trauma-informed professionals, this group creates a safe and
              empowering space where participants can process painful experiences, rebuild trust in themselves and
              others, and take meaningful steps toward long-term recovery...</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- #news end -->

<?php require("./partials/layout/bottom-layout.php"); ?>