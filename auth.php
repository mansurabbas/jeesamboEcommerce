<?php
ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

session_start();
include("storescripts/connect_to_mysql.php");
include("admin/functions.php");

if (isset($_SESSION['WISHLIST_ID']) && $_SESSION['WISHLIST_ID']!=''){
        wishlist_add($conn,$_SESSION['USER_ID'],$_SESSION['WISHLIST_ID']);
        unset($_SESSION['WISHLIST_ID']);
}

if(isset($_SESSION['redirectURL'])){
    redirect($_SESSION['redirectURL']);
}else{
    redirect('index');
}

?>