<?php
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");
confirm_logged_in();

$current_user_id = $_SESSION['user_id'];

$pagetitle = "Manage Current Medical Condition";

// Get current user data
$member = get_user_id($_SESSION['email']);
$member = mysqli_fetch_array($member);


// Handle delete
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);

    $query = "DELETE FROM vitals_tbl WHERE vitals_id = ? AND id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ii", $delete_id, $current_user_id);

    if (mysqli_stmt_execute($stmt)) {
        $success_message = "Medical Condition deleted successfully!";
    } else {
        $error_message = "Failed to delete Medical Condition. Please try again.";
    }
    mysqli_stmt_close($stmt);
}

// Fetch medications
$query = "SELECT vitals_id, current_med, med_advice_updated_at FROM vitals_tbl WHERE id = ? ORDER BY vitals_id DESC";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "i", $current_user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

//include("includes/head_add.php");
include("includes/header_side.php");
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Manage Medication</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">Manage Medication</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
      <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
      <?php endif; ?>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Your Current Medication </h3>
          <div class="card-tools">
            <a href="add_currentmed.php" class="btn btn-success btn-sm">Add New Medication</a>
          </div>
        </div>

        <div class="card-body table-responsive">
          <?php if (mysqli_num_rows($result) > 0): ?>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>S/N</th>
                <th>Medical Condition</th>
                <th>Date Added</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sn = 1;
              while ($row = mysqli_fetch_assoc($result)):
              ?>
              <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo nl2br(htmlspecialchars($row['current_med'] ?? '')); ?></td>
                <td>
                  <?php //echo date("d M Y h:i A", strtotime($row['updated_at'])); ?>
                <?php 
  echo !empty($row['med_advice_updated_at']) ? date("d M Y h:i A", strtotime($row['med_advice_updated_at'])) : "N/A"; 
  ?>

                </td>
                <td>
                  <a href="edit_med.php?id=<?php echo $row['vitals_id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                  <a href="manage_med.php?delete=<?php echo $row['vitals_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this Medical Condition?');">Delete</a>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
          <?php else: ?>
            <div class="alert alert-info">No Medical Condition. <a href="add_currentmed.php">Add your current Medication</a>.</div>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </section>
</div>

<?php include("includes/footer.php"); ?>
