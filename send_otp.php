<?php
session_start();
include("storescripts/connect_to_mysql.php");
include("admin/functions.php");

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// passing true in constructor enables exceptions in PHPMailer

		$conn=mysqli_connect('localhost','root','','mystore');

		$reg_firstname=clean($conn, $_POST['reg_firstname']);
		$reg_email=clean($conn, $_POST['reg_email']);
		$reg_password=clean($conn, $_POST['reg_password']);

		$check_user=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE email='$reg_email'"));
        if($check_user>0){
        echo "Email Present";
        }else {
        // Insert user
                $added_on=date('Y-m-d h:i:s');
                $sql = "INSERT INTO users (firstname,email,password,added_on) VALUES('$reg_firstname','$reg_email','$reg_password','$added_on')";
                // echo $sql;
                // die();
                $sql = mysqli_query($conn, $sql) or die("Error:". mysqli_error($conn));
                // if($sql){
                //         header("Location: login.php");
                //     echo "Insert";
                // }

        }

		$sql=mysqli_query($conn,"SELECT * FROM users WHERE email='$reg_email'");
		$count=mysqli_num_rows($sql);
		if($count>0){
			$otp=rand(11111,99999);
			mysqli_query($conn,"UPDATE users SET otp='$otp' WHERE email='$reg_email'");
			$html="Your otp verification code is ".$otp;
			$_SESSION['EMAIL']=$reg_email;
			
			// Send Email
			$mail = new PHPMailer(true);

			// Server settings
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;

			// Setting port 587
			// $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			// $mail->Port = 587;

			// Setting port 465
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
			$mail->Port = 465;

			$mail->Username = 'no-reply@jeesambo.com.ng'; // YOUR gmail email
			$mail->Password = 'Mansur#####Mansur#####'; // YOUR gmail password

			// Sender and recipient settings
			$mail->setFrom('no-reply@jeesambo.com.ng');
			$mail->addAddress($reg_email);
			$mail->addReplyTo('no-reply@jeesambo.com.ng'); // to set the reply to

			// Setting the email content
			$mail->IsHTML(true);
			$mail->Subject = "New OTP";
			$mail->Body = $html;

			if ($mail->send()) {
				echo "yes";
			}else{
				//echo "Error occur";	
			}
		}else{
			echo "not_exist";
		}

		


?>