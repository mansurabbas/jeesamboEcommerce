<?php
session_start();
include("storescripts/connect_to_mysql.php");
include("admin/functions.php");

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

?>
<?php
    $loadFun="";
    $vendorlat='';
    $vendorlon='';
    if(isset($_SESSION['vendorlat']) && isset($_SESSION['vendorlon'])){
	// $vendorlat=$_SESSION['vendorlat'];
	//  $vendorlon=$_SESSION['vendorlon'];
	
    }else{
    	$loadFun="onload='getLocation()'";
    }
?>
<?php
$shop_name='';
$email_address='';
$password='';
$confirm_password='';
$agreement='';
$first_name='';
$last_name='';
$middle_name='';
$nationality='';
$date_of_birth='';
$fileField='';
$mobile_number='';
$email_address='';
$name='';  
$iv='';  
$fileField='';  
$temp_name='';
$product_available='';
$address='';
$email_address='';
$company_phone_number='';
$business_reg_no='';
$business_type='';
$tin='';
$msg='';
$page_title='';

$script_name=$_SERVER['SCRIPT_NAME'];
$script_name_arr=explode('/',$script_name);
$mypage=$script_name_arr[count($script_name_arr)-1];
$meta_title="Jeesambo";
$meta_desc="Jeesambo";
$meta_keyword="Jeesambo";
$meta_url="localhost/mystore/";
$meta_image="";
if($mypage=='seller_signup.php'){
    $page_title='Seller Registration';
}
?>
<?php
// registration proccess step 1
if (isset($_POST['step2'])) {
        
        $shop_name = mysqli_real_escape_string($conn, $_POST["shop_name"]); 
        $email_address = mysqli_real_escape_string($conn, $_POST["email_address"]); 
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $confirm_password = mysqli_real_escape_string($conn, $_POST["confirm_password"]);
        $confirm_password_hash = password_hash($confirm_password, PASSWORD_DEFAULT);
        $agreement = mysqli_real_escape_string($conn, $_POST["agreement"]);

        $_SESSION['SHOP_NAME']=$shop_name;
        $_SESSION['EMAIL']=$email_address;
        $_SESSION['PASSWORD']=$password_hash;
        $_SESSION['CONFIRM_PASSWORD_HASH']=$confirm_password_hash;
        $_SESSION['AGREEMENT']=$agreement;

}

// registration proccess step 2
if (isset($_POST['step3'])) {

			$product_available = mysqli_real_escape_string($conn, $_POST["product_available"]);
			$address = mysqli_real_escape_string($conn, $_POST["address"]); 
			$business_email_address = mysqli_real_escape_string($conn, $_POST["business_email_address"]);
			$company_phone_number = mysqli_real_escape_string($conn, $_POST["company_phone_number"]);
			$business_reg_no = mysqli_real_escape_string($conn, $_POST["business_reg_no"]);
			$business_type = mysqli_real_escape_string($conn, $_POST["business_type"]);
			$tin = mysqli_real_escape_string($conn, $_POST["tin"]);

                        $_SESSION['PRODUCT_AVAILABLE']=$product_available;
                        $_SESSION['ADDRESS']=$address;
                        $_SESSION['BUSINESS_EMAIL_ADDRESS']=$business_email_address;
                        $_SESSION['COMPANY_PHONE_NUMBER']=$company_phone_number;
                        $_SESSION['BUSINESS_REG_NO']=$business_reg_no;
                        $_SESSION['BUSINESS_TYPE']=$business_type;
                        $_SESSION['TIN']=$tin;
                

}
// registration proccess step 3
if (isset($_POST['submit'])) {

        // $iv=openssl_random_pseudo_bytes(16);
        $first_name = mysqli_real_escape_string($conn, $_POST["first_name"]);
        $middle_name = mysqli_real_escape_string($conn,$_POST["middle_name"]);
        $last_name = mysqli_real_escape_string($conn,$_POST["last_name"]);
        $nationality = mysqli_real_escape_string($conn, $_POST["nationality"]); 
        $date_of_birth = mysqli_real_escape_string($conn, $_POST["date_of_birth"]);
        $mobile_number = mysqli_real_escape_string($conn, $_POST["mobile_number"]);
        $legal_email_address = mysqli_real_escape_string($conn, $_POST["legal_email_address"]);

        $name       = $_FILES['fileField']['name'];  
        $temp_name  = $_FILES['fileField']['tmp_name'];	
        
        if($_FILES['fileField']['type']!=''){
                if($_FILES['fileField']['type']!='image/png' && $_FILES['fileField']['type']!='image/jpg' && $_FILES['fileField']['type']!='image/jpeg'){
                $msg="Please select only png,jpg and jpeg image formate";
                }
        }
        
        if($_FILES['fileField']['size']!=''){
                $size=$_FILES['fileField']['size'];
                $maxSize=2097152;
        if($size>$maxSize) {
                $msg="File size must be 2MB or less";
        }
        }

        // $email_check=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM vendor_registration WHERE email='".$_SESSION['EMAIL']."'"));
        // if($email_check>0){
        // echo "<div class='seller-container' style='margin-left:45%;padding-top:20%;font-size:22px'><div id='wrap'><div class='form-wrap'><span>Email Present</span><a href='".SITE_PATH."seller_signup' style='text-decoration:none;'> Go Back</a></div></div></div>";
        // die();
        // }else{

        // Insert user
        $tin='';
        $added_on=date('Y-m-d h:i:s');

        $sql="SELECT id,shop_name,email FROM vendor_registration where shop_name='".$_SESSION['SHOP_NAME']."' AND email='".$_SESSION['EMAIL']."'";
        $sql_run=mysqli_query($conn, $sql);

        $check_vendor=mysqli_num_rows($sql_run);
        
        if($check_vendor>0){
                $row=mysqli_fetch_assoc($sql_run);
                $vendor_id=$row['id'];
                $vendor_shop_name=$row['shop_name'];

                mysqli_query($conn,"UPDATE vendor_registration SET shop_name='".$_SESSION['SHOP_NAME']."', email='".$_SESSION['EMAIL']."', password='".$_SESSION['PASSWORD']."', confirm_password='".$_SESSION['CONFIRM_PASSWORD_HASH']."', agreement='".$_SESSION['AGREEMENT']."', product_available='".$_SESSION['PRODUCT_AVAILABLE']."', address='".$_SESSION['ADDRESS']."', business_email_address='".$_SESSION['BUSINESS_EMAIL_ADDRESS']."', business_reg_no='".$_SESSION['BUSINESS_REG_NO']."', business_type='".$_SESSION['BUSINESS_TYPE']."', company_phone_number='".$_SESSION['COMPANY_PHONE_NUMBER']."', tin='".$_SESSION['TIN']."', first_name='$first_name', last_name='$last_name', middle_name='$middle_name', nationality='$nationality', date_of_birth='$date_of_birth', id_card='$name', mobile_number='$mobile_number', legal_email_address='$legal_email_address' WHERE id='$vendor_id' ");

        }else{
                $vendor_reg_sql = "INSERT INTO vendor_registration (shop_name,email,password,confirm_password,agreement,product_available,address,business_email_address,business_reg_no,business_type,company_phone_number,tin,first_name,last_name,middle_name,nationality,date_of_birth,id_card,mobile_number,legal_email_address,added_on)
                VALUES('".$_SESSION['SHOP_NAME']."','".$_SESSION['EMAIL']."','".$_SESSION['PASSWORD']."','".$_SESSION['CONFIRM_PASSWORD_HASH']."','".$_SESSION['AGREEMENT']."','".$_SESSION['PRODUCT_AVAILABLE']."','".$_SESSION['ADDRESS']."','".$_SESSION['BUSINESS_EMAIL_ADDRESS']."','".$_SESSION['BUSINESS_REG_NO']."','".$_SESSION['BUSINESS_TYPE']."','".$_SESSION['COMPANY_PHONE_NUMBER']."','".$_SESSION['TIN']."','$first_name','$last_name','$middle_name','$nationality','$date_of_birth','$name','$mobile_number','$legal_email_address','$added_on')";
                $vendor_reg_sql=mysqli_query($conn,$vendor_reg_sql) or die("Error:". mysqli_error($conn));

                if($vendor_reg_sql){
        
                        if(isset($name) and !empty($name)){
                                $location = 'id_cards/';      
                                if(move_uploaded_file($temp_name, $location.$name)){
                                        // unset();
                                        // header("Location: seller_signup.php");
                                }
                        
        
                        }
        
                }
        }

        $sql_admin="SELECT id,username,email FROM admin where username='".$_SESSION['SHOP_NAME']."' AND email='".$_SESSION['EMAIL']."'";
                $sql_admin_run=mysqli_query($conn, $sql_admin);
                $sql_admin_check=mysqli_num_rows($sql_admin_run);
                if($sql_admin_check>0){
                        $row=mysqli_fetch_assoc($sql_admin_run);
                        $admin_id=$row['id'];
                        mysqli_query($conn,"UPDATE admin SET username='".$_SESSION['SHOP_NAME']."', email='".$_SESSION['EMAIL']."', password='".$_SESSION['PASSWORD']."', role=1, mobile='".$_SESSION['COMPANY_PHONE_NUMBER']."', status=0, latitude='$vendorlat', longitude='$vendorlon' WHERE id='$admin_id'");
                }else{
                        $admin_sql = "INSERT INTO admin (username,email,password,role,mobile,status,latitude,longitude,joined)
                        VALUES('".$_SESSION['SHOP_NAME']."','".$_SESSION['EMAIL']."','".$_SESSION['PASSWORD']."',1,'".$_SESSION['COMPANY_PHONE_NUMBER']."',0, latitude='$vendorlat', longitude='$vendorlat', '$added_on')";
                        $admin_sql=mysqli_query($conn,$admin_sql) or die("Error:". mysqli_error($conn));
                        
                        $admin_id=mysqli_insert_id($conn);

                        $time=time()+10;
                        $admin_details_sql="INSERT INTO admin_details(id,last_login) VALUES($admin_id,$time)";
                        mysqli_query($conn, $admin_details_sql) or die("Error:". mysqli_error($conn));
                }
        //}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title?></title>
    <link rel="stylesheet" href="style.css">
    <script src="//code.jquery.com/jquery-3.5.1.js"></script>
    <script>
	  function error(err){
		  //alert(err.message);
	  }
	  function success(pos){
		  var vendorlat=pos.coords.latitude;
		  var vendorlon=pos.coords.longitude;
		  jQuery.ajax({
			  url:'setVendorLatLong.php',
			  data:'vendorlat='+vendorlat+'&vendorlon='+vendorlon,
			  type:'post',
			  success:function(result){
				  //window.location.href='<?php //echo SITE_PATH?>index'
			  }
			  
		  });
	  }
	  function getLocation(){
		  if(navigator.geolocation){
			  navigator.geolocation.getCurrentPosition(success,error);
		  }else{
			  
		  }
	  }
	</script>
</head>
<body <?php echo $loadFun?>>
    <div id="preloader"></div>
    <div class="seller-container">
            <div class="seller-1">
                    <div class="logo">
                    <a href="<?php echo SITE_PATH?>index"><h1 class="seller">Jeesambo</h1></a>
                    </div>
                    <div class="claim">
                        <a href="#"><h1>Raise Claim</h1></a>
                    </div>
            </div>
            <div class="logo-deco">
                        
            </div>
            <div class="seller-2">
                            <div class="parag">
                                <h2>Create your own seller account and start selling on Jeesambo.</h2>
                                <h2><a href="<?php echo SITE_PATH?>admin/condition">Read Policies Before Creating an Account</a></h2>
                            </div>
                            <div class="steps-span">
                                            <span>Create Account</span>
                                            <span>Business Information</span>
                                            <span>Legal information </span>
                            </div>
                            
            </div>
            
            <?php 
                if(isset($_POST["step1"]))
                {
                displayStep1();
                }
                else if(isset($_POST["step2"]))
                {
                displayStep2();
                }
                else if(isset($_POST["step3"]))
                {
                displayStep3();
                }
                else if(isset($_POST["submit"]))
                {
                displayThanks();
                }
                else
                {
                displayStep1();
                }
                function setValue($filedName)
                {
                if(isset($_POST[$filedName]))
                {
                        echo $_POST[$filedName];
                }
                }
                ?>
                
    </div>

    <?php
                            function displayStep1()
                            {?>
                            <div id="wrap">
                                <div class="form-wrap">
                                        <form action="" method="post">
                                        <h1>Create Account</h1>
                                        <div class="form-input">
                                        <input type="hidden" name="product_available" value="<?php setValue("product_available")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="address" value="<?php setValue("address")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="business_email_address" value="<?php setValue("business_email_address")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="company_phone_number" value="<?php setValue("company_phone_number")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="business_reg_no" value="<?php setValue("business_reg_no")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="business_type" value="<?php setValue("business_type")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="tin" value="<?php setValue("tin")?>">
                                        </div>

                                        <div class="form-input">
                                        <input type="hidden" name="first_name" value="<?php setValue("first_name")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="last_name" value="<?php setValue("last_name")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="middle_name" value="<?php setValue("middle_name")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="nationality" value="<?php setValue("nationality")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="date_of_birth" value="<?php setValue("date_of_birth")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="fileField" value="<?php setValue("fileField")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="mobile_number" value="<?php setValue("mobile_number")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="legal_email_address" value="<?php setValue("legal_email_address")?>">
                                        </div>
                                        
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>Display Name / Shop Name* </h3></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="text" name="shop_name" class="seller_inp" id="shop_name" value="<?php setValue("shop_name")?>" required>
                                                </div>
                                        </div>
                                        <br>
                                
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>Email Address* <h3></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="text" name="email_address" class="seller_inp" id="email_address" value="<?php setValue("email_address")?>" required>
                                                </div>
                                        </div>
                        
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>Password*</h3></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="password" name="password" class="seller_inp" id="password" value="<?php setValue("password")?>" required>
                                                </div>
                                        </div>
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>Comfirm Password* </h3></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="password" name="confirm_password" class="seller_inp" id="comfire_password" value="<?php setValue("confirm_password")?>" required>
                                                </div>
                                        </div>
                                
                                        <div class="label-input">
                                                
                                                <div class="form-input">
                                                        <input type="checkbox" name="agreement" id="checkbox" value="1"   required>
                                                        &nbsp;<span>Membership Agreement*</span>
                                                </div>
                                                <br>
                                        </div>
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="submit" name="step2" class="seller_inp" value="Step2" id="submit">
                                                       
                                                </div>
                                        </div>


                                        </form>
                                
                            </div>
                            </div>
                            <?php }

                            function displayStep2()
                            {?>
                        <div id="wrap">
                           <div class="form-wrap">
                                <form action="#" method="post" enctype="multipart/form-data">
                                <h1>Business Information</h1>
                                        <div class="form-input">
                                        <input type="hidden" name="shop_name" value="<?php setValue("shop_name")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="email_address" value="<?php setValue("email_address")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="password" value="<?php setValue("password")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="confirm_password" value="<?php setValue("confirm_password")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="agreement" value="<?php setValue("agreement")?>">
                                        </div>

                                        <div class="form-input">
                                        <input type="hidden" name="first_name" value="<?php setValue("first_name")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="last_name" value="<?php setValue("last_name")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="middle_name" value="<?php setValue("middle_name")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="nationality" value="<?php setValue("nationality")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="date_of_birth" value="<?php setValue("date_of_birth")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="fileField" value="<?php setValue("fileField")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="mobile_number" value="<?php setValue("mobile_number")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="business_email_address" value="<?php setValue("business_email_address")?>">
                                        </div>

                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>Diffrent Product Available</h3></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="text" name="product_available" class="seller_inp" id="first_and_last_name" value="<?php setValue("product_available")?>">
                                                </div>
                                        </div>
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>Company registered address</h3></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="text" name="address" class="seller_inp" value="<?php setValue("address")?>">
                                                </div>
                                        </div>
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>Company contact email address</h3></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="text" name="business_email_address" class="seller_inp" value="<?php setValue("business_email_address")?>">
                                                </div>
                                        </div>
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>Company contact number</h3></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="text" name="company_phone_number" class="seller_inp" value="<?php setValue("company_phone_number")?>">
                                                </div>
                                        </div>
     
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>Business Registration N0</h3></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="text" name="business_reg_no" class="seller_inp" id="business_reg_no" value="<?php setValue("business_reg_no")?>">
                                                </div>
                                        </div>
        
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>Individual / Business Entity / company</h3></label>
                                                </div>
                                                <div class="form-input" >
                                                        <div class="form-input">
                                                                <select name="business_type" class="seller_select" id="shop" value="<?php setValue("business_type")?>">
                                                                    <option value="">Please Select</option>
                                                                    <option value="Sole proprietorship">Sole proprietorship</option>
                                                                    <option value="Partnership">Partnership</option>
                                                                    <option value="Limited liability">Limited liability</option>
                                                                </select>
                                                        </div>
                                                </div>
                                        </div>
                                        
                                        
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>Tax Identification Number (TIN)</h3></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="text" name="tin" class="seller_inp" id="password" value="<?php setValue("tin")?>">
                                                </div>
                                        </div>

                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="submit" name="step1" class="seller_inp" value="Step1" id="submit" style="width: 49.8%">
                                                        <input type="submit" name="step3" class="seller_inp" value="Step3" id="submit" style="width: 49.8%">
                                                </div>
                                        </div>
                                        </form>
                                
                            </div>
                            </div>
                            <?php }

                            function displayStep3()
                            {?>
                                <div id="wrap">
                                <div class="form-wrap">
                                <form action="#" method="post" enctype="multipart/form-data">
                                <h1>Legal Information</h1>
                                <div class="form-input">
                                        <input type="hidden" name="shop_name" value="<?php setValue("shop_name")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="email_address" value="<?php setValue("email_address")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="password" value="<?php setValue("password")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="confirm_password" value="<?php setValue("confirm_password")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="agreement" value="<?php setValue("agreement")?>">
                                        </div>

                                        <div class="form-input">
                                        <input type="hidden" name="product_available" value="<?php setValue("product_available")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="address" value="<?php setValue("address")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="business_email_address" value="<?php setValue("business_email_address")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="company_phone_number" value="<?php setValue("company_phone_number")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="business_reg_no" value="<?php setValue("business_reg_no")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="business_type" value="<?php setValue("business_type")?>">
                                        </div>
                                        <div class="form-input">
                                        <input type="hidden" name="tin" value="<?php setValue("tin")?>">
                                        </div>

                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>Full name</h3></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="text" name="first_name" class="seller_inp" id="first_and_last_name" value="<?php setValue("first_name")?>">
                                                </div>
                                        </div>
                                
                                        <div class="label-input">
                                                <div class="form-input">
                                                        <input type="text" name="last_name" class="seller_inp" id="" value="<?php setValue("last_name")?>">
                                                </div>
                                        </div>
                                        <div class="label-input">
                                                <div class="form-input">
                                                        <input type="text" name="middle_name" class="seller_inp" id="date_of_birth" value="<?php setValue("middle_name")?>">
                                                </div>
                                        </div>
                                        <br>
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>Nationality</h3></label>
                                                </div>
                                                <div class="form-input">
                                                <select name="nationality" class="seller_select" id="shop" value="<?php setValue("nationality")?>">
                                                                    <option value="">Please Select</option>
                                                                    <option value="Nigeria">Nigeria</option>
                                                                </select>
                                                </div>
                                        </div>
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>Date of Birth</h3></label>
                                                </div>
                                                <div class="form-input">
                                                <input type="date" name="date_of_birth" class="birth_select" value="<?php setValue("date_of_birth")?>">     
                                                </div>
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>ID</h3></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="file" name="fileField" class="seller_inp" value="<?php setValue("fileField")?>">
                                                </div>
                                        </div>
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>Mobile Number</h3></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="text" name="mobile_number" class="seller_inp" value="<?php setValue("mobile_number")?>">
                                                </div>
                                        </div>
     
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""><h3>Email Address</h3></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="text" name="legal_email_address" class="seller_inp" id="legal_email_address" value="<?php setValue("legal_email_address")?>">
                                                </div>
                                        </div>
                                        <div class="label-input">
                                                <div class="label">
                                                        <label for=""></label>
                                                </div>
                                                <div class="form-input">
                                                        <input type="submit" name="step2" class="seller_inp" value="Step2" id="submit" style="width: 49.8%">
                                                        <input type="submit" name="submit" class="seller_inp" value="Submit" id="submit" style="width: 49.8%">
                                                </div>
                                        </div>
                                        </form>
                                
                            </div>
                            </div>

                            <?php } 
                            
                            function displayThanks()
                            {?>
                            <div id="wrap">
                                <div class="form-wrap">
                                <div class="final-stage">
                                <h2>Your information has been submitted.</h2>
                                    <p>It will take two (2) working days to review your information.<br />
                                    we will let you know if you have been verified.<br />
                                    if not, you can re-submit your application.
                                    </p>
                                    
                                    <p>When you get the confirmation of your registration then you<br> can access your 
                                    account on this link: <br><br>

                                        https://jeesambo.com.ng/admin/index
                                    </p>
                                </div>
                            </div>
                            </div>
                            <?php } ?>

<script>
        var loader = document.getElementById("preloader");
        window.addEventListener("load", function(){
            loader.style.display = "none";
        })
</script>
</body>
</html>