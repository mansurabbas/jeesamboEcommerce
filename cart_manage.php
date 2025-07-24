<?php
session_start();
include("storescripts/connect_to_mysql.php");
include("admin/functions.php");

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

$pid=clean($conn,$_POST['pid']);
$qty=clean($conn,$_POST['qty']);
$type=clean($conn,$_POST['type']);

$productSoldQtyByProductId=productSoldQtyByProductId($conn,$pid);
$productQty=productQty($conn,$pid);

$pending_qty=$productQty-$productSoldQtyByProductId;

if($qty>$pending_qty){
	echo "not_avaliable";
	die();
}

$obj=new add_to_cart();

if($type=='add'){
	$obj->addProduct($pid,$qty);
}

if($type=='remove'){
	$obj->removeProduct($pid);
}

if($type=='update'){
	$obj->updateProduct($pid,$qty);
}

echo $obj->totalProduct();
?>