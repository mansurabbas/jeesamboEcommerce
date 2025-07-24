
<!------------------------ Account Page  ------------------->
<div class="account-page">
    <div class="container">
        <div class="row">
        
                <div class="form-container" id="form-container">
                            <div class="form-btn">
                            <span onclick="login()">Login</span>
                            <span onclick="register()">Rigister</span>
                            <hr id="Indicator">
                            </div>
                            <!-- Login Form -->

                            <form id="LoginForm" style="width:100%" autocomplete="off">
                                <div class="login_first_box">
                                <input type="text" name="login_email" id="login_email" placeholder="Email" class="login-input" autocomplete="off" autofocus>
                                
                                </div>
                                <div class="login_first_box">
                                <input type="password" name="login_password" id="login_password" placeholder="Password" class="login-input"autocomplete="off" >
                                </div>
                                <div class="login_first_box">
                                <button type="button" class="reg_btn login" onclick="send_login_otp()">Login</button>
                                </div>
                                
                                 <div class="login_second_box">
                                    <input type="text" id="login_otp" placeholder="OTP" class="login-input" autocomplete="off" autofocus>
        
                                  <span id="login_otp_error" class="field_error"></span>
                                  </div>
                                  <div class="login_second_box">
                                      <button type="button" id="log_otp_btn" class="reg_btn" onclick="login_submit_otp()">Submit OTP</button>
                                      <span id="login_email_otp_result"></span>
                                  </div>
                                <a href="<?php echo SITE_PATH?>reset_password" class="forgot_password">Forgot Password</a>
                                
                            </form>
                            
                            
                            
                            <!-- // Login Form -->
                            <div class="form-output login_msg">
                            </div>
                            <!-- Registration Form -->
                            <form id="RegForm" style="width:100%" autocomplete="off">
                            <div class="first_box">
                                <input type="text" name="reg_firstname" id="reg_firstname" placeholder="Firstname Lastname" class="login-input" autocomplete="off" autofocus>
                            </div>
                            <div class="first_box">
                                <input type="email" name="reg_email" id="reg_email" placeholder="Email" class="login-input" autocomplete="off">
                            </div>
                            <div class="first_box">
                                <input type="text" name="reg_username" id="reg_username" placeholder="Username" class="login-input" autocomplete="off">
                            </div>
                            <div class="first_box">
                                <input type="password" name="reg_password" id="reg_password" placeholder="Password" class="login-input" autocomplete="off">
                            </div>
                            <div class="first_box">
                                <!-- <input type="submit" name="reg_submit" class="reg_btn" value="Register"> -->
                                <button type="button" id="register_submit" class="reg_btn" onclick="send_otp()">Register</button>
                                
                            </div>

                          <!-- <div class="second_box">
                          <input type="text" id="otp" placeholder="OTP" class="login-input">

                          <span id="otp_error" class="field_error"></span>
                          </div>
                          <div class="second_box">
                              <button type="button" id="reg_otp_btn" class="reg_btn" onclick="submit_otp()">Submit OTP</button>
                              <span id="email_otp_result"></span>
                          </div> -->
                          <div id="reg_form_msg"></div>
                            </form>
                            
                            <!-- // Registration Form -->
                </div>
        </div>
    </div>
</div>

</div>
<style>
.second_box{display:none;}
.field_error{color:red;}

.login_second_box{display:none;}
.field_error{color:red;}
</style>

<script>
function send_otp(){
	var reg_firstname=jQuery('#reg_firstname').val();
	var reg_email=jQuery('#reg_email').val();
	var reg_username=jQuery('#reg_username').val();
	var reg_password=jQuery('#reg_password').val();
	jQuery('#register_submit').attr('disabled', true);
    jQuery('#login_loader').show();

	jQuery.ajax({
		url:'register_submit.php',
		type:'post',
		data:'reg_firstname='+reg_firstname+'&reg_email='+reg_email+'&reg_password='+reg_password+'&reg_username='+reg_username,
		success:function(result){
            var result = result.trim();
            jQuery('#reg_form_msg').html('');
            jQuery('#register_submit').attr('disabled', false);
            jQuery('#login_loader').hide();
			if(result=='yes'){
                login();
                swal({
                title: "Verification email sent",
                text: "Verification email sent to "+reg_email,
                successMode: true,
                })
			}
			if(result=='user_exist'){
                swal({
                title: "Email is taken!",
                text: "This email have an account with us.",
                icon: "warning",
                dangerMode: true,
                })
			}
			if(result=='not_exist'){
                swal({
                title: "Account not exist",
                text: "Please enter correct email ID",
                icon: "warning",
                dangerMode: true,
                })
			}
		}
	});
}

function send_login_otp(){
	var login_email=jQuery('#login_email').val();
	var login_password=jQuery('#login_password').val();
    jQuery('#login_loader').show();
    jQuery('.login').attr('disabled', true);
	jQuery.ajax({
		url:'login_submit.php',
		type:'post',
		data:'login_email='+login_email+'&login_password='+login_password,
		success:function(result){

            jQuery('#login_loader').hide();
            jQuery('.login').attr('disabled', false);
                if(result=='not_exist'){
                    swal({
                    title: "Email error",
                    text: "Enter correct email ID",
                    icon: "warning",
                    dangerMode: true,
                    })
                }
                if(result=='not_verify'){
                    swal({
                    title: "Comfirmation",
                    text: "Please verify your Email",
                    icon: "warning",
                    dangerMode: true,
                    })
                }
                if(result=='deactivated'){
                    swal({
                    title: "Deactivated",
                    text: "Your account has been deactivated",
                    icon: "warning",
                    dangerMode: true,
                    })
                }
                if(result=='incorrect_password'){
                    swal({
                    title: "Incorrect password",
                    text: "Please enter correct password",
                    icon: "warning",
                    dangerMode: true,
                    })
                }
                if(result=='yes'){

                    jQuery('.login_second_box').show();
                    jQuery('.login_first_box').hide();
                    swal("An OTP was sent to "+login_email);  
                }
                if(result=='no'){
                    window.location.href="<?php echo SITE_PATH?>signing_in";
                }
		}
	});
}

function submit_otp(){
	var otp=jQuery('#otp').val();
    jQuery('#reg_otp_btn').attr('disabled', true);
    jQuery('#login_loader').show();
	jQuery.ajax({
		url:'check_otp.php',
		type:'post',
		data:'otp='+otp,
		success:function(result){
            jQuery('#reg_otp_btn').attr('disabled', false);
            jQuery('#login_loader').hide();
			if(result=='yes'){
                login()
			}
			if(result=='not_exist'){
				swal({
                title: "OTP Error!",
                text: "Please enter valid otp",
                icon: "warning",
                dangerMode: true,
                })
			}
		}
	});
}

function login_submit_otp(){
	var login_otp=jQuery('#login_otp').val();
    jQuery('#log_otp_btn').attr('disabled', true);
    jQuery('#login_loader').show();
	jQuery.ajax({
		url:'login_check_otp.php',
		type:'post',
		data:'login_otp='+login_otp,
		success:function(result){
            
           var result = result.trim();
            jQuery('#log_otp_btn').attr('disabled', false);
            jQuery('#login_loader').hide();
			if(result=='yes'){
                window.location.href="<?php echo SITE_PATH?>auth";
			}
			if(result=='not_exist'){
                
				swal({
                title: "OTP Error!",
                text: "Please enter valid otp",
                icon: "warning",
                dangerMode: true,
                })
			}
		}
	});
}
</script>



