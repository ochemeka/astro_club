<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/pagination.php"); ?>
<?php
confirm_logged_in();


// Get current user data
$member = get_user_id($_SESSION['email']);
$member = mysqli_fetch_array($member);
?>


<aside style="background-color:#272e48;" class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo: Back Home -->
  <a href="../index.php" class="brand-link">
    <img src="dist/img/sms.png" alt="SMS" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Back Home</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- User Panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="<?= $image; ?>"
             class="img-circle elevation-2"
             alt="User Image"
             style="width:40px;height:40px;object-fit:cover;">
    </div>
    <div class="info">
        <a href="memberprofile.php" class="d-block">
            <?= $username; ?>
        </a>
    </div>
</div>
    <!-- Rest of your sidebar code remains the same -->
      

    <!-- Sidebar Search (optional) -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item menu-open">
          <a href="dashboard.php" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Manage History -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Manage Vitals History
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="medical_history.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Vitals  History</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="addmedhistory.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p> Add  Vitals</p>
              </a>
            </li>
          </ul>
        </li>
<li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Manage Vaccination
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="vaccination_history.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Vaccination History</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="vaccination.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Vaccination</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- medication  -->
         <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-edit"></i>
            <p>
              Manage Medication 
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="manage_med.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Manage Medication</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="add_currentmed.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Medication</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- Manage Settings -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
              Manage Settings
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="memberprofile.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Profile</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="imagesetting.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Upload Photo</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="change_pass.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Change Password</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Log Out -->
        <li class="nav-item">
          <a href="logout.php" class="nav-link">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Log Out</p>
          </a>
        </li>

        <br><br><br><br><br><br><br>

        <!-- Back Home -->
        <li class="nav-item">
          <a href="../index.php" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>Back Home</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
