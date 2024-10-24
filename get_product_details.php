<?php
include 'includes/db.php';

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);
    $query = "SELECT * FROM products WHERE product_id = $productId AND status = 'Active'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        echo json_encode($product);
    } else {
        echo json_encode(null);
    }
} else {
    echo json_encode(null);
}
?>
