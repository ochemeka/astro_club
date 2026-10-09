<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/pagination.php"); ?>

<?php
$head_title = "About Us – Lekki Astro Medical Records";
$page_title = "About Us";
?>

<?php require("./partials/layout/top-layout.php"); ?>

<?php require("./partials/page-title.php"); ?>

<!-- About Section -->
<section class="section about-section pb-5 my-5">
  <div class="b-container">
    <div class="row align-items-center g-5">
      <!-- Left Image Side -->
      <div class="col-xl-4 d-flex position-relative">
        <div class="position-relative mx-auto img-container">
          <!-- Primary Image -->
          <div class="ratio-wrapper-429">
           <img src="./assets/image/doc_pic.png" alt="About Us"
  class="w-100 h-100 object-fit-cover position-absolute top-0 start-0 rounded-5"
  style="transform: scaleX(-1);"
  data-aos="fade-right"
  data-aos-easing="ease-in-sine"
  data-aos-delay="500"
  data-aos-duration="1000">


              
          </div>
        </div>
      </div>

      <!-- Center Text Side -->
      <div class="col-xl-8">
        <div class="row">
          <h6 class="text-primary-color fw-semibold mb-2">ABOUT US</h6>
          <h2 class="font-1 mb-4" style="font-weight: 800;">Empowering Members’ Health & Wellbeing</h2>
        </div>
        <div class="row">
          <div class="col-12 col-md-7">
            <ul class="list-unstyled fs-5">
              <li class="d-flex align-items-start mb-2">
                <i class="bi bi-chevron-right text-primary-color me-2 py-3"></i>
                <span>We provide an integrated digital medical record system to manage members’ health efficiently.</span>
              </li>
              <li class="d-flex align-items-start mb-2">
                <i class="bi bi-chevron-right text-primary-color me-2 py-3"></i>
                <span>Our system ensures quick access to accurate health records for informed medical decisions.</span>
              </li>
              <li class="d-flex align-items-start mb-2">
                <i class="bi bi-chevron-right text-primary-color me-2 py-3"></i>
                <span>We prioritize data security, privacy, and compliance to protect members’ personal health information.</span>
              </li>
              <li class="d-flex align-items-start mb-2">
                <i class="bi bi-chevron-right text-primary-color me-2 py-3"></i>
                <span>Dedicated to supporting members’ holistic wellbeing through proactive care and health monitoring.</span>
              </li>
            </ul>
          </div>
          <div class="col-12 col-md-5 mt-sm-4" data-aos="fade-up" data-aos-easing="ease-in-sine"
            data-aos-delay="500" data-aos-duration="1000">
            <div class="card bg-gradient-primary p-4 rounded-5 border-0">
              <div class="card-body text-white">
                <h4 class="font-1" style="font-weight: 900;">Why Choose Us</h4>
                <div class="row mt-4">
                  <div class="mb-4 fs-5">
                    <i class="bi bi-check-circle-fill text-secondary-color-2 me-2"></i>
                    Digital Medical Records
                  </div>
                  <div class="mb-4 fs-5">
                    <i class="bi bi-check-circle-fill text-secondary-color-2 me-2"></i>
                    Appointment Scheduling
                  </div>
                  <div class="mb-4 fs-5">
                    <i class="bi bi-check-circle-fill text-secondary-color-2 me-2"></i>
                    Secure Data Management
                  </div>
                  <div class="mb-4 fs-5">
                    <i class="bi bi-check-circle-fill text-secondary-color-2 me-2"></i>
                    Member-Centered Care
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- col-xl-8 end -->
    </div> <!-- row end -->
  </div>
</section>
<!-- #about end -->

<?php //include("./partials/section/consult.php"); ?>
<?php //include("./partials/section/specialist.php"); ?>
<?php include("./partials/section/color-faqs.php"); ?>
<?php include("./partials/section/feedback.php"); ?>

<?php require("./partials/layout/bottom-layout.php"); ?>
