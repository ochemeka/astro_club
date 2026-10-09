$(function () {
  'use strict';
  /*--------------------------------------------------------------
    AJAX Submit Form
  --------------------------------------------------------------*/
  // Take all the forms we want to apply Bootstrap custom validation styles to
  const forms = $('.needs-validation');

  forms.on('submit', function (event) {
    const form = $(this);
    const actionInput = form.find("input[name='action']");

    if (!form[0].checkValidity()) {
      event.preventDefault();
      event.stopPropagation();
    } else {
      event.preventDefault();

      $('.submit_form').html('Sending...');
      $('.submit_subscribe').html('Sending...');

      const toastSuccess = new bootstrap.Toast($('.success_msg')[0]);
      const toastError = new bootstrap.Toast($('.error_msg')[0]);
      const toastSubscribe = new bootstrap.Toast($('.success_msg_subscribe')[0]);

      const formData = form.serialize();

      $.ajax({
        type: "POST",
        url: "./assets/inc/form_submission.php", // make sure this path is correct
        data: formData,
        success: function (response) {
          if (response.trim() === 'success') {
            if (actionInput.length && actionInput.val() === 'subscribe') {
              $('.submit_subscribe').html('Subscribe');
              toastSubscribe.show();
            } else {
              $('.submit_form').html('Send Message');
              toastSuccess.show();
            }
          } else {
            $('.submit_form').html('Send Message');
            $('.submit_subscribe').html('Subscribe');
            toastError.show();
          }
        },
        error: function () {
          $('.submit_form').html('Send Message');
          $('.submit_subscribe').html('Subscribe');
          toastError.show();
        }
      });
    }

    form.addClass('was-validated');
  });

  /*--------------------------------------------------------------
    Swiper Slider
  --------------------------------------------------------------*/
  const swiper = new Swiper('.mySwiper', {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    centeredSlides: false, // make sure this is false to avoid centering the first slide
    slideToClickedSlide: false,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      768: {
        slidesPerView: 2
      },
      1024: {
        slidesPerView: 3
      }
    }
  });

  /*--------------------------------------------------------------
    Number Counter
  --------------------------------------------------------------*/
  /**
   * Animates a count-up effect on the given element.
   * @param {jQuery} $el - The jQuery element to animate.
   * @param {number} [duration=2000] - Duration of the animation in milliseconds.
   */
  function countUp($el, duration = 2000) {
    const target = parseFloat($el.data('count')) || 0;
    const suffix = $el.data('suffix') || '';
    const isInteger = Number.isInteger(target);
    $({ countNum: 0 }).animate({ countNum: target }, {
      duration: duration,
      easing: 'swing',
      step: function () {
        const formatted = isInteger ? Math.floor(this.countNum) : this.countNum.toFixed(1);
        $el.text(formatted + suffix);
      },
      complete: function () {
        const formatted = isInteger ? Math.floor(target) : target.toFixed(1);
        $el.text(formatted + suffix);
      }
    });
  }

  // Setup IntersectionObserver
  function setupCountUpObserver(selector = '.count-up') {
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const $target = $(entry.target);
          if (!$target.hasClass('counted')) {
            countUp($target);
            $target.addClass('counted');
          }
          obs.unobserve(entry.target); // Stop observing after triggered
        }
      });
    }, { threshold: 0.6 });
    $(selector).each(function () {
      observer.observe(this);
    });
  }
  // Activate count-up observers
  setupCountUpObserver();

  /*--------------------------------------------------------------
    YT Video Player Overlay
  --------------------------------------------------------------*/
  const $overlay = $('#videoOverlay');
  const $frame = $('#youtubeFrame');

  // Show overlay function
  function showVideoOverlay() {
    $overlay.removeClass('d-none');

    let src = $frame.attr('src');
    if (!src.includes('autoplay=1')) {
      const sep = src.includes('?') ? '&' : '?';
      $frame.attr('src', src + sep + 'autoplay=1');
    }
  }

  // Hide overlay function
  function hideVideoOverlay() {
    $overlay.addClass('d-none');

    let src = $frame.attr('src');
    src = src.replace('&autoplay=1', '').replace('?autoplay=1', '');
    $frame.attr('src', src);
  }

  // 🔗 Event binding to all .btn-play button
  $('.btn-play').on('click', showVideoOverlay);
  // 🔗 Event binding to close button from overlay
  $('.btn-close-overlay').on('click', hideVideoOverlay);

  /*--------------------------------------------------------------
    Animate On Scroll (AOS)
  --------------------------------------------------------------*/

  // Initialize AOS
  AOS.init({
    duration: 800,
    once: true
  });

  /*--------------------------------------------------------------
    Dynamic Nav-Link Active Class
  --------------------------------------------------------------*/

  // Get current path eg. /homepage.php, fallback to index.php if empty
  let currentPage = window.location.pathname.split('/').pop();
  if (currentPage === '') {
    currentPage = 'index.php';
  }

  // Active class function
  function markActiveLink($el) {
    const linkHref = $el.attr('href');
    if (linkHref === currentPage) {
      $el.addClass('active');
    }
  }
  // Mark main nav-link
  $('.nav-link').each(function () {
    markActiveLink($(this));
  });
  // Mark dropdown item and parent
  $('.dropdown-menu .dropdown-item').each(function () {
    const $item = $(this);
    const linkHref = $item.attr('href');
    if (linkHref === currentPage) {
      $item.addClass('active');
      $item.closest('.dropdown').find('.nav-link').addClass('active');
    }
  });
  // Mark another link at footer or other parts
  $('.links-secondary').each(function () {
    markActiveLink($(this));
  });

  /*--------------------------------------------------------------
    Back To Top Button
  --------------------------------------------------------------*/
  const $backToTop = $('#back-to-top');

  $(window).on('scroll', function () {
    if ($(window).scrollTop() > 300) {
      $backToTop.addClass('show');
    } else {
      $backToTop.removeClass('show');
    }
  });

  $backToTop.on('click', function () {
    $('html, body').animate({ scrollTop: 0 }, 500);
  });

});