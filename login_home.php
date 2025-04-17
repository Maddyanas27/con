<?php 

include_once 'site_connection.php';
	
if (isset($_POST['login']))
{
	$email = $_POST['email'];
	$password = $_POST['password'];

	$sql_select = "select * from `user_register` where `email`='$email' and `password`='$password'";
	$data = mysqli_query($conn,$sql_select);
	$row_count = mysqli_num_rows($data);

	if($row_count>0)
	{
		$row = mysqli_fetch_assoc($data);
		$_SESSION['login']=$row['id'];

		if(isset($_SESSION['cart_id']) && isset($_SESSION['num_product']))
		{
			$user_id = $row['id'];
			$cart_id = $_SESSION['cart_id'];
			$product = $_SESSION['num_product'];
			$size_p = $_SESSION['size_p'];
			$color_p = $_SESSION['color_p'];

			if($product>0)
			{
				$sql_select = "select * from `product` where `id`='$cart_id'";
				$data = mysqli_query($conn,$sql_select);
				$row = mysqli_fetch_assoc($data);

				$sql_select_c = "select * from `cart` where `product_id`='$cart_id' and `user_id`='$user_id'";
				$data_c = mysqli_query($conn,$sql_select_c);
				$row_count = mysqli_num_rows($data_c);
				$row_data = mysqli_fetch_assoc($data_c);

				$product_id = $cart_id;
				$name = $row['name'];
				$price = $row['price'];
				$num_product = $product;
				$image = $row['image1'];

				if($row_count>0)
				{
					$new_price = $price;
					$new_num_product = $num_product + $row_data['num_product'];

					$sql_update = "update `cart` set `price`='$new_price',`num_product`='$new_num_product' where `product_id`='$product_id' and `user_id`='$user_id'";
					mysqli_query($conn,$sql_update);

					header('location:shoping-cart.php');
				}
				else
				{
					$sql_insert = "insert into `cart`(`product_id`,`user_id`,`name`,`price`,`num_product`,`image`,`size`,`color`)values('$product_id','$user_id','$name','$price','$product','$image','$size_p','$color_p')";
					mysqli_query($conn,$sql_insert);

					header('location:shoping-cart.php');
				}
			}
		}
		else
		{
			header('location:index.php');
		}
	}
	else
	{ ?>
		<div style="text-align: center; color: red; padding-top:10px;">"Entered Email or Password is Incorrect...."</div>
	<?php }
}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Home</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main_css.css">
	<link rel="stylesheet" type="text/css" href="css/premium-login.css">
<!--===============================================================================================-->
	<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

</head>

<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.php" class="logo_login">
				<img src="images/icons/log.jpg" alt="IMG-LOGO">
			</a>
		</div>
	

	<div class="container">
	    <div class="row justify-content-center">
	        <div class="col-lg-6 col-md-8 col-sm-11">
	            <div class="premium-login-container">
	                <div class="login-header">
	                    <h4>LOGIN / REGISTER</h4>
	                    <p>Enjoy a personalised shopping experience</p>
	                </div>

	                <form method="post">
	                    <div class="form-group">
	                        <label class="premium-label" for="email">Email</label>
	                        <input class="premium-input" id="email" type="email" name="email" required>
	                    </div>

	                    <div class="form-group">
	                        <label class="premium-label" for="password">Password</label>
	                        <input class="premium-input" id="password" type="password" name="password" required>
	                    </div>

	                    <button class="premium-btn" name="login">
	                        Login
	                    </button>

	                    <div class="text-center mt-3">
	                        <a href="forgot.php" class="premium-link">Forgot Password?</a>
	                    </div>

	                    <div class="premium-divider">
	                        <span>OR</span>
	                    </div>

	                    <div class="text-center">
	                        <p class="mb-3">New to venuto?</p>
	                        <a href="register.php" class="premium-btn">Create an account</a>
	                    </div>
	                </form>
	            </div>
	        </div>
	    </div>
	</div>


	<?php include_once 'scripts.php'; ?>