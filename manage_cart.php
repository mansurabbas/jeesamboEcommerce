<?php
session_start();
include("storescripts/connect_to_mysql.php");
include("admin/functions.php");
require('add_to_cart.inc.php');

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

$pid=clean($conn,$_POST['pid']);
$qty=clean($conn,$_POST['qty']);
$type=clean($conn,$_POST['type']);

$getProductAttr=getProductAttr($conn,$pid);
$productSoldQtyByProductId=productSoldQtyByProductId($conn,$pid,$getProductAttr);
$productQty=productQty($conn,$pid,$getProductAttr);

$pending_qty=$productQty-$productSoldQtyByProductId;

$attr_id=0;
if (isset($_POST['pid']) && isset($_POST['cid']) && isset($_POST['sid']) && isset($_POST['qty'])) {
    $sub_sql='';
    $cid = clean($conn,$_POST['cid']);
    $sid = clean($conn,$_POST['sid']);
    $pid = clean($conn,$_POST['pid']);
    $qty=clean($conn,$_POST['qty']);

    if($sid>0) {
        $sub_sql.=" AND size_id=$sid ";
    }
    if($cid>0) {
        $sub_sql.=" AND color_id=$cid ";
    }
    $row=mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM product_attributes WHERE product_id=$pid $sub_sql"));
    $attr_id=$row['id'];
}

$obj=new add_to_cart();

if($type=='add'){
	$obj->addProduct($pid,$qty,$attr_id);
}

if($type=='remove'){
	$obj->removeProduct($pid,$attr_id);
}

if($type=='update'){
	$obj->updateProduct($pid,$qty,$attr_id);
}

echo $obj->totalProduct();



?>
