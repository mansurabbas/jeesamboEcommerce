<?php 
require_once('top.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
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
    $sql=mysqli_query($conn,"SELECT * FROM users WHERE email='".$_SESSION['LOGIN_EMAIL']."' LIMIT 1 ");
    $count=mysqli_num_rows($sql);
    if($count>0){
        $row=mysqli_fetch_assoc($sql);
        $email = $row['email'];
        $bank = "Moniepoint";

    }
	
    if (isset($_POST['amount']) && $_POST['amount']!='') {
        
        // $bank_name =mysqli_real_escape_string($conn, $_POST['bank_name']);
        // $reference = mysqli_real_escape_string($conn, $_POST['reference']);
        $amount = mysqli_real_escape_string($conn, $_POST['amount']);

        $email_address = "mansurabbas2016@gmail.com";
        $html = $amount." have been submitted to " .$bank. " from ".$_SESSION['LOGIN_EMAIL'];

        // Send Email
        $mail = new PHPMailer(true);
					
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'mail.jeesambo.com.ng';
        $mail->SMTPAuth = true;

        // Setting port 587
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        // $mail->Port = 587;

        // Setting port 465
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPDebug = 0;
        $mail->Port = 465;
        
        $mail->Username = 'jeesamb3'; // YOUR gmail email
        $mail->Password = '1uY674akjW[A)U'; // YOUR gmail password

        // Sender and recipient settings
        $mail->setFrom('noreply@jeesambo.com.ng');
        $mail->addAddress($email_address);
        $mail->addReplyTo('noreply@jeesambo.com.ng'); // to set the reply to

        // Setting the email content
        $mail->IsHTML(true);
        $mail->Subject = "Manual Wallet Topup From ".$_SESSION['LOGIN_EMAIL'];
        $mail->Body = $html;

        if ($mail->send()) {
            ?>
                <script>
                    alert('Payment details Sent');
                    window.location.href="<?php echo SITE_PATH?>bank_payment";
                </script>
            <?php
            exit();
        }else{
            //echo "Error occur";	
        }
    }
?> 

<body id="index">
<div class="content">
<span class="menu-toggle" id="menuToggle" style="color: black;">&#9776;</span>
<div class="contained">
<?php include('side_menu.php'); ?>
<div class="content-body">

    <div class="content">
        <div class="bank-popup">
        <h3 style="text-align: center; padding-bottom: 10px; font-size: 3rem; font-weight: normal"> Bank Transfer </h3>
                <div class="Bank_payment_container">
                <form action="bank_payment.php" method="post">
                    <div class="inputs">
                        
                            <label for="input1">Bank paid to</label>
                            <input type="text" name="bank_name" id="input1" value="<?php echo $bank ?>" readonly placeholder="Just Enter Moniepoint">

                            <label for="input2">Reference or Naration</label>
                            <input type="text" name="reference" id="input2" value="<?php echo $email ?>" readonly placeholder="Enter Your Registered Email As reference or Narration">
                            <span>Use your registered email as Reference or Narration if it is bank Tranfer</span>

                            <label for="input3">Amount* </label>
                            <input type="text" name="amount" id="input3" placeholder="Enter Amount You Paid">
                            <p style="color: red; font-size: 1.6rem">Your account will be suspended if you submit without transfer.</p>

                            <input type="submit" name="submit" value="Submit" id="bank_btn">
                        
                    </div>
                </form>
                <div class="text">
                    <p>You can deposit or transfer fund into our account stated below. Use your 
                        registered email as depositor's name, naration or remarks Your account 
                        will be funded as soon as your payment is confirmed.</p><br>
                        <span style="color: red"><p>Please <b>NOTE</b> that a charge of &nbsp;N50 naira will be applied.</p></span>
                        <br>
                        <p>Wallet Name: &nbsp;&nbsp; MoniePoint</p>
                        <p>Account Number: &nbsp;&nbsp; 8034451240</p>
                        <p>Account Name: &nbsp;&nbsp; Mansur Abbas Jisambo</p>
                        <br>
                        <p>Our WhatsApp helpline: &nbsp;&nbsp; 08034451240</p>
                        <p>We are available 24/7 to answer your inquiries</p>
                </div>
                </div>
        </div>

    </div>
</div>
</div>

<?php require_once('footer.inc.php'); ?>
</body>
</html>