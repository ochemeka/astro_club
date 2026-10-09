<!-- Banner Section -->
<section class="section position-relative"
  style="background-image: url('./assets/image/Place-Holder-1920x1280.jpg'); height: 40vh;">
  <div class="bg-overlay-secondary"></div>
  <div class="b-container h-100 position-relative pt-4 text-white" style="z-index: 2;">
    <div
      class="col-10 d-flex flex-column w-100 h-100 justify-content-center align-items-center text-center text-white gap-3 font-1">
      <h1 class="display-2 mb-0" style="font-weight: 900;">
        <?php if (isset($page_title) && !empty($page_title)) {
          echo $page_title;
        } ?></h1>
      <nav aria-label="breadcrumb" style="font-weight: 900;">
        <ol class="breadcrumb justify-content-center align-items-center">
          <li class="breadcrumb-item font-1">
            <a class="text-decoration-none text-primary-color" href="index.php">Homepage</a>
          </li>
          <!-- <li class="breadcrumb-item text-white">
            Services
          </li> -->
          <li class="breadcrumb-item text-white active" aria-current="page">
            <?php if (isset($page_title) && !empty($page_title)) {
              echo $page_title;
            } ?>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</section>
<!-- #banner end -->