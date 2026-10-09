<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/pagination.php"); ?>
<?php require_once("../includes/ratelimit.php"); ?>
<?php
$pagetitle = "Members Secure Logins";
?>

<?php
if (logged_in()) {
    redirect_to(SITE_PATH . "user/dashboard.php");
}

$message = "";
$errors = [];

// Identity for rate limiting: 'u:' prefix = member login
$rl_identity = '';
if (isset($_POST['email']) && trim($_POST['email']) !== '') {
    $rl_identity = 'u:' . strtolower(trim($_POST['email']));
}

// Escalating rate limit: 5 failures -> 15 min block;
// submitting again during a block -> 1 hour, then 6 hours (max)
$rate_blocked_seconds = rl_block_remaining($connection, $rl_identity);
if ($rate_blocked_seconds > 0 && isset($_POST['login'])) {
    // Deliberate attempt while blocked: escalate one level
    $rate_blocked_seconds = rl_escalate_lock($connection, $rl_identity);
}
if ($rate_blocked_seconds > 0) {
    $message = rl_lock_message($rate_blocked_seconds);
}

// START FORM PROCESSING
if (isset($_POST['login']) && empty($message)) {
    
    // Perform validations on the form data
    $required_fields = array('email', 'password');
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
        $errors[] = ucfirst($field) . " is required";
    }
}

    // Sanitize input data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $rl_identity = 'u:' . strtolower($email);

    // Re-check block now that the target account is known (IP + account)
    if (empty($errors)) {
        $rate_blocked_seconds = rl_block_remaining($connection, $rl_identity);
        if ($rate_blocked_seconds > 0) {
            $message = rl_lock_message($rate_blocked_seconds);
        }
    }
    
    // Validate email format
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($errors) && empty($message)) {
        // Get the user data from database
        $query = "SELECT id, fname, lname, username, email, password, status FROM newmember_tbl WHERE email = ? LIMIT 1";
        $stmt = mysqli_prepare($connection, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result_set = mysqli_stmt_get_result($stmt);
            
            if ($result_set && mysqli_num_rows($result_set) == 1) {
                $found_user = mysqli_fetch_array($result_set);
                
                // Check if account is active
                if ($found_user['status'] != 1) {
                    $message = "Your account is not active. Please contact administrator.";
                } else {
                    // Verify password
                    if (password_verify($password, $found_user['password'])) {
                        // Password is correct, log the user in
                        session_regenerate_id(true);
                        $_SESSION['user_id'] = $found_user['id'];
                        $_SESSION['username'] = $found_user['username'];
                        $_SESSION['email'] = $found_user['email'];
                        $_SESSION['fname'] = $found_user['fname'];
                        $_SESSION['lname'] = $found_user['lname'];
                        $_SESSION['status'] = $found_user['status'];
                        // Reset rate limiter
                        rl_clear_failures($connection, $rl_identity);
                        
                        // Update last login time
                        $update_query = "UPDATE newmember_tbl SET last_login = NOW() WHERE id = ?";
                        $update_stmt = mysqli_prepare($connection, $update_query);
                        if ($update_stmt) {
                            mysqli_stmt_bind_param($update_stmt, "i", $found_user['id']);
                            mysqli_stmt_execute($update_stmt);
                            mysqli_stmt_close($update_stmt);
                        }
                        
                        mysqli_stmt_close($stmt);
                        redirect_to(SITE_PATH . "user/dashboard.php");
                        exit;
                    } else {
                        $lock_seconds = rl_record_failure($connection, $rl_identity);
                        $message = ($lock_seconds > 0) ? rl_lock_message($lock_seconds)
                            : "Username/password combination incorrect.<br />
                            Please make sure your caps lock key is off and try again.";
                    }
                }
            } else {
                // User not found
                $lock_seconds = rl_record_failure($connection, $rl_identity);
                $message = ($lock_seconds > 0) ? rl_lock_message($lock_seconds)
                    : "Username/password combination incorrect.<br />
                    Please make sure your caps lock key is off and try again.";
            }
            
            mysqli_stmt_close($stmt);
        } else {
            $message = "Database error. Please try again later.";
        }
    } else {
        // Display validation errors
        if (count($errors) > 0) {
            $message = "<strong>Please correct the following errors:</strong><br /><ul>";
            foreach ($errors as $error) {
                $message .= "<li>" . htmlspecialchars($error) . "</li>";
            }
            $message .= "</ul>";
        }
    }
} else {
    // Form has not been submitted
    if (isset($_GET['logout']) && $_GET['logout'] == 1) {
        $message = "You are now logged out.";
    }
    $email = "";
    $password = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($pagetitle); ?> - Lekki Astro Sports Club Medical</title>
  <link rel="icon" type="image/x-icon" href="../favicon.ico">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="auth-body">
  <div class="auth-wrapper">
    <div class="auth-panel">
      <!-- Brand column -->
      <div class="auth-brand">
        <div class="auth-brand-inner">
          <span class="auth-brand-icon"><i class="bi bi-shield-plus"></i></span>
          <h2>Lekki Astro Sports Club</h2>
          <p class="auth-brand-sub">Medical Records Portal</p>
          <hr>
          <ul class="auth-features list-unstyled">
            <li><i class="bi bi-check-circle-fill"></i> Secure digital health records</li>
            <li><i class="bi bi-check-circle-fill"></i> Vitals &amp; vaccination history</li>
            <li><i class="bi bi-check-circle-fill"></i> Medical advice at your fingertips</li>
          </ul>
          <p class="auth-brand-ref">New member? <a href="register.php">Create an account</a></p>
        </div>
      </div>

      <!-- Form column -->
      <div class="auth-form">
        <div class="auth-form-inner">
          <a href="../index.php" class="auth-logo-link">
            <img src="../assets/image/Logo.png" alt="Lekki Astro Sports Club Medical" class="auth-logo">
          </a>

          <h1 class="font-1 fw-bold">Welcome back</h1>
          <p class="text-muted-color">Sign in to access your medical records.</p>

          <?php if (!empty($message)): ?>
            <div class="alert alert-danger auth-alert"><?php echo $message; ?></div>
          <?php endif; ?>



          <form method="post" action="" novalidate>
            <div class="mb-2">
              <label for="email" class="form-label fw-semibold">Email address</label>
              <div class="input-group auth-input">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" id="email" class="form-control" placeholder="you@example.com"
                  value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required autofocus>
              </div>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label fw-semibold">Password</label>
              <div class="input-group auth-input">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Your password" required>
                <button type="button" class="input-group-text auth-pw-toggle" id="pwToggle" tabindex="-1"
                  aria-label="Show password"><i class="bi bi-eye"></i></button>
              </div>
            </div>

            <button type="submit" name="login" class="btn btn-primary-solid w-100">Sign In</button>
          </form>

          <div class="text-center auth-bottom-links">
            <p class="mb-1">Not a member yet? <a href="register.php" class="links-primary fw-bold">Register now</a></p>
            <a href="../index.php" class="links-primary d-inline-flex align-items-center gap-2">
              <i class="bi bi-house-door"></i> Back to homepage
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="../assets/js/vendor/jquery.min.js"></script>
  <script src="../assets/js/vendor/bootstrap.bundle.min.js"></script>
  <script>
    $(function () {
      $('#pwToggle').on('click', function () {
        const input = $('#password');
        const icon = $(this).find('i');
        const isPassword = input.attr('type') === 'password';
        input.attr('type', isPassword ? 'text' : 'password');
        icon.toggleClass('bi-eye bi-eye-slash');
      });
    });
  </script>
</body>
</html>