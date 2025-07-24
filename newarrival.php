<?php require_once('top.php');?>
<?php
$sort_order='';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Arrival</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/3ebb00a559.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="order-top-4a">
            <h1 class="deal">New Arrivals</h1>
        </div>
        <!-- <div class="category-menu" >
                <div class="category-menu-list">
                        <div class="menu-item-img">
                                <div class="menu-item-icon">
                                    <span><i class="fas fa-couch"></i></span>
                                </div>
                        </div>
                        <div class="menu-item-desc">
                                <span>Furnitures</span>
                        </div>
                </div>
                <div class="category-menu-list">
                        <div class="menu-item-img">
                                <div class="menu-item-icon">
                                <i class="fas fa-tv"></i>
                                </div>
                        </div>
                        <div class="menu-item-desc">
                                <span>Electronics</span>
                        </div>
                </div>
                <div class="category-menu-list">
                        <div class="menu-item-img">
                                <div class="menu-item-icon">
                                    <span><i class="fas fa-car"></i></span>
                                </div>
                        </div>
                        <div class="menu-item-desc">
                                <span>Automobile</span>
                        </div>
                </div>
                <div class="category-menu-list">
                        <div class="menu-item-img">
                                <div class="menu-item-icon">
                                    <span><i class="fas fa-suitcase-rolling"></i></span>
                                </div>
                        </div>
                        <div class="menu-item-desc">
                                <span>Accessories</span>
                        </div>
                </div>
                <div class="category-menu-list">
                        <div class="menu-item-img">
                                <div class="menu-item-icon">
                                    <span><i class="fas fa-tshirt"></i></span>
                                </div>
                        </div>
                        <div class="menu-item-desc">
                                <span>Clothing</span>
                        </div>
                </div>
                <div class="category-menu-list">
                        <div class="menu-item-img">
                                <div class="menu-item-icon">
                                    <span><i class="fas fa-laptop"></i></span>
                                </div>
                        </div>
                        <div class="menu-item-desc">
                                <span>Phones<br>Communication</span>
                        </div>
                </div>
                <div class="category-menu-list">
                        <div class="menu-item-img">
                                <div class="menu-item-icon">
                                    <span><i class="fas fa-shopping-bag"></i></span>
                                </div>
                        </div>
                        <div class="menu-item-desc">
                                <span>Bag and Shoes</span>
                        </div>
                </div>
                <div class="category-menu-list">
                        <div class="menu-item-img">
                                <div class="menu-item-icon">
                                    <span><i class="fas fa-baby"></i></span>
                                </div>
                        </div>
                        <div class="menu-item-desc">
                                <span>Mum and Kids</span>
                        </div>
                </div>
        </div> -->
    </div>
    <div class="content">
    <div id="more-to-love">
            <?php
                $get_product=get_product($conn,'4','','','',$sort_order);
                foreach($get_product as $list){
                        $img = $list['image'];
                        $img=explode(" ",$img);
                        $count=count($img)-1;
                ?>
                    <div class="product-card">
                                <div class="product-image-wrapper">
                                <a href="<?php echo SITE_PATH?>product?id=<?php echo $list['id']?>"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$img[0];
                                ?>" alt="<?php echo $list['product_name'];?>">
                                </a>
                                </div>
                                <div class="product-info">
                                <span>&#8358; <?php echo $list['price'];?></span>
                                </div>
                    </div>
                    
            <?php } ?>
        </div>
        
    </div>
    <?php require_once('footer.inc.php');?>
        <script src="js/custom.js"></script>
        </footer>
</body>
</html>