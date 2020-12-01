<?php

  session_start();
  require '../config/config.php';
  require '../config/common.php';

  if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
  }

  if($_SESSION['role'] != 1) {
    header('Location: login.php');
  }

  // if(!empty($_POST['search'])) {
  //   setcookie('search', $_POST['search'], time() + (86400 * 30), "/");
  // } else {
  //   if(empty($_GET['pageno'])) {
  //     unset($_COOKIE['search']);
  //     setcookie('search', null, -1, '/');
  //   }
  // }

?> 

<?php
include('header.php');
?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product Listings</h3>
                <div class="float-right d-none d-sm-inline">
                  <a href="logout.php" type="button" class="btn btn-dark">Logout</a>
                </div>
              </div>
              <?php
                if (!empty($_GET['pageno'])) {
                  $pageno = $_GET['pageno'];
                }else {
                  $pageno = 1;
                }
                $numOfrecs = 4;
                $offset = ($pageno - 1) * $numOfrecs;

                if (empty($_POST['search']) && empty($_COOKIE['search'])) {


                  $pdostmt = $pdo -> prepare("SELECT * FROM products ORDER BY id DESC");
                  $pdostmt-> execute();
                  $rawResult = $pdostmt->fetchAll();

                  $total_pages = ceil(count($rawResult)/$numOfrecs);

                  $pdostmt = $pdo -> prepare("SELECT * FROM products ORDER BY id DESC LIMIT $offset,$numOfrecs");
                  $pdostmt-> execute();
                  $result = $pdostmt->fetchAll();
                }else {
                  $searchKey = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];

                  $pdostmt = $pdo -> prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC");
                  // print_r($pdostmt);exit();
                  $pdostmt-> execute();
                  $rawResult = $pdostmt->fetchAll();
                  $total_pages = ceil(count($rawResult)/$numOfrecs);

                  $pdostmt = $pdo -> prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
                  $pdostmt-> execute();
                  $result = $pdostmt->fetchAll();
                }

              ?>

              <!-- /.card-header -->
              <div class="card-body">
                <div>
                  <a href="product_add.php" type="button" class="btn btn-outline-success">Create New Product</a>
                </div>
                <br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Category</th>
                      <th>In Stock</th>
                      <th>Price</th>
                      <th style="width: 40px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $i = 1;
                      if ($result) {
                        foreach ($result as $value) { ?>
                    <?php 
                      $catStmt = $pdo -> prepare("SELECT * FROM categories WHERE id=".$value['category_id']);
                      $catStmt-> execute();
                      $catResult = $catStmt->fetchAll(); 
                    ?>
                     
                     <tr>
                       <td><?php  echo $i; ?></td>
                       <td><?php  echo escape($value['name']) ?></td>
                       <td><?php  echo escape(substr($value['description'],0,20)) ?></td>
                       <td><?php  echo escape($catResult[0]['name']) ?></td>
                       <td><?php  echo escape($value['quantity']) ?></td>
                       <td><?php  echo escape($value['price']) ?></td>
                       <td>
                         <div class="btn-group">
                           <div class="container">
                             <a href="product_edit.php?id=<?php echo $value['id'] ?>" type="button" class="btn btn-outline-warning">Edit</a>
                           </div>
                           <div class="container">
                             <a href="product_delete.php?id=<?php echo $value['id'] ?>"
                               onclick="return confirm('Are you sure want to delete this item')"
                               type="button" class="btn btn-outline-danger">Delete</a>
                           </div>
                         </div>
                       </td>
                     </tr>
                    <?php
                      $i++;
                        }

                      }

                    ?>
                  </tbody>
                </table><br>
                
                
              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  <?php include('footer.php') ?>
