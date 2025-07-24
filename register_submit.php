<?php
session_start();
include("storescripts/connect_to_mysql.php");
include("admin/functions.php");

		use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\SMTP;
		use PHPMailer\PHPMailer\Exception;

		$reg_firstname=mysqli_real_escape_string($conn, $_POST['reg_firstname']);
		$reg_email=mysqli_real_escape_string($conn, $_POST['reg_email']);
		$reg_username=mysqli_real_escape_string($conn, $_POST['reg_username']);
		$reg_password=mysqli_real_escape_string($conn, $_POST['reg_password']);

		$check_user=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE email='$reg_email' OR username='$reg_username' "));
        if($check_user>0){
        echo "user_exist";
		die();
        }else {
        // Insert user
                // $iv=openssl_random_pseudo_bytes(16);
                // $reg_password=str_openssl_enc($reg_password,$iv);
                // $iv=bin2hex($iv);
                if (isset($_SESSION['FROM_REFERRAL_CODE']) && $_SESSION['FROM_REFERRAL_CODE']!='') {
					$from_referral_code=mysqli_real_escape_string($conn, $_SESSION['FROM_REFERRAL_CODE']);
				}else{
					$from_referral_code='';
				}
                $password_hash = password_hash($reg_password, PASSWORD_DEFAULT); 
				$rand_str=rand_str();
				$referral_code=rand_str();
                $added_on=date('Y-m-d h:i:s');

                $sql = "INSERT INTO users (firstname,email,username,password,pin,two_factor,rand_str,email_verify,status,last_login,otp,referral_code,from_referral_code,added_on) VALUES('$reg_firstname','$reg_email','$reg_username','$password_hash','$pin','Off','$rand_str','0','1','0','0','$referral_code','$from_referral_code','$added_on')";
                $sql = mysqli_query($conn, $sql);
				$id=mysqli_insert_id($conn);
				unset($_SESSION['FROM_REFERRAL_CODE']);

				$getSettings=getSetting();
				$wallet_amt=$getSettings['wallet_amt'];
				//manageWallet($id,$wallet_amt,$reg_email,'in','Resgistration');

        }

		$sql=mysqli_query($conn,"SELECT * FROM users WHERE (email='$reg_email' OR username='$reg_username') AND firstname='$reg_firstname'");
		$count=mysqli_num_rows($sql);
		if($count>0){
			
			mysqli_query($conn,"UPDATE users SET otp='$otp' WHERE (email='$reg_email' OR username='$reg_username')");
			$link=SITE_PATH."login?id=".$rand_str;
			$html = '
            <div style="width: 80%; max-width: 500px; margin: auto; background: #ffffff; border: 1px solid #dddddd; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            
                <div>
                    <p style="font-size: 16px; color: #333333; line-height: 1.5; margin-bottom: 16px;">
                        Click the below link to verify your email:
                    </p>
                    <div style="background-color: #eaecee; color: #454545; font-size: 25px; font-weight: bold; text-align: center; padding: 15px 0; margin: auto; border-radius: 6px; width: 80%;">
                        <a href="' . htmlspecialchars($link, ENT_QUOTES, 'UTF-8') . '" style="color: #454545; text-decoration: none;">Click here to verify</a>
                    </div>
                    
                </div>
                <div style="margin-top: 20px;">
                    <p style="font-size: 16px; color: #333333; margin: 5px 0;">Regards,</p>
                    <p style="font-size: 16px; color: #333333; margin: 5px 0;"><b>Jeesambo</b> Team</p>
                </div>
            </div>
            ';
			$_SESSION['EMAIL']=$reg_email;
			$_SESSION['REG_USERNAME']=$reg_username;
			$_SESSION['REG_PASSWORD']=$reg_password;
			
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
			$mail->Port = 465;

			$mail->Username = 'jeesamb3'; // YOUR gmail email
			$mail->Password = '1uY674akjW[A)U'; // YOUR gmail password

			// Sender and recipient settings
			$mail->setFrom('noreply@jeesambo.com.ng','Jeesambo');
			$mail->addAddress($reg_email);
			$mail->addReplyTo('noreply@jeesambo.com.ng'); // to set the reply to

			// Setting the email content
			$mail->IsHTML(true);
			$mail->Subject = "Email Verification";
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