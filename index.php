<?php

if(session_status() == PHP_SESSION_NONE) { // Testing session_start() is already exist or not;
    session_start();
}

require('config/config.php');
require('config/common.php');

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
}

if(!empty($_POST['search'])) {
    setcookie('search', $_POST['search'], time() + (86400 * 30), "/");
  } else {
    if(empty($_GET['pageno'])) {
      unset($_COOKIE['search']);
      setcookie('search', null, -1, '/');
    }
  }

  if (!empty($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
  }else {
    $pageno = 1;
  }
  $numOfrecs = 6;
  $offset = ($pageno - 1) * $numOfrecs;

  if (empty($_POST['search']) && empty($_COOKIE['search'])) {
    if (!empty($_GET['category_id'])) {
        $categoryId = $_GET['category_id'];
        $pdostmt = $pdo -> prepare("SELECT * FROM products WHERE category_id=$categoryId AND quantity > 0 ORDER BY id DESC");
        $pdostmt-> execute();
        $rawResult = $pdostmt->fetchAll();
    
        $total_pages = ceil(count($rawResult)/$numOfrecs);
    
        $pdostmt = $pdo -> prepare("SELECT * FROM products WHERE category_id=$categoryId AND quantity > 0 ORDER BY id DESC LIMIT $offset,$numOfrecs");
        $pdostmt-> execute();
        $result = $pdostmt->fetchAll();
    } else {
    $pdostmt = $pdo -> prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC");
    $pdostmt-> execute();
    $rawResult = $pdostmt->fetchAll();

    $total_pages = ceil(count($rawResult)/$numOfrecs);

    $pdostmt = $pdo -> prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC LIMIT $offset,$numOfrecs");
    $pdostmt-> execute();
    $result = $pdostmt->fetchAll();
  }
}else {
    $searchKey = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];

    $pdostmt = $pdo -> prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity > 0 ORDER BY id DESC");
    // print_r($pdostmt);exit();
    $pdostmt-> execute();
    $rawResult = $pdostmt->fetchAll();
    $total_pages = ceil(count($rawResult)/$numOfrecs);

    $pdostmt = $pdo -> prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity > 0 ORDER BY id DESC LIMIT $offset,$numOfrecs");
    $pdostmt-> execute();
    $result = $pdostmt->fetchAll();
  }

?>


<?php require('header.php'); ?>
<div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 col-md-5">
                <div class="sidebar-categories">
                    <div class="head">Browse Categories</div>
                    <ul class="main-categories">
                        <li class="main-nav-list">
<?php
    $catStmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
    $catStmt->execute();
    $catResult = $catStmt->fetchAll();
?>
<?php foreach($catResult as $key => $value) { ?>

<a href="index.php?category_id=<?php echo $value['id'] ?>"><span class="lnr lnr-arrow-right"></span><?php echo escape($value['name']) ?></a>

<?php } ?>

                        </li>                       
                    </ul>
                </div>
            </div>
<div class="col-xl-9 col-lg-8 col-md-7">
<!-- Start Filter Bar -->
    <div class="filter-bar d-flex flex-wrap align-items-center">
        <div class="pagination">
            <a href="?pageno=1" class="active">First</a>

            <a <?php if($pageno<=1){ echo'disabled';} ?> 
            href="<?php if($pageno<=1){echo '#';}else{ echo "?pageno=".($pageno-1);} ?>" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>
            </a>

            <a href="#" class="active"><?php echo $pageno; ?></a>

            <a href="<?php if($pageno>=$total_pages){echo '#';}else{ echo "?pageno=".($pageno+1);} ?>" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>

            <a <?php if($pageno>=$total_pages){ echo'disabled';} ?> 
            href="?pageno=<?php echo $total_pages; ?>" class="active">Last
            </a>
        </div>
    </div>


<!-- End Filter Bar -->
<!-- Start Best Seller -->
<section class="lattest-product-area pb-40 category-list">
    <div class="row">
<?php
    if($result) {
        foreach($result as $key => $value) 
{ ?>
        <div class="col-lg-4 col-md-6">
            <div class="single-product">
            <a href="product_detail.php?id=<?php echo $value['id']; ?>">
                <img  class="img-fluid" src="admin/images/<?php echo $value['image']; ?>" style="height: 250px; width: 200px" alt="">
            </a>
                <div class="product-details">
                    <h6><?php echo $value['name']; ?></h6>
                    <div class="price">
                        <h6><?php echo $value['price']; ?></h6>
                    </div>
                    <div class="prd-bottom">
                    <form action="addtocart.php" method="post" class="">
                    <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                    <input type="hidden" name="id" value="<?php echo escape($value['id'])?>">
                    <input type="hidden" name="qty" value="1">
                        <div class="social-info">
                            <button style="display: contents" class="social-info" type="submit">
                                <span class="ti-bag"></span><p style="left: 20px;" class="hover-text">add to bag</p>
                            </button>
                        </div>
                        <a href="product_detail.php?id=<?php echo $value['id']; ?>" class="social-info">
                            <span class="lnr lnr-move"></span>
                            <p class="hover-text">view more</p>
                        </a>
                    </form>                        
                    </div>
                </div>
            </div>
        </div>
<?php }
    }   
?>
        <!-- single product -->
        
    </div>
</section>

<?php require('footer.php'); ?>