<?php
// This include session, connection and functions
require_once('top.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Change Password</title>
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
                
                <div class="form-container">
                            <div class="form-btn">
                            <h1 onclick="register()">Change Password</h1>
                            </div>
                            <div class="form-output login_msg">
                            </div>
                            <form action="" id="frmPassword" id="RegForm" method="POST">
                            <!--<label class="password_label">Current Password</label>-->
                            <input type="password" name="current_password" id="current_password" placeholder="Current Password" class="login-input" style="width:100%"> <br>
                            <span class="field_error" id="current_password_error"></span>
                            <!--<label class="password_label">New Password</label>-->
                            <input type="password" name="new_password" id="new_password" placeholder="New Password" class="login-input" style="width:100%"> <br>
                            <span class="field_error" id="new_password_error"></span>
                            <!--<label class="password_label">Confirm New Password</label>-->
                            <input type="password" name="confirm_new_password" id="confirm_new_password" placeholder="Confirm New Password" class="login-input" style="width:100%"> <br>
                            <span class="field_error" id="confirm_new_password_error"></span>
                            <button type="button" class="log_btn" onclick="update_password()" id="btn_update_password">Update Password</button>
                            </form><br><br>
                            <span class="field_error" id="email_error"></span>
                            <div class="form-output login_msg">
                                <p class="form-messege field_error"></p>
                            </div>        
                                    </div> 
                                    <input type="hidden" name="" id="is_email_verified"> 
                            </div>
    </div>
</div>
</div>
</div>



<!--------------------------footer ---------------------- -->
<?php include('footer.inc.php'); ?>
<!--------------------------js for toggle menu  ------------------>
<script>
  var MenuItems = document.getElementById("MenuItems");
  MenuItems.style.maxHeight = "0px";

  function menutoggle() {
    if(MenuItems.style.maxHeight = "0px") {
      MenuItems.style.maxHeight = "200px"
    } else {
      MenuItems.style.maxHeight = "0px";
    }
  }
</script>
<script>
function update_password(){
			jQuery('.field_error').html('');
			var current_password=jQuery('#current_password').val();
			var new_password=jQuery('#new_password').val();
			var confirm_new_password=jQuery('#confirm_new_password').val();
			var is_error='';
			if(current_password==''){
				jQuery('#current_password_error').html('Please enter password');
				is_error='yes';
			}if(new_password==''){
				jQuery('#new_password_error').html('Please enter password');
				is_error='yes';
			}if(confirm_new_password==''){
				jQuery('#confirm_new_password_error').html('Please enter password');
				is_error='yes';
			}
			
			if(new_password!='' && confirm_new_password!='' && new_password!=confirm_new_password){
				jQuery('#confirm_new_password_error').html('Please enter same password');
				is_error='yes';
			}
			
			if(is_error==''){
				jQuery('#btn_update_password').html('Please wait...');
				jQuery('#btn_update_password').attr('disabled',true);
				jQuery.ajax({
					url:'update_password',
					type:'post',
					data:'current_password='+current_password+'&new_password='+new_password,
					success:function(result){
						jQuery('#current_password_error').html(result);
						jQuery('#btn_update_password').html('Update');
						jQuery('#btn_update_password').attr('disabled',false);
						jQuery('#frmPassword')[0].reset();
					}
				})
			}
			
		}
		</script>


<!-- Load th CDN First -->
<script src="//code.jquery.com/jquery-3.5.1.js"></script>
<!-- If the CDN fails to load, serve up the local version -->
<script>window.jQuery || document.write('<script src="js/jquery-3.5.1.js"><\/script>');</script>
<script src="js/custom.js"></script>
</body>
</html>
