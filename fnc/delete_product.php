<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];

    $stmt = $conn->prepare("DELETE FROM products WHERE product_id=?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        header("Location: ../all-products.php?message=Product+deleted+successfully");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
