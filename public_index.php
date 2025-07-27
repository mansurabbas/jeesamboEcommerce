<?php
// require top
require('top.php');

$obj->isAdmin();

?>
<?php

$ref='';
$os='';
?>
<?php
// Script Log Errors

?>
<?php 

$vendor_sql="SELECT id FROM admin WHERE role=1 ORDER BY id";
$vendor_run=mysqli_query($conn,$vendor_sql);
  $vendor_row = mysqli_num_rows($vendor_run);

$product_sql="SELECT id FROM products ORDER BY id";
$product_run=mysqli_query($conn,$product_sql);
  $product_row = mysqli_num_rows($product_run);

$order_sql="SELECT id FROM `order` ORDER BY id";
$order_run=mysqli_query($conn,$order_sql);
  $order_row = mysqli_num_rows($order_run);

$customer_sql="SELECT id FROM customer ORDER BY id";
$customer_run=mysqli_query($conn,$customer_sql);
  $customer_row = mysqli_num_rows($customer_run);

$subscribers_sql="SELECT id FROM subscribers ORDER BY id";
$subscribers_run=mysqli_query($conn,$subscribers_sql);
  $subscribers_row = mysqli_num_rows($subscribers_run);

?>

    <div class="content">
            
    <div class="card">
        <h4 style="color: #b5491b">Dashboard</h4>
        <h4></h4>
    </div>
  
    <div class="container">
                <div class="item-1">
                        <div class="top one" style="border-right: 7px solid lightblue;">
                            <div class="left">
                            <p><i class="fa fas fa-shopping-cart" style="color: #b5491b"></i></p>
                            </div>
                                <div class="right">
                                  <p style="color: #b5491b"><b><?php echo $product_row; ?></b></p>
                                  <p>Total Products!</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">
                            
                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <a><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            </div>
                            
                        </div>
                        <!-- <div class="top two">
                            <div class="left">
                              <p><i class="fa fa-truck" aria-hidden="true"></i></p>
                            </div>
                                <div class="right">
                                  <p><b>200</b></p>
                                  <p>Orders Pending!</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">

                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <p><i class="fa fa-caret-down" aria-hidden="true"></i></p>
                            </div>

                        </div>
                        <div class="top three">
                            <div class="left">
                              <p>icon</p>
                            </div>
                                <div class="right">
                                  <p><b>200</b></p>
                                  <p>Orders Processing!</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">

                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <p><i class="fa fa-caret-down" aria-hidden="true"></i></p>
                            </div>
                        </div>
                        <div class="top four">
                            <div class="left">
                              <p>icon</p>
                            </div>
                                <div class="right">
                                  <p><b>200</b></p>
                                  <p>Orders Completed!</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">

                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <p><i class="fa fa-caret-down" aria-hidden="true"></i></p>
                            </div>

                        </div>
                        <div class="top five">
                            <div class="left">
                              <p>icon</p>
                            </div>
                                <div class="right">
                                  <p><b>200</b></p>
                                  <p>Pending Withdraws!</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">

                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <p><i class="fa fa-caret-down" aria-hidden="true"></i></p>
                            </div>

                        </div> -->
                        <div class="top six" style="border-right: 7px solid #fb9678;">
                            <div class="left">
                            <p><i class="fa fas fa-user-plus" aria-hidden="true"></i></p>
                            </div>
                                <div class="right">
                                  <p><b><?php echo $customer_row; ?></b></p>
                                  <p>Total Customers!</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">

                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <a><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            </div>

                        </div>
                        <div class="top seven" style="border-right: 7px solid yellowpink;">
                            <div class="left">
                              <p><i class="fa fas fa-user-times" aria-hidden="true"></i></p>
                            </div>
                                <div class="right">
                                  <p><b><?php echo $vendor_row; ?></b></p>
                                  <p>Total Vendors!</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">

                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <a><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            </div>

                        </div>
                        <!-- <div class="top eight">
                            <div class="left">
                              <p>icon</p>
                            </div>
                                <div class="right">
                                  <p><b>200</b></p>
                                  <p>Vendors Pending!</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">

                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <p><i class="fa fa-caret-down" aria-hidden="true"></i></p>
                            </div>

                        </div> -->
                        <div class="top nine" style="border-right: 7px solid pink;">
                            <div class="left">
                              <p><i class="fa fas fa-truck" aria-hidden="true"></i></p>
                            </div>
                                <div class="right">
                                  <p><b><?php echo $order_row; ?></b></p>
                                  <p>Total Orders!</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">

                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <a><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            </div>

                        </div>
                        <div class="top eight" style="border-right: 7px solid lightgreen;">
                            <div class="left">
                              <p><i class="fa fas fa-at" aria-hidden="true"></i></p>
                            </div>
                                <div class="right">
                                  <p><b><?php echo $subscribers_row; ?></b></p>
                                  <p>Total Subscribers!</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">

                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <a><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            </div>

                        </div>
                        <div class="top five" style="border-right: 7px solid blue;">
                            <div class="left">
                              <p><i class="fa fas fa-users" aria-hidden="true"></i></p>
                            </div>
                                <div class="right">
                                  <p><b>
                                  <?php 
                                    $start=date('Y-m-d'). ' 00-00-00';
                                    $end=date('Y-m-d'). ' 23-59-59';
                                    echo getSale($start,$end); 
                                  ?>
                                  </b></p>
                                  <p>Total Sale!</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">

                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <a><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            </div>

                        </div>
                        <div class="top five" style="border-right: 7px solid blue;">
                            <div class="left">
                              <p><i class="fa fas fa-users" aria-hidden="true"></i></p>
                            </div>
                                <div class="right">
                                  <p><b>
                                  <?php 
                                    $start=strtotime(date('Y-m-d'));
                                    $start=strtotime("-7 day",$start);
                                    $start=date('Y-m-d', $start);
                                    $end=date('Y-m-d'). ' 23-59-59';
                                    echo getSale($start,$end); 
                                  ?>
                                  </b></p>
                                  <p>7 Days Sale</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">

                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <a><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            </div>

                        </div>
                        <div class="top five" style="border-right: 7px solid blue;">
                            <div class="left">
                              <p><i class="fa fas fa-users" aria-hidden="true"></i></p>
                            </div>
                                <div class="right">
                                  <p><b>
                                  <?php 
                                    $start=strtotime(date('Y-m-d'));
                                    $start=strtotime("-30 day",$start);
                                    $start=date('Y-m-d', $start);
                                    $end=date('Y-m-d'). ' 23-59-59';
                                    echo getSale($start,$end); 
                                  ?>
                                  </b></p>
                                  <p>Last 30 Days</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">

                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <a><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            </div>

                        </div>
                        <div class="top five" style="border-right: 7px solid blue;">
                            <div class="left">
                              <p><i class="fa fas fa-users" aria-hidden="true"></i></p>
                            </div>
                                <div class="right">
                                  <p><b>
                                  <?php 
                                    $start=strtotime(date('Y-m-d'));
                                    $start=strtotime("-365 day",$start);
                                    $start=date('Y-m-d', $start);
                                    $end=date('Y-m-d'). ' 23-59-59';
                                    echo getSale($start,$end); 
                                  ?>
                                  </b></p>
                                  <p>Last 365 Days</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">

                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <a><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            </div>

                        </div>
                        <div class="top five" style="border-right: 7px solid blue;">
                            <div class="left">
                              <p><i class="fa fas fa-users" aria-hidden="true"></i></p>
                            </div>
                                <div class="right">
                                  <p><b>
                                  <?php 
                                    $run_sql=mysqli_query($conn,"SELECT count(`order`.id) AS tt,users.firstname FROM `order`,users WHERE `order`.user_id=users.id GROUP BY `order`.user_id ORDER BY count(`order`.id) DESC LIMIT 1");
                                    
                                    if(mysqli_num_rows($run_sql) > 0){
                                       $row = mysqli_fetch_assoc();
                                        echo $row['firstname'];
                                        echo "<br />";
                                    }
                                    
                                    
                                  ?>
                                  </b></p>
                                  <p style="fonf-size:12px">
                                    <?php 
                                    if(isset($row['tt']) && $row['tt']!= ''){
                                         echo '<span style="fonf-size:12px; font-style:italic">('.$row['tt'].') times<span>';
                                         echo "<br />";
                                    }
                                     
                                    ?>
                                  </p>
                                  <p>Most Active User</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">

                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <a><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            </div>

                        </div>
                        <div class="top five" style="border-right: 7px solid blue;">
                            <div class="left">
                              <p><i class="fa fas fa-users" aria-hidden="true"></i></p>
                            </div>
                                <div class="right">
                                  <p><b>
                                  <?php 
                                    $run_sql_order = mysqli_query($conn,"SELECT count(order_details.order_id) as tt,order_details.order_id,order_details.product_name FROM order_details,`order` WHERE `order`.id=order_details.order_id GROUP BY order_details.order_id ORDER BY count(order_details.order_id) DESC LIMIT 1");
                                    if(mysqli_num_rows($run_sql_order) > 0){
                                        mysqli_fetch_assoc($run_sql_order);
                                        echo $row['product_name'];
                                        echo "<br />";
                                    }
                                  ?>
                                  </b></p>
                                  <p style="fonf-size:12px">
                                    <?php 
                                    if(isset($row['tt']) && $row['tt']!= ''){
                                      echo '<span style="fonf-size:12px; font-style:italic">('.$row['tt'].') times<span>';
                                    }
                                    ?>
                                  </p>
                                  <p>Most Liked Product</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">

                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <a><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            </div>

                        </div>
                        <div class="top five" style="border-right: 7px solid blue;">
                            <div class="left">
                              <p><i class="fa fas fa-users" aria-hidden="true"></i></p>
                            </div>
                                <div class="right">
                                  <p><b>
                                  <?php 
                                    
                                    echo getCommissionAmt();
                                    echo "<br />";
                                  ?>
                                  </b></p>
                        
                                  <p>Commission</p>
                                </div>
                            <br><br><br><br><br><br>
                            <div class="border">

                            </div>
                            <div class="view-more">
                              <p>view more</p>
                              <a><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                            </div>

                        </div>
                </div>
                <br>
                
                <div class="item-2">
                        <!-- <div class="middle referrals">
                          <p id="heading">Top Referals</p>
                          <hr><br><br>
                          <hr><br><br>
                          <hr><br><br>
                          <hr><br><br>
                          <hr><br><br>
                          <hr><br><br>
                          <hr>
                        </div> -->
                        <div class="middle os">
                        <h2 id="heading">Top Referrals</2h>
                          <hr><br><br>
                          <span><?php //echo $ref; ?></span>
                          <hr><br><br>
                          <hr><br><br>
                          <hr><br><br>
                          <hr><br><br>
                          <hr><br><br>
                          <hr>
                        </div>
                        <div class="middle os">
                        <h2 id="heading">Most Used OS</h2>
                          <hr><br><br>
                            <span><?php echo $os; ?></span>
                          <hr><br><br>
                          <hr><br><br>
                          <hr><br><br>
                          <hr><br><br>
                          <hr><br><br>
                          <hr>
                        </div>

                </div>
                <br>
                <div class="item-3">
                        <div class="middle referrals">
                            <h2>Last 5 Orders</h2>
                            <table id="myTable" class="display responsive wrap" style="width:100%">
                                <thead>
                                  <tr>
                                      <th width="5%">ID</th>
                                      <th width="5%">User ID</th>
                                      <th width="20%">Address</th>
                                      <th width="30%">Email</th>
                                      <th width="10%">Reference</th>
                                      <th width="10%">Order status</th>
                                      <th width="10%">Price</th>
                                      <th width="10%">Order Date</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php 	
                                      $sql = "select `order`.*,order_status.name as order_status_str from `order`,order_status where order_status.id=`order`.order_status order by `order`.id desc LIMIT 5";
                                      $query = mysqli_query($conn, $sql);

                                      while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
                                      $id = $row["id"];
                                      $user_id = $row["user_id"];
                                      $address = $row["address"];
                                      $email = $row["email"];
                                      $reference = $row["reference"];
                                      $order_status_str = $row["order_status_str"];
                                      $total_price = $row["total_price"];
                                      $added_on=date('Y-m-d h:i:s');
                                      
                                ?>
                                  <tr>
                                      <td><a href="order_master_details.php?id=<?php echo $id ?>"> <?php echo $id ?></a></td>
                                      <td><?php echo $user_id ?></td>
                                      <td><?php echo $address ?></td>
                                      <td><?php echo $email ?></td>
                                      <td><?php echo $reference ?></td>
                                      <td><?php echo $order_status_str ?></td>
                                      <td><?php echo $total_price ?></td>
                                      <td><?php echo $added_on ?></td>
                                      
                                  </tr>
                                <?php 
                                  }  ?>
                              </tbody>
                            </table>
                        </div>
                        
                        <div class="middle os">
                            <h2>Vendor Status</h2>
                            <table id="myTable" class="display responsive wrap" style="width:100%">
                                    <thead>
                                       <tr>
                                          <th width="10%">No.</th>
                                          <th width="60%" style='text-align:left'>Vendor</th>
                                          <th width="30%" style='text-align:left'>Status</th>
                                       </tr>
                                    </thead>
                                     <tbody id="user_grid">
                        			  
                                    </tbody>
                            </table>
                        </div>

                </div>
                
    </div>

</div>


    <script type="text/javascript">
    $(document).ready(function(){
      $('.nav_btn').click(function(){
        $('.mobile_nav_items').toggleClass('active');
      });
    });
    </script>
    
   <!--Live Online Users Start-->
            <script>
                $(document).ready(function(){
                    
                    <?php
                    if($_SESSION["ADMIN_ROLE"] == 1) { ?>
                    
                    		function updateUserStatus(){
                    		    var action = 'update_time';
                    			jQuery.ajax({
                    				url:'action.php',
                    				method:"POST",
                                    data:{action:action},
                    				success:function(data){
                    					
                    				}
                    			});
                    		}
                    		
                    		setInterval(function(){
                    			updateUserStatus();
                    		},3000);
            		
            		<?php } else { ?> 
            		
                    		getUserStatus();
                    		
                    		setInterval(function(){
                			getUserStatus();
                		    },3000);
                    		
                    		function getUserStatus(){
                    		    var action = "fetch_data";
                    			jQuery.ajax({
                    				url:'action.php',
                    				method:"POST",
                                    data:{action:action},
                    				success:function(data){
                    					jQuery('#user_grid').html(data);
                    				}
                    			});
                    		}
            		
            		<?php } ?>
                });
    	  </script>
    <!--Live Online Users End-->

<script src="../js/custom.js"></script>
  </body>
</html>