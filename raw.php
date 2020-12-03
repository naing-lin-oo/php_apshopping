<?php require('header.php'); ?>

    <!--================Single Product Area =================-->
	<div class="product_image_area">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<div class="s_Product_carousel">
						<div class="single-prd-item">
							<img class="img-fluid" src="img/category/s-p1.jpg" alt="">
						</div>
						<div class="single-prd-item">
							<img class="img-fluid" src="img/category/s-p1.jpg" alt="">
						</div>
						<div class="single-prd-item">
							<img class="img-fluid" src="img/category/s-p1.jpg" alt="">
						</div>
					</div>
				</div>
				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3>Faded SkyBlu Denim Jeans</h3>
						<h2>$149.99</h2>
						<ul class="list">
							<li><a class="active" href="#"><span>Category</span> : Household</a></li>
							<li><a href="#"><span>Availibility</span> : In Stock</a></li>
						</ul>
						<p>Mill Oil is an innovative oil filled radiator with the most modern technology. If you are looking for
							something that can make your interior look awesome, and at the same time give you the pleasant warm feeling
							during the winter.</p>
						<div class="product_count">
							<label for="qty">Quantity:</label>
							<input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
							<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
							 class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
							<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
							 class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
						</div>
						<div class="card_area d-flex align-items-center">
							<a class="primary-btn" href="#">Add to Cart</a>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
    <br>
	<!--================End Single Product Area =================-->

	<!--================Product Description Area =================-->

<?php require('footer.php'); ?> 
<!-- Login -->

<?php

session_start();
require '../config/config.php';
require '../config/common.php';

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $pdostmt = $pdo -> prepare("SELECT * FROM users WHERE email = :email");
    $pdostmt -> bindValue(':email',$email);
    $pdostmt -> execute();
    $user = $pdostmt -> fetch(PDO::FETCH_ASSOC);
    if ($user) {
      if (password_verify($password, $user['password'])) {
        $_SESSION['user_id']=$user['id'];
        $_SESSION['username']=$user['name'];
        $_SESSION['logged_in']=time();
        $_SESSION['role']=1;

        header('Location: index.php');
      }
    }
      echo "<script>alert('Incorrect email or password')</script>";
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Shopping App | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>NLO Shopping </b>Admin Panel </a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="login.php" method="post">
      <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- /.social-auth-links -->

      <!-- <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>


<!-- index.php -->

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

  if (!empty($_POST['search'])) {
    setcookie('search',$_POST['search'], time() + (86400 * 30), "/");
  }else{
    if (empty($_GET['pageno'])) {
      unset($_COOKIE['search']); 
      setcookie('search', null, -1, '/'); 
    }
  }  

?> 

<?php
  include('header.php');
?>

<?php echo $_SESSION['role']; ?>
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
                $numOfrecs = 2;
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
                <nav aria-label="Page navigation example" style="float:right !important">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno<=1){ echo'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno<=1){echo '#';}else{ echo "?pageno=".($pageno-1);} ?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno>=$total_pages){ echo'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno>=$total_pages){echo '#';}else{ echo "?pageno=".($pageno+1);} ?>">Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                  </ul>
                </nav>
                
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
