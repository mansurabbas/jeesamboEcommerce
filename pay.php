<?php
// This include session, connection and functions
include "top.php";
?>

<?php
$product_name='';
$price='';
$details='';
$quantity='';
$msg='';
$obj='';
$cartOutput = '';
$item_id = '';
$product_name = '';
$price = '';
$pricetotal = '';
$cartOutput = "";
$cartTotal = "";
?>

<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Section 5  (render the cart for the user to view on the page)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$cartOutput = "";
$cartTotal = "";
$pp_checkout_btn = '';
$product_id_array = '';
if (!isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) < 1) {
    $cartOutput = "<h2 align='center'>Your shopping cart is empty</h2>";
} else {
   // Start PayPal Checkout Button
   $pp_checkout_btn .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="upload" value="1">
    <input type="hidden" name="business" value="you@youremail.com">';
   // Start the For Each loop
   $i = 0;
    foreach ($_SESSION["cart_array"] as $each_item) {
       $item_id = clean($conn,$each_item['item_id']);
       $sql = mysqli_query($conn, "SELECT * FROM products WHERE id='$item_id' LIMIT 1");
       while ($row = mysqli_fetch_array($sql)) {
           $product_name = $row["product_name"];
           $price = (int)$row["price"];
           $details = $row["details"];
       }

       $pricetotal = (int)$price * $each_item['quantity'];
       $cartTotal = $pricetotal + (int)$cartTotal;
    //    setlocale(LC_MONETARY, "en_US");
    //     $pricetotal = number_format($pricetotal, 2);
       // Dynamic Checkout Btn Assembly
       $x = $i + 1;
       $pp_checkout_btn .= '<input type="hidden" name="item_name_' . $x . '" value="' . $product_name . '">
        <input type="hidden" name="amount_' . $x . '" value="' . $price . '">
        <input type="hidden" name="quantity_' . $x . '" value="' . $each_item['quantity'] . '" class="qty">  ';
       // Create the product array variable
       $product_id_array .= "$item_id-".$each_item['quantity'].",";
       // Dynamic table row assembly

                    $cartOutput .= '<tr>';
                    $cartOutput .= '<td><div align="left" width="100%">'.$product_name.'</div><div class="cart-info" style="padding: 5px;border-bottom: 1px solid #ebebeb;"><img src="inventory_images/' . $item_id . '.jpg" alt="' . $product_name. '" /><div><p>' . $product_name. '</p><p><small>$' . $price . '</small></p></div></div></td>';
                    $cartOutput .= '<td width="5%"><span><form action="checkout.php" method="post" style="width: 20%; margin-top: 30px">
                    <input name="quantity" type="text" value="' . $each_item['quantity'] . '" size="1" maxlength="2" /><br>
                    <input name="adjustBtn' . $item_id . '" type="submit" value="change" />
                    <input name="item_to_adjust" type="hidden" value="' . $item_id . '" />
                    </form></span></td>';
                    $cartOutput .= '</tr>';

       $i++;
    }

}
?>

<body id="index">

    <?php 
    // $flat_fee = 0.015;
    // $flat_fee = number_format($flat_fee, 2);

    // $decimal_fee = 0.015;
    // $decimal_fee = number_format($decimal_fee, 2);
    // $final_amount = ((int)$cartTotal + $flat_fee) / (1 - $decimal_fee);
    ?>

    <div class="container">

        <h2><?php echo $_SESSION["EMAIL"]; ?></h2>
    
<form >
  <script src="https://js.paystack.co/v1/inline.js"></script>
  <button type="button" onclick="payWithPaystack()"> Pay </button> 
</form>
 
<script>
  function payWithPaystack(){
    var handler = PaystackPop.setup({
      key: 'pk_test_cd9adc217ec49d0ae3bc59553b502e588c697956',
      email: '<?php echo $_SESSION["EMAIL"]; ?>',
      amount: <?php echo $cartTotal * 100 ; ?>,
      currency: "NGN",
      ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      firstname: "<?php echo $_SESSION["FIRSTNAME"]; ?>",
      
      metadata: {
         custom_fields: [
            {
                display_name: "Mobile Number",
                variable_name: "mobile_number",
                value: "+2348012345678"
            }
         ]
      },
      callback: function(response){
          const referenced = response.reference;
          window.location.href='<?php echo SITE_PATH?>success?successfullypaid='+referenced;
      },
      onClose: function(){
          alert('window closed');
      }
    });
    handler.openIframe();
  }
</script>
    
    </div>

</body>
</html>
