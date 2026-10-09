<?php
require_once("../includes/session.php");
require_once("../includes/connection.php");
require_once("../includes/functions.php");
require_once("../includes/pagination.php");
confirm_logged_in();

$current_user_id = $_SESSION['user_id'];

$pagetitle = "Vitals History";
// include("includes/head_add.php");


// Get current user data
$member = get_user_id($_SESSION['email']);
$member = mysqli_fetch_array($member);
?>

<!-- Main Sidebar Container -->
<?php include("includes/header_side.php"); ?>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>User: <span style="color:#f30;"><?php
            $fullname = trim(($member['fname'] ?? '') . ' ' . ($member['lname'] ?? ''));
            echo htmlspecialchars(!empty($fullname) ? $fullname : ($member['username'] ?? ''));
          ?></span></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
            <li class="breadcrumb-item active">Vitals History</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Add New Record Button -->
      <div class="row mb-2">
        <div class="col-sm-12">
          <a href="addmedhistory.php" class="btn btn-success">
            <i class="fa fa-plus"></i> Add New Record
          </a>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">My Vitals History</h3>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>S/N</th>
                      <th>Pulse Rate</th>
                      <th>Blood Pressure</th>
                      <th>Weight</th>
                      <th>Height</th>
                      <th>BMI</th>
                      <th>Date Added</th>
                      <!-- <th>Action</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Pagination
                    $item_per_page = 100;
                    $page_number = isset($_GET["page"]) ? filter_var($_GET["page"], FILTER_SANITIZE_NUMBER_INT) : 1;
                    if (!is_numeric($page_number)) { die('Invalid page number!'); }

                    // Total records
                    $count_query = "SELECT COUNT(*) FROM vitals_tbl WHERE id = ?";
                    $count_stmt = mysqli_prepare($connection, $count_query);
                    mysqli_stmt_bind_param($count_stmt, "i", $current_user_id);
                    mysqli_stmt_execute($count_stmt);
                    $count_result = mysqli_stmt_get_result($count_stmt);
                    $get_total_rows = mysqli_fetch_row($count_result);
                    $total_pages = ceil($get_total_rows[0]/$item_per_page);
                    $page_position = (($page_number-1) * $item_per_page);

                    // Fetch records
                    $query = "SELECT * FROM vitals_tbl WHERE id = ? ORDER BY updated_at DESC LIMIT ?, ?";
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($stmt, "iii", $current_user_id, $page_position, $item_per_page);
                    mysqli_stmt_execute($stmt);
                    $results = mysqli_stmt_get_result($stmt);
                    $sn = $page_position + 1;

                    if (mysqli_num_rows($results) > 0) {
                      while ($row = mysqli_fetch_assoc($results)) {
                    ?>
                    <tr>
                      <td><?php echo $sn++; ?></td>
                      <td><?php echo htmlspecialchars($row['pulse_rate'] ?? 'N/A'); ?></td>
                      <td><?php echo htmlspecialchars($row['blood_pressure'] ?? 'N/A'); ?></td>
                      <td><?php echo htmlspecialchars($row['weight'] ?? 'N/A'); ?></td>
                      <td><?php echo htmlspecialchars($row['height'] ?? 'N/A'); ?></td>
                      <td><?php echo htmlspecialchars($row['bmi'] ?? 'N/A'); ?></td>
                      <td><?php echo !empty($row['updated_at']) ? date("d M Y H:i A", strtotime($row['updated_at'])) : "N/A"; ?></td>
                      <td>
                        <!-- <a href="editmedhistory.php?id=<?php //echo htmlspecialchars($row['vitals_id']); ?>" class="btn btn-primary btn-sm">
                          <i class="fa fa-edit"></i> Edit
                        </a> -->
                      </td>
                    </tr>
                    <?php
                      }
                    } else {
                    ?>
                    <tr>
                      <td colspan="8" class="text-center">
                        <div class="alert alert-info">
                          <h5><i class="icon fas fa-info"></i> No Vitals History Found!</h5>
                          You don't have any Vitals History records yet. Please visit the medical center to get your first checkup.
                        </div>
                      </td>
                    </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>S/N</th>
                      <th>Pulse Rate</th>
                      <th>Blood Pressure</th>
                      <th>Weight</th>
                      <th>Height</th>
                      <th>BMI</th>
                      <th>Date Added</th>
                      <!-- <th>Action</th> -->
                    </tr>
                  </tfoot>
                </table>
              </div>

              <!-- Pagination -->
              <?php if ($total_pages > 1): ?>
              <div class="row mt-3">
                <div class="col-md-6">
                  <div class="dataTables_info">
                    Showing page <?php echo $page_number; ?> of <?php echo $total_pages; ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <ul class="pagination justify-content-end">
                    <?php if ($page_number > 1): ?>
                    <li class="page-item">
                      <a href="?page=<?php echo $page_number-1; ?>" class="page-link">Previous</a>
                    </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page_number) ? 'active' : ''; ?>">
                      <a href="?page=<?php echo $i; ?>" class="page-link"><?php echo $i; ?></a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($page_number < $total_pages): ?>
                    <li class="page-item">
                      <a href="?page=<?php echo $page_number+1; ?>" class="page-link">Next</a>
                    </li>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
              <?php endif; ?>

            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

<?php include("includes/footer.php"); ?>

