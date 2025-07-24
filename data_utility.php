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


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://kit.fontawesome.com/3ebb00a559.js" crossorigin="anonymous"></script>
    <style>
      /* General Reset */
      body, h2, ul, li, p, a {
        margin: 0;
        padding: 0;
        list-style: none;
        text-decoration: none;
        box-sizing: border-box;
      }

      body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        overflow: hidden;
        overflow-y: scroll;
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
        color: #8d9498;
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

      .unique-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
      }

      .unique-card {
        background: white;
        padding: 20px;
        text-align: center;
        border-radius: 5px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
      }

      .unique-card img {
        width: 100px;
        margin-bottom: 10px;
      }

      .unique-card:hover {
        transform: translateY(-5px);
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
          .welcome-message {
            margin-right: 0px;
          }
      }

    </style>
</head>
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
    <div class="unique-cards">
      <div class="unique-card">
        <a href="<?php echo SITE_PATH?>airtime">
        <img src="<?php echo SITE_PATH?>icons/airtime.svg" alt="Card Image">
        <p>Buy Airtime</p>
        </a>
      </div>
      <div class="unique-card">
      <a href="<?php echo SITE_PATH?>data">
        <img src="<?php echo SITE_PATH?>icons/data.jpg" alt="Card Image">
        <p>Buy Data</p>
      </a>
      </div>
      <div class="unique-card">
      <a href="<?php echo SITE_PATH?>create_account">
        <img src="<?php echo SITE_PATH?>icons/wallet.png" alt="Card Image">
        <p>Create virtual account</p>
      </a>
      </div>
      <div class="unique-card">
      <a href="#">
        <img src="<?php echo SITE_PATH?>icons/utility.jpg" alt="Card Image">
        <p>Electricity Bills</p>
      </a>
      </div>
      <div class="unique-card">
      <a href="#">
        <img src="<?php echo SITE_PATH?>icons/cable.jpg" alt="Card Image">
        <p>Cable Subscription</p>
      </a>
      </div>
      <div class="unique-card">
      <a href="#">
        <img src="<?php echo SITE_PATH?>icons/cable.jpg" alt="Card Image">
        <p>Revenue  

        <?php 
           $start=date('Y-m-d'). ' 00-00-00';
           $end=date('Y-m-d'). ' 23-59-59';
           echo '&#8358;'.getRevenue($start,$end);
        ?>
        </p>
      </a>
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
<?php ///include('footer.inc.php');?>
</body>
</html>