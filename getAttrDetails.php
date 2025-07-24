<?php
session_start();
include("storescripts/connect_to_mysql.php");
include("admin/functions.php");

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

$color=clean($conn, $_POST['color']);
$pid=clean($conn, $_POST['pid']);
$size=clean($conn, $_POST['size']);
if($color==''){
    $color=0;
}
if($size==''){
    $size=0;
}

$res=mysqli_query($conn,"SELECT * FROM product_attributes WHERE product_id='$pid' AND (color_id='$color' OR size_id='$size') ");
if(mysqli_num_rows($res)>0){
    $row=mysqli_fetch_assoc($res);
    $productSoldQtyByProductId=productSoldQtyByProductId($conn,$pid,$row['id']);

    $pending_qty=$row['qty']-$productSoldQtyByProductId;
    $price=$row['price'];
    echo json_encode(['qty'=>$pending_qty,'price'=>$price]);

}else{

}

?>

