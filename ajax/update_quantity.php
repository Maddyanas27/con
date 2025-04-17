<?php
include_once '../site_connection.php';

header('Content-Type: application/json');

if(isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    $cart_id = mysqli_real_escape_string($conn, $_POST['cart_id']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    
    if($quantity > 0) {
        $sql = "UPDATE cart SET num_product = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $quantity, $cart_id);
        
        if(mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
            exit;
        }
    }
}

echo json_encode(['success' => false]);