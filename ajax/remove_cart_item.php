<?php
include_once '../site_connection.php';

header('Content-Type: application/json');

if(isset($_POST['cart_id'])) {
    $cart_id = mysqli_real_escape_string($conn, $_POST['cart_id']);
    
    // Delete the item from cart
    $sql = "DELETE FROM cart WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $cart_id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}