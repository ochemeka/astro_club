<?php
$head_title = "Error 404 – Nuro";
$page_title = "Error 404";
?>

<?php require("./partials/layout/top-layout-2.php"); ?>

<section class="section position-relative"
  style="background-image: url('./assets/image/Place-Holder-1920x1280.jpg'); height: 100vh; background-size: cover; background-position: center;">
  <div class="bg-overlay-secondary"></div>
  <div class="b-container">
    <div class="position-absolute top-50 start-50 translate-middle text-center z-2 text-white px-3"
      style="width: 100%; max-width: 600px;">
      <div class="font-1 fw-bolder">
        <div class="error-code text-black" data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="300"
          data-aos-offset="0">
          <span class="py-3">4</span>
          <span>0</span>
          <span class="py-3">4</span>
        </div>
        <h2 class="text-white mt-3 fw-bolder">Sorry, This Page Isn’t Feeling Well.</h2>
        <a href="index.php" class="btn btn-lg btn-primary-solid mt-3 px-5 py-3">Back To Homepage</a>
      </div>
    </div>
  </div>
</section>

<?php require("./partials/layout/bottom-layout-2.php"); ?>