<?php
require_once "../includes/session.php";
require_once "../includes/connection.php";
require_once "../includes/functions.php";
require_once "../includes/constant.php";
require_once "includes/MemberManager.php";

$pagetitle = "Manage Member Account";

include "includes/header.php";
admin_logged_in();

// CSRF Token generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

$memberManager = new MemberManager($connection);
$user_id = intval($_GET['pid']);
$user = $memberManager->getMember($user_id);

$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'], $_POST['csrf_token'])) {
    if (hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        // Validate required fields
        $errors = [];
        foreach (['username', 'email', 'phone', 'address'] as $field) {
            if (empty(trim($_POST[$field]))) {
                $errors[] = ucfirst($field) . " is required.";
            }
        }

        // Handle image upload
        $image = $user['image'];
        if (!empty($_FILES['file_1']['name'])) {
            require_once "../includes/image_upload_functions.php";
            include "../includes/image_upload_app1.php";
            if (strlen($db_images) < 7) {
                $errors[] = "Image upload failed.";
            } else {
                $image = $db_images;
            }
        }

        if (empty($errors)) {
            if ($memberManager->updateMember(
                $user_id,
                trim($_POST['username']),
                trim($_POST['email']),
                trim($_POST['phone']),
                trim($_POST['address']),
                $image
            )) {
                redirect_to('manage_members.php?status=updated');
            } else {
                $message = "Error updating member.";
            }
        } else {
            $message = implode("<br>", $errors);
        }
    } else {
        $message = "Invalid CSRF token.";
    }
}
?>

<?php include 'includes/sidebar.php'; ?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Manage Member <small>Edit</small></h1>
  </section>

  <section class="content">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Edit Member Account</h3>
      </div>

      <?php if (!empty($message)): ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
      <?php endif; ?>

      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>">

        <div class="box-body">
          <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" required>
          </div>

          <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
          </div>

          <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']); ?>" required>
          </div>

          <div class="form-group">
            <label>Address:</label>
            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($user['address']); ?>" required>
          </div>

          <div class="form-group">
            <label>Current Image:</label><br>
            <?php foreach (explode(',', $user['image']) as $img) :
              if (strlen($img) > 4): ?>
                <img src="<?= SITE_PATH; ?>uploads/<?= htmlspecialchars($img); ?>" height="70" width="70" alt="Member Image">
            <?php endif; endforeach; ?>
          </div>

          <div class="form-group">
            <label>Change Image:</label>
            <input type="file" name="file_1" class="form-control">
          </div>
        </div>

        <div class="box-footer">
          <button type="submit" name="submit" class="btn btn-primary">Update Member</button>
          <a href="manage_members.php" class="btn btn-default">Back to Members List</a>
        </div>
      </form>
    </div>
  </section>
</div>

<?php include 'includes/footer.php'; ?>
