<?php
require_once "../includes/session.php";
require_once "../includes/connection.php";
require_once "../includes/functions.php";
require_once "../includes/constant.php";
require_once "includes/MemberManager.php";

$pagetitle = "Manage Members";
include "includes/header.php";
admin_logged_in();

// CSRF Token generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

$memberManager = new MemberManager($connection);

// Handle status updates securely with CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['member_id'], $_POST['csrf_token'])) {
    if (hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $member_id = intval($_POST['member_id']);
        $action = $_POST['action'];
        $status = ($action === 'approve') ? 1 : (($action === 'disapprove') ? 0 : 7);
        if ($memberManager->updateStatus($member_id, $status)) {
            redirect_to("manage_members.php?status=success");
        } else {
            $message = "Error updating member status.";
        }
    } else {
        $message = "Invalid CSRF token.";
    }
}

// Pagination setup
$item_per_page = 20;
$page_number = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$total_members = $memberManager->countMembers();
$total_pages = ceil($total_members / $item_per_page);
$offset = ($page_number - 1) * $item_per_page;

$members = $memberManager->getMembers($offset, $item_per_page);
?>

<!-- Sidebar -->
<?php include('includes/sidebar.php'); ?>

<div class="content-wrapper">
  <section class="content-header">
    <h1>Manage Members <small>Admin Panel</small></h1>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">List of Members</h3>
      </div>
      <div class="box-body">
        <?php if (!empty($message)) : ?>
          <div class="alert alert-danger"><?php echo $message; ?></div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Images</th>
              <th>Address</th>
              <th>Email</th>
              <th>Created At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $members->fetch_assoc()) : ?>
              <tr>
                <td><?= $row['id']; ?></td>
                <td><?php
                  $fullname = trim($row['fname'] . ' ' . $row['lname']);
                  echo htmlspecialchars(!empty($fullname) ? $fullname : $row['username']);
                ?></td>
                <td><?= htmlspecialchars($row['phone']); ?></td>
                <td>
                  <?php foreach (explode(',', $row['image']) as $img) :
                    if (strlen($img) > 4) : ?>
                      <img src="<?= SITE_PATH ?>uploads/<?= htmlspecialchars($img); ?>" alt="<?= htmlspecialchars($row['username']); ?>" height="50" width="50">
                  <?php endif; endforeach; ?>
                </td>
                <td><?= htmlspecialchars($row['address']); ?></td>
                <td><?= htmlspecialchars($row['email']); ?></td>
                <td><?= !empty($row['created_at']) ? date("Y-m-d H:i", strtotime($row['created_at'])) : 'N/A'; ?></td>
                <td>
                  <form method="post" style="display:inline;">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token; ?>">
                    <input type="hidden" name="member_id" value="<?= $row['id']; ?>">
                    <?php if ($row['status'] == 1): ?>
                      <button type="submit" name="action" value="disapprove" class="btn btn-warning btn-sm" onclick="return confirm('Disapprove this member?');">Disapprove</button>
                    <?php else: ?>
                      <button type="submit" name="action" value="approve" class="btn btn-success btn-sm" onclick="return confirm('Approve this member?');">Approve</button>
                    <?php endif; ?>
                    <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm" onclick="return confirm('Delete this member?');">Delete</button>
                  </form>
                  <a href="manage_edituser.php?pid=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>

        <!-- Pagination -->
        <nav>
          <ul class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
              <li class="page-item <?= ($i == $page_number) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
              </li>
            <?php endfor; ?>
          </ul>
        </nav>

      </div>
    </div>
  </section>
</div>

<?php include('includes/footer.php'); ?>
