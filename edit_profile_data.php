<?php include_once 'site_connection.php'; include_once 'header.php'; 

if(isset($_SESSION['login']))
{
	$id = $_SESSION['login'];

	$sql_select = "select * from user_register where id='$id'";
	$data = mysqli_query($conn,$sql_select);
	$row = mysqli_fetch_assoc($data);

	$msg = '';

	if(isset($_POST['verify_data']))
	{
		$password = $_POST['password'];

		$sql_check = "select * from user_register where id='$id' and password='$password'";
		$data_check = mysqli_query($conn,$sql_check);
		$check = mysqli_num_rows($data_check);

		if($check>0)
		{
			$name = $_POST['name_e'];
			$email = $_POST['email_e'];
			$mobile = $_POST['mobile_e'];

			$sql_select_email = "select * from user_register where id='$id'";
			$data_email = mysqli_query($conn,$sql_select_email);
			$row_email = mysqli_fetch_assoc($data_email);
			$existing_email = $row_email['email'];

			if($email==$existing_email)
			{
				$sql_update = "update user_register set name='$name',email='$email',mobile_number='$mobile' where id='$id'";
				mysqli_query($conn,$sql_update);

				header('location:my_profile.php');
			}
			else
			{
				$_SESSION['new_email'] = $email;
				$_SESSION['new_name'] = $name;
				$_SESSION['new_mobile'] = $mobile;

				header('location:mail_email_change/smtp.php');
			}
		}
		else
		{
			$msg = "Entered Current passowrd is not matched.....!";
		}		
	}
}
else
{
	header('location:login_home.php');
}

?>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/premium-profile.css">

<div class="container py-5">
    <div class="profile-container">
        <h4 class="heading_profile">
            <i class="zmdi zmdi-edit mr-2"></i>Edit Your Profile
        </h4>

        <p class="profile-description">
            Please update your details below or use the back option to return
        </p>

        <form method="post" id="edit_data">
            <div id="new_number_of_product">
                <div class="bg0">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-md-10">
                            <?php if($msg): ?>
                                <div class="error-message animate__animated animate__shakeX">
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <label for="name">
                                    <i class="zmdi zmdi-account mr-2"></i>Full Name
                                </label>
                                <input type="text" 
                                       name="name_e" 
                                       class="form-control" 
                                       required 
                                       value="<?php echo @$row['name']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="email">
                                    <i class="zmdi zmdi-email mr-2"></i>Email Address
                                </label>
                                <input type="email" 
                                       name="email_e" 
                                       class="form-control" 
                                       required 
                                       value="<?php echo @$row['email']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="mobile">
                                    <i class="zmdi zmdi-phone mr-2"></i>Mobile Number
                                </label>
                                <input type="text" 
                                       name="mobile_e" 
                                       class="form-control" 
                                       required 
                                       value="<?php echo @$row['mobile_number']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="password">
                                    <i class="zmdi zmdi-lock mr-2"></i>Current Password
                                </label>
                                <input type="password" 
                                       name="password" 
                                       class="form-control" 
                                       required 
                                       placeholder="Enter your current password">
                            </div>

                            <button type="submit" 
                                    name="verify_data" 
                                    class="premium-btn w-100">
                                Update Profile
                            </button>

                            <div class="divider">
                                <span>or</span>
                            </div>

                            <div class="back-link">
                                <p>Want to go back without making changes?</p>
                                <a href="my_profile.php" class="premium-btn">
                                    Back to Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation delays to form groups
    document.querySelectorAll('.form-group').forEach((group, index) => {
        group.style.animationDelay = `${(index + 1) * 0.1}s`;
    });

    // Add ripple effect to buttons
    document.querySelectorAll('.premium-btn').forEach(button => {
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

<?php include_once 'scripts.php'; ?>