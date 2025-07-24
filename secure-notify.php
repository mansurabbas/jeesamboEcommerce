<?php
session_start();
session_regenerate_id();
require_once("storescripts/connect_to_mysql.php");
require_once("admin/functions.php");

if(!isset($_SESSION['USER_LOGIN'])){
  redirect('login');
}
if(!isset($_SESSION['USER_ID'])){
    $uid=$_SESSION['USER_ID'];
}

$url = "https://api.paystack.co/transaction/initialize";

//Gather the data to be sent to the endpoint
$email=$_SESSION['FUNDING_EMAIL'];
$amount=$_SESSION['FUNDING_AMOUNT'];
$charges=$_SESSION['FUNDING_CHARGES'];

$metadata = [
    'funding_charges' => $_SESSION['FUNDING_CHARGES']
];
$data = [
    "email" => $email,
    "amount" => $amount * 100,
    'metadata' => $metadata
];

//Create cURL session
$curl = curl_init($url);

//Turn off Mandatory SSL Checker
//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

//Configure the cURL  session based on the type of request
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//Decide that this is a POST request
curl_setopt($curl, CURLOPT_POST, true);

//Convert the request data to a JSON data
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

//Set the API headers
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer sk_live_8e66b5298d2fbb42d63e2fbfd8f3afae8b2b7bdd", 
    "Content-type: Application/json"
]);

//Run the curl
$run = curl_exec($curl);

//Error checker
$error = curl_error($curl);

if($error){
    die("Curl returned some errors: " . $error);
}

//Convert to jSON object

$result = json_decode($run);
//Close cURL session
curl_close($curl);

header("Location: " . $result->data->authorization_url);
//var_dump($run);
?>