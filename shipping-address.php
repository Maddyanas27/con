<?php 
include_once 'site_connection.php';

if(!isset($_SESSION['login'])) {
    header('location:login_home.php');
    exit;
}

$login_id = $_SESSION['login'];
// Get existing address if any
$sql_address = "SELECT * FROM shipping_address WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql_address);
mysqli_stmt_bind_param($stmt, "i", $login_id);
mysqli_stmt_execute($stmt);
$address_result = mysqli_stmt_get_result($stmt);
$address = mysqli_fetch_assoc($address_result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shipping Address</title>
    <?php include_once 'header.php'; ?>
    <link rel="stylesheet" type="text/css" href="css/shipping-form.css">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg3 text-white">
                        <h4 class="mb-0">Shipping Address</h4>
                    </div>
                    <div class="card-body">
                        <form action="process-order.php" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Full Name *</label>
                                    <input type="text" name="full_name" class="form-control" 
                                           value="<?php echo $address['full_name'] ?? ''; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Phone Number *</label>
                                    <input type="tel" name="phone" class="form-control" 
                                           value="<?php echo $address['phone'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Address Line 1 *</label>
                                <input type="text" name="address_line1" class="form-control" 
                                       value="<?php echo $address['address_line1'] ?? ''; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label>Address Line 2</label>
                                <input type="text" name="address_line2" class="form-control" 
                                       value="<?php echo $address['address_line2'] ?? ''; ?>">
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label>City *</label>
                                    <input type="text" name="city" class="form-control" 
                                           value="<?php echo $address['city'] ?? ''; ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>State *</label>
                                    <input type="text" name="state" class="form-control" 
                                           value="<?php echo $address['state'] ?? ''; ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Pincode *</label>
                                    <input type="text" name="pincode" class="form-control" 
                                           value="<?php echo $address['pincode'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" name="confirm_order" 
                                        class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                                    Confirm Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'footer.php'; ?>
    <?php include_once 'scripts.php'; ?>
</body>
</html>