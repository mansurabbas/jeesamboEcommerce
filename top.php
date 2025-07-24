<?php
ob_start();
// ini_set( 'session.cookie_httponly', 1 );
session_start();
session_regenerate_id();
require_once("storescripts/connect_to_mysql.php");
require_once('Mobile_Detect.php');
require_once('BrowserDetection.php');
require_once("vendor/autoload.php");
require_once("admin/functions.php");
require('add_to_cart.inc.php');

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);
// error_log("You messed up!", 3, "/public_html/errors.log");

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url_array = explode("/", $url);
$id = end($url_array);

?>
<?php
$page_title='';
$wishlist_count='';
$product_name='';
$price='';
$details='';
$detail='';
$quantity='';
$msg='';
$list='';
$obj='';
$brand='';
$uid='';
$cartOutput = '';
$item_id = '';
$price = '';  
$pricetotal = '';
$cartOutput = "";
$cartTotal = "";
$get_product='';
$user_id='';
$order_id='';
$coupon_value='';
$total_price='';
$cart_total='';
$productAttr='';
$_SESSION['VENDOR_COMPANY_NAME']='';
$customerlat=0;
$customerlon=0;
$vendorlat=0;
$vendorlon=0;
$unitShippingCost=0;
$totalShippingCost=0;
$unitPrice=0;
$totalPrice=0;
$CartTotal=0;
?>

<?php
   
// Getting Position of the Customer Start 
// if(isset($_SESSION['ip-api_customerlat']) && isset($_SESSION['ip-api_customerlon'])){
//         $customerlat = $_SESSION['ip-api_customerlat'];
//         $customerlon = $_SESSION['ip-api_customerlon'];
//  }
// Getting Position of the Customer End 
// 		if(isset($_SESSION['customerlat']) && isset($_SESSION['customerlon'])){
//         	$customerlat=$_SESSION['customerlat'];
//         	$customerlon=$_SESSION['customerlon'];
    	
//         }else{
//         	$loadFun="onload='getLocation()'";
//         }

  // Getting Position of the Customer Start
    // get user's IP address
    function getUserIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    //Making cURL request
    // $ip = getUserIpAddr();
    // $ch=curl_init();
    // curl_setopt($ch,CURLOPT_URL,"http://ip-api.com/json/$ip");
    // curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    // $result=curl_exec($ch);
    // $result=json_decode($result);
    // if($result->status=='success'){
    	
    // 	if(isset($result->lat) && isset($result->lon)){
    // 	     $_SESSION['ip-api_customerlat'] = $result->lat;
    // 		 $_SESSION['ip-api_customerlon'] = $result->lon;
    // 	}
    	
    // }
    //      $customerlat = $_SESSION['ip-api_customerlat'];
	// 	 $customerlon = $_SESSION['ip-api_customerlon'];
	// Getting Position of the Customer End

?>
<?php

$attr_id='';
$total_count=0;
$totalProduct=0;
$browser=new Wolfcast\BrowserDetection;

$browser_name=$browser->getName();
$browser_version=$browser->getVersion();

$detect=new Mobile_Detect();

if($detect->isMobile()){
	$type='Mobile';
}elseif($detect->isTablet()){
	$type='Tablet';
}else{
	$type='PC';
}

if($detect->isiOS()){
	$os='IOS';
}elseif($detect->isAndroidOS()){
	$os='Android';
}else{
	$os='Window';
}

$url=(isset($_SERVER['HTTPS'])) ? "https":"http";
$url.="://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$ref='';
if(isset($_SERVER['HTTP_REFERER'])){
	$ref=$_SERVER['HTTP_REFERER'];
}

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$added_on = date('Y-m-d');
$userIP = $_SERVER['REMOTE_ADDR'];
$query = "SELECT * FROM unique_visitors WHERE added_on='$added_on'";
$result = mysqli_query($conn, $query);

if($result->num_rows==0) {
    $insertQuery = "INSERT INTO unique_visitors (browser_name,browser_version,type,os,url,ref,ip,added_on) VALUES('$browser_name','$browser_version','$type','$os','$url','$ref','$userIP','$added_on')";
    mysqli_query($conn, $insertQuery);
}else{
    $row = $result->fetch_assoc();
    if(!preg_match('/'.$userIP.'/i',$row['ip'])) {
        $newIP = "$row[ip] $userIP";

        if(!isset($_COOKIE['visit'])){
            setCookie('visit','yes',time()+(60*60*24*30));
            $updateQuery = "UPDATE unique_visitors SET ip ='$newIP',total_count=total_count+1 WHERE added_on='$added_on'";
            mysqli_query($conn, $updateQuery);
        }

    }
}
?>

<?php


$obj=new add_to_cart();
$totalProduct=$obj->totalProduct();

if (isset($_SESSION['USER_ID'])) {
    $uid=$_SESSION['USER_ID'];
}
if (isset($login_password)) {
        echo $login_password;
}
$order_sql=mysqli_query($conn,"SELECT * FROM `order` WHERE user_id='$uid'");
while($row=mysqli_fetch_assoc($order_sql)){
    $order_id=$row['id'];
}
?>
<?php

//Deleting Wishlist
$getWalletAmt=0;
if(isset($_SESSION['USER_LOGIN'])){
	if (isset($_SESSION['USER_ID'])) {
        $uid=$_SESSION['USER_ID'];
    }
	if(isset($_GET['wishlist_id'])){
		$wid=mysqli_real_escape_string($conn, $_GET['wishlist_id']);
		mysqli_query($conn,"DELETE FROM wishlist WHERE id='$wid' AND user_id='$uid'");
	}
	$wishlist_count=mysqli_num_rows(mysqli_query($conn,"SELECT products.product_name,products.image,products.id,wishlist.id FROM products,wishlist WHERE wishlist.product_id=products.id AND wishlist.user_id='$uid'"));
}

$script_name=$_SERVER['SCRIPT_NAME'];
$script_name_arr=explode('/',$script_name);
$mypage=$script_name_arr[count($script_name_arr)-1];
$meta_title="Jeesambo";
$meta_desc="Jeesambo";
$meta_keyword="Jeesambo";
$meta_url=SITE_PATH;

$meta_image="";
if($mypage=='product.php'){
    $page_title='Product';
    $decryptedId = decryptId($_GET['id']);
	$pid=mysqli_real_escape_string($conn, $decryptedId);
    
	$product_meta=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM products WHERE id='$pid'"));
	$meta_title=$product_meta['meta_title'];
	$meta_desc=$product_meta['meta_desc'];
	$meta_keyword=$product_meta['meta_keyword'];
    $pid = encryptId($pid);
    
	$meta_url=SITE_PATH."product?id=$pid";
	$meta_image=PRODUCT_IMAGE_SITE_PATH.$product_meta['image'];

}if($mypage=='contact.php'){
	$page_title='Contact Us';
}if($mypage=='wishlist.php'){
	$page_title='Wishlist';
}if($mypage=='banner.php'){
	$page_title='Banner';
}if($mypage=='index.php'){
	$page_title='Home';
}if($mypage=='cart.php'){
	$page_title='Cart';
}if($mypage=='checkout.php'){
	$page_title='Checkout';
}if($mypage=='success.php'){
	$page_title='Success';
}if($mypage=='my_order.php'){
	$page_title='My Order';
}if($mypage=='profile.php'){
	$page_title='Profile';
}if($mypage=='security.php'){
	$page_title='Security';
}if($mypage=='change_name.php'){
	$page_title='Update Name';
}if($mypage=='change_email.php'){
	$page_title='Update Email';
}if($mypage=='change_password.php'){
	$page_title='Update Password';
}if($mypage=='search.php'){
	$page_title='Search';
}if($mypage=='categories.php'){
	$page_title='Category';
}if($mypage=='login.php'){
	$page_title='Login';
}if($mypage=='seller_signup.php'){
	$page_title='Seller Signup';
}if($mypage=='terms-of-use.php'){
	$page_title='Terms Of Use';
}if($mypage=='my_order_details.php'){
	$page_title='My Order Details';
}if($mypage=='users.php'){
	$page_title='User';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $page_title?></title>
    <meta name="description" content="<?php echo $meta_desc?>">
	<meta name="keywords" content="<?php echo $meta_keyword?>">
	<meta property="og:title" content="<?php echo $meta_title?>">
	<meta property="og:image" itemprop="image" content="<?php echo $meta_image?>">
	<meta property="og:url" content="<?php echo $meta_url?>">
	<meta property="og:site_name" content="<?php echo SITE_PATH?>">
    <meta property="twitter:title" content="<?php echo $meta_title?>">
    <meta name="twitter:image" content="<?php echo $meta_image?>">
    <meta name="twitter:description" content="<?php echo $meta_desc?>">
    <meta property="twitter:url" content="<?php echo $meta_url?>">
	<link rel="cononical" href="<?php echo SITE_PATH?>title=<?php echo $meta_title;?>">

    <link rel="stylesheet" href="style.css">
    
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <!-- <script src="//code.jquery.com/jquery-3.6.3.js"></script> -->
    <!-- DataTables js -->
    <script type="text/javascript" src="datatable/js/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="datatable/datatable.js"></script>
    <script type="text/javascript" src="datatable/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="datatable/js/dataTables.responsive.min.js"></script>
    <!--// DataTables -->
    <!-- DataTables css -->
    <link rel="stylesheet" type="text/css" href="datatable/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="datatable/css/responsive.dataTables.min.css">
    <!--// DataTables -->

	<link rel="shortcut icon" type="image/png" href="icons/favicon.png">
	
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/custom.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/3ebb00a559.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>

    <script src="js/custom.js"></script>

  <script>
      $(document).ready(function(){
            var flag = 0;
            function loadProducts(offset, limit) {
            $.ajax({
                
                type: "POST",
                url: "loadMoreProduct.php",
                data: {
                    'offset': offset,
                    'limit': limit,
                },
                cache: false,
                success: function(data){
                    $('.results').append(data);
                    flag += limit;
                }
                
            });
            }
            // Initial load
            loadProducts(0, 7); // Fetch products on load

            $(window).scroll(function() {
                if($(window).scrollTop() >= $(document).height() - $(window).height()-100) {
                    loadProducts(flag, 3); // Load more when near the bottom
                }
            });
           
      });    
  </script>

    </head>
    <body id="index">

         <!-- Loader Container -->
        <div class="loader-container" id="loaderContainer">
            <div class="loader spin-animation" id="loader"></div>
        </div>
        <!-- Login page Loader Container -->
        <div id="login_loader"></div>
    <nav>
        <div class="content-wrap">
                <div class="logo"><a href="<?php echo SITE_PATH?>index">Jeesambo</a></div>
                <div class="form">
                <form action="search" autocomplete="off">
                    <input type="text" name="str" id="search" placeholder="Search Products" class="mg-search" autocomplete="off">
                    <button id="submit" class="mg-submit"><i class="fas fa-search"></i></button>
                </form>
                </div>
                <input type="radio" name="slide" id="menu-bt" class="menu-bt">
                <input type="radio" name="slide" id="cancel-bt" class="cancel-bt">
                <ul class="nav-links">
                    <label for="cancel-bt" class="bt cancel-bt"><i class="fas fa-times"></i></label>
                    
                    <li><div class="side-logo"><a href="<?php echo SITE_PATH?>index">Jeesambo</a></div> 

                   
                    <li class="become_vendor"><a href="<?php echo SITE_PATH?>seller_signup"><i class="fa fa-industry"></i> 
                    &nbsp;Sell on jeesambo</span></a></li>
                    <li class="airtime_topup"><a href="data_utility"><i class="fa fa-volume-control-phone"></i> 
                    &nbsp;Buy Airtime</span></a></li>
                    <li class="data_topup"><a href="data_utility"><i class="fas fa-wifi"></i> 
                    &nbsp;Buy Data</span></a></li>

                    <?php if (isset($_SESSION['USER_ID'])) { ?>
                    <li><a href="<?php echo SITE_PATH?>wallet"><i class="fas fa-wallet"></i> 
                    Wallet Bal: &nbsp;&#8358; <span><?php 
                    $getWalletAmt=getWalletAmt($uid);

                    echo number_format($getWalletAmt,2); ?></span></a></li> 
                    <?php } ?>

                    <li><a href="<?php echo SITE_PATH?>cart?id=<?php echo $uid?>"><i class="fa fa-shopping-cart"></i> 
                    Cart&nbsp;<span class="htc__qua"><?php echo $totalProduct; ?></span></a></li>
                   
                    <?php if(isset($_SESSION["USER_ID"])) { ?>
                    <li><a href="<?php echo SITE_PATH?>wishlist"><i class="fa fa-heart-o"></i>&nbsp;Wishlist&nbsp;<span class="cnt_wishlist"><?php echo $wishlist_count; ?></span></a></li>
                    <?php } ?>
                    <li>
                    <?php
                    if (isset($_SESSION["FIRSTNAME"])) {
                    ?>
                    <a href="<?php echo SITE_PATH?>login" class="desktop-item"><i class="fa fa-user-o"></i>&nbsp;Hi, <?php echo $_SESSION["FIRSTNAME"]; ?></a>
                    <?php
                    } else {
                        echo '<a class="desktop-item"><i class="fa fa-user-o"></i>&nbsp;Account</a>';
                    }
                    ?>
                    <input type="checkbox" id="showDrop" class="showDrop">
                    <?php
                    if (isset($_SESSION["FIRSTNAME"])) {
                    ?>
                    <label for="showDrop" class="mobile-item"><i class="fa fa-user-o"></i>&nbsp;&nbsp;Hi, <?php echo $_SESSION["FIRSTNAME"]; ?>&nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i></label>
                    <?php
                    } else {
                        echo '<label for="showDrop" class="mobile-item"><i class="fa fa-user-o"></i>&nbsp;Account&nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i></label>';
                    }
                    ?>
                    <!-- <label for="showDrop" class="mobile-item">Login&nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i></label> -->
                    <ul class="drop-menu">
                        <li><a href="<?php echo SITE_PATH?>login"><i class="fa fa-sign-in"></i>&nbsp;Register / Login</a></li>
                        <li><a href="<?php echo SITE_PATH?>my_order"><i class="fa fa-plane" aria-hidden="true"></i>&nbsp;Order</a></li>
                        <li><a href="<?php echo SITE_PATH?>profile"><i class="fa fa-user-circle"></i>&nbsp;Profile</a></li>
                        <li><a href="<?php echo SITE_PATH?>logout"><i class="fa fa-sign-out"></i>&nbsp;Logout</a></li>
                    </ul>
                    </li>
                    <li>
                    <a href="#" class="desktop-item"><i class="fa fa-caret-down" aria-hidden="true"></i> All</a>
                    <input type="checkbox" id="showMega" class="showMega">
                    <label for="showMega" class="mobile-item">All&nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i></label>
                        <div class="mega-box">
                            <div class="mega-content">
                                <!-- <div class="row"> -->
                                    <!-- <img src="images/mac.jpg" alt=""> -->
                                <!-- </div> -->
        
                                    <?php
                                    // FETCHING CATEGORIES
                                    $cat_res=mysqli_query($conn,"SELECT * FROM categories WHERE STATUS=1 ORDER BY categories ASC");
                                    $cat_arr=array();
                                    while($row=mysqli_fetch_assoc($cat_res)){
                                        $cat_arr[]=$row;
                                    }

                                    foreach($cat_arr as $list) { ?>
                                            <?php
                                                $cat_id=$list['id'];
                                                $sub_cat_res=mysqli_query($conn,"SELECT * FROM sub_categories WHERE status='1' AND categories_id='$cat_id' LIMIT 5");
                                                if(mysqli_num_rows($sub_cat_res)>0){
											?>

                                <div class="row">
                                    <a class="row_title" href="<?php echo SITE_PATH?>categories?id=<?php echo $list['id']?>"><?php echo $list['categories']?></a>
                                            
                                    <ul class="mega-links">
                                    
                                            <?php
                                            while($sub_cat_rows=mysqli_fetch_assoc($sub_cat_res)){
                                                echo '<li><a href="'.SITE_PATH.'categories?id='.$list['id'].'&sub_categories='.$sub_cat_rows['id'].'">'.$sub_cat_rows['sub_categories'].'</a></li>
                                            ';
                                            }
                                            ?>

                                    </ul>
                                   
                                </div>
                                <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </li>
                    <!-- <li><a href="#">Feedback</a></li> -->
                </ul>
                <label for="menu-bt" class="bt first-bt menu-bt"><a href="<?php echo SITE_PATH?>login"><i class="fa fa-user-o"></i></a></label>
                <label for="menu-bt" class="bt first-bt menu-bt"><a href="<?php echo SITE_PATH?>data_utility"><i class="fas fa-wifi"></i></a></label>
                <label for="menu-bt" class="bt first-bt menu-bt"><i class="fas fa-bars"></i></label>
        </div>
        
    </nav>

    <div id="bottom-header">
        <div class="topup_wrapper">
             <a href="<?php echo SITE_PATH?>data_utility"><span>Airtime</span></a> 
            <a href="<?php echo SITE_PATH?>data_utility" class="data-airtime-subs"><span>Data</span></a>
            <!-- <a href="<?php echo SITE_PATH?>bill_payment"><span>Bills |</span></a>
            <a href="<?php echo SITE_PATH?>cable_payment"><span>Subscriptions</span></a> -->
        </div>
        <div class="sell">
            <a href="<?php echo SITE_PATH?>seller_signup" class="monitize"><span>Sell On Jeesambo</span></a>
        </div>
        <div class="second-menu">
            <a href=""><label for="menu-bt" class="bt second-bt menu-bt"><i class="fas fa-bars"></i></label></a>
        </div>
    </div>

<?php ob_end_flush();?>

        
    