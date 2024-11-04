<?php
session_start();
include 'includes/db.php'; // Database connection file

// Fetch admins from the database
$query_admins = "SELECT user_id, username, first_name, role, date_added FROM users WHERE role = 'Admin'";
$result_admins = mysqli_query($conn, $query_admins);
$admins = mysqli_fetch_all($result_admins, MYSQLI_ASSOC);

// Fetch other users from the database
$query_users = "SELECT user_id, username, first_name, role, date_added FROM users WHERE role != 'Admin'";
$result_users = mysqli_query($conn, $query_users);
$other_users = mysqli_fetch_all($result_users, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Roles and Permissions | Init POS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
            <h3>Roles and Permissions</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">Roles and Permissions</li>
            </ol>
          </div>
        </div>
        
        <!-- Success message display -->
        <?php if (isset($_GET['message'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['message']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>

      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Admins List</h3>
              </div>
              <div class="card-body">
                <table id="adminTable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>User ID</th>
                      <th>Username</th>
                      <th>First Name</th>
                      <th>Date Added</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($admins as $admin): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($admin['user_id']); ?></td>
                      <td><?php echo htmlspecialchars($admin['username']); ?></td>
                      <td><?php echo htmlspecialchars($admin['first_name']); ?></td>
                      <td><?php echo htmlspecialchars($admin['date_added']); ?></td>
                      <td>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="fillEditModal(<?php echo htmlspecialchars(json_encode($admin)); ?>)">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteId(<?php echo $admin['user_id']; ?>)">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>User ID</th>
                      <th>Username</th>
                      <th>First Name</th>
                      <th>Date Added</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>

          <div class="col-12 mt-4">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Other Users List</h3>
              </div>
              <div class="card-body">
                <table id="userTable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>User ID</th>
                      <th>Username</th>
                      <th>First Name</th>
                      <th>Date Added</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($other_users as $user): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                      <td><?php echo htmlspecialchars($user['username']); ?></td>
                      <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                      <td><?php echo htmlspecialchars($user['date_added']); ?></td>
                      <td>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="fillEditModal(<?php echo htmlspecialchars(json_encode($user)); ?>)">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteId(<?php echo $user['user_id']; ?>)">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>User ID</th>
                      <th>Username</th>
                      <th>First Name</th>
                      <th>Date Added</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="fnc/edit_user.php" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="editUserId" name="user_id">
            <div class="form-group">
              <label for="editUsername">Username</label>
              <input type="text" class="form-control" id="editUsername" name="username" required>
            </div>
            <div class="form-group">
              <label for="editFirstName">First Name</label>
              <input type="text" class="form-control" id="editFirstName" name="first_name" required>
            </div>
            <div class="form-group">
              <label for="editRole">Role</label>
              <input type="text" class="form-control" id="editRole" name="role" required>
            </div>
            <div class="form-group">
              <label for="editPassword">Password</label>
              <input type="password" class="form-control" id="editPassword" name="password">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="fnc/delete_user.php" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Delete User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="deleteUserId" name="user_id">
            <p id="deleteMessage">Are you sure you want to delete this user?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Delete</button>
          </div>
        </form>
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
  <!-- DataTables  & Plugins -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="plugins/jszip/jszip.min.js"></script>
  <script src="plugins/pdfmake/pdfmake.min.js"></script>
  <script src="plugins/pdfmake/vfs_fonts.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <script>
    $(function () {
      $("#adminTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#adminTable_wrapper .col-md-6:eq(0)');

      $("#userTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#userTable_wrapper .col-md-6:eq(0)');
    });

    function fillEditModal(user) {
      $('#editUserId').val(user.user_id);
      $('#editUsername').val(user.username);
      $('#editFirstName').val(user.first_name);
      $('#editRole').val(user.role);
      $('#editPassword').val(''); // Password should be kept empty for security
    }

    function setDeleteId(id) {
      $('#deleteUserId').val(id);
      $('#deleteMessage').text(`Are you sure you want to delete user ID "${id}"?`);
    }
  </script>
</div>
</body>
</html>
