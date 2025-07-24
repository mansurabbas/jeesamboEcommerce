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

$sql="SELECT * FROM users WHERE id = '$uid'";
$query=mysqli_query($conn,$sql);
$count=mysqli_num_rows($query);
if ($count>0) {
    $row=mysqli_fetch_assoc($query);
    $email=$row['email'];
}

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url_array = explode("/", $url);
$id = end($url_array);

$getWalletAmt=0;

if(isset($_POST['submit'])){

    $email=$_POST['email'];
    $amount=$_POST['amount'];
    $_SESSION['FUNDING_EMAIL'] = $email;
    $_SESSION['FUNDING_AMOUNT'] = $amount;

    mysqli_query($conn, "INSERT INTO virtual_account_transactions (user_id,customer_email) VALUES('$uid','$email')");
    header("Location: https://jeesambo.com.ng/secure-notify.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create virtual account</title>
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
      * {
        max-width: 100%;
        overflow-x: hidden;
      }

      /* Header */
      .unique-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #616bc4;
        color: white;
        padding: 15px 20px;
        position: sticky;
        top: 0;
        width: 100%;
        z-index: 1000;
        overflow-x: hidden;
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
        max-width: 800px;
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
        width: 100%;
        max-width: 100%;
        grid-template-columns: 1fr;
        box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.1);
    }
    .vendorAndForm .create_top_virt {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        padding: 1rem;
    }
    .vendorAndForm .create_top_virt .left_tag {
        font-size: 1.5rem;
        font-weight: 600;
    }
    .vendorAndForm .create_top_virt .right_tag a {
        /* color: #fff; */
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
    .topup-wrapper .vendorAndForm .topup-form form .charges_div {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
    }
    .topup-wrapper .vendorAndForm .topup-form form .total_div {
        display: flex;
        justify-content: space-between;
        padding: 1rem 0;
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
        font-size: 1rem;
    }
    .topup-wrapper .vendorAndForm .topup-form form #submitDataBn:hover {
        cursor: pointer;
    }

    .topup-wrapper .vendorAndForm .topup-vendors span .payment_method img {
        max-width: 100%;
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
        .vendorAndForm .create_top_virt .left_tag {
        font-size: 1rem;
        font-weight: 600;
        }
        .welcome-message {
        margin-right: 0px;
      }
        
      }

    </style>
</head>
<body id="index">
  
<!-- Login page Loader Container -->
<div id="login_loader"></div>

<div class="content">
<!-- Loader Container -->
<div class="loader-container" id="loaderContainer">
            <div class="loader spin-animation" id="loader"></div>
</div>
<!-- Login page Loader Container -->
<div id="login_loader"></div>
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
      <li>
        <a href="<?php echo SITE_PATH?>fund_wallet">
          <i class="fas fa-credit-card"></i>
          <p>Fund Wallet</p>
        </a>
      </li>
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
          
                <div class="topup-form">
                      <form action="https://jeesambo.com.ng/fund_wallet.php" method="POST">
                            <p>
                            <input type="hidden" name="email" value="<?php echo $email ?>" placeholder="Enter Email" required><br>
                            </p>
                            <br>
                              <p>
                                  <input type="number" name="amount" id="amount" placeholder="Enter Amount" required><br>
                              </p>
                              <br>  
                              <div class="charges_div">
                                <div>Transaction charge</div>
                                <div id="charges"></div>
                              </div>
                              <hr>    
                              <div class="total_div">
                                <div>Total</div>
                                <div id="total"></div>
                              </div>      
                              <p>
                                  <button type="submit" name="submit" id="submitDataBn">Fund wallet</button>
                              </p>
                      </form>
                      
                 </div>
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
        $(document).ready(function () {
            $('#amount').on('input', function () {
                const amount = parseFloat($(this).val()) || 0;
                let charges = amount * 0.01; // Example: 1% charge
                if (charges > 300) {
                    charges = 300;
                }
                const total = amount + charges;
                $('#charges').text('N'+charges);
                $('#total').text('N'+total);
            });
        });
    </script>
</body>
</html>