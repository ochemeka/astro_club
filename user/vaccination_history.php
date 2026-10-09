<?php
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");
confirm_logged_in();

$current_user_id = $_SESSION['user_id'];

$pagetitle = "Vaccination History";

// Get current user data
$member = get_user_id($_SESSION['email']);
$member = mysqli_fetch_array($member);


// Handle delete action
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);

    // Get filename to delete image file
    $query = "SELECT vacination_img FROM vitals_tbl WHERE vitals_id = ? AND id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ii", $delete_id, $current_user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $image_filename);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Delete image file if exists
    if ($image_filename) {
        $file_path = "../uploads/" . $image_filename;
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    // Delete record from DB
    $query = "DELETE FROM vitals_tbl WHERE vitals_id = ? AND id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ii", $delete_id, $current_user_id);
    if (mysqli_stmt_execute($stmt)) {
        set_flash('success', 'Vaccination record deleted successfully!');
        redirect_to('vaccination_history.php');
        exit;
    } else {
        set_flash('error', 'Failed to delete record.');
    }
    mysqli_stmt_close($stmt);
}

// Fetch vaccination records
$query = "SELECT vitals_id, vacination, vacination_img FROM vitals_tbl WHERE id = ? AND vacination IS NOT NULL ORDER BY vitals_id DESC";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "i", $current_user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Page layout begins
//include("includes/head_add.php");
include("includes/header_side.php");
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Vaccination History</h1>
          
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">Vaccination History</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Your Vaccination Records</h3>
            </div>

            <div class="card-body table-responsive">
              <?php if (mysqli_num_rows($result) > 0): ?>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>S/N</th>
                    <th>Vaccination Name</th>
                    <th>Image</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $sn = 1;
                  while ($row = mysqli_fetch_assoc($result)): ?>
                  <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo htmlspecialchars($row['vacination']); ?></td>
                    <td>
                      <?php if (!empty($row['vacination_img'])): ?>
                      <a href="../uploads/<?php echo $row['vacination_img']; ?>" target="_blank" rel="noopener noreferrer">
                        <img src="../uploads/<?php echo $row['vacination_img']; ?>" width="80" alt="Vaccination Image">
                      </a>
                      <?php else: ?>
                      No image
                      <?php endif; ?>
                    </td>
                    <td>
                      <a href="edit_vaccination.php?id=<?php echo $row['vitals_id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                      <a href="vaccination_history.php?delete=<?php echo $row['vitals_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this vaccination record?');">Delete</a>
                    </td>
                  </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
              <?php else: ?>
              <div class="alert alert-info">No vaccination records found. <a href="vaccination.php">Add one now</a>.</div>
              <?php endif; ?>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include("includes/footer.php"); ?>

