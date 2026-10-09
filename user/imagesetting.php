<?php 
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");
require_once("../includes/pagination.php");
require_once('../includes/image_upload_functions.php');

$pagetitle = "Change Profile Image";
confirm_logged_in();

// CSRF Token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Get current user data
$member_result = get_user_id($_SESSION['email']);
$member = mysqli_fetch_array($member_result);

// Handle form submission
$errors = [];
$message = "";

if (isset($_POST['submit'])) {

    // CSRF validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token. Please refresh the page.");
    }

    // Check if a file is uploaded
    if (isset($_FILES['file_1']) && $_FILES['file_1']['error'] != UPLOAD_ERR_NO_FILE) {

        $file = $_FILES['file_1'];

        // Validate file size (max 2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            $errors[] = "File size must be less than 2MB.";
        }

        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowed_types)) {
            $errors[] = "Only JPG, PNG, and GIF files are allowed.";
        }

        // Process the upload if no errors
        if (empty($errors)) {

            // Generate a unique file name
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $new_filename = uniqid('img_', true) . "." . $ext;

            $upload_path = "../uploads/" . $new_filename;

            if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                // Delete old image if it exists and is not a default
                $old_image = $member['image'];
                if (!empty($old_image) && $old_image !== $new_filename) {
                    $old_path = "../uploads/" . $old_image;
                    if (file_exists($old_path) && is_file($old_path)) {
                        unlink($old_path);
                    }
                }
                // Upload successful, update database
                $update_query = "UPDATE newmember_tbl 
                                 SET image = '{$new_filename}'
                                 WHERE id = '{$member['id']}'";

                if (mysqli_query($connection, $update_query)) {
                    $message = "Profile image updated successfully.";
                    // Refresh member data
                    $member['image'] = $new_filename;
                } else {
                    $errors[] = "Failed to update profile image in the database.";
                }

            } else {
                $errors[] = "Failed to upload the file. Please try again.";
            }

        }

    } else {
        $errors[] = "Please select an image to upload.";
    }
}
?>

<?php include("includes/header_side.php"); ?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Change Profile Image</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">Change Profile Image</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Change Profile Image</h3>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
              <input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>">
              
              <?php 
                if (!empty($message)) {
                    echo "<div class='alert alert-success'>{$message}</div>";
                }
                if (!empty($errors)) { 
                    foreach($errors as $error) {
                        echo "<div class='alert alert-danger'>{$error}</div>";
                    }
                }
              ?>

              <div class="card-body">
                <div class="form-group">
                  <label>Current Image</label><br>
                  <?php 
                  if (!empty($member["image"])) {
                      echo '<img src="' . SITE_PATH . 'uploads/' . $member["image"] . '" height="150" width="200" alt="Profile Image" />';
                  } else {
                      echo 'No image uploaded yet.';
                  }
                  ?>
                </div>

                <div class="form-group">
                  <label>Select Image: <em style="color:#f30;">Note: Maximum size 2MB</em></label>
                  <input name="file_1" type="file" class="form-control" />
                </div>
              </div>
              
              <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include('includes/footer.php'); ?>
