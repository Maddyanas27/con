<?php
include_once '../site_connection.php';

header('Content-Type: application/json');

if(isset($_SESSION['login'])) {
    $login_id = $_SESSION['login'];
    
    $sql = "SELECT SUM(price * num_product) as total FROM cart WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $login_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    echo json_encode([
        'total' => number_format($row['total'] ?? 0, 2)
    ]);
} else {
    echo json_encode(['total' => '0.00']);
}