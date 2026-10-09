<?php
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");

$pagetitle = "View User Vitals";
admin_logged_in();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

include('includes/header.php');
include('includes/sidebar.php');
?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>User Vitals <small>View and manage user vitals</small></h1>
    <ol class="breadcrumb">
      <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">User Vitals</li>
    </ol>
  </section>

  <section class="content">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Select User to View Vitals</h3>
      </div>

      <div class="box-body">
        <form method="post" action="user_vitals.php">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
          <div class="form-group">
            <label>Select User</label>
            <select name="user_id" class="form-control" required>
              <option value="">-- Select User --</option>
              <?php
              $user_query = "SELECT id, fname, lname, username FROM newmember_tbl WHERE status != 7 ORDER BY fname";
              $user_result = mysqli_query($connection, $user_query);
              while ($user = mysqli_fetch_assoc($user_result)) {
                  $fullname = trim($user['fname'] . ' ' . $user['lname']);
                  $display = !empty($fullname) ? $fullname : $user['username'];
                  $selected = (isset($_POST['user_id']) && $_POST['user_id'] == $user['id']) ? ' selected' : '';
                  echo "<option value='" . htmlspecialchars($user['id']) . "'" . $selected . ">" . htmlspecialchars($display) . "</option>";
              }
              ?>
            </select>
          </div>
          <button type="submit" name="search" class="btn btn-primary">Search</button>
        </form>
      </div>

      <?php
      if (isset($_POST['save_recommendation'])) {
          if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
              die("Invalid CSRF token.");
          }

          $recommendation_input = trim($_POST['recommendation']);
          $user_id = intval($_POST['user_id']);

          $today_date = date("j F Y");
          $full_recommendation = $recommendation_input . " on " . $today_date;

          $sub_query = "SELECT MAX(vitals_id) FROM vitals_tbl WHERE id = ?";
          $sub_stmt = mysqli_prepare($connection, $sub_query);
          mysqli_stmt_bind_param($sub_stmt, "i", $user_id);
          mysqli_stmt_execute($sub_stmt);
          $sub_result = mysqli_stmt_get_result($sub_stmt);
          $latest_id = mysqli_fetch_row($sub_result)[0];
          mysqli_stmt_close($sub_stmt);

          if ($latest_id) {
              $update_query = "UPDATE vitals_tbl SET medical_advice = ? WHERE vitals_id = ?";
              $update_stmt = mysqli_prepare($connection, $update_query);
              if ($update_stmt) {
                  mysqli_stmt_bind_param($update_stmt, "si", $full_recommendation, $latest_id);
                  if (mysqli_stmt_execute($update_stmt)) {
                      echo "<div class='alert alert-success'>Recommendation saved successfully!</div>";
                  } else {
                      echo "<div class='alert alert-danger'>Failed to save recommendation.</div>";
                  }
                  mysqli_stmt_close($update_stmt);
              }
          } else {
              echo "<div class='alert alert-danger'>No vitals record found for this user.</div>";
          }
      }

      if (isset($_POST['search']) || isset($_POST['save_recommendation'])) {
          $user_id = intval($_POST['user_id']);

          $stmt_user = mysqli_prepare($connection, "SELECT fname, lname, username FROM newmember_tbl WHERE id = ?");
          mysqli_stmt_bind_param($stmt_user, "i", $user_id);
          mysqli_stmt_execute($stmt_user);
          $user_row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_user));
          mysqli_stmt_close($stmt_user);

          $fullname = trim(($user_row['fname'] ?? '') . ' ' . ($user_row['lname'] ?? ''));
          $display_name = !empty($fullname) ? $fullname : ($user_row['username'] ?? 'Unknown');

          echo "<div class='box-body'>";
          echo "<h4>You are viewing <strong>" . htmlspecialchars($display_name) . "</strong>'s records</h4>";

          $vitals_query = "SELECT vitals_id, pulse_rate, blood_pressure, weight, height, bmi, updated_at, medical_advice FROM vitals_tbl WHERE id = ? ORDER BY updated_at DESC";
          $stmt_vitals = mysqli_prepare($connection, $vitals_query);
          if ($stmt_vitals) {
              mysqli_stmt_bind_param($stmt_vitals, "i", $user_id);
              mysqli_stmt_execute($stmt_vitals);
              $result = mysqli_stmt_get_result($stmt_vitals);

              if (mysqli_num_rows($result) > 0) {
                  echo "<table class='table table-bordered'>";
                  echo "<thead><tr>
                      <th>Pulse Rate</th>
                      <th>Blood Pressure</th>
                      <th>Weight</th>
                      <th>Height</th>
                      <th>BMI</th>
                      <th>Updated At</th>
                      <th>Medical Advice</th>
                      </tr></thead><tbody>";
                  while ($row = mysqli_fetch_assoc($result)) {
                      echo "<tr>
                          <td>" . htmlspecialchars($row['pulse_rate']) . "</td>
                          <td>" . htmlspecialchars($row['blood_pressure']) . "</td>
                          <td>" . htmlspecialchars($row['weight']) . "</td>
                          <td>" . htmlspecialchars($row['height']) . "</td>
                          <td>" . htmlspecialchars($row['bmi']) . "</td>
                          <td>" . htmlspecialchars($row['updated_at']) . "</td>
                          <td>" . htmlspecialchars($row['medical_advice']) . "</td>
                      </tr>";
                  }
                  echo "</tbody></table>";

                  echo "<h4>Add Doctor Recommendation</h4>";
                  echo "<form method='post' action='user_vitals.php'>";
                  echo "<input type='hidden' name='csrf_token' value='" . htmlspecialchars($csrf_token) . "'>";
                  echo "<input type='hidden' name='user_id' value='" . htmlspecialchars($user_id) . "'>";
                  echo "<div class='form-group'>
                          <textarea name='recommendation' class='form-control' rows='3' placeholder='Enter recommendation...' required></textarea>
                        </div>";
                  echo "<button type='submit' name='save_recommendation' class='btn btn-success'>Save Recommendation</button>";
                  echo "</form>";

              } else {
                  echo "<p>No vitals records found for this user.</p>";
              }

              mysqli_stmt_close($stmt_vitals);
          }

          echo "</div>";
      }
      ?>
    </div>
  </section>
</div>

<?php include('includes/footer.php'); ?>
