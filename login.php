<?php
session_start();
session_regenerate_id();
include("../storescripts/connect_to_mysql.php");
require("functions.php");
$msg='';

if(isset($_SESSION['ADMIN_LOGIN'])){
    redirect('index');
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" type="image/png" href="../icons/favicon.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Admin</title>
<!-- <link rel="stylesheet" href="style.css" type="text/css" media="screen" /> -->
</head>

<body>
	        <div id="login_loader" style="display:none;position: absolute;top: 20%; left:37%; z-index:5"><img src="../icons/loader2.gif" style="background-color: #f5f6f8" width="80%" height="400px"></div>

	<div class="template-container">
        <div class="template-wrapper">
            <div class="company-info">
                <h3>Admin Login</h3>
            </div>
            <div class="contact">
                <h3></h3>
                <span></span>
                <?php //$_SESSION['token'] = uniqid(md5(microtime()), true); ?> 
                <form method="POST" autocomplete="off">
                    <p class="first_box">
                        <label>Email Address</label>
                        <input type="email" id="email" required autocomplete="off" style="box-sizing: border-box" >
                        <!-- <input type="hidden" id="token" value="<?php //echo $_SESSION['token'] ?>" /> -->
                    </p>
                    <p class="first_box">
                        <label>Password</label>
                        <input type="password" id="password" style="box-sizing: border-box" required autocomplete="off">
                    </p>
                    <p class="submit-btn first_box" >
                        <button type="button" id="submit_btn" class="button-submit" onclick="send_otp()">Login</button>
                        
                    </p>
                    
                    <p class="submit-btn second_box">
                        <input type="text" id="otp" placeholder="One Time Password (OTP)" class="login-input" style="box-sizing: border-box" autocomplete="off">
                        <span id="otp_error" class="field_error"></span>
                    </p>
                    <p class="submit-btn second_box">
                        <button type="button" id="otp_btn" class="button-submit" onclick="submit_otp()">Submit OTP</button>
                        <span id="email_otp_result"></span>
                    </p>
                    <p>
                    <div id="form_msg" class="result email_error" style="color: red; width:100%"></div>
                        <a href="reset_password.php">Forget Password</a>
                    </p>
                    
                </form>
                By continuing you agree to the Jeesambo`s <a href="https://jeesambo.com.ng/admin/condition">Acceptable use and privacy policy</a>
                            
                <?php
            	    if(isset($_GET["newpwd"])){
                        if ($_GET["newpwd"] == "passwordupdated") {
                            echo '<p class="signupsuccess">Your password has been reset</p>';
                        }
                    }
        	    ?>
            </div>

        </div>
    </div>

			<!--form area end-->

			<script type="text/javascript">
			$('.options-02 a').click(function(){
				$('form').animate({
					height: "toggle", opacity: "toggle"
				}, "slow");
			});
			</script>
			<script type="text/javascript">
			
			function send_otp(){
                	var email=jQuery('#email').val();
                	var password=jQuery('#password').val();
                    jQuery('#submit_btn').attr('disabled', true);
                    jQuery('#login_loader').show();

                	jQuery.ajax({
                		url:'login_submit.php',
                		type:'post',
                		data:'email='+email+'&password='+password,
  
                		success:function(result){
                            jQuery('#submit_btn').attr('disabled', false);
                            jQuery('#login_loader').hide();
                            console.log(result);
                			if(result=='yes'){
                				jQuery('.second_box').show();
                				jQuery('.first_box').hide();
                			}
                			if(result=='not_exist'){
                			    
                				swal({
                                title: "Error!!",
                                text: "Please enter correct email",
                                icon: "warning",
                                dangerMode: true,
                                })
                			}
                			if(result=='incorrect_password'){
				                swal({
                                title: "Error!!",
                                text: "Please enter correct password",
                                icon: "warning",
                                dangerMode: true,
                                })
			                }
                			if(result=='deactivated'){
                				swal({
                                title: "Error!!",
                                text: "Your account has been deactivated",
                                icon: "warning",
                                dangerMode: true,
                                })
                			}
                		}
                	});
            }
            
            function submit_otp(){
                	var otp=jQuery('#otp').val();
                    jQuery('#otp_btn').attr('disabled', true);
                    jQuery('#login_loader').show();
                	jQuery.ajax({
                		url:'check_otp.php',
                		type:'post',
                		data:'otp='+otp,
                		success:function(result){
                            jQuery('#otp_btn').attr('disabled', false);
                            jQuery('#login_loader').hide();
                			if(result=='yes'){
                                window.location.href='index';
                			}
                			if(result=='not_exist'){
                			    
                				jQuery('#otp_error').html('Please enter valid otp');
                			}
                		}
                	});
            }
			</script>

<script src="../js/custom.js"></script>
</body>
</html>
