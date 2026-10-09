<?php 
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");
include('../includes/pagination.php');

$pagetitle = "Manage Vitals";
admin_logged_in();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Approve, disapprove, delete actions (POST only)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['vital_id']) && is_numeric($_POST['vital_id'])) {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    $vital_id = $_POST['vital_id'];
    $action = $_POST['action'];
    $status = ($action === 'approve') ? 1 : (($action === 'disapprove') ? 0 : 7);

    $stmt = $connection->prepare("UPDATE vitals_tbl SET status = ? WHERE vitals_id = ?");
    $stmt->bind_param("ii", $status, $vital_id);
    $stmt->execute();
    $stmt->close();

    redirect_to("manage_vitals.php");
    exit;
}

include('includes/header.php');
include('includes/sidebar.php');
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Manage Vitals <small>All recorded vitals</small></h1>
        <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Manage Vitals</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">All Vitals</h3>
                    </div>
                    <table class="display table table-hover table-condensed" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>User</th>
                                <th>Blood Pressure</th> 
                                <th>Pulse Rate</th>
                                <th>Weight</th>
                                <th>Height</th>
                                <th>BMI</th>
                                <th>Updated At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $item_per_page = 20;
                            $page_number = isset($_GET["page"]) ? filter_var($_GET["page"], FILTER_SANITIZE_NUMBER_INT) : 1;
                            if (!is_numeric($page_number)) die('Invalid page number!');

                            $results = $connection->query("SELECT COUNT(*) FROM vitals_tbl");
                            $get_total_rows = $results->fetch_row();
                            $total_pages = ceil($get_total_rows[0]/$item_per_page);
                            $page_position = (($page_number-1) * $item_per_page);

                            $stmt = $connection->prepare(
                                "SELECT v.vitals_id, v.blood_pressure, v.pulse_rate, v.weight, v.height, v.bmi, v.updated_at, v.status,
                                        COALESCE(NULLIF(TRIM(CONCAT(n.fname, ' ', n.lname)), ''), n.username) AS fullname
                                        FROM vitals_tbl v
                                        LEFT JOIN newmember_tbl n ON v.id = n.id
                                        ORDER BY v.vitals_id ASC
                                        LIMIT ?, ?"
                            );
                            $stmt->bind_param("ii", $page_position, $item_per_page);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['vitals_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['fullname'] ?? 'Unknown'); ?></td>
                                    <td><?php echo htmlspecialchars($row['blood_pressure']); ?></td>
                                    <td><?php echo htmlspecialchars($row['pulse_rate']); ?></td>
                                    <td><?php echo htmlspecialchars($row['weight']); ?></td>
                                    <td><?php echo htmlspecialchars($row['height']); ?></td>
                                    <td><?php echo htmlspecialchars($row['bmi']); ?></td>
                                    <td>
                                        <?php
                                        if (!empty($row['updated_at'])) {
                                            echo date("d M Y H:i A", strtotime($row['updated_at']));
                                        } else {
                                            echo "N/A";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo ($row['status'] == 1) ? "Approved" : (($row['status'] == 0) ? "Disapproved" : "Deleted"); ?></td>
                                    <td>
                                        <?php if ($row['status'] != 1) { ?>
                                            <form method="post" style="display:inline" onsubmit="return confirm('Approve this record?');">
                                                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                                <input type="hidden" name="action" value="approve">
                                                <input type="hidden" name="vital_id" value="<?php echo $row['vitals_id']; ?>">
                                                <button type="submit" class="btn btn-xs btn-success">Approve</button>
                                            </form>
                                        <?php } ?>
                                        <?php if ($row['status'] == 1) { ?>
                                            <form method="post" style="display:inline" onsubmit="return confirm('Disapprove this record?');">
                                                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                                <input type="hidden" name="action" value="disapprove">
                                                <input type="hidden" name="vital_id" value="<?php echo $row['vitals_id']; ?>">
                                                <button type="submit" class="btn btn-xs btn-warning">Disapprove</button>
                                            </form>
                                        <?php } ?>
                                        <form method="post" style="display:inline" onsubmit="return confirm('Delete this record?');">
                                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="vital_id" value="<?php echo $row['vitals_id']; ?>">
                                            <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                                        </form>
                                        <a href="manage_editvital.php?vital=<?php echo htmlspecialchars($row['vitals_id']); ?>" class="btn btn-xs btn-info">Edit</a>
                                        <a href="view_vital.php?vitals_id=<?php echo htmlspecialchars($row['vitals_id']); ?>" class="btn btn-xs btn-default">View</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            $stmt->close();
                            ?>
                        </tbody>
                    </table>

                    <?php echo '<div align="center">'.paginate($item_per_page, $page_number, $get_total_rows[0], $total_pages, "manage_vitals.php").'</div>'; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('includes/footer.php'); ?>
