<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/pagination.php"); ?>
<?php
$head_title = "Blog Detail – Nuro";
$page_title = "Blog Detail";
?>

<?php require("./partials/layout/top-layout.php"); ?>

<?php require("./partials/page-title.php"); ?>

<!-- Blog content -->
<section class="section py-5 my-5">
  <div class="b-container">
    <div class="row g-5">
      <!-- Blog Detail -->
      <div class="col-12 col-lg-8">
        <div class="row">
          <h2 class="font-1 fw-bolder mb-4">Benefits of Regular Health Checkups for Club Members</h2>
          <p class="text-primary-color mb-4">
            <i class="bi bi-calendar-fill"></i>&nbsp;15th March 2025
            &nbsp;|&nbsp;
            <i class="bi bi-person-fill"></i>&nbsp;By Lekki Astro Medical Team
          </p>
          <div class="mb-4">
            <img src="./assets/image/Place-Holder-1920x1280.jpg" alt="Health Checkup" class="img-fluid rounded-5">
          </div>
          <p class="text-muted-color">
            Regular medical checkups are a cornerstone of safe sport. For our members, a checkup is more than a
            formality — it is a chance to track how your body responds to training, spot concerns early, and keep
            your health goals firmly on course.
          </p>

          <p class="text-muted-color mb-0">
            During each check-in, the medical team records your resting pulse, blood pressure, weight, height, and
            BMI. Tracking these vitals over time gives us a clear, honest picture of your health — so a small change
            is noticed and acted on before it becomes a bigger problem.
          </p>
          <div class="row g-0 g-md-3 px-2">
            <div class="col-12 col-md-6 mt-4 mt-md-0">
              <div class="bg-primary-color text-white rounded-5 d-flex align-items-center justify-content-center py-5 h-100">
                <div class="text-center">
                  <i class="bi bi-heart-pulse fs-1"></i>
                  <h5 class="font-1 fw-bold mt-3 mb-0">Vitals Tracked Over Time</h5>
                  <p class="mb-0 mt-2 px-4">Pulse, blood pressure, weight, and BMI reviewed at every checkup.</p>
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 mt-4 mt-md-0">
              <div class="bg-secondary-color text-white rounded-5 d-flex align-items-center justify-content-center py-5 h-100">
                <div class="text-center">
                  <i class="bi bi-clipboard2-pulse fs-1"></i>
                  <h5 class="font-1 fw-bold mt-3 mb-0">Clear Medical Advice</h5>
                  <p class="mb-0 mt-2 px-4">Doctor recommendations are saved to your profile for you and your coaches.</p>
                </div>
              </div>
            </div>
          </div>
          <p class="text-muted-color mt-4">
            A checkup isn't just numbers — it's guidance. After each visit, the medical team records clear
            recommendations on your profile, so you and your coaches know whether to push, rest, or adjust your
            routine. This makes every training week safer and more effective.
          </p>

          <p class="text-muted-color ">
            Ultimately, consistent checkups build a complete health history you control. It's the simplest way to
            stay fit, catch concerns early, and be fully match-ready whenever the whistle blows.
          </p>
        </div>
        <hr class="border-2 my-5">
        <div class="d-flex align-items-center mb-0 mb-lg-5">
          <h3 class="font-1 fw-bolder mt-1">Share On :</h3>
          <div class="social-box ms-4">
            <a href="https://www.facebook.com" class="rounded-5 py-2" style="width: 40px; height: 40px;"><i
                class="bi bi-facebook text-white"></i></a>
            <a href="https://x.com" class="rounded-5 py-2" style="width: 40px; height: 40px;"><i
                class="bi bi-twitter-x text-white"></i></a>
            <a href="https://www.linkedin.com" class="rounded-5 py-2" style="width: 40px; height: 40px;"><i
                class="bi bi-linkedin text-white"></i></a>
          </div>
        </div>
      </div>
      <!-- #blog detail end -->

      <!-- Sidebar -->
      <div class="col-12 col-lg-4">

        <?php include('./partials/section/blog-sidebar.php'); ?>

      </div>
      <!-- #sidebar end -->

    </div>
  </div>
  <!-- #blog content end -->
</section>
<!-- #blog end -->

<?php require("./partials/layout/bottom-layout.php"); ?>