<?php
// Include database connection file
require_once 'db_connection.php'; // Adjust this path as necessary

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the products array is set in the POST request
    if (isset($_POST['products']) && is_array($_POST['products'])) {
        // Retrieve the products from the POST data
        $products = $_POST['products'];

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO sales (product_id, quantity) VALUES (?, ?)");
        
        if (!$stmt) {
            echo json_encode(["error" => "SQL Prepare Error: " . $conn->error]);
            exit;
        }

        // Loop through each product and bind parameters
        foreach ($products as $product) {
            // Ensure productId and quantity are set
            if (isset($product['productId']) && isset($product['quantity'])) {
                $productId = $product['productId'];
                $quantity = $product['quantity'];

                // Bind parameters to the prepared statement
                if (!$stmt->bind_param("ii", $productId, $quantity)) {
                    echo json_encode(["error" => "Bind Param Error: " . $stmt->error]);
                    continue; // Skip to the next product
                }

                // Execute the statement
                if (!$stmt->execute()) {
                    echo json_encode(["error" => "Execution Error: " . $stmt->error]);
                }
            } else {
                echo json_encode(["error" => "Product data is incomplete for a product."]);
            }
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo json_encode(["error" => "No products found in the request."]);
    }
} else {
    echo json_encode(["error" => "Invalid request method."]);
}

// Close the database connection
$conn->close();
?>
