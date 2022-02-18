<?php

include('../../connections/connection.php');
include('../../connections/local_connection.php');

$system_id = $_POST['system_id'];
$product_id = $_POST["product_id"];
$quantity = $_POST["quantity"];
$business = $_POST["business"];

$database_name = "";
// Getting Database
$sql="SELECT * FROM `systems` WHERE `id` = $system_id";
$result = mysqli_query($conn, $sql);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $database_name = $row["database_name"];
    }
}
if($database_name != ""){
    $local_conn_db = mysqli_connect($server, $server_user, $server_pass, $database_name);
    if($local_conn_db->connect_error){
        die("Failed to connect with MySQL: " . $local_conn_db->connect_error);
    }
    $products_table = "asset_4_values";
    $purchase_order_table = "entry_5_values";
    $purchase_table = "entry_16_values";
    $opening_purchase = 0;
    $opening_sale = 0;
    $sql1="SELECT SUM(`opt_12`) as `opening_purchase` FROM `$purchase_order_table` WHERE `opt_5`='$product_id'"." AND `entry_of`='$business'";
    $result1 = mysqli_query($local_conn_db, $sql1);
    if($result1->num_rows > 0){
        while($row1 = $result1->fetch_assoc()){
            $opening_purchase = floatval($row1["opening_purchase"]);
        }
    }
    $sql1="SELECT SUM(`opt_12`) as `opening_sale` FROM `$purchase_table` WHERE `opt_15`='$product_id'"." AND `entry_of`='$business'";
    $result1 = mysqli_query($local_conn_db, $sql1);
    if($result1->num_rows > 0){
        while($row1 = $result1->fetch_assoc()){
            $opening_sale = floatval($row1["opening_sale"]);
        }
    }
    if(($opening_purchase - $opening_sale) >= $quantity){
        echo "Cleared";
    }
    else{
        echo "Not available in store...!--sp--".($opening_purchase - $opening_sale);
    }
}
?>