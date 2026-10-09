<?php
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");

$pagetitle = "Add Vital";
admin_logged_in();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

$errors = array();
$message = '';

if (isset($_POST['submit'])) {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    $required_fields = array('height','weight','bp','pulse','user_id');
    foreach ($required_fields as $fieldname) {
        if (!isset($_POST[$fieldname]) || empty(trim($_POST[$fieldname]))) {
            $errors[] = $fieldname;
        }
    }

    if (empty($errors)) {
        $user_id = intval($_POST['user_id']);
        $height = floatval($_POST['height']);
        $weight = floatval($_POST['weight']);
        $pulse = trim($_POST['pulse']);
        $bp = trim($_POST['bp']);

        $bmi = ($height > 0) ? $weight / ($height * $height) : 0;

        $stmt = $connection->prepare("INSERT INTO vitals_tbl (id, pulse_rate, blood_pressure, weight, height, bmi, updated_at, status) VALUES (?, ?, ?, ?, ?, ?, NOW(), 1)");
        $stmt->bind_param("isssdd", $user_id, $pulse, $bp, $weight, $height, $bmi);

        if ($stmt->execute()) {
            redirect_to("manage_vitals.php");
            exit;
        } else {
            $message = "Failed to create vital record.";
        }
        $stmt->close();
    } else {
        $message = "Please fill in all required fields.";
    }
}

include('includes/header.php');
include('includes/sidebar.php');
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Add Vital <small>New vital record</small></h1>
        <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="manage_vitals.php">Manage Vitals</a></li>
            <li class="active">Add Vital</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add New Vital Record</h3>
                    </div>

                    <?php if (!empty($message)) { ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
                    <?php } ?>
                    <?php if (!empty($errors)) { ?>
                        <div class="alert alert-warning">Missing fields: <?php echo htmlspecialchars(implode(', ', $errors)); ?></div>
                    <?php } ?>

                    <form method="post">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Select User</label>
                                <select class="form-control" name="user_id" required>
                                    <option value="">-- Select User --</option>
                                    <?php
                                    $query = "SELECT id, fname, lname, username FROM newmember_tbl WHERE status != 7 ORDER BY fname ASC";
                                    $result = mysqli_query($connection, $query);
                                    while ($cat_set = mysqli_fetch_assoc($result)) {
                                        $fullname = trim($cat_set['fname'] . ' ' . $cat_set['lname']);
                                        $display = !empty($fullname) ? $fullname : $cat_set['username'];
                                        echo "<option value='" . htmlspecialchars($cat_set['id']) . "'>" . htmlspecialchars($display) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Blood Pressure</label>
                                <input type="text" class="form-control" placeholder="e.g. 120/80" name="bp" required>
                            </div>
                            <div class="form-group">
                                <label>Pulse Rate</label>
                                <input type="text" class="form-control" placeholder="e.g. 72 bpm" name="pulse" required>
                            </div>
                            <div class="form-group">
                                <label>Weight (kg)</label>
                                <input type="text" class="form-control" placeholder="e.g. 70" name="weight" required>
                            </div>
                            <div class="form-group">
                                <label>Height (m)</label>
                                <input type="text" class="form-control" placeholder="e.g. 1.75" name="height" required>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                            <a href="manage_vitals.php" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('includes/footer.php'); ?>
