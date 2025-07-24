<?php
ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

session_start();
session_regenerate_id();
unset($_SESSION["FIRSTNAME"]);
unset($_SESSION["PASSWORD"]);
unset($_SESSION["USER_ID"]);
unset($_SESSION["USER_LOGIN"]);
// unset($_SESSION["cart_array"]);
header("Location: login");

?>
