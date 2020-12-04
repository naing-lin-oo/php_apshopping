<?php
    session_start();
    
    require 'header.php';

    if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
        header('Location: login.php');
    }
?>
    <!-- Start Header Area -->
	
	<!-- End Header Area -->

    <!-- Start Banner Area -->
    <!-- End Banner Area -->

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
            <table class="table">
                <div class="table-responsive">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>                                
                            </tr>
                        </thead>
                        <tbody>
<?php if(!empty($_SESSION['cart'])) { ?>
                    
<?php 
    require 'config/config.php';
    $total = 0;
    $subtotal = 0;
    foreach($_SESSION['cart'] as $key => $qty) :
        $id = str_replace('id','',$key);
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $total = $result['price'] * $qty;
        $subtotal += $total;
?>
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img style="height: 100px; width:100px" src="admin/images/<?php echo $result['image']; ?>" alt="Product_Photos">
                                        </div>
                                        <div class="media-body">
                                            <p><?php echo $result['name']; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo $result['price']; ?>Kyats</h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input type="text" value="<?php echo $qty; ?>" title="Quantity:"
                                            class="input-text qty" readonly>
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo $result['price'] * $qty; ?>Kyats</h5>
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="cart_item_clear.php?pid=<?php echo $result['id'] ?>">Clear</a>
                                </td>
                            </tr>
<?php endforeach ?>
                            
                            <tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <h5>Subtotal</h5>
                                </td>
                                <td>
                                    <h5><?php echo $subtotal; ?>Kyats</h5>
                                </td>
                            </tr>
                            <tr class="out_button_area">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                 <td>

                                </td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">
                                        <a class="gray_btn" href="clearall.php">Clear All</a>
                                        <a class="primary-btn" href="index.php">Continue Shopping</a>
                                        <a class="gray_btn" href="sale_order.php">Order Submit</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
<?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->

    <!-- start footer Area -->
<?php require('footer.php'); ?>