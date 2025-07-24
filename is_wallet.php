<?php
session_start();

if (isset($_POST['amt']) && isset($_POST['email'])) {
    $amt = ($_POST['amt'] / 100);
    if ($amt>=2500) {
        $amt = $amt - ($amt * 1.5 / 100) - 100;
        $amt = ceil($amt);
    }else{
        $amt = $amt - ($amt * 1.5 / 100);
        $amt = ceil($amt);
    }
    $email = $_POST['email'];

    $_SESSION['IS_WALLET'] = 'yes';
    $_SESSION['AMT'] = $amt;
    echo 'yes';
} else {
    echo 'no';
}
