<?php
// Require top
require("top.php");

// $obj->isAdmin();
?>

<?php
$msg='';
$condition='';
$condition1='';
if($_SESSION["ADMIN_ROLE"]==1){
   $condition=" AND products.added_by='".$_SESSION["ADMIN_ID"]."'";
   $condition1=" AND added_by='".$_SESSION["ADMIN_ID"]."'";
}
 ?>

<?php

 // query the Product
 if(isset($_GET['type']) && $_GET['type']!=''){
 	$type=clean($conn,$_GET['type']);
 	if($type=='status'){
 		$operation=clean($conn,$_GET['operation']);
 		$id=clean($conn,$_GET['id']);
 		if($operation=='active'){
 			$status='1';
 		}else{
 			$status='0';
 		}
 		$update_status_sql="UPDATE products SET status='$status' $condition1 WHERE id='$id' ";
 		mysqli_query($conn,$update_status_sql);
 	}

 	if($type=='delete'){
 		  $id=clean($conn,$_GET['id']);
 		
 		   //   Delete single front image from database and image path
 		  $fetch_sql="SELECT image FROM products WHERE id='$id' ";
          $fetch_sql=mysqli_query($conn,$fetch_sql);
              if(mysqli_num_rows($fetch_sql)>0) {
              $row=mysqli_fetch_assoc($fetch_sql);
              $image_to_delete=$row['image'];
    
              $image_to_delete="../inventory_images/".$image_to_delete;
              
                    if (file_exists($image_to_delete)) {
                       		    unlink($image_to_delete);
                    }
              }
 		
 		  $delete_sql="DELETE FROM products WHERE id='$id' $condition1 ";
 		  mysqli_query($conn,$delete_sql);

        //   Delete product images from database and product images path
        $fetch_images_sql="SELECT product_images FROM product_images WHERE product_id='$id' ";
           $fetch_images_run=mysqli_query($conn,$fetch_images_sql);
           $count=mysqli_num_rows($fetch_images_run);
               if($count>0) {
                    while ($row=mysqli_fetch_assoc($fetch_images_run)) {
                        $images_to_delete=$row['product_images'];
                        $images_to_delete_path="../product_images/".$images_to_delete;
                        if (file_exists($images_to_delete_path)) {
                            unlink($images_to_delete_path);
                        }     
                    }     
               }
           $product_images_sql="DELETE FROM product_images WHERE product_id='$id' ";
 		   mysqli_query($conn,$product_images_sql);

        //   Delete product attribute from the database
 		  $product_attributes_sql="DELETE FROM product_attributes WHERE id='$id' ";
 		  mysqli_query($conn,$product_attributes_sql);
 		
 	}
 }


// query the Product And Categories
$product_sql = "SELECT products.*,categories.categories,product_attributes.price AS aprice,product_attributes.qty AS aqty FROM products,categories,product_attributes WHERE products.categories_id=categories.id AND products.id=product_attributes.product_id $condition ORDER BY products.id DESC";

$product_sql=mysqli_query($conn,$product_sql);

 ?>

  <div class="content">
      <a href="inventory_list">Add Product</a>
     <table id="myTable" class="display responsive wrap" style="width:100%">
         
                <thead>
                    <tr>
                        <th width="5%">ID</th>
                        <th width="20%">Product Name</th>
                        <th width="5%">Image</th>
                        <th width="15%">Price</th>
                        <th width="15%">Qty</th>
                        <th width="10%">Date added</th>
                        <th width="30%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                          $imgArr=[];
                          while($row = mysqli_fetch_array($product_sql)){
                          $id = $row["id"];
                          $product_name = $row["product_name"];
                          $image = $row['image'];
                          $qty = $row["aqty"];
                          $price = $row["aprice"];
                          $date = date_create($row["date_added"]);
                          $date_added = date_format($date, 'Y-m-d H:i:s');
                    ?>
                    <tr>
                            <td width="5%"><?php echo $id;?></td>
                            <td width="20%" style="word-wrap: break-word;"><?php echo $product_name;?></td>
                            <td width="5%"><img style="max-width: 100%; width: 50px; height: auto" src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image;?>" /></td>
                            <td width="15%">&#8358;<?php echo number_format($row['aprice']);?></td>
                            <td width="15%"><?php echo $row['aqty'];?>
                               <?php
                               $getProductAttr=getProductAttr($conn,$id);
                               $productSoldQtyByProductId=productSoldQtyByProductId($conn,$id,$getProductAttr);
                               $productQty=productQty($conn,$id,$getProductAttr);
                               $pending_qty=$row['aqty']-$productSoldQtyByProductId;
                                   
                                ?>
                                Pending Qty: <?php echo $pending_qty;?>
                            
                            </td>
                            <td width="10%"><?php echo $date_added;?></td>
                            <td width="30%">
                            <?php
                            if($row['status']==1){
                              echo "<span class='badge badge-complete'><a href='?type=status&operation=deactive&id=".$id."'><i class='fas fa-check'></i>&nbsp;Active</a></span>&nbsp;";
                            }else{
                              echo "<span class='badge badge-pending'><a href='?type=status&operation=active&id=".$id."'><i class='fas fa-times'></i>&nbsp;Deactive</a></span>&nbsp;";
                            }
                            echo "<span class='badge badge-edit'><a href='inventory_edit?id=".$id."'><i class='far fa-edit'></i>&nbsp;Edit</a></span>&nbsp;";
                            
                            echo "<span class='badge badge-delete'><a href='?type=delete&id=".$id."'><i class='far fa-trash-alt'></i>&nbsp;Delete</a></span>";
                            
                            ?>
                            
                            </td>
                    </tr>
                    <?php 
                    echo $msg;
                    }  ?>
                </tbody>
                
    </table>

  </div>


  <script type="text/javascript">
      $(document).ready(function(){
        $('.nav_btn').click(function(){
          $('.mobile_nav_items').toggleClass('active');
        });
      });
      </script>
      
      <!--Live Online Users Start-->
            <script>
                $(document).ready(function(){
                    
                    <?php
                    if($_SESSION["ADMIN_ROLE"] == 1) { ?>
                    
                    		function updateUserStatus(){
                    		    var action = 'update_time';
                    			jQuery.ajax({
                    				url:'action.php',
                    				method:"POST",
                                    data:{action:action},
                    				success:function(data){
                    					
                    				}
                    			});
                    		}
                    		
                    		setInterval(function(){
                    			updateUserStatus();
                    		},3000);
            		
            		<?php } else { ?> 
            		
                    		getUserStatus();
                    		
                    		setInterval(function(){
                			getUserStatus();
                		    },3000);
                    		
                    		function getUserStatus(){
                    		    var action = "fetch_data";
                    			jQuery.ajax({
                    				url:'action.php',
                    				method:"POST",
                                    data:{action:action},
                    				success:function(data){
                    					jQuery('#user_grid').html(data);
                    				}
                    			});
                    		}
            		
            		<?php } ?>
                });
    	  </script>
    <!--Live Online Users End-->

</script>
</body>
</html>
