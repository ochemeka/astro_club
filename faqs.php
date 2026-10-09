<?php
require_once("includes/session.php");
require_once("includes/connection.php");
require_once("includes/functions.php");
$head_title = "FAQs";
$page_title = "FAQs";
?>

<?php require("./partials/layout/top-layout.php"); ?>

<?php require("./partials/page-title.php"); ?>

<!-- FAQs Section -->
<div class="section py-5 my-5">
  <div class="b-container">
    <div class="row">

      <!-- Sidebar -->
      <div class="col-12 col-lg-4">

        <?php include("./partials/section/faqs-sidebar.php"); ?>

      </div>
      <!-- #sidebar end -->

      <!-- FAQs content -->
      <div class="col-12 col-lg-8 mt-5 mt-lg-0">
        <div class="accordion" id="accordionFaqs">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1"
                aria-expanded="false" aria-controls="faq-1">
                &nbsp;What is mental health, and why is it important?
              </button>
            </h2>
            <div id="faq-1" class="accordion-collapse collapse show" data-bs-parent="#accordionFaqs">
              <div class="accordion-body">If you experience persistent feelings of sadness, anxiety, or
                stress that
                interfere with daily life, it may be time to seek professional support. Other signs include
                difficulty concentrating, changes in sleep patterns, or feelings of isolation and
                hopelessness.
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
              <div class="accordion-body">Mental health refers to a person’s emotional, psychological, and
                social
                well-being. It affects how people think, feel, and behave. Maintaining good mental health is
                essential for handling stress, building relationships, and making decisions in daily life.
              </div>
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
                flexibility, accessibility, and privacy, making it easier for people to access professional
                help
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
              <div class="accordion-body">You can improve your mental well-being by practicing self-care,
                such as
                regular exercise, a healthy diet, mindfulness, and getting enough sleep. Additionally,
                staying
                connected with loved ones and seeking help when needed are essential steps toward better
                mental
                health.</div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#faq-5" aria-expanded="false" aria-controls="faq-5">
                &nbsp;What can I do to improve my mental well-being daily?
              </button>
            </h2>
            <div id="faq-5" class="accordion-collapse collapse" data-bs-parent="#accordionFaqs">
              <div class="accordion-body">No, you don’t need a referral. You can directly book a session with one of
                our mental health professionals.</div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#faq-6" aria-expanded="false" aria-controls="faq-6">
                &nbsp;Do I need a referral to join a counseling session?
              </button>
            </h2>
            <div id="faq-6" class="accordion-collapse collapse" data-bs-parent="#accordionFaqs">
              <div class="accordion-body">A typical counseling session lasts around 45 to 60 minutes, depending on
                the type of service you choose.</div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#faq-7" aria-expanded="false" aria-controls="faq-7">
                &nbsp;Are online sessions as effective as in-person counseling?
              </button>
            </h2>
            <div id="faq-7" class="accordion-collapse collapse" data-bs-parent="#accordionFaqs">
              <div class="accordion-body">Yes, studies have shown that online counseling can be just as effective as
                in-person sessions for many individuals. It also offers greater convenience and accessibility.</div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#faq-8" aria-expanded="false" aria-controls="faq-8">
                &nbsp;What should I expect during my first session?
              </button>
            </h2>
            <div id="faq-8" class="accordion-collapse collapse" data-bs-parent="#accordionFaqs">
              <div class="accordion-body">During your first session, your counselor will get to know you, discuss
                your concerns, and work with you to set goals for your mental health journey.</div>
            </div>
          </div>

        </div>
        <!-- #faqs end -->
      </div>
      <!-- #faqs content end -->

    </div>
  </div>
</div>

<?php require("./partials/layout/bottom-layout.php"); ?>