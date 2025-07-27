<?php

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

$pid='';
// Composer Phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Manual Phpmailer
require_once 'phpmailer/src/Exception.php';
require_once 'phpmailer/src/PHPMailer.php';
require_once 'phpmailer/src/SMTP.php';
?>
<?php

function pr($arr){
	echo '<pre>';
	print_r($arr);
}

//  Facebook Time Ago
function facebook_time_ago($timestamp)  
 {  
      $time_ago = strtotime($timestamp);  
	 
      $current_time = time();
 
      $time_difference = $current_time - $time_ago;  
	
      $seconds = $time_difference;  
	 
      $minutes = round($seconds / 60 ); 	  // value 60 is seconds  
	  
      $hours = round($seconds / 3600);   	  //value 3600 is 60 minutes * 60 

      $days = round($seconds / 86400);        //86400 = 24 * 60 * 60;  

      $weeks = round($seconds / 604800);      // 7 * 24 * 60 * 60;  
	  
      $months = round($seconds / 2629440);
      //((365+365+365+365+366)/5/12) * 24 * 60 * 60  
	  
      $years = round($seconds / 31553280);
      //(365+365+365+365+366)/5 * 24 * 60 * 60  
	  
      if($seconds <= 60)  
      {  
        return "Just Now";  
      }  
      else if($minutes <=60)  
      {  
        if($minutes==1)  
        {  
          return "one minute ago";  
        }  
        else  
        {  
          return "$minutes minutes ago";  
        }  
      }  
      else if($hours <=24)  
      {  
        if($hours==1)  
        {  
          return "an hour ago";  
        }  
        else  
        {  
          return "$hours hrs ago";  
        }  
      }  
      else if($days <= 7)  
      {  
        if($days==1)  
        {  
          return "Yesterday";  
        }  
        else  
        {  
          return "$days days ago";  
        }  
      }  
      else if($weeks <= 4.3) //4.3 == 52/12  
      {  
        if($weeks==1)  
        {  
          return "a week ago";  
        }  
        else  
        {  
          return "$weeks weeks ago";  
        }  
      }  
      else if($months <=12)  
      {  
        if($months==1)  
        {  
          return "a month ago";  
        }  
        else  
        {  
          return "$months months ago";  
        }  
      }  
      else  
      {  
        if($years==1)  
        {  
          return "one year ago";  
        }  
        else  
        {  
          return "$years years ago";  
        }  
      }  
 }
//  Facebook Time Ago

function prx($arr){
	echo '<pre>';
	print_r($arr);
	die();
}
function redirect($link){
	?>
	<script>
	window.location.href='<?php echo $link ?>';
	</script>
	<?php
}
function decryptId($id){
	$encrypt_method = "AES-256-CBC";   
  	$secret_key = "XDT-YUGHH-GYGF-YUTY-GHRGFR";
  	$iv = "DFYTYUITYUIUYUGYIYT";

    $id = base64_decode($id);
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $iv), 0, 16);
    $id = openssl_decrypt($id, $encrypt_method, $key, 0, $iv);
    return $id;
    }

    function encryptId($id){
		$encrypt_method = "AES-256-CBC";   
		$secret_key = "XDT-YUGHH-GYGF-YUTY-GHRGFR";
		$iv = "DFYTYUITYUIUYUGYIYT";
		
		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $iv), 0, 16);
		$id = openssl_encrypt($id, $encrypt_method, $key, 0, $iv);
		$id = base64_encode($id);
		return $id;
		}
function str_openssl_enc($str,$iv){
	$key='1234567890mansur%$%^%$$#$#';
	$chiper="AES-128-CTR";
	$options=0;
	$str=openssl_encrypt($str,$chiper,$key,$options,$iv);
	return $str;
}
function str_openssl_dec($str,$iv){
	$key='1234567890mansur%$%^%$$#$#';
	$chiper="AES-128-CTR";
	$options=0;
	$str=openssl_decrypt($str,$chiper,$key,$options,$iv);
	return $str;
}

function encrypt($pass){
	$string = password_hash($pass, PASSWORD_DEFAULT);
	return $string;
}

function rand_str(){
	$str=str_shuffle("abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz");
	return $str=substr($str,0,15);
	
}
 
function wishlist_add($conn,$uid,$pid){
	$added_on=date('Y-m-d h:i:s');
	mysqli_query($conn,"INSERT INTO wishlist(user_id,product_id,added_on) VALUES('$uid','$pid','$added_on')");
}

function getProductAttr($conn,$pid){
	$sql="SELECT id FROM product_attributes WHERE product_id='$pid'";
	$sql=mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($sql);
	return $row['id'];
}

function productSoldQtyByProductId($conn,$pid,$attr_id){
	$sql="SELECT sum(order_details.qty) AS qty FROM order_details,`order` WHERE `order`.id=order_details.order_id AND order_details.product_id=$pid AND order_details.product_attr_id=$attr_id AND `order`.order_status!=4 AND (((`order`.payment_type='paystack' || `order`.payment_type='wallet') and `order`.payment_status='Success'))";
	$sql=mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($sql);
	return $row['qty'];
}

function getOrderById($oid) {
	global $conn;
	$sql="SELECT * FROM `order` WHERE id='$oid'";
	$data=array();
	$res=mysqli_query($conn, $sql);
	while($row=mysqli_fetch_assoc($res)) {
		$data[]=$row;
	}
	return $data;
}

function getUserDetailsByid($uid=''){
	global $conn;
	$data['firstname']='';
	$data['email']='';
	//$data['mobile']='';
	$data['referral_code']='';
	
	if(isset($_SESSION['USER_ID'])){
		$uid=$_SESSION['USER_ID'];
	}
	
	$row=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM users WHERE id='$uid'"));
	$data['firstname']=$row['firstname'];
	$data['email']=$row['email'];
	//$data['mobile']=$row['mobile'];
	$data['referral_code']=$row['referral_code'];
	return $data;
}

function getDeliveryBoyNameById($id){
	global $conn;
	$sql="SELECT name,mobile FROM delivery_boy WHERE id='$id'";
	$data=array();
	$res=mysqli_query($conn,$sql);
	if(mysqli_num_rows($res)>0){
		$row=mysqli_fetch_assoc($res);
		return $row['name'].'('.$row['mobile'].')';	
	}else{
		return 'Not Assign';
	}
}

function productQty($conn,$pid,$attr_id){
	$sql="SELECT qty FROM product_attributes WHERE id=$attr_id";
	$sql=mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($sql);
	return $row['qty'];
}

function clean($conn,$str){
	if($str!=''){
		$str=trim($str);
		$str=strip_tags($str);
		return mysqli_real_escape_string($conn,$str);
	}
}
function getTwoFactor($uid) {
	global $conn;
		$sql="SELECT two_factor FROM users WHERE id ='$uid' ";
		$res=mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($res);
			return $row['two_factor'];
}

function getSale($start,$end) {
	global $conn;
		$sql="SELECT SUM(total_price) AS total_price FROM `order` WHERE added_on between '$start' AND '$end' AND order_status=5";
		$res=mysqli_query($conn,$sql);
		$arr=array();
		while($row=mysqli_fetch_assoc($res)) {
			return $row['total_price'];
		}
}
function getRevenue($start,$end) {
	global $conn;
		$sql="SELECT SUM(revenue) AS revenue FROM revenue_transactions WHERE transaction_date between '$start' AND '$end'";
		$res=mysqli_query($conn,$sql);
		$arr=array();
		while($row=mysqli_fetch_assoc($res)) {
			return $row['revenue'];
		}
}

function getSetting() {
	global $conn;
		$sql="SELECT * FROM settings WHERE id ='1' ";
		$res=mysqli_query($conn,$sql);
		$row=mysqli_fetch_assoc($res);
			return $row;
}

function manageWallet($uid,$amt,$email,$type,$msg,$payment_id='') {
	global $conn;
	$added_on=date('Y-m-d H:i:s');
		$sql="INSERT INTO wallet(user_id,amt,email,type,msg,added_on) VALUES('$uid','$amt','$email','$type','$msg','$added_on')";
		$res=mysqli_query($conn,$sql);
}

function getWallet($uid) {
	global $conn;
		$sql="SELECT * FROM wallet WHERE user_id = '$uid' ";
		$res=mysqli_query($conn,$sql);
		$arr=array();
		while ($row=mysqli_fetch_assoc($res)) {
			$arr[]=$row;
		}
		return $arr;
}

function getWalletAmt($uid) {
	global $conn;
		$sql="SELECT * FROM wallet WHERE user_id = '$uid' ";
		$res=mysqli_query($conn,$sql);
		$arr=array();
		$in=0;
		$out=0;
		while ($row=mysqli_fetch_assoc($res)) {
			if($row['type']=='in'){
				$in=$in+$row['amt'];
			}
			if($row['type']=='out'){
				$out=$out+$row['amt'];
			}
		}
		return $in - $out;
}
// Manage vendor wallet
function manageVendorWallet($admin_id,$amount,$msg,$type,$added_on) {
	global $conn;
	$added_on=date('Y-m-d H:i:s');
		$sql="INSERT INTO admin_wallet(admin_id,amount,type,msg,added_on) VALUES('$admin_id','$amount','$type','$msg','$added_on')";
		$res=mysqli_query($conn,$sql);
}

function getVendorWallet($admin_id) {
	global $conn;
		$sql="SELECT * FROM admin_wallet WHERE admin_id = '$admin_id' ";
		$res=mysqli_query($conn,$sql);
		$arr=array();
		while ($row=mysqli_fetch_assoc($res)) {
			$arr[]=$row;
		}
		return $arr;
}

function getVendorWalletAmt($admin_id) {
	global $conn;
		$sql="SELECT * FROM admin_wallet WHERE admin_id = '$admin_id' ";
		$res=mysqli_query($conn,$sql);
		$arr=array();
		$in=0;
		$out=0;
		while ($row=mysqli_fetch_assoc($res)) {
			if($row['type']=='in'){
				$in=$in+$row['amt'];
			}
			if($row['type']=='out'){
				$out=$out+$row['amt'];
			}
		}
		return $in - $out;
}

function manageCommission($commission_amt,$msg,$type,$receive_date) {
	global $conn;
	$receive_date=date('Y-m-d H:i:s');
		$sql="INSERT INTO commission(commission_amt,msg,type,receive_date) VALUES('$commission_amt','$msg','$type','$receive_date')";
		$res=mysqli_query($conn,$sql);
}

function getCommissionAmt() {
	global $conn;
		$sql="SELECT * FROM commission ";
		$res=mysqli_query($conn,$sql);
		$arr=array();
		$in=0;
		$out=0;
		while ($row=mysqli_fetch_assoc($res)) {
			if($row['type']=='in'){
				$in=$in+$row['commission_amt'];
			}
			if($row['type']=='out'){
				$out=$out+$row['commission_amt'];
			}
		}
		return $in - $out;
}

function get_product($conn, $limit='', $cat_id='', $pid='',  $search_str='',$sort_order='', $is_best_seller='',$sub_categories='',$offset='',$attr_id=''){
	$sql="SELECT products.*,categories.categories,product_attributes.price,product_attributes.qty FROM products,categories,product_attributes WHERE products.status=1 AND products.id=product_attributes.product_id";
	if($cat_id!=''){
		$sql.=" AND products.categories_id=$cat_id ";
	}
	if($pid!=''){
		$sql.=" AND products.id=$pid ";
	}
	if($sub_categories!=''){
		$sql.=" AND products.sub_categories_id=$sub_categories ";
	}
	if($is_best_seller!=''){
		$sql.=" AND products.best_seller=1 ";
	}
	if($attr_id>0){
		$sql.=" AND product_attributes.id=$attr_id ";
	}
	$sql.=" AND products.categories_id=categories.id ";
	if($search_str!=''){
		$sql.=" AND (products.product_name like '%$search_str%' or products.details like '%$search_str%') ";
	}
	$sql.=" GROUP BY products.id ";
	if($sort_order!=''){
		$sql.=" $sort_order ";
	}else{
		$sql.=" ORDER BY products.id DESC ";
	}
	if($limit!=''){
		$sql.=" limit $limit ";
	}
	if($offset!=''){
		$sql.=" offset $offset";
	}
	
	$sql=mysqli_query($conn,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($sql)){
		$data[]=$row;
	}
	return $data;
}

// Assuming you have already connected to the database

// Calculate commission amount for a product
function calculateCommission($productPrice, $commissionRate) {
    return $productPrice * $commissionRate / 100;
}

function sentInvoice($conn,$order_id){
	$res=mysqli_query($conn,"SELECT distinct(order_details.id) ,order_details.*,order_details.price ,order_details.shipping AS ShippingCost, products.product_name,products.image FROM order_details,products WHERE order_details.order_id='$order_id' AND order_details.product_id=products.id ");

	$user_order=mysqli_fetch_assoc(mysqli_query($conn,"SELECT `order`.*,`order`.total_price, users.firstname,users.email  FROM `order`,users WHERE users.id=`order`.user_id AND `order`.id='$order_id'"));

	$coupon_details=mysqli_fetch_assoc(mysqli_query($conn,"SELECT coupon_value FROM `order` WHERE id='$order_id'"));
	$coupon_value=$coupon_details['coupon_value'];

	$total_price=0;
	//$ShippingCost=$_SESSION['ShippingCost'];

	$html='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html>
	  <head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="x-apple-disable-message-reformatting" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title></title>
		<style type="text/css" rel="stylesheet" media="all">
		/* Base ------------------------------ */
		
		@import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");
		body {
		  width: 100% !important;
		  height: 100%;
		  margin: 0;
		  -webkit-text-size-adjust: none;
		}
		
		a {
		  color: #3869D4;
		}
		
		a img {
		  border: none;
		}
		
		td {
		  word-break: break-word;
		}
		
		.preheader {
		  display: none !important;
		  visibility: hidden;
		  mso-hide: all;
		  font-size: 1px;
		  line-height: 1px;
		  max-height: 0;
		  max-width: 0;
		  opacity: 0;
		  overflow: hidden;
		}
		/* Type ------------------------------ */
		
		body,
		td,
		th {
		  font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
		}
		
		h1 {
		  margin-top: 0;
		  color: #333333;
		  font-size: 22px;
		  font-weight: bold;
		  text-align: left;
		}
		
		h2 {
		  margin-top: 0;
		  color: #333333;
		  font-size: 16px;
		  font-weight: bold;
		  text-align: left;
		}
		
		h3 {
		  margin-top: 0;
		  color: #333333;
		  font-size: 14px;
		  font-weight: bold;
		  text-align: left;
		}
		
		td,
		th {
		  font-size: 16px;
		}
		
		p,
		ul,
		ol,
		blockquote {
		  margin: .4em 0 1.1875em;
		  font-size: 16px;
		  line-height: 1.625;
		}
		
		p.sub {
		  font-size: 13px;
		}
		/* Utilities ------------------------------ */
		
		.align-right {
		  text-align: right;
		}
		
		.align-left {
		  text-align: left;
		}
		
		.align-center {
		  text-align: center;
		}
		/* Buttons ------------------------------ */
		
		.button {
		  background-color: #3869D4;
		  border-top: 10px solid #3869D4;
		  border-right: 18px solid #3869D4;
		  border-bottom: 10px solid #3869D4;
		  border-left: 18px solid #3869D4;
		  display: inline-block;
		  color: #FFF;
		  text-decoration: none;
		  border-radius: 3px;
		  box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
		  -webkit-text-size-adjust: none;
		  box-sizing: border-box;
		}
		
		.button--green {
		  background-color: #22BC66;
		  border-top: 10px solid #22BC66;
		  border-right: 18px solid #22BC66;
		  border-bottom: 10px solid #22BC66;
		  border-left: 18px solid #22BC66;
		}
		
		.button--red {
		  background-color: #FF6136;
		  border-top: 10px solid #FF6136;
		  border-right: 18px solid #FF6136;
		  border-bottom: 10px solid #FF6136;
		  border-left: 18px solid #FF6136;
		}
		
		@media only screen and (max-width: 500px) {
		  .button {
			width: 100% !important;
			text-align: center !important;
		  }
		}
		/* Attribute list ------------------------------ */
		
		.attributes {
		  margin: 0 0 21px;
		}
		
		.attributes_content {
		  background-color: #F4F4F7;
		  padding: 16px;
		}
		
		.attributes_item {
		  padding: 0;
		}
		/* Related Items ------------------------------ */
		
		.related {
		  width: 100%;
		  margin: 0;
		  padding: 25px 0 0 0;
		  -premailer-width: 100%;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		}
		
		.related_item {
		  padding: 10px 0;
		  color: #CBCCCF;
		  font-size: 15px;
		  line-height: 18px;
		}
		
		.related_item-title {
		  display: block;
		  margin: .5em 0 0;
		}
		
		.related_item-thumb {
		  display: block;
		  padding-bottom: 10px;
		}
		
		.related_heading {
		  border-top: 1px solid #CBCCCF;
		  text-align: center;
		  padding: 25px 0 10px;
		}
		/* Discount Code ------------------------------ */
		
		.discount {
		  width: 100%;
		  margin: 0;
		  padding: 24px;
		  -premailer-width: 100%;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		  background-color: #F4F4F7;
		  border: 2px dashed #CBCCCF;
		}
		
		.discount_heading {
		  text-align: center;
		}
		
		.discount_body {
		  text-align: center;
		  font-size: 15px;
		}
		/* Social Icons ------------------------------ */
		
		.social {
		  width: auto;
		}
		
		.social td {
		  padding: 0;
		  width: auto;
		}
		
		.social_icon {
		  height: 20px;
		  margin: 0 8px 10px 8px;
		  padding: 0;
		}
		/* Data table ------------------------------ */
		
		.purchase {
		  width: 100%;
		  margin: 0;
		  padding: 35px 0;
		  -premailer-width: 100%;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		}
		
		.purchase_content {
		  width: 100%;
		  margin: 0;
		  padding: 25px 0 0 0;
		  -premailer-width: 100%;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		}
		
		.purchase_item {
		  padding: 10px 0;
		  color: #51545E;
		  font-size: 15px;
		  line-height: 18px;
		}
		
		.purchase_heading {
		  padding-bottom: 8px;
		  border-bottom: 1px solid #EAEAEC;
		}
		
		.purchase_heading p {
		  margin: 0;
		  color: #85878E;
		  font-size: 12px;
		}
		
		.purchase_footer {
		  padding-top: 15px;
		  border-top: 1px solid #EAEAEC;
		}
		
		.purchase_total {
		  margin: 0;
		  text-align: right;
		  font-weight: bold;
		  color: #333333;
		}
		
		.purchase_total--label {
		  padding: 0 15px 0 0;
		}
		
		body {
		  background-color: #F4F4F7;
		  color: #51545E;
		}
		
		p {
		  color: #51545E;
		}
		
		p.sub {
		  color: #6B6E76;
		}
		
		.email-wrapper {
		  width: 100%;
		  margin: 0;
		  padding: 0;
		  -premailer-width: 100%;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		  background-color: #FFF;
		}
		
		.email-content {
		  width: 100%;
		  margin: 0;
		  padding: 0;
		  -premailer-width: 100%;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		}
		/* Masthead ----------------------- */
		
		.email-masthead {
		  padding: 25px 0;
		  text-align: center;
		}
		
		.email-masthead_logo {
		  width: 94px;
		}
		
		.email-masthead_name {
		  font-size: 16px;
		  font-weight: bold;
		  color: #A8AAAF;
		  text-decoration: none;
		  text-shadow: 0 1px 0 white;
		}
		/* Body ------------------------------ */
		
		.email-body {
		  width: 100%;
		  margin: 0;
		  padding: 0;
		  -premailer-width: 100%;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		  background-color: #FFFFFF;
		}
		
		.email-body_inner {
		  width: 570px;
		  margin: 0 auto;
		  padding: 0;
		  -premailer-width: 570px;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		  background-color: #FFFFFF;
		}
		
		.email-footer {
		  width: 570px;
		  margin: 0 auto;
		  padding: 0;
		  -premailer-width: 570px;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		  text-align: center;
		}
		
		.email-footer p {
		  color: #6B6E76;
		}
		
		.body-action {
		  width: 100%;
		  margin: 30px auto;
		  padding: 0;
		  -premailer-width: 100%;
		  -premailer-cellpadding: 0;
		  -premailer-cellspacing: 0;
		  text-align: center;
		}
		
		.body-sub {
		  margin-top: 25px;
		  padding-top: 25px;
		  border-top: 1px solid #EAEAEC;
		}
		
		.content-cell {
		  padding: 35px;
		}
		/*Media Queries ------------------------------ */
		
		@media only screen and (max-width: 600px) {
		  .email-body_inner,
		  .email-footer {
			width: 100% !important;
		  }
		}
		
		@media (prefers-color-scheme: dark) {
		  body,
		  .email-body,
		  .email-body_inner,
		  .email-content,
		  .email-wrapper,
		  .email-masthead,
		  .email-footer {
			background-color: #FFF !important;
			color: #FFF !important;
		  }
		  p,
		  ul,
		  ol,
		  blockquote,
		  h1,
		  h2,
		  h3 {
			color: #FFF !important;
		  }
		  .attributes_content,
		  .discount {
			background-color: #222 !important;
		  }
		  .email-masthead_name {
			text-shadow: none !important;
		  }
		}
		</style>
		<!--[if mso]>
		<style type="text/css">
		  .f-fallback  {
			font-family: Arial, sans-serif;
		  }
		</style>
	  <![endif]-->
	  </head>
	  <body>
		<span class="preheader">This is an invoice for your purchase on '.$user_order['added_on'].'. Please submit payment by {{ due_date }}</span>
		<table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
		  <tr>
			<td align="center">
			  <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
				<tr>
				  <td class="email-masthead">
					<a href="https://jeesambo.com.ng/" class="f-fallback email-masthead_name">
					<img src="https://jeesambo.com.ng/icons/logo.png" width="96px" height="100px"/>
				  </a>
				  </td>
				</tr>
				<!-- Email Body -->
				<tr>
				  <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
					<table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
					  <!-- Body content -->
					  <tr>
						<td class="content-cell">
						  <div class="f-fallback">
							<h1>Hi '.$user_order['firstname'].',</h1>
							<p>Thanks for using our website. This is an invoice for your recent purchase.</p>
							<table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
							  <tr>
								<td class="attributes_content"  style="background: #fb9678">
								  <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
									<tr>
									  <td class="attributes_item">
										<span class="f-fallback" style="color:#fff">
				  <strong>Amount Due:</strong> '.number_format($user_order['total_price'],2).'.
				</span>
									  </td>
									</tr>
								   
								  </table>
								</td>
							  </tr>
							</table>
							<!-- Action -->
							
							<table class="purchase" width="100%" cellpadding="0" cellspacing="0">
							  <tr>
								<td>
								  <h3>'.$user_order['id'].'.</h3>
								</td>
								<td>
								  <h3 class="align-right">'.$user_order['added_on'].'.</h3>
								</td>
							  </tr>
							  <tr>
								<td colspan="2">
								  <table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">
									<tr>
									  <th class="purchase_heading" align="left">
										<p class="f-fallback">Description</p>
									  </th>
									  <th class="purchase_heading" align="right">
										<p class="f-fallback">Amount</p>
									  </th>
									</tr>
									';
									while($row=mysqli_fetch_assoc($res)){
										$total_price=$total_price + $row['price'];
										$price=$row['price'];
										$unitShippingCost=0;
										$totalShippingCost=0;
										$unitShippingCost = $row['ShippingCost'];
										$totalShippingCost += $unitShippingCost;
										$html.='<tr>
										  <td width="80%" class="purchase_item"><span class="f-fallback">'.$row['product_name'].'</span></td>
										  <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">'.number_format($total_price,2).'</span></td>
										</tr>';
									}
									
									if($coupon_value!=''){								
										$html.=' <td width="80%" class="purchase_footer" valign="middle">
										<p class="f-fallback purchase_total purchase_total--label">Coupon Value</p>
									  </td>
									  <td width="20%" class="purchase_footer" valign="middle">
										<p class="f-fallback purchase_total">'.number_format($coupon_value,2).'</p>
									  </td>
									</tr>';
									}
									if(isset($totalShippingCost)){								
										$html.=' <td width="80%" class="purchase_footer" valign="middle">
										<p class="f-fallback purchase_total purchase_total--label">Shipping</p>
									  </td>
									  <td width="20%" class="purchase_footer" valign="middle">
										<p class="f-fallback purchase_total">'.number_format($totalShippingCost,2).'</p>
									  </td>
									</tr>';
									}
									
									$total_price=(int)($total_price + $totalShippingCost )-(int)$coupon_value;
								
									$html.='<tr>
									  <td width="80%" class="purchase_footer" valign="middle">
										<p class="f-fallback purchase_total purchase_total--label">Total</p>
									  </td>
									  <td width="20%" class="purchase_footer" valign="middle">
										<p class="f-fallback purchase_total">'.number_format($total_price,2).'</p>
									  </td>
									</tr>
								  </table>
								</td>
							  </tr>
							</table>
							<p>If you have any questions about this invoice, simply reply to this email or reach out to our <a href="{{support_url}}">support team</a> for help.</p>
							<p>Cheers,
							  <br>The [Jeesambo] Team</p>
							<!-- Sub copy -->
							
						  </div>
						</td>
					  </tr>
					</table>
				  </td>
				</tr>
				<tr>
				  <td>
					<table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
					  <tr>
						<td class="content-cell" align="center">
						  <p class="f-fallback sub align-center">&copy 2022 [Jeesambo]. All rights reserved.</p>
						  <p class="f-fallback sub align-center">
							[Jeesambo, LLC]
							<br>Pv2 Numan Rd.
							<br>Tudun wada Kaduna
						  </p>
						</td>
					  </tr>
					</table>
				  </td>
				</tr>
			  </table>
			</td>
		  </tr>
		</table>
		<script>
	  </body>
	</html>';


// passing true in constructor enables exceptions in PHPMailer
		$mail = new PHPMailer(true);

		// Server settings
		$mail->isSMTP();
		$mail->Host = 'mail.jeesambo.com.ng';
		$mail->SMTPAuth = true;

		// Setting port 587
		// $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		// $mail->Port = 587;

		// Setting port 465
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		$mail->Port = 465;

		$mail->Username = 'jeesamb2'; // YOUR gmail email
		$mail->Password = 'Mansur#####Mansur#####'; // YOUR gmail password

		// Sender and recipient settings
		$mail->setFrom('no-reply@jeesambo.com.ng', 'Jeesambo');
		$mail->addAddress($user_order['email']);
		$mail->addReplyTo('no-reply@jeesambo.com.ng', 'Jeesambo'); // to set the reply to

		// Setting the email content
		$mail->IsHTML(true);
		$mail->Subject = "Invoice Details";
		$mail->Body = $html;
		$mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

		if ($mail->send()) {
			echo "";
		}else{
			echo "Email id not registered with us";
			die();
		}

}


?>
