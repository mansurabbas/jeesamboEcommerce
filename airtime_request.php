<?php
session_start();
session_regenerate_id();
require_once("storescripts/connect_to_mysql.php");

if (isset($_SESSION['USER_ID'])) {
  $uid=$_SESSION['USER_ID'];
}
function getRevenue($start,$end) {
	global $conn;
		$sql="SELECT SUM(revenue) AS revenue FROM revenue_transactions WHERE transaction_date between '$start' AND '$end'";
		$res=mysqli_query($conn,$sql);
		$arr=array();
		while($row=mysqli_fetch_assoc($res)) {
			return $row['revenue'];
		}
}

function getWalletAmt($uid) {
	global $conn;
		$sql="SELECT * FROM wallet WHERE user_id = '$uid' ";
		$res=mysqli_query($conn,$sql);
		$arr=array();
		$in=0;
		$out=0;
		while ($row=mysqli_fetch_assoc($res)) {
			if($row['type']=='in'){
				$in=$in+$row['amt'];
			}
			if($row['type']=='out'){
				$out=$out+$row['amt'];
			}
		}
		return $in - $out;
}
function manageWallet($uid,$amt,$email,$type,$msg,$payment_id='') {
	global $conn;
	$added_on=date('Y-m-d H:i:s');
		$sql="INSERT INTO wallet(user_id,amt,email,type,msg,added_on) VALUES('$uid','$amt','$email','$type','$msg','$added_on')";
		$res=mysqli_query($conn,$sql);
}

// If the form is submit
if (isset($_POST['product_item'])) {

    $network = $_POST['network'];
    $product_item = $_POST['product_item'];
    $amount = $_POST['amount'];
    $phone_number = $_POST['phone_number'];

    $error_msg='';
    $getWalletAmt=getWalletAmt($_SESSION['USER_ID']);
    if ($getWalletAmt > $amount) {
        
    } else {
        echo "low_wallet_money";
        die();

    }

  

    // Post transaction request
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://www.gladtidingsdata.com/api/topup/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>json_encode([
        "network" => $network,
        "amount"=> $amount,
        "mobile_number" => $phone_number,
        "Ported_number" => true,
        "airtime_type"=> "VTU"
    ]),
    CURLOPT_HTTPHEADER => array(
        'Authorization: Token 6cca591eb397af064a4d459ff432dc01896a013d',
        'Content-Type: application/json'
    ),
    ));

    $response = curl_exec($curl);
    $result = json_decode($response, true);

    $data_id = $result['id'];
    $ident = $result['ident'];
    $amount = $result['amount'];
    $network = $result['network'];
    $airtime_type = $result['airtime_type'];
    switch ($network) {
        case 1:
            $network = 'MTN';
            break;
        case 2:
            $network = 'GLO';
            break;
        case 3:
            $network = 'AIRTEL';
            break;
        case 6:
            $network = '9MOBILE';
            break;
    }
    
    $plan_amount = $result['plan_amount'];
    $paid_amount = $result['paid_amount'];
    $plan_network = $result['plan_network'];
    $status = $result['Status'];
    $product_type = 'Airtime';
    $create_date = $result['create_date'];

    curl_close($curl);

    if (isset($result['error'][0]) && $result['error'][0] != '') {
        echo 'invalid_mobile_number';
        die();
    }
    if (isset($result['network'][0]) && $result['network'][0] != '') {
        echo 'invalid_network';
        die();
    }
    if (isset($result['Status']) && $result['Status'] == 'failed') {
        echo "failed";
        die();
    }
    if (isset($result['Status']) && $result['Status'] == 'successful') {
        $getWalletAmt = getWalletAmt($_SESSION['USER_ID']);
        manageWallet($_SESSION['USER_ID'], $amount, $_SESSION['LOGIN_EMAIL'], 'out', 'Airtime purchased');

        mysqli_query($conn,"INSERT INTO other_customer(customer_name,customer_email,amount,phone_number,date) VALUES('".$_SESSION['LOGIN_USERNAME']."','".$_SESSION['LOGIN_EMAIL']."','$amount','".$_SESSION['LOGIN_PHONE']."','$create_date') ");
        $last_id = mysqli_insert_id($conn);
        $revenue = $amount - $paid_amount;
        mysqli_query($conn,"INSERT INTO revenue_transactions(customer_id,product_type,network_provider,product_name,quantity,amount,plan_amount,revenue,transaction_date) VALUES('$last_id','$product_type','$plan_network','$netmwork','$plan_name','$amount','$paid_amount','$revenue','$create_date') ");
        echo "successful";
    }
    
    
}

?>