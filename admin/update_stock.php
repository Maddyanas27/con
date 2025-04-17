<?php
include_once 'header.php';

// Add stock_count column to product table if it doesn't exist
$sql_check_column = "SHOW COLUMNS FROM `product` LIKE 'stock_count'";
$result = mysqli_query($conn, $sql_check_column);

if(mysqli_num_rows($result) == 0) {
    $sql_add_column = "ALTER TABLE `product` ADD COLUMN `stock_count` INT DEFAULT 0";
    mysqli_query($conn, $sql_add_column);
}

if(isset($_POST['product_id']) && isset($_POST['stock_count'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $stock_count = mysqli_real_escape_string($conn, $_POST['stock_count']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $old_stock = mysqli_real_escape_string($conn, $_POST['old_stock']);
    
    // Update stock count
    $sql_update = "UPDATE `product` SET 
                   `stock_count` = '$stock_count',
                   `stock` = CASE 
                        WHEN '$stock_count' > 0 THEN 'In Stock'
                        ELSE 'Out of Stock'
                    END
                   WHERE `id` = '$product_id'";
    
    if(mysqli_query($conn, $sql_update)) {
        $change = $stock_count - $old_stock;
        $change_text = $change >= 0 ? "increased" : "decreased";
        $change_abs = abs($change);
        
        $_SESSION['message'] = sprintf(
            "Stock for '%s' successfully updated! Stock count %s by %d units (from %d to %d).",
            $product_name,
            $change_text,
            $change_abs,
            $old_stock,
            $stock_count
        );
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error updating stock for '$product_name'!";
        $_SESSION['message_type'] = "error";
    }
}

// Redirect back with message
header('Location: view-product.php');
exit();