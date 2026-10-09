<?php
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");
confirm_logged_in();

$pagetitle = "Edit Vitals";

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    set_flash('error', 'Invalid record ID.');
    redirect_to("medical_history.php");
    exit;
}
$vital_id = $_GET['id'];

$message = '';

if (isset($_POST['submit'])) {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token. Please refresh the page.");
    }

    $pulse_rate = trim($_POST['pulse_rate']);
    $blood_pressure = trim($_POST['blood_pressure']);
    $weight = trim($_POST['weight']);
    $height = trim($_POST['height']);
    $bmi = trim($_POST['bmi']);

    $query = "UPDATE vitals_tbl SET pulse_rate=?, blood_pressure=?, weight=?, height=?, bmi=?, updated_at=NOW() WHERE vitals_id=?";
    $stmt = mysqli_prepare($connection, $query);
    if (!$stmt) {
        error_log("editmedhistory prepare failed: " . mysqli_error($connection));
        $message = "Update failed. Please try again.";
    } else {
        mysqli_stmt_bind_param($stmt, "sssssi", $pulse_rate, $blood_pressure, $weight, $height, $bmi, $vital_id);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            mysqli_stmt_close($stmt);
            set_flash('success', 'Vitals record updated successfully!');
            redirect_to("medical_history.php");
            exit;
        } else {
            error_log("editmedhistory execute failed: " . mysqli_error($connection));
            $message = "Update failed. Please try again.";
        }
        mysqli_stmt_close($stmt);
    }
}

$query = "SELECT * FROM vitals_tbl WHERE vitals_id = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "i", $vital_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    // Record found
} else {
    set_flash('error', 'Record not found.');
    redirect_to("medical_history.php");
    exit;
}
?>

<?php include("includes/header_side.php"); ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Vitals Record</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item"><a href="medical_history.php">Vitals History</a></li>
            <li class="breadcrumb-item active">Edit</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <?php if (!empty($message)) { echo "<div class='alert alert-danger'>" . htmlspecialchars($message) . "</div>"; } ?>

      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-edit mr-1"></i> Update Vitals</h3>
            </div>
            <form action="editmedhistory.php?id=<?php echo htmlspecialchars($vital_id); ?>" method="post">
              <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Pulse Rate</label>
                      <input type="text" name="pulse_rate" class="form-control" value="<?php echo htmlspecialchars($row['pulse_rate']); ?>" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Blood Pressure</label>
                      <input type="text" name="blood_pressure" class="form-control" value="<?php echo htmlspecialchars($row['blood_pressure']); ?>" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Weight (kg)</label>
                      <input type="text" name="weight" class="form-control" value="<?php echo htmlspecialchars($row['weight']); ?>" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Height (m)</label>
                      <input type="text" name="height" class="form-control" value="<?php echo htmlspecialchars($row['height']); ?>" required>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>BMI</label>
                  <input type="text" name="bmi" class="form-control" value="<?php echo htmlspecialchars($row['bmi']); ?>" readonly>
                  <small class="text-muted">BMI is calculated automatically.</small>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Update Record</button>
                <a href="medical_history.php" class="btn btn-default float-right">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include("includes/footer.php"); ?>
