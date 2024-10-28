<?php
session_start();
include 'includes/db.php'; // Database connection file

// Fetch categories from the database
$query = "SELECT category_id, category_name, description FROM categories";
$result = mysqli_query($conn, $query);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>All Categories | Init POS</title>

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
            <h3>All Categories</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">All Categories</li>
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
                <h3 class="card-title">All Categories List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Category ID</th>
                      <th>Category Name</th>
                      <th>Description</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($categories as $category): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($category['category_id']); ?></td>
                      <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                      <td><?php echo htmlspecialchars($category['description']); ?></td>
                      <td>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="fillEditModal(<?php echo htmlspecialchars(json_encode($category)); ?>)">
                          <i class="fas fa-edit"></i> 
                        </button>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteId(<?php echo $category['category_id']; ?>, '<?php echo htmlspecialchars($category['category_name']); ?>')">
                          <i class="fas fa-trash"></i> 
                        </button>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Category ID</th>
                      <th>Category Name</th>
                      <th>Description</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
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
        <form action="fnc/edit_category.php" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="editCategoryId" name="category_id">
            <div class="form-group">
              <label for="editCategoryName">Category Name</label>
              <input type="text" class="form-control" id="editCategoryName" name="category_name" required>
            </div>
            <div class="form-group">
              <label for="editCategoryDescription">Description</label>
              <textarea class="form-control" id="editCategoryDescription" name="description" required></textarea>
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
        <form action="fnc/delete_category.php" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Delete Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="deleteCategoryId" name="category_id">
            <p id="deleteMessage"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
  <!-- DataTables & Plugins -->
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
  <!-- Page specific script -->
  <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    // Populate Edit Modal with category data
    function fillEditModal(category) {
      $('#editCategoryId').val(category.category_id);
      $('#editCategoryName').val(category.category_name);
      $('#editCategoryDescription').val(category.description);
    }

    // Set category ID and name for deletion
    function setDeleteId(categoryId, categoryName) {
      $('#deleteCategoryId').val(categoryId);
      $('#deleteMessage').text("Are you sure you want to delete the category '" + categoryName + "'?");
    }
  </script>
</body>
</html>
