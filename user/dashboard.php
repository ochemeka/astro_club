<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
confirm_logged_in();
$pagetitle = "Dashboard";

$member = get_user_id($_SESSION['email']);
$member = mysqli_fetch_array($member);

$current_user_id = $_SESSION['user_id'];

$vitals_count = 0;
$vitals_q = mysqli_prepare($connection, "SELECT COUNT(*) FROM vitals_tbl WHERE id = ?");
mysqli_stmt_bind_param($vitals_q, "i", $current_user_id);
mysqli_stmt_execute($vitals_q);
mysqli_stmt_bind_result($vitals_q, $vitals_count);
mysqli_stmt_fetch($vitals_q);
mysqli_stmt_close($vitals_q);

$vac_count = 0;
$vac_q = mysqli_prepare($connection, "SELECT COUNT(*) FROM vitals_tbl WHERE id = ? AND vacination IS NOT NULL");
mysqli_stmt_bind_param($vac_q, "i", $current_user_id);
mysqli_stmt_execute($vac_q);
mysqli_stmt_bind_result($vac_q, $vac_count);
mysqli_stmt_fetch($vac_q);
mysqli_stmt_close($vac_q);

$med_count = 0;
$med_q = mysqli_prepare($connection, "SELECT COUNT(*) FROM vitals_tbl WHERE id = ? AND current_med IS NOT NULL");
mysqli_stmt_bind_param($med_q, "i", $current_user_id);
mysqli_stmt_execute($med_q);
mysqli_stmt_bind_result($med_q, $med_count);
mysqli_stmt_fetch($med_q);
mysqli_stmt_close($med_q);
?>

<?php include("includes/header_side.php"); ?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Welcome, <?php echo htmlspecialchars(($member['fname'] ?? '') . ' ' . ($member['lname'] ?? '') ?: 'Member'); ?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-4 col-md-6 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-heartbeat"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Vitals Records</span>
              <span class="info-box-number"><?php echo $vitals_count; ?></span>
            </div>
            <a href="medical_history.php" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-syringe"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Vaccinations</span>
              <span class="info-box-number"><?php echo $vac_count; ?></span>
            </div>
            <a href="vaccination_history.php" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12">
          <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-pills"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Medications</span>
              <span class="info-box-number"><?php echo $med_count; ?></span>
            </div>
            <a href="manage_med.php" class="small-box-footer">View <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-user mr-1"></i> Quick Actions</h3>
            </div>
            <div class="card-body">
              <a href="addmedhistory.php" class="btn btn-primary btn-block mb-2"><i class="fas fa-plus"></i> Add New Vitals</a>
              <a href="vaccination.php" class="btn btn-success btn-block mb-2"><i class="fas fa-plus"></i> Add Vaccination</a>
              <a href="add_currentmed.php" class="btn btn-warning btn-block mb-2"><i class="fas fa-plus"></i> Add Medication</a>
              <a href="memberprofile.php" class="btn btn-info btn-block"><i class="fas fa-user"></i> View Profile</a>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Account Info</h3>
            </div>
            <div class="card-body">
              <table class="table table-bordered">
                <tr><th>Name</th><td><?php echo htmlspecialchars(($member['fname'] ?? '') . ' ' . ($member['lname'] ?? '') ?: $member['username'] ?? ''); ?></td></tr>
                <tr><th>Email</th><td><?php echo htmlspecialchars($member['email'] ?? ''); ?></td></tr>
                <tr><th>Phone</th><td><?php echo htmlspecialchars($member['phone'] ?? ''); ?></td></tr>
                <tr><th>Member ID</th><td><?php echo htmlspecialchars($member['mem_id'] ?? ''); ?></td></tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include("includes/footer.php"); ?>
