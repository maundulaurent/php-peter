<?php
ob_start();
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login');
  exit();
}
include 'includes/db.php';

$categories = mysqli_query($conn, "SELECT category_id, category_name FROM categories");
$suppliers = mysqli_query($conn, "SELECT supplier_id, supplier_name FROM suppliers");

// Handle form submission
if (isset($_POST['add'])) {
    // Capture and sanitize form data
    $category_id = isset($_POST['category_id']) ? mysqli_real_escape_string($conn, $_POST['category_id']) : null;
    $product_name = isset($_POST['product_name']) ? mysqli_real_escape_string($conn, $_POST['product_name']) : null;
    $supplier_id = isset($_POST['supplier_id']) ? mysqli_real_escape_string($conn, $_POST['supplier_id']) : null;
    $barcode = isset($_POST['barcode']) ? mysqli_real_escape_string($conn, $_POST['barcode']) : null;
    $cost_price = isset($_POST['cost_price']) ? mysqli_real_escape_string($conn, $_POST['cost_price']) : null;
    $selling_price = isset($_POST['selling_price']) ? mysqli_real_escape_string($conn, $_POST['selling_price']) : null;
    $discount_price = isset($_POST['discount_price']) ? mysqli_real_escape_string($conn, $_POST['discount_price']) : null;
    $description = isset($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : null;
    $quantity_available = isset($_POST['quantity_available']) ? mysqli_real_escape_string($conn, $_POST['quantity_available']) : null;
    $minimum_stock_level = isset($_POST['minimum_stock_level']) ? mysqli_real_escape_string($conn, $_POST['minimum_stock_level']) : null;

    // Handle image upload
    $image_path = "";
    if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] == 0) {
        $image_name = $_FILES['image_path']['name'];
        $image_tmp = $_FILES['image_path']['tmp_name'];
        $image_path = "uploads/products/" . basename($image_name);

        // Move uploaded file
        move_uploaded_file($image_tmp, $image_path);
    }

    // Validate required fields
    if (!$product_name || !$category_id || !$supplier_id) {
        $_SESSION['error'] = "Please fill out all required fields.";
    } else {
        // Insert data into database
        $query = "INSERT INTO products (product_name, category_id, barcode, description, cost_price, selling_price, quantity_available, minimum_stock_level, supplier_id, image_path)
                  VALUES ('$product_name', '$category_id', '$barcode', '$description', '$cost_price', '$selling_price', '$quantity_available', '$minimum_stock_level', '$supplier_id', '$image_path')";

        if (mysqli_query($conn, $query)) {
            $_SESSION['success'] = "Product added successfully!";
            header("Location: add-product.php"); // Redirect to avoid form resubmission
            exit();
        } else {
            $_SESSION['error'] = "Error: " . mysqli_error($conn);
        }
    }
}
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
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <?php include "includes/preloader.php" ?>

  <!-- Navbar -->
 <?php include "includes/navbar.php" ?>

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
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Product</li>
            </ol>
          </div>
        </div>

        <!-- Display error or success messages -->
        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-sm-10 col-md-2">
          </div>
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

          <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Select Category *</label>
                    <select class="form-control select2" name="category_id" style="width: 100%;">
                      <option value="">-select-</option>
                      <?php while ($row= mysqli_fetch_assoc($categories)): ?>
                        <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                      <label for="product_name">Product Name *</label>
                      <input type="text" class="form-control" name="product_name" autofocus="" placeholder="Enter Name" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label>Select Supplier *</label>
                    <select class="form-control select2" name="supplier_id" style="width: 100%;">
                      <option value="">-select-</option>
                      <?php while ($row = mysqli_fetch_assoc($suppliers)): ?>
                        <option value="<?php echo $row['supplier_id']; ?>"><?php echo $row['supplier_name']; ?></option>
                      <?php endwhile; ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                      <label for="barcode">Barcode</label>
                      <input type="text" class="form-control" name="barcode" autofocus="" placeholder="Enter barcode">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                      <label for="cost_price">Buying Price *</label>
                      <input type="number" min="0" class="form-control" name="cost_price" autofocus="" placeholder="Enter Buying Price" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                      <label for="selling_price">Selling Price *</label>
                      <input type="number" min="0" class="form-control" name="selling_price" autofocus="" placeholder="Enter Selling Price" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                      <label for="discount_price">Discount Price</label>
                      <input type="number" min="0" class="form-control" name="discount_price" autofocus="" placeholder="Enter Discount Price">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                      <label for="description">Description</label>
                      <input type="text" class="form-control" name="description" autofocus="" placeholder="Enter description">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                      <label for="quantity_available">Counter Quantity *</label>
                      <input type="number" min="0" class="form-control" name="quantity_available" autofocus="" placeholder="Enter counter quantity" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                      <label for="minimum_stock_level">Store Quantity *</label>
                      <input type="number" min="0" class="form-control" name="minimum_stock_level" autofocus="" placeholder="Enter Store Quantity" required>
                  </div>
                </div>

                <div class="form-group">
                      <label for="image_path">Add Image</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="image_path" id="image_path">
                          <label class="custom-file-label" for="image_path">Choose file</label>
                        </div>
                        <div class="input-group-append">
                          <span class="input-group-text">Upload</span>
                        </div>
                      </div>
                </div>
              </div>

              <div class="d-flex justify-content-between">
                  <button type="reset" class="btn btn-secondary">Cancel</button>
                  <button type="submit" name="add" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
          </div>
        </div>
      
      </div>
    </section>
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark"></aside>

  <!-- Main Footer -->
  <?php include "includes/footer.php" ?>
</div>

<?php include "includes/scripts.php" ?>
</body>
</html>

<?php ob_end_flush() ?>
