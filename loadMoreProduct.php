<?php 
session_start();
require_once("storescripts/connect_to_mysql.php");
?>


<?php
    
    
    if(isset($_POST['offset']) && isset($_POST['limit'])){
        $offset = mysqli_real_escape_string($conn, $_POST['offset']);
        $limit = mysqli_real_escape_string($conn, $_POST['limit']);
        
        $sql = "SELECT products.id, products.product_name, products.image, MIN(product_attributes.price) as price 
            FROM products 
            JOIN product_attributes ON products.id = product_attributes.product_id 
            WHERE products.status = 1 
            GROUP BY product_attributes.product_id 
            ORDER BY products.id ASC 
            LIMIT $limit OFFSET $offset";
        $data=mysqli_query($conn,$sql);

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
   
        while ($row=mysqli_fetch_assoc($data)) {
            $id=$row['id'];
            $image=$row['image'];
            $id = encryptId($id);
            
            echo '<div class="home-card">
                      <div class="img-home-card">
                            <a href="'.SITE_PATH.'product?id='.$id.'"><img src="' . SITE_PATH . 'inventory_images/' . $image . '" /></a>
                      </div>
                      <div class="img-home-info">
                            <span class="product_name">'.$row['product_name'].'</span>
                            <span class="price">&#8358; '. number_format($row['price']).'</span>
                      </div>
                  </div>';
            
        }
       
    }

?>