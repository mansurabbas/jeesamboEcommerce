<?php
require_once('top.php');
?>
<?php
    if(!isset($_SESSION['USER_LOGIN'])){
        $_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
        redirect('login');
    }
?> 

<body id="index">
<div class="content">
<!-- <span class="menu-toggle" id="menuToggle" style="color: black;">&#9776;</span> -->
<div class="contained">
<?php include('side_menu.php'); ?>
<div class="content-body">

<div class="topup-wrapper">

        <div class="history-container">
        <h2>History</h2>
        <div class="history-table">
            <?php
                $data_id='';
                if (isset($_GET['id'])) {
                    $data_id = $_GET['id'];
                }
                // SQL query to fetch data from transactions_history table
                $sql = "SELECT * FROM transactions_history WHERE user_id ='".$_SESSION['USER_ID']."' AND data_id ='$data_id'";
                $result = mysqli_query($conn, $sql);

                // Check if any rows are returned
                if (mysqli_num_rows($result) > 0) {
                    // Output data for each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='table-row'>
                                <div class='table-key'><span>ID</span></div>
                                <div class='table-value'><span>$row[id]</span></div>
                              </div>
                              <div class='table-row'>
                                <div class='table-key'><span>Data ID</span></div>
                                <div class='table-value'><span>$row[data_id]</span></div>
                              </div>
                              <div class='table-row'>
                                <div class='table-key'><span>Ident</span></div>
                                <div class='table-value'><span>$row[ident]</span></div>
                              </div>
                              <div class='table-row'>
                                <div class='table-key'><span>Status</span></div>
                                <div class='table-value'><span>$row[status]</span></div>
                              </div>
                              <div class='table-row'>
                                <div class='table-key'><span>Plan Network</span></div>
                                <div class='table-value'><span>$row[plan_network]</span></div>
                              </div>
                              <div class='table-row'>
                                <div class='table-key'><span>Phone Number</span></div>
                                <div class='table-value'><span>$row[phone_number]</span></div>
                              </div>
                              <div class='table-row'>
                                <div class='table-key'><span>Amount</span></div>
                                <div class='table-value'><span>$row[amount]</span></div>
                              </div>
                              <div class='table-row'>
                                <div class='table-key'><span>Plan Name</span></div>
                                <div class='table-value'><span>$row[plan_name]</span></div>
                              </div>
                              <div class='table-row'>
                                <div class='table-key'><span>Create Date</span></div>
                                <div class='table-value'><span>$row[create_date]</span></div>
                              </div>
                              <div class='table-row'>
                                <div class='table-key'><span>Balance Before</span></div>
                                <div class='table-value'><span>$row[balance_before]</span></div>
                              </div>
                              <div class='table-row'>
                                <div class='table-key'><span>Balance After</span></div>
                                <div class='table-value'><span>$row[balance_after]</span></div>
                              </div>";
                    }
                } else {
                    echo "<p><span>No history data found.</span></p>";
                }

                // Close the connection
                mysqli_close($conn);
            ?>
        </div>
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
    var network_name = 'AIRTEL';
}
if (network==6){
    var network_name = '9MOBILE';
}
// Type of network requested End
var bundle = document.getElementById("selectBox").value;

if (network==1) {
    // Bundle name start
    if (bundle==150) {
        var bundle_name = '500.0MB SME @ ₦ 150  30 days';
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
    if (bundle==3975){
        var bundle_name = '15.0GB SME @ ₦ 3975  30 days';
        var bundle_data_amt = '15.0GB';
    }
    // Bundle name End  
}
if (network==2) {
    // Bundle name start
    if (bundle==70) {
        var bundle_name = '200.0MB CORPORATE GIFTING @ ₦ 70  30 DAYS (CG)';
        var bundle_data_amt = '200.0MB';
    }
    if (bundle==150) {
        var bundle_name = '500.0MB CORPORATE GIFTING @ ₦ 150  30 DAYS (CG)';
        var bundle_data_amt = '500.0MB';
    }
    if (bundle==280){
        var bundle_name = '1.0GB CORPORATE GIFTING @ ₦ 280  30 DAYS (CG)';
        var bundle_data_amt = '1.0GB';
    }
    if (bundle==560){
        var bundle_name = '2.0GB CORPORATE GIFTING @ ₦ 560 {14days}';
        var bundle_data_amt = '2.0GB';
    }
    if (bundle==840){
        var bundle_name = '3.0GB CORPORATE GIFTING @ ₦ 840  30 DAYS (CG)';
        var bundle_data_amt = '3.0GB';
    }
    if (bundle==1400){
        var bundle_name = '5.0GB CORPORATE GIFTING @ ₦ 1400  30 DAYS (CG)';
        var bundle_data_amt = '5.0GB';
    }
    if (bundle==2800){
        var bundle_name = '10.0GB CORPORATE GIFTING @ ₦ 2800  (30days)';
        var bundle_data_amt = '10.0GB';
    }
    // Bundle name End  
}
if (network==3) {
    // Bundle name start
    if (bundle==150) {
        var bundle_name = '500.0MB CORPORATE GIFTING @ ₦ 150  [30days] CORPORATE';
        var bundle_data_amt = '500.0MB';
    }
    if (bundle==285) {
        var bundle_name = '1.0GB CORPORATE GIFTING @ ₦ 285  [30days] CORPORATE';
        var bundle_data_amt = '1.0GB';
    }
    if (bundle==570){
        var bundle_name = '2.0MB CORPORATE GIFTING @ ₦  570  [7days]';
        var bundle_data_amt = '2.0GB';
    }
    if (bundle==1140){
        var bundle_name = '4.0GB CORPORATE GIFTING @ ₦ 1140  [30days] CORPORATE';
        var bundle_data_amt = '4.0GB';
    }
    if (bundle==1425){
        var bundle_name = '5.GB CORPORATE GIFTING @ ₦ 1425  [30days]';
        var bundle_data_amt = '15.0GB';
    }
    if (bundle==2850){
        var bundle_name = '10.0GB CORPORATE GIFTING @ ₦ 2850  [30days] CORPORATE';
        var bundle_data_amt = '10.0GB';
    }
    if (bundle==4275){
        var bundle_name = '15.0GB CORPORATE GIFTING @ ₦ 4275  [30days] CORPORATE';
        var bundle_data_amt = '15.0GB';
    }
    // Bundle name End  
}
if (network==6) {
    // Bundle name start
    if (bundle==150) {
    var bundle_name = '500.0MB CORPORATE GIFTING @ ₦ 150  30 DAYS (CG)';
    var bundle_data_amt = '500.0MB';
    }
    if (bundle==250) {
        var bundle_name = '1.0GB CORPORATE GIFTING @ ₦ 250  30 DAYS (CG)';
        var bundle_data_amt = '1.0GB';
    }
    if (bundle==375) {
        var bundle_name = '1.5GB CORPORATE GIFTING @ ₦ 375  30 DAYS (CG)';
        var bundle_data_amt = '1.5GB';
    }
    if (bundle==500){
        var bundle_name = '2.0GB CORPORATE GIFTING @ ₦ 500  30 DAYS (CG)';
        var bundle_data_amt = '2.0GB';
    }
    if (bundle==750){
        var bundle_name = '3.0GB CORPORATE GIFTING @ ₦ 750  30 DAYS (CG)';
        var bundle_data_amt = '3.0GB';
    }
    if (bundle==1000){
        var bundle_name = '4.0GB CORPORATE GIFTING @ ₦ 1000  30 DAYS (CG)';
        var bundle_data_amt = '4.0GB';
    }
    if (bundle==1250){
        var bundle_name = '5.0GB CORPORATE GIFTING @ ₦ 1250  (Weekly ) (CORPORATE GIFTING)';
        var bundle_data_amt = '5.0GB';
    }
    if (bundle==2500){
        var bundle_name = '10.0GB CORPORATE GIFTING @ ₦ 2500  30 DAYS (CG)';
        var bundle_data_amt = '10.0GB';
    }
    if (bundle==3750){
        var bundle_name = '15.0GB CORPORATE GIFTING @ ₦ 3750  (Weekly) (CORPORATE GIFTING)';
        var bundle_data_amt = '15.0GB';
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
                        if (resultArray[2]=='successful') {
                            // swal("Transaction successful", "You have successfully purchased "+bundle_data_amt+" "+network_name+" data for "+phone_number, "success");
                            swal({
                            title: "Transaction successful",
                            text: "You have successfully purchased " + bundle_data_amt + " " + network_name + " data for " + phone_number,
                            icon: "success",
                            buttons: {
                                viewHistory: {
                                text: "View Transaction History",
                                value: "viewHistory",
                                closeModal: true
                                }
                            }
                            }).then((value) => {
                            if (value === "viewHistory") {
                                // Redirect to the transactions history page
                                window.location.href = "transactions_history.php"; // Replace with your actual URL
                            }
                            });


                        }
                    }
                };

                xhr.send(params);
  } else {
    console.log('No');
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