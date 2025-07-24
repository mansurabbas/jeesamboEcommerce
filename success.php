<?php
// This include session, connection and functions
include "top.php";
?>
<?php
// $phone = '';
// $user_id = '';
// $item_id = '';
// $reference='';
// $email = '';
// $address = '';
// $qty = '';
// $quantity = '';
// $added_on = '';
// $total_price = '';
// $reference = '';
// $final_amount = '';
// $total_cart_price=0;
// $cartTotal=0;
// $cart_total = '';
// $pricetotal = '';
// $name='';
// $phone_number='';
// $street='';
// $suit='';
// $country='';
// $state='';
// $city='';
// $zipcode='';
// $productId='';
// $amt = '';
 
// Getting Position of the Customer Start 
// if(isset($_SESSION['ip-api_customerlat']) && isset($_SESSION['ip-api_customerlon'])){
//     $customerlat = $_SESSION['ip-api_customerlat'];
//     $customerlon = $_SESSION['ip-api_customerlon'];
// }
// Getting Position of the Customer End 
?>
<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Success</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="content">
        
        <!-- Popup Success Message -->
        
        <div id="popup-container">
            <div class="popup" id="popup">
                <img src="mystore/icons/tick.png" width="100px" >
                <h2>Thank You</h2>
                    <p>Your order has been placed successfully.</p>
                    <p>Please check your email id for invoice.</p>
                <button type="button" onclick="closePopup()">Ok</button>
            </div>
        </div>
        
        <!-- Popup Success Message -->
        
    </div>
<?php include('footer.inc.php'); ?>
<?php
if(isset($_SESSION['COUPON_ID'])){
	unset($_SESSION['COUPON_ID']);
	unset($_SESSION['COUPON_CODE']);
	unset($_SESSION['COUPON_VALUE']);
}
?>
<script src="js/custom.js"></script>

<script>
        var loader = document.getElementById("preloader");
        window.addEventListener("load", function(){
            loader.style.display = "none";
        })
</script>

<script>
 let popup = document.getElementById("popup");
 
 document.addEventListener("DOMContentLoaded", function() {
     setTimeout(function() {
     popup.classList.add("open-popup")
     }, 1000 );
 });
 
  function closePopup() {
     popup.classList.remove("open-popup")
     window.location.replace("https://jeesambo.com.ng");
 }
 
</script>


</body>
</html>
