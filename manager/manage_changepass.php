<?php
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");

admin_logged_in();
$pagetitle = "Change Password";

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

$message = '';
$errors = [];

if (isset($_POST['submit'])) {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    $required_fields = ['password', 'pass_nw', 'con_password'];
    foreach ($required_fields as $fieldname) {
        if (empty(trim($_POST[$fieldname]))) {
            $errors[] = ucfirst(str_replace("_", " ", $fieldname)) . " is required.";
        }
    }

    if (empty($errors)) {
        $oldpass = $_POST['password'];
        $newpass = $_POST['pass_nw'];
        $con_password = $_POST['con_password'];

        if ($newpass !== $con_password) {
            $message = "Confirm password does not match!";
        } elseif (strlen($newpass) < 6) {
            $message = "New password must be at least 6 characters.";
        } else {
            $stmt = $connection->prepare("SELECT adm_password FROM admintbl WHERE adm_id = ? LIMIT 1");
            $stmt->bind_param("i", $_SESSION['adm_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            if ($row) {
                $db_password = $row['adm_password'];
                if (password_verify($oldpass, $db_password)) {
                    $new_hashed_password = password_hash($newpass, PASSWORD_DEFAULT);
                    $stmt = $connection->prepare("UPDATE admintbl SET adm_password = ? WHERE adm_id = ?");
                    $stmt->bind_param("si", $new_hashed_password, $_SESSION['adm_id']);
                    if ($stmt->execute()) {
                        $message = "Password updated successfully!";
                    } else {
                        $message = "Password update failed. Try again.";
                    }
                    $stmt->close();
                } else {
                    $message = "Incorrect old password!";
                }
            } else {
                $message = "Admin record not found.";
            }
        }
    }
}

include('includes/header.php');
include('includes/sidebar.php');
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Change Password</h1>
        <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Change Password</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Change Admin Password</h3>
                    </div>
                    <div class="box-body">
                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
                        <?php } ?>
                        <?php if (!empty($errors)) { ?>
                            <div class="alert alert-danger">
                                <ul>
                                <?php foreach ($errors as $err) { echo "<li>" . htmlspecialchars($err) . "</li>"; } ?>
                                </ul>
                            </div>
                        <?php } ?>

                        <form action="" method="post">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <div class="form-group">
                                <label>Old Password</label>
                                <input name="password" type="password" placeholder="Old Password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input name="pass_nw" type="password" placeholder="New Password (min 6 chars)" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input name="con_password" type="password" placeholder="Confirm New Password" class="form-control" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('includes/footer.php'); ?>
