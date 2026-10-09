<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/pagination.php"); ?>

<?php $head_title = "Lekki Astro Sports Club Medical Record"; ?>
<?php require("./partials/layout/top-layout.php"); ?>

<!-- Hero Section -->
<section class="section hero-section d-flex align-items-center pb-0">
  <div class="b-container px-3 px-sm-4 px-md-0">
    <div class="row row-cols-1 row-cols-lg-2 g-4 align-items-center text-white">
      <!-- Hero Text -->
      <div class="col mt-md-5 text-center text-lg-start" data-aos="fade-up" data-aos-delay="500" data-aos-duration="1000">
        <h6 class="text-primary-color fw-semibold">YOUR HEALTH, OUR PRIORITY</h6>
        <h1 class="display-md-4 lh-sm font-1 fw-bold">
          Empowering <span class="text-primary-color">Members’ Health</span> & Wellbeing
        </h1>
        <hr class="border border-white border-2 opacity-75 w-75 my-4 mx-auto mx-lg-0">
        <p class="fs-5 my-4">
          Secure, accessible, and comprehensive medical records for every member. Supporting your fitness, health tracking, and wellbeing goals through innovative digital solutions.
        </p>
        <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start mt-4">
          <a href="user/login.php"  class="btn btn-primary-solid">Check Record Now</a>
          <a href="appointment.php" class="btn btn-secondary-solid">Book Medical Checkup</a>
        </div>
      </div>

      <!-- Hero Image -->
      <div class="col position-relative text-center pt-lg-4 pt-xl-3">
        <img src="./assets/image/doc_pic.png" alt="Medical Record" class="img-fluid position-relative" style="z-index: 2;">
      </div>
    </div>
  </div>
</section>
<!-- #hero end -->

<!-- Features Section -->
<section class="section py-5">
  <div class="b-container">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 text-center">
      <!-- Feature Card -->
      <?php
      $features = [
        ["icon" => "bi-file-earmark-medical", "title" => "Digital Health Records", "desc" => "Access and update members’ health records securely anytime, anywhere.", "bg" => "bg-secondary-color"],
        ["icon" => "bi-calendar-check", "title" => "Appointment Scheduling", "desc" => "Streamlined booking system for checkups, consultations, and health reviews.", "bg" => "bg-secondary-color-2"],
        ["icon" => "bi-heart-pulse", "title" => "Health Monitoring", "desc" => "Track members’ vitals, fitness assessments, and health improvement goals efficiently.", "bg" => "bg-primary-color"],
        ["icon" => "bi-shield-lock", "title" => "Data Security", "desc" => "Ensure members’ data privacy with robust, encrypted record management.", "bg" => "bg-primary-color-2"],
      ];

      foreach ($features as $index => $feature):
      ?>
      <div class="col" data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 250 ?>" data-aos-duration="1000">
        <div class="<?= $feature['bg'] ?> text-white p-4 rounded-5 h-100 transition-hover">
          <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
            <i class="bi <?= $feature['icon'] ?> fs-1"></i>
            <h6 class="fw-bold mb-0"><?= $feature['title'] ?></h6>
          </div>
          <p class="mt-3"><?= $feature['desc'] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- #features end -->

<!-- About Section -->
<section class="section pb-5 my-5">
  <div class="b-container">
    <div class="row row-cols-1 row-cols-xl-2 g-5 align-items-center">
      <!-- About Highlights -->
      <div class="col text-center">
        <div class="row row-cols-1 g-3">
          <div class="col">
            <div class="bg-secondary-color text-white p-4 rounded-5 h-100 text-start">
              <div class="d-flex align-items-center gap-3 mb-2">
                <i class="bi bi-person-vcard fs-1"></i>
                <h5 class="fw-bold mb-0">Member-Centered Records</h5>
              </div>
              <p class="mb-0">Every checkup, vital reading, and recommendation is logged against a single member
                profile for a complete health picture.</p>
            </div>
          </div>
          <div class="col">
            <div class="bg-secondary-color-2 text-white p-4 rounded-5 h-100 text-start">
              <div class="d-flex align-items-center gap-3 mb-2">
                <i class="bi bi-clipboard-pulse fs-1"></i>
                <h5 class="fw-bold mb-0">Fitness &amp; Health Tracking</h5>
              </div>
              <p class="mb-0">Vitals, fitness assessments, and goals are tracked over time to guide safer and
                smarter training.</p>
            </div>
          </div>
          <div class="col">
            <div class="bg-primary-color text-white p-4 rounded-5 h-100 text-start">
              <div class="d-flex align-items-center gap-3 mb-2">
                <i class="bi bi-shield-lock fs-1"></i>
                <h5 class="fw-bold mb-0">Private &amp; Secure</h5>
              </div>
              <p class="mb-0">Records are only accessible to each member and the club's medical team.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- About Content -->
      <div class="col text-center text-xl-start">
        <h6 class="text-primary-color fw-semibold mb-2">ABOUT US</h6>
        <h2 class="font-1 fw-bold mb-4">Dedicated To Members’ Health Records & Care</h2>
        <p class="text-secondary fs-5">
          Our Medical Record System simplifies healthcare management for members. We integrate medical assessments, consultations, and fitness data to build a complete profile for each member, fostering holistic wellbeing and proactive care.
        </p>
        <ul class="list-unstyled mt-4">
          <?php
          $about_points = [
            "Comprehensive Record Keeping",
            "Member-Centered Approach",
            "Secure Data Management",
          ];
          foreach ($about_points as $point):
          ?>
          <li class="d-flex align-items-center mb-2">
            <i class="bi bi-check-circle-fill text-primary-color fs-4 me-2"></i> <?= $point ?>
          </li>
          <?php endforeach; ?>
        </ul>
        <a href="about-us.php" class="btn btn-primary-solid mt-4">Learn More</a>
      </div>
    </div>
  </div>
</section>
<!-- #about end -->

<!-- Services Section -->
<section class="section py-5 bg-light">
  <div class="b-container text-center">
    <h6 class="text-primary-color fw-semibold mb-2">OUR SERVICES</h6>
    <h2 class="display-5 font-1 fw-bold mb-5">Enhancing Members' Health Experience</h2>
    <div class="row g-4">
      <?php
      $services = [
        ["icon" => "bi-person-lines-fill", "title" => "Medical Consultations", "desc" => "Book and manage consultations with the club’s medical professionals for timely care."],
        ["icon" => "bi-clipboard-data", "title" => "Fitness Assessments", "desc" => "Track performance metrics to align training and health goals seamlessly."],
        ["icon" => "bi-layers", "title" => "Integrated Reports", "desc" => "Generate, download, and review comprehensive health and fitness reports."],
      ];

      foreach ($services as $service):
      ?>
      <div class="col-md-4">
        <div class="card border-0 rounded-5 shadow h-100">
          <div class="card-body p-4">
            <i class="bi <?= $service['icon'] ?> fs-1 text-primary-color"></i>
            <h4 class="mt-3"><?= $service['title'] ?></h4>
            <p><?= $service['desc'] ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- #services end -->

<?php include("./partials/section/consult.php"); ?>
<?php include("./partials/section/feedback.php"); ?>
<?php //include("./partials/section/specialist.php"); ?>
<?php //include("./partials/section/quotation.php"); ?>

<!-- News Section -->
<section class="section py-5 mb-5">
  <div class="b-container">
    <div class="text-center mb-5">
      <h6 class="text-primary-color fs-5 fw-semibold">NEWS & UPDATES</h6>
      <h2 class="font-1 display-5 fw-bold">Latest Health Tips & Club Updates</h2>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php
      $news = [
        [
          "icon" => "bi-clipboard2-pulse",
          "bg" => "bg-primary-color",
          "title" => "Benefits of Regular Health Checkups",
          "desc" => "Routine checkups help track vitals, catch concerns early, and keep members fit and match-ready.",
        ],
        [
          "icon" => "bi-heart-pulse",
          "bg" => "bg-secondary-color",
          "title" => "Why We Track Your Vitals",
          "desc" => "Blood pressure, pulse, weight and BMI give our medical team the data to guide safe training.",
        ],
        [
          "icon" => "bi-calendar-check",
          "bg" => "bg-secondary-color-2",
          "title" => "Booking Your Medical Checkup",
          "desc" => "Schedule a checkup in minutes, then review your latest results and medical advice from anywhere.",
        ],
      ];
      foreach ($news as $item):
      ?>
      <div class="col">
        <div class="card h-100 shadow border-0 rounded-5 overflow-hidden">
          <div class="<?= $item['bg'] ?> text-white d-flex align-items-center justify-content-center py-4">
            <i class="bi <?= $item['icon'] ?> fs-1"></i>
          </div>
          <div class="card-body">
            <h5 class="card-title"><?= $item['title'] ?></h5>
            <p class="card-text"><?= $item['desc'] ?></p>
            <a href="blog-detail.php" class="btn btn-primary-solid mt-2">Read More</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<!-- #news end -->

<?php require("./partials/layout/bottom-layout.php"); ?>
