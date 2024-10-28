<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $barcode = $_POST['barcode'];
    $description = $_POST['description'];
    $selling_price = $_POST['selling_price'];
    $quantity_available = $_POST['quantity_available'];

    $stmt = $conn->prepare("UPDATE products SET product_name=?, barcode=?, description=?, selling_price=?, quantity_available=? WHERE product_id=?");
    $stmt->bind_param("sssdii", $product_name, $barcode, $description, $selling_price, $quantity_available, $product_id);

    if ($stmt->execute()) {
        header("Location: ../all-products.php?message=Product+updated+successfully");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
