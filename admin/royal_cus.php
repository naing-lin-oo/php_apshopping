<?php
session_start();
require '../config/config.php';
require '../config/common.php';


if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: /admin/login.php');
}

?>


<?php include('header.php'); ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Royal Users</h3>
              </div>
              <?php
                $currentDate = date("Y-m-d");
                $tpsubsum = 0;
                //SELECT SUM(quantity) as qsum,product_id FROM sale_order_detail GROUP BY product_id
                $stmt = $pdo->prepare("SELECT SUM(total_price) as tpsum,user_id FROM sale_orders GROUP BY user_id");
                //$stmt = $pdo->prepare("SELECT SUM(total_price) as tpsubsum,user_id FROM sale_orders");
                $stmt->execute();
                $result = $stmt->fetchAll();               
              ?>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered" id="d-table">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>UserID</th>
                      <th>Total Amount</th>
                      <!-- <th>Order Date</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($result) {
                      $i = 1;
                      foreach ($result as $value) { ?>

                        <?php
                            $tpsubsum += $value['tpsum'];
                            $userStmt = $pdo->prepare("SELECT * FROM users WHERE id=".$value['user_id']);
                            $userStmt->execute();
                            $userResult = $userStmt->fetchAll();
                        ?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo escape($userResult[0]['name'])?></td>
                          <td><?php echo escape($value['tpsum'])?></td>
                          <!-- <td><?php //echo escape(date("Y-m-d",strtotime($value['order_date'])))?></td> -->
                        </tr>
                    <?php
                      $i++;
                      }
                    }
                    ?>
                    <tr>
                      <td colspan="2" class="text-center bold"><b>Total Sold Amount</b></td>
                      <td><?php echo escape($tpsubsum) ?></td>
                    </tr>
                  </tbody>
                </table><br>

              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

  <?php include('footer.php')?>

  <script>
  $( document ).ready(function() {
    $('#d-table').DataTable();
  });
  </script>