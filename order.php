<?php 
include_once 'site_connection.php';

if(!isset($_SESSION['login'])) {
    header('location:login_home.php');
    exit();
}

$login_id = $_SESSION['login'];
$sql_orders = "SELECT * FROM `order` WHERE `user_id`='$login_id' ORDER BY `date_time` DESC";
$result_orders = mysqli_query($conn, $sql_orders);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <!-- Add your CSS links here -->
</head>
<body>
    <?php include_once 'header.php'; ?>

    <div class="container mt-5">
        <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success">
            Your order has been placed successfully!
        </div>
        <?php endif; ?>

        <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            There was an error processing your order. Please try again.
        </div>
        <?php endif; ?>

        <h2>Your Orders</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order Date</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($order = mysqli_fetch_assoc($result_orders)): ?>
                    <tr>
                        <td><?php echo date('d M Y H:i', strtotime($order['date_time'])); ?></td>
                        <td><?php echo htmlspecialchars($order['name']); ?></td>
                        <td><?php echo $order['num_product']; ?></td>
                        <td>Rs.<?php echo $order['price']; ?></td>
                        <td>Rs.<?php echo $order['price'] * $order['num_product']; ?></td>
                        <td><?php echo ucfirst($order['status']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include_once 'footer.php'; ?>
    <?php include_once 'scripts.php'; ?>
</body>
</html>
