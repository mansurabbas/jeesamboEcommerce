<?php 
session_start();
include("storescripts/connect_to_mysql.php");

$network= $_POST['network'];
$options = '';
if ($network == 1) {
    // SME
    $options .= '<option value="">Select Plan</option>';
    $options .= '<option value="130">500.0MB SME = ₦130 30 Days</option>';
    $options .= '<option value="260">1.0GB SME = ₦ 260 30 Days</option>';
    $options .= '<option value="520">2.0GB SME = ₦ 520 330 Days</option>';
    $options .= '<option value="780">3.0GB SME = ₦ 780 30 Days</option>';
    $options .= '<option value="1300">5.0GB SME = ₦ 1300 30 Days</option>';
    $options .= '<option value="2600">10.0GB SME = ₦ 2600 30 Days</option>';
    $options .= '<option value="3975">15.0GB SME = ₦ 3975 30 Days</option>';
}
if ($network == 2) {
    // Corportare Gifting
    $options .= '<option value="">Select Plan</option>';
    $options .= '<option value="140">500.0MB CORPORATE GIFTING = ₦ 140 30 DAYS (CG)</option>';
    $options .= '<option value="265">1.0GB CORPORATE GIFTING = ₦ 265 30 DAYS (CG)</option>';
    $options .= '<option value="530">2.0GB CORPORATE GIFTING = ₦ 530 30 Days</option>';
    $options .= '<option value="795">3.0GB CORPORATE GIFTING = ₦ 795 30 DAYS (CG)</option>';
    $options .= '<option value="1325">5.0GB CORPORATE GIFTING = ₦ 1325 30 DAYS (CG)</option>';
    $options .= '<option value="2650">10.0GB CORPORATE GIFTING = ₦ 2650 30 Days</option>';

}
if ($network == 3) {
    $options .= '<option value="">Select Plan</option>';
    $options .= '<option value="130">500.0MB CORPORATE GIFTING = ₦ 130 30 Days</option>';
    $options .= '<option value="285">1.0GB CORPORATE GIFTING = ₦ 285 30 Days</option>';
    $options .= '<option value="520">2.0MB CORPORATE GIFTING = ₦ 520 30 Days</option>';
    $options .= '<option value="780">3.0GB CORPORATE GIFTING = ₦ 780 30 Days</option>';
    $options .= '<option value="4275">5.GB CORPORATE GIFTING = ₦ 1425 30 Days</option>';
    $options .= '<option value="2850">10.0GB CORPORATE GIFTING = ₦ 2850 30 Days</option>';
    $options .= '<option value="4275">15.0GB CORPORATE GIFTING = ₦ 4275 30 Days</option>';
}
if ($network == 4) {
    $options .= '<option value="">Select Plan</option>';
    $options .= '<option value="140">500.0MB CORPORATE GIFTING = ₦ 140 30 DAYS (CG)</option>';
    $options .= '<option value="275">1.0GB CORPORATE GIFTING = ₦ 275 30 DAYS (CG)</option>';
    $options .= '<option value="550">2.0GB CORPORATE GIFTING = ₦ 550 30 DAYS (CG)</option>';
    $options .= '<option value="1375">5.0GB CORPORATE GIFTING = ₦ 1375 30 Days</option>';
    $options .= '<option value="2750">10.0GB CORPORATE GIFTING = ₦ 2750 30 DAYS (CG)</option>';
}

echo $options;
?>