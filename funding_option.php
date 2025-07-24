<?php 
require_once('top.php');
?>
<?php

$ownerName = '';
$meterNumber = '';
$minAmount = '';
$maxAmount = '';
$proceed = '';
$item_code = '';
$code = '';
$customer = '';
$message = '';
?>
<?php
    if(!isset($_SESSION['USER_LOGIN'])){
        $_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
        redirect('login');
    }
?> 

<body id="index">
<div class="content">
<!--<span class="menu-toggle" id="menuToggle" style="color: black;">&#9776;</span>-->
<div class="contained">
<?php include('side_menu.php'); ?>
<div class="content-body">

<div class="content">
    <div class="funding-popup">
    <div class="top-row">
        <!-- <div class="left" style="font-size: 1rem">Funding wallet</div>
        <div class="right" style="font-size: 1rem">X</div> -->
    </div>
    <div class="middle-row">
        <a href="<?php echo SITE_PATH?>wallet">
        <div class="card">
        <i class="fa fa-university" aria-hidden="true"></i>
        <div class="text">Paystack Automated Bank Funding</div>
        </div>
        </a>
        <a href="<?php echo SITE_PATH?>bank_payment">
        <div class="card">
        <i class="fa fa-university" aria-hidden="true"></i>
        <div class="text">Manual Bank Funding</div>
        </div>
        </a>
        <!-- <div class="card">
        <i class="fa fa-university" aria-hidden="true"></i>
        <div class="text">Text here</div>
        </div> -->
    </div>
    <div class="bottom-row">
        <!-- <button class="cancel-btn">Cancel</button> -->
    </div>
    </div>

    </div>
    </div>
</div>

<script>
      // Get references to the select and input elements
      const selectBox = document.getElementById('selectBox');
      const inputBox = document.getElementById('inputBox');
      
      // Add an event listener to the select element
      selectBox.addEventListener('change', function() {
          // Get the selected option's value
          const selectedValue = selectBox.value;

          // Update the input value based on the selected option
          inputBox.value = selectedValue;

      });

      document.addEventListener("DOMContentLoaded", function () {
        const menu = document.querySelector(".menu");
        const menuToggle = document.getElementById("menuToggle");

        // Event listener for the menu toggle icon
        menuToggle.addEventListener("click", function () {
            if (menu.style.display === "none" || menu.style.display === "") {
                menu.style.display = "flex";
            } else {
                menu.style.display = "none";
            }
        });
      });
</script>
<script>
    $("#netSelect").change(function(){
            var network = $('#netSelect').val();
            $.ajax({
                    url: 'network.php',
                    method: 'post',
                    data: {network: network},
                    success: function(result) {
                        $("#selectBox").html(result);
                    }
            });
            

        });
</script>

<script>
submitBn = document.getElementById("submitBn");
if (submitBn) {
    submitBn.addEventListener("click", myFunction);
}

function myFunction() {
    
var network = document.getElementById("netSelect").value;
var userName = document.getElementById("userName").value;

// Type of network requested Start
if (network==1) {
    var network_name = 'MTN';
}
if (network==2) {
    var network_name = 'GLO';
}
if (network==3){
    var network_name = 'AIRTEL';
}
if (network==6){
    var network_name = '9MOBILE';
}
// Type of network requested End
var bundle = document.getElementById("selectBox").value;

if (network==1) {
    // Bundle name start
    if (bundle==133) {
        var bundle_name = '500.0MB SME @ ₦ 133  30 days';
        var bundle_data_amt = '500.0MB';
    }
    if (bundle==265) {
        var bundle_name = '1.0GB SME @ ₦ 265  30 days';
        var bundle_data_amt = '1.0GB';
    }
    if (bundle==530){
        var bundle_name = '2.0GB SME @ ₦ 530  30 days';
        var bundle_data_amt = '2.0GB';
    }
    if (bundle==795){
        var bundle_name = '3.0GB SME @ ₦ 795  30 days';
        var bundle_data_amt = '3.0GB';
    }
    if (bundle==1060){
        var bundle_name = '4.0GB SME @ ₦ 1060  30 days';
        var bundle_data_amt = '4.0GB';
    }
    if (bundle==1325){
        var bundle_name = '5.0GB SME @ ₦ 1325  30 days';
        var bundle_data_amt = '5.0GB';
    }
    if (bundle==2650){
        var bundle_name = '10.0GB SME @ ₦ 2650  30 days';
        var bundle_data_amt = '10.0GB';
    }
    if (bundle==13500){
        var bundle_name = '50.0GB SME @ ₦ 13500  30 days';
        var bundle_data_amt = '50.0GB';
    }
    // Bundle name End  
}
if (network==2) {
    // Bundle name start
    if (bundle==60) {
        var bundle_name = '200.0MB CORPORATE GIFTING @ ₦ 60  30 DAYS (CG)';
        var bundle_data_amt = '200.0MB';
    }
    if (bundle==130) {
        var bundle_name = '500.0MB CORPORATE GIFTING @ ₦ 130  30 DAYS (CG)';
        var bundle_data_amt = '500.0MB';
    }
    if (bundle==238){
        var bundle_name = '1.0GB CORPORATE GIFTING @ ₦ 238  30 DAYS (CG)';
        var bundle_data_amt = '1.0GB';
    }
    if (bundle==476){
        var bundle_name = '2.0GB CORPORATE GIFTING @ ₦ 476 {14days}';
        var bundle_data_amt = '2.0GB';
    }
    if (bundle==700){
        var bundle_name = '3.0GB CORPORATE GIFTING @ ₦ 700  30 DAYS (CG)';
        var bundle_data_amt = '3.0GB';
    }
    if (bundle==1190){
        var bundle_name = '5.0GB CORPORATE GIFTING @ ₦ 1190  30 DAYS (CG)';
        var bundle_data_amt = '5.0GB';
    }
    if (bundle==2380){
        var bundle_name = '10.0GB CORPORATE GIFTING @ ₦ 2380  (30days)';
        var bundle_data_amt = '10.0GB';
    }
    // Bundle name End  
}
if (network==3) {
    // Bundle name start
    if (bundle==110) {
        var bundle_name = '500.0MB CORPORATE GIFTING @ ₦ 110  [30days] CORPORATE';
        var bundle_data_amt = '500.0MB';
    }
    if (bundle==210) {
        var bundle_name = '1.0GB CORPORATE GIFTING @ ₦ 210  [30days] CORPORATE';
        var bundle_data_amt = '1.0GB';
    }
    if (bundle==420){
        var bundle_name = '2.0MB CORPORATE GIFTING @ ₦  420  [7days]';
        var bundle_data_amt = '2.0GB';
    }
    if (bundle==1100){
        var bundle_name = '5.0GB CORPORATE GIFTING @ ₦ 1100  [30days] CORPORATE';
        var bundle_data_amt = '5.0GB';
    }
    if (bundle==3250){
        var bundle_name = '15.GB CORPORATE GIFTING @ ₦ 3250  [30days]';
        var bundle_data_amt = '15.0GB';
    }
    if (bundle==4350){
        var bundle_name = '20.0GB CORPORATE GIFTING @ ₦ 4350  [30days] CORPORATE';
        var bundle_data_amt = '20.0GB';
    }
    // Bundle name End  
}
if (network==6) {
    // Bundle name start
    if (bundle==100) {
    var bundle_name = '500.0MB CORPORATE GIFTING @ ₦ 100  30 DAYS (CG)';
    var bundle_data_amt = '500.0MB';
    }
    if (bundle==150) {
        var bundle_name = '1.0GB CORPORATE GIFTING @ ₦ 150  30 DAYS (CG)';
        var bundle_data_amt = '1.0GB';
    }
    if (bundle==265){
        var bundle_name = '2.0GB CORPORATE GIFTING @ ₦  265  30 DAYS (CG)';
        var bundle_data_amt = '2.0GB';
    }
    if (bundle==400){
        var bundle_name = '3.0GB CORPORATE GIFTING @ ₦ 400  30 DAYS (CG)';
        var bundle_data_amt = '3.0GB';
    }
    if (bundle==530){
        var bundle_name = '4.0GB CORPORATE GIFTING @ ₦  530  30 DAYS (CG)';
        var bundle_data_amt = '4.0GB';
    }
    if (bundle==655){
        var bundle_name = '5.0GB CORPORATE GIFTING @ ₦ 655  (Weekly ) (CORPORATE GIFTING)';
        var bundle_data_amt = '5.0GB';
    }
    if (bundle==1300){
        var bundle_name = '10.0GB CORPORATE GIFTING @ ₦ 1300  30 DAYS (CG)';
        var bundle_data_amt = '10.0GB';
    }
    if (bundle==2600){
        var bundle_name = '20.0GB CORPORATE GIFTING @ ₦ 2600  (Weekly) (CORPORATE GIFTING)';
        var bundle_data_amt = '20.0GB';
    }
    if (bundle==5700){
        var bundle_name = '40.0GB CORPORATE GIFTING @ ₦ 5700  (7days) (CORPORATE GIFTING)';
        var bundle_data_amt = '40.0GB';
    }
    if (bundle==6500){
        var bundle_name = '50.0GB CORPORATE CORPORATE GIFTING @ ₦  6500  30 DAYS (CG)';
        var bundle_data_amt = '50.0GB';
    }
    if (bundle==14200){
        var bundle_name = '100.0GB CORPORATE GIFTING @ ₦ 14200  30 DAYS (CG)';
        var bundle_data_amt = '100.0GB';
    }
    // Bundle name End  
}

var amount = document.getElementById("inputBox").value;
var phone_number = document.getElementById("phone_number").value;
    swal({
  title: "Dear "+userName,
  text: "Are you sure you want to purchase "+bundle_name+" "+network_name+" data for "+phone_number,
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    // console.log('Yes');
    // If confirmed, perform AJAX post request
    jQuery('#login_loader').show();
    var xhr = new XMLHttpRequest();
                var url = 'data_request.php';
                var params = 'network=' + network +
                             '&bundle=' + bundle +
                             '&amount=' + amount +
                             '&phone_number=' + phone_number;

                xhr.open('POST', url, true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Handle the response as needed
                        // console.log(xhr.responseText);
                        var result = xhr.responseText;

                        // Remove the loader response is received from the server
                        jQuery('#login_loader').hide();

                        if (result=='low_wallet_money') {
                            swal({
                            title: "Low wallet money",
                            text: "Top up your wallet",
                            icon: "warning",
                            dangerMode: true,
                            })
                        }
                        if (result=='unavailable') {
                            swal({
                            title: "This service is temporarily unavailable",
                            text: "Check back later",
                            icon: "warning",
                            dangerMode: true,
                            })
                        }
                        if (result=='success') {
                            swal("Transaction successful", "You have successfully purchased "+bundle_data_amt+" "+network_name+" data for "+phone_number, "success");

                        }
                    }
                };

                xhr.send(params);
  } else {
    // console.log('No');
        swal({
            title: "You press cancel",
            text: "",
            icon: "warning",
            successMode: true,
        })
  }
});
}
</script>
<?php require_once('footer.inc.php'); ?>
</body>
</html>