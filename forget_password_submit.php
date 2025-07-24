<?php
session_start();
include("storescripts/connect_to_mysql.php");
include("admin/functions.php");

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

$email=$_POST['email'];
$sql=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
$check_user=mysqli_num_rows($sql);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// passing true in constructor enables exceptions in PHPMailer
if($check_user>0){
        $row=mysqli_fetch_assoc($sql);
        
        $iv=hex2bin($row['iv']);
        $pwd=str_openssl_dec($row['password'],$iv);

        $html="Your password is <strong>$pwd</strong>";
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
		$mail->Port = 465;

		$mail->Username = 'jeesamb3'; // YOUR gmail email
		$mail->Password = '1uY674akjW[A)U'; // YOUR gmail password

		// Sender and recipient settings
		$mail->setFrom('noreply@jeesambo.com.ng', 'Mansur');
		$mail->addAddress($email);
		$mail->addReplyTo('noreply@jeesambo.com.ng', 'Mansur'); // to set the reply to

		// Setting the email content
		$mail->IsHTML(true);
		$mail->Subject = "Your Password";
		$mail->Body = $html;
		$mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

		if ($mail->send()) {
			echo "Please check your email id for password";
		}else{
			echo "Email id not registered with us";
			die();
		}


}
?>

<script src="//code.jquery.com/jquery-3.5.1.js"></script>
<!-- If the CDN fails to load, serve up the local version -->
<script>window.jQuery || document.write('<script src="js/jquery-3.5.1.js"><\/script>');</script>
<script src="js/custom.js"></script>