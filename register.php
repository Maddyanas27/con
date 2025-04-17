<?php 

include_once 'site_connection.php';

if (isset($_POST['register']))
{
	$name = $_POST['name'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];

	if($password1 == $password2)
	{
		$sql_select_email = "select * from `user_register` where `email`='$email'";
		$data_email = mysqli_query($conn,$sql_select_email);
		$email_count = mysqli_num_rows($data_email);

		$sql_select_mobile = "select * from `user_register` where `mobile_number`='$mobile'";
		$data_mobile = mysqli_query($conn,$sql_select_mobile);
		$mobile_count = mysqli_num_rows($data_mobile);

			if($email_count==0)
			{
				if($mobile_count==0)
				{
					$sql_insert = "insert into `user_register`(`name`,`email`,`mobile_number`,`password`)values('$name','$email','$mobile','$password1')";
					mysqli_query($conn,$sql_insert);

					header('location:login_home.php');
				}
				else
				{ ?>
					<div style="text-align: center; color: red; padding-top:10px;">"Entered Mobile Number is already exist.... Please enter correct Mobile number or user Forgot Password option...."</div>
				<?php }
			}
			else
			{ ?>
				<div style="text-align: center; color: red; padding-top:10px;">"Entered Email ID is already exist.... Please enter correct email or user Forgot Password option...."</div>
			<?php }
	}
	else
	{ ?>
		<div style="text-align: center; color: red; padding-top:10px;">"Re-entered password is not match.. Kindly enter same password in both tab...."</div>
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
<!--===============================================================================================-->
	<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/premium-register.css">
</head>

<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.php" class="logo_login">
				<img src="images/icons/log.jpg" alt="IMG-LOGO">
			</a>
		</div>
	</div>
	

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-11">
            <div class="premium-register-container">
                <div class="register-header">
                    <h4>Create Account</h4>
                    <p>Join us for a premium shopping experience</p>
                </div>

                <form method="post">
                    <div class="form-group">
                        <label class="premium-label">Full Name</label>
                        <input type="text" name="name" class="premium-input" required>
                    </div>

                    <div class="form-group">
                        <label class="premium-label">Email Address</label>
                        <input type="email" name="email" class="premium-input" required>
                    </div>

                    <div class="form-group">
                        <label class="premium-label">Mobile Number</label>
                        <input type="tel" name="mobile" class="premium-input" required>
                    </div>

                    <div class="form-group">
                        <label class="premium-label">Password</label>
                        <input type="password" name="password1" class="premium-input" 
                               minlength="6" maxlength="10" required>
                    </div>

                    <div class="form-group">
                        <label class="premium-label">Confirm Password</label>
                        <input type="password" name="password2" class="premium-input" 
                               minlength="6" maxlength="10" required>
                    </div>

                    <button type="submit" class="premium-btn" name="register">
                        Create Account
                    </button>

                    <div class="premium-divider">
                        <span>OR</span>
                    </div>

                    <div class="text-center">
                        <p class="mb-3">Already have an account?</p>
                        <a href="login_home.php" class="premium-btn">Sign In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once 'scripts.php'; ?>