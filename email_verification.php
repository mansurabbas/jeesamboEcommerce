<?php
// This include session, connection and functions
require_once("top.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Email Verification</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    .second_box{display:none;}
    .field_error{color:red;}
  </style>
</head>
<body>
<div class="content">

<div class="account-page">
    <div class="container">
        <div class="row">
                
            <div class="form-container">
                  <div class="form-btn">
                  <h2>Email verification</h2>
                  </div>
                  <div class="form-output login_msg">
                  </div>
                  <!-- Email Verification -->
                  <?php $script_name = $_SERVER['SCRIPT_NAME']; ?>
                  <form id="RegForm" method="POST" style="width:100%">
                      <div class="first_box">
                          <input type="email" name="email" id="email" placeholder="Email" class="login-input" style="width:100%">
                          <span id="email_error" class="field_error"></span>
                      </div>
                      <div class="first_box">
                          <button type="button" class="email_sent_otp" onclick="send_otp()" style="width:100%">Send OTP</button>
                      </div>
                      <div class="second_box">
                          <input type="text" id="otp" placeholder="OTP" style="width:100%">
                          <span id="otp_error" class="field_error"></span>
                      </div>
                      <div class="second_box">
                          <button type="button" onclick="submit_otp()" style="width:100%">Submit OTP</button>
                          <span id="email_otp_result"></span>
                      </div>
                  </form>
                  <!-- // Email Verification -->
            </div>
        </div>
    </div>
</div>
</div>
<!-- <input type="hidden" id="is_phone_verified"/> -->
<input type="hidden" id="is_email_verified"/>
<script>
function send_otp(){
	var email=jQuery('#email').val();
	jQuery.ajax({
		url:'send_otp.php',
		type:'post',
		data:'email='+email,
		success:function(result){
			if(result=='yes'){
				jQuery('.second_box').show();
				jQuery('.first_box').hide();
			}
			if(result=='not_exist'){
				jQuery('#email_error').html('Please enter valid email');
			}
		}
	});
}

function submit_otp(){
	var otp=jQuery('#otp').val();
	jQuery.ajax({
		url:'check_otp.php',
		type:'post',
		data:'otp='+otp,
		success:function(result){
			if(result=='yes'){
				window.location='index.php'
			}
			if(result=='not_exist'){
				jQuery('#otp_error').html('Please enter valid otp');
			}
		}
	});
}
</script>

	</div>
<!--------------------------footer ---------------------- -->
<?php include('footer.inc.php'); ?>

<!--------------------- js for toggle form ---------------------------------------->
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

<!-- Load th CDN First -->
<script src="//code.jquery.com/jquery-3.5.1.js"></script>
<!-- If the CDN fails to load, serve up the local version -->
<script>window.jQuery || document.write('<script src="js/jquery-3.5.1.js"><\/script>');</script>
<script src="js/custom.js"></script>
</body>
</html>
