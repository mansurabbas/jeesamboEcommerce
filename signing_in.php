<?php
session_start();
include("storescripts/connect_to_mysql.php");
include("admin/functions.php");

$email=$_SESSION['LOGIN_EMAIL'];

$sql=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
$count=mysqli_num_rows($sql);
if($count>0){

    $row = mysqli_fetch_array($sql);
    $user_id = $row["id"];
    $dbfirstname = $row["firstname"];
    $dbemail = $row["email"];
    $dbpassword = $row["password"];
    
    $time=time()+10;
    mysqli_query($conn,"UPDATE users SET last_login='$time' WHERE email='$email' AND id='$user_id'");
        	
}

$_SESSION['IS_LOGIN']= TRUE;
$_SESSION['LOGIN_EMAIL']=$dbemail;
$_SESSION["PASSWORD"] = $dbpassword;
$_SESSION["FIRSTNAME"] = $dbfirstname;
$_SESSION['LOGIN_USERNAME']=$dbfirstname;
$_SESSION["USER_ID"] = $user_id;
$_SESSION['USER_LOGIN'] = TRUE;

redirect('auth');

?>