<?php
ob_start();
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login');
  exit();
}
include 'includes/db.php';

// Fetch products for dropdown
$query = "SELECT product_id, product_name, barcode, description, selling_price FROM products WHERE status = 'Active'";
$result = mysqli_query($conn, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
  <style>
      /* Add your custom styles here */
      .dropdown {
          position: relative;
          display: inline-block;
      }
      .dropdown-content {
          display: none;
          position: absolute;
          background-color: #f9f9f9;
          min-width: 200px;
          z-index: 1;
          border: 1px solid #ddd;
      }
      .dropdown-content input {
          width: 100%;
          padding: 8px;
          box-sizing: border-box;
      }
      .dropdown-content div {
          padding: 8px;
          cursor: pointer;
      }
      .dropdown-content div:hover {
          background-color: #f1f1f1;
      }
      .quantity-controls {
          display: flex;
          align-items: center;
          justify-content: center;
      }
      .quantity-button {
          cursor: pointer;
          margin: 0 5px;
          padding: 2px 5px;
          border: 1px solid #ccc;
          border-radius: 3px;
      }
  </style>
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
             <li class="breadcrumb-item"><a href="./">Home</a></li>
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
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary">
                    <div class="card-header border-0">
                        <h3 class="card-title">Add Products</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputStatus">Select Product</label>
                            <div class="dropdown">
                                <input type="text" id="product-search" placeholder="Search products..." />
                                <div id="product-dropdown" class="dropdown-content">
                                    <?php foreach ($products as $product): ?>
                                        <div class="product-item" data-id="<?= $product['product_id'] ?>" data-price="<?= $product['selling_price'] ?>" data-barcode="<?= $product['barcode'] ?>" data-description="<?= $product['description'] ?>">
                                            <?= $product['product_name'] ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEstimatedBudget">Total</label>
                            <input type="number" id="total-amount" class="form-control" placeholder="Total" readonly>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header border-0">
                        <h3 class="card-title">Selected Products</h3>
                    </div>
                    <!-- My Table -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Item Id</th>
                                    <th>Item Name</th>
                                    <th>Barcode</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="details-body">
                                <tr id="details-row">
                                    <td colspan="7">Select a product to see the details</td>
                                </tr>
                            </tbody>
                            <!-- <tfoot>
                                <tr>
                                    <td colspan="5" style="text-align:right;"><strong>Grand Total:</strong></td>
                                    <td colspan="2" id="grand-total">0.00</td>
                                </tr>
                            </tfoot> -->
                        </table>
                    </div>
                    <!-- End Table -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="#" class="btn btn-success float-right">Payment</a>
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


<!-- Cash Payment Modal -->
<div class="modal fade" id="cashPaymentModal" tabindex="-1" aria-labelledby="cashPaymentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cashPaymentModalLabel">Cash Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Confirm your cash payment for the following items:</p>
        <div id="cashPaymentItems"></div>
        <p><strong>Total Amount:</strong> Ksh <span id="cashTotalAmount"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" id="confirmCashPayment" class="btn btn-success">Confirm Payment</button>
      </div>
    </div>
  </div>
</div>



<?php include "includes/scripts.php" ?>
<script>
    $(document).ready(function() {
        // Show dropdown content on input focus
        $('#product-search').on('focus', function() {
            $('#product-dropdown').show();
        });

        // Filter products based on search input
        $('#product-search').on('keyup', function() {
            var searchValue = $(this).val().toLowerCase();
            $('#product-dropdown .product-item').each(function() {
                var productName = $(this).text().toLowerCase();
                $(this).toggle(productName.indexOf(searchValue) > -1);
            });
        });

        // Select product from dropdown
        $(document).on('click', '.product-item', function() {
            var productId = $(this).data('id');
            var productPrice = parseFloat($(this).data('price'));
            var productName = $(this).text();
            var productBarcode = $(this).data('barcode');
            var productDescription = $(this).data('description');

            // Hide dropdown after selection
            $('#product-dropdown').hide();
            $('#product-search').val('');

            // Check if product already exists
            var existingRow = $('#details-body tr[data-id="' + productId + '"]');
            if (existingRow.length === 0) {
                // If product does not exist, add a new row
                $('#details-body').append(`
                    <tr data-id="${productId}">
                        <td>${productId}</td>
                        <td>${productName}</td>
                        <td>${productBarcode}</td>
                        <td>${productPrice.toFixed(2)}</td>
                        <td>
                            <div class="quantity-controls">
                                <button class="quantity-button minus">-</button>
                                <span class="quantity">1</span>
                                <button class="quantity-button plus">+</button>
                            </div>
                        </td>
                        <td class="total">${productPrice.toFixed(2)}</td>
                        <td class="remove-item"><i class="fas fa-trash" title="Remove item" style="color: grey; cursor: pointer;"></i></td>
                    </tr>
                `);
            } else {
                // If product already exists, increment the quantity
                var quantitySpan = existingRow.find('.quantity');
                var currentQuantity = parseInt(quantitySpan.text());
                quantitySpan.text(currentQuantity + 1);
                updateTotal(existingRow, productPrice);
            }
            updateGrandTotal();
        });

        // Increase or decrease quantity
        $(document).on('click', '.quantity-button', function() {
            var button = $(this);
            var row = button.closest('tr');
            var quantitySpan = row.find('.quantity');
            var currentQuantity = parseInt(quantitySpan.text());
            var productPrice = parseFloat(row.find('td:eq(3)').text());
            
            if (button.hasClass('plus')) {
                quantitySpan.text(currentQuantity + 1);
            } else if (button.hasClass('minus') && currentQuantity > 1) {
                quantitySpan.text(currentQuantity - 1);
            }

            updateTotal(row, productPrice);
            updateGrandTotal();
        });

        // Remove item from selected products
        $(document).on('click', '.remove-item', function() {
            $(this).closest('tr').remove();
            updateGrandTotal();
        });

        // Update total for a row
        function updateTotal(row, price) {
            var quantity = parseInt(row.find('.quantity').text());
            var total = price * quantity;
            row.find('.total').text(total.toFixed(2));
        }

        // Update grand total
        function updateGrandTotal() {
            var grandTotal = 0;
            $('#details-body .total').each(function() {
                grandTotal += parseFloat($(this).text());
            });
            $('#grand-total').text(grandTotal.toFixed(2));
            $('#total-amount').val(grandTotal.toFixed(2));
        }

        // Hide dropdown if clicked outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('#product-dropdown').hide();
            }
        });


         // Trigger payment modal and fill details
        $('.btn-success.float-right[href="#"]').on('click', function(e) {
        e.preventDefault();
        let totalAmount = $('#total-amount').val();
        let itemDetails = '';

        $('#details-body tr').each(function() {
            let productName = $(this).find('td:eq(1)').text();
            let quantity = $(this).find('.quantity').text();
            let total = $(this).find('.total').text();
            itemDetails += `<p>${productName} (x${quantity}): Ksh ${total}</p>`;
        });

        $('#cashPaymentItems').html(itemDetails);
        $('#cashTotalAmount').text(totalAmount);
        $('#cashPaymentModal').modal('show');
    });

    // Confirm Cash Payment
    $('#confirmCashPayment').on('click', function() {
        let totalAmount = $('#total-amount').val();
        let discountApplied = 0;  // Adjust if discounts are available
        let taxApplied = 0;       // Adjust if taxes are applied
        let paymentMethod = 'Cash';

        // Collect product details for receipt and database entry
let products = [];
$('#details-body tr').each(function() {
    let productId = $(this).data('id');
    let productName = $(this).find('td:eq(1)').text();
    let quantity = parseInt($(this).find('.quantity').text());
    let price = parseFloat($(this).find('td:eq(3)').text());

    // Check if all required fields are correctly retrieved
    console.log({
        productId,
        productName,
        quantity,
        price
    });

    // Add to products array only if all fields are present
    if (productId && productName && !isNaN(quantity) && !isNaN(price)) {
        products.push({ productId, productName, quantity, price });
    } else {
        console.error("Missing required product fields", {
            productId,
            productName,
            quantity,
            price
        });
    }
});

    });
    });


</script>
</body>
</html>

<?php ob_end_flush() ?>
