<?php 
session_start();
include("../storescripts/connect_to_mysql.php");
include("functions.php");

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

         use PHPMailer\PHPMailer\PHPMailer;
         use PHPMailer\PHPMailer\Exception;
         use PHPMailer\PHPMailer\SMTP;

        //  if ($_POST['token'] !== $_SESSION['token']) {
        //     die('Invalid token');
        //  }

         $email = strtolower(mysqli_real_escape_string($conn, $_POST["email"])); 
         $password = mysqli_real_escape_string($conn, $_POST["password"]); 
                
        $sql=mysqli_query($conn,"SELECT * FROM admin WHERE email='$email' ");
        
		$count=mysqli_num_rows($sql);
		
		if($count>0){
			
            $row = mysqli_fetch_assoc($sql);
            $admin_id = $row['id'];
            $dbemail = $row['email'];
            $dbpassword = $row["password"];
			$status = $row["status"];
            $dbusername = $row['username'];
            
            $tokenCheck = password_verify($password, $dbpassword);
               
			if ($status==1) {
               if($tokenCheck === false) {

					echo "incorrect_password";

               } elseif ($tokenCheck === true) {
                    if ($row['status']=='0') {
				        echo "deactivated";
				        die();
        			} else {
        		    	$otp=rand(11111,99999);
        		    	
        		    	$time=time()+10;
            			mysqli_query($conn,"UPDATE admin SET otp='$otp' WHERE email='$dbemail'");
            			$html="Your otp verification code is ".$otp;
        			    $_SESSION['EMAIL']=$dbemail;
        			    $_SESSION['POST_PASSWORD']=$password;
        			    
                        
        			}
			
        			// Send Email
        			$mail = new PHPMailer(true);
        
        			// Server settings
        			$mail->isSMTP();
        			$mail->Host = 'mail.jeesambo.com.ng';
        			$mail->SMTPAuth = true;
        			$mail->SMTPDebug  = 0;
        
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
        			$mail->addAddress($dbemail);
        	
        			//$mail->addReplyTo('abdumailer@gmail.com'); // to set the reply to
        
        			// Setting the email content
        			$mail->IsHTML(true);
        			$mail->Subject = "New OTP";
        			$mail->Body = $html;
        
        			if ($mail->send()) {
        				echo "yes";
        			} else {
        				//echo "Error occur";	
        			}
               }
			}else{
				echo "deactivated";
			}
            
		}else{
		
			echo "not_exist";
		}
		

?>