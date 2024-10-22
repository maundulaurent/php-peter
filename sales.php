<?php
ob_start();
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login');
  exit();
}
include 'includes/db.php';

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
   <section class="content-header">
     <div class="container-fluid">
       <div class="row mb-2">
         <div class="col-sm-6">
           <h1>Sales</h1>
         </div>
         <div class="col-sm-6">
           <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="#">Home</a></li>
             <li class="breadcrumb-item active">Sales</li>
           </ol>
         </div>
         <div class="col-12">
             <a href="sales.php?new_doc" class="btn btn-primary" style="font-color:#ffffff; color: #ffffff;">New Order</a>
         </div>
       </div>
     </div><!-- /.container-fluid -->
   </section>


   <!-- Main content -->
   <section class="content">
     <div class="container-fluid">
       <!-- SELECT2 EXAMPLE -->


       <div class="row">

         <!-- left column -->
         <div class="col-md-12 col-lg-12">
            <div class="card card-primary">
             
           <!-- My Table -->
             <div class="card-body">
             <h3 class="card-title mb-3">Added Products</h3>
               <table id="example2" class="table table-bordered table-hover">
                 <thead>
                 <tr>
                   <th>Sales Id</th>
                   <th>Item Name</th>
                   <th>Price</th>
                   <th>Quantity</th>
                   <th>Total</th>
                   <th>Action</th>
                 </tr>
                 </thead>
                 <tbody>
                 <tr>
                   <td>Trident</td>
                   <td>Internet
                     Explorer 4.0
                   </td>
                   <td>Win 95+</td>
                   <td>
                   <!-- <i class="fas fa-minus"></i> -->
                   4
                   <!-- <i class="fas fa-plus"></i> -->
                   </td>
                   <td>X</td>
                   <td>X</td>
                 </tr>
                 <tr>
                   <td>Trident</td>
                   <td>Internet
                     Explorer 5.0
                   </td>
                   <td>Win 95+</td>
                   <td>5</td>
                   <td>C</td>
                   <td>C</td>
                 </tr>
                 <tr>
                   <td>Trident</td>
                   <td>Internet
                     Explorer 5.5
                   </td>
                   <td>Win 95+</td>
                   <td>5.5</td>
                   <td>A</td>
                   <td>A</td>
                 </tr>
                 
                 </tbody>
                 
               </table>
             </div>
           <!-- End Table -->
           </div>

           <section class="content">
     <div class="row">
       <div class="col-md-6">
       <div class="card card-primary">
               <div class="card-header border-0">
                 <h3 class="card-title">Add Products</h3>
                 
               </div>
               <div class="card-body">
                 <div class="d-flex justify-content-between align-items-center border-bottom mb-3">

                   <div class="form-group">
                     <label for="inputStatus">Select Product</label>
                     <select id="inputStatus" class="form-control custom-select">
                       <option selected disabled>-select product-</option>
                       <option>On Hold</option>
                       <option>Canceled</option>
                       <option>Success</option>
                     </select>
                   </div>
                   <div class="form-group p-1">
                     <label for="inputEstimatedBudget">Barcode</label>
                     <input type="number" id="inputEstimatedBudget" class="form-control" placeholder="barcode">
                   </div>
                   <div class="form-group">
                     <label for="inputEstimatedBudget">Amount Paid</label>
                     <input type="number" id="inputEstimatedBudget" class="form-control" placeholder="Amount">
                   </div>
                   
                 </div>
                 <!-- /.d-flex -->                  
               </div>
             </div>
         <!-- /.card -->
             <div class="form-group">
               <label for="inputEstimatedBudget">Total</label>
               <input type="number" id="inputEstimatedBudget" class="form-control" placeholder="Total">
             </div>
       </div>
       <div class="col-md-6">
         <div class="card card-secondary">
           <div class="card-header">
             <h3 class="card-title">Customer Details</h3>

             <div class="card-tools">
               <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                 <!-- <i class="fas fa-minus"></i> -->
               </button>
             </div>
           </div>
           <div class="card-body">
             <div class="form-group">
               <label for="inputEstimatedBudget">Customer Details</label>
               <input type="number" id="inputEstimatedBudget" class="form-control">
             </div>
             <div class="form-group">
               <label for="inputSpentBudget">Commision</label>
               <input type="number" id="inputSpentBudget" class="form-control">
             </div>
           </div>
           <!-- /.card-body -->
         </div>
         <!-- /.card -->
       </div>
     </div>
     <div class="row">
       <div class="col-12">
         <a href="#" class="btn btn-secondary">Generate</a>
         <input type="submit" value="Update" class="btn btn-success float-right">
       </div>
     </div>
   </section>

           
         </div>


       </div>
     </div>
   </section>
   <!-- /.content -->

   

 </div>
 <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark"></aside>

  <!-- Main Footer -->
  <?php include "includes/footer.php" ?>
</div>

<?php include "includes/scripts.php" ?>
</body>
</html>

<?php ob_end_flush() ?>
