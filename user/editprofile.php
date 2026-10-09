<?php
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");
require_once("../includes/pagination.php");

$pagetitle = "Edit Profile";
confirm_logged_in();

$message = '';

// Fetch member as associative array
$member = get_user_id($_SESSION['email']);
$member = mysqli_fetch_array($member);



if (!$member) {
  // Redirect if user not found
  redirect_to("../user/dashboard.php");
}

// Handle form submission
if (isset($_POST['submit'])) {
  $errors = [];

  // Required fields
  $required_fields = ['fname', 'lname', 'username', 'email', 'gender', 'phone', 'address'];
  foreach ($required_fields as $field) {
    if (empty(trim($_POST[$field] ?? ''))) {
      $errors[] = $field;
    }
  }


  if (empty($errors)) {
    // Sanitize inputs
    $fname = mysqli_real_escape_string($connection, $_POST['fname']);
    $lname = mysqli_real_escape_string($connection, $_POST['lname']);
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $gender = mysqli_real_escape_string($connection, $_POST['gender']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);

    $time = date("Y-m-d H:i:s");

    // Update the member
        // $user_id = (int) $member['id'];

        $query = "UPDATE newmember_tbl SET
            fname = '{$fname}',
            lname = '{$lname}',
            username = '{$username}',
            gender = '{$gender}',
            phone = '{$phone}',
            email = '{$email}',
            address = '{$address}'
        WHERE id = '{$member['id']}'";



    $result = mysqli_query($connection, $query);

    if ($result) {
      set_flash('success', 'Profile updated successfully!');
      redirect_to('memberprofile.php');
      exit;
    } else {
      error_log("editprofile update failed: " . mysqli_error($connection));
      $message = "Update failed. Please try again.";
    }
  } else {
    $message = "Please review the following fields: " . implode(', ', $errors);
  }
}
?>

<?php include("includes/header_side.php"); ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h4>Edit Profile</h4>
      <?php if (!empty($message)) {
        echo "<div class='alert alert-warning'>" . htmlspecialchars($message) . "</div>";
      } ?>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card card-default">
        <div class="card-body">
          <form method="post" enctype="multipart/form-data">
            <div class="row">
              <!-- First column -->
              <div class="col-md-3">
                <div class="form-group">
                  <label>First Name</label>
                  <input type="text" name="fname" class="form-control" value="<?php echo htmlspecialchars($member['fname'] ?? ''); ?>" placeholder="Enter First Name">
                </div>
                <div class="form-group">
                  <label>Last Name</label>
                  <input type="text" name="lname" class="form-control" value="<?php echo htmlspecialchars($member['lname'] ?? ''); ?>" placeholder="Enter Last Name">
                </div>
              </div>

              <!-- Second column -->
              <div class="col-md-3">
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($member['username'] ?? ''); ?>" placeholder="Enter Username">
                </div>
                <div class="form-group">
                  <label>Gender</label>
                  <input type="text" name="gender" class="form-control" value="<?php echo htmlspecialchars($member['gender'] ?? ''); ?>" placeholder="Enter Gender">
                </div>
              </div>

              <!-- Third column -->
              <div class="col-md-3">
                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($member['phone'] ?? ''); ?>" placeholder="eg +234 80 675-43218">
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($member['email'] ?? ''); ?>" placeholder="Enter Email" readonly>
                </div>
              </div>

              <!-- Fourth column -->
              <div class="col-md-3">
                <div class="form-group">
                  <label>Unique Member ID</label>
                  <input type="text" name="mem_id" class="form-control" value="<?php echo htmlspecialchars($member['mem_id'] ?? ''); ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Address</label>
                  <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($member['address'] ?? ''); ?>" placeholder="Enter Address">
                </div>
              </div>
            </div>

            <div class="btn-group w-100 mt-3">
              <button type="submit" name="submit" class="btn btn-success col">Update Profile</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include("includes/footer.php"); ?>