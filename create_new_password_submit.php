<?php
require_once("storescripts/connect_to_mysql.php");
include("admin/functions.php");

if(isset($_POST['reset-password-submit'])) {
    
    $selector = clean($conn, $_POST['selector']);
    $validator = clean($conn, $_POST['validator']);
    $password = clean($conn, $_POST['password']);
    $passwordRepeat = clean($conn, $_POST['password-repeat']);
    
    if(empty($selector) || empty($validator) ) {
        header("Location: create_new_password.php?newpassword=empty");
        exit();
    } elseif ($password!= $passwordRepeat) {
        header("Location: create_neww_password?newpassword=passwordnotsame");
        exit();
    }
        $currentDate = date('U');
        $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector='$selector' AND pwdResetExpires>='$currentDate'";
        // prx($sql);
        $sql = mysqli_query($conn, "SELECT * FROM pwdReset WHERE pwdResetSelector='$selector' AND pwdResetExpires>='$currentDate'") or die(mysqli_error($conn));
        
        if(!$sql){
            echo "There was an error line 22";
            exit();
        }else{
           if( !$row = mysqli_fetch_assoc($sql)) {
               ?>
               <script>
                    alert("You need to re-submit your reset request.");
               </script>
               <?php
               header("Location: create_new_password.php");
            //   exit();
           }else{
               $tokenBin = hex2bin($validator);
               $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);
               
               if($tokenCheck === false) {
                   echo "You need to re-submit your reset request";
                   exit();
               } elseif ($tokenCheck === true) {
                   $tokenEmail = $row['pwdResetEmail'];
                   $sql = mysqli_query($conn,"SELECT * FROM users WHERE email = '$tokenEmail'") or die(mysqli_error($conn));
                   if(!$sql) {
                       echo "There was an error line";
                       exit();
                   } else {
                       if(!$row = mysqli_fetch_assoc($sql)){
                           echo "There was an error";
                           exit();
                       } else {
                           $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                           $sql = "UPDATE users SET password = '$newPwdHash' WHERE email = '$tokenEmail'" or die(mysqli_error($conn));
                           mysqli_query($conn, $sql) or die(mysqli_error($conn));
                           
                           mysqli_query($conn, "DELETE FROM pwdReset WHERE pwdResetEmail = '$tokenEmail' ");
                           header("Location: login?newpwd=passwordupdated");
                           
                       }
                   }
               }
           }
            
        }
    
} else {
    header("Location: index.php");
}
?>