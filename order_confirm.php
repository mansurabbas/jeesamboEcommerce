<?php
// This include session, connection and functions
include "top.php";
?>
<?php
// if (isset($_SESSION["username"])) {
//     header("location: index");
//     exit();
// }
?>
<?php
$cartOutput = "";
$cartTotal = "";
$pid = '';
$id = '';
$image = '';
$newname = "";
$each_item = "";
?>
<?php
if (isset($_SESSION["cart_array"]) || count($_SESSION["cart_array"]) > 0) {
	// Start the For Each loop
	$i = 0;
    foreach ($_SESSION["cart_array"] as $each_item) {
		$item_id = clean($conn,$each_item['item_id']);
		$sql = mysqli_query($conn, "SELECT * FROM products WHERE id='$item_id' AND status = 1 ORDER BY date_added DESC LIMIT 1");
		while ($row = mysqli_fetch_array($sql)) {
			$product_name = $row["product_name"];
			$price = (int)$row["price"];
			$details = $row["details"];
			$image = $row["image"];
		}

		$pricetotal = (int)$price * $each_item['quantity'];
		$cartTotal = $pricetotal + (int)$cartTotal;
		setlocale(LC_MONETARY, "en_US");
        $pricetotal = number_format($pricetotal, 2);
	}

}
mysqli_close($conn);
 ?>

<?php
// sanitize from inputs from users
$sanitizer = filter_var_array($_POST, FILTER_SANITIZE_STRING);
$first_name = '';
$product_name = '';
// collect user's inputs from the form into regular define_syslog_variables
$first_name = $sanitizer['first_name'];
$address = $sanitizer['address'];
$phone = $sanitizer['phone'];
$email = $sanitizer['email'];
$product_name = $product_name;
// Make sure all fields are filled in
if (isset($first_name) || isset($address) || isset($phone) || isset($email)) {
	if (!empty($first_name) || !empty($address) || !empty($phone) || !empty($email)) {
	$_SESSION['first_name'] = $first_name;
	$_SESSION['address'] = $address;
	$_SESSION['phone'] = $phone;
	$_SESSION['email'] = $email;
	$_SESSION['product_name'] = $product_name;
	$_SESSION['carttotal'] = $cartTotal;
	$final_amount = $_SESSION['carttotal'] * 100;


	}

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Order_confirm</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="container">
	<div class="container" >

      <div class="row">
          <div class="col-2">
			  <p>Phone: <?php echo $_SESSION['phone']; ?></p>
              <p>Email: <?php echo $_SESSION['email']; ?></p>
              <p>Address: <?php echo $_SESSION['address']; ?></p>
              <span>
				  <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image;?>" width="200px" height="200px" />
			  </span>
			  <form>
			  <script src="https://js.paystack.co/v1/inline.js"></script>
			  <button type="button" class="stack-btn " onclick="payWithPaystack()"> Pay </button>
			  </form>

			  <script>
			  function payWithPaystack(){
			  var handler = PaystackPop.setup({
			    key: 'pk_test_e7784477c3bb99f8dcb7dbc5746f34f66dcb6a74',
			    email: '<?php echo $_SESSION['email']; ?>',
			    amount: <?php echo $final_amount; ?>,
				firstname: "<?php echo $_SESSION['first_name']; ?>",
				phone: "<?php echo $_SESSION['phone']; ?>",
			    ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
			    metadata: {
			  	 custom_fields: [
			  		{
			  			display_name: "<?php echo $_SESSION['first_name']; ?>",
			  			variable_name: "mobile_number",
			  			value: "<?php echo $_SESSION['phone']; ?>",
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

      </div>

    </div>
</div>

<!--------------------------footer ---------------------- -->
<?php include('footer.inc.php'); ?>

<script>
  var LoginForm = document.getElementById("LoginForm");
  var RegForm = document.getElementById("RegForm");
  var Indicator = document.getElementById("Indicator");

      function register() {
        RegForm.style.transform = "translateX(0px)";
        LoginForm.style.transform = "translateX(0px)";
        Indicator.style.transform = "translateX(100px)";
      }
      function login() {
        RegForm.style.transform = "translateX(300px)";
        LoginForm.style.transform = "translateX(300px)";
        Indicator.style.transform = "translateX(0px)";
      }
</script>

</body>
</html>
