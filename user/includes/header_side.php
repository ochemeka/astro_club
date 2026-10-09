
<?php
if (!isset($member)) {
    $member = array(
        'username' => $_SESSION['username'] ?? 'User',
        'image' => '',
        'img_alt' => ''
    );
    $user_result = get_user_id($_SESSION['email']);
    if ($user_result && mysqli_num_rows($user_result) > 0) {
        $member_data = mysqli_fetch_array($user_result);
        if ($member_data) {
            $member = array_merge($member, $member_data);
        }
    }
}
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo isset($pagetitle) ? htmlspecialchars($pagetitle) . ' - ' : ''; ?>Lekki Astro Sports Club Medical</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../index.php" class="nav-link">Back to Site</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="logout.php">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </li>
    </ul>
  </nav>

  <aside style="background-color:#272e48;" class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="../index.php" class="brand-link">
      <span class="brand-text font-weight-light" style="color:#fff;">Astro Medical</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php if (!empty($member["image"])): ?>
            <img class="img-circle elevation-2"
                 src="<?php echo SITE_PATH; ?>uploads/<?php echo htmlspecialchars($member["image"]); ?>"
                 alt="<?php echo htmlspecialchars(($member['fname'] ?? '') . ' ' . ($member['lname'] ?? '')); ?>"
                 style="width:35px;height:35px;">
          <?php else: ?>
            <img class="img-circle elevation-2"
                 src="dist/img/user2-160x160.jpg"
                 alt="<?php echo htmlspecialchars(($member['fname'] ?? '') . ' ' . ($member['lname'] ?? '')); ?>"
                 style="width:35px;height:35px;">
          <?php endif; ?>
        </div>
        <div class="info">
          <a href="dashboard.php" class="d-block"><?php
            $fullname = trim(($member['fname'] ?? '') . ' ' . ($member['lname'] ?? ''));
            echo htmlspecialchars(!empty($fullname) ? $fullname : ($member['username'] ?? 'Member'));
          ?></a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link <?php echo ($currentPage === 'dashboard.php') ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link <?php echo in_array($currentPage, ['medical_history.php','addmedhistory.php','editmedhistory.php']) ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-heartbeat"></i>
              <p>Manage Vitals <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="medical_history.php" class="nav-link <?php echo ($currentPage === 'medical_history.php') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vitals History</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="addmedhistory.php" class="nav-link <?php echo ($currentPage === 'addmedhistory.php') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Vitals</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link <?php echo in_array($currentPage, ['vaccination_history.php','vaccination.php','edit_vaccination.php']) ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-syringe"></i>
              <p>Manage Vaccination <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="vaccination_history.php" class="nav-link <?php echo ($currentPage === 'vaccination_history.php') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vaccination History</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="vaccination.php" class="nav-link <?php echo ($currentPage === 'vaccination.php') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Vaccination</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link <?php echo in_array($currentPage, ['manage_med.php','add_currentmed.php','edit_med.php']) ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-pills"></i>
              <p>Current Medication <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="manage_med.php" class="nav-link <?php echo ($currentPage === 'manage_med.php') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Manage Medication</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="add_currentmed.php" class="nav-link <?php echo ($currentPage === 'add_currentmed.php') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Medication</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link <?php echo in_array($currentPage, ['memberprofile.php','editprofile.php','imagesetting.php','change_pass.php']) ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-cog"></i>
              <p>Settings <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="memberprofile.php" class="nav-link <?php echo ($currentPage === 'memberprofile.php') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="imagesetting.php" class="nav-link <?php echo ($currentPage === 'imagesetting.php') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Upload Photo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="change_pass.php" class="nav-link <?php echo ($currentPage === 'change_pass.php') ? 'active' : ''; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Change Password</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
