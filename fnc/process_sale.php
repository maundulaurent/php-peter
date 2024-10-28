<?php
session_start();
include '../includes/db.php';

// Enable error reporting to help identify the problem
ini_set('display_errors', 0); // Don't display errors to user
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', '../error_log.log'); // Log errors to error_log.log in project root

header('Content-Type: application/json'); // Ensure JSON response header

$response = ['success' => true, 'message' => 'Sale processed successfully', 'errors' => []];
$products = $_POST['products'] ?? [];

// Check if request is valid
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $response['success'] = false;
    $response['message'] = 'Invalid request';
    echo json_encode($response);
    exit();
}

// Begin sale processing
foreach ($products as $product) {
    $productId = $product['productId'];
    $quantitySold = $product['quantity'];

    // Fetch current stock and price
    $query = "SELECT quantity_available, selling_price FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $stmt->bind_result($currentQuantity, $sellingPrice);
    $stmt->fetch();
    $stmt->close();

    // Check stock and proceed with sale if stock is sufficient
    if ($currentQuantity >= $quantitySold) {
        $newQuantity = $currentQuantity - $quantitySold;
        $updateQuery = "UPDATE products SET quantity_available = ? WHERE product_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ii", $newQuantity, $productId);
        if (!$updateStmt->execute()) {
            $response['success'] = false;
            $response['errors'][] = "Failed to update product ID: $productId";
        }
        $updateStmt->close();

        // Record the sale
        $totalPrice = $sellingPrice * $quantitySold;
        $saleQuery = "INSERT INTO sales (product_id, quantity_sold, total_price, sale_date) VALUES (?, ?, ?, NOW())";
        $saleStmt = $conn->prepare($saleQuery);
        $saleStmt->bind_param("iid", $productId, $quantitySold, $totalPrice);
        if (!$saleStmt->execute()) {
            $response['success'] = false;
            $response['errors'][] = "Failed to record sale for product ID: $productId";
        }
        $saleStmt->close();
    } else {
        $response['success'] = false;
        $response['errors'][] = "Insufficient stock for product ID: $productId";
    }
}

// Return JSON response
echo json_encode($response);
?>
