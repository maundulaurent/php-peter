<?php
ob_start();
// Include the database connection
include 'includes/db.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $supplier_name = $_POST['supplier_name'];
    $contact_info = $_POST['contact_info'];
    $address = $_POST['address'];
    $description = $_POST['description'];

    // Validate form inputs
    if (!empty($supplier_name)) {
        // Prevent SQL Injection by escaping inputs
        $supplier_name = mysqli_real_escape_string($conn, $supplier_name);
        $contact_info = mysqli_real_escape_string($conn, $contact_info);
        $address = mysqli_real_escape_string($conn, $address);
        $description = mysqli_real_escape_string($conn, $description);

        // Insert category into the database
        $sql = "INSERT INTO suppliers (supplier_name, contact_info, address, description) 
                VALUES ('$supplier_name', '$contact_info', '$address', '$description')";

        if (mysqli_query($conn, $sql)) {
            $alert_message = "<div class='alert alert-success alert-dismissible fade show floating-alert' role='alert'>
                                Supplier added successfully.
                                <button type='button' class='close text-light' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                              </div>";
        } else {
            $alert_message = "<div class='alert alert-danger alert-dismissible fade show floating-alert' role='alert'>
                                Error: " . mysqli_error($conn) . "
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                              </div>";
        }
    } else {
        $alert_message = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                            Please enter a supplier name.
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                          </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Supplier | Init POS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <style>
    .floating-alert {
        position: absolute;
        width: 100%;
        top: 1px;
        z-index: 1050; /* Make sure it's above other content */
    }
  </style>
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
            <h1>Add Supplier</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">Add Supplier</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-6">
              

              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Add Supplier</h3>
                  <!-- Alert will appear here -->
        <?php if (isset($alert_message)) echo $alert_message; ?>
                </div>
                <!-- form start -->
                <form method="POST" action="">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="supplier_name">Supplier Name</label>
                      <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Enter supplier name" required>
                    </div>
                    <div class="form-group">
                      <label for="contact_info">Contact Info</label>
                      <input type="text" class="form-control" name="contact_info" id="contact_info" placeholder="Enter Contact Information">
                    </div>
                    <div class="form-group">
                      <label for="address">Address</label>
                      <input type="text" class="form-control" name="address" id="address" placeholder="Enter supplier address">
                    </div>
                    <div class="form-group">
                      <label for="description">Description</label>
                      <input type="text" class="form-control" name="description" id="description" placeholder="Enter Description">
                    </div>
                  </div>

                  <div class="d-flex justify-content-between p-4">
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>                  
                  </div>
                </form>
              </div>
              <!-- /.card -->
          </div>
          <div class="col-md-2"></div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  </div>

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Auto dismiss alert -->
<script>
$(document).ready(function() {
    // Auto-dismiss after 5 seconds
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 5000);
});
</script>
</body>
</html>
<?php ob_end_flush() ?>
