<?php
include_once '../site_connection.php';

header('Content-Type: application/json');

if(isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    $cart_id = mysqli_real_escape_string($conn, $_POST['cart_id']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    
    if($quantity > 0) {
        $sql_update = "UPDATE cart SET num_product = '$quantity' WHERE id = '$cart_id'";
        if(mysqli_query($conn, $sql_update)) {
            echo json_encode(['success' => true]);
            exit;
        }
    }
}

echo json_encode(['success' => false]);