<?php include_once 'header.php';

if (isset($_GET['e_id']))
{
    $edit_id = $_GET['e_id'];
}

$sql_select = "select * from `product` where `id`='$edit_id'";
$data = mysqli_query($conn,$sql_select);
$row = mysqli_fetch_assoc($data);

$tag = explode(', ',$row['tag']);
$tag_length = count($tag);

if (isset($_POST['edited_product']))
{
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $tag = implode(', ',$_POST['tag']);
    $type = $_POST['type'];
    $one_line_title = $_POST['one_line_title'];
    $weight = $_POST['weight'];
    $material = $_POST['material'];
    $stock = $_POST['stock'];

    $image1_e = $_FILES['image1']['name'];
    if ($image1_e=="")
    {
        $image1=$row['image1'];
    }
    else
    {
        unlink('image/'.$row['image1']);

        $image1 = rand(1,1000000).$_FILES['image1']['name'];
        $path1 = 'image/'.$image1;
        move_uploaded_file($_FILES['image1']['tmp_name'],$path1);
    }

    // Begin transaction to ensure all updates succeed or none do
    mysqli_begin_transaction($conn);

    try {
        // Update main product table
        $sql_update = "UPDATE `product` SET 
            `name` = ?,
            `price` = ?,
            `category` = ?,
            `tag` = ?,
            `type` = ?,
            `one_line_title` = ?,
            `weight` = ?,
            `material` = ?,
            `image1` = ?,
            `stock` = ?,
            `description` = ?
            WHERE `id` = ?";
            
        $stmt = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt, "sssssssssssi", 
            $name, $price, $category, $tag, $type, 
            $one_line_title, $weight, $material, 
            $image1, $stock, $_POST['description'], $edit_id
        );
        mysqli_stmt_execute($stmt);

        // Update cart table
        $sql_update_cart = "UPDATE `cart` SET 
            `name` = ?,
            `price` = ?,
            `image` = ? 
            WHERE `product_id` = ?";
            
        $stmt_cart = mysqli_prepare($conn, $sql_update_cart);
        mysqli_stmt_bind_param($stmt_cart, "sssi", 
            $name, $price, $image1, $edit_id
        );
        mysqli_stmt_execute($stmt_cart);

        // Update orders table if needed
        $sql_update_orders = "UPDATE `order` SET 
            `product_name` = ?,
            `price` = ?,
            `image` = ? 
            WHERE `product_id` = ? AND `status` = 'Pending'";
            
        $stmt_orders = mysqli_prepare($conn, $sql_update_orders);
        mysqli_stmt_bind_param($stmt_orders, "sssi", 
            $name, $price, $image1, $edit_id
        );
        mysqli_stmt_execute($stmt_orders);

        // Commit transaction if all updates succeed
        mysqli_commit($conn);

        $_SESSION['success'] = "Product updated successfully";
        header('location:view-more-product.php?v_id='.$edit_id);
        exit;

    } catch (Exception $e) {
        // Rollback transaction if any update fails
        mysqli_rollback($conn);
        $_SESSION['error'] = "Error updating product: " . $e->getMessage();
        header('location:edit-product.php?e_id='.$edit_id);
        exit;
    }
} 

// Add after session_start()
if(isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
    unset($_SESSION['success']);
}
if(isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
    unset($_SESSION['error']);
}

?>

  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">General Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit This Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Stock</label>
                    <select class="form-control" name="stock" required>
                      <option selected disabled>-Select Avilability of Product-</option>
                      <option <?php if($row['stock']=="In Stock"){echo "selected";} ?>>In Stock</option>
                      <option <?php if($row['stock']=="Out of Stock"){echo "selected";} ?>>Out of Stock</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Name/Title of Product</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Title of New Photo" name="name" maxlength="40" required value="<?php echo @$row['name']; ?>">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Price</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" maxlength="50" placeholder="Enter Some Details of New Photo" name="price" maxlength="50" required value="<?php echo @$row['price']; ?>">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Category of Product</label>
                    <select class="form-control" name="category" required>
  <option selected disabled>-Select Category of Product-</option>
  <option <?php if($row['category']=="Industrial Chemicals"){echo "selected";} ?>>Industrial Chemicals</option>
  <option <?php if($row['category']=="Construction Materials"){echo "selected";} ?>>Construction Materials</option>
  <option <?php if($row['category']=="Raw Materials"){echo "selected";} ?>>Raw Materials</option>
  <option <?php if($row['category']=="Glass & Ceramics"){echo "selected";} ?>>Glass & Ceramics</option>
  <option <?php if($row['category']=="Adhesives & Binders"){echo "selected";} ?>>Adhesives & Binders</option>
</select>

                  </div>

                  <div class="form-group">
  <label for="exampleInputFile">Tag of Product (As per Usage or Classification)</label>
  <div>
    <input type="checkbox" name="tag[]" value="Best-seller" 
    <?php 
    for($i=0; $i<$tag_length; $i++)
      { 
        if($tag[$i]=="Best-seller")
          {echo "checked";}
      } 
    ?>> Best-seller <br>

    <input type="checkbox" name="tag[]" value="Industrial-grade"
    <?php 
    for($i=0; $i<$tag_length; $i++)
      { 
        if($tag[$i]=="Industrial-grade")
          {echo "checked";}
      } 
    ?>> Industrial-grade <br>

    <input type="checkbox" name="tag[]" value="High-purity"
    <?php 
    for($i=0; $i<$tag_length; $i++)
      { 
        if($tag[$i]=="High-purity")
          {echo "checked";}
      } 
    ?>> High-purity <br>

    <input type="checkbox" name="tag[]" value="Bulk-available"
    <?php 
    for($i=0; $i<$tag_length; $i++)
      { 
        if($tag[$i]=="Bulk-available")
          {echo "checked";}
      } 
    ?>> Bulk-available <br>

    <input type="checkbox" name="tag[]" value="Export-quality"
    <?php 
    for($i=0; $i<$tag_length; $i++)
      { 
        if($tag[$i]=="Export-quality")
          {echo "checked";}
      } 
    ?>> Export-quality <br>
  </div>
</div>


<div class="form-group">
  <label for="exampleInputPassword1">Type of Product</label>
  <select class="form-control" name="type" required>
    <option selected disabled>-Select Type of Product-</option>
    <option <?php if($row['type']=="Chemical"){echo "selected";} ?>>Chemical</option>
    <option <?php if($row['type']=="Powder"){echo "selected";} ?>>Powder</option>
    <option <?php if($row['type']=="Liquid"){echo "selected";} ?>>Liquid</option>
    <option <?php if($row['type']=="Binder"){echo "selected";} ?>>Binder</option>
    <option <?php if($row['type']=="Raw Material"){echo "selected";} ?>>Raw Material</option>
  </select>
</div>

                  

                  

                  <div class="form-group">
                    <label for="exampleInputPassword1">One Line Title of Product</label>
                    <textarea type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter One Line Title of Product" name="one_line_title" maxlength="100" required><?php echo $row['one_line_title']; ?></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Description of Product</label>
                    <textarea rows="10" type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter Description of Product" name="description" maxlength="500" required><?php echo $row['description']; ?></textarea>
                  </div>

                   <div class="form-group">
                    <label for="exampleInputPassword1">Weight of Product (in KG)</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter Weight of Product" name="weight" maxlength="10" required value="<?php echo $row['weight']; ?>">
                  </div>

                 

                  <div class="form-group">
                    <label for="exampleInputPassword1">Type of Material used in Product</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Enter type of materail used in product" name="material" maxlength="50" required value="<?php echo $row['material']; ?>">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputFile">Image 1 (Main Image)</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="image1">
                        <label class="custom-file-label" for="exampleInputFile">Choose image</label></div>
                    </div> 
                  </div>
                   <label for="exampleInputFile">Current Image-1 (Main Image) of Product</label>
                        <div style="width: 200px; height: 200px;">
                            <img src="image/<?php echo $row['image1']; ?>" style="height: 100%; width: 100%; object-fit: cover; object-position: top;">
                        </div>
                  <br>  

                  
                <!-- /.card-body -->
           
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="edited_product">Submit</button>
                </div>

              </div>
              </form>
            </div>
            <!-- /.card -->
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
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