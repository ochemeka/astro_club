<?php
require_once("includes/session.php");
require_once("includes/connection.php");
require_once("includes/functions.php");
$head_title = "Service Detail";
$page_title = "Service Detail";
?>

<?php require("./partials/layout/top-layout.php"); ?>

<?php require("./partials/page-title.php"); ?>

<!-- Detail Section -->
<section class="section py-5 my-5">
  <div class="b-container">
    <div class="row g-5">

      <!-- Sidebar -->
      <div class="col-12 col-lg-4 mb-5 order-2 order-lg-1">

        <?php include("./partials/section/service-sidebar.php"); ?>

      </div>
      <!-- #sidebar end -->

      <!-- Content -->
      <div class="col-12 col-lg-8 mb-5 order-1 order-lg-2 pt-5 pt-lg-0">
        <div class="row mb-3">
          <h2 class="font-1 fw-bolder">Group Counseling</h2>
          <p class="text-muted-color">Offers a safe space to explore overwhelming thoughts, practice calming
            techniques, and build supportive connections with others. This group provides a compassionate and
            confidential environment where individuals can openly discuss their fears, learn healthy coping
            mechanisms, and understand that they are not alone in their struggles with constant worry and unease.
          </p>
          <img src="./assets/image/Place-Holder-1920x1280.jpg" alt="Group Conseling Detail" class="img-fluid rounded-5 my-4">
          <p class="text-muted-color">Provides understanding and encouragement through shared experiences, helping
            individuals rediscover hope and emotional strength. Through guided conversations and shared stories,
            members are encouraged to reconnect with themselves and others, gradually rebuilding emotional strength,
            motivation, and hope in a space that prioritizes healing and patience.</p>
        </div>

        <div class="row my-2">
          <h3 class="font-1 fw-bolder">What We Do In Counseling</h3>
          <p class="text-muted-color">Participants learn to identify stress triggers and replace negative responses
            with practical, mindful strategies, all while benefiting from the encouragement and accountability of a
            supportive and understanding peer community.</p>
          <p class="text-muted-color">Promotes healthier daily habits through mindfulness practices, peer support,
            and effective strategies to reduce mental overload.</p>
        </div>
        <div class="row my-2">
          <h3 class="font-1 fw-bolder">Let Us Supporting You</h3>
          <p class="text-muted-color">Creates a compassionate environment where healing begins with shared stories,
            emotional validation, and gentle guidance. Designed to help individuals navigate the complex emotions
            that follow a loss, this group offers comfort, empathy, and guidance through meaningful dialogue, shared
            remembrance, and connection with others on a similar journey.</p>
          <ul class="list-unstyled font-1 mt-3 mb-4 ms-3">
            <li class="d-flex my-2 fs-4 fw-bolder">
              <i class="bi bi-check-circle-fill text-primary-color me-2"></i>Anxiety Support Group
            </li>
            <li class="d-flex my-2 fs-4 fw-bolder">
              <i class="bi bi-check-circle-fill text-primary-color me-2"></i>Depression Recovery Group
            </li>
            <li class="d-flex my-2 fs-4 fw-bolder">
              <i class="bi bi-check-circle-fill text-primary-color me-2"></i>Stress Management Group
            </li>
            <li class="d-flex my-2 fs-4 fw-bolder">
              <i class="bi bi-check-circle-fill text-primary-color me-2"></i>Grief and Loss Support Group
            </li>
            <li class="d-flex my-2 fs-4 fw-bolder">
              <i class="bi bi-check-circle-fill text-primary-color me-2"></i>Emotional Resilience Building Group
            </li>
            <li class="d-flex my-2 fs-4 fw-bolder">
              <i class="bi bi-check-circle-fill text-primary-color me-2"></i>Trauma Healing Group
            </li>
            <li class="d-flex my-2 fs-4 fw-bolder">
              <i class="bi bi-check-circle-fill text-primary-color me-2"></i>Self-Esteem Improvement Group
            </li>
          </ul>
          <p class="text-muted-color">Focusing on personal empowerment and mental flexibility, this group helps
            individuals develop inner strength, regulate emotions, and handle life’s challenges with a renewed sense
            of control and confidence. Strengthens inner stability by teaching coping skills, improving
            self-awareness, and fostering a supportive group dynamic.</p>
        </div>

        <div class="row my-2">
          <div class="accordion" id="accordionFaqs" data-aos="fade-up" data-aos-easing="linear" data-aos-delay="500"
            data-aos-duration="1000">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1"
                  aria-expanded="false" aria-controls="faq-1">
                  &nbsp;What is mental health, and why is it important?
                </button>
              </h2>
              <div id="faq-1" class="accordion-collapse collapse show" data-bs-parent="#accordionFaqs">
                <div class="accordion-body">If you experience persistent feelings of sadness, anxiety, or stress
                  that
                  interfere with daily life, it may be time to seek professional support. Other signs include
                  difficulty concentrating, changes in sleep patterns, or feelings of isolation and hopelessness.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#faq-2" aria-expanded="false" aria-controls="faq-2">
                  &nbsp;How can I tell if I need professional mental health
                  support?
                </button>
              </h2>
              <div id="faq-2" class="accordion-collapse collapse" data-bs-parent="#accordionFaqs">
                <div class="accordion-body">Mental health refers to a person’s emotional, psychological, and social
                  well-being. It affects how people think, feel, and behave. Maintaining good mental health is
                  essential for handling stress, building relationships, and making decisions in daily life.</div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#faq-3" aria-expanded="false" aria-controls="faq-3">
                  &nbsp;Are online therapy sessions effective?
                </button>
              </h2>
              <div id="faq-3" class="accordion-collapse collapse" data-bs-parent="#accordionFaqs">
                <div class="accordion-body">Yes, online therapy can be very effective for many individuals. It
                  offers
                  flexibility, accessibility, and privacy, making it easier for people to access professional help
                  from the comfort of their own homes.</div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#faq-4" aria-expanded="false" aria-controls="faq-4">
                  &nbsp;What can I do to improve my mental well-being daily?
                </button>
              </h2>
              <div id="faq-4" class="accordion-collapse collapse" data-bs-parent="#accordionFaqs">
                <div class="accordion-body">You can improve your mental well-being by practicing self-care, such as
                  regular exercise, a healthy diet, mindfulness, and getting enough sleep. Additionally, staying
                  connected with loved ones and seeking help when needed are essential steps toward better mental
                  health.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- #end content -->

    </div>
  </div>
</section>
<!-- #end detail -->

<?php require("./partials/layout/bottom-layout.php"); ?>