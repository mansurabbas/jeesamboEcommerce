<?php
// This include session, connection and functions
require("top.php");
?>

<?php
$str='';
$str=clean($conn,$_GET['str']);
if($str!=''){
	$get_product=get_product($conn,'','','',$str);
}else{
	?>
	<script> 
	window.location.href='<?php echo SITE_PATH?>index';
	</script>
	<?php
}
?>

<body id="index">
	<div class="content">
      <div id="wrapper">
                 <!-- Featured Product Display Start-->
             <!-- Testing -->
                    <div id="recent-wrapper" style="background: #f5f6f8">
                            <?php
                            foreach($get_product as $list){
                              $image = $list['image'];
                              $newId = $list['id'];
                            ?>
                            <div class="recent-card">
                                    <div class="img-recent-card">
                                        <?php 
                                        $encryptedId = encryptId($newId);
                                    ?>
                                    <a href="<?php echo SITE_PATH?>product?id=<?php echo $encryptedId ?>&sub_categories_id=<?php echo $list['sub_categories_id']?>"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image;?>" alt="<?php echo $list['product_name'];?>"></a>
                                    </div>
                                    <div class="img-recent-info">
                                        <span class="product_name"><?php echo $list['product_name'];?></span>
                                        <span class="price">&#8358; <?php echo number_format($list['price'],2);?></span>
                                    </div>
                            </div>
                            
                            <?php } ?>
                
                    </div>
             <!-- Testing -->
             <!-- Featured Product Display End-->
      </div>
    </div>

<!--------------------------footer ---------------------- -->
<?php include('footer.inc.php'); ?>

<script>
        var loader = document.getElementById("preloader");
        window.addEventListener("load", function(){
            loader.style.display = "none";
        })
</script>
</body>
</html>
