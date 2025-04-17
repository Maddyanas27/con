<?php include_once 'header.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="css/premium-style.css">

<?php

$sql_select_data = "select * from `product`";
$data_data = mysqli_query($conn,$sql_select_data);
$data_count = mysqli_num_rows($data_data);

$limit = 8;
$page_count = ceil($data_count/$limit);

if (isset($_GET['p_id']))
{
  $page_no = $_GET['p_id'];
}
else
{
  $page_no=1;
}

$start = ($page_no-1)*$limit;

$sql_select = "select * from `product` limit $start,$limit";
$data = mysqli_query($conn,$sql_select);

$previous = $page_no-1;
$next = $page_no+1;

?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-4">
          <div class="col-sm-12 text-center">
            <h1 class="animate__animated animate__fadeIn">Product Management Dashboard</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card animate__animated animate__fadeInUp">
              <?php if(isset($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['message_type'] == 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show animate__animated animate__fadeInDown" style="
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    z-index: 1000;
                    min-width: 300px;
                    max-width: 500px;
                    text-align: center;
                    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
                    border-radius: 10px;
                    padding: 20px;">
                    <h5 style="margin: 0; font-size: 18px; font-weight: 500;">
                        <?php 
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                        unset($_SESSION['message_type']);
                        ?>
                    </h5>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
              <?php endif; ?>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover display_product_admin_page_change">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name of Product</th>
                    <th>Price of Product</th>
                    <th>Category of Product</th>
                    <th>Type of Product</th>
                    <th>Stock Status</th>
                    <th>Stock Count</th>
                    <th>Image 1 (Main)</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  
                  <?php while ($row = mysqli_fetch_assoc($data)) { ?>
                   <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['type']; ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td>
                      <form method="post" action="update_stock.php" class="stock-form">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['name']); ?>">
                        <input type="hidden" name="old_stock" value="<?php echo $row['stock_count']; ?>">
                        <input type="number" name="stock_count" value="<?php echo $row['stock_count']; ?>" min="0" class="form-control" style="width: 100px;">
                        <button type="submit" class="btn btn-sm btn-primary mt-1">Update Stock</button>
                      </form>
                    </td>
                    <td align="center">
                         <div class="product-image" style="width: 200px; height: 170px;">
                             <img src="image/<?php echo $row['image1']; ?>" style="height: 100%; width: 100%; object-fit: cover; object-position: top; border-radius: 10px;">
                         </div>
                    </td>
                    <td>
                      <a href="view-more-product.php?v_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">View More</a>
                    </td>
                  </tr>
                  <?php } ?>

                   <tr>
                    <td colspan="9" align="center">
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
                      } ?> product_admin_page_change " attr_id=<?php echo $i; ?> >
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
