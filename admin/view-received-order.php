<?php include_once 'header.php';

// Update order status
if(isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $sql_update = "UPDATE `order` SET status = '$status' WHERE id = '$order_id'";
    
    if(mysqli_query($conn, $sql_update)) {
        // Add success message to session
        $_SESSION['message'] = "Order status updated successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        // Add error message to session
        $_SESSION['message'] = "Error updating order status!";
        $_SESSION['message_type'] = "error";
    }

    // Redirect back to view-received-order.php
    header('Location: view-received-order.php');
    exit();
}

// Get all orders with pagination
$sql_select_data = "SELECT o.*, u.name as customer_name 
                    FROM `order` o
                    LEFT JOIN user_register u ON o.user_id = u.id
                    ORDER BY o.date_time DESC";
$data_data = mysqli_query($conn, $sql_select_data);
$data_count = mysqli_num_rows($data_data);

$limit = 5;
$page_count = ceil($data_count/$limit);

if (isset($_GET['p_id'])) {
    $page_no = $_GET['p_id'];
} else {
    $page_no = 1;
}

$start = ($page_no-1)*$limit;

$sql_select = "SELECT o.*, u.name as customer_name 
               FROM `order` o
               LEFT JOIN user_register u ON o.user_id = u.id
               ORDER BY o.date_time DESC 
               LIMIT $start, $limit";
$data = mysqli_query($conn, $sql_select);
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>View / Manage Data of Sliders</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">View/Manage data of Products</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover display_order_admin_page_change">
                  <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Order Date/Time</th>
                    <th>Customer Name</th>
                    <th>Product Details</th>
                    <th>Order Status</th>
                    <th>Delivery Details</th>
                    <th>Payment Method</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  
                  <?php while ($row = mysqli_fetch_assoc($data)) { ?>
                  <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo date('d M Y H:i', strtotime($row['date_time'])); ?></td>
                    <td>
                        <?php echo htmlspecialchars($row['customer_name']); ?><br>
                        <?php echo htmlspecialchars($row['mobile']); ?><br>
                        <?php echo htmlspecialchars($row['email']); ?>
                    </td>
                    <td>
                        <div style="width: 200px;">
                            <img src="image/<?php echo $row['image']; ?>" style="height: 100px; width: 100px; object-fit: cover;"><br>
                            <?php echo htmlspecialchars($row['name']); ?><br>
                            Quantity: <?php echo $row['num_product']; ?><br>
                            Price: Rs.<?php echo $row['price']; ?><br>
                            Total: Rs.<?php echo $row['price'] * $row['num_product']; ?>
                        </div>
                    </td>
                    <td>
                        <form method="post" action="update_order_status.php">
                            <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">
                            <select name="status" class="form-control mb-2">
                                <option value="Pending" <?php echo $row['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="Confirmed" <?php echo $row['status'] == 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                <option value="Shipped" <?php echo $row['status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                                <option value="Delivered" <?php echo $row['status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                                <option value="Cancelled" <?php echo $row['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
                        </form>
                    </td>
                    <td>
                        <?php echo nl2br(htmlspecialchars($row['address'])); ?><br>
                        <?php echo htmlspecialchars($row['city']); ?>, 
                        <?php echo htmlspecialchars($row['pincode']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['payment']); ?></td>
                    <td>
                        <a href="view-more-product-order.php?v_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">View Details</a>
                    </td>
                  </tr>
                  <?php } ?>

                   <tr>
                    <td colspan="8" align="center">
                  <?php for ($i=1; $i<=$page_count; $i++) { ?>
                    <a href="javascript:void(0)" class="btn btn-primary-page 
                    <?php if(isset($_GET['p_id']))
                      {
                        if($_GET['p_id']==$i)
                        {
                          echo "btn-primary-page-active";
                        }
                        else
                        {
                          echo "";
                        }
                      }
                      else
                      {
                        if($i==1)
                        {
                          echo "btn-primary-page-active";
                        }
                      } ?> order_admin_page_change " attr_id=<?php echo $i; ?> >
                    <?php echo $i; ?>
                    </a>
                  <?php } ?>   
                    </td>
                  </tr>

                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <?php include_once 'footer.php'; ?>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include_once 'scripts.php'; ?>
