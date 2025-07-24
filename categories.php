<?php 
$brand='';
$product_name='';
$image='';
require_once('top.php');

include("Product_custom.php");
$product = new ProductCustom();
$categories = $product->getCategories();
$brands = $product->getBrand();
$products = $product->getProducts();
$totalRecords = $product->getTotalProducts();
?>

<div class="content">
    <div class="bodyWrapper">
        <div class="sideBar">
            <div class="panel list">
                <span>
                    <form action="" method="post" id="search_form">
                    <div class="panel-heading"><h3 class="panel-title" data-toggle="collapse" data-target="#panelOne" aria-expanded="true">Categories</h3></div>
                    <ul>
                        <?php 
                        foreach ($categories as $key => $category) {
                            if(isset($_POST['category'])) {
                                if(in_array($product->cleanString($category['categories_id']),$_POST['category'])) {
                                    $categoryCheck ='checked="checked"';
                                } else {
                                    $categoryCheck="";
                                }
                            }
                        ?>
                        <li><div class="checkbox"><label><input type="checkbox" value="<?php echo $product->cleanString($category['categories_id']); ?>" <?php echo @$categoryCheck; ?> name="category[]" class="sort_rang category"><?php echo ucfirst($category['categories']); ?></label></div></li>
                        <?php } ?>
                    </ul>
                    
                </span>
            </div>

            <div class="panel list">
            <div class="panel-heading"><h3 class="panel-title" data-toggle="collapse" data-target="#panelOne" aria-expanded="true">Sort By</h3></div>
                <span>
                        <div class="radio disabled">
                        <label><input type="radio" name="sorting" value="newest" <?php if(isset($_POST['sorting']) && ($_POST['sorting'] == 'newest' || $_POST['sorting'] == '')) {echo "checked";} ?> class="sort_rang sorting">Newest</label>
                        </div> 
                        <div class="radio">
                            <label><input type="radio" name="sorting" value="low" <?php if(isset($_POST['sorting']) && $_POST['sorting'] == 'low') {echo "checked";} ?> class="sort_rang sorting">Price: Low to High</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="sorting" value="high" <?php if(isset($_POST['sorting']) && $_POST['sorting'] == 'high') {echo "checked";} ?> class="sort_rang sorting">Price: High to Low</label>
                        </div>
                    
                </span>
            </div>

            <div class="panel list">
            <div class="panel-heading"><h3 class="panel-title" data-toggle="collapse" data-target="#panelOne" aria-expanded="true">Brand</h3></div>
                <span>
                   
                        <?php 
                        $brand='';
                        foreach ($brands as $key => $brand) {
                            if(isset($_POST['brand'])) {
                                if(in_array($product->cleanString($brand['brand']),$_POST['brand'])) {
                                    $brandChecked ='checked="checked"';
                                } else {
                                    $brandChecked="";
                                }
                            }
                        ?>
                    <ul>
                        <li><div class="checkbox"><label><input type="checkbox" value="<?php echo $product->cleanString($brand['brand']); ?>" <?php echo @$brandChecked; ?> name="brand[]" class="sort_rang brand"><?php echo ucfirst($brand['brand']); ?></label></div></li>
                        <?php } ?>
                        
                    </ul>
                    <input type="hidden" id="totalRecords" value="<?php echo $totalRecords; ?>">
                    </form>
                    
                </span>
            </div>
        
        </div>


        <div class="mainContainer">
            <div class="innerWrapper">
                    <!-- title -->
                    <div class="title">
                        <h1><?php //echo $category['categories']; ?></h1>
                    </div>
                    <!-- title -->
                    <!-- product card -->
                        <div id="recent-wrapper" class="result">

                        </div>
                    <!-- product card -->
            </div>
        </div>

    </div>
</div>
    <?php require_once('footer.inc.php');?>
    <script src="js/script.js"></script>
    <!-- <script>
        var loader = document.getElementById("preloader");
        window.addEventListener("load", function(){
            loader.style.display = "none";
        })
</script> -->
</body>
</html>