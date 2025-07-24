<?php
// This include session, connection and functions
require("top.php");
?>
<?php 
if(!isset($_SESSION['USER_LOGIN'])){
	?>
	<script>
	window.location.href='<?php echo SITE_PATH?>index';
	</script>
	<?php
}
$order_id=clean($conn,$_GET['id']);

$coupon_details=mysqli_fetch_assoc(mysqli_query($conn,"SELECT coupon_value FROM `order` WHERE id='$order_id'"));
$coupon_value=$coupon_details['coupon_value'];
$total_price=0;
?>
<?php 
if (isset($_GET['id'])) {
  $order_id=clean($conn,$_GET['id']);
}

$total_price='';
?>

<body id="index">
        <div class="navigation">
            <a href="#"><span>My Jisambo</span></a>
            <!-- <a href="order"><span>Order</span></a> -->
            <a href="<?php echo SITE_PATH?>wishlist"><span>Wishlist</span></a>
            <a href="<?php echo SITE_PATH?>login"><span>Account</span></a>
        </div>

    <div class="content">
        <div class="order-wrapper">
            <div class="aside">
                <a href="<?php echo SITE_PATH?>my_order">All Orders</a>
                <a href="<?php echo SITE_PATH?>order_pdf?id=<?php echo $order_id ?>">PDF</a>
                <a href="#">My Coupon</a>
                <a href="#">Shipping Address</a>
                <a href="#">Cards and Bank Account</a>
            </div>
            <div class="main">
            <h2 href="#">Order</h2>
                <div class="item main-1">
                
                <a href="#">Awaiting Payment()</a>
                <a href="#">Awaiting Shipment()</a>
                <a href="#">Awaiting Delivery()</a>
                
                </div>
                <!--<div class="item main-2"><form action="">-->
                <!--  <div class="input-wrap">-->
                <!--    <label for="">Order number: </label><br>-->
                <!--    <input type="text" name="order_number" id="order_number"><br>-->
                <!--  </div>-->
                <!--  <div class="input-wrap">-->
                <!--  <label for="">Product: </label><br>-->
                <!--    <input type="text" name="product" id="product">-->
                <!--  </div>-->
                <!--  <div class="input-wrap">-->
                <!--  <label for=""></label><br>-->
                <!--    <input type="submit" id="submit" value="search">-->
                <!--  </div>-->
                <!--</form>-->
                <!--</div>-->
                <div class="item main-3">
                <ul>
                        <li class="fisrt">Product</li>
                        <li>Product Action</li>
                        <li>Order Status</li>
                        <li>Order Action</li>
                </ul>
                </div>
                <!------------------------ cart items details -------------------------------->
    <table class="cart-table">
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        <?php
        $uid=$_SESSION['USER_ID'];
        $res=mysqli_query($conn,"SELECT distinct(order_details.id) ,order_details.*,order_details.shipping AS ShippingCost,products.product_name,products.image,product_attributes.price AS pp FROM order_details,products,product_attributes,`order` WHERE order_details.order_id='$order_id' AND `order`.user_id='$uid' AND order_details.product_id=products.id AND order_details.product_attr_id=product_attributes.id");
        $total_price=0;
        while($row=mysqli_fetch_assoc($res)){
        $total_price=$total_price+($row['qty']*$row['pp']);

        $img = $row['image'];
        $unitShippingCost = $row['ShippingCost'];

        ?>
        <tr>
          <td>
            <div class="cart-info">
              <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$img?>">
              <div>
              <p><?php echo $row['product_name']?></p>
              <small>&#8358;<?php echo number_format($row['pp'],2)?></small>
              <!-- <br> -->
              </div>
            </div>
          </td>
          <td><?php echo $row['qty']?></td>
          <td>&#8358;<?php 
          $sub_total=$row['pp']*$row['qty'];
          echo number_format($sub_total,2)?></td>
        </tr>
        <?php } ?>
    </table>
    <div class="total-price">
        <table>
            <?php 
            if($coupon_value!=''){
            ?>
            <tr>
                <td>Coupon Value</td>
                <td>&#8358;<?php echo number_format($coupon_value,2)?></td>
            </tr>
            <?php } ?>
            <?php 
            if($unitShippingCost!=''){
            ?>
            <tr>
                <td>Shipping</td>
                <td>&#8358;<?php echo number_format($unitShippingCost,2)?></td>
            </tr>
            <?php } ?>
            <tr>
                <td>Total Price</td>
                <td align="right">&#8358;<?php 
                $total_price=((int)$total_price + (int)$unitShippingCost)-(int)$coupon_value;
                echo number_format($total_price,2); ?></td>
            </tr>
        </table>
    </div>
                <br>
                <div class="item main-4">
                <h4>Buyers who bought this item also bought: </h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repudiandae amet non ipsa voluptatibus consequuntur fugiat magnam enim possimus, ratione inventore, quos magni? Iste, maxime temporibus. Reprehenderit officia velit illum. Tempora necessitatibus, saepe cumque unde odit rem voluptatibus illo fuga, veritatis iste eaque natus ipsa, vitae suscipit. Dicta molestias ipsam magni sint, nobis tempora error sapiente quidem vel blanditiis, veritatis cumque adipisci reprehenderit, autem earum rem? Reprehenderit sint impedit, fuga amet temporibus molestiae? Quidem incidunt fuga quasi error numquam voluptates fugit deleniti ad impedit ducimus! Cumque animi eligendi quis illum itaque deleniti asperiores impedit ipsam soluta architecto! Nulla saepe officiis consequuntur eaque beatae! Quis delectus voluptatem perspiciatis veritatis modi sequi velit impedit, quam quibusdam, asperiores unde quo cum maiores dolores? Reiciendis quos doloremque blanditiis numquam! Tempora mollitia ab molestias quaerat. Impedit laboriosam facere, consequuntur repellendus blanditiis nisi aliquid veritatis animi consequatur a corporis vel unde hic quisquam praesentium at et inventore? Aut hic eligendi illo! Quae, ipsam? Animi rerum maxime quia dolorum deserunt dolorem magnam delectus sit ab cumque autem quis porro neque molestiae, praesentium sunt, modi et! Adipisci nihil necessitatibus ipsum ad vel asperiores iure, ea alias ducimus maiores, nulla, accusantium at aperiam nostrum officiis harum culpa. Optio, tempore adipisci.</p>
                </div>
                <br><br>
            <!-- </div> -->
        </div>
        
    </div>
  
    <!--------------------------footer ---------------------- -->
    <?php include('footer.inc.php'); ?>
        <script src="js/custom.js"></script>
</body>
</html>





  