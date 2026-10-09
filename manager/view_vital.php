<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include('../includes/pagination.php'); ?>

<?php
$pagetitle = "View Vital";
include('includes/header.php');
admin_logged_in();
include('includes/sidebar.php');

// Get vital_id from URL
$vital_id = $_GET["vitals_id"] ?? null;

// Fetch vital details
$vital_query = "SELECT * FROM vitals_tbl WHERE vitals_id = ?";
$stmt = $connection->prepare($vital_query);
$stmt->bind_param("i", $vital_id);
$stmt->execute();
$vital_result = $stmt->get_result();
$vital = $vital_result->fetch_assoc();
$stmt->close();

if (!$vital) {
    echo "<p>Vital record not found.</p>";
    include('includes/footer.php');
    exit;
}

// Fetch user details
$user_id = $vital['id'] ?? null;
$username = "Unknown User";
$user_image = "";

if ($user_id) {
    $user_query = "SELECT fname, lname, username, image FROM newmember_tbl WHERE id = ?";
    $user_stmt = $connection->prepare($user_query);
    $user_stmt->bind_param("i", $user_id);
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();
    $user = $user_result->fetch_assoc();
    $fullname = trim(($user['fname'] ?? '') . ' ' . ($user['lname'] ?? ''));
    $username = !empty($fullname) ? $fullname : ($user['username'] ?? "Unknown User");
    $user_image = $user['image'] ?? "";
    $user_stmt->close();
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Astro Sport Club Medical
            <small>View Vital</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="manage_vitals.php">Manage Vitals</a></li>
            <li class="active">View Vital</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Vital Details for <?php echo htmlspecialchars($username); ?></h3>
            </div>

            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th>User</th>
                        <td><?php echo htmlspecialchars($username); ?></td>
                    </tr>
                    <tr>
                        <th>Pulse Rate</th>
                        <td><?php echo htmlspecialchars($vital['pulse_rate']); ?></td>
                    </tr>
                    <tr>
                        <th>Weight</th>
                        <td><?php echo htmlspecialchars($vital['weight']); ?></td>
                    </tr>
                    <tr>
                        <th>Height</th>
                        <td><?php echo htmlspecialchars($vital['height']); ?></td>
                    </tr>
                    <tr>
                        <th>BMI</th>
                        <td><?php echo htmlspecialchars($vital['bmi']); ?></td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td><?php echo htmlspecialchars(date("d M Y H:i A", strtotime($vital['updated_at']))); ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?php echo ($vital['status'] == 1) ? "Approved" : "Not Approved"; ?></td>
                    </tr>
                    <tr>
                        <th>User Image</th>
                        <td>
                            <?php
                            if (!empty($user_image)) {
                                $img_arr = explode(',', $user_image);
                                foreach ($img_arr as $img_url1) {
                                    if (strlen(trim($img_url1)) > 4) {
                                        echo "<img src='" . htmlspecialchars(SITE_PATH . "uploads/" . trim($img_url1)) . "' alt='" . htmlspecialchars($username) . "' height='100' width='100' style='margin:5px;' />";
                                    }
                                }
                            } else {
                                echo "No image found.";
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="box-footer">
                <a href="manage_vitals.php" class="btn btn-default">Back to Vitals</a>
            </div>
        </div>
    </section>
</div>

<?php include('includes/footer.php'); ?>
