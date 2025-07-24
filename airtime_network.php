<?php 
session_start();
include("storescripts/connect_to_mysql.php");
$network = '';
$network = $_POST['network'];
$options = '';
if ($network==1) {
    // SME
    $options .= '<option value="">product items</option>';
    $options .= '<option value="1">MTN VTU 100</option>';
    $options .= '<option value="5">MTN VTU 200</option>';
    $options .= '<option value="8">MTN VTU 500</option>';
    $options .= '<option value="9">MTN VTU 1000</option>';
   
}
if ($network==2) {
    // Corportare Gifting
    $options .= '<option value="">product items</option>';
    $options .= '<option value="2">GLO VTU 100</option>';
    $options .= '<option value="6">GLO VTU 200</option>';
    $options .= '<option value="10">GLO VTU 500</option>';

}
if ($network==3) {
    $options .= '<option value="">product items</option>';
    $options .= '<option value="3">AIRTEL VTU 100</option>';
    $options .= '<option value="7">AIRTEL VTU 200</option>';
    $options .= '<option value="11">AIRTEL VTU 500</option>';
    $options .= '<option value="13">AIRTEL VTU 300</option>';

}
if ($network==6) {
    $options .= '<option value="">product items</option>';
    $options .= '<option value="4">9MOBILE VTU 100</option>';
    $options .= '<option value="12">9MOBILE VTU 200</option>';
}

echo $options;
?>