<?php include_once('top.php') ?>

<?php
if(!isset($_SESSION['USER_LOGIN'])){
	$_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
	redirect('login');
}
$getUserDetails=getUserDetailsByid();
?>

<?php 
if(!isset($_SESSION['USER_LOGIN'])){
	?>
	<script>
	window.location.href='<?php echo SITE_PATH?>index';
	</script>
	<?php
}

$uid=$_SESSION['USER_ID'];

$res=mysqli_query($conn,"SELECT products.product_name,products.image,product_attributes.price,products.id as pid,wishlist.id FROM products,wishlist,product_attributes WHERE wishlist.product_id=products.id AND products.id=product_attributes.id AND wishlist.user_id='$uid'") or die("Error:". mysqli_error($conn));

if (isset($_SESSION['USER_ID'])) {
    $uid=$_SESSION['USER_ID'];
}
$order_sql=mysqli_query($conn,"SELECT * FROM `order` WHERE user_id='$uid'") or die("Error:". mysqli_error($conn));
while($row=mysqli_fetch_assoc($order_sql)){
    $order_id=$row['id'];
}
?>

<body id="index">
    
    
    <div class="content">
    <div class="account-wrapper">
            <br>
            <h1 class="referral-code">
                Referral Code: <?php echo $getUserDetails['referral_code'] ?>
            </h1>
            <br>
                <h1 for="referral Link" class="referal-label">Referral Link: </h1>
                <input type="text" readonly name="referralLink" id="referralLink" value="<?php echo SITE_PATH?>login?referral_code=<?php echo $getUserDetails['referral_code']?>">
                <button onclick="copyToClipboard()" id="copyClipBtn">Copy</button>
                <p id="copySuccess">Copied!</p>
                
        <!--<h1>Your Account</h1>-->
    <div class="card-wrap">
                <a href="<?php echo SITE_PATH?>my_order?id=<?php echo $uid?>" id="anchor">
                
                    <div class="a_logo">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="a_desc">
                        <span id="card_header">Your Orders</span>
                        <div class="a_content">
                            <span>View Your Orders</span>
                        </div>
                    </div>
                
                </a>
                <a href="" id="anchor">
                
                    <div class="a_logo">
                        <i class="fas fa-user-lock"></i>
                    </div>
                    <div class="a_desc">
                        <span id="card_header">Your Profile</span>
                        <div class="a_content">
                            <span>Manage Profile</span>
                        </div>
                    </div>
                
                </a>
                <a href="<?php echo SITE_PATH?>security?id=<?php echo $uid?>" id="anchor">
                
                    <div class="a_logo">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="a_desc">
                        <span id="card_header">Login and Security</span>
                        <div class="a_content">
                            <span>Edit Phone number, name and login</span>
                        </div>
                    </div>
                
                </a>
                <a href="javascript:void(0)" id="anchor">
                
                    <div class="a_logo">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="a_desc">
                        <span id="card_header">2FA</span>
                        <div class="a_content">
                            <span>
                                <select name="two_factor[]" id="two_factor" onchange="two_factor()" style="padding:.3rem .0rem; width: 60px">
                                    <?php 
                                        $twoFactor='';
                                        if(!isset($_GET['twoFactor'])){
                                            $twoFactor = $_GET['twoFactor'];
                                
                                        }
                                        
                                        $res=mysqli_query($conn,"SELECT two_factor FROM users WHERE email='".$_SESSION["LOGIN_EMAIL"]."' AND id='$uid'");
                                        $row=mysqli_fetch_assoc($res);
                                        
                                        $selected = '';
                                        if ($twoFactor == $row['two_factor']) {
                                            $selected = "selected";
                                        }
                                        
                                    ?>
                                    <?php if ($row['two_factor'] == 'Off') {
                                        ?>
                                            <option value="Off" <?php echo $selected ?>>Off</option>
                                            <option value="On">On</option>
                                        <?php
                                    }elseif ($row['two_factor'] == 'On') {
                                        ?>
                                    
                                    <option value="On" <?php echo $selected ?>>On</option>
                                    <option value="Off">Off</option>
                                        <?php } ?>
                                </select>
                                
                                <input type="hidden" id="uid" value="<?php echo $uid ?>">
                            </span>
                        </div>
                    </div>
                
                </a>
                <!-- <div class="a_card">
                    <div class="a_logo">
                        <span><i class="fab fa-cc-mastercard"></i></span>
                    </div>
                    <div class="a_desc">
                        <h2>Your Payment</h2>
                        <div class="a_content">
                            <span>Manage payment</span>
                        </div>
                    </div>
                </div> -->
    </div>
    </div>
    </div>
  
    <?php include('footer.inc.php'); ?>
    <script src="js/custom.js"></script>

<script>
    function copyToClipboard() {
        // Select the text to copy
        var copyText = document.getElementById("referralLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the selected text
        document.execCommand("copy");

        // Optional: Deselect the text
        copyText.blur();
    }

    async function copyToClipboard() {
      var copyText = document.getElementById("referralLink").value;

      try {
        await navigator.clipboard.writeText(copyText);
        showCopySuccessMessage();
      } catch (err) {
        console.error("Unable to copy text to clipboard", err);
      }
    }

    function showCopySuccessMessage() {
      var copySuccessMessage = document.getElementById("copySuccess");
      copySuccessMessage.style.display = "block";

      setTimeout(() => copySuccessMessage.style.display = "none", 2000);
    }
</script>

<script>
    function two_factor(){
        
	var two_factor = jQuery('#two_factor').val();
	var uid = jQuery('#uid').val();
    
	jQuery.ajax({
		url:'two_factor.php',
		type:'post',
		data:'two_factor='+two_factor+'&uid='+uid,
		success: function(result){
            //jQuery('#two_factor').attr('selected', 'selected');
            jQuery('#two_factor').val(result);
            window.location.href="<?php echo SITE_PATH?>profile?twoFactor="+result;
		}
	});
}
</script>

</body>
</html>