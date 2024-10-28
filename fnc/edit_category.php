<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE categories SET category_name=?, description=? WHERE category_id=?");
    $stmt->bind_param("ssi", $category_name, $description, $category_id);

    if ($stmt->execute()) {
        header("Location: ../all-categories.php?message=Category+updated+successfully");
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
