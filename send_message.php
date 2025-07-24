<?php

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

require("storescripts/connect_to_mysql.php");
require("admin/functions.php");
$name=clean($conn,$_POST['name']);
$email=clean($conn,$_POST['email']);
$mobile=clean($conn,$_POST['mobile']);
$comment=clean($conn,$_POST['message']);
$added_on=date('Y-m-d h:i:s');
mysqli_query($conn,"INSERT INTO contact_us(name,email,mobile,comment,added_on) VALUES('$name','$email','$mobile','$comment','$added_on')");
echo "Thank you";
?>

<script src="js/custom.js"></script>