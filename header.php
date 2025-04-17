<?php include_once 'site_connection.php';

if(isset($_SESSION['login']))
{
$login_id = $_SESSION['login'];
$sql_select_login = "select * from `user_register` where `id`='$login_id'";
$data_login = mysqli_query($conn,$sql_select_login);
$row_login = mysqli_fetch_assoc($data_login);

$sql_select_cart = "select * from `cart` where `user_id`='$login_id'";
$data_cart = mysqli_query($conn,$sql_select_cart);

$amt_total = "select * from `cart` where `user_id`='$login_id'";
$data_total = mysqli_query($conn,$amt_total);

$total_price = 0;
while($row_total = mysqli_fetch_assoc($data_total))
{
	$total_price = $total_price + $row_total['price'] * $row_total['num_product'];
}

$data_count = mysqli_num_rows($data_total);
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
	<link rel="stylesheet" type="text/css" href="css/premium-header.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!--===============================================================================================-->
</head>
<body class="animsition">

	<!-- Header -->
	<header class="premium-header">
		 <!-- Main Header -->
		<div class="main-header">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-3">
						<a href="index.php" class="logo">
							<img src="images/icons/log.jpg" alt="IMG-LOGO">
						</a>
					</div>
					<div class="col-md-6">
						<nav class="main-nav">
							<ul class="nav justify-content-center">
								<li class="nav-item">
									<a class="nav-link active" href="index.php">Home</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="product.php">Shop</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="blog.php">Blog</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" href="about.php">About</a>
								</li>
							</ul>
						</nav>
					</div>
					<div class="col-md-3">
						<div class="header-right d-flex align-items-center justify-content-end">
							<div class="header-icons mr-4">
								<a href="#" class="header-icon js-show-modal-search">
									<i class="zmdi zmdi-search"></i>
								</a>
								<a href="shoping-cart.php" class="header-icon">
									<i class="zmdi zmdi-shopping-cart"></i>
									<?php if (isset($_SESSION['login'])) { ?>
										<span class="cart-count"><?php echo $data_count; ?></span>
									<?php } ?>
								</a>
							</div>
							<?php if (isset($_SESSION['login'])) { ?>
								<div class="user-profile">
									<div class="profile-menu">
										<a href="#" class="user-name">
											<i class="zmdi zmdi-account-circle"></i>
												<span title="<?php echo $row_login['name']; ?>"><?php echo $row_login['name']; ?></span>
										</a>
										<div class="profile-dropdown">
											<ul class="list-unstyled mb-0">
												<li><a href="my_profile.php"><i class="zmdi zmdi-account mr-2"></i>My Profile</a></li>
												<li><a href="order-list.php"><i class="zmdi zmdi-shopping-basket mr-2"></i>My Orders</a></li>
												<li><a href="shoping-cart.php"><i class="zmdi zmdi-shopping-cart mr-2"></i>Cart</a></li>
												<li><hr class="my-2"></li>
												<li><a href="logouts.php"><i class="zmdi zmdi-power mr-2"></i>Logout</a></li>
											</ul>
										</div>
									</div>
								</div>
							<?php } else { ?>
								<a href="login_home.php" class="nav-link"><i class="zmdi zmdi-account-circle mr-2"></i>Login</a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>

	<script src="js/premium-header.js"></script>
</body>
</html>


