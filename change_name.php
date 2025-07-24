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
  <title>Change Name</title>
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
                            <h1 onclick="register()">Change Name</h1>
                            </div>
                            <div class="form-output login_msg">
                            </div>
                            <form action="update_email.php" id="RegForm" method="POST">
                                <input type="text" name="name" id="name" class="login-input" placeholder="Your Name*" style="width:100%" value="<?php echo $_SESSION['FIRSTNAME']?>"> 
                                <span class="field_error" id="name_error"></span>
                                <button type="button" class="log_btn" onclick="update_name()" id="btn_submit">Update Name</button>
                            </form>          
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
function update_name(){
			jQuery('.field_error').html('');
			var name=jQuery('#name').val();
			if(name==''){
				jQuery('#name_error').html('Please enter your name');
			}else{
				jQuery('#btn_submit').html('Please wait...');
				jQuery('#btn_submit').attr('disabled',true);
				jQuery.ajax({
					url:'update_name.php',
					type:'post',
					data:'name='+name,
					success:function(result){
						jQuery('#name_error').html(result);
						jQuery('#btn_submit').html('Update');
						jQuery('#btn_submit').attr('disabled',false);
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
