<?php
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");
include('../includes/image_upload_functions.php');

$pagetitle = "My Profile";
confirm_logged_in();

$member = get_user_id($_SESSION['email']);
$member = mysqli_fetch_array($member);
?>

<?php include("includes/header_side.php"); ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>My Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">Profile</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-4">
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <?php if (!empty($member["image"])): ?>
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?php echo SITE_PATH; ?>uploads/<?php echo htmlspecialchars($member['image']); ?>"
                       alt="<?php echo htmlspecialchars($member['username']); ?>"
                       style="width:128px;height:128px;object-fit:cover;">
                <?php else: ?>
                  <img class="profile-user-img img-fluid img-circle"
                       src="dist/img/user2-160x160.jpg"
                       alt="<?php echo htmlspecialchars($member['username']); ?>"
                       style="width:128px;height:128px;">
                <?php endif; ?>
              </div>

              <h3 class="profile-username text-center"><?php echo htmlspecialchars($member['fname'] . ' ' . $member['lname']); ?></h3>
              <p class="text-muted text-center"><?php echo htmlspecialchars($member['username']); ?></p>

              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Email</b> <a class="float-right"><?php echo htmlspecialchars($member['email']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Phone</b> <a class="float-right"><?php echo htmlspecialchars($member['phone'] ?? 'N/A'); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Gender</b> <a class="float-right"><?php echo htmlspecialchars($member['gender'] ?? 'N/A'); ?></a>
                </li>
              </ul>

              <a href="editprofile.php" class="btn btn-primary btn-block"><i class="fas fa-edit mr-1"></i> Edit Profile</a>
              <a href="imagesetting.php" class="btn btn-default btn-block"><i class="fas fa-camera mr-1"></i> Change Photo</a>
            </div>
          </div>
        </div>

        <div class="col-md-8">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#personal" data-toggle="tab">Personal Information</a></li>
                <li class="nav-item"><a class="nav-link" href="#medical" data-toggle="tab">Medical Summary</a></li>
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="personal">
                  <table class="table table-bordered">
                    <tr><th style="width:200px">Full Name</th><td><?php echo htmlspecialchars($member['fname'] . ' ' . $member['lname']); ?></td></tr>
                    <tr><th>Username</th><td><?php echo htmlspecialchars($member['username']); ?></td></tr>
                    <tr><th>Gender</th><td><?php echo htmlspecialchars($member['gender'] ?? 'N/A'); ?></td></tr>
                    <tr><th>Phone</th><td><?php echo htmlspecialchars($member['phone'] ?? 'N/A'); ?></td></tr>
                    <tr><th>Email</th><td><?php echo htmlspecialchars($member['email']); ?></td></tr>
                    <tr><th>Address</th><td><?php echo htmlspecialchars($member['address'] ?? 'N/A'); ?></td></tr>
                    <tr><th>Member ID</th><td><?php echo htmlspecialchars($member['mem_id'] ?? 'N/A'); ?></td></tr>
                  </table>
                </div>
                <div class="tab-pane" id="medical">
                  <?php
                  $current_user_id = $_SESSION['user_id'];
                  $vitals_q = mysqli_prepare($connection, "SELECT COUNT(*) FROM vitals_tbl WHERE id = ?");
                  mysqli_stmt_bind_param($vitals_q, "i", $current_user_id);
                  mysqli_stmt_execute($vitals_q);
                  mysqli_stmt_bind_result($vitals_q, $vitals_count);
                  mysqli_stmt_fetch($vitals_q);
                  mysqli_stmt_close($vitals_q);

                  $vac_q = mysqli_prepare($connection, "SELECT COUNT(*) FROM vitals_tbl WHERE id = ? AND vacination IS NOT NULL");
                  mysqli_stmt_bind_param($vac_q, "i", $current_user_id);
                  mysqli_stmt_execute($vac_q);
                  mysqli_stmt_bind_result($vac_q, $vac_count);
                  mysqli_stmt_fetch($vac_q);
                  mysqli_stmt_close($vac_q);

                  $med_q = mysqli_prepare($connection, "SELECT COUNT(*) FROM vitals_tbl WHERE id = ? AND current_med IS NOT NULL");
                  mysqli_stmt_bind_param($med_q, "i", $current_user_id);
                  mysqli_stmt_execute($med_q);
                  mysqli_stmt_bind_result($med_q, $med_count);
                  mysqli_stmt_fetch($med_q);
                  mysqli_stmt_close($med_q);
                  ?>
                  <table class="table table-bordered">
                    <tr><th style="width:200px">Vitals Records</th><td><a href="medical_history.php"><?php echo $vitals_count; ?> records</a></td></tr>
                    <tr><th>Vaccinations</th><td><a href="vaccination_history.php"><?php echo $vac_count; ?> records</a></td></tr>
                    <tr><th>Medications</th><td><a href="manage_med.php"><?php echo $med_count; ?> records</a></td></tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include("includes/footer.php"); ?>
