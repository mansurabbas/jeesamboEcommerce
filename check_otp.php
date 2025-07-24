<?php
session_start();
include("storescripts/connect_to_mysql.php");

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

$otp=clean($_POST['otp']);
$reg_email=$_SESSION['EMAIL'];
$reg_password=$_SESSION['REG_PASSWORD'];

$res=mysqli_query($conn,"SELECT * FROM users WHERE email='$reg_email' AND otp='$otp'");
$count=mysqli_num_rows($res);
if($count>0){
    
    
    
    $_SESSION["USER_ID"] = $user_id;
	mysqli_query($conn,"UPDATE users SET otp='' WHERE email='$reg_email'");
	$_SESSION['IS_LOGIN']=$reg_email;
	echo "yes";
}else{
	echo "not_exist";
}
?>