<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/pagination.php"); ?>

<?php
$head_title = "Our Services – Nuro";
$page_title = "Our Services";
?>

<?php require("./partials/layout/top-layout.php"); ?>
<?php require("./partials/page-title.php"); ?>

<!-- Services Section -->
<section class="section py-5 my-5">
  <div class="b-container text-center">

    <!-- Section Header -->
    <h6 class="text-primary-color fw-semibold mb-2">OUR SERVICES</h6>
    <h2 class="display-5 font-1 mb-5 fw-bold">Empowering Minds, Strengthening Lives</h2>

    <!-- Service Cards Row -->
    <div class="row g-4 my-5">
      
      <!-- Loop Start: Example Service Card -->
      <?php
      $services = [
        [
          "title" => "Vision Therapy",
          "img" => "./assets/image/Place-Holder-1920x1280.jpg",
          "icon" => "./assets/image/icon/Icon1.png",
          "desc" => "Advanced exercises and personalized care to improve and enhance visual performance for daily life.",
          "link" => "service-detail.php"
        ],
        [
          "title" => "Comprehensive Eye Exams",
          "img" => "./assets/image/Place-Holder-1920x1280.jpg",
          "icon" => "./assets/image/icon/Icon2.png",
          "desc" => "Thorough eye health assessments ensuring clear vision and early detection of potential concerns.",
          "link" => "service-detail.php"
        ],
        [
          "title" => "Pediatric Eye Care",
          "img" => "./assets/image/Place-Holder-1920x1280.jpg",
          "icon" => "./assets/image/icon/Icon3.png",
          "desc" => "Specialized care tailored for children's unique visual needs, growth, and learning development.",
          "link" => "service-detail.php"
        ],
        [
          "title" => "Contact Lens Services",
          "img" => "./assets/image/Place-Holder-1920x1280.jpg",
          "icon" => "./assets/image/icon/Icon1.png",
          "desc" => "Expert fittings and guidance to find the best contact lenses for comfort and clear sight.",
          "link" => "service-detail.php"
        ],
        [
          "title" => "Vision Rehabilitation",
          "img" => "./assets/image/Place-Holder-1920x1280.jpg",
          "icon" => "./assets/image/icon/Icon2.png",
          "desc" => "Supportive programs for individuals with low vision to regain independence and confidence.",
          "link" => "service-detail.php"
        ],
        [
          "title" => "Emergency Eye Care",
          "img" => "./assets/image/Place-Holder-1920x1280.jpg",
          "icon" => "./assets/image/icon/Icon3.png",
          "desc" => "Prompt and professional response to urgent eye injuries or sudden vision changes.",
          "link" => "service-detail.php"
        ],
      ];

      foreach ($services as $index => $service):
      ?>
      <div class="col-12 col-md-6 col-xl-4">
        <div class="card border-0 rounded-5 overflow-hidden h-100 shadow-sm scale-hover" data-aos="fade-up"
          data-aos-easing="linear" data-aos-delay="<?= ($index + 1) * 250 ?>" data-aos-duration="1000">

          <!-- Service Image -->
          <img src="<?= $service['img'] ?>" class="w-100" style="height: 250px; transform: scale(1.5); object-position: center;" alt="<?= $service['title'] ?>">

          <!-- Card Content -->
          <div class="bg-accent-color-2 text-start p-4 position-relative">

            <!-- Icon -->
            <div class="position-absolute top-0 start-0 translate-middle-y" style="margin-top: 0; margin-left: 20px;">
              <img src="<?= $service['icon'] ?>" alt="" width="100">
            </div>

            <!-- Read More Button -->
            <a href="<?= $service['link'] ?>"
              class="btn btn-dark btn-lg rounded-pill position-absolute top-0 end-0 me-3 fw-medium scale-hover"
              style="margin-top: -25px;">Read More</a>

            <!-- Title -->
            <h3 class="font-1 mt-5 fw-bold"><?= $service['title'] ?></h3>

            <hr class="border-primary border-1 opacity-100 w-100 my-4">

            <!-- Description -->
            <p class="mb-3"><?= $service['desc'] ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
      <!-- Loop End -->

    </div>
  </div>
</section>
<!-- #services end -->

<?php include("./partials/section/quotation.php"); ?>
<?php include("./partials/section/feedback.php"); ?>
<?php require("./partials/layout/bottom-layout.php"); ?>
