<?php
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");
require_once("../includes/ratelimit.php");

$pagetitle = "Admin Login";

if (admin_login()) {
    redirect_to("dashboard.php");
}

$message = '';
$errors = array();
$username = '';

// Identity for rate limiting: 'a:' prefix = admin login
$rl_identity = '';
if (isset($_POST['username']) && trim($_POST['username']) !== '') {
    $rl_identity = 'a:' . strtolower(trim($_POST['username']));
}

// Escalating rate limit: 5 failures -> 15 min block;
// submitting again during a block -> 1 hour, then 6 hours (max)
$rate_blocked_seconds = rl_block_remaining($connection, $rl_identity);
if ($rate_blocked_seconds > 0 && isset($_POST['submit'])) {
    // Deliberate attempt while blocked: escalate one level
    $rate_blocked_seconds = rl_escalate_lock($connection, $rl_identity);
}
if ($rate_blocked_seconds > 0) {
    $message = rl_lock_message($rate_blocked_seconds);
}

if (isset($_POST['submit']) && empty($message)) {
    $required_fields = array('username', 'password');
    $errors = array_merge($errors, check_required_fields($required_fields, $_POST));

    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $rl_identity = 'a:' . strtolower($username);

    if (empty($errors)) {
        // Re-check block now that the target account is known (IP + account)
        $rate_blocked_seconds = rl_block_remaining($connection, $rl_identity);
        if ($rate_blocked_seconds > 0) {
            $message = rl_lock_message($rate_blocked_seconds);
        }
    }

    if (empty($errors) && empty($message)) {
        $stmt = $connection->prepare("SELECT adm_id, adm_username, adm_password, adm_status FROM admintbl WHERE adm_username = ? AND adm_status = 1 LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result_set = $stmt->get_result();

        if ($result_set && mysqli_num_rows($result_set) == 1) {
            $found_user = mysqli_fetch_array($result_set);
            $stored_password = $found_user['adm_password'];

            if (password_verify($password, $stored_password)) {
                session_regenerate_id(true);
                $_SESSION['adm_id'] = $found_user['adm_id'];
                $_SESSION['adm_username'] = $found_user['adm_username'];
                $_SESSION['adm_status'] = $found_user['adm_status'];
                rl_clear_failures($connection, $rl_identity);
                redirect_to("dashboard.php");
                exit;
            } else {
                $lock_seconds = rl_record_failure($connection, $rl_identity);
                $message = ($lock_seconds > 0)
                    ? rl_lock_message($lock_seconds)
                    : "Username/password combination incorrect. Please try again.";
            }
        } else {
            $lock_seconds = rl_record_failure($connection, $rl_identity);
            $message = ($lock_seconds > 0)
                ? rl_lock_message($lock_seconds)
                : "Username/password combination incorrect. Please try again.";
        }
        $stmt->close();
    }
} else {
    if (isset($_GET['logout']) && $_GET['logout'] == 1) {
        $message = "You are now logged out.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo htmlspecialchars($pagetitle); ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo ADMIN_PATH; ?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo ADMIN_PATH; ?>bootstrap/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo ADMIN_PATH; ?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo ADMIN_PATH; ?>plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="<?php echo ADMIN_PATH; ?>dist/css/skins/skin-blue.min.css">
</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="<?php echo ADMIN_PATH; ?>dashboard.php"><b>Lekki Astro Sports Club Medical</b></a>
    </div>
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <?php if (!empty($message)) { ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
      <?php } ?>
      <?php if (!empty($errors)) { display_errors($errors); } ?>

      <form action="" method="post">
        <div class="form-group has-feedback">
          <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8"></div>
          <div class="col-xs-4">
            <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="<?php echo ADMIN_PATH; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <script src="<?php echo ADMIN_PATH; ?>bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo ADMIN_PATH; ?>plugins/iCheck/icheck.min.js"></script>
  <script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue'
      });
    });
  </script>
</body>
</html>
