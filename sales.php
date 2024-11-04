<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login');
  exit();
}
?>
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
  <style>
    /* Dropdown Styling */
    #product-dropdown {
      position: absolute;
      background-color: #fff;
      border: 1px solid #ddd;
      max-height: 200px;
      overflow-y: auto;
      display: none;
      z-index: 1000;
      width: 100%;
    }
    .product-item {
      padding: 8px;
      cursor: pointer;
    }
    .product-item:hover {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body class="bg-light">

<div class="wrapper">

  <!-- Navbar -->
 <?php include "includes/navbar.php" ?>

<div class="container-fluid mt-5">
  
  <div class="row">
    <!-- Customer Info -->
    <div class="col-md-4">
      <div class="row mb-3">
          <div class="col-md-6">
              <input type="text" class="form-control" placeholder="Search Customer">
          </div>
          <div class="col-md-6 position-relative">
              <input type="text" id="product-search" class="form-control" placeholder="Search Product">
              <div id="product-dropdown"></div>
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
            <p>Counters: <strong>0.00</strong></p>
            <p>Sold today: <strong>- -</strong></p>
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
                <th>Total</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="selected-products">
              <tr>
                <td colspan="5">No products selected</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Products and Actions -->
    <div class="col-md-8">
      <div class="row">
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

        <div class="col-md-6">
            <div class="card total-card">
                <div class="card-body text-center">
                    <p class="mb-1">TOTAL</p>
                    <p class="mb-0">&nbsp;&nbsp; </p>
                    <h5 id="grand-total">Ksh0.00</h5>
                    <p class="mb-0">TAX: <span id="tax-amount">Ksh0.00</span> &nbsp;&nbsp; NET: <span id="net-amount">Ksh0.00</span></p>
                    <p class="mb-0">&nbsp;&nbsp; </p>
                </div>
            </div>
        </div>
      </div>

        <!-- Payment Section -->
        <div class="row mt-4">
          <div class="col-md-6">
              <a href="sales?new_doc" class="btn btn-danger btn-lg w-100"><i class="fas fa-cart-arrow-down"></i> New Sale</a>
          </div>
          <div class="col-md-6"><button type="button" class="btn btn-success btn-lg w-100" data-toggle="modal" data-target="#modal-lg"><i class="fas fa-credit-card"></i> Pay</button></div>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- Payment Modal -->
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
        <div class="form-group">
          <label for="payment-method">Select Payment Method</label>
          <select id="payment-method" class="form-control">
            <option value="cash">Cash</option>
            <option value="mpesa">Mpesa</option>
          </select>
        </div>
        <p>Items being sold:</p>
        <div id="payment-summary"></div>
        <p><strong>Total Amount:</strong> <span id="modal-total"></span></p>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="confirm-payment" class="btn btn-primary">Finish Sale</button>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function () {
    // const TAX_RATE = 0.1;
    const TAX_RATE = 0.0;
    let selectedProducts = [];

    // Load products dynamically from the database via AJAX
    $('#product-search').on('focus keyup', function () {
      const searchValue = $(this).val().toLowerCase();
      $('#product-dropdown').empty().show();

      $.ajax({
        url: 'fnc/fetch_products.php',
        type: 'GET',
        dataType: 'json',
        data: { search: searchValue },
        success: function(products) {
          products.forEach(product => {
            $('#product-dropdown').append(`
              <div class="product-item" data-id="${product.product_id}" data-name="${product.product_name}" data-price="${product.selling_price}" data-quantity="${product.quantity_available}">
                ${product.product_name}
              </div>
            `);
          });
        }
      });
    });

    // Add product to selection on dropdown item click
    $('#product-dropdown').on('click', '.product-item', function () {
      const productId = $(this).data('id');
      const productName = $(this).data('name');
      const productPrice = parseFloat($(this).data('price'));
      const availableQuantity = parseInt($(this).data('quantity'));

      // Check for existing product in the selected list
      const existingProduct = selectedProducts.find(p => p.id === productId);

      if (existingProduct) {
        if (existingProduct.quantity + 1 > availableQuantity) {
          alert(`Only ${availableQuantity} units of ${productName} are available.`);
          return;
        }
        existingProduct.quantity += 1;
      } else {
        selectedProducts.push({ id: productId, name: productName, price: productPrice, quantity: 1, availableQuantity });
      }

      $('#product-dropdown').hide();
      updateSelectedProductsTable();
      updateTotals();
    });

    // Update Selected Products Table
    function updateSelectedProductsTable() {
      $('#selected-products').empty();
      selectedProducts.forEach(product => {
        $('#selected-products').append(`
          <tr data-id="${product.id}">
            <td>${product.name}</td>
            <td>Ksh${product.price.toFixed(2)}</td>
            <td><button class="quantity-minus">-</button> ${product.quantity} <button class="quantity-plus">+</button></td>
            <td>Ksh${(product.price * product.quantity).toFixed(2)}</td>
            <td><button class="remove-product"><i class="fas fa-trash"></i></button></td>
          </tr>
        `);
      });
    }

    // Update Totals
    function updateTotals() {
      let total = selectedProducts.reduce((sum, product) => sum + (product.price * product.quantity), 0);
      let tax = total * TAX_RATE;
      let net = total - tax;
      $('#grand-total').text(`Ksh${total.toFixed(2)}`);
      $('#tax-amount').text(`Ksh${tax.toFixed(2)}`);
      $('#net-amount').text(`Ksh${net.toFixed(2)}`);
      $('#modal-total').text(`Ksh${total.toFixed(2)}`);
    }

    // Quantity adjustments
    $('#selected-products').on('click', '.quantity-plus, .quantity-minus', function () {
      const $row = $(this).closest('tr');
      const productId = $row.data('id');
      const product = selectedProducts.find(p => p.id === productId);

      if ($(this).hasClass('quantity-plus')) {
        if (product.quantity + 1 > product.availableQuantity) {
          alert(`Only ${product.availableQuantity} units of ${product.name} are available.`);
          return;
        }
        product.quantity += 1;
      } else if (product.quantity > 1) {
        product.quantity -= 1;
      }
      updateSelectedProductsTable();
      updateTotals();
    });

    // Remove product
    $('#selected-products').on('click', '.remove-product', function () {
      const productId = $(this).closest('tr').data('id');
      selectedProducts = selectedProducts.filter(p => p.id !== productId);
      updateSelectedProductsTable();
      updateTotals();
    });

    // Confirm payment
    $('#confirm-payment').click(function () {
      const paymentMethod = $('#payment-method').val();
      const saleData = {
        products: selectedProducts,
        paymentMethod: paymentMethod,
        totalAmount: parseFloat($('#modal-total').text().replace('Ksh', ''))
      };

      $.post('fnc/process_sale.php', saleData, function(response) {
        if (response.success) {
          alert('Sale completed successfully!');
          location.reload();
        } else {
          alert('Error: ' + response.error);
        }
      }, 'json');
    });
  });


</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const navbar = document.querySelector(".main-header");
        if (navbar) {
        navbar.classList.remove("main-header");
        }
    });
    </script>


</body>
</html>
