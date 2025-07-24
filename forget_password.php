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
  <title>Forgot Password</title>
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
                            <h1 onclick="register()">Forgot Password</h1>
                            </div>
                           
                            <form action="" id="forgetPass" method="POST">
                            <input type="text" name="email" id="email" class="login-input" placeholder="Enter your email*"> 
                            <button type="button" class="log_btn" onclick="forget_password()" id="btn_submit">Submit</button>
                            <span class="field_error" id="email_error"></span>
                            </form><br><br>
                            
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
<script>
function forget_password(){
    jQuery('#email_error').html('');
    var email=jQuery('#email').val();
    if(email==''){
        jQuery('#email_error').html('Please enter email id');
    }else{
        jQuery('#btn_submit').html('Please wait...');
        jQuery('#btn_submit').attr('disabled',true);
        jQuery.ajax({
            url:'forget_password_submit.php',
            type:'post',
            data:'email='+email,
            success:function(result){
                jQuery('#email').val('');
                jQuery('#email_error').html(result);
                jQuery('#btn_submit').html('Submit');
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
</body>
</html>
