<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/pagination.php"); ?>
<?php
$pagetitle = "Change Password";
confirm_logged_in();

// CSRF Token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Get current user data
$member = get_user_id($_SESSION['email']);
$member = mysqli_fetch_array($member);

// Start form processing
// Handle form submission
if (isset($_POST['submit'])) {

    // CSRF validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token. Please refresh the page.");
    }

    $errors = [];

    $old_pass = trim($_POST['password']);
    $new_pass = trim($_POST['pass_nw']);
    $confirm_pass = trim($_POST['pass_nw2']);

    if (empty($old_pass) || empty($new_pass) || empty($confirm_pass)) {
        $errors[] = "All fields are required";
    }

    if ($new_pass !== $confirm_pass) {
        $errors[] = "New passwords do not match";
    }

    if (strlen($new_pass) < 6) {
        $errors[] = "New password must be at least 6 characters long";
    }

    if (empty($errors)) {
        $current_password = $member['password']; // bcrypt hash only

        if (!empty($current_password) && password_verify($old_pass, $current_password)) {
            $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);

            $stmt = mysqli_prepare(
                $connection,
                "UPDATE newmember_tbl SET password = ?, temp_pass = '' WHERE id = ?"
            );
            mysqli_stmt_bind_param($stmt, "si", $new_hash, $member['id']);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                set_flash('success', 'Password changed successfully!');
                redirect_to("change_pass.php");
                exit;
            } else {
                mysqli_stmt_close($stmt);
                $errors[] = "Failed to update password. Please try again.";
            }
        } else {
            $errors[] = "Old password is incorrect.";
        }
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
                    <h1>Change Password</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
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
                            <h3 class="card-title">Change Password</h3>
                        </div>
                        <form method="post" action="">
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>">
                            <div class="card-body">
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0 ps-3">
                                        <?php foreach ($errors as $err): ?>
                                            <li><?= htmlspecialchars($err); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                  <label><strong>Current Password:</strong></label>
                  <input name="password" type="password" placeholder="Enter Current Password" class="form-control" />
                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input name="pass_nw" type="password" placeholder="Enter New Password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Confirm New Password</label>
                                    <input name="pass_nw2" type="password" placeholder="Confirm New Password" class="form-control" required>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" name="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('includes/footer.php'); ?>
