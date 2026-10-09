<?php
require_once("includes/session.php");
require_once("includes/connection.php");
require_once("includes/functions.php");
$head_title = "Pricing";
$page_title = "Pricing";
?>

<?php require("./partials/layout/top-layout.php"); ?>

<?php require("./partials/page-title.php"); ?>

<!-- Pricing Section -->
<section class="section py-5 my-5">
  <div class="b-container">
    <div class="row justify-content-center text-center my-5">
      <h6 class="text-primary-color fw-semibold mb-2">PRICING PLAN</h6>
      <h2 class="display-5 font-1 mb-5" style="font-weight: 800;">Affordable Plans for<br>a Healthier Mind</h2>
    </div>
    <div class="row justify-content-center g-4">
      <!-- Basic Plan -->
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card rounded-5 transition-hover" data-aos="fade-right" data-aos-easing="ease-out-cubic"
          data-aos-delay="250" data-aos-duration="1000">
          <div class="card-body font-1 p-4">
            <h3 class="fw-bolder">Basic Plan</h3>
            <div class="d-flex align-items-end my-3">
              <h1 class="text-primary-color mb-0" style="font-weight: 900;">$49</h1>
              <h4 class="fw-bolder ms-1">/Month</h4>
            </div>
            <p class="text-muted-color mb-5">Creates a compassionate environment where healing begins with shared
              stories, emotional validation, and gentle guidance.</p>
            <hr>
            <h5 class="fw-bolder pt-3">What We Offer ?</h5>
            <ul class="list-unstyled mt-3">
              <li class="d-flex border-bottom mt-2 py-2">
                <i class="bi bi-circle-fill text-primary-color me-2"></i>Access to group counseling sessions (twice
                a month)
              </li>
              <li class="d-flex border-bottom mt-2 py-2">
                <i class="bi bi-circle-fill text-primary-color me-2"></i>Unlimited access to self-help resources
              </li>
              <li class="d-flex border-bottom mt-2 py-2">
                <i class="bi bi-circle-fill text-primary-color me-2"></i>Weekly guided meditation and mindfulness
                exercises
              </li>
              <li class="d-flex border-bottom mt-2 py-2">
                <i class="bi bi-circle-fill text-primary-color me-2"></i>24/7 support via chat and email
              </li>
            </ul>
            <a href="contact-us.php" class="btn btn-primary-solid w-100 mt-4">Select Plan</a>
          </div>
        </div>
      </div>

      <!-- Standard Plan -->
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card rounded-5 position-relative text-white transition-hover" data-aos="fade-up"
          data-aos-easing="ease-out-cubic" data-aos-delay="500" data-aos-duration="1000"
          style="background: linear-gradient(to bottom, #3B67BF, #F2BBC5);">
          <div
            class="position-absolute top-0 start-50 translate-middle bg-primary-color text-white px-3 py-1 rounded-5 fw-bolder"
            style="font-size: 1.4rem;">Most Popular</div>
          <div class="card-body font-1 p-4">
            <h3 class="fw-bolder">Standard Plan</h3>
            <div class="d-flex align-items-end my-3">
              <h1 class="mb-0 text-white" style="font-weight: 900;">$99</h1>
              <h4 class="fw-bolder ms-1">/Month</h4>
            </div>
            <p class="text-white mb-5">Strengthens inner stability by teaching coping skills, improving
              self-awareness, and fostering a supportive group dynamic.</p>
            <hr class="border-white">
            <h5 class="fw-bolder pt-3">What We Offer ?</h5>
            <ul class="list-unstyled mt-3 mb-4">
              <li class="d-flex border-bottom my-4 py-2">
                <i class="bi bi-circle-fill text-primary-color me-2"></i>Everything in Basic Plan
              </li>
              <li class="d-flex border-bottom my-4 py-2">
                <i class="bi bi-circle-fill text-primary-color me-2"></i>One-on-one counseling session (once a
                month)
              </li>
              <li class="d-flex border-bottom my-4 py-2">
                <i class="bi bi-circle-fill text-primary-color me-2"></i>Personalized mental wellness plan
              </li>
              <li class="d-flex border-bottom my-4 py-2">
                <i class="bi bi-circle-fill text-primary-color me-2"></i>Priority response from mental health
                professionals
              </li>
            </ul>
            <a href="contact-us.php" class="btn btn-primary-solid w-100 mt-4">Select Plan</a>
          </div>
        </div>
      </div>

      <!-- Premium Plan -->
      <div class="col-12 col-lg-4">
        <div class="card rounded-5 transition-hover" data-aos="fade-left" data-aos-easing="ease-out-cubic"
          data-aos-delay="750" data-aos-duration="1000">
          <div class="card-body font-1 p-4">
            <h3 class="fw-bolder">Premium Plan</h3>
            <div class="d-flex align-items-end my-3">
              <h1 class="text-primary-color mb-0" style="font-weight: 900;">$149</h1>
              <h4 class="fw-bolder ms-1">/Month</h4>
            </div>
            <p class="text-muted-color mb-5">Focuses on emotional recovery through trauma-informed care, building
              trust, and nurturing personal growth in a safe setting.
            </p>
            <hr>
            <h5 class="fw-bolder pt-3">What We Offer ?</h5>
            <ul class="list-unstyled mt-3 mb-4">
              <li class="d-flex border-bottom my-4 py-2"><i
                  class="bi bi-circle-fill text-primary-color me-2"></i>Everything in Standard Plan
              </li>
              <li class="d-flex border-bottom my-4 py-2"><i
                  class="bi bi-circle-fill text-primary-color me-2"></i>Weekly one-on-one counseling
                sessions</li>
              <li class="d-flex border-bottom my-4 py-2"><i
                  class="bi bi-circle-fill text-primary-color me-2"></i>Access to exclusive workshops
                and webinars</li>
              <li class="d-flex border-bottom my-4 py-2"><i
                  class="bi bi-circle-fill text-primary-color me-2"></i>Direct access to expert
                therapists anytime</li>
              <li class="d-flex  border-bottom my-4 py-2"><i
                  class="bi bi-circle-fill text-primary-color me-2"></i>Ongoing progress tracking
                and
                feedback</li>
            </ul>
            <a href="contact-us.php" class="btn btn-primary-solid w-100 mt-4">Select Plan</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- #pricing end -->

<?php include("./partials/section/consult.php"); ?>

<?php include("./partials/section/feedback.php"); ?>

<?php require("./partials/layout/bottom-layout.php"); ?>