<?php 
session_start();
session_regenerate_id();
require_once("storescripts/connect_to_mysql.php");
require_once("admin/functions.php");

if(!isset($_SESSION['USER_LOGIN'])){
  $_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
  redirect('login');
}
if (isset($_SESSION['USER_ID'])) {
  $uid=$_SESSION['USER_ID'];
}

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url_array = explode("/", $url);
$id = end($url_array);

$getWalletAmt=0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/3ebb00a559.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
      /* General Reset */
      body, h2, ul, li, p, a, input {
        margin: 0;
        padding: 0;
        list-style: none;
        text-decoration: none;
        box-sizing: border-box;
      }

      body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
      }
      .content {
          overflow-y: auto; /* Enable vertical scrolling */
          overflow-x: hidden; /* Enable vertical scrolling */
          height: calc(100vh - 58px); /* Adjust height to fill the rest of the viewport */
      }
      /* Header */
      .unique-header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          background-color: #616bc4;
          color: white;
          padding: 0px 20px;
          position: sticky;
          top: 0;
          width: 100%;
          z-index: 1000;
          overflow-x: hidden;
          height: 58px; /* Adjust height to match header */
      }

      .menu-container {
        display: flex;
        align-items: center;
        gap: 7rem;
      }

      .menu-icon {
        font-size: 24px;
        cursor: pointer;
      }

      .welcome-message {
        font-size: 18px;
        margin-right: 10px;
      }
      .welcome-message a {
        color: #fff;
      }

      .logout-button {
        display: flex;
        align-items: center;
        color: white;
        margin-right: 35px;
      }

      .logout-button i {
        margin-right: 8px;
      }

      /* Sidebar */
      .unique-sidebar {
        width: 250px;
        background-color: #1e1e2d;
        color: white;
        height: calc(100vh - 58px); /* Adjusted to exclude the header height */
        position: fixed;
        top: 58px; /* Matches the header height */
        left: 0;
        overflow-y: auto;
        transition: transform 0.3s ease-in-out;
      }

      .unique-sidebar.hidden {
        transform: translateX(-250px);
      }

      .unique-logo {
        display: flex;
        align-items: center;
        padding: 20px;
        background-color: #28293d;
      }
      .unique-logo .profile-pic-wrapper p {
        color: #8d9498
      }

      .unique-logo img {
        border-radius: 50%;
        margin-right: 10px;
      }

      .nav-list li {
        padding: 15px 20px;
      }

      .nav-list a {
        display: flex;
        align-items: center;
        color: #8d9498;
      }

      .nav-list a i {
        margin-right: 10px;
      }

      .nav-list li:hover {
        background-color: #2b2b3b;
      }

      /* Main Content */
      .unique-main {
        margin-left: 250px;
        padding: 20px;
        overflow: hidden; /* Prevent scrolling issues */
        transition: margin-left 0.3s ease-in-out;
      }

      .topup-wrapper {
        max-width: 1000px;
        margin: auto;
        padding-bottom: 10px;
        max-height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        -webkit-align-items: center;
    }
    .vendorAndForm {
        display: grid;
        background: #fff;
        padding: 20px;
        max-width: 100%;
        grid-template-columns: 1fr 1fr;
        box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.1);
    }
    .topup-wrapper .vendorAndForm .topup-vendors {
        padding: 20px;
    }
    .topup-wrapper .vendorAndForm .topup-form {
        display: flex;
        align-items: center;
        justify-content: center;
        -webkit-align-items: center;
    }
    .topup-wrapper .vendorAndForm .topup-form form {
        width: 90%;
        margin: auto;
    }
    .topup-wrapper .vendorAndForm .topup-form form input,
    .topup-wrapper .vendorAndForm .topup-form form select {
        max-width: 100%;
        padding: 1rem !important;
        font-size: 1rem;
        outline-color: #fb9678;
    }
    .topup-wrapper .vendorAndForm .topup-form form input,
    .topup-wrapper .vendorAndForm .topup-form form select,
    .topup-wrapper .vendorAndForm .topup-form form #submitDataBn {
        width: 100%;
        padding: 10px;
        border: none;
        background: #f1f1f1;
    }
    .topup-wrapper .vendorAndForm .topup-form form #submitDataBn {
        background-color: #fb9678;
        color: #fff;
        border-radius: 5px;
        font-weight: 600;
        font-size: 1.6rem;
    }
    .topup-wrapper .vendorAndForm .topup-form form #submitDataBn:hover {
        cursor: pointer;
    }

    .topup-wrapper .vendorAndForm .topup-vendors span .payment_method img {
        max-width: 100%;
    }
    #login_loader {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
      background: url("icons/loaderBlack.gif") no-repeat center/50px 50px
          rgba(0, 0, 0, 0.6);
      z-index: 5;
    }

      /* Responsive Design */
      @media (max-width: 768px) {
        .unique-sidebar {
          transform: translateX(-250px);
        }

        .unique-sidebar.hidden {
          transform: translateX(0);
        }

        .unique-main {
          margin-left: 0;
        }
        .vendorAndForm {
          grid-template-columns: 1fr;
        }
        .topup-wrapper {
          width: 100%;
          padding-bottom: 0;
        }
        .welcome-message {
            margin-right: 0px;
        }
        .topup-wrapper .vendorAndForm .topup-vendors span h1{
          font-size: 1.6rem;
        }
        .topup-wrapper .vendorAndForm .topup-form form input,
        .topup-wrapper .vendorAndForm .topup-form form select {
            padding: 1rem !important;
            font-size: 0.8rem;
        }
        .topup-wrapper .vendorAndForm .topup-form form input,
        .topup-wrapper .vendorAndForm .topup-form form select,
        .topup-wrapper .vendorAndForm .topup-form form #submitDataBn {
            padding: 7px;
        }
        .topup-wrapper .vendorAndForm .topup-form form #submitDataBn {
            font-weight: 400;
            font-size: 1.3rem;
        }
        
      }

    </style>
</head>
<body id="index">

<!-- Login page Loader Container -->
<div id="login_loader"></div>

<div class="content">

   <!-- Header -->
   <header class="unique-header">
    <div class="menu-container">
      <div class="menu-icon" id="menuIcon">☰</div>
      <span class="welcome-message"><a href="<?php echo SITE_PATH?>">Jeesambo</a></span>
    </div>
    <a href="#" class="logout-button">
      <i class="fas fa-power-off"></i> Logout
    </a>
  </header>

  <!-- Left Navigation -->
  <div class="unique-sidebar" id="uniqueSidebar">
    <div class="unique-logo">
      <img src="https://via.placeholder.com/50" alt="User Logo">
      <div class="profile-pic-wrapper">
        <?php
              if (isset($_SESSION["FIRSTNAME"])) { 
                  $getWalletAmt=getWalletAmt($uid);
                  echo "<p>".$_SESSION["FIRSTNAME"]."</p>";
                  echo "<p>Balance: &#8358;".number_format($getWalletAmt,2)."</p>";
                ?>
        <?php } ?>
      </div>
    </div>
    <ul class="nav-list">
      <li>
        <a href="<?php echo SITE_PATH?>data_utility">
          <i class="fas fa-home"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li>
        <a href="<?php echo SITE_PATH?>data">
          <i class="fas fa-signal"></i>
          <p>Buy Data</p>
        </a>
      </li>
      <li>
        <a href="<?php echo SITE_PATH?>airtime">
          <i class="fas fa-phone-square"></i>
          <p>Buy Airtime</p>
        </a>
      </li>
      <li>
        <a href="#">
          <i class="fas fa-bolt"></i>
          <p>Utilities</p>
        </a>
      </li>
      <!-- <li>
        <a href="<?php //echo SITE_PATH?>fund_wallet">
          <i class="fas fa-credit-card"></i>
          <p>Fund Wallet</p>
        </a>
      </li> -->
      <li>
        <a href="<?php echo SITE_PATH?>create_account">
          <i class="fas fa-wallet"></i>
          <p>Create virtual account</p>
        </a>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <main class="unique-main">
  <div class="topup-wrapper">
        <div class="vendorAndForm">

                <div class="topup-vendors">
                    
                    <span>
                        <h1>Topup data instantly</h1>
                        <div class="payment_method">
                            <div><img src="icons/comm.jpg"></div>
                        </div>
                    </span>
                    
                </div>
                <div class="topup-form">
                      <form action="" id="myForm" method="POST">
                            <p>
                            <select name="network" id="netSelect">
                                  <option value="">Select Network</option>
                                  <option value="1">MTN</option>
                                  <option value="2">Glo</option>
                                  <option value="3">9MOBILE</option>
                                  <option value="4">AIRTEL</option>
                                 
                              </select>
                            </p>
                            <br>
                        
                              <p>
                                <select name="bundle" id="selectBox">       
                                    
                                </select>
                                </p>
                                <br>
                                <p>
                                  <input type="number" name="amount" id="inputBox" placeholder="Enter Amount" readonly><br>
                                </p>
                                <br>
                              <p>
                                  <input type="number" name="phone_number" id="phone_number" placeholder="Enter Phone Number"><br>
                                  <span id="phone_number_error" style="color:red"></span>
                              </p>
                              <br>            
                              <p>
                                  <button type="button" name="submit" id="submitDataBn" onclick="myFunction()">Top-up</button>
                              </p>
                              <input type="hidden" id="bundleAmt" value="">
                              <input type="hidden" id="userName" value="<?php echo $_SESSION['LOGIN_USERNAME'] ?>">
                      </form>
                      
                 </div>
        </div>
  </main>

</div>
<script>
  document.addEventListener("DOMContentLoaded", () => {
  const menuIcon = document.getElementById("menuIcon");
  const sidebar = document.getElementById("uniqueSidebar");

  menuIcon.addEventListener("click", () => {
    sidebar.classList.toggle("hidden");
  });
});
</script>
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

    //   document.addEventListener("DOMContentLoaded", function () {
    //     const menu = document.querySelector(".menu");
    //     const menuToggle = document.getElementById("menuToggle");

    //     // Event listener for the menu toggle icon
    //     menuToggle.addEventListener("click", function () {
    //         if (menu.style.display === "none" || menu.style.display === "") {
    //             menu.style.display = "flex";
    //         } else {
    //             menu.style.display = "none";
    //         }
    //     });
    //   });
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
    var network_name = '9MOBILE';
}
if (network==4){
    var network_name = 'AIRTEL';
}
// Type of network requested End
var bundle = document.getElementById("selectBox").value;

if (network==1) {
    // Bundle name start
    if (bundle==130) {
        var bundle_name = '500.0MB SME @ ₦ 130  30 days';
        var bundle_data_amt = '500.0MB';
    }
    if (bundle==260) {
        var bundle_name = '1.0GB SME @ ₦ 260  30 days';
        var bundle_data_amt = '1.0GB';
    }
    if (bundle==520){
        var bundle_name = '2.0GB SME @ ₦ 520  30 days';
        var bundle_data_amt = '2.0GB';
    }
    if (bundle==780){
        var bundle_name = '3.0GB SME @ ₦ 780  30 days';
        var bundle_data_amt = '3.0GB';
    }
    if (bundle==1300){
        var bundle_name = '5.0GB SME @ ₦ 1300  30 days';
        var bundle_data_amt = '5.0GB';
    }
    if (bundle==2600){
        var bundle_name = '10.0GB SME @ ₦ 2600  30 days';
        var bundle_data_amt = '10.0GB';
    }
    // Bundle name End  
}
if (network==2) {
    // Bundle name start
    if (bundle==140) {
        var bundle_name = '500.0MB CORPORATE GIFTING @ ₦ 140  30 DAYS (CG)';
        var bundle_data_amt = '500.0MB';
    }
    if (bundle==265){
        var bundle_name = '1.0GB CORPORATE GIFTING @ ₦ 265  30 DAYS (CG)';
        var bundle_data_amt = '1.0GB';
    }
    if (bundle==530){
        var bundle_name = '2.0GB CORPORATE GIFTING @ ₦ 530 30 DAYS';
        var bundle_data_amt = '2.0GB';
    }
    if (bundle==795){
        var bundle_name = '3.0GB CORPORATE GIFTING @ ₦ 795  30 DAYS (CG)';
        var bundle_data_amt = '3.0GB';
    }
    if (bundle==1325){
        var bundle_name = '5.0GB CORPORATE GIFTING @ ₦ 1325  30 DAYS (CG)';
        var bundle_data_amt = '5.0GB';
    }
    if (bundle==2650){
        var bundle_name = '10.0GB CORPORATE GIFTING @ ₦ 2650  (30days)';
        var bundle_data_amt = '10.0GB';
    }
    // Bundle name End  
}
if (network==3) {
    // Bundle name start
    if (bundle==130) {
        var bundle_name = '500.0MB CORPORATE GIFTING @ ₦ 130  [30days]';
        var bundle_data_amt = '500.0MB';
    }
    if (bundle==260) {
        var bundle_name = '1.0GB CORPORATE GIFTING @ ₦ 260  [30days]';
        var bundle_data_amt = '1.0GB';
    }
    if (bundle==520){
        var bundle_name = '2.0MB CORPORATE GIFTING @ ₦ 520  [7days]';
        var bundle_data_amt = '2.0GB';
    }
    if (bundle==780){
        var bundle_name = '3.0GB CORPORATE GIFTING @ ₦ 780  [30days]';
        var bundle_data_amt = '3.0GB';
    }
    if (bundle==1300){
        var bundle_name = '5.GB CORPORATE GIFTING @ ₦ 1300  [30days]';
        var bundle_data_amt = '5.0GB';
    }
    // Bundle name End  
}
if (network==4) {
    // Bundle name start
    if (bundle==140) {
    var bundle_name = '500.0MB CORPORATE GIFTING @ ₦ 140  30 DAYS (CG)';
    var bundle_data_amt = '500.0MB';
    }
    if (bundle==275) {
        var bundle_name = '1.0GB CORPORATE GIFTING @ ₦ 275  30 DAYS (CG)';
        var bundle_data_amt = '1.0GB';
    }
    if (bundle==550) {
        var bundle_name = '2.0GB CORPORATE GIFTING @ ₦ 550  30 DAYS (CG)';
        var bundle_data_amt = '2.0GB';
    }
    if (bundle==1375){
        var bundle_name = '5.0GB CORPORATE GIFTING @ ₦ 1375 30 DAYS';
        var bundle_data_amt = '5.0GB';
    }
    if (bundle==2750){
        var bundle_name = '10.0GB CORPORATE GIFTING @ ₦ 2750  30 DAYS (CG)';
        var bundle_data_amt = '10.0GB';
    }
    // Bundle name End  
}

var amount = document.getElementById("inputBox").value;
var phone_number = document.getElementById("phone_number").value;

if (phone_number=='') {
    var phone_number_error ='Enter phone number';
    alert(phone_number_error);
    exit();
}
if (bundle=='') {
    var bundle_error ='Enter data plan';
    alert(bundle_error);
    exit();
}
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
                    
                        var resultArray = xhr.responseText.split("|");
                        console.log(resultArray);
                        // Remove the loader response is received from the server
                        jQuery('#login_loader').hide();
                        
                        if (resultArray[0]=='lowAmt' && resultArray[1]=='low_wallet_money') {
                            swal({
                            title: "Low wallet money",
                            text: "Top up your wallet",
                            icon: "warning",
                            dangerMode: true,
                            })
                        }
                        if (resultArray[0]=='failed' && resultArray[1]=='unavailable') {
                            swal({
                            title: "This service is temporarily unavailable",
                            text: "Check back later",
                            icon: "warning",
                            dangerMode: true,
                            })
                        }
                        if (resultArray[2]=='failed'){
                            swal({
                            title: "Check Number",
                            text: "Number and network don't match",
                            icon: "warning",
                            dangerMode: true,
                            })
                        }
                        
                        if (resultArray[2]=='successful') {
                            // swal("Transaction successful", "You have successfully purchased "+bundle_data_amt+" "+network_name+" data for "+phone_number, "success");
                            swal({
                            title: "Successful",
                            text: "You have successfully purchased " + bundle_data_amt + " " + network_name + " data for " + phone_number,
                            icon: "success",
                            buttons: {
                                viewHistory: {
                                text: "View history",
                                value: "viewHistory",
                                closeModal: true
                                }
                            }
                            }).then((value) => {
                            if (value === "viewHistory") {
                                // Redirect to the transactions history page
                                window.location.href = "transactions_history"; // Replace with your actual URL
                            }
                            });


                        }
                    }
                };

                xhr.send(params);
  } else {
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

</body>
</html>