<?php require_once('top.php');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computers</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="content">
    <div class="bodyWrapper">
        <div class="sideBar">
        <span>fdbfb</span>
        </div>
        <div class="mainContainer">
            <div class="innerWrapper">
                    <div class="title">
                        <h1>Computers And Accessories</h1>
                    </div>
                    <div class="mainBody">
                        <div id="categoryContainer">
                            <?php
                            $get_product=get_product($conn,'3');
                            foreach($get_product as $list){
                                
                                $img = $list['image'];
                                $img=explode(" ",$img);
                                $count=count($img)-1;
                            ?>
                            <div class="categoryCard">
                                <div class="categoryImage">
                                <a href="<?php echo SITE_PATH?>product?id=<?php echo $list['id']?>"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$img['0'];?>" alt="<?php echo $list['product_name'];?>"></a>
                                </div>
                                <div class="categoryInfo">
                                <span><?php echo $list['product_name'];?></span>
                                <br>
                                <span>&#8358; <?php echo number_format($list['price'],2);?></span>
                                </div>

                            </div>
                            <?php } ?>
                        </div>
                    </div>
                   
            </div>
        </div>
    </div>
</div>
    <?php require_once('footer.inc.php');?>
</body>
</html>