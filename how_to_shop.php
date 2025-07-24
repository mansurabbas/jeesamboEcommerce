<?php
include("storescripts/connect_to_mysql.php");
require("top.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
        <div class="content">
            <div class="general_terms">
            <span style="font-size: 34px; color: #f49719; margin-top: -10px;">How To Shop</span><br> 
            </div><br>
            <div class="logo-deco">
                        
            </div>

                <div id="terms_wrapper">
                        <div class="row1">
                                
                                        <div id="terms_content">
                                        <div class="-pre-note">
                                                <div class="-txt -big">To place an order:</div>
                                                <ol><li>Search for an item using the search bar</li>
                                                <li>Compare prices &amp; vendor score</li>
                                                <li>Add to your cart</li>
                                                <li>Then pay at checkout</li>
                                                </ol>
                                        </div>
                                        </div>
                        </div>

                        <center>
                        <p style="color: #f49719;">Ready to Start Shopping?</p>
                        <br>
                        <a href="<?php echo SITH_PATH ?>" class="btn">Shop Now</a>
                        </center>
                </div>
                
        </div>
                     
        


<?php require("footer.inc.php");?>
</body>
</html>