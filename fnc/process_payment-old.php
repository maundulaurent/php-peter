<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $items = json_decode($_POST['items'], true);
    $totalAmount = $_POST['total_amount'];
    
    // Insert payment into the payments table (assuming you have this table)
    $query = "INSERT INTO payments (user_id, amount, payment_method) VALUES (?, ?, 'Cash')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('id', $_SESSION['user_id'], $totalAmount);
    $stmt->execute();

    // Update product quantities
    foreach ($items as $item) {
        $query = "UPDATE products SET quantity = quantity - ? WHERE product_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $item['quantity'], $item['id']);
        $stmt->execute();
    }

    // Success response
    echo json_encode(['success' => true, 'message' => 'Payment processed successfully.']);
} else {
    // Invalid request
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
