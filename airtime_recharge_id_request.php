<?php 
session_start();
include("storescripts/connect_to_mysql.php");

$airtimeRechargeId = $_POST['airtimeRechargeId'];
$airtimeRechargeAmt = 0;
if (in_array($airtimeRechargeId, [1, 2, 3, 4])) {
    $airtimeRechargeAmt +=100;
}

if (in_array($airtimeRechargeId, [5, 6, 7, 12])) {
    $airtimeRechargeAmt +=200;
}

if (in_array($airtimeRechargeId, [8, 10, 11])) {
    $airtimeRechargeAmt +=500;
}

if (in_array($airtimeRechargeId, [13])) {
    $airtimeRechargeAmt +=300;
}

if (in_array($airtimeRechargeId, [9])) {
    $airtimeRechargeAmt +=1000;
}


echo $airtimeRechargeAmt;
?>