<!-- Header -->
<header class="bg-white">
  <div class="b-container">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
        <!-- Logo -->
        <a href="index.php" class="navbar-brand">
          <img src="./assets/image/Logo.png" alt="Main Logo">
        </a>

        <!-- Mobile toggle button -->
        <button class="navbar-toggler bg-primary-color border-0" type="button" data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
          aria-label="Toggle navigation">
          <span class="bi bi-list text-white fs-2"></span>
        </button>

        <!-- Navbar links + dropdown -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-4 justify-content-center flex-grow-1">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Homepage</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about-us.php">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact-us.php">Contact Us</a>
            </li>
            <li class="nav-item d-lg-none">
              <?php if(logged_in()){ ?>
                <a class="nav-link" href="user/dashboard.php">My Account</a>
              <?php } else { ?>
                <a class="nav-link" href="user/login.php">Login</a>
              <?php } ?>
            </li>
          </ul>

          <!-- Dropdown for user auth links -->
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle btn btn-quotes text-white px-3" href="#" id="userDropdown" role="button"
                 data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo logged_in() ? 'My Account' : 'Register'; ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <?php if(logged_in()){ ?> 
                  <li><a class="dropdown-item" href="user/dashboard.php">Dashboard</a></li>
                  <li><a class="dropdown-item" href="user/logout.php">Logout</a></li>
                <?php } else { ?>
                  <li><a class="dropdown-item" href="user/login.php">Login</a></li>
                  <li><a class="dropdown-item" href="user/register.php">Register</a></li>
                <?php } ?>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- #navbar end -->
  </div>
</header>
<!-- #header end -->
