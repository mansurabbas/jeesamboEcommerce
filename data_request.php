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
if (isset($_POST['bundle'])) {
    $dataString = '';
    $network = $_POST['network'];
    $amount = $_POST['amount'];
    $bundle = $_POST['bundle'];
    $phone_number = $_POST['phone_number'];

    $error_msg='';
    $getWalletAmt=getWalletAmt($_SESSION['USER_ID']);
    if ($getWalletAmt > $amount) {
        
    } else {
        $low_wallet_money ="low_wallet_money";
        $lowAmt ="lowAmt";
        $dataString .= $lowAmt.'|'.$low_wallet_money;

        echo $dataString;
        die();

    }

    if ($network == 1) {
        if ($amount == "130") {
            $bundle = '212';
            $data_amt = '500MB';
        }elseif ($amount == "260") {
            $bundle = '207';
            $data_amt = '1GB';
        }elseif ($amount == "520") {
            $bundle = '208';
            $data_amt = '2GB';
        }elseif ($amount == "789") {
            $bundle = '209';
            $data_amt = '3GB';
        }elseif ($amount == "1300") {
            $bundle = '210';
            $data_amt = '5GB';
        }elseif ($amount == "2600") {
          $bundle = '247';
          $data_amt = '10GB';
        }
    }
    if ($network == 2) {
        if ($amount == "140") {
            $bundle = '311';
        }elseif ($amount == "265") {
            $bundle = '306';
        }elseif ($amount == "530") {
            $bundle = '307';
        }elseif ($amount == "795") {
            $bundle = '308';
        }elseif ($amount == "1325") {
            $bundle = '309';
        }elseif ($amount == "2650") {
          $bundle = '310';
        }
    }
    if ($network == 3) {
        if ($amount == "130") {
            $bundle = '342';
        }elseif ($amount == "260") {
            $bundle = '335';
        }elseif ($amount == "520") {
            $bundle = '336';
        }elseif ($amount == "780") {
            $bundle = '337';
        }elseif ($amount == "1300") {
            $bundle = '338';
        }elseif ($amount == "2850") {
            $bundle = '339';
        }elseif ($amount == "4275") {
            $bundle = '340';
        }   
    }
    if ($network == 4) {
        if ($amount == "140") {
            $bundle = '246';
        }elseif ($amount == "275") {
            $bundle = '213';
        }elseif ($amount == "550") {
            $bundle = '214';
        }elseif ($amount == "1375") {
            $bundle = '215';
        }elseif ($amount == "2750") {
            $bundle = '216';
        }
}
  

// Post transaction request
$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://maskawasubapi.com/api/data/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>json_encode([
    "network" => $network,
    "mobile_number" => $phone_number,
    "plan"=> $bundle,
    "Ported_number" => true
  ]),
  CURLOPT_HTTPHEADER => array(
    'Authorization: Token 6ad4ffc59141c0f7f9688056b0a5e8e25de8b67d',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
$result = json_decode($response, true);
curl_close($curl);

    if ($result['error']['0']) {
        $unavailable ="unavailable";
        $failed ="failed";
        $dataString .= $failed.'|'.$unavailable;

        echo $dataString;
        die();
    }
    
    $data_id = $result['id'];
    $ident = $result['ident'];
    $status = $result['Status'];
    $mobile_number = $result['mobile_number'];
    $api_response = $result['api_response'];
    $plan_code = $result['plan'];
    $plan_network = $result['plan_network'];
    $plan_name = $result['plan_name'];
    $plan_amount = $result['plan_amount'];
    $create_date = $result['create_date'];   
    $product_type = 'Data';
    
    if($result['Status']=='failed'){
        $dataString .= $data_id.'|'.$ident.'|'.$status.'|'.$_SESSION['USER_ID'].'|'.$plan_network.'|'.$phone_number.'|'.$amount.'|'.$client_ip.'|'.$duration.'|'.$plan_name.'|'.$plan_amount.'|'.$create_date.'|'.$balance_before.'|'.$balance_after;
        echo $dataString;
        die();
    }
    
    if ($result['Status']=='successful') {

        $getWalletAmt=getWalletAmt($_SESSION['USER_ID']);
        $balance_before = $getWalletAmt;
        $balance_after = $getWalletAmt - $amount;

        manageWallet($_SESSION['USER_ID'],$amount,$_SESSION['LOGIN_EMAIL'],'out','Data purchased');

        $revenue = $amount - $plan_amount;
        mysqli_query($conn,"INSERT INTO transactions_history(data_id,ident,user_id,status,plan_network,phone_number,amount,plan_name,plan_amount,create_date,balance_before,balance_after) VALUES('$data_id','$ident','".$_SESSION['USER_ID']."','$status','$plan_network','$phone_number','$amount','$plan_name','$plan_amount','$create_date','$balance_before','$balance_after') ");
        mysqli_query($conn,"INSERT INTO other_customer(customer_name,customer_email,amount,phone_number,date) VALUES('".$_SESSION['LOGIN_USERNAME']."','".$_SESSION['LOGIN_EMAIL']."','$amount','".$_SESSION['LOGIN_PHONE']."','$create_date') ");
        $last_id = mysqli_insert_id($conn);
        mysqli_query($conn,"INSERT INTO revenue_transactions(customer_id,product_type,network_provider,product_name,quantity,amount,plan_amount,revenue,transaction_date) VALUES('$last_id','$product_type','$plan_network','$plan_name','$plan_name','$amount','$plan_amount','$revenue','$create_date') ");

        $dataString .= $data_id.'|'.$ident.'|'.$status.'|'.$_SESSION['USER_ID'].'|'.$plan_network.'|'.$phone_number.'|'.$amount.'|'.$plan_name.'|'.$plan_amount.'|'.$create_date.'|'.$balance_before.'|'.$balance_after;

        echo $dataString;
        die();
        
    }

}

?>