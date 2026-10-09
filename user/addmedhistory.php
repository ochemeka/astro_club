<?php
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");
$pagetitle = "Add Vitals";
confirm_logged_in();

$current_user_id = $_SESSION['user_id'];

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

$member = get_user_id($_SESSION['email']);
$member = mysqli_fetch_array($member);

$errors = array();

if (isset($_POST['submit'])) {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token. Please refresh the page.");
    }

    $required_fields = array('height','weight','bp','pulse');
    foreach ($required_fields as $fieldname) {
        if (!isset($_POST[$fieldname]) || empty(trim($_POST[$fieldname]))) {
            $errors[] = ucfirst($fieldname) . " is required.";
        }
    }

    if (empty($errors)) {
        $height = mysqli_real_escape_string($connection, $_POST['height']);
        $weight = mysqli_real_escape_string($connection, $_POST['weight']);
        $pulse = mysqli_real_escape_string($connection, $_POST['pulse']);
        $bp = mysqli_real_escape_string($connection, $_POST['bp']);
        $bmi = $weight / ($height * $height);

        $query = "INSERT INTO vitals_tbl (id, pulse_rate, blood_pressure, weight, height, bmi, updated_at, status)
                  VALUES ('{$current_user_id}', '{$pulse}', '{$bp}', '{$weight}', '{$height}', '{$bmi}', NOW(), 1)";

        $result = mysqli_query($connection, $query);
        if ($result) {
            set_flash('success', 'Vitals record added successfully!');
            redirect_to('medical_history.php');
            exit;
        } else {
            error_log("addmedhistory insert failed: " . mysqli_error($connection));
            $errors[] = "Database insert failed. Please try again.";
        }
    }
}
?>

<?php include("includes/header_side.php"); ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add Vitals</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item"><a href="medical_history.php">Vitals History</a></li>
            <li class="breadcrumb-item active">Add Vitals</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-heartbeat mr-1"></i> Record New Vitals</h3>
            </div>
            <form action="addmedhistory.php" method="post">
              <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
              <div class="card-body">
                <?php if (!empty($errors)) { ?>
                  <div class="alert alert-danger">
                    <?php foreach ($errors as $error) { echo htmlspecialchars($error) . "<br>"; } ?>
                  </div>
                <?php } ?>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Blood Pressure</label>
                      <input type="text" name="bp" class="form-control" placeholder="e.g. 120/80" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Pulse Rate</label>
                      <input type="text" name="pulse" class="form-control" placeholder="e.g. 72 bpm" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Weight (kg)</label>
                      <input type="text" name="weight" class="form-control" placeholder="e.g. 70" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Height (m)</label>
                      <input type="text" name="height" class="form-control" placeholder="e.g. 1.75" required>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save Vitals</button>
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
