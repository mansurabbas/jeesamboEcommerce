<?php
session_start();
include("storescripts/connect_to_mysql.php");
include("admin/functions.php");

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);
?>
<?php




$check_user=mysqli_num_rows(mysqli_query($con,"select * from users where email='$email'"));
$check_mobile=mysqli_num_rows(mysqli_query($con,"select * from users where mobile='$mobile'"));
if($check_user>0){
	echo "email_present";
}elseif($check_mobile>0){
	echo "mobile_present";
}else{
	$added_on=date('Y-m-d h:i:s');
	mysqli_query($con,"insert into users(name,email,mobile,password,added_on) values('$name','$email','$mobile','$password','$added_on')");
	echo "insert";
}
?>



