<?php
include_once '../site_connection.php';

header('Content-Type: application/json');

if(isset($_SESSION['login'])) {
    $login_id = $_SESSION['login'];
    
    // Calculate total
    $sql = "SELECT SUM(price * num_product) as total FROM cart WHERE user_id = '$login_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    
    $total = number_format($row['total'] ?? 0, 2);
    echo json_encode(['total' => $total]);
} else {
    echo json_encode(['total' => '0.00']);
}