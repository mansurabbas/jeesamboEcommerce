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
                            <p>An email will be send to you with instructions on how to reset your password</p>
                            </div>
                           
                            <form action="reset_request.php" id="forgetPass" method="POST">
                            <input type="text" name="email" class="login-input" placeholder="Enter your email*"> 
                            <button type="submit" name="reset-request-submit" class="log_btn" id="btn_submit">Reset password</button>

                                <?php
                                    if(isset($_GET["reset"])){
                                        if ($_GET["reset"] == "success") {
                                            echo  '<p class="signupsuccess">Check your email</p>';
                                        }
                                    }
                                ?>
                                
                            </form><br><br>
                            
                               
                </div>
                            
            
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
