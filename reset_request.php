<?php
require_once("storescripts/connect_to_mysql.php");
require_once("admin/functions.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require_once 'phpmailer/vendor/phpmailer/src/Exception.php';
// require_once 'phpmailer/vendor/phpmailer/src/PHPMailer.php';
// require_once 'phpmailer/vendor/phpmailer/src/SMTP.php';

if(isset($_POST['reset-request-submit'])) {
    
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    
    $url = "https://jeesambo.com.ng/create_new_password?selector=" .$selector . "&validator=" . bin2hex($token);
	
    $expires = date('U') + 1800;    
    
    
    $userEmail = clean($conn, $_POST['email']);
    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail = '".$userEmail."'";
	// prx($sql);
    $sql = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	
    if(!$sql){
        echo "There was an error!";
        exit();
    } else {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
		$sql = "INSERT INTO pwdReset (pwdResetEmail,pwdResetSelector,pwdResetToken,pwdResetExpires) VALUES ('$userEmail', '$selector', '$hashedToken', '$expires') ";
		
        $sql =  mysqli_query($conn, $sql) or die(mysqli_error($conn));
		//prx($sql);
    }
    
                
        $to = $userEmail;
        
        $subject = "Reset your password for jeesambo";
        
        $message='<p>We receive a password reset request. The link to reset your password make this request, you can ignore this email';
        $message .= '<p>Here is your password reset link <br />';
        $message .= '<a href="'.$url.'">'.$url.'</a></p>';
        
        // php mailer start
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
		$mail->setFrom('noreply@jeesambo.com.ng', 'Jeesambo');
		$mail->addAddress($to);
		//$mail->addReplyTo('no-reply@jeesambo.com.ng', 'Mansur'); // to set the reply to

		// Setting the email content
		$mail->IsHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $message;
		$mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';

		if ($mail->send()) {
			echo "Link to reset your password has been sent to you";
			header("Location: reset_password?reset=success");
		}else{
			echo "Email id not registered with us";
			die();
		}
        //php mailer end
        
        
        
} else {
    header("Location: index");
}
