<?php include_once 'site_connection.php'; include_once 'header.php'; 

if(isset($_SESSION['login']))
{
	$id = $_SESSION['login'];

	$sql_select = "select * from user_register where id='$id'";
	$data = mysqli_query($conn,$sql_select);
	$row = mysqli_fetch_assoc($data);

	if (isset($_POST['edit_data'])) {
		header('location:edit_profile_data.php');
	}

	if (isset($_POST['change_pass'])) {
		header('location:change_profile_pass.php');
	}
}
else
{
	header('location:login_home.php');
}

?>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/premium-profile.css">
<script src="js/premium-profile.js"></script>

<div class="container py-5">
    <div class="profile-container">
        <h4 class="heading_profile">
            Manage Your Profile
        </h4>

        <p class="profile-description">
            Update your personal information and manage your account settings
        </p>

        <form method="post">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" 
                       name="name" 
                       class="form-control" 
                       required 
                       disabled 
                       value="<?php echo $row['name']; ?>">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       name="email" 
                       class="form-control" 
                       required 
                       disabled 
                       value="<?php echo $row['email']; ?>">
            </div>

            <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="text" 
                       name="mobile" 
                       class="form-control" 
                       required 
                       disabled 
                       value="<?php echo $row['mobile_number']; ?>">
            </div>

            <button type="submit" 
                    name="edit_data" 
                    class="premium-btn">
                Edit Your Details
            </button>

            <button type="submit" 
                    name="change_pass" 
                    class="premium-btn">
                Change Password
            </button>

            <div class="divider">
                <span>OR</span>
            </div>

            <div class="back-link">
                <p>Want to go back to the homepage?</p>
                <a href="index.php" class="premium-btn">
                    Back to Home
                </a>
            </div>
        </form>
    </div>
</div>

<?php include_once 'scripts.php'; ?>