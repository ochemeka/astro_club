<?php
require_once("includes/session.php");
require_once("includes/connection.php");
require_once("includes/functions.php");

$head_title = "Register – Lekki Astro Sports Club Medical";
$page_title = "Register";

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token. Please refresh the page.");
    }
}
?>

<?php require("./partials/layout/top-layout.php"); ?>

<?php require("./partials/member_log.php"); ?>

<!-- Contact section -->
<section class="section py-5 my-5">
  <div class="b-container">
    <div class="row justify-content-center g-5">

      <!-- Form contact -->
      <div class="col-12 col-lg-6 order-2 order-lg-1">
        <div class="card bg-secondary-color-2 rounded-5 border-0">
          <div class="card-body p-5">
            
            <!-- Success message -->
            
            <!-- Error message -->
            <!-- <div
              class="error_msg toast align-items-center w-100 shadow-none border-danger mb-3 my-4 border rounded-pill"
              role="alert" aria-live="assertive" aria-atomic="true">
              <div class="d-flex p-2">
                <div class="toast-body d-flex flex-row gap-3 align-items-center text-danger">
                  <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                  Something Wrong ! Send Form Failed.
                </div>
                <button type="button" class="me-2 m-auto bg-transparent border-0 ps-1 pe-0 text-danger"
                  data-bs-dismiss="toast" aria-label="Close"><i class="bi bi-x-lg"></i></button>
              </div>
            </div> -->
            <!-- Form -->
            <form class="needs-validation" method="POST" novalidate>
              <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
              <input type="hidden" name="action" value="contact">
              <div class="row g-3">
                <div class="col-lg-12 col-sm-12">
                  <label for="name" class="form-label font-1 fs-4 fw-bold">Name</label>
                  <input type="text" class="form-control form-control-lg rounded-5" id="name" name="name"
                    placeholder="Your name here" required>
                  <div class="invalid-feedback">
                    Valid name is required.
                  </div>
                </div>
                <div class="col-lg-12 col-sm-12">
                  <label for="email" class="form-label font-1 fs-4 fw-bold">Email</label>
                  <input type="email" class="form-control form-control-lg rounded-5" id="email" name="email"
                    placeholder="Your email here" required>
                  <div class="invalid-feedback">
                    Valid email is required.
                  </div>
                </div>
                <div class="col-lg-12 col-sm-12">
                  <label for="phone" class="form-label font-1 fs-4 fw-bold">Phone</label>
                  <input type="number" class="form-control form-control-lg rounded-5" id="phone" name="phone"
                    placeholder="Your phone number" required>
                  <div class="invalid-feedback">
                    Valid phone is required.
                  </div>
                </div>
                <!--  -->
                <!--  -->
                <button class="btn btn-block btn-primary-solid submit_form mt-4" type="submit">Submit Now</button>
              </div>
            </form> <br>
             Already have an account? <a href="login.php"> Click here to Login</a>
          </div>
        </div>
      </div>
      <!-- #form end -->

      <!-- Information -->
      <!-- <div class="col-12 col-lg-6 order-1 order-lg-2">
        <div class="row py-5">
          <h6 class="text-primary-color fw-semibold mb-2">GET IN TOUCH</h6>
          <h2 class="font-1" style="font-weight: 800;">Contact Details</h2>
        </div>
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <div class="card text-center rounded-5" data-aos="fade-down" data-aos-easing="ease-out-cubic"
              data-aos-delay="250" data-aos-duration="1000" style="border: 2px solid #1747A6;">
              <div class="card-body d-flex flex-column align-items-center font-1">
                <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary-color"
                  style="width: 75px; height: 75px; border: 2px solid white;">
                  <i class="bi bi-geo-alt-fill fs-2 text-white"></i>
                </div>
                <h4 class="card-title mt-3 fw-bolder">Address</h4>
                <p class="card-text text-muted-color">123 Serenity Lane, Blissfield,<br>CA 90210, United States</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="card text-center rounded-5" data-aos="fade-left" data-aos-easing="ease-out-cubic"
              data-aos-delay="500" data-aos-duration="1000" style="border: 2px solid #1747A6;">
              <div class="card-body d-flex flex-column align-items-center font-1">
                <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary-color"
                  style="width: 75px; height: 75px; border: 2px solid white;">
                  <i class="bi bi-envelope-fill fs-2 text-white"></i>
                </div>
                <h4 class="card-title mt-3 fw-bolder">Need Support?</h4>
                <p class="card-text text-muted-color">(555) 123-4567<br>Info@Yourmail.com</p>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card rounded-5" data-aos="fade-right" data-aos-easing="ease-out-cubic" data-aos-delay="750"
              data-aos-duration="1000" style="border: 2px solid #1747A6;">
              <div
                class="card-body font-1 d-flex flex-column flex-md-row align-items-center text-center text-md-start gap-3">
                <div
                  class="d-flex align-items-center justify-content-center rounded-circle bg-primary-color mx-auto mx-md-0"
                  style="width: 75px; height: 75px; border: 2px solid white;">
                  <i class="bi bi-clock-fill fs-2 text-white"></i>
                </div>
                <div class="mt-3">
                  <h4 class="card-title fw-bolder">Working Hours</h4>
                  <p class="card-text text-muted-color">Mon - Fri 8:00 - 6:30</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <!-- #information end -->

    </div>
  </div>
</section>
<!-- #contact end -->



<?php require("./partials/layout/bottom-layout_1.php"); ?>