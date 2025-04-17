<?php
include_once 'site_connection.php';

if(isset($_POST['cart_submit']) && isset($_SESSION['login'])) {
    $user_id = $_SESSION['login'];
    $cart_id = $_POST['cart_id'];
    $product = $_POST['num_product'];
    
    $response = array();

    if($product > 0) {
        $sql_select = "select * from `product` where `id`='$cart_id'";
        $data = mysqli_query($conn, $sql_select);
        $row = mysqli_fetch_assoc($data);

        $sql_select_c = "select * from `cart` where `product_id`='$cart_id' and `user_id`='$user_id'";
        $data_c = mysqli_query($conn, $sql_select_c);
        $row_count = mysqli_num_rows($data_c);
        $row_data = mysqli_fetch_assoc($data_c);

        $product_id = $cart_id;
        $name = $row['name'];
        $price = $row['price'];
        $image = $row['image1'];

        if($row_count > 0) {
            $new_price = $price;
            $new_num_product = $product + $row_data['num_product'];

            $sql_update = "update `cart` set `price`='$new_price',`num_product`='$new_num_product' 
                          where `product_id`='$product_id' and `user_id`='$user_id'";
            mysqli_query($conn, $sql_update);
        } else {
            $sql_insert = "insert into `cart`(`product_id`,`user_id`,`name`,`price`,`num_product`,`image`) 
                          values('$product_id','$user_id','$name','$price','$product','$image')";
            mysqli_query($conn, $sql_insert);
        }
        
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }
    
    echo json_encode($response);
} else {
    $_SESSION['cart_id'] = $_POST['cart_id'];
    $_SESSION['num_product'] = $_POST['num_product'];
    
    header('location:login_cart.php');
}
?>