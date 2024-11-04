<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login');
  exit();
}
// fnc/process_sale.php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $products = $_POST['products'];
    $paymentMethod = $_POST['paymentMethod'];
    $totalAmount = $_POST['totalAmount'];

    // Initialize response
    $response = ['success' => true, 'error' => ''];

    // Start database transaction
    $conn->begin_transaction();

    try {
        // Check product quantities and update inventory
        foreach ($products as $product) {
            $productId = $product['id'];
            $quantitySold = $product['quantity'];

            // Fetch current stock
            $query = "SELECT quantity_available FROM products WHERE product_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            $productData = $result->fetch_assoc();

            if ($productData['quantity_available'] < $quantitySold) {
                throw new Exception("Not enough stock for product ID $productId.");
            }

            // Update product quantity
            $newQuantity = $productData['quantity_available'] - $quantitySold;
            $updateQuery = "UPDATE products SET quantity_available = ? WHERE product_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ii", $newQuantity, $productId);
            $updateStmt->execute();
        }

        // Insert sale details into the `sales` table
        $saleDate = date('Y-m-d H:i:s');
        $cashierId = $_SESSION['user_id']; // Assuming cashier ID is stored in session
        $insertSale = "INSERT INTO sales (sale_date, cashier_id, total_sale_amount, payment_method, sale_status) 
                       VALUES (?, ?, ?, ?, 'completed')";
        $saleStmt = $conn->prepare($insertSale);
        $saleStmt->bind_param("sids", $saleDate, $cashierId, $totalAmount, $paymentMethod);
        $saleStmt->execute();
        $saleId = $conn->insert_id;

        // Create receipt content
        $receiptContent = "Receipt for Sale #$saleId\n";
        $receiptContent .= "Date: $saleDate\n";
        $receiptContent .= "Cashier ID: $cashierId\n";
        $receiptContent .= "Payment Method: $paymentMethod\n";
        $receiptContent .= "----------------------------------------\n";
        $receiptContent .= "Item\tQty\tPrice\tTotal\n";

        foreach ($products as $product) {
            $productId = $product['id'];
            $productName = $product['name'];
            $quantity = $product['quantity'];
            $price = $product['price'];
            $lineTotal = $price * $quantity;
            $receiptContent .= "$productName\t$quantity\t$price\t$lineTotal\n";
        }
        
        $receiptContent .= "----------------------------------------\n";
        $receiptContent .= "Total: $totalAmount\n";

        // Save receipt file
        $receiptFilename = "../receipts/receipt_$saleId.txt";
        file_put_contents($receiptFilename, $receiptContent);

        // Commit transaction
        $conn->commit();

        // Set success response
        $response['message'] = "Sale completed successfully and receipt saved.";
    } catch (Exception $e) {
        // Rollback transaction if there's any error
        $conn->rollback();
        $response['success'] = false;
        $response['error'] = $e->getMessage();
    }

    // Send response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
