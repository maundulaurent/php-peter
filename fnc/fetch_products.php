<?php
// fnc/fetch_products.php
include '../includes/db.php';

// Check if a search term is provided
$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT product_id, product_name, selling_price, quantity_available 
          FROM products 
          WHERE status = 'Active' AND product_name LIKE ?";

// Prepare and execute the statement
$stmt = $conn->prepare($query);
$searchTerm = '%' . $search . '%';
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = [
        'product_id' => $row['product_id'],
        'product_name' => $row['product_name'],
        'selling_price' => $row['selling_price'],
        'quantity_available' => $row['quantity_available']
    ];
}

// Return the product data as JSON
header('Content-Type: application/json');
echo json_encode($products);
?>
