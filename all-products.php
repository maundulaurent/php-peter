<?php
session_start();
include 'includes/db.php'; // Database connection file

// Fetch products from the database
$query = "SELECT product_id, product_name, barcode, description, selling_price, quantity_available FROM products WHERE status = 'Active'";
$result = mysqli_query($conn, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>All Products | Init POS</title>

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
  <?php include "includes/navbar.php"?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include "includes/sidebar.php"?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3>All Products</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">All Products</li>
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
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">All Products List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Product ID</th>
                      <th>Product Name</th>
                      <th>Barcode</th>
                      <th>Description</th>
                      <th>Selling Price</th>
                      <th>Quantity Available</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                      <td><?php echo $product['product_id']; ?></td>
                      <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                      <td><?php echo htmlspecialchars($product['barcode']); ?></td>
                      <td><?php echo htmlspecialchars($product['description']); ?></td>
                      <td><?php echo number_format($product['selling_price'], 2); ?></td>
                      <td><?php echo $product['quantity_available']; ?></td>
                      <td>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editProductModal" onclick="fillEditProductModal(<?php echo htmlspecialchars(json_encode($product)); ?>)">
                          <i class="fas fa-edit"></i> 
                        </button>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteProductModal" onclick="setDeleteProductId(<?php echo $product['product_id']; ?>, '<?php echo htmlspecialchars($product['product_name']); ?>')">
                          <i class="fas fa-trash"></i> 
                        </button>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
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

  <!-- Edit Product Modal -->
  <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="fnc/edit_product.php" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="editProductId" name="product_id">
            <div class="form-group">
              <label for="editProductName">Product Name</label>
              <input type="text" class="form-control" id="editProductName" name="product_name" required>
            </div>
            <div class="form-group">
              <label for="editProductBarcode">Barcode</label>
              <input type="text" class="form-control" id="editProductBarcode" name="barcode" required>
            </div>
            <div class="form-group">
              <label for="editProductDescription">Description</label>
              <textarea class="form-control" id="editProductDescription" name="description" required></textarea>
            </div>
            <div class="form-group">
              <label for="editProductPrice">Selling Price</label>
              <input type="number" step="0.01" class="form-control" id="editProductPrice" name="selling_price" required>
            </div>
            <div class="form-group">
              <label for="editProductQuantity">Quantity Available</label>
              <input type="number" class="form-control" id="editProductQuantity" name="quantity_available" required>
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

  <!-- Delete Product Modal -->
  <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="fnc/delete_product.php" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteProductModalLabel">Delete Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="deleteProductId" name="product_id">
            <p id="deleteProductMessage"></p>
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

    // Populate Edit Product Modal with product data
    function fillEditProductModal(product) {
      $('#editProductId').val(product.product_id);
      $('#editProductName').val(product.product_name);
      $('#editProductBarcode').val(product.barcode);
      $('#editProductDescription').val(product.description);
      $('#editProductPrice').val(product.selling_price);
      $('#editProductQuantity').val(product.quantity_available);
    }

    // Set product ID and name for deletion
    function setDeleteProductId(productId, productName) {
      $('#deleteProductId').val(productId);
      $('#deleteProductMessage').text("Are you sure you want to delete the product '" + productName + "'?");
    }
  </script>
</body>
</html>
