<?php
session_start();
include("storescripts/connect_to_mysql.php");
include("admin/functions.php");

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

$c_s_id=clean($conn,$_POST['c_s_id']);
$pid=clean($conn,$_POST['pid']);
$type=clean($conn,$_POST['type']);

if($type=='color') {
	$sqlAttr=mysqli_query($conn, "SELECT product_attributes.size_id,size_master.size FROM product_attributes,size_master WHERE product_attributes.product_id='$pid' AND product_attributes.color_id=$c_s_id AND size_master.id=product_attributes.size_id AND size_master.status=1 ORDER By size_master.order_by asc");
	$html='';
    if(mysqli_num_rows($sqlAttr)>0){
        while($rowAttr=mysqli_fetch_assoc($sqlAttr)){
            $html.="<option value='".$rowAttr['size_id']."'>".$rowAttr['size']."</option>";
        }
    }
 	echo $html;
}
?>

