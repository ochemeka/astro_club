<?php
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");
confirm_logged_in();

$pagetitle = "Edit Vaccination";

$current_user_id = $_SESSION['user_id'];

// Validate GET ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: vaccination_history.php");
    exit;
}

$edit_id = intval($_GET['id']);

// Fetch vaccination record
$query = "SELECT vacination, vacination_img FROM vitals_tbl WHERE vitals_id = ? AND id = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "ii", $edit_id, $current_user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $vacination, $vacination_img);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// If record not found, redirect
if (!$vacination) {
    header("Location: vaccination_history.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vacination_new = trim($_POST['vacination']);

    if (!empty($vacination_new)) {
        // Handle image upload
        if (!empty($_FILES['vacination_img']['name'])) {
            $target_dir = "../uploads/";
            $file_name = time() . '_' . basename($_FILES['vacination_img']['name']);
            $target_file = $target_dir . $file_name;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check file is image
            $check = getimagesize($_FILES['vacination_img']['tmp_name']);
            if ($check === false) {
                $error_message = "File is not an image.";
                $uploadOk = 0;
            }

            // Allow certain formats
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                $error_message = "Only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Upload if valid
            if ($uploadOk) {
                if (move_uploaded_file($_FILES['vacination_img']['tmp_name'], $target_file)) {
                    // Delete old image if exists
                    if (!empty($vacination_img)) {
                        $old_path = "../uploads/" . $vacination_img;
                        if (file_exists($old_path)) {
                            unlink($old_path);
                        }
                    }
                    $vacination_img = $file_name;
                } else {
                    $error_message = "Error uploading your file.";
                }
            }
        }

        // Update database if no upload error
        if (!isset($error_message)) {
            $query = "UPDATE vitals_tbl SET vacination = ?, vacination_img = ?, updated_at = NOW() WHERE vitals_id = ? AND id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "ssii", $vacination_new, $vacination_img, $edit_id, $current_user_id);

            if (mysqli_stmt_execute($stmt)) {
                // Redirect to vaccination_history.php upon successful update
                header("Location: vaccination_history.php?updated=1");
                exit;
            } else {
                $error_message = "Failed to update record.";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        $error_message = "Please enter the vaccination name.";
    }
}

// Fetch current user for sidebar if not set
if (!isset($member)) {
    if (isset($_SESSION['username'])) {
        $member_query = get_user_id($_SESSION['email']);
        if ($member_query && mysqli_num_rows($member_query) > 0) {
            $member = mysqli_fetch_array($member_query);
        }
    }
}

include("includes/header_side.php");
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Vaccination</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item"><a href="vaccination_history.php">Vaccination History</a></li>
            <li class="breadcrumb-item active">Edit Vaccination</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
      <?php endif; ?>

      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Edit Vaccination Record</h3>
        </div>

        <form method="POST" enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group">
              <label for="vacination">Vaccination Name</label>
              <input type="text" name="vacination" id="vacination" class="form-control" value="<?php echo htmlspecialchars($vacination); ?>" required>
            </div>

            <div class="form-group">
              <label for="vacination_img">Vaccination Image</label><br>
              <?php if (!empty($vacination_img)): ?>
                <img src="../uploads/<?php echo $vacination_img; ?>" width="120" class="mb-2">
              <?php endif; ?>
              <input type="file" name="vacination_img" id="vacination_img" class="form-control-file">
              <small class="text-muted">Leave blank to keep existing image.</small>
            </div>
          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update Vaccination</button>
            <a href="vaccination_history.php" class="btn btn-secondary">Back</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

<?php include("includes/footer.php"); ?>
