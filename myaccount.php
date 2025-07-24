<?php
// This include session, connection and functions
include "top.php";
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard</title>
    <link rel="stylesheet" href="userstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
  </head>
  <body>
    <input type="checkbox" id="check">
    <!--header area start-->
    
    <!--header area end-->
    <!--mobile navigation bar start-->
    <div class="mobile_nav">
      <div class="nav_bar">
        <img src="1.png" class="mobile_profile_image" alt="">
        <i class="fa fa-bars nav_btn"></i>
      </div>
      <div class="mobile_nav_items">
        <a href="<?php echo SITE_PATH?>index"><i class="fas fa-desktop"></i><span>Profile</span></a>
        <a href="#"><i class="fas fa-cogs"></i><span>Orders</span></a>
        <a href="#"><i class="fas fa-table"></i><span>Orders</span></a>
        <a href="#"><i class="fas fa-th"></i><span>Withdraws</span></a>
      </div>
    </div>
    <!--mobile navigation bar end-->
    <!--sidebar start-->
    <div class="sidebar">
      <div class="profile_info">
        <img src="1.png" class="profile_image" alt="">
        <h4>Jessica</h4>
      </div>
      <a href="<?php echo SITE_PATH?>index"><i class="fas fa-desktop"></i><span>Profile</span></a>
      <a href="<?php echo SITE_PATH?>products"><i class="fas fa-cogs"></i><span>Orders</span></a>
      <a href="<?php echo SITE_PATH?>orders"><i class="fas fa-table"></i><span>Orders</span></a>
      <a href="<?php echo SITE_PATH?>withdraw"><i class="fas fa-th"></i><span>Withdraws</span></a>

    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <!--sidebar end-->

    <div class="container">

      <div class="items-container">


      </div>

    </div>

    <script type="text/javascript">
    $(document).ready(function(){
      $('.nav_btn').click(function(){
        $('.mobile_nav_items').toggleClass('active');
      });
    });
    </script>
<?php include('footer.inc.php'); ?>


  </body>
</html>
