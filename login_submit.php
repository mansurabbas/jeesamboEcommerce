<?php 
session_start();
include("storescripts/connect_to_mysql.php");

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

         // Composer Phpmailer
         use PHPMailer\PHPMailer\PHPMailer;
         use PHPMailer\PHPMailer\SMTP;
         use PHPMailer\PHPMailer\Exception;
         
        // Manual Phpmailer
        require_once 'phpmailer/src/Exception.php';
        require_once 'phpmailer/src/PHPMailer.php';
        require_once 'phpmailer/src/SMTP.php';
    
         $login_email = mysqli_real_escape_string($conn, $_POST["login_email"]); // filter everything but numbers and letters
         $login_password = mysqli_real_escape_string($conn, $_POST["login_password"]); // filter everything but numbers and letters
                
        $sql=mysqli_query($conn,"SELECT * FROM users WHERE email='$login_email' LIMIT 1");
		$count=mysqli_num_rows($sql);
		if($count>0){
		    
               $row = mysqli_fetch_assoc($sql);
               $dbfirstname = $row["firstname"];
               $dbemail = $row["email"];
               $dbphone = $row["phone"];
               $dbpassword = $row["password"];
               $status = $row["status"];
               $email_verify = $row["email_verify"];
        
               $tokenCheck = password_verify($login_password, $dbpassword);
               
               function getTwoFactor($uid) {
				global $conn;
					$sql="SELECT two_factor FROM users WHERE id ='$uid' ";
					$res=mysqli_query($conn,$sql);
					$row=mysqli_fetch_assoc($res);
						return $row['two_factor'];
				}
				$is_two_factor = getTwoFactor($row["id"]);
               
			   if($email_verify==1){
				if ($status==1) {

						if($tokenCheck === false) {
							echo "incorrect_password";
							exit();
						} elseif ($tokenCheck === true) {
						
						    if ($is_two_factor == 'On') {

								$_SESSION['LOGIN_USERNAME']=$dbfirstname;
								$_SESSION['LOGIN_EMAIL']=$dbemail;
								$_SESSION['LOGIN_PHONE']=$dbphone;
								$_SESSION["PASSWORD"] = $dbpassword;
								$otp=rand(11111,99999);
								$time=time()+10;
								mysqli_query($conn,"UPDATE users SET otp='$otp' WHERE email='$dbemail'");

                                $html = '<div style="width: 80%; max-width: 500px; margin: auto; background: #ffffff; border: 1px solid #dddddd; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
								<div>
									<p style="font-size: 16px; color: #333333; line-height: 1.5; margin-bottom: 16px;">
										Your One Time Password (OTP) verification code is:
									</p>
									<div style="background-color: #eaecee; color: #454545; font-size: 25px; font-weight: bold; text-align: center; padding: 15px 0; margin: auto; border-radius: 6px; width: 80%;">' . $otp . '</div>
									<p style="font-size: 14px; color: #ff0000; margin-top: 16px;">
										Remember, never share this OTP with anyone, not even if <b>Jeesambo</b> asks you to.
									</p>
								</div>
								<div style="margin-top: 20px;">
									<p style="font-size: 16px; color: #333333; margin: 5px 0;">Regards,</p>
									<p style="font-size: 16px; color: #333333; margin: 5px 0;"><b>Jeesambo</b> Team</p>
								</div>
							    </div>';									
								
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
								$mail->setFrom('noreply@jeesambo.com.ng','Jeesambo');
								$mail->addAddress($dbemail);
								$mail->addReplyTo('noreply@jeesambo.com.ng'); // to set the reply to
					
								// Setting the email content
								$mail->IsHTML(true);
								$mail->Subject = "OTP Confirmation";
								$mail->Body = $html;

								if ($mail->send()) {
									echo "yes";
									exit();
								}else{
									// echo "";	
								}
							}elseif($is_two_factor == 'Off'){
								$_SESSION['LOGIN_USERNAME']=$dbfirstname;
								$_SESSION['LOGIN_EMAIL']=$dbemail;
								echo 'no';
							}
						
						}
				}else{
					echo "deactivated";
					exit();
				}
			}else{
				echo "not_verify";
				exit();
			}

		}else{
			echo "not_exist";
		}
?>