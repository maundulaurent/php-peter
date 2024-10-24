<?php
if (isset($_POST['receipt'])) {
    $receipt = $_POST['receipt'];
    $fileName = 'receipts/' . time() . '_receipt.txt';
    file_put_contents($fileName, $receipt);
    echo 'Receipt saved!';
}
?>
