<?php
ob_start();
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login');
    exit();
}

include 'includes/db.php';

// Fetch products for dropdown
$query = "SELECT product_id, product_name, selling_price FROM products WHERE status = 'Active'";
$result = mysqli_query($conn, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Selection</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            margin: 20px;
        }
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
        table {
            border-collapse: collapse;
            width: 45%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .remove-item {
            cursor: pointer;
            color: red;
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
<body>

    <div class="dropdown">
        <h2>Select a Product</h2>
        <input type="text" id="product-search" placeholder="Search products..." />
        <div id="product-dropdown" class="dropdown-content">
            <?php foreach ($products as $product): ?>
                <div class="product-item" data-id="<?= $product['product_id'] ?>" data-price="<?= $product['selling_price'] ?>">
                    <?= $product['product_name'] ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div>
        <h2>Selected Products</h2>
        <table id="product-details">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Barcode</th>
                    <th>Description</th>
                    <th>Selling Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="details-body">
                <tr id="details-row">
                    <td colspan="8">Select a product to see the details</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" style="text-align:right;"><strong>Grand Total:</strong></td>
                    <td colspan="2" id="grand-total">0.00</td>
                </tr>
            </tfoot>
        </table>
    </div>

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
                            <td></td>
                            <td></td>
                            <td>${productPrice.toFixed(2)}</td>
                            <td>
                                <div class="quantity-controls">
                                    <button class="quantity-button minus">-</button>
                                    <span class="quantity">1</span>
                                    <button class="quantity-button plus">+</button>
                                </div>
                            </td>
                            <td class="total">${productPrice.toFixed(2)}</td>
                            <td><span class="remove-item" title="Remove this item">&times;</span></td>
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
                var productPrice = parseFloat(row.find('td:nth-child(5)').text());
                var currentQuantity = parseInt(quantitySpan.text());

                if (button.hasClass('plus')) {
                    quantitySpan.text(currentQuantity + 1);
                } else if (button.hasClass('minus') && currentQuantity > 1) {
                    quantitySpan.text(currentQuantity - 1);
                }
                updateTotal(row, productPrice);
                updateGrandTotal();
            });

            // Remove item on click
            $(document).on('click', '.remove-item', function() {
                $(this).closest('tr').remove();
                updateGrandTotal();
            });

            // Update total for the row
            function updateTotal(row, price) {
                var quantity = parseInt(row.find('.quantity').text());
                var total = quantity * price;
                row.find('.total').text(total.toFixed(2));
            }

            // Update grand total
            function updateGrandTotal() {
                var grandTotal = 0;
                $('#details-body .total').each(function() {
                    grandTotal += parseFloat($(this).text());
                });
                $('#grand-total').text(grandTotal.toFixed(2));
            }
        });
    </script>

</body>
</html>
