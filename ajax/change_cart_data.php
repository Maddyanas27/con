<?php 

include_once '../site_connection.php';

header('Content-Type: application/json');

if(isset($_POST['id']) && isset($_POST['add_pro'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $new_quantity = mysqli_real_escape_string($conn, $_POST['add_pro']);
    
    // Get current stock count
    $sql_stock = "SELECT p.stock_count 
                  FROM cart c 
                  JOIN product p ON c.product_id = p.id 
                  WHERE c.id = '$id'";
    $result_stock = mysqli_query($conn, $sql_stock);
    $row_stock = mysqli_fetch_assoc($result_stock);
    
    if($row_stock && $new_quantity <= $row_stock['stock_count'] && $new_quantity > 0) {
        // Update cart quantity
        $sql_update = "UPDATE cart SET num_product = '$new_quantity' WHERE id = '$id'";
        if(mysqli_query($conn, $sql_update)) {
            echo json_encode(['success' => true]);
            exit;
        }
    }
}

echo json_encode(['success' => false]);
?>