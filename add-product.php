<?php
ob_start();

include 'includes/db.php';

$categories = mysqli_query($conn, "SELECT category_id, category_name FROM categories");

$suppliers = mysqli_query($conn, "SELECT supplier_id, supplier_name FROM suppliers");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Product | Init POS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed"><!--dark-mode-->
<div class="wrapper">

  <!-- Preloader -->
  <?php include "includes/preloader.php" ?>

  <!-- Navbar -->
 <?php include "includes/navbar.php" ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
<?php include "includes/sidebar.php" ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Products</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Product</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-10 col-md-2">
            
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-10 col-md-8">
          <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Add Product</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Select Category</label>
                  <select class="form-control select2" name="category_id" style="width: 100%;">
                    <option selected="selected">-select-</option>
                    <?php while ($row= mysqli_fetch_assoc($categories)): ?>
                      <option value="<?php echo $row['category_id']; ?>"><?php echo ?></option>
                    <?php endwhile; ?>
                  </select>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Product Name</label>
                    <input type="text" class="form-control" name="barcode" autofocus="" placeholder="Enter Name">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Select Supplier</label>
                  <select class="form-control select2" style="width: 100%;">
                    <option selected="selected">anonymous</option>
                    <option>cat 1</option>
                    <option>cat 2</option>
                    <option>category 3</option>
                    <option>category 4</option>
                    <option>category 5</option>
                    <option>category 6</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Barcode*</label>
                    <input type="text" class="form-control" name="barcode" autofocus="" placeholder="Enter barcode">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Buying Price</label>
                    <input type="number" min="0" class="form-control" name="barcode" autofocus="" placeholder="Enter Buying Price">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Selling Price</label>
                    <input type="number" min="0" class="form-control" name="barcode" autofocus="" placeholder="Enter Selling Price">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Discount Price</label>
                    <input type="number" min="0" class="form-control" name="barcode" autofocus="" placeholder="Enter Discount Price">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Specification</label>
                    <input type="text" class="form-control" name="barcode" autofocus="" placeholder="Enter specifications">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Counter Quantity</label>
                    <input type="number" min="0" class="form-control" name="barcode" autofocus="" placeholder="Enter barcode">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputEmail1">Store Quantity</label>
                    <input type="number" min="0" class="form-control" name="barcode" autofocus="" placeholder="Enter Store Quantity">
                </div>
              </div>
              
              <div class="form-group">
                    <label for="exampleInputFile">Add Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div>
              <!-- /.col -->
               
            </div>
            <!-- /.row -->

            <div class="d-flex justify-content-between">
                
                <button type="reset" class="btn btn-secondary">Cancel</button>
                <button type="submit" name="add" class="btn btn-primary">Save</button>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
          
        </div>
          </div>
          <!-- /.col -->

          <div class="col-12 col-sm-6 col-md-2">
            
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
           
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
           
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

      
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php include "includes/footer.php" ?>
</div>
<!-- ./wrapper -->

<?php include "includes/scripts.php" ?>
</body>
</html>

<?php ob_end_flush() ?>