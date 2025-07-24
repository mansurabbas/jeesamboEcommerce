<?php
// This include session, connection and functions
require_once('top.php');
?>
<?php
if(!isset($_SESSION['USER_LOGIN'])){
	?>
	<script>
	window.location.href='<?php echo SITE_PATH?>index';
	</script>
	<?php
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Change Email</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


</head>
<body>
<div class="content">

<!-- Change Email -->
<div class="account-page">
    <div class="container">
        <div class="row">
                
                <div class="form-container" style="height: 250px">
                            <div class="form-btn">
                            <h1 onclick="register()">Change Email</h1>
                            </div>
                            <div class="form-output login_msg">
                            </div>
                            <form action="update_email.php" id="RegForm" method="POST">
                                <input type="text" name="email" id="email" placeholder="Email" class="login-input" value="<?php echo $_SESSION['LOGIN_EMAIL']?>">
                                <span class="field_error" id="email_error"></span>
                                <button type="button" class="log_btn" onclick="update_email()" id="btn_submit">Update Email</button>
                            </form>          
                </div> 
                <input type="hidden" name="" id="is_email_verified">  
        </div>
    </div>
</div>
</div>
</div>
        
  
  <!-- // Change Email -->


<!--------------------------footer ---------------------- -->
<?php include('footer.inc.php'); ?>
<!--------------------------js for toggle menu  ------------------>

<script>
function update_email(){
			jQuery('.field_error').html('');
			var email=jQuery('#email').val();
			if(email==''){
				jQuery('#email_error').html('Please enter your email');
			}else{
				jQuery('#btn_submit').html('Please wait...');
				jQuery('#btn_submit').attr('disabled',true);
				jQuery.ajax({
					url:'update_email.php',
					type:'post',
					data:'email='+email,
					success:function(result){
						jQuery('#email_error').html(result);
						jQuery('#btn_submit').html('Update');
						jQuery('#btn_submit').attr('disabled',false);
					}
				})
			}
		}
</script>

<!-- Load th CDN First -->
<script src="//code.jquery.com/jquery-3.6.3.js"></script>
<!-- If the CDN fails to load, serve up the local version -->
<script>window.jQuery || document.write('<script src="js/jquery-3.6.3.js"><\/script>');</script>
<script src="js/custom.js"></script>

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
