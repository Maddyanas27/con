<?php include_once 'site_connection.php'; ?>

<?php 

if(isset($_SESSION['login']))
{
	$login_id = $_SESSION['login'];
	$sql_select_login = "select * from `user_register` where `id`='$login_id'";
	$data_login = mysqli_query($conn,$sql_select_login);
	$row_login = mysqli_fetch_assoc($data_login);

		$sql_select = "select * from `order` where `user_id`='$login_id' order by `status` desc";
		$data = mysqli_query($conn,$sql_select);

		$sql_select_o = "select * from `order` where `user_id`='$login_id'";
		$data_o = mysqli_query($conn,$sql_select_o);
		$row_o = mysqli_fetch_assoc($data_o);

		$amt_total = "select * from `order` where `user_id`='$login_id'";
		$data_total = mysqli_query($conn,$amt_total);

		$total_price = 0;
		while($row_total = mysqli_fetch_assoc($data_total))
		{
			$total_price = $total_price + $row_total['price'] * $row_total['num_product'];
		}

		$sql_select_r = "select * from `user_register` where `id`='$login_id'";
		$data_r = mysqli_query($conn,$sql_select_r);
		$row_r = mysqli_fetch_assoc($data_r);

		$sql_select_pay = "select `payment` from `order` where `user_id`='$login_id'";
		$data_pay = mysqli_query($conn,$sql_select_pay);
		$row_pay = mysqli_fetch_assoc($data_pay);

		if($row_pay!="")
		{
			if ($row_pay['payment']=='Cash on Delivery')
			{
				$payment_status = 'CASH ON DELIVERY';
			}
			else
			{
				$payment_status = 'PAID';
			}

			if (isset($_POST['cancel']))
			{	
				header('location:cancel-order.php');
			}
		}

}
else
{
	header('location:login_home.php');
}


 ?>

<!-- breadcrumb -->
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
<!--===============================================================================================-->
	<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/premium-order.css">

</head>
<body class="animsition">

	<header class="header-v4">
		<div class="container-menu-desktop">
			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop container">
					
					<!-- Logo desktop -->		
					<a href="index.php" class="logo">
						<img src="images/icons/log.jpg" alt="IMG-LOGO">
					</a>

					 <!-- Profile Menu -->
					 <?php if (isset($_SESSION['login'])) { ?>
                    <div class="profile-menu ml-auto">
                        <div class="user-info">
                            <span class="welcome-text">Welcome, <?php echo $row_login['name']; ?></span>
                            <div class="profile-dropdown">
                                <a href="my_profile.php">My Profile</a>
                                <a href="order-list.php">Order List</a>
                                <a href="shoping-cart.php">My Cart</a>
                                <a href="logouts.php">Logout</a>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <a href="login_home.php" class="premium-btn ml-auto">
                        Login / Sign-in
                    </a>
                <?php } ?>
				</nav>
			</div>	
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->		
			<div class="logo-mobile">
				<a href="index.php"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
			</div>

			<!-- Icon header -->
			<!-- <div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>

				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="8">
					<i class="zmdi zmdi-shopping-cart"></i>
				</div>

				<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="0">
					<i class="zmdi zmdi-favorite-outline"></i>
				</a>
			</div> -->

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="topbar-mobile">
				<li>
					<div class="left-top-bar">
						Free shipping for standard order over $100
					</div>
				</li>

				<li>
					<div class="right-top-bar flex-w">
						<a href="#" class="flex-c-m p-lr-13 trans-04">
							Help & FAQs
						</a>

						<a href="#" class="flex-c-m p-lr-13 trans-04">
							INR
						</a>

						<?php if (isset($_SESSION['login']))
						{ ?>
							<div class="profile-main-menu-m">
							<a href="#" class="flex-c-m trans-04 p-lr-25" style="border-left: 0">My Account</a>
								<ul class="profile-sub-menu-m">
									<li><h5><?php echo $row_login['name']; ?></h5></li>
									<li><a href="index.php" class="right-top-bar-2">My Profile</a></li>
									<li><a href="index.php">Order List</a></li>
									<li><a href="shoping-cart.php">My Cart</a></li>
									<li><a href="logout.php">Logout</a></li>
								</ul>
							</div>
						<?php }
						else{ ?>
							<a href="login_home.php" class="flex-c-m trans-04 p-lr-25">
								Login / Sign-in
							</a>
						<?php } ?>

						<?php if (isset($_SESSION['login']))
						{ ?>
							<a style="color: #b2b2b2;" class="flex-c-m trans-04 p-lr-15">
								Hello... <?php echo $row_login['name']; ?>!
							</a>
						<?php } ?>
					</div>
				</li>
			</ul>

			<!-- <ul class="main-menu-m">
				<li>
					<a href="index.php">Home</a>
					<ul class="sub-menu-m">
						<li><a href="index.php">Homepage 1</a></li>
						<li><a href="home-02.php">Homepage 2</a></li>
						<li><a href="home-03.php">Homepage 3</a></li>
					</ul>
					<span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
				</li>

				<li>
					<a href="product.php">Shop</a>
				</li>

				<li>
					<a href="shoping-cart.php" class="label1 rs1" data-label1="hot">Shopping Cart</a>
				</li>

				<li>
					<a href="blog.php">Blog</a>
				</li>

				<li>
					<a href="about.php">About</a>
				</li>

				<li>
					<a href="contact.php">Contact</a>
				</li>
			</ul> -->
		</div>

		<!-- Modal Search -->
		<!-- <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="images/icons/icon-close2.png" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Search...">
				</form>
			</div>
		</div> -->
	</header>

	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-15 p-lr-0-lg">
			<a href="index.php" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<a href="shoping-cart.php" class="stext-109 cl8 hov-cl1 trans-04">
				Shoping Cart
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Your Order-list
			</span>
		</div>
	</div>

<div class="container py-5">
    <div class="order-container">
        <div class="order_placed">
            <h1>Your Orders</h1>
            <p class="text-muted">Track and manage your orders below</p>
        </div>

        <div class="table-responsive">
            <table class="table-shopping-cart">
                <thead>
                    <tr class="table_head">
                        <th class="column-1">Product</th>
                        <th class="column-4">Quantity</th>
                        <th class="column-5">Status</th>
                        <th class="column-3">Price</th>
                        <th class="column-5">Action</th>
                        <th class="column-5 text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($_SESSION['login'])) {
                        while($row = mysqli_fetch_assoc($data)) { ?>
                            <tr class="table_row">
                                <td class="column-1">
                                    <div class="how-itemcart1">
                                        <img src="admin/image/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                                    </div>
                                    <div class="product-name"><?php echo htmlspecialchars($row['name']); ?></div>
                                </td>
                                <td class="column-4">
                                    <span class="num_pro"><?php echo $row['num_product']; ?></span>
                                </td>
                                <td class="column-5">
                                    <span class="status-badge <?php echo strtolower($row['status']); ?>">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>
                                <td class="column-3">Rs.<?php echo number_format($row['price']); ?></td>
                                <td class="column-5">
                                    <?php if($row['status'] == "Pending") { ?>
                                        <a href="cancel-order.php?c_id=<?php echo $row['id']; ?>" 
                                           class="order_delete">
                                            Cancel Order
                                        </a>
                                    <?php } ?>
                                </td>
                                <td class="column-5 text-right">Rs.<?php echo number_format($row['price'] * $row['num_product']); ?></td>
                            </tr>
                        <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation delays to table rows
    document.querySelectorAll('.table_row').forEach((row, index) => {
        row.style.animationDelay = `${(index + 1) * 0.1}s`;
        row.style.opacity = '0';
        row.style.animation = `fadeIn 0.8s ease ${(index + 1) * 0.1}s forwards`;
    });

    // Add ripple effect to buttons
    document.querySelectorAll('.order_delete').forEach(button => {
        button.addEventListener('click', function(e) {
            const ripple = document.createElement('div');
            ripple.classList.add('ripple');
            this.appendChild(ripple);
            
            const rect = this.getBoundingClientRect();
            ripple.style.left = `${e.clientX - rect.left}px`;
            ripple.style.top = `${e.clientY - rect.top}px`;
            
            setTimeout(() => ripple.remove(), 1000);
        });
    });
});
</script>

	<?php include_once 'footer.php'; ?>

	<?php include_once 'scripts.php'; ?>
