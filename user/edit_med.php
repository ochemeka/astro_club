<?php
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");
confirm_logged_in();

$pagetitle = "Edit Medical Condition";

// Fetch current user data
$member = get_user_id($_SESSION['email']);
$member = mysqli_fetch_array($member);
$current_user_id = $_SESSION['user_id'];

// Validate GET ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: manage_med.php");
    exit;
}

$edit_id = intval($_GET['id']);

// Fetch existing record
$query = "SELECT current_med FROM vitals_tbl WHERE vitals_id = ? AND id = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "ii", $edit_id, $current_user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $current_med);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (!$current_med) {
    header("Location: manage_med.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_med_new = trim($_POST['current_med']);

    if (!empty($current_med_new)) {
        $query = "UPDATE vitals_tbl SET current_med = ?, med_advice_updated_at = NOW() WHERE vitals_id = ? AND id = ?";
        $stmt = mysqli_prepare($connection, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sii", $current_med_new, $edit_id, $current_user_id);

            if (mysqli_stmt_execute($stmt)) {
                $success_message = "Medical Condition updated successfully!";
                // Redirect to manage_med.php after update
                header("Location: manage_med.php");
                exit;
            } else {
                $error_message = "Failed to update Medical Condition. Please try again.";
            }

            mysqli_stmt_close($stmt);
        } else {
            error_log("edit_med prepare failed: " . mysqli_error($connection));
            $error_message = "Database error. Please try again later.";
        }
    } else {
        $error_message = "Please enter your medical condition.";
    }
}

//include("includes/head_add.php");
include("includes/header_side.php");
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Medical Condition</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item"><a href="manage_med.php">Manage Medical Condition</a></li>
            <li class="breadcrumb-item active">Edit Medical Condition</li>
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

      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Edit Your Medical Condition</h3>
        </div>

        <form method="POST" action="">
          <div class="card-body">
            <div class="form-group">
              <label for="current_med">Medical Condition</label>
              <textarea name="current_med" id="current_med" class="form-control" rows="4" required><?php echo htmlspecialchars($current_med); ?></textarea>
            </div>
          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update Medical Condition</button>
            <a href="manage_med.php" class="btn btn-secondary">Back</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

<?php include("includes/footer.php"); ?>
