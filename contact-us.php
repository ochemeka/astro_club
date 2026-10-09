<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/pagination.php"); ?>

<?php
$head_title = "Contact Us – Nuro";
$page_title = "Contact Us";

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

<?php require("./partials/page-title.php"); ?>

<!-- Contact section -->
<section class="section py-5 my-5">
  <div class="b-container">
    <div class="row justify-content-center g-5">

      <!-- Form contact -->
      <div class="col-12 col-lg-6 order-2 order-lg-1">
        <div class="card bg-secondary-color-2 rounded-5 border-0">
          <div class="card-body p-5">
            <!-- Success message -->
            <div
              class="success_msg toast align-items-center w-100 shadow-none mb-3 border border-success rounded-pill my-4"
              role="alert" aria-live="assertive" aria-atomic="true">
              <div class="d-flex p-2">
                <div class="toast-body d-flex flex-row gap-3 align-items-center text-success">
                  <i class="bi bi-check-circle-fill text-success"></i>
                  Your Message Successfully Send.
                </div>
                <button type="button" class="me-2 m-auto bg-transparent border-0 ps-1 pe-0 text-success"
                  data-bs-dismiss="toast" aria-label="Close"><i class="bi bi-x-lg"></i></button>
              </div>
            </div>
            <!-- Error message -->
            <div
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
            </div>
            <!-- Form -->
            <form class="needs-validation" method="POST" novalidate>
              <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
              <input type="hidden" name="action" value="contact">
              <div class="row g-3">
                <div class="col-lg-6 col-sm-12">
                  <label for="name" class="form-label font-1 fs-4 fw-bold">Name</label>
                  <input type="text" class="form-control form-control-lg rounded-5" id="name" name="name"
                    placeholder="Your name here" required>
                  <div class="invalid-feedback">
                    Valid name is required.
                  </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                  <label for="email" class="form-label font-1 fs-4 fw-bold">Email</label>
                  <input type="email" class="form-control form-control-lg rounded-5" id="email" name="email"
                    placeholder="Your email here" required>
                  <div class="invalid-feedback">
                    Valid email is required.
                  </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                  <label for="phone" class="form-label font-1 fs-4 fw-bold">Phone</label>
                  <input type="number" class="form-control form-control-lg rounded-5" id="phone" name="phone"
                    placeholder="Your phone number" required>
                  <div class="invalid-feedback">
                    Valid phone is required.
                  </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                  <label for="subject" class="form-label font-1 fs-4 fw-bold">Subject</label>
                  <input type="text" class="form-control form-control-lg rounded-5" id="subject" name="subject"
                    placeholder="Your subject." required>
                  <div class="invalid-feedback">
                    Valid subject is required.
                  </div>
                </div>
                <div class="col-12">
                  <label for="message" class="form-label font-1 fs-4 fw-bold">Message</label>
                  <textarea class="form-control form-control-lg rounded-5" id="message" name="message"
                    rows="5"></textarea>
                </div>
                <button class="btn btn-block btn-primary-solid submit_form mt-4" type="submit">Submit Now</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- #form end -->

      <!-- Information -->
      <div class="col-12 col-lg-6 order-1 order-lg-2">
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
      </div>
      <!-- #information end -->

    </div>
  </div>
</section>
<!-- #contact end -->

<!-- Map frame -->
<div class="section p-0 m-0">
  <div class="container-fluid p-0 m-0">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="map-container">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.1234567890123!2d-122.4194156846814!3d37.7749292797599!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085808c8c8c8c8c%3A0x8c8c8c8c8c8c8c8c!2s123%20Serenity%20Lane%2C%20Blissfield%2C%20CA%2090210%2C%20United%20States!5e0!3m2!1sen!2sus!4v1631234567890"
            height="350" style="width: 100%; border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- #map end -->

<?php require("./partials/layout/bottom-layout.php"); ?>