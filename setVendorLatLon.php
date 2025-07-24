<?php

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

session_start();
if(isset($_POST['vendorlat']) && isset($_POST['vendorlon'])){
	$_SESSION['vendorlat']=$_POST['vendorlat'];
	$_SESSION['vendorlon']=$_POST['vendorlon'];
}
?>