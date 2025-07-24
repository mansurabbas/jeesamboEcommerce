<?php include_once('top.php') ?>
<?php
$firstname = '';
$email = '';
$password = '';
?>
<?php
    if(!isset($_SESSION['USER_LOGIN'])){
        $_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
        redirect('login');
    }
?>
<?php
$uid=$_SESSION['USER_ID'];
$user_sql="SELECT * FROM users WHERE id='$uid' ";
$user_sql=mysqli_query($conn,$user_sql);

$existCount = mysqli_num_rows($user_sql); // count the row nums
if ($existCount > 0) { // evaluate the count
         while ($row = mysqli_fetch_assoc($user_sql)) {
                $firstname = $row['firstname'];
                $email = $row['email'];
                $password = $row['password'];
         }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security</title>
</head>
<body>


    <div class="content">
    <div class="security-wrapper">
    <span>Your Account</span>
            <div class="s-wrap">
                    <div class="s-card">
                        <div class="left">
                                <h1>Name:</h1>
                                <p style="word-wrap:break-word"><?php echo $firstname?></p>
                        </div>
                        <div class="right">
                                <a href="<?php echo SITE_PATH?>change_name?id=<?php echo $uid?>">Edit</a>
                        </div>
                    </div>
                    <div class="s-card">
                        <div class="left">
                                <h1>Email</h1>
                                <p style="word-wrap:break-word"><?php echo $email?></p>
                        </div>
                        <div class="right">
                                <a href="<?php echo SITE_PATH?>change_email?id=<?php echo $uid?>">Edit</a>
                        </div>
                    </div>
                    <div class="s-card">
                        <div class="left">
                                <h1>Password:</h1>
                                <p style="word-wrap:break-word"><?php echo $password?></p>
                        </div>
                        <div class="right">
                                <a href="<?php echo SITE_PATH?>change_password?id=<?php echo $uid?>">Edit</a>
                        </div>
                    </div>
            </div>
    </div>
    </div>



    <?php include('footer.inc.php'); ?>
    <script src="js/custom.js"></script>
    
    <script>
        var loader = document.getElementById("preloader");
        window.addEventListener("load", function(){
            loader.style.display = "none";
        })
</script>
</body>
</html>