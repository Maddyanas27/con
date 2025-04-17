<?php
include_once 'site_connection.php';

$response = array();

if (isset($_POST['cart_submit'])) {
    if (isset($_SESSION['login'])) {
        $user_id = $_SESSION['login'];
        $cart_id = $_POST['cart_id'];
        $product = $_POST['num_product'];

        if ($product > 0) {
            // Get product details
            $sql_select = "SELECT * FROM `product` WHERE `id`='$cart_id'";
            $data = mysqli_query($conn, $sql_select);
            $row = mysqli_fetch_assoc($data);

            // Check if product already in cart
            $sql_select_c = "SELECT * FROM `cart` WHERE `product_id`='$cart_id' AND `user_id`='$user_id'";
            $data_c = mysqli_query($conn, $sql_select_c);
            $row_count = mysqli_num_rows($data_c);
            $row_data = mysqli_fetch_assoc($data_c);

            $product_id = $cart_id;
            $name = $row['name'];
            $price = $row['price'];
            $image = $row['image1'];

            if ($row_count > 0) {
                // Update existing cart item
                $new_price = $price;
                $new_num_product = $product + $row_data['num_product'];

                $sql_update = "UPDATE `cart` SET 
                              `price`='$new_price',
                              `num_product`='$new_num_product' 
                              WHERE `product_id`='$product_id' 
                              AND `user_id`='$user_id'";
                mysqli_query($conn, $sql_update);
            } else {
                // Add new cart item
                $sql_insert = "INSERT INTO `cart`
                              (`product_id`,`user_id`,`name`,`price`,`num_product`,`image`)
                              VALUES
                              ('$product_id','$user_id','$name','$price','$product','$image')";
                mysqli_query($conn, $sql_insert);
            }

            // Calculate total
            $sql_total = "SELECT SUM(price * num_product) as total 
                         FROM `cart` 
                         WHERE `user_id`='$user_id'";
            $result = mysqli_query($conn, $sql_total);
            $total = mysqli_fetch_assoc($result)['total'];

            $_SESSION['cart_total'] = $total;
            $response['success'] = true;
        }
    } else {
        $_SESSION['cart_id'] = $_POST['cart_id'];
        $_SESSION['num_product'] = $_POST['num_product'];
        $response['redirect'] = 'login_cart.php';
    }
}

echo json_encode($response);
?>