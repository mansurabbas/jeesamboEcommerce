<?php
session_start();

ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

if (isset($_POST['payment_type'])) {

    if ($_POST['payment_type'] == 'paystack') {
        $_SESSION['PAYMENT_BY_PAYSTACK'] = $_POST['payment_type'];
        echo 'paystack';
        
    } elseif ($_POST['payment_type'] == 'wallet') {
        $_SESSION['PAYMENT_BY_WALLET'] = $_POST['payment_type'];
        echo 'wallet';
        
    }  
    
}





