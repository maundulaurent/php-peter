<?php
session_start();
include 'includes/db.php';

header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cashierId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $totalAmount = isset($_POST['totalAmount']) ? $_POST['totalAmount'] : 0;
    $paymentMethod = isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : 'Cash';
    $discountApplied = isset($_POST['discountApplied']) ? $_POST['discountApplied'] : 0;
    $taxApplied = isset($_POST['taxApplied']) ? $_POST['taxApplied'] : 0;
    $saleStatus = 'Completed';
    $products = isset($_POST['products']) ? $_POST['products'] : [];
    $saleDate = date('Y-m-d H:i:s');

    if (!$cashierId) {
        $response['message'] = 'User not logged in or cashier ID missing.';
        echo json_encode($response);
        exit();
    }

    // Insert the sale record
    $insertSaleQuery = "INSERT INTO sales (sale_date, cashier_id, total_sale_amount, payment_method, discount_applied, tax_applied, sale_status)
                        VALUES ('$saleDate', '$cashierId', '$totalAmount', '$paymentMethod', '$discountApplied', '$taxApplied', '$saleStatus')";

    if (mysqli_query($conn, $insertSaleQuery)) {
        $saleId = mysqli_insert_id($conn);

        $receiptContent = "Receipt for Sale ID: $saleId\nDate: $saleDate\n\nItems:\n";
        foreach ($products as $index => $product) {
            // Log product data for debugging
            if (!isset($product['productId'], $product['productName'], $product['quantity'], $product['price'])) {
                $response['message'] = "Product at index $index is missing required fields.";
                echo json_encode($response);
                exit();
            }

            $productId = $product['productId'];
            $productName = $product['productName'];
            $quantity = $product['quantity'];
            $price = $product['price'];
            $totalPrice = $price * $quantity;

            $receiptContent .= "$productName (x$quantity): Ksh $totalPrice\n";
        }
        $receiptContent .= "\nTotal: Ksh $totalAmount\nPayment Method: $paymentMethod\n";

        $receiptDir = 'receipt';
        if (!is_dir($receiptDir)) {
            mkdir($receiptDir, 0777, true);
        }

        $receiptFile = "$receiptDir/receipt_$saleId.txt";
        if (file_put_contents($receiptFile, $receiptContent) === false) {
            $response['message'] = 'Failed to save receipt file.';
            echo json_encode($response);
            exit();
        }

        $response['success'] = true;
        $response['message'] = 'Cash payment processed successfully.';
        echo json_encode($response);
    } else {
        $response['message'] = 'Failed to insert sale record: ' . mysqli_error($conn);
        echo json_encode($response);
    }
} else {
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
}
?>
