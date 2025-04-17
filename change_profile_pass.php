<?php include_once 'site_connection.php'; include_once 'header.php'; 

if(isset($_SESSION['login']))
{
	$id = $_SESSION['login'];
	$msg = "";
	$msg2 = "";

	if(isset($_POST['change_pass']))
	{
		$curr_pass = $_POST['curr_pass'];
		$new_pass = $_POST['new_pass'];
		$new_pass2 = $_POST['new_pass2'];

		$sql_check = "select * from user_register where password='$curr_pass' and id='$id'";
		$data_check = mysqli_query($conn,$sql_check);
		$check = mysqli_num_rows($data_check);

		if($check>0)
		{
			if($new_pass==$new_pass2)
			{
				if($curr_pass==$new_pass2)
				{
					$msg2 = "";
					$msg = "New password is already used before...! Kindly use another password...";
				}
				else
				{
					$sql_update = "update user_register set password='$new_pass2' where id='$id'";
					mysqli_query($conn,$sql_update);

					$msg = "";
					$msg2 = "Password has been changed sucessfully... Kindly go back to Home or My profile now....";
				}				
			}
			else
			{
				$msg2 = "";
				$msg = "Re-entered new password is not match...! Kindly enter same password in both field...";
			}
		}
		else
		{
			$msg2 = "";
			$msg = "Entered Current passowrd is not match...!";
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
            <i class="zmdi zmdi-lock-outline mr-2"></i>Change Your Password
        </h4>

        <p class="profile-description">
            Please enter your current password and choose a new one
        </p>

        <form method="post">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <?php if($msg): ?>
                        <div class="error-message animate__animated animate__shakeX">
                            <?php echo $msg; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($msg2): ?>
                        <div class="success-message animate__animated animate__fadeIn">
                            <?php echo $msg2; ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="curr_pass">
                            <i class="zmdi zmdi-lock mr-2"></i>Current Password
                        </label>
                        <input type="password" 
                               name="curr_pass" 
                               class="form-control" 
                               minlength="6" 
                               maxlength="15" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="new_pass">
                            <i class="zmdi zmdi-lock-outline mr-2"></i>New Password
                        </label>
                        <input type="password" 
                               name="new_pass" 
                               class="form-control" 
                               minlength="8" 
                               maxlength="15" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="new_pass2">
                            <i class="zmdi zmdi-lock-outline mr-2"></i>Confirm New Password
                        </label>
                        <input type="password" 
                               name="new_pass2" 
                               class="form-control" 
                               minlength="8" 
                               maxlength="15" 
                               required>
                    </div>

                    <button type="submit" 
                            name="change_pass" 
                            class="premium-btn w-100">
                        Update Password
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