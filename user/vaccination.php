<?php
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");
$pagetitle = "Add Vaccination";
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

    if (empty($_POST['vaccination'])) {
        $errors[] = "Vaccination name is required.";
    } else {
        $vaccination = mysqli_real_escape_string($connection, $_POST['vaccination']);
    }

    if (isset($_FILES['vaccination_img']) && $_FILES['vaccination_img']['error'] == 0) {
        $target_dir = "../uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $filename = basename($_FILES['vaccination_img']['name']);
        $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
        $new_filename = "vacc_" . time() . "." . $file_ext;
        $target_file = $target_dir . $new_filename;

        $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array(strtolower($file_ext), $allowed_types)) {
            if (!move_uploaded_file($_FILES['vaccination_img']['tmp_name'], $target_file)) {
                $errors[] = "Failed to upload image.";
            }
        } else {
            $errors[] = "Invalid image type. Only jpg, jpeg, png, gif allowed.";
        }
    } else {
        $errors[] = "Vaccination image is required.";
    }

    if (empty($errors)) {
        $query = "INSERT INTO vitals_tbl (id, vacination, vacination_img) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iss", $current_user_id, $vaccination, $new_filename);
            if (mysqli_stmt_execute($stmt)) {
                set_flash('success', 'Vaccination record added successfully!');
                redirect_to('vaccination_history.php');
                exit;
            } else {
                error_log("vaccination insert failed: " . mysqli_error($connection));
                $errors[] = "Database insert failed. Please try again.";
            }
            mysqli_stmt_close($stmt);
        } else {
            error_log("vaccination prepare failed: " . mysqli_error($connection));
            $errors[] = "Database error. Please try again later.";
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
          <h1>Add Vaccination</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item"><a href="vaccination_history.php">Vaccination History</a></li>
            <li class="breadcrumb-item active">Add Vaccination</li>
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
              <h3 class="card-title"><i class="fas fa-syringe mr-1"></i> Record New Vaccination</h3>
            </div>
            <form action="vaccination.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
              <div class="card-body">
                <?php if (!empty($errors)) { ?>
                  <div class="alert alert-danger">
                    <?php foreach ($errors as $error) { echo htmlspecialchars($error) . "<br>"; } ?>
                  </div>
                <?php } ?>

                <div class="form-group">
                  <label>Vaccination Name</label>
                  <input type="text" name="vaccination" class="form-control" placeholder="e.g. COVID-19 Vaccine" required>
                </div>

                <div class="form-group">
                  <label>Vaccination Image</label>
                  <div class="custom-file">
                    <input type="file" name="vaccination_img" class="custom-file-input" accept="image/*" required id="vaccImg">
                    <label class="custom-file-label" for="vaccImg">Choose image...</label>
                  </div>
                  <small class="text-muted">Accepted formats: JPG, PNG, GIF</small>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save Vaccination</button>
                <a href="vaccination_history.php" class="btn btn-default float-right">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
  var label = e.target.nextElementSibling;
  label.textContent = e.target.files[0] ? e.target.files[0].name : 'Choose image...';
});
</script>

<?php include("includes/footer.php"); ?>
