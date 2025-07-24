<?php
// This include session, connection and functions
require_once('top.php');
require_once('add_to_cart.inc.php');
?>
<?php
$product_name='';
$vendor_company_name='';
$mobile='';
$email='';
$price='';
$details='';
$quantity='';
$msg='';
$obj='';
$key1 = '';
$product_name = '';
$price = '';
$pricetotal = '';
$cartOutput = "";
$res[0] = '';
$cid='';
$sid='';
$subTotal = "";
$total_cart_price=0;
$latitude='';
$longitude='';
// $customerlat='';
// $customerlon='';
// $vendorlat='';
// $vendorlon='';
$loadFun="";
$costPerKilometer=0;
$unitShippingCost=$_SESSION["RATE"];
$totalShippingCost=0;
?>
<?php
    if(isset($_GET['cmd']) && $_GET['cmd'] == 'emptyCart') {
        $obj=new add_to_cart();
        $obj->emptyProduct($pid,$quantity,$key1);

    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Cart</title>
<link rel="stylesheet" href="style.css" />
<script src="https://kit.fontawesome.com/3ebb00a559.js" crossorigin="anonymous"></script>

</head>
<body id="index" <?php //echo $loadFun?>>

<div class="content">
  <div class="both">
            <div class="cart-main">
                <div class="cart-item"><h1>Shopping Cart (<?php echo $totalProduct; ?>) </h1><br><span><a id="empty" href="<?php echo SITE_PATH?>cart?cmd=emptyCart">Empty cart</a></span></div>
                <div class="cart-item"><h1>Payment Method</h1><span><div class="payment_method"><div><img src="icons/master_card.png"/></div><div><img src="icons/visa.jpg"/></div><div><img src="icons/stripe_paystack.png"/></div></span></div></div>
            <!-- cart-page start -->
                <div class="cart-item"> 
                    <table class="cart-table">
                    <?php
                    if(isset($_SESSION['cart'])){
                       
                        foreach($_SESSION['cart'] as $key=>$val){
                         
                            foreach($val as $key1=>$val1){
                        
                            $sqlAttr=mysqli_fetch_assoc(mysqli_query($conn, "SELECT product_attributes.*,color_master.color,size_master.size FROM product_attributes LEFT JOIN color_master ON product_attributes.color_id=color_master.id AND color_master.status=1 LEFT JOIN size_master ON product_attributes.size_id=size_master.id AND size_master.status=1 WHERE product_attributes.id='$key1'"));

                            $productArr=get_product($conn,'','',$key,'','','','','',$key1);
                            $product_name=$productArr[0]['product_name'];
                            $price=$productArr[0]['price'];
                            $added_by=$productArr[0]['added_by'];
                            $image=$productArr[0]['image'];
                            // $image=explode(" ",$image);
                            // $count=count($image)-1;

                            $qty=$val1['qty'];
                            
                            // Getting Position of the Vendor name and position Start
                            $vendor_detail = mysqli_query($conn, "SELECT admin.username,admin.mobile,admin.email,admin.latitude,admin.longitude FROM admin,products WHERE products.id=$key AND admin.id=products.added_by") or die(mysqli_error($conn));
                            while ($vendor_detail_row = mysqli_fetch_array($vendor_detail)) {
                                $vendor_company_name = $vendor_detail_row["username"];
                                $mobile = $vendor_detail_row["mobile"];
                                $email = $vendor_detail_row["email"];   
                                $vendorLatitude = $vendor_detail_row["latitude"];   
                                $vendorLongitude = $vendor_detail_row["longitude"];   
                            }
                            // Getting Position of the Vendor name and position End
                            
                            //$km = calculateDistance($customerlat,$customerlon,$vendorLatitude,$vendorLongitude);
                            
                            // Shipping cost of single item in the cart
                            //$ShippingCost=calculateShippingCost($km, 10);
                            
                            $_SESSION['unitShippingCost'] = $unitShippingCost;
                            $unitShippingCost = $_SESSION['unitShippingCost'];
                            
                            // shipping cost of all items in the cart
                            
                            $totalShippingCost = (int)$totalShippingCost + ((int)$unitShippingCost * (int)$val1['qty']);
                            
                            $_SESSION['totalShippingCost'] = $totalShippingCost;
                            $totalShippingCost = $_SESSION['totalShippingCost'];
                            
                            // Price of single item in the cart
                            $unitPrice=(int)$price*(int)$qty;
                            
                            // Price of all items in the cart
                            $totalPrice+=$unitPrice;
                            
                            // Final Price to pay
                            $cartTotal=$totalPrice + $totalShippingCost;
                            
                            ?>
                    <tr>
                        <td><p><?php echo $vendor_company_name ?></p><div align="left" width="100%" style="padding: 5px;"></div><div class="cart-info" style="padding: 5px;border-bottom: 1px solid #ebebeb;"><img src="inventory_images/<?php echo $image?>" alt="<?php echo $product_name ?>" /><div><p><?php echo $product_name ?></p><p id="price">&nbsp;<small>NGN &#8358;<?php echo number_format($price,2) ?></small></p>
                        
                        <?php
                        if(isset($sqlAttr['color']) && $sqlAttr['color'] !=''){
                            echo "<span>".$sqlAttr['color']."</span><br />";
                        } 
                        if(isset($sqlAttr['size']) && $sqlAttr['size'] !=''){
                            echo "<span>".$sqlAttr['size']."</span>";
                        } 
                        if(isset($unitShippingCost) && $unitShippingCost !=''){
                            echo "<span>Shipping: &#8358;".number_format($unitShippingCost)."</span>";
                        } 
                        
                        ?>
                        </div></div></td>
                        <td width="3%"><span><a href="javascript:void(0)" onclick="wishlist_manage('<?php echo $key?>','add','<?php echo $sqlAttr['size_id'] ?>','<?php echo $sqlAttr['color_id'] ?>','<?php echo $price ?>')"><i class="fas fa-heart"></i></a></span></td>
                        <td width="3%"><span><a href="javascript:void(0)" onclick="manage_cart_update('<?php echo $key?>','remove','<?php echo $sqlAttr['size_id'] ?>','<?php echo $sqlAttr['color_id'] ?>')"><i class="far fa-trash-alt"></i></a></span></td>
                    </tr>
                    <?php } } } ?>
                
                    </table>

                <span align="right"><?php echo $msg; ?></span>
                        <?php if(isset($_SESSION['cart']) && $cartTotal > 0) { ?>
                            <div class="total-price">
                                <table>
                                    <tr>
                                        <td><h1>Total</h1></td>
                                        <td><h1 class="price">&nbsp; &#8358;<?php 
                                        if(isset($cartTotal)){
                                        echo number_format((float)$cartTotal,2); 
                                        }
                                        ?></h1></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                </table>
                                
                            </div>
                        <?php }else{
                                echo "<h1 align='center' style='padding: 60px 0px'>Your shopping cart is empty</h1>";
                              }
                        ?>

                </div> 
            </div>
                <!-- cart-page end -->
            <!-- cart-summary start -->
            <div class="cart-summary">
                    <div class="order-details">
                        <h1 class="order-details__title">Order Summary</h1>
                        <div class="order-details__item">
                            
                            <div class="single-item">
                                <div class="single-item__content">
                                    <span>Subtotal</span>
                                </div>
                                <div class="single-item__remove">
                                    <span>NGN &#8358;<?php if(isset($totalPrice)){
                                    echo number_format($totalPrice,2);
                                    }
                                    ?></span>
                                    
                                </div>
                            </div>
                            <div class="single-item">
                                <div class="single-item__content">
                                    <span>Shipping</span>
                                </div>
                                <div class="single-item__remove">
                                    <span>NGN &#8358;<?php echo number_format($totalShippingCost,2); ?></span>
                                </div>
                            </div>

                        </div>
                        <div class="ordre-details__total">
                            <h1>Total</h1>
                            <h1 class="price" id="order_total_price"><span class="summary-ngn">NGN</span> &#8358;<?php 
                            if(isset($cartTotal) && !empty($cartTotal)){
                            echo number_format($cartTotal,2);
                            }
                            ?></h1>
                        </div>
                        
                            <h1><a class="buy" href="<?php echo SITE_PATH?>checkout">BUY (<?php echo $totalProduct; ?>)</a></h1>
                        
                    </div>
            </div>
            <!-- cart-summary end -->
  </div>
</div>

<input type="hidden" id="sid">
<input type="hidden" id="cid">

<script src="js/custom.js"></script>
<?php require_once('footer.inc.php');?>

<script>
        var loader = document.getElementById("preloader");
        window.addEventListener("load", function(){
            loader.style.display = "none";
        })
</script>
</body>
</html>
