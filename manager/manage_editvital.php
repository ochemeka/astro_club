<?php
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");

$pagetitle = "Edit Vital";
admin_logged_in();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

$vital_id = $_GET["vital"] ?? null;
if (!$vital_id || !is_numeric($vital_id)) {
    redirect_to("manage_vitals.php");
    exit;
}

$stmt = $connection->prepare("SELECT * FROM vitals_tbl WHERE vitals_id = ?");
$stmt->bind_param("i", $vital_id);
$stmt->execute();
$vital_part = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$vital_part) {
    redirect_to("manage_vitals.php");
    exit;
}

$user_id = $vital_part['id'] ?? null;
$current_user_image = "";
$username = "Unknown User";

if ($user_id) {
    $stmt_img = $connection->prepare("SELECT fname, lname, username, image FROM newmember_tbl WHERE id = ? LIMIT 1");
    $stmt_img->bind_param("i", $user_id);
    $stmt_img->execute();
    $img_result = $stmt_img->get_result();
    if ($img_row = $img_result->fetch_assoc()) {
        $current_user_image = $img_row['image'];
        $fullname = trim(($img_row['fname'] ?? '') . ' ' . ($img_row['lname'] ?? ''));
        $username = !empty($fullname) ? $fullname : ($img_row['username'] ?? 'Unknown User');
    }
    $stmt_img->close();
}

$errors = [];
$message = '';

if (isset($_POST['submit'])) {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    $required_fields = ['pulse_rate', 'weight', 'height'];
    foreach ($required_fields as $fieldname) {
        if (empty(trim($_POST[$fieldname]))) {
            $errors[] = $fieldname;
        }
    }

    if (empty($errors)) {
        $pulse = trim($_POST['pulse_rate']);
        $weight = floatval($_POST['weight']);
        $height = floatval($_POST['height']);
        $bmi = ($height > 0) ? $weight / ($height * $height) : 0;

        $stmt = $connection->prepare("UPDATE vitals_tbl SET pulse_rate = ?, weight = ?, height = ?, bmi = ? WHERE vitals_id = ?");
        $stmt->bind_param("sdddi", $pulse, $weight, $height, $bmi, $vital_id);
        if ($stmt->execute()) {
            redirect_to("manage_vitals.php");
            exit;
        } else {
            $message = "Update failed.";
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
        <h1>Edit Vital <small><?php echo htmlspecialchars($username); ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="manage_vitals.php">Manage Vitals</a></li>
            <li class="active">Edit Vital</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Vitals for <?php echo htmlspecialchars($username); ?></h3>
                    </div>

                    <?php if (!empty($message)) { ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($message); ?></div>
                    <?php } ?>
                    <?php if (!empty($errors)) { ?>
                        <div class="alert alert-warning">Missing fields: <?php echo htmlspecialchars(implode(', ', $errors)); ?></div>
                    <?php } ?>

                    <?php if (!empty($current_user_image)) { ?>
                        <div class="box-body">
                            <label>User Image:</label><br>
                            <?php
                            $img_arr = explode(',', $current_user_image);
                            foreach ($img_arr as $img_url1) {
                                if (strlen(trim($img_url1)) > 4) {
                                    echo "<img src='" . htmlspecialchars(SITE_PATH . "uploads/" . trim($img_url1)) . "' alt='" . htmlspecialchars($username) . "' height='100' width='100' style='margin:5px;' />";
                                }
                            }
                            ?>
                        </div>
                    <?php } ?>

                    <form method="post">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Pulse Rate</label>
                                <input type="text" name="pulse_rate" class="form-control" value="<?php echo htmlspecialchars($vital_part['pulse_rate']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Weight (kg)</label>
                                <input type="text" name="weight" class="form-control" value="<?php echo htmlspecialchars($vital_part['weight']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Height (m)</label>
                                <input type="text" name="height" class="form-control" value="<?php echo htmlspecialchars($vital_part['height']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label>BMI</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($vital_part['bmi']); ?>" readonly>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit" class="btn btn-primary">Update Vitals</button>
                            <a href="manage_vitals.php" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('includes/footer.php'); ?>
