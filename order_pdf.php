<?php
// This include session, connection and functions
session_start();
include("vendor/autoload.php");
include("storescripts/connect_to_mysql.php");
include("admin/functions.php");

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

?>
<?php
if(!isset($_SESSION['ADMIN_LOGIN'])){
	if(!isset($_SESSION['USER_ID'])){
		die();
	}
}

$order_id=clean($conn,$_GET['id']);

$coupon_details=mysqli_fetch_assoc(mysqli_query($conn,"SELECT coupon_value FROM `order` WHERE id='$order_id'"));
$coupon_value=$coupon_details['coupon_value'];

$css=file_get_contents('style.css');

$html='<table class="cart-table">
		<thead>
		<tr>
			<th>Product</th>
			<th>Quantity</th>
			<th style="text-align: right">Subtotal</th>
		</tr>
		<thead>';

		if(isset($_SESSION['ADMIN_LOGIN'])){
			$sql=mysqli_query($conn,"SELECT DISTINCT(order_details.id) ,order_details.*,order_details.shipping AS ShippingCost,products.product_name,products.image,product_attributes.price AS pp FROM order_details,products,product_attributes,`order` WHERE order_details.order_id='$order_id' AND order_details.product_id=products.id AND order_details.product_attr_id=product_attributes.id");
		}else{
			$uid=$_SESSION['USER_ID'];
			$sql=mysqli_query($conn,"SELECT DISTINCT(order_details.id) ,order_details.*,order_details.shipping AS ShippingCost,products.product_name,products.image,product_attributes.price AS pp FROM order_details,products,product_attributes,`order` WHERE order_details.order_id='$order_id' AND `order`.user_id='$uid' AND order_details.product_id=products.id AND order_details.product_attr_id=product_attributes.id");
		}

		$total_price=0;
		if(mysqli_num_rows($sql)==0){
			die();
		}
		while($row=mysqli_fetch_assoc($sql)){
			  $image = $row['image'];
			  $unitShippingCost = $row['ShippingCost'];

		$total_price=$total_price+($row['qty']*$row['pp']);
		 $pp=$row['qty']*$row['pp'];
         $html.='<tr>
		 <td>
    		 <div class="cart-info">
        		     <img src="'.SITE_PATH.'inventory_images/'.$image.'" style="width: 160px; height: 160px;">
        		     
                     <div>
            	     <p>'.$row['product_name'].'</p>
                     <small>Price: &#8358;'.number_format($row['pp'],2).'</small>
                     <br>
            		 </div>
	         </div>
	      </td>
	   <td style="text-align: center">'.$row['qty'].'</td>
		<td style="text-align: right">&#8358;'.number_format($pp,2).'</td>
         </tr>';
	   }
	   if($coupon_value!=""){
	           $html.='<tr>
	                <td></td>
    				<td style="text-align: right">Coupon Value</td>
    				<td style="text-align: right">&#8358;'.number_format($coupon_value,2).'</td>
	                  </tr>';
       }
	   if($unitShippingCost!=""){
	           $html.='<tr>
	                <td></td>
    				<td style="text-align: right">Shipping</td>
    				<td style="text-align: right">&#8358;'.number_format($unitShippingCost,2).'</td>
	                  </tr>';
       }
			$total_price=((int)$total_price + (int)$unitShippingCost) - (int)$coupon_value;
		 $html.='<tr>
	                    <td></td>
        				<td style="text-align: right">Total Price</td>
        				<td style="text-align: right">&#8358;'.number_format($total_price,2).'</td>
        		</tr>';
$html.='</table>';


$mpdf=new \Mpdf\Mpdf();
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html,2);
$file=time().'.pdf';
$mpdf->Output($file,'D');
?>
