<?php

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

$conn='';
$db_host='';
$db_username='';
$db_pass='';
$db_name='';
$image='';
$product_name='';
$productTable='';
$categoryTable='';
$dbConnect='';


class ProductCustom{
	private $host  = 'localhost';
    private $user  = 'jeesamb3';
    private $password   = "1uY674akjW[A)U";
    private $database  = "jeesamb3_mystore";
	private $productTable = 'products';    
	private $categoryTable = 'categories';    
	private $productAttributeTable = 'product_attributes';    
	private $dbConnect = false;



    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }

	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}	
	public function cleanString($str){
		return str_replace(' ','_',$str);
	}
	public function getCategories() {		
		$sqlQuery = "
		SELECT products.categories_id, categories.categories
			FROM ".$this->productTable.",
			".$this->categoryTable."
			WHERE products.categories_id=categories.id
			GROUP BY categories.categories";		
        return  $this->getData($sqlQuery);
	}
	public function getBrand () {
		$sql = '';
		if(isset($_POST['category']) && $_POST['category']!="") {
			$category = $_POST['category'];
			$sql.=" WHERE categories_id IN ('".implode("','",$category)."')";
		}
		$sqlQuery = "
			SELECT distinct brand
			FROM ".$this->productTable." 
			$sql GROUP BY brand";
        return  $this->getData($sqlQuery);
	}
	// public function getMaterial () {
	// 	$sql = '';
	// 	if(isset($_POST['brand']) && $_POST['brand']!="") {
	// 		$brand = $_POST['brand'];
	// 		$sql.=" WHERE brand IN ('".implode("','",$brand)."')";
	// 	}
	// 	$sqlQuery = "
	// 		SELECT distinct material
	// 		FROM ".$this->productTable." 
	// 		$sql GROUP BY material";
    //     return  $this->getData($sqlQuery);
	// }
	// public function getProductSize () {
	// 	$sql = '';
	// 	if(isset($_POST['brand']) && $_POST['brand']!="") {
	// 		$brand = $_POST['brand'];
	// 		$sql.=" WHERE brand IN ('".implode("','",$brand)."')";
	// 	}
	// 	$sqlQuery = "
	// 		SELECT distinct size
	// 		FROM ".$this->productTable." 
	// 		$sql GROUP BY size";
    //     return  $this->getData($sqlQuery);
	// }
	public function getTotalProducts () {
		$sql= "SELECT DISTINCT products.id FROM ".$this->productTable.",".$this->productAttributeTable." WHERE products.id=product_attributes.product_id";
		if(isset($_POST['category']) && $_POST['category']!="") {
			$category = $_POST['category'];
			$sql.=" AND categories_id IN ('".implode("','",$category)."')";
		}
		if(isset($_POST['brand']) && $_POST['brand']!="") {
			$brand = $_POST['brand'];
			$sql.=" AND brand IN ('".implode("','",$brand)."')";
		}
		$productPerPage = 9;		
		$rowCount = $this->getNumRows($sql);
		$totalData = ceil($rowCount / $productPerPage);
		return $totalData;
	}		
	public function getProducts() {	
		$productPerPage = 9;	
		$totalRecord = isset($_POST['totalRecords']) ? strtolower(trim(str_replace("/","",$_POST['totalRecords']))) : 0;
		$totalRecord = intval($totalRecord);
		$start = ceil($totalRecord * $productPerPage);		
		$sql= "SELECT distinct(products.id),products.*,product_attributes.* FROM ".$this->productTable.", ".$this->productAttributeTable." WHERE products.id=product_attributes.product_id AND qty != 0 ";
		
		if(isset($_POST['category']) && $_POST['category']!="") {
			$category = $_POST['category'];
			$sql.=" AND categories_id IN ('".implode("','",$category)."')";
		}
		if(isset($_POST['brand']) && $_POST['brand']!="") {
			$brand = $_POST['brand'];
			$sql.=" AND brand IN ('".implode("','",$brand)."')";
		}
		if(isset($_POST['sorting']) && $_POST['sorting']!="") {
			$sorting = implode("','",(array)$_POST['sorting']);			
			if($sorting == 'newest' || $sorting == '') {
				$sql.=" ORDER BY products.id DESC";
			} else if($sorting == 'low') {
				$sql.=" ORDER BY price ASC";
			} else if($sorting == 'high') {
				$sql.=" ORDER BY price DESC";
			}
		} else {
			$sql.=" ORDER BY products.id DESC";
		}	
		
		$sql.=" LIMIT $start, $productPerPage";		
		$products = $this->getData($sql);
		$rowcount = $this->getNumRows($sql);
		$productHTML = '';
		if(isset($products) && count($products)) {			
            foreach ($products as $key => $product) {				

				$img = $product['image'];
				// $img=explode(" ",$img);
				// $count=count($img)-1;
				$product_id = $product['product_id'];
				$encryptedId = encryptId($product_id);

				$productHTML .= '<div class="recent-card">';
				$productHTML .= '<div class="img-recent-card">';
                $productHTML .= '<a href="'.SITE_PATH.'product?id='.$encryptedId.'"><img src="' . SITE_PATH . 'inventory_images/'.$img.'" alt="'.$product['product_name'].'" /></a>';
				$productHTML .= '</div>';
				$productHTML .= '<div class="img-recent-info">';
				$productHTML .= '<span class="product_name">'.$product['product_name'].'</span>';
				$productHTML .= '<span class="price">&#8358; '.$product['price'].'</span>';
				$productHTML .= '</div>';
				$productHTML .= '</div>';
			
			}
		}
		return 	$productHTML;	
	
	}	
}
?>