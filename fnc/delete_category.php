<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = $_POST['category_id'];

    $stmt = $conn->prepare("DELETE FROM categories WHERE category_id=?");
    $stmt->bind_param("i", $category_id);

    if ($stmt->execute()) {
        header("Location: ../all-categories.php?message=Category+deleted+successfully");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
