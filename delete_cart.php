<?php
session_start();
include("storescripts/connect_to_mysql.php");
include("admin/functions.php");

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

$key_to_remove = clean($conn, $_POST['index_to_remove']);

       if (count($_SESSION["cart_array"]) <= 1) {
           unset($_SESSION["cart_array"]);
           echo 'all';
       } else {
           unset($_SESSION["cart_array"]["$key_to_remove"]);
           sort($_SESSION["cart_array"]);
           echo 'specific';
       }



?>
