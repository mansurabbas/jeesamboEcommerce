<?php
header('Content-Type: application/json');
require_once("storescripts/connect_to_mysql.php");

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

function encryptId($id){
	$encrypt_method = "AES-256-CBC";   
	$secret_key = "XDT-YUGHH-GYGF-YUTY-GHRGFR";
	$iv = "DFYTYUITYUIUYUGYIYT";
	
	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $iv), 0, 16);
	$id = openssl_encrypt($id, $encrypt_method, $key, 0, $iv);
	$id = base64_encode($id);
	return $id;
}
function decryptId($id){
	$encrypt_method = "AES-256-CBC";   
  	$secret_key = "XDT-YUGHH-GYGF-YUTY-GHRGFR";
  	$iv = "DFYTYUITYUIUYUGYIYT";

    $id = base64_decode($id);
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $iv), 0, 16);
    $id = openssl_decrypt($id, $encrypt_method, $key, 0, $iv);
    return $id;
    }

include("Product_custom.php");
$product = new ProductCustom();
$products = $product->getProducts();

$productData = array(
	"products" => $products	
);

echo json_encode($productData);
?>