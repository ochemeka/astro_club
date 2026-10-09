<?php
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");
confirm_logged_in();

$pagetitle = "Current Medication";

// Fetch current user data
$member = get_user_id($_SESSION['email']);
$member = mysqli_fetch_array($member);
$current_user_id = $_SESSION['user_id'];

// CSRF Token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // CSRF validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token. Please refresh the page.");
    }

    $current_med = trim($_POST['current_med']);

    if (!empty($current_med)) {
        // Insert into vitals_tbl
       $query = "INSERT INTO vitals_tbl (id, current_med, med_advice_updated_at) VALUES (?, ?, NOW())";
        $stmt = mysqli_prepare($connection, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "is", $current_user_id, $current_med);

            if (mysqli_stmt_execute($stmt)) {
                // Redirect to manage_med.php upon success
                header("Location: manage_med.php");
                exit;
            } else {
                $error_message = "Error saving medication. Please try again.";
            }
            mysqli_stmt_close($stmt);
        } else {
            $error_message = "Database preparation failed. Please contact the administrator.";
        }
    } else {
        $error_message = "Please enter your current medication.";
    }
}

include("includes/header_side.php");
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Current Medication</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">Current Medication</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
      <?php endif; ?>

      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Enter Your Current Medication</h3>
            </div>
            <form method="POST" action="">
              <input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>">
              <div class="card-body">
                <div class="form-group">
                  <label for="current_med">Current Medication </label>
                  <textarea name="current_med" id="current_med" class="form-control" rows="4" placeholder="Enter your current medication here..." required></textarea>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save Medication</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<?php include("includes/footer.php"); ?>
