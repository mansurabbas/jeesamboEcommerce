<footer>
        <div class="container">
            <div class="sec aboutus">
                <h2>About Us</h2>
                <p>Jeesambo is among the best online shopping site in Nigeria. We are an online store where you can purchase all your electronics, as well as home appliances, kiddies items, fashion items for men, women, and children; cool gadgets, computers, groceries, automobile parts, and more on the go. What more? You can have them delivered directly to you. Whatever it is you wish to buy, Jeesambo offers you all and lots more at prices which you can trust. Shopping online in Nigeria is easy and convenient with Jeesambo. We provide you with a wide range of products you can trust. Take part in the deals of the day and discover the best prices on a wide range of products.</p>
                <p> Our newsletter subscribers and Facebook fans get to know all of our offers before anyone else such as fastival period discount.</p>
                <ul class="sci">
                    <li><a href="https://facebook.com/jeesambo"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                    <li><a href="https://twitter.com/JeesamboMall"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                    <li><a href="https://www.instagram.com/jeesambo/"><i class="fa fa-instagram" aria-hidden="true"></i></i></a></li>
                    <li><a href="https://www.youtube.com/channel/UCB3SO1FaW7uBk7K2K01FTTA"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                </ul>
            </div>
            <div class="sec quicklinks">
                <h2>Quick Links</h2>
                <ul>
                    <!--<li><a href="">About</a></li>-->
                    <li><a href="">FAQ</a></li>
                    <li><a href="<?php echo SITE_PATH?>privacy">Privacy Policy</a></li>
                    <li><a href="">Help</a></li>
                    <li><a href="<?php echo SITE_PATH?>acceptable_use_policy">Acceptable_use_policy</a></li>
                    <!--<li><a href="return_policy.php">Return Policy</a></li>-->
                    <li><a href="">Contact</a></li>
                    <li><a href="<?php echo SITE_PATH?>how_to_shop">How To Shop On Jeesambo</a></li>
                </ul>
            </div>
            <div class="sec contact">
                <h2>Contact Info</h2>
                <ul class="info">
                    <li>
                        <span><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                        <span>Pv 2 Numan road tudun wada Kaduna</span>
                    </li>
                    <li>
                        <span><i class="fa fa-phone" aria-hidden="true"></i></span>
                        <p><a href="tel:1234567890">+234 803 445 1240</a><br>
                            <a href="tel:1234567890">+234 706 391 6281</a>
                        </p>
                    </li>
                    <li>
                        <span><i class="fa fa-envelope" aria-hidden="true"></i></span>
                        <p><a href="mailto:info@jeesambo.com.ng">info@jeesambo.com.ng</a></p>
                    </li>
                </ul>
            </div>
        </div>
    </footer>
    <div class="copyright">&copy <span id="copyrights"></span> All Right Reserved</div>
<script src="js/custom.js"></script>

<!--Online Users Start-->
         <script>  
                $(document).ready(function(){
                
                 getUserStatus();
                
                 setInterval(function() {
                      updateUserStatus();
                      getUserStatus();
                 }, 3000);
                
                 function getUserStatus() {
                      $.ajax({
                           url:"get_user_status.php",
                           success:function(result){
                            $('#user_grid').html(result);
                           }
                      })
                 }
                
                 function updateUserStatus() {
                      $.ajax({
                           url:"update_user_status.php",
                           success:function()
                           {
                        
                           }
                      })
                 }
                 
                });  
        </script>
 <!--Online Users End-->
 
  <script>
    // Add a class to start the animation
    document.getElementById('loader').classList.add('spin-animation');

    // Wait for the entire page to load
    window.onload = function() {
      // Remove the loader when the page is fully loaded
      document.getElementById('loaderContainer').style.display = 'none';
      // Stop the animation by removing the class
      document.getElementById('loader').classList.remove('spin-animation');
    };
  </script>

<script>
let d=new Date();
document.getElementById('copyrights').innerHTML=d.getFullYear();
</script>

