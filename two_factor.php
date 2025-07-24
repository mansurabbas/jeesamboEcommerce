<?php
session_start();
include("storescripts/connect_to_mysql.php");

 if (isset($_POST['two_factor'])) {
    $two_factor = mysqli_real_escape_string($conn, $_POST["two_factor"]);
    $uid = mysqli_real_escape_string($conn, $_POST["uid"]);

    $sql = mysqli_query($conn,"UPDATE users SET two_factor='$two_factor' WHERE email='".$_SESSION["LOGIN_EMAIL"]."' AND id='$uid'");
 }
 echo $two_factor;
 
?>