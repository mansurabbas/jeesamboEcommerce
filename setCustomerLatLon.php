<?php

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

session_start();
if(isset($_POST['customerlat']) && isset($_POST['customerlon'])){
	$_SESSION['customerlat']=$_POST['customerlat'];
	$_SESSION['customerlon']=$_POST['customerlon'];
}
?>