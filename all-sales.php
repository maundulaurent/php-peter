<?php
session_start();
include 'includes/db.php'; // Database connection file

// Fetch sales from the database
$query = "SELECT sale_id, sale_date, cashier_id, total_sale_amount, payment_method, discount_applied, tax_applied, sale_status FROM sales";
$result = mysqli_query($conn, $query);
$sales = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>All Sales | Init POS</title>

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
            <h3>All Sales</h3>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">All Sales</li>
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
                <h3 class="card-title">All Sales List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Sale ID</th>
                      <th>Sale Date</th>
                      <th>Cashier ID</th>
                      <th>Total Sale Amount</th>
                      <th>Payment Method</th>
                      <th>Discount Applied</th>
                      <th>Tax Applied</th>
                      <th>Sale Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($sales as $sale): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($sale['sale_id']); ?></td>
                      <td><?php echo htmlspecialchars($sale['sale_date']); ?></td>
                      <td><?php echo htmlspecialchars($sale['cashier_id']); ?></td>
                      <td><?php echo htmlspecialchars($sale['total_sale_amount']); ?></td>
                      <td><?php echo htmlspecialchars($sale['payment_method']); ?></td>
                      <td><?php echo htmlspecialchars($sale['discount_applied']); ?></td>
                      <td><?php echo htmlspecialchars($sale['tax_applied']); ?></td>
                      <td><?php echo htmlspecialchars($sale['sale_status']); ?></td>
                      <td>
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="fillEditModal(<?php echo htmlspecialchars(json_encode($sale)); ?>)">
                          <i class="fas fa-edit"></i> 
                        </button>
                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteId(<?php echo $sale['sale_id']; ?>)">
                          <i class="fas fa-trash"></i> 
                        </button>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Sale ID</th>
                      <th>Sale Date</th>
                      <th>Cashier ID</th>
                      <th>Total Sale Amount</th>
                      <th>Payment Method</th>
                      <th>Discount Applied</th>
                      <th>Tax Applied</th>
                      <th>Sale Status</th>
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
        <form action="fnc/edit_sale.php" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Sale</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="editSaleId" name="sale_id">
            <div class="form-group">
              <label for="editSaleDate">Sale Date</label>
              <input type="text" class="form-control" id="editSaleDate" name="sale_date" required>
            </div>
            <div class="form-group">
              <label for="editCashierId">Cashier ID</label>
              <input type="text" class="form-control" id="editCashierId" name="cashier_id" required>
            </div>
            <div class="form-group">
              <label for="editTotalSaleAmount">Total Sale Amount</label>
              <input type="text" class="form-control" id="editTotalSaleAmount" name="total_sale_amount" required>
            </div>
            <div class="form-group">
              <label for="editPaymentMethod">Payment Method</label>
              <input type="text" class="form-control" id="editPaymentMethod" name="payment_method" required>
            </div>
            <div class="form-group">
              <label for="editDiscountApplied">Discount Applied</label>
              <input type="text" class="form-control" id="editDiscountApplied" name="discount_applied" required>
            </div>
            <div class="form-group">
              <label for="editTaxApplied">Tax Applied</label>
              <input type="text" class="form-control" id="editTaxApplied" name="tax_applied" required>
            </div>
            <div class="form-group">
              <label for="editSaleStatus">Sale Status</label>
              <input type="text" class="form-control" id="editSaleStatus" name="sale_status" required>
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
        <form action="fnc/delete_sale.php" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Delete Sale</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="deleteSaleId" name="sale_id">
            <p id="deleteMessage">Are you sure you want to delete this sale?</p>
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
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php include "includes/footer.php" ?>

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
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    function fillEditModal(sale) {
      $('#editSaleId').val(sale.sale_id);
      $('#editSaleDate').val(sale.sale_date);
      $('#editCashierId').val(sale.cashier_id);
      $('#editTotalSaleAmount').val(sale.total_sale_amount);
      $('#editPaymentMethod').val(sale.payment_method);
      $('#editDiscountApplied').val(sale.discount_applied);
      $('#editTaxApplied').val(sale.tax_applied);
      $('#editSaleStatus').val(sale.sale_status);
    }

    function setDeleteId(id) {
      $('#deleteSaleId').val(id);
      $('#deleteMessage').text(`Are you sure you want to delete sale ID "${id}"?`);
    }
  </script>
</div>
</body>
</html>
