<?php
ob_start();
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pagetitle = "Member Registration";

/* =======================
   CSRF TOKEN GENERATION
======================= */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = "";
$errors = [];

if (isset($_POST['submit'])) {

    /* =======================
       CSRF VALIDATION
    ======================= */
    if (
        !isset($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die("Invalid CSRF token. Please refresh the page.");
    }

    /* =======================
       REQUIRED FIELDS
    ======================= */
    $required_fields = ['username', 'email', 'phone', 'password', 'passc', 'gender'];

    foreach ($required_fields as $field) {
        if (empty(trim($_POST[$field] ?? ''))) {
            $errors[] = ucfirst($field) . " is required";
        }
    }

    /* =======================
       SANITIZE INPUTS
    ======================= */
    $fname    = trim($_POST['fname'] ?? '');
    $lname    = trim($_POST['lname'] ?? '');
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = $_POST['password'];
    $passc    = $_POST['passc'];
    $gender   = $_POST['gender'];

    /* =======================
       VALIDATIONS
    ======================= */
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address";
    }

    if ($gender === "0") {
        $errors[] = "Please select gender";
    }

    if ($password !== $passc) {
        $errors[] = "Passwords do not match";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long";
    }

    /* =======================
       DUPLICATE CHECKS
    ======================= */
    if (empty($errors)) {

        $stmt = mysqli_prepare($connection, "SELECT id FROM newmember_tbl WHERE email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errors[] = "Email already exists";
        }
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($connection, "SELECT id FROM newmember_tbl WHERE username = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errors[] = "Username already exists";
        }
        mysqli_stmt_close($stmt);
    }

    /* =======================
       INSERT USER
    ======================= */
    if (empty($errors)) {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $temp_pass = ''; // Never store plain text passwords
        $created_at = date("Y-m-d H:i:s");
        $reg_number = "Astro" . date("Ysi");
        
        // Set default values for columns not in the registration form
        $address = '';
        $image = '';
        $img_alt = '';
        $pulse_rate = NULL;
        $blood_pressure = NULL;
        $weight = NULL;
        $bmi = NULL;
        $height = NULL;
        $status = '1'; // Active status by default (string to match your DB column type)

        $stmt = mysqli_prepare(
            $connection,
            "INSERT INTO newmember_tbl 
            (fname, lname, username, mem_id, email, address, image, img_alt, phone, gender, 
             pulse_rate, blood_pressure, weight, bmi, height, password, temp_pass, created_at, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "sssssssssssssssssss",
            $fname,
            $lname,
            $username,
            $reg_number,
            $email,
            $address,
            $image,
            $img_alt,
            $phone,
            $gender,
            $pulse_rate,
            $blood_pressure,
            $weight,
            $bmi,
            $height,
            $hashed_password,
            $temp_pass,
            $created_at,
            $status
        );

        if (mysqli_stmt_execute($stmt)) {
            unset($_SESSION['csrf_token']);
            header("Location: login.php?p=success");
            exit;
        } else {
            $errors[] = "Registration failed. Please try again.";
            // Uncomment for debugging (remove in production):
            // $errors[] = "Error: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }

    if (!empty($errors)) {
        $message = "<ul>";
        foreach ($errors as $error) {
            $message .= "<li>" . htmlspecialchars($error) . "</li>";
        }
        $message .= "</ul>";
    }
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
          <p class="auth-brand-ref">Already a member? <a href="login.php">Sign in</a></p>
        </div>
      </div>

      <!-- Form column -->
      <div class="auth-form">
        <div class="auth-form-inner auth-form-inner-wide">
          <a href="../index.php" class="auth-logo-link">
            <img src="../assets/image/Logo.png" alt="Lekki Astro Sports Club Medical" class="auth-logo">
          </a>

          <h1 class="font-1 fw-bold">Create your account</h1>
          <p class="text-muted-color">Register to start your secure health record.</p>

          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger auth-alert">
              <ul class="mb-0 ps-3">
                <?php foreach ($errors as $error): ?>
                  <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form method="post" novalidate>
            <input type="hidden" name="csrf_token"
              value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

            <div class="row g-2">
              <div class="col-6">
                <label for="fname" class="form-label fw-semibold">First name</label>
                <input type="text" name="fname" id="fname" class="form-control auth-control"
                  placeholder="First name"
                  value="<?php echo htmlspecialchars($_POST['fname'] ?? ''); ?>">
              </div>
              <div class="col-6">
                <label for="lname" class="form-label fw-semibold">Last name</label>
                <input type="text" name="lname" id="lname" class="form-control auth-control"
                  placeholder="Last name"
                  value="<?php echo htmlspecialchars($_POST['lname'] ?? ''); ?>">
              </div>

              <div class="col-6">
                <label for="username" class="form-label fw-semibold">Username</label>
                <input type="text" name="username" id="username" class="form-control auth-control"
                  placeholder="Username" required
                  value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
              </div>
              <div class="col-6">
                <label for="phone" class="form-label fw-semibold">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control auth-control"
                  placeholder="Phone number" required
                  value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
              </div>

              <div class="col-6">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" name="email" id="email" class="form-control auth-control"
                  placeholder="you@example.com" required
                  value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
              </div>
              <div class="col-6">
                <label for="gender" class="form-label fw-semibold">Gender</label>
                <select name="gender" id="gender" class="form-select auth-control" required>
                  <option value="0">Select</option>
                  <option value="Male" <?php if (($_POST['gender'] ?? '') === 'Male') echo 'selected'; ?>>Male</option>
                  <option value="Female" <?php if (($_POST['gender'] ?? '') === 'Female') echo 'selected'; ?>>Female</option>
                </select>
              </div>

              <div class="col-6">
                <label for="password" class="form-label fw-semibold">Password</label>
                <div class="input-group auth-input">
                  <input type="password" name="password" id="password" class="form-control auth-control"
                    placeholder="Min. 6 characters" required>
                  <button type="button" class="input-group-text auth-pw-toggle" id="pwToggle1" tabindex="-1"
                    aria-label="Show password"><i class="bi bi-eye"></i></button>
                </div>
              </div>
              <div class="col-6">
                <label for="passc" class="form-label fw-semibold">Confirm</label>
                <div class="input-group auth-input">
                  <input type="password" name="passc" id="passc" class="form-control auth-control"
                    placeholder="Repeat password" required>
                  <button type="button" class="input-group-text auth-pw-toggle" id="pwToggle2" tabindex="-1"
                    aria-label="Show password"><i class="bi bi-eye"></i></button>
                </div>
              </div>
            </div>

            <button type="submit" name="submit" class="btn btn-primary-solid w-100 mt-3">Create Account</button>
          </form>

          <div class="text-center auth-bottom-links">
            <p class="mb-1">Already have an account? <a href="login.php" class="links-primary fw-bold">Login</a></p>
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
      function setupPwToggle(toggleId, inputId) {
        $('#' + toggleId).on('click', function () {
          var input = $('#' + inputId);
          var icon = $(this).find('i');
          var isPassword = input.attr('type') === 'password';
          input.attr('type', isPassword ? 'text' : 'password');
          icon.toggleClass('bi-eye bi-eye-slash');
        });
      }
      setupPwToggle('pwToggle1', 'password');
      setupPwToggle('pwToggle2', 'passc');
    });
  </script>
</body>
</html>