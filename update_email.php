<?php
// This include session, connection and functions
session_start();
include("storescripts/connect_to_mysql.php");
include("admin/functions.php");

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

?>
<?php
if(!isset($_SESSION['USER_LOGIN'])){
	?>
	<script>
	window.location.href='<?php echo SITE_PATH?>index';
	</script>
	<?php
}

$email=clean($conn,$_POST['email']);
$uid=$_SESSION['USER_ID'];
mysqli_query($conn,"UPDATE users SET email='$email' WHERE id='$uid'");
$_SESSION['EMAIL']=$email;
echo "Your email updated";

?>
