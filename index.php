<?php require_once('top.php');?>
<?php 
    $loadFun="";
    $time=time();
    if(!isset($_SESSION['USER_LOGIN'])) {
        $_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
    }

?>

<body id="index">

    <div class="content">
        
            <!-- Front Barner And Description-->
       <div id="wrapper">
      
       <div class="container-2">
        <!-- Left Div -->
        <div class="left">
                <div class="top-div">
                    <div class="wrap">
                        <div class="inner-wrap">
                            <p>Jeesambo, as an e-commerce marketplace, offers a wide variety of physical goods including electronics, fashion, and personal care products. Customers can shop for items like smartphones, laptops, clothing, shoes, furniture directly from their devices. With detailed product descriptions, customer reviews, and secure payment options, Jeesambo provides a seamless shopping experience. Integrated shipping and delivery services ensure customers receive their orders at their doorsteps. Jeesambo also helps sellers expand their reach, offering a global platform for showcasing their products.</p>
                        </div>
                    </div>
                </div>
                <div class="bottom-div">
                    <div class="wrap">
                        <div class="inner-wrap">
                            <p>We sell cheap data and airtime for network such as MTN, GLO, AIRTEL, and 9MOBILE.</p>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Middle Div with Rotating Banner -->
        <div class="middle">
            <div id="banner-wrapper" class="banner-wrapper">
                <div id="banner" class="banner">
                <?php 
                $banner_res = mysqli_query($conn, "SELECT * FROM banner WHERE status='1' ORDER BY order_number");
                $images = [];
                while($banner_row = mysqli_fetch_assoc($banner_res)) {
                    $images[] = SITE_BANNER_IMAGE . $banner_row['image'];
                }
                ?>
                </div>

                <!-- Left and Right Arrows -->
                <div class="arrow-left">&#10094;</div>
                <div class="arrow-right">&#10095;</div>

                <!-- Indicator -->
                <div class="indicator">
                    <?php for($i = 0; $i < count($images); $i++): ?>
                        <span class="dot" data-index="<?php echo $i; ?>"></span>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <!-- Right Div -->
        <div class="right">
                <div class="top-div">
                <div class="wrap">
                    <div class="inner-wrap">
                        <div class="call-icon">
                        <i class="fas fa-phone"></i>
                        </div>
                        <div class="call">
                            <span>CALL TO ORDER</span><br>
                            <a href="tel:1234567890"><small>+234 803 445 1240</small></a>
                        </div>
                    </div>
                    <div class="inner-wrap"> 
                        <div class="call-icon">
                        <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="sell">
                        <a href="https://jeesambo.com.ng/seller_signup"><span>Sell On Jeesambo</span></a>
                        </div>
                    </div>
                </div>
                </div>
                <div class="bottom-div">
                <div class="wrap">
                    <div class="inner-wrap">
                        <span>Make money on jeesambo</span>
                        <div class="txt">
                        <ul>
                            <li><p>List your product(s) for free on jeesambo and pay only 5% commission when you sell your product(s).</p></li>
                            <li><p>Create account and send your referral link to get commission on every purchase.</p></li>
                        </ul>
                        </div>
                    </div>
                    
                </div>

                </div>
                </div>
            </div>

       
     <div class="product_display_container">
            <!-- Featured Product Display Start-->
             <!-- Testing -->
             <?php $get_product=get_product($conn,'7','','','','ORDER BY products.id asc','','','',''); ?>
             <?php if ($get_product) { ?>
             <div class="row_wrapper">
             <div class="test_wrap">
                <span id="feature_name">Featured Product</span>
                <span id="view_more"><a href="<?php echo SITE_PATH?>categories">view more</a></span>
             </div>
                    <div id="home-wrapper">
                            <?php
                            $get_product=get_product($conn,'5','','','','ORDER BY products.id asc','','','','');
                            foreach($get_product as $list){
                                
                                $image = $list['image'];
                                $newId = $list['id'];

                            ?>
                            <div class="home-card">
                                    <div class="img-home-card">
                                    <?php 
                                        $encryptedId = encryptId($newId);
                                    ?>
                                    <a href="<?php echo SITE_PATH?>product?id=<?php echo $encryptedId?>"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image;?>" alt="<?php echo $list['product_name'];?>"></a>
                                    </div>
                                    <div class="img-home-info">
                                        <?php 
                                            if (($list['order_from_abroad'] != '' && $list['order_from_abroad'] != 'no')) { ?>
                                                <span class="order-abroad"> <?php echo $list['order_from_abroad'] ?> </span><br>
                                        <?php } ?>
                                        <span class="product_name"><?php echo $list['product_name'];?></span>
                                        <span class="price"><span>&#8358; </span><?php echo number_format($list['price']);?></span>
                                    </div>
                                    
                            </div>
                            
                            <?php } ?>
                
                    </div>
              </div>
              <?php } ?>
             <!-- Testing -->
             <!-- Featured Product Display End-->
             <!-- New Arrival Display Start-->
             <!-- Testing -->
             <?php $get_product=get_product($conn,'5','','','','','','','',''); ?>
             <?php if ($get_product) { ?>
             <div class="row_wrapper">
                     <div class="test_wrap">
                        <span id="feature_name">New Arrivals</span>
                        <span id="view_more"><a href="<?php echo SITE_PATH?>categories">view more</a></span>
                     </div>
                     <div id="home-wrapper">
                            <?php
                            $get_product=get_product($conn,'5','','','','','','','','');
                            foreach($get_product as $list){
                                
                                $image = $list['image'];
                                $newId = $list['id'];

                            ?>
                            <div class="home-card">
                                    <div class="img-home-card">
                                    <?php 
                                        $encryptedId = encryptId($newId);
                                    ?>
                                    <a href="<?php echo SITE_PATH?>product?id=<?php echo $encryptedId?>"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image;?>" alt="<?php echo $list['product_name'];?>"></a>
                                    </div>
                                    <div class="img-home-info">
                                        <?php 
                                            if (($list['order_from_abroad'] != '' && $list['order_from_abroad'] != 'no')) { ?>
                                                <span class="order-abroad"> <?php echo $list['order_from_abroad'] ?> </span><br>
                                        <?php } ?>
                                        <span class="product_name"><?php echo $list['product_name'];?></span>
                                        <span class="price">&#8358; <?php echo number_format($list['price']);?></span>
                                    </div>
                                    
                            </div>
                            
                            <?php } ?>
                
                     </div>
             </div>
             <?php } ?>
             <!-- Testing -->
             <!-- New Arrival Display End-->
             <!-- Best Seller Display Start-->
             <!-- Testing -->
             <?php $get_product=get_product($conn,'5','','','','','yes','','',''); ?>
             <?php if ($get_product) { ?>
             <div class="row_wrapper">
             <div class="test_wrap">
                <span id="feature_name">Best Seller</span>
                <span id="view_more"><a href="<?php echo SITE_PATH?>categories">view more</a></span>
             </div>

                    <div id="home-wrapper">
                            <?php
                            $get_product=get_product($conn,'5','','','','','yes','','','');
                            foreach($get_product as $list){
                                
                                $image = $list['image'];
                                $newId = $list['id'];

                            ?>
                            <div class="home-card">
                                    <div class="img-home-card">
                                    <?php 
                                        $encryptedId = encryptId($newId);
                                    ?>
                                    <a href="<?php echo SITE_PATH?>product?id=<?php echo $encryptedId?>"><img src="<?php echo PRODUCT_IMAGE_SITE_PATH.$image;?>" alt="<?php echo $list['product_name'];?>"></a>
                                    </div>
                                    <div class="img-home-info">
                                        <?php 
                                            if (($list['order_from_abroad'] != '' && $list['order_from_abroad'] != 'no')) { ?>
                                                <span class="order-abroad"> <?php echo $list['order_from_abroad'] ?> </span><br>
                                        <?php } ?>
                                        <span class="product_name"><?php echo $list['product_name'];?></span>
                                        <span class="price">&#8358; <?php echo number_format($list['price']);?></span>
                                    </div>
                                    
                            </div>
                            
                            <?php } ?>
                
                    </div>
             </div>
             <?php } ?>
             <!-- Testing -->
             <!-- Best Seller Display End-->

              <!-- More To Love Display Start-->
             <!-- Testing -->
             <div class="row_wrapper">
             <div class="test_wrap">
                <span id="feature_name">More To Love</span>
             </div>

                    <div id="home-wrapper" class="results">
                            

                    </div>
              </div>
             <!-- Testing -->
             <!-- More To Love Display End-->

   
        
   </div> 
</div>
</div>
<?php require_once('footer.inc.php');?>
<!-- Slider start -->
<script>
    var images = <?php echo json_encode($images); ?>;
</script>
<script>
    var currentIndex = 0;
    var bannerDiv = document.getElementById('banner');
    var dots = document.querySelectorAll('.dot');
    var totalImages = images.length;

    function changeBannerImage(index) {
        currentIndex = index !== undefined ? index : (currentIndex + 1) % totalImages;
        
        // Update the banner image
        bannerDiv.innerHTML = '<img src="' + images[currentIndex] + '" />';
        
        // Update the dots' active state
        updateDots();
    }

    function updateDots() {
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentIndex);
        });
    }

    // Auto slide every 3 seconds
    var slideInterval = setInterval(changeBannerImage, 3000);

    // Left arrow click
    document.querySelector('.arrow-left').addEventListener('click', function() {
        clearInterval(slideInterval);
        currentIndex = (currentIndex - 1 + totalImages) % totalImages;
        changeBannerImage(currentIndex);
        slideInterval = setInterval(changeBannerImage, 3000); // Restart interval
    });

    // Right arrow click
    document.querySelector('.arrow-right').addEventListener('click', function() {
        clearInterval(slideInterval);
        changeBannerImage();
        slideInterval = setInterval(changeBannerImage, 3000); // Restart interval
    });

    // Dot indicators click
    dots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
            clearInterval(slideInterval);
            changeBannerImage(index);
            slideInterval = setInterval(changeBannerImage, 3000); // Restart interval
        });
    });

    // Start with the first image
    changeBannerImage(0);
</script>

<!-- Slider end -->
    
    <script>
        var loader = document.getElementById("preloader");
        window.addEventListener("load", function(){
            loader.style.display = "none";
        })
    </script>
    <script>
        const banners = document.querySelectorAll('.banner');
        let currentBanner = 0;

        function showNextBanner() {
            banners[currentBanner].classList.remove('active');
            currentBanner = (currentBanner + 1) % banners.length;
            banners[currentBanner].classList.add('active');
        }

        setInterval(showNextBanner, 3000);
    </script>

</body>
</html>