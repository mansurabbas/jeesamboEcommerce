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
  <title>Reset Password</title>
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
                            <h1 onclick="register()">Reset Password</h1>
                            </div>
                            
                            <?php
                            $selector = clean($conn, $_GET['selector']);
                            $validator = clean($conn, $_GET['validator']);
                            
                            if(empty($selector) || empty($validator)){
                                
                            } else {
                                if(ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false ) {
                                    ?>
                                    
                                    <form action="create_new_password_submit.php" id="forgetPass" method="post">
                                        <input type="hidden" name="selector" value="<?php echo $selector ?>" class="login-input"></input>
                                        <input type="hidden" name="validator" value="<?php echo $validator ?>" class="login-input"></input>
                                        <input type="password" name="password" placeholder="Enter a new password..." class="login-input"></input>
                                        <input type="password" name="password-repeat" placeholder="Repeat new password..." class="login-input"></input>
                                        <button type="submit" name="reset-password-submit" class="log_btn" id="btn_submit">Reset Password</button>
                                    </form><br><br>
                                    
                                    <?php
                                }
                            }
                            ?>
                                    
                </div>
                <input type="hidden" name="" id="is_email_verified">  
        </div>
    </div>
</div>
</div>
</div>


<!--------------------------footer ---------------------- -->
<?php include('footer.inc.php'); ?>

<script src="js/custom.js"></script>
</body>
</html>
