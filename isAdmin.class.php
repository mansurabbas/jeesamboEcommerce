<?php
ini_set('log_errors', TRUE);
ini_set('ignore_repeated_errors', TRUE);

Class IsAdmin {

    public function isAdmin() {
        if ($_SESSION["admin_role"] ==1) {
            header("Location: products");
        }
    }
}

$obj = new IsAdmin();
$obj->isAdmin();
?>
