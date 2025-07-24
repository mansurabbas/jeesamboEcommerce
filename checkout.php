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
$qty='';
$details='';
$quantity='';
$msg='';
$obj='';
$cartOutput = '';
$item_id = '';
$product_name = '';
$price = '';
$cartTotal = "";
$res[0] = '';
$cid='';
$sid='';

$info = '';
$code='';
$product_name='';
$coupon_str='';
$dd='';
$vendor_company_name='';
$added_by='';
$email='';
$pricetotal = '';
$cartOutput = "";
$cartTotal = "";
$final_price = "";
$price='';
$details='';
$quantity='';
$msg='';
$obj='';
$item_id = '';
$name='';
$phone_number='';
$street='';
$suit='';
$country='';
$state='';
$city='';
$zipcode='';
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
if (isset($_SESSION["RATE"])) {
    $unitShippingCost=$_SESSION["RATE"];
}
$totalShippingCost=0;

$id='';
$last_id='';
$db_id="";
$db_name="";
$db_phone_number="";
$db_street="";
$db_suit="";
$db_country="";
$db_state="";
$db_city="";
$db_zipcode="";
$last_insert_id="";
$cart_msg="";
?>
<?php
// Getting Position of the Customer Start 
if(isset($_SESSION['ip-api_customerlat']) && isset($_SESSION['ip-api_customerlon'])){
    $customerlat = $_SESSION['ip-api_customerlat'];
    $customerlon = $_SESSION['ip-api_customerlon'];
}
// Getting Position of the Customer End 
?>
<?php
    if(!isset($_SESSION['USER_LOGIN'])){
        $_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
        redirect('login');
        die();
    }

?>

<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 3 (if user chooses to adjust item quantity)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['item_to_adjust']) && $_POST['item_to_adjust'] != "") {
    // execute some code

   $pid = mysqli_real_escape_string($conn, $_POST['item_to_adjust']);
   $attr_id = mysqli_real_escape_string($conn, $_POST['attr_id']);
   $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
   $quantity = mysqli_real_escape_string($conn, $quantity); // filter everything but numbers
   $getProductAttr=getProductAttr($conn,$pid);
   $productSoldQtyByProductId=productSoldQtyByProductId($conn,$pid,$getProductAttr);
   $productQty=productQty($conn,$pid,$getProductAttr);
   $pending_qty=$productQty-$productSoldQtyByProductId;

   if($quantity>$pending_qty) {
       $cart_msg = "Qty not available";
   }
   
   if ($quantity >= 100) { $quantity = 99; }
   if ($quantity < 1) { $quantity = 1; }
   if ($quantity == "") { $quantity = 1; }
   $i = 0;

   if(isset($_SESSION['cart'])){
   foreach ($_SESSION["cart"] as $key => $val) {
          $i++;
          foreach ($val as $key1 => $val1) {

             // while ($key != null && $value != null ) {

                     // That item is in cart already so let's adjust its quantity using array_splice()
                     if ($cart_msg=='') {
                        $obj=new add_to_cart();
                        $obj->updateProduct($key,$attr_id,$quantity);
                     }

             // } // close while loop
        }// close foreach
   } // close foreach loop
  }

}
?>
<?php
if (!empty($_SESSION["cart"])) {

if(isset($_POST['coupon_str'])){
  $coupon_str=clean($conn,$_POST['coupon_str']);

}

$_SESSION['coupon_str']=$coupon_str;
$res=mysqli_query($conn,"SELECT * FROM coupon_master WHERE coupon_code='$coupon_str' AND STATUS='1'");
$count=mysqli_num_rows($res);
$jsonArr=array();
$cart_total=0;
if(isset($_SESSION['COUPON_ID'])){
	unset($_SESSION['COUPON_ID']);
	unset($_SESSION['COUPON_CODE']);
	unset($_SESSION['COUPON_VALUE']);
}
foreach($_SESSION["cart"] AS $key=>$val){

    foreach($val AS $key1=>$val1){

	$productArr=get_product($conn,'','',$key);
	$price=$productArr[0]['price'];
	$qty=$val1['qty'];
	$cart_total=$cart_total+((int)$price*(int)$qty);
    }
}
if($count>0){
	$coupon_details=mysqli_fetch_assoc($res);
	$coupon_value=$coupon_details['coupon_value'];
    $id=$coupon_details['id'];
	$coupon_type=$coupon_details['coupon_type'];
	$cart_min_value=$coupon_details['cart_min_value'];
	
	if($cart_min_value>$cart_total){
		$code = "Cart total value must be $cart_min_value";
	}else{
		if($coupon_type=='Naira'){
			$final_price=$cart_total-$coupon_value;
		}else{
			$final_price=$cart_total-(($cart_total*$coupon_value)/100);
      
		}
		$dd=(int)$cart_total-(int)$final_price;
		$_SESSION['COUPON_ID']=$id;
		$_SESSION['FINAL_PRICE']=$final_price;
		$_SESSION['COUPON_VALUE']=$dd;
		$_SESSION['COUPON_CODE']=$coupon_str;
    
	}
	
}else{
	$code = "Coupon code not found";
}
}
?>
<?php 
// Shipping Address
if(isset($_POST['s-cancel']) ) {
      
        $address = $_SESSION["SUITE"].', '.$_SESSION["STREET"].', '.$_SESSION["STATE"].' '.$_SESSION["COUNTRY"].'.';
    
        $info = $_SESSION["NAME"].', '.$_SESSION["PHONE_NUMBER"].', <br />'.$_SESSION["SUITE"].' '.$_SESSION["STREET"].', '.$_SESSION["STATE"].', <br />'.$_SESSION["COUNTRY"].' '.$_SESSION["ZIPCODE"].'.';
  
}

if(isset($_POST['s-submit']) && !empty($_POST['s-submit'])) {
    
  $id=$_POST["last_id"];
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
  $street = mysqli_real_escape_string($conn, $_POST['street']);
  $suit = mysqli_real_escape_string($conn, $_POST['suite']);
  $country = mysqli_real_escape_string($conn, $_POST['country']);
  $state = mysqli_real_escape_string($conn, $_POST['state']);
  $city = mysqli_real_escape_string($conn, $_POST['city']);
  $zipcode = mysqli_real_escape_string($conn, $_POST['zipcode']);

  if($id =='') {

    mysqli_query($conn, "INSERT INTO shipping_address(shipping_name,shipping_phone_number,shipping_street,shipping_suit,shipping_country,shipping_state,shipping_city,shipping_zipcode) VALUES('$name','$phone_number','$street','$suit','$country','$state','$city','$zipcode')");
    $last_id = mysqli_insert_id($conn);
      
  }else{
    
    $sql="UPDATE shipping_address SET shipping_name='$name',shipping_phone_number='$phone_number',shipping_street='$street',shipping_suit='$suit',shipping_country='$country',shipping_state='$state',shipping_city='$city',shipping_zipcode='$zipcode' WHERE shipping_id='$id'";

    mysqli_query($conn, $sql);
    
    $id_sql = "SELECT shipping_id FROM shipping_address WHERE shipping_id='$id' LIMIT 1";
    $id_sql = mysqli_query($conn, $id_sql);
        $count=mysqli_num_rows($id_sql);
        if($count > 0) {
            $row=mysqli_fetch_assoc($id_sql);
        }
        $last_id = $row['shipping_id'];
  }
  
  $_SESSION["NAME"] = $name;
  $_SESSION["STREET"] = $street;
  $_SESSION["SUITE"] = $suit;
  $_SESSION["PHONE_NUMBER"] = $phone_number;
  $_SESSION["COUNTRY"] = $country;
  $_SESSION["STATE"] = $state;
  $_SESSION["CITY"] = $city;
  $_SESSION["ZIPCODE"] = $zipcode;
  
    $address = $_SESSION["SUITE"].', '.$_SESSION["STREET"].', '.$_SESSION["STATE"].' '.$_SESSION["COUNTRY"].'.';

    $info = $_SESSION["NAME"].', '.$_SESSION["PHONE_NUMBER"].', <br />'.$_SESSION["SUITE"].' '.$_SESSION["STREET"].', '.$_SESSION["STATE"].', <br />'.$_SESSION["COUNTRY"].' '.$_SESSION["ZIPCODE"].'.';
    
    $res=mysqli_query($conn,"SELECT * FROM shipping_address WHERE shipping_id='$last_id' ");
    $count=mysqli_num_rows($res);
    if($count > 0) {
        $row=mysqli_fetch_assoc($res);
        
        $db_id=$row["shipping_id"];
        $db_name=$row["shipping_name"];
        $db_phone_number=$row["shipping_phone_number"];
        $db_street=$row["shipping_street"];
        $db_suit=$row["shipping_suit"];
        $db_country=$row["shipping_country"];
        $db_state=$row["shipping_state"];
        $db_city=$row["shipping_city"];
        $db_zipcode=$row["shipping_zipcode"];
        
    }
  
}

?>
<?php
// Wallet top up Start
if (isset($_SESSION['IS_WALLET']) && isset($_SESSION['AMT'])) {
    // $uid = $_SESSION['USER_ID'];
    $email = $_SESSION['LOGIN_EMAIL'];

    if (isset($_SESSION['REF_EXIST']) && $_SESSION['REF_EXIST'] = 'yes') {
        manageWallet($_SESSION['USER_ID'],$_SESSION['AMT'],$_SESSION['LOGIN_EMAIL'],'in','Added');
        unset($_SESSION['IS_WALLET']);
        unset($_SESSION['AMT']);
        redirect(SITE_PATH.'wallet');
        die();
    }
}
// Wallet top up end

// Payment By Wallet Start
if (isset($_SESSION['PAYMENT_BY_WALLET']) ) {
    
    // $uid = $_SESSION['USER_ID'];
    $email = $_SESSION['LOGIN_EMAIL'];
    $cartTotal = $_SESSION['cartTotal'];
    $added_on=date('Y-m-d h:i:s');

    $getWallet = getWallet($uid);
    foreach ($getWallet as $list) {
        $user_id = $list['user_id'];
        $amt = $list['amt'];
        $email = $list['email'];
        $msg = $list['msg'];
        
    }

    // Inserting Into Oder Table
    $unitShippingCost=$_SESSION['unitShippingCost'];
    $totalShippingCost = $_SESSION['totalShippingCost'];

        if (isset($_SESSION['COUPON_ID'])) {
            $coupon_id = $_SESSION['COUPON_ID'];
            $coupon_code =  $_SESSION['COUPON_CODE'];
            $coupon_value = $_SESSION['COUPON_VALUE'];
            //$cartTotal = $cartTotal - $coupon_value;
            unset($_SESSION['COUPON_ID']);
            unset($_SESSION['COUPON_CODE']);
            unset($_SESSION['COUPON_VALUE']);
        
        } else {
            $coupon_id = '';
            $coupon_code =  '';
            $coupon_value = '';
        }
        
        // Shipping Address
        if(isset($_SESSION["NAME"])) {
            $name=$_SESSION["NAME"];
            $phone_number=$_SESSION["PHONE_NUMBER"];
            $street=$_SESSION["STREET"];
            $suit=$_SESSION["SUITE"];
            $country=$_SESSION["COUNTRY"];
            $state=$_SESSION["STATE"];
            $city=$_SESSION["CITY"];
            $zipcode=$_SESSION["ZIPCODE"];
        }

    //  Inserting Data into Order
    $sql = "INSERT INTO `order` (user_id,address,email,user_name,phone,city,zipcode,payment_type,total_price,added_on,order_status,coupon_id,coupon_code,coupon_value) VALUES('$user_id','$street','$email','$name','$phone_number','$city','$zipcode','wallet','$cartTotal','$added_on','1','$coupon_id','$coupon_code','$coupon_value')";
    
    $sql_res = mysqli_query($conn, $sql);
    $order_id = mysqli_insert_id($conn);
    
    // Inserting Into Oder Details Start
    if ($sql_res) {

        if (isset($_SESSION["cart"]) || count($_SESSION["cart"]) > 0) {
        
                // Inserting data into Order Detail
                //$total_cart_price;
                foreach ($_SESSION["cart"] as $key=>$val) {
                    foreach($val AS $key1=>$val1){
                    $resAttr=mysqli_fetch_assoc(mysqli_query($conn,"SELECT price,qty,product_id FROM product_attributes WHERE id='$key1'"));
                    $qty=$val1['qty'];
                    $product_id=$resAttr['product_id'];
                    $price=$resAttr['price'];
                    $ttprice=$resAttr['price'] * $qty;

                    $res=mysqli_query($conn, "SELECT commission_rate,added_by,product_name FROM products WHERE id='$key'") or die (mysqli_error($conn));

                    $row = mysqli_fetch_assoc($res);
                    $product_name=$row['product_name'];
                    $commissionRate=$row['commission_rate'];
                    $adminId=$row['added_by'];
    
                    mysqli_query($conn, "INSERT INTO order_details (order_id,product_id,product_name,product_attr_id,qty,price,shipping) VALUES ('$order_id', '$key','$product_name', '$key1', '$qty', '$price','$totalShippingCost')") or die (mysqli_error($conn));

                    mysqli_query($conn, "INSERT INTO customer (firstname,email,price,qty) VALUES ('".$_SESSION["FIRSTNAME"]."', '".$_SESSION["LOGIN_EMAIL"]."','$price','$qty')") or die (mysqli_error($conn));    
                        
                        // Calculate the commission amount
                        $commissionAmount = calculateCommission($price, $commissionRate);

                        $vendor_money = $price - $commissionAmount;

                        $vmsg="Order id - ".$order_id;
                        $cmsg="commission from sales with order id - ".$order_id;
                        $added_on = date('Y-m-d H:i:s');

                        // Insert money into vendor
                        manageVendorWallet($adminId,$vendor_money,$vmsg,'in',$added_on);
                        // Insert money into commission
                        manageCommission($commissionAmount,$cmsg,'in',$added_on);
    
                    }
    
                } // close foreach loop
                
            sentInvoice($conn,$order_id);
        
        }
        // Inserting Into Oder Details End
        $added_on=date('Y-m-d H:i:s');
        // Debiting user`s wallet
        manageWallet($uid,$cartTotal,$email,'out','Order Id-'.$order_id,$added_on);
        // Updating Oder
        mysqli_query($conn, "UPDATE `order` SET payment_status = 'success' WHERE id = '$order_id' ");

        unset($_SESSION['PAYMENT_BY_WALLET']);
        session_unset();
        session_destroy();
        redirect(SITE_PATH.'success?msg=successfullyPaid&type=wlt');
        die();

    }
}
// Payment By Wallet End

// Payment By Paystack Start
if (isset($_SESSION['PAYMENT_BY_PAYSTACK']) ) {
    
    // $uid = $_SESSION['USER_ID'];
    $email = $_SESSION['LOGIN_EMAIL'];
    $cartTotal = $_SESSION['cartTotal'];
    $added_on=date('Y-m-d h:i:s');

    $getWallet = getWallet($uid);
    foreach ($getWallet as $list) {
        $user_id = $list['user_id'];
        $amt = $list['amt'];
        $email = $list['email'];
        $msg = $list['msg'];
        
    }
     
     $unitShippingCost=$_SESSION['unitShippingCost'];
     $totalShippingCost = $_SESSION['totalShippingCost'];

     if (isset($_SESSION['COUPON_ID'])) {
        $coupon_id = $_SESSION['COUPON_ID'];
        $coupon_code =  $_SESSION['COUPON_CODE'];
        $coupon_value = $_SESSION['COUPON_VALUE'];
        //$cartTotal = $cartTotal - $coupon_value;
        unset($_SESSION['COUPON_ID']);
        unset($_SESSION['COUPON_CODE']);
        unset($_SESSION['COUPON_VALUE']);
    
    } else {
        $coupon_id = '';
        $coupon_code =  '';
        $coupon_value = '';
    }
    
    // Shipping Address
    if(isset($_SESSION["NAME"])) {
        $name=$_SESSION["NAME"];
        $phone_number=$_SESSION["PHONE_NUMBER"];
        $street=$_SESSION["STREET"];
        $suit=$_SESSION["SUITE"];
        $country=$_SESSION["COUNTRY"];
        $state=$_SESSION["STATE"];
        $city=$_SESSION["CITY"];
        $zipcode=$_SESSION["ZIPCODE"];
    }
    
        if (isset($_SESSION['PAID_REF_ID'])) {
            $reference = $_SESSION['PAID_REF_ID'];
        }else{
            $reference = 0;
        }

        //  Inserting Data into Order
        $sql = "INSERT INTO `order` (user_id,address,email,user_name,phone,city,zipcode,payment_type,total_price,reference,added_on,order_status,coupon_id,coupon_code,coupon_value) VALUES('$user_id','$street','$email','$name','$phone_number','$city','$zipcode','paystack','$cartTotal','$reference','$added_on','1','$coupon_id','$coupon_code','$coupon_value')";
        
        $sql_res = mysqli_query($conn, $sql) or die("Error:". mysqli_error($conn));
        $order_id = mysqli_insert_id($conn);

    if ($sql_res) {
    
        if (isset($_SESSION["cart"]) || count($_SESSION["cart"]) > 0) {
        
                // Inserting data into Order Detail
                //$total_cart_price;
                foreach ($_SESSION["cart"] as $key=>$val) {
                    foreach($val AS $key1=>$val1){
                        $resAttr=mysqli_fetch_assoc(mysqli_query($conn,"SELECT price,qty,product_id FROM product_attributes WHERE id='$key1'"));
                        $qty=$val1['qty'];
                        $pid = $key;
                        $product_id=$resAttr['product_id'];
                        $price=$resAttr['price'];
                        $ttprice=$resAttr['price'] * $qty;

                        $res=mysqli_query($conn, "SELECT commission_rate,added_by,product_name FROM products WHERE id='$key'") or die (mysqli_error($conn));

                        $row = mysqli_fetch_assoc($res);
                        $product_name=$row['product_name'];
                        $commissionRate=$row['commission_rate'];
                        $adminId=$row['added_by'];
        
                        mysqli_query($conn, "INSERT INTO order_details (order_id,product_id,product_name,product_attr_id,qty,price,shipping) VALUES ('$order_id', '$key','$product_name', '$key1', '$qty', '$price','$totalShippingCost')") or die (mysqli_error($conn));

                        mysqli_query($conn, "INSERT INTO customer (firstname,email,price,qty,reference) VALUES ('".$_SESSION["FIRSTNAME"]."', '".$_SESSION["LOGIN_EMAIL"]."','$price','$qty','$reference')") or die (mysqli_error($conn));   
                            
                            
                            // Calculate the commission amount
                            $commissionAmount = calculateCommission($price, $commissionRate);
    
                            $vendor_money = $price - $commissionAmount;
    
                            $vmsg="Order id - ".$order_id;
                            $cmsg="commission from sales with order id - ".$order_id;
                            $added_on = date('Y-m-d H:i:s');
    
                            // Insert money into vendor
                            manageVendorWallet($adminId,$vendor_money,$vmsg,'in',$added_on);
                            // Insert money into commission
                            manageCommission($commissionAmount,$cmsg,'in',$added_on);

                            if (isset($_SESSION['PAID']) && $_SESSION['PAID'] =='yes') {
                                mysqli_query($conn, "UPDATE `order` SET payment_status = 'success' WHERE id = '$order_id' ");
                            }
        
                    }    
                } // close foreach loop
                
            sentInvoice($conn,$order_id);
        
        }
    
    //echo "<script>alert('your payment went through')</script>";
    ?>
    <?php
    
    }else{
        echo "There was an error";
        die();
    }
    
    unset($_SESSION['PAYMENT_BY_PAYSTACK']);
    unset($_SESSION['PAID']);
    // Prevent resubmission
    session_unset();
    session_destroy();
    redirect(SITE_PATH.'success?msg=successfullyPaid&type=pystk');
    die();

}
// Payment By Paystack End

?>

<body id="index" <?php //echo $loadFun?>>

<div class="content">
  <div class="both">
            <div class="cart-main">
            <div class="cart-item"><h1>Address Information</h1>
        
            <br> 
            <span id="address_bowl">
               <?php 
                    
                    if(!isset($_POST["s-submit"]) || empty($_POST["s-submit"])){ ?>
                        <script>
                            let address_bowl = document.getElementById("address_bowl").innerHTML = "";
                        </script>
                    <?php
                    }
                    
                    if(isset($_POST["s-submit"]) && !empty($_POST["s-submit"])){ 
                        echo $info;
                        echo '<br />';
                        echo '<br />';
                        echo '<a href="#" class="show addr">edit shipping address</a>';
                    }else{
                            echo '<div class="error" id="shipping_error" style="color: red; display: none">Shipping address can not be empty</div>';
                            echo '<br />';
                            echo '<a href="#" class="show addr">Add shipping address</a>';
                    }
                ?>
                
      <!-- Popup address -->
        
       
          <div class="modl">
            <div class="modal-box">
                <span class="close-button">X</span>
                <h2>Add shipping address</h2><br />
                <form action="#" method="POST" class="form" autocomplete="off">
                        <p>
                        <label>Name</label>   
                        <input type="text" name="name" id="c-input" placeholder="Name" value="<?php echo $db_name ?>" autocomplete="off" required>
                        </p>
                        <p>
                        <label>Number</label>
                        <input type="text" name="phone_number" id="c-input" placeholder="Phone number" value="<?php echo $db_phone_number ?>" autocomplete="off" required>
                        </p>
  
                        <p>
                        <label>Apartment</label>
                        <input type="text" name="street" id="c-input" placeholder="Street,House/Apartment" value="<?php echo $db_street ?>" autocomplete="off" required>
                        </p>
                        <p>
                        <label>Suit</label>
                        <input type="text" name="suite" id="c-input" placeholder="Suite" value="<?php echo $db_suit ?>" autocomplete="off" required>
                        </p>
                        <p>
                        <label>Country</label>
                        <input type="text" name="country" id="c-input" placeholder="Country" value="<?php echo $db_country ?>" autocomplete="off" required>
                        </p>
                        <p>
                        <label>State</label>
                        <input type="text" name="state" id="c-input" placeholder="State" value="<?php echo $db_state ?>" autocomplete="off" required>
                        </p>
                        <p>
                        <label>City</label>
                        <input type="text" name="city" id="c-input" placeholder="City" value="<?php echo $db_city ?>" autocomplete="off" required>
                        </p>
                        <p>
                        <label>Zipcode</label>
                        <input type="text" name="zipcode" id="c-input" placeholder="Zipcode" value="<?php echo $db_zipcode ?>" autocomplete="off" required>
                        <input type="hidden" name="last_id" id="c-input" value="<?php echo $last_id ?>" autocomplete="off">

                        </p>

                        <p>
                        <label></label>
                        <input type="submit" name="s-submit" id="s-submit" value="Save and Continue">
                        </p>
                        <!--<p>-->
                        <!--<label></label>-->
                        <!--<button id="c-cancel">X</button>-->
                        <!--</p>-->
                </form>
                
            </div>
          </div>
          <!-- // Popup address -->
          </span>
          </div>
                <div class="cart-item"><h1>Payment Method</h1><span><div class="payment_method"><div><img src="icons/master_card.png"/></div><div><img src="icons/visa.jpg"/></div><div><img src="icons/stripe_paystack.png"/></div></span></div></div>
            <!-- cart-page start -->
                <div class="cart-item"> 
                    <table class="cart-table">
                    <?php
                    if(isset($_SESSION['cart'])){
                        
                        foreach($_SESSION['cart'] as $key=>$val){
                          
                            foreach($val AS $key1=>$val1){
                        
                        $sqlAttr=mysqli_fetch_assoc(mysqli_query($conn, "SELECT product_attributes.*,color_master.color,size_master.size FROM product_attributes LEFT JOIN color_master ON product_attributes.color_id=color_master.id AND color_master.status=1 LEFT JOIN size_master ON product_attributes.size_id=size_master.id AND size_master.status=1 WHERE product_attributes.id='$key1'"));

                        $productArr=get_product($conn,'','',$key,'','','','','',$key1);
                        $product_name=$productArr[0]['product_name'];
                        $price=$productArr[0]['price'];
                        $added_by=$productArr[0]['added_by'];
                        $image=$productArr[0]['image'];
                        // $image=explode(" ",$image);
                        // $count=count($image)-1;
                        $qty=$val1['qty'];

                        $_SESSION["PRODUCT_ID"] = $key;
                        
                        // Getting Position of the Vendor name and position Start
                            $vendor_detail = mysqli_query($conn, "SELECT admin.id,admin.username,admin.mobile,admin.email,admin.latitude,admin.longitude FROM admin,products WHERE products.id=$key AND admin.id=products.added_by") or die(mysqli_error($conn));
                            while ($vendor_detail_row = mysqli_fetch_assoc($vendor_detail)) {
                                
                                $vendor_company_name = $vendor_detail_row["username"];
                                $mobile = $vendor_detail_row["mobile"];
                                $email = $vendor_detail_row["email"];   
                                $vendorLatitude = $vendor_detail_row["latitude"];   
                                $vendorLongitude = $vendor_detail_row["longitude"];   
                            }

                            // Getting Position of the Vendor name and position End
                            
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
                            $cartTotal=($totalPrice + $totalShippingCost);
                            $getWalletAmt=getWalletAmt($_SESSION['USER_ID']);
                        
                        ?>
                    <tr>
                        <td><?php echo $vendor_company_name?><div align="left" width="100%" style="padding: 5px;"></div><div class="cart-info" style="padding: 5px;border-bottom: 1px solid #ebebeb;"><img src="inventory_images/<?php echo $image?>" alt="<?php echo $product_name ?>" /><div><p><?php echo $product_name ?></p><p id="price">&nbsp;<small>NGN &#8358;<?php echo number_format($price,2) ?></small></p>
                        
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

                        <td width="5%">
                            <span>
                                <form action="checkout" method="POST" >
                                <span align="right" style="color: red"><?php echo $cart_msg; ?></span>
                                <input name="quantity" type="text" value="<?php echo $qty ?>" size="1" maxlength="2" autocomplete="off"/><br>
                                <input name="item_to_adjust" type="hidden" value="<?php echo $key ?>" />
                                <input name="attr_id" type="hidden" value="<?php echo $key1 ?>" />
                                <input name="adjustBtn<?php echo $key ?>" type="submit" value="Change"/>
                                </form>
                            </span>
                        </td>
                                
                    </tr>
                    <?php } } } ?>
                
                    </table>

                <?php if(!empty($_SESSION["cart"])) { ?>
                            <div class="total-price">
                                <table>
                                    <tr>
                                        <td><h1>Total</h1></td>
                                        <td><h1 class="price"><div class="cart-ngn"></div> &#8358;<?php
                                        if(isset($cartTotal)){
                                        echo number_format($cartTotal,2); 
                                        }
                                        ?></h1></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                            
                                        
                                        <input type="radio" name="payment_type" value="paystack" checked="checked">
                                        <label>paystack</label>
                                        <br>
                                        <?php
                                            $is_dis='';
                                            $low_msg='';
                                            $value='';
                                            if ($getWalletAmt>=$cartTotal) { 
                                                $value='value="wallet"';
                                            } else {
                                                $is_dis="disabled='disabled'";
                                                $low_msg = "(Low wallet money)";
                                                $value='value=""';
                                            }
                                         
                                         ?>
                                         <span style="color: red; font-size:14px">
                                            <?php 
                                                //echo $low_msg;
                                            ?>
                                        </span>
                                        <input type="radio" name="payment_type" <?php echo $value ?> checked="checked" <?php echo $is_dis ?> >
                                        <label>wallet</label>
                                        <br><br><br>
                                        <script src="https://js.paystack.co/v1/inline.js"></script>
                                        <button type="button" class="stack-btn" onclick="payWithPaystack()"> Place Order </button>
                                   
                                        </td>
                                        
                                    </tr>
                                </table>

                            </div>
                            <?php } ?>

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
                                              <span>Select coupon<br></span>
                                          </div>
                                          <div class="single-item__remove">
                                              <span>Coupon<br></span>
                                          </div>
                                  </div>
                          </div>
                          <div class="ordre-details__total" id="coupon_box">
                            <?php if($dd!='') {  ?>
                              <h1 >Coupon value</h1>
                              <?php } ?>
                              <h1 class="price" id="coupon_price"><?php if($dd!='') { ?><span>NGN &#8358;</span><?php } ?><?php if(isset($dd) && $dd!=''){ echo number_format($dd, 2);} ?></h1>
                          </div>
                          <div class="ordre-details__total">
                              <h1>Total</h1>
                              <h1 class="price order_total_price" id=""><span class="summary-ngn">NGN</span> &#8358;<?php 
                              echo number_format((int)$cartTotal - (int)$dd, 2);
                              
                              ?></h1>
                          </div>
                          <div class="ordre-details__coupon">
                          <form action="" method="POST" autocomplete="off">
                                  <input type="text" class="coupon_input" id="coupon_str" name="coupon_str" autocomplete="off"/>
                                  <input type="submit" class="coupon_submit" id="coupon_submit" name="submit" value="Apply Coupon"/>
                          </form>
                          <div id="coupon_result" style="color:red; font-size: 20px; padding: 0px"><?php if(isset($_POST['coupon_str'])){echo $code;}?></div>
                          </div>
                          <!-- <div id="place-order">Place Order</div> -->
                    </div>
              </div>
            <!-- cart-summary end -->
  </div>
</div>

<input type="hidden" id="sid">
<input type="hidden" id="cid">

<?php 
require_once('footer.inc.php');
?>

<!-- ------------------ Paystack Payment Button ----->
<script src="app.js"></script>
<script>
 
        
  function payWithPaystack(){

            if(address_bowl=== ""){
                toggleModal();
            } else {

            let radioBtns = document.querySelectorAll("input[name='payment_type'");
            let findSelected = () => {
                let selected = document.querySelector("input[name='payment_type']:checked").value;
                return selected
            }
            radioBtns.forEach(radioBtn => {
                radioBtn.addEventListener("change", findSelected);
            });
            var payment_type = findSelected();
                
                // XMLHttpRequest Object
                var http = new XMLHttpRequest();
                var url = 'payment_type.php';
                var params = 'payment_type='+payment_type;
                http.open('POST', url, true);
                
                //Send the proper header information along with the request
                http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                http.send(params);
                http.onreadystatechange = function() { //Call a function when the state changes.
                    if(http.readyState == 4 && http.status == 200) {
                        var result = http.responseText;

                        if (result == 'wallet') {
                            
                            window.location.href='<?php echo SITE_PATH?>checkout';

                        }
                        if (result == 'paystack') {
                            var handler = PaystackPop.setup({
                            key: 'pk_live_a66e96f6628340e5c54cfc73e69fc5b678644f78',
                            email: "<?php echo $_SESSION["LOGIN_EMAIL"] ?>",
                            amount: <?php 
                        if ($dd!='') {
                                $cartTotal = $cartTotal - $dd;
                                echo ($cartTotal * 100) + ($cartTotal * 1.5 / 100) * 100 + (100 * 100);
                                $_SESSION['cartTotal']=$cartTotal;
                        }else{
                                echo ($cartTotal * 100) + ($cartTotal * 1.5 / 100) * 100 + (100 * 100);
                                $_SESSION['cartTotal']=$cartTotal;
                        } ?>,
                        currency: "NGN",
                        ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                        firstname: "<?php echo $_SESSION["FIRSTNAME"] ?>",
                        
                        metadata: {
                            custom_fields: [
                                {
                                    display_name: "Mobile Number",
                                    variable_name: "mobile_number",
                                    value: ""
                                }
                            ]
                        },
                        callback: function(response){
                            var referenced = response.reference;
                            var status = response.status;
                            
                            //after the transaction have been completed
                            //make post call  to the server with to verify payment 
                            //using transaction reference as post data
                            
                            $.post("verify_payment.php", {reference: referenced}, function(response){
                                if(response == "success") {

                                    //successful transaction
                                    window.location.href='<?php echo SITE_PATH?>checkout';
                                    
                                }else{

                                    //transaction failed
                                    alert(response);
                                }
                            });
                        },
                        onClose: function(){
                            alert('window closed');
                        }
                        });
                        handler.openIframe();

                        }
                    }
                
                // XMLHttpRequest Object
                }
        
            
        }

   
  }
</script>
<!-- ------------------ // Paystack Payment Button -->
</body>
</html>
