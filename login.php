<?php
// This include session, connection and functions
include("top.php");
?>
<?php
$msg='';
$email='';
$password='';
$sqlAttr='';

if(isset($_SESSION['USER_LOGIN'])){
    redirect('index');
}

if (isset($_GET['referral_code']) && $_GET['referral_code']!='') {
	$_SESSION['FROM_REFERRAL_CODE'] = clean($conn, $_GET['referral_code']);
}

function getIpAddr(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
       $ipAddr=$_SERVER['HTTP_CLIENT_IP'];
    }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
       $ipAddr=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
       $ipAddr=$_SERVER['REMOTE_ADDR'];
    }
   return $ipAddr;
}
?>

<body id="index">
	<div class="content">
	<?php include('form.php');?>
	<?php
	    if(isset($_GET["newpwd"])){
            if ($_GET["newpwd"] == "passwordupdated") {
                echo '<p class="signupsuccess">Your password has been reset</p>';
            }
        }
	?>

	</div>
<!--------------------------footer ---------------------- -->
<?php include('footer.inc.php');?>

<!--------------------- js for toggle form ---------------------------------------->
<script>
  var LoginForm = document.getElementById("LoginForm");
  var RegForm = document.getElementById("RegForm");
  var Indicator = document.getElementById("Indicator");

      function register() {
        RegForm.style.transform = "translateX(0px)";
        LoginForm.style.transform = "translateX(0px)";
        Indicator.style.transform = "translateX(100px)";
      }
      function login() {
        RegForm.style.transform = "translateX(300px)";
        LoginForm.style.transform = "translateX(300px)";
        Indicator.style.transform = "translateX(0px)";
      }
</script>

<script>
    var loader = document.getElementById("preloader");
    window.addEventListener("load", function(){
        loader.style.display = "none";
    })
</script>

<?php 
      //Email id verify
      if(isset($_GET['id']) && $_GET['id']!=''){
          $id=mysqli_real_escape_string($conn, $_GET['id']);
          mysqli_query($conn,"update users set email_verify=1 where rand_str='$id'");
          $msg="Email id verify";
          ?>
          <script>
            login();
          </script>
          <?php 
      }
  ?>

<script src="js/custom.js"></script>
<script src="js/script.js"></script>
</body>
</html>
