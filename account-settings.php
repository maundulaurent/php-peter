<?php
ob_start();
session_start();
include 'includes/db.php'; // Database connection file
// Fetch the current logged-in user details from the database
$currentUserId = $_SESSION['user_id']; // Assuming user_id is stored in session
$query = "SELECT user_id, username, first_name, role, date_added FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $currentUserId);
$stmt->execute();
$result = $stmt->get_result();
$userDetails = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Account Settings | Init POS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php include "includes/navbar.php" ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include "includes/sidebar.php" ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>Account Settings</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">Account Settings</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User Details</h3>
                <div class="card-tools">
                  <button class="btn btn-tool" data-toggle="modal" data-target="#editModal">
                    <i class="fas fa-edit"></i> Edit
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <tr>
                    <th>User ID</th>
                    <td><?php echo htmlspecialchars($userDetails['user_id']); ?></td>
                  </tr>
                  <tr>
                    <th>Username</th>
                    <td><?php echo htmlspecialchars($userDetails['username']); ?></td>
                  </tr>
                  <tr>
                    <th>First Name</th>
                    <td><?php echo htmlspecialchars($userDetails['first_name']); ?></td>
                  </tr>
                  <tr>
                    <th>Role</th>
                    <td><?php echo htmlspecialchars($userDetails['role']); ?></td>
                  </tr>
                  <tr>
                    <th>Date Added</th>
                    <td><?php echo htmlspecialchars($userDetails['date_added']); ?></td>
                  </tr>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Account</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userDetails['user_id']); ?>">
            <div class="form-group">
              <label for="editUsername">Username</label>
              <input type="text" class="form-control" id="editUsername" name="username" value="<?php echo htmlspecialchars($userDetails['username']); ?>" required>
            </div>
            <div class="form-group">
              <label for="editFirstName">First Name</label>
              <input type="text" class="form-control" id="editFirstName" name="first_name" value="<?php echo htmlspecialchars($userDetails['first_name']); ?>" required>
            </div>
            <div class="form-group">
              <label for="editRole">Role</label>
              <input type="text" class="form-control" id="editRole" name="role" value="<?php echo htmlspecialchars($userDetails['role']); ?>" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>

        <?php
        // Handle the form submission for editing account details
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_POST['user_id'];
            $username = $_POST['username'];
            $firstName = $_POST['first_name'];
            $role = $_POST['role'];

            // Update the user details in the database
            $updateQuery = "UPDATE users SET username = ?, first_name = ?, role = ? WHERE user_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("sssi", $username, $firstName, $role, $userId);
            if ($updateStmt->execute()) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Account updated successfully!</div>';
                // Refresh the page to reflect the changes
                header("Refresh:0");
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Error updating account. Please try again.</div>';
            }
        }
        ?>
      </div>
    </div>
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
  <!-- /.control-sidebar -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
</body>
</html>
<?php
ob_end_flush();
?>