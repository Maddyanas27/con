<?php
include_once 'site_connection.php';

if(!isset($_SESSION['login']) || !isset($_POST['confirm_order'])) {
    header('location:login_home.php');
    exit;
}

$login_id = $_SESSION['login'];

// Save/Update shipping address
$sql_address = "INSERT INTO shipping_address (user_id, full_name, phone, address_line1, 
                address_line2, city, state, pincode) VALUES (?, ?, ?, ?, ?, ?, ?, ?) 
                ON DUPLICATE KEY UPDATE 
                full_name=VALUES(full_name), phone=VALUES(phone), 
                address_line1=VALUES(address_line1), address_line2=VALUES(address_line2), 
                city=VALUES(city), state=VALUES(state), pincode=VALUES(pincode)";

$stmt = mysqli_prepare($conn, $sql_address);
mysqli_stmt_bind_param($stmt, "isssssss", 
    $login_id, 
    $_POST['full_name'],
    $_POST['phone'],
    $_POST['address_line1'],
    $_POST['address_line2'],
    $_POST['city'],
    $_POST['state'],
    $_POST['pincode']
);

if(mysqli_stmt_execute($stmt)) {
    // Proceed with order placement
    header('location:order-now.php');
} else {
    $_SESSION['error'] = "Error saving address";
    header('location:shipping-address.php');
}