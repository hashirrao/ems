<?php

include('../../connections/connection.php');
include('../../connections/local_connection.php');

$system_id = $_POST['system_id'];
if(isset($_POST["account_id"])){
    $account_id = $_POST["account_id"];
}
$amount = $_POST["amount"];
$date = $_POST["date"];
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
    $accounts_table = "asset_49_values";
    $payment_table = "entry_7_values";
    $reciept_table = "entry_8_values";
    $expense_table = "entry_14_values";
    $salary_table = "entry_17_values";
    $cash_deposit_table = "entry_50_values";
    $cash_withdrawal_table = "entry_51_values";
    $receipt_amount = 0;
    $payment_amount = 0;
    $expense_amount = 0;
    $salary_amount = 0;
    $cash_deposit_amount = 0;
    $cash_withdrawal_amount = 0;
    $sql1="SELECT SUM(`opt_6`) as `reciept_amount` FROM `$reciept_table` WHERE `opt_1`<='".$date."'"." AND `entry_of`='$business'";
    // echo $sql1;
    $result1 = mysqli_query($local_conn_db, $sql1);
    if($result1->num_rows > 0){
        while($row1 = $result1->fetch_assoc()){
            $receipt_amount = floatval($row1["reciept_amount"]);
        }
    }
    $sql1="SELECT SUM(`opt_5`) as `payment_amount` FROM `$payment_table` WHERE `opt_1`<='$date'"." AND `entry_of`='$business'";
    $result1 = mysqli_query($local_conn_db, $sql1);
    if($result1->num_rows > 0){
        while($row1 = $result1->fetch_assoc()){
            $payment_amount = floatval($row1["payment_amount"]);
        }
    }
    $sql1="SELECT SUM(`opt_3`) as `expense_amount` FROM `$expense_table` WHERE `opt_1`<='$date'"." AND `entry_of`='$business'";
    $result1 = mysqli_query($local_conn_db, $sql1);
    if($result1->num_rows > 0){
        while($row1 = $result1->fetch_assoc()){
            $expense_amount = floatval($row1["expense_amount"]);
        }
    }
    $sql1="SELECT SUM(`opt_6`) as `salary_amount` FROM `$salary_table` WHERE `opt_1`<='$date'"." AND `entry_of`='$business'";
    $result1 = mysqli_query($local_conn_db, $sql1);
    if($result1->num_rows > 0){
        while($row1 = $result1->fetch_assoc()){
            $salary_amount = floatval($row1["salary_amount"]);
        }
    }
    $sql1="SELECT SUM(`opt_5`) as `cash_deposit_amount` FROM `$cash_deposit_table` WHERE `opt_1`<='$date'"." AND `entry_of`='$business'";
    $result1 = mysqli_query($local_conn_db, $sql1);
    if($result1->num_rows > 0){
        while($row1 = $result1->fetch_assoc()){
            $cash_deposit_amount = floatval($row1["cash_deposit_amount"]);
        }
    }
    $sql1="SELECT SUM(`opt_5`) as `cash_withdrawal_amount` FROM `$cash_withdrawal_table` WHERE `opt_1`<='$date'"." AND `entry_of`='$business'";
    $result1 = mysqli_query($local_conn_db, $sql1);
    if($result1->num_rows > 0){
        while($row1 = $result1->fetch_assoc()){
            $cash_withdrawal_amount = floatval($row1["cash_withdrawal_amount"]);
        }
    }
    $respective_amount = ($receipt_amount - $payment_amount - $expense_amount - $salary_amount - $cash_deposit_amount + $cash_withdrawal_amount);
    if($respective_amount >= $amount){
        echo "Cleared";
    }
    else{
        echo "Cash in hand is less than respective amount...!--sp--".$respective_amount;
    }
}
?>