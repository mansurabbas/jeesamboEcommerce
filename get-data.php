<?php
session_start();
require_once("storescripts/connect_to_mysql.php");

$type = $_POST['type'];
$s_name = '';
$c_name = '';
$s_id = '';

if($type=='default') {
    $state_id = $_POST['state_id'];
    $fetch_query = mysqli_query($conn,"SELECT * FROM tbl_city WHERE state_id= '$state_id' ");
    if (mysqli_num_rows($fetch_query) > 0) {
        $row = mysqli_fetch_assoc($fetch_query);
            $city_id = $row['id'];
            $s_id = $row['state_id'];
    }
    $_SESSION["STATE"] = $s_id;

    $result = "";
    while($res_arr = mysqli_fetch_array($fetch_query)) {

        $selected = ($res_arr['name'] == 'Tudun Wada') ? 'selected' : '';
        $result .='<option value='.$res_arr['id'].' ' . $selected . '>'.$res_arr['name'].'</option>';
    }
    $_SESSION["RATE"] = 1500;
    echo $result;
}

if($type=='state') {
    $state_id = $_POST['state_id'];
    $fetch_query = mysqli_query($conn,"SELECT * FROM tbl_city WHERE state_id= '$state_id' ");
    if (mysqli_num_rows($fetch_query) > 0) {
        $row = mysqli_fetch_assoc($fetch_query);
            $city_id = $row['id'];
            $s_id = $row['state_id'];
    }
    // $_SESSION["STATE"] = $s_id;

    $result = "";
    while($res_arr = mysqli_fetch_array($fetch_query)) {

        $selected = ($res_arr['name'] == 'Tudun Wada') ? 'selected' : '';
        $result .='<option value='.$res_arr['id'].' ' . $selected . '>'.$res_arr['name'].'</option>';
    }
    echo $result;
    
}
if($type=='city') {

    // $fetch_query_state = mysqli_query($conn,"SELECT * FROM tbl_state WHERE id= '$s_id' ");
    $city_id = $_POST['city_id'];
    $state_id = $_POST['state_id'];

    $fetch_query = mysqli_query($conn,"SELECT id,rate,state_id FROM shipping_rates WHERE city_id= '$city_id' AND state_id= '$state_id' ");
    if (mysqli_num_rows($fetch_query) > 0) {
        $row = mysqli_fetch_assoc($fetch_query);
            $city_id = $row['id'];
            $rate = $row['rate'];
            $state_id = $row['state_id'];
    }
    $result = "";
    while($row = mysqli_fetch_array($fetch_query)) {
        $selected = ($row['id']==$city_id) ? 'selected' : '';
            $result .='<option value='.$row['id'].' ' . $selected . '>'.$row['name'].'</option>';
    }
    echo $result;

    // $_SESSION["CITY"] = $city_id;
    $_SESSION["RATE"] = $rate;
    echo $rate;
    // $fetch_query = mysqli_query($conn,"SELECT * FROM tbl_city ");
    // if (mysqli_num_rows($fetch_query) > 0) {
    //     while ($row = mysqli_fetch_assoc($fetch_query)) {
    //         $city_id = $row['id'];
    //         $state_id = $row['state_id'];

    //         $shippingRate = 3000;
    //         mysqli_query($conn, "INSERT INTO shipping_rates (state_id, city_id, rate) VALUES ($state_id, $city_id, $shippingRate)");
    //     }
    // }

}

?>