<!-- /This is my sales UI -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POS Sales Page</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

<div class="wrapper">

  <!-- Navbar -->
 <?php include "includes/navbar.php" ?>

<div class="container-fluid mt-2">
  
  <div class="row">
    <!-- Customer Info -->
    <div class="col-md-4">
        <!-- Search Bar -->
        <div class="row mb-3">
            <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Search Customer">
            </div>
            <!-- <h5>Search to Product</h5> -->
            <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Search Product">
            </div>
        </div>
  
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5>Recents</h5>
        </div>
        <div class="card-body">
          <h6>Init POS</h6>
          <p class="text-muted">stocks</p>
          <div class="d-flex justify-content-between">
            <p>Store: <strong>0.00</strong></p>
            <p>counters: <strong>4200</strong></p>
            <p>sold today: <strong>19</strong></p>
          </div>
        </div>
      </div>

      <div class="card mt-2">
        <div class="card-header bg-secondary text-white">
          <h6>Selected items</h6>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped mb-0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Red Maxi Dress</td>
                <td>101</td>
                <td>1</td>
                <td>Ksh50.00</td>
              </tr>
              <tr>
                <td>Classic Blue Jeans</td>
                <td>003</td>
                <td>1</td>
                <td>Ksh35.00</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Products and Actions -->
    <div class="col-md-8">
      <div class="row">

      <!-- <div class="col-2 mb-2">
          <button class="btn btn-plus w-100 product-btn"><i class="fas fa-plus"></i></button>
        </div> -->
        
        <div class="col-2 mb-2">
          <a href="./" class="btn btn-bl w-100  product-btn">Home</a>
        </div>
        <div class="col-2 mb-2">
          <a href="all-categories" class="btn btn-bl w-100  product-btn">Categories</a>
        </div>
        <div class="col-2 mb-2">
          <a href="all-products" class="btn btn-bl w-100  product-btn">Products</a>
        </div>
        <div class="col-2 mb-2">
          <a href="all-users" class="btn btn-bl w-100  product-btn">Users</a>
        </div>
        <div class="col-2 mb-2">
          <a href="./" class="btn btn-bl w-100  product-btn"></a>
        </div>
        <div class="col-2 mb-2">
          <a href="./" class="btn btn-bl w-100  product-btn"></a>
        </div>



        <!-- Product and Action Buttons with Color Coding and Icons -->
        <div class="col-3 mb-2">
          <!-- <button class="btn btn-info w-100"><i class="fas fa-tshirt"></i> Shirts</button> -->
        </div>
        <div class="col-3 mb-2">
          <!-- <button class="btn btn-bl w-100"><i class="fas fa-female"></i> Dresses</button> -->
        </div>
        <div class="col-3 mb-2">
          <!-- <button class="btn btn-info w-100"><i class="fas fa-jeans"></i> Jeans</button> -->
        </div>
        <div class="col-3 mb-2">
        &nbsp;
          <!-- <button class="btn btn-bl w-100"><i class="fas fa-box-open"></i> Accessories</button> -->
        </div>

        <!-- Action Buttons -->
        <div class="col-3 mb-2">
          <button class="btn btn-light w-100"><i class="fas fa-history"></i> Recent Sales</button>
        </div>
        <div class="col-3 mb-2">
          <button class="btn btn-light w-100"><i class="fas fa-clock"></i> Pending Sales</button>
        </div>
        <div class="col-3 mb-2">
          <button class="btn btn-light w-100"><i class="fas fa-truck"></i> Pickup Orders</button>
        </div>
        <div class="col-3 mb-2">
          <button class="btn btn-light w-100"><i class="fas fa-cash-register"></i> Check Out</button>
        </div>

        <!-- More Action Buttons with Icons -->
        <div class="col-3 mb-2">
          <button class="btn btn-light w-100"><i class="fas fa-dollar-sign"></i> Cash Out</button>
        </div>
        <div class="col-3 mb-2">
          <button class="btn btn-light w-100"><i class="fas fa-gift"></i> Gift Card Balance</button>
        </div>
        <div class="col-3 mb-2">
          <button class="btn btn-light w-100"><i class="fas fa-percentage"></i> Coupons</button>
        </div>
        <div class="col-3 mb-2">
          <button class="btn btn-light w-100"><i class="fas fa-file-invoice-dollar"></i> Promotions</button>
        </div>
      </div>

    
            <div class="col-md-6">
                <div class="card total-card">
                    <div class="card-body text-center">
                        <p class="mb-1">TOTAL</p>
                        <p class="mb-0">&nbsp;&nbsp; </p>
                        <h5>Ksh85.00</h5>
                        <p class="mb-0">TAX: Ksh8.33 &nbsp;&nbsp; NET: Ksh76.67</p>
                        <p class="mb-0">&nbsp;&nbsp; </p>
                    </div>
                </div>
            </div>
     

      <!-- Payment Section -->
      <div class="row mt-4">
        <div class="col-md-6">
          <!-- <button class="btn btn-danger btn-lg w-100"><i class="fas fa-cart-arrow-down"></i> New Sale</button> -->
          <a href="sales?new_doc" class="btn btn-danger btn-lg w-100" > <i class="fas fa-cart-arrow-down"></i> New Sale</a>
        </div>
        <div class="col-md-6">
          <!-- <button class="btn btn-success btn-lg w-100"><i class="fas fa-credit-card"></i> Pay</button> -->
            <button type="button" class="btn btn-success btn-lg w-100" data-toggle="modal" data-target="#modal-lg"><i class="fas fa-credit-card"></i>
                Pay
            </button>
        </div>
      </div>
    </div>
  </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Payment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const navbar = document.querySelector(".main-header");
        if (navbar) {
        navbar.classList.remove("main-header");
        }
    });
    </script>


<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
