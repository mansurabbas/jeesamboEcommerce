<?php
ob_start();
// This include session, connection and functions
require_once("top.php");
?>
<?php 
$cart_show = '';
$i="";
$id="";
$pid="";
$wid="";
$res="";
$key="";
$vendor_company_name='';
$mobile='';
$email='';
$stock="";
$sizeKey="";
$get_product='';
$pending_qty='';
$productSoldQtyByProductId='';
$getProductAttr='';
$latitude='';
$longitude='';
$loadFun="";
$costPerKilometer="";

?>

<?php 
// Product review start

if (isset($_POST['review_submit'])) {
    $rating = clean($conn, ucfirst($_POST["rating"]));
    $review = clean($conn, ucfirst($_POST["review"]));
    $pid = clean($conn, $_POST["pid"]);
    
    date_default_timezone_set("Africa/Lagos");
    $added_on=date('Y-m-d H:i:s');

    mysqli_query($conn, "INSERT INTO product_review(product_id,user_id,rating,review,status,added_on) VALUES('$pid','".$_SESSION["USER_ID"]."','$rating','$review','1','$added_on')");

    $pid = encryptId($pid);
    ?>
       <script>
        window.location.href="<?php echo SITE_PATH?>product?id=<?php echo $pid ?>";
        function clearForm() {
            document.getElementById("reviewForm").reset();
        }
        clearForm();
        </script>
        <?php
        die();
}
$pid = decryptId($_GET['id']);
$product_review_res = mysqli_query($conn, "SELECT users.firstname,product_review.id,product_review.rating,product_review.review,product_review.added_on FROM users,product_review WHERE product_review.status=1 AND product_review.user_id=users.id AND product_review.product_id='$pid' ORDER BY product_review.added_on DESC");
// Product review end
if(isset($_GET['id'])){ 
    
	$pid=mysqli_real_escape_string($conn, $_GET['id']);
    $pid = decryptId($pid);

    // Getting Position of the Vendor Start
    $vendor_detail = mysqli_query($conn, "SELECT admin.latitude,admin.longitude,products.added_by FROM admin,products WHERE products.id='$pid' AND admin.id=products.added_by") or die(mysqli_error($conn));
    while ($vendor_detail_row = mysqli_fetch_array($vendor_detail)) {
        
        // $vendorlat = $vendor_detail_row["latitude"];   
        // $vendorlon = $vendor_detail_row["longitude"];   
        
    }
    // Getting Position of the Vendor End
    
    //  Shipping mechanism for under 10kg
    //  0 - 5 km - Price N2500.00
    //  5 - 10 km - Price N500.00 / per km
    //  > 10 km - Price N500.00 / per km

    //  Shipping mechanism for over 10kg and under 30kg
    //  0 - 5 km - Price N4000.00
    //  6 - 15 km - Price N500.00 / per km
    //  > 16 km - Price N750 / per km
   
    function calculateDistance($lat1, $long1, $lat2, $long2) {
        $theta = $long1 - $long2;
        $miles = (sin(deg2rad($lat1))) * sin(deg2rad($lat2)) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $result['miles'] = $miles * 60 * 1.1515;
        // $result['feet'] = $result['miles'] * 5280;
        // $result['yards'] = $result['feet'] / 3;
        $result['kilometers'] = $result['miles'] * 1.609344;
        $result['meters'] = $result['kilometers'] * 1000;
        return round($result['kilometers']);
    }

    function calculateShippingCost($km, $kg) {
        // invalid weight?
        if ($kg > 30) return false;
            // determine cost parameters
            $costPerKilometer = 0.00;
        
            if( $kg <= 10 ) {
                $startingCost = 1000.00;
                if ($km > 10 ) {
                    $costPerKilometer = 2.00;
                }
                elseif ($km > 5 ) {
                    $costPerKilometer = 2.00;
                }
            } else {
                $startingCost = 400.00;
                if ($km > 15 ) {
                    $costPerKilometer = 2.00;
                }
                elseif ($km > 5 ) {
                    $costPerKilometer = 2.00;
                }
            }    

        // calculate cost based on parameters
        return $startingCost + round($km) * $costPerKilometer;
    }
    
    $km = calculateDistance($customerlat,$customerlon,$vendorlat,$vendorlon);
    $unitShippingCost=calculateShippingCost($km, 10);
    $_SESSION['ShippingCost']=$unitShippingCost;
    $unitShippingCost = $_SESSION['ShippingCost'];

    $sqlAttr=mysqli_query($conn, "SELECT product_attributes.*,color_master.color,size_master.size FROM product_attributes LEFT JOIN color_master ON product_attributes.color_id=color_master.id AND color_master.status=1 LEFT JOIN size_master ON product_attributes.size_id=size_master.id AND size_master.status=1 WHERE product_attributes.product_id='$pid'");
    $productAttr=[];
    $colorArr=[];
    $sizeArr=[];
    $sizeArr1=[];
    $colorArr1=[];
    if(mysqli_num_rows($sqlAttr)>0){
        while($rowAttr=mysqli_fetch_assoc($sqlAttr)){

            $price=$rowAttr['price'];
            $colorArr[$rowAttr['color_id']][]=$rowAttr['color'];
            $sizeArr[$rowAttr['size_id']][]=$rowAttr['size'];
            $productAttr[]=$rowAttr;

            $colorArr1[]=$rowAttr['color'];
            $sizeArr1[]=$rowAttr['size'];
            
        }
    }
    $is_color=count(array_filter($colorArr1));
    $is_size=count(array_filter($sizeArr1));
    
    // $colorArr=array_unique($colorArr);
    // $sizeArr=array_unique($sizeArr);
    
	if($pid !=''){
		$get_product=get_product($conn,'','',$pid);
        $image = $get_product['0']['image'];
        $id = $get_product['0']['id'];
        $added_by = $get_product['0']['added_by'];
        $details = $get_product['0']['details'];
        $specs = $get_product['0']['specifications'];
        $categories = $get_product['0']['categories'];
        
	}else{
		?>
		<script>
		window.location.href='<?php echo SITE_PATH?>index';
		</script>
		<?php
	}

    $resMultipleImages=mysqli_query($conn, "SELECT * FROM product_images WHERE product_id='$pid'");
    $multipleImages=[];
    if(mysqli_num_rows($resMultipleImages)>0) {
        while($rowMultipleImages=mysqli_fetch_assoc($resMultipleImages)) {
            $multipleImages[]=$rowMultipleImages['product_images'];
        }
    }

}else{
	?>
	<script>
	window.location.href='<?php echo SITE_PATH?>index';
	</script>
	<?php
}
?>
   
<body id="index" <?php //echo $loadFun?>>
<div class="content">
    <!-- Wrapper Start -->
    <div id="wrapper">
        <!-- Product Page Container Start -->
    <div class="product-page-container">
        <div class="ppc-one">
            <!-- Ppc-img Start -->
            <div class="ppc-img">
                <div class="small-images image_hover">
                    <?php if(isset($multipleImages[0])) { 
                        foreach($multipleImages AS $list) {
                            echo "<img src='".PRODUCT_MULTIPLE_IMAGE_SITE_PATH.$list."' class='small_img image_hover'/>";
                        }   
                        } 
                    ?>
                </div>

                <div class="big-img">
                    <img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image?>" id="ProductImg" class="big_img"/>
                    <div class="down-small-img-row">

                    <?php if(isset($multipleImages[0])) { 
                            foreach($multipleImages AS $list) { ?>
                        <div class="down-small-img-col">
                            <?php
                                echo "<img src='".PRODUCT_MULTIPLE_IMAGE_SITE_PATH.$list."' width='100%' class='down-small-img image_hover'>";
                                ?>
                        </div>
                    <?php } } ?>
                      

                    </div>
                </div>

            </div>
            <!-- Ppc-img End -->
            <!-- desc Start -->
            <div class="desc" >
            <!-- Product Name -->
                <h2><?php echo $get_product['0']['product_name']?></h2>
                <!-- // Product Name -->
                <!-- Price -->
                <div class="price-div">
                <span class="price"><span>&nbsp;&nbsp;₦ <?php echo number_format($get_product['0']['price'])?> </span></span><br />
                </div>
                <!-- // Price -->
                
                <!-- Categoris -->
                <div class="category-div">
                <span class="span-category"><?php echo "Category:  ".$get_product['0']['categories']; ?></span>
                </div>
                <!-- // Categoris -->
                
                <!-- Color Start-->
                <?php if($is_color>0) { ?>
                <div class="color">
                <p><span class="span-color">Color:&nbsp;&nbsp;</span></p>
                
                <ul>
                <?php 
                foreach($colorArr AS $key=>$val) {
                    echo "<li style='background-color: ".$val[0]."; border: 1px solid #ccc; border-radius: 50% '><a id='color_value' href='javascript:void(0)' onclick=loadAttr('".$key."','".$id."','color')>".$val[0]."</a></li> &nbsp;";
                    
                } ?>
                </ul>
                </div>
                <?php } ?>
                <!-- // Color End-->
                <!-- Size Start-->
                <?php if($is_size>0) { ?>
                <div class="size">
                <p><span class="span-size">Size:&nbsp;&nbsp;</span></p>
                
                <select id="size_attr" onchange="showQty()">
                    <option value=''>Size</option>
                <?php 
                foreach($sizeArr AS $sizeKey=>$sizeVal) {
                
                    echo "<option value'".$sizeKey."'>$sizeVal[0]</option>";
                }
                ?>
                </select>
                </div>
                <?php } ?>
                <!-- // Size End-->
                <!-- Quantity Start -->
                <?php
                    $isQtyHide="hide";
                    
                    if($is_color==0 && $is_size==0){
                        
                        $isQtyHide="";
                    }
                ?>
                <div id="cart_attr_msg"></div>
                <div class="qty <?php echo $isQtyHide ?>" id="cart_qty">
                <p><span>Qty:&nbsp;&nbsp;&nbsp;</span></p>

                <select id="qty">
                
                </select>

                </div>
                <!-- // Quantity End-->
                <!-- Product description Start -->
                
                <h4>Description:</h4>
                <span class="span-description"><?php 

                    $detail = substr($get_product['0']['details'], 0, 400) . '...';
                    
                echo $detail ?></span></p>
                
                <!-- Product description End -->
            </div>
            <!-- desc End -->
            <!-- Pp-Side Start  -->
            <div class="pp-side">

                <!-- Availability -->
                    <?php 
                    $cart_show='yes';
                    $is_cart_box_show="hide";
                    if($is_color==0 && $is_size==0) { 
                        $is_cart_box_show="";    
                    ?>
                <div>
                    <?php
                    $getProductAttr=getProductAttr($conn,$pid);

                    $productSoldQtyByProductId=productSoldQtyByProductId($conn,$pid,$getProductAttr);
                    
                    $productQty=productQty($conn,$pid,$getProductAttr);
                    $pending_qty=$get_product['0']['qty']-$productSoldQtyByProductId;
                    $cart_show='yes';
                    if($productQty>$productSoldQtyByProductId){
                        $stock='In Stock';
                    }else{
                        $stock='Not in Stock';
                        $cart_show='';
                    }
                    
                    ?>
                    <span>Availability:</span> <?php echo $stock?>
                </div>
                <?php } ?>
                <!--Availability -->
                <!-- <div><span class="shipping"></span>Shipping: &#8358; <?php //echo number_format($unitShippingCost) ?></span></div> -->
              
                <div id="is_cart_box_show" class="<?php echo $is_cart_box_show ?>">
                    <?php 
                    $attr_id=0;
                    if (isset($_POST['cid']) && isset($_POST['sid'])) {
                        $cid = clean($conn,$_POST['cid']);
                        $sid = clean($conn,$_POST['sid']);
                        $row=mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM product_attributes WHERE color_id=$cid AND size_id=$sid"));
                        $attr_id=$row['id'];
                    }
                    ?>
              
                    <a class="Product_add_cart" href="javascript:void(0)" onclick="manage_cart('<?php echo $pid?>','add')">Add to cart</a>
                    <a class="Product_buy_now" href="javascript:void(0)" onclick="manage_cart('<?php echo $pid?>','add','yes')">Buy Now</a>

                </div>

                <div id="social_share_box">
                  <a href="http://facebook.com/sharer/sharer.php?u=<?php echo $meta_url; ?>" target="_blank"><img src="icons/facebook.png" ></a>
                  <a href="http://twitter.com/intent/tweet?url=<?php echo $get_product['0']['product_name']; ?>&url=<?php echo $meta_url; ?>" target="_blank"><img src="icons/twitter.png" ></a>
                  <a href="http://linkedin.com/shareArticle?mini=true&url=<?php echo $get_product['0']['product_name']; ?>&url=<?php echo $meta_url; ?>" target="_blank"><img src="icons/linkedin.png" ></a>
                  <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($get_product['0']['product_name']); ?> <?php echo $meta_url; ?>" target="_blank"><img src="icons/whatsapp.png" ></a>
                  <!-- <a href="https://www.instagram.com/sharer.php?u=<?php //echo urlencode($get_product['0']['product_name']); ?> <?php //echo $meta_url; ?>" target="_blank"><img src="icons/instagram.jpg" ></a> -->
                </div>
                <div class="location_delivery_return">

                    <h4>Choose your location</h4>
                    <div>
                        <label for="state">State: </label>
                        <select name="state" id="state">
                            <option value="0">Select state</option> 
                                <?php

                                    $fetch_state = mysqli_query($conn, "SELECT * FROM tbl_state");
                                    while($state = mysqli_fetch_array($fetch_state)){
                                        $selected = ($state['name'] == 'Kaduna') ? 'selected' : '';
                                    ?>    
                                    <option value="<?php echo $state['id']; ?>" <?php echo $selected; ?>><?php echo $state['name']; ?></option>
                                <?php } ?>
                        </select>

                    </div>
                    <div>
                        <label for="city">City: </label>
                        <select name="city" id="city">
                            <option>Select city</option>

                        </select>
                    </div>

                    <div class="delivery_return_wrapper">
                        <!-- <div class="item">
                            <div class="icon">
                            <i class="fas fa-truck"></i>
                            </div>

                            <div class="detail_desc">
                                <div class="headings">
                                        <div>Door Delivery</div>
                                        <div><a href="#">Details</a></div>
                                </div>
                                <div class="body_content">
                                    <div>Delivery Fees #650</div>
                                </div>
                            </div>
                        </div> -->

                        <div class="item">
                            <div class="icon">
                            <i class="fas fa-truck"></i>
                            </div>

                            <div class="detail_desc">
                                <div class="headings">
                                        <span>Pickup station</span>
                                        <a href="javascript:void(0)" onclick="pickFunction()">Details</a>
                                </div>
                                <div class="body_content">
                                    <span class="fees" style="font-size: 1.4rem">Delivery Fees </span>
                                    <span style="font-size: 1.4rem">&nbsp;&nbsp;&nbsp; &#8358</span>
                                    <span id="shipping_rate" style="font-size: 1.4rem"></span>
                                </div>
                            </div>
                        </div>
                        <hr style=" margin-bottom: 1.2rem">
                        <div class="item">
                            <div class="icon">
                            <i class="fa fa-undo"></i>
                            </div>

                            <div class="detail_desc">
                                <div class="headings">
                                        <span>Return Policy</span>
                                        <a href="javascript:void(0)" onclick="returnFunction()">Details</a>
                                </div>
                                <div class="body_content">
                                    <span class="policy" style="font-size: 1.4rem">Free return within 7 days for ALL eligible items</span>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>

            </div>
            <!-- Pp-Side End  -->
        </div>
        <!-- <hr id="hr"> -->
        <input type="hidden" id="cid">
        <input type="hidden" id="sid">
    </div>
    <!-- Product Page Container End -->
    
    <!-- Recently Viewed Product Start -->
        <div id="recent_wrap">
                <h2 id="tag">Recently Viewed</h2>              
        </div>
        <div id="recent-wrapper">
                <?php 
                //unset($_COOKIE['recently_viewed']);
                
                if(isset($_COOKIE['recently_viewed'])) {
                    $arrRecentView=unserialize($_COOKIE['recently_viewed']);
                    $countRecentView=count($arrRecentView);
                    $countStartRecentView=$countRecentView-4;
                    if($countRecentView>4) {
                        $arrRecentView=array_slice($arrRecentView,$countStartRecentView,4);
                    }
                    $recentViewId=implode("','",$arrRecentView);
                    
                    $sql=mysqli_query($conn, "SELECT products.*,product_attributes.price,product_attributes.qty FROM products,product_attributes WHERE products.id=product_attributes.id AND products.id IN ('$recentViewId')") or die (mysqli_error($conn));
                ?>

                            <?php
                            
                            while($list=mysqli_fetch_assoc($sql)) {
                                
                                $image = $list['image'];
                                $newId = $list['id'];

                            ?>
                            <div class="recent-card">
                                    <div class="img-recent-card">
                                    <?php 
                                        $encryptedId = encryptId($newId);
                                    ?>
                                        <a href="<?php echo SITE_PATH?>product?id=<?php echo $encryptedId?>"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$list['image'];?>" alt="<?php echo $list['product_name'];?>">
                                        </a>
                                    </div>
                                    <div class="img-recent-info">
                                        <?php 
                                                if ($list['order_from_abroad'] != '' && $list['order_from_abroad'] != 'no') { ?>
                                                    <span class="order-abroad"> <?php echo $list['order_from_abroad'] ?> </span>
                                        <?php } ?>
                                        <span class="product_name"><?php echo $list['product_name'];?></span>
                                        <span class="price">&#8358; <?php echo number_format($list['price'],2);?></span>
                                    </div>
                            </div>
                            <?php } ?>

        </div>
        <?php
            $arrRec=unserialize($_COOKIE['recently_viewed']);
            if(($key=array_search($pid,$arrRec)) !==false) {
                unset($arrRec[$key]);
            }
            $arrRec[]=$pid;
            setcookie('recently_viewed',serialize($arrRec),time()+60*60*24*365);
        } else {
            $arrRec[]=$pid;
            setcookie('recently_viewed',serialize($arrRec),time()+60*60*24*365); 
        }  
        ?>
    <!-- <hr id="hr"> -->
        <!-- Recently Viewed Product End -->
        
         <!-- Tabs Start -->
        <div class="mytabs">
                <input type="radio" id="tabfree" name="mytabs" checked="checked">
                <label for="tabfree"><span id="label_deco">Specification</span></label>
                <div class="tab">
                    <p style="max-width: 100%"><?php echo $specs; ?></p>
                </div>

                <input type="radio" id="tabsilver" name="mytabs">
                <label for="tabsilver"><span id="label_deco">Reviews</span></label>
                <div class="tab">
                <?php 
                    if(mysqli_num_rows($product_review_res)>
                    0){

                    while($product_review_row=mysqli_fetch_assoc($product_review_res)) {

                    ?>
                <article class="comment-rating">
                    <span>  <?php echo $product_review_row['rating'] ?></span><span style="color: green"> -  <?php echo $product_review_row['firstname'] ?> </span><br>
                    <span>
                        <?php 
                        $added_on=$product_review_row['added_on'];
                        $added_on = facebook_time_ago($added_on);
                        echo $added_on;
             
                        ?>
                    </span><br>
                    <span style="max-width: 100%">  <?php echo $product_review_row['review'] ?> </span><br><br><br>
                </article>

                <?php } }else {
                    echo "<h3 class='submit_review_hint'>No review added</h3>";
                }
                ?>

                <h2 class="review_heading">Enter your review</h2>
                <?php
                if(isset($_SESSION['USER_LOGIN'])) {
                    
                ?> 
                <form action="" method="POST" id="reviewForm">
                <select name="rating" id="rating" required>
                <option value="" selected disabled>
                Select rating
                </option>
                <option value="good">
                Good
                </option>
                <option value="very good">
                Very Good
                </option>
                <option value="bad">
                Bad
                </option>
                <option value="worse">
                Worse
                </option>
                </select><br><br>
                <textarea name="review" id="review" cols="30" rows="10" style="width: 100%" placeholder="Please enter your review" required></textarea><br><br>
                <input type="hidden" name="pid" id="pid" value="<?php echo $pid ?>">
                <input type="submit" name="review_submit" id="review_submit" value="Review">
                </form>
                <p></p>
                <?php } else { echo "<span class='submit_review_hint'>Please <a href='".SITE_PATH."login' style='color: #fb9678; font-weight: bold'>login</a> to submit your review</span>"; } ?>
                </div>

                <input type="radio" id="office_address" name="mytabs">
                <label for="office_address"><span id="label_deco">Description</span></label>
                <div class="tab"><p style="max-width: 100%">
                <?php 
                echo $details; ?>
                </p></div>

              


    </div>
        <!-- Tabs End -->

    </div>
    <!-- Wrapper End -->
    

    </div>
</div>

    <?php require_once('footer.inc.php');?>

<!-- ----------------  Zoom Image -------------- -->
<script src="zoomsl.js" type="text/javascript"></script>
<!-- Product Hover -->
<script type="text/javascript">
$(document).ready(function(){
    $(".image_hover").hover(function(){
        $(".big_img").attr('src',$(this).attr('src'));
    });
});
</script>
<!-- Product Zoom -->
<script  type="text/javascript">
 var w = window.innerWidth
 if(w >= 1300) {
    $(document).ready(function(){
    $(".big_img").imagezoomsl({
        zoomrange: [3,3]
    });
 });
 }
</script>



<script>
let is_color='<?php echo $is_color ?>';
let is_size='<?php echo $is_size ?>';
let pid='<?php echo $pid ?>';
</script>
<script>
        function pickFunction() {
            return swal("Delivery time starts from the day you place your order to the day your order arrives at the pickup station. You will be notified of your order's arrival, and you have to retrieve it within 5 days. If the order is not picked up, it will be automatically cancelled.");
        }
        function returnFunction() {
            return swal("Free return within 7 days for ALL eligible items.");
        }
</script>

<script type="text/javascript">
  $(document).ready(function(){
        // Default Before anything is selected = sending state id to server
        var state_id = $('#state').val();
        if(state_id=='0') {
            $("#city").html('<option value="0">Select City</option>');
        } else {
            $("#city").html('<option value="0">Select City</option>');
            $.ajax({
                url: 'get-data.php',
                method: 'post',
                data: {state_id: state_id, type:'default'},
                success: function(result) {
                    $("#city").append(result);
                    $("#shipping_rate").html('1500');
                }
            });
        }
        // Default Before anything is selected = sending city id to server
        var city_id = $('#city').val();
            if(city_id=='0') {
                $("#city").html('<option value="0">Select City</option>');
            } else {
                $("#city").html('<option value="0">Select City</option>');
                $.ajax({
                    url: 'get-data.php',
                    method: 'post',
                    data: {city_id: city_id, type:'city'},
                    success: function(result) {
                        $("#shipping_rate").html(result);
                    }
                });
            }

        // After state is selected
        $("#state").change(function(){
            var state_id = $(this).val();
            if(state_id=='0') {
                $("#city").html('<option value="0">Select City</option>');
            } else {
                $("#city").html('<option value="0">Select City</option>');
                $.ajax({
                    url: 'get-data.php',
                    method: 'post',
                    data: {state_id: state_id, type:'state'},
                    success: function(result) {
                        $("#city").append(result);
                    }
                });
            }

        });
        // After city is selected
        $("#city").change(function(){
            var city_id = $(this).val();
            var state_id = $('#state').val();
            if(city_id=='0') {
                $("#city").html('<option value="0">Select City</option>');
            } else {
                $.ajax({
                    url: 'get-data.php',
                    method: 'post',
                    data: {city_id: city_id, state_id: state_id, type:'city'},
                    success: function(result) {
                        $("#shipping_rate").html(result);
                    }
                });
            }

        });
  });
</script>
<script>
    window.addEventListener('load', function () {
    document.querySelectorAll('.tab p').forEach(paragraph => {
        paragraph.style.width = '100%'; // Adjust as needed
    });
    });
</script>
<script src="js/custom.js"></script>
<?php ob_flush();?>
</body>
</html>

<!-------------------- js for product gallery  -------------------------------->
<!-- <script>  
          var ProductImg = document.getElementById("ProductImg");
          var SmallImg = document.getElementsByClassName("down-small-img");
          SmallImg[0].onclick = function() {
              ProductImg.src = SmallImg[0].src;
          }
          SmallImg[1].onclick = function() {
              ProductImg.src = SmallImg[1].src;
          }
          SmallImg[2].onclick = function() {
              ProductImg.src = SmallImg[2].src;
          }
          SmallImg[3].onclick = function() {
              ProductImg.src = SmallImg[3].src;
          }
          SmallImg[4].onclick = function() {
              ProductImg.src = SmallImg[4].src;
          }
</script> -->


