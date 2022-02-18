<?php

include('../../connections/connection.php');
include('../../connections/local_connection.php');

if($_POST['option_type'] === "entry"){
    $option_type = $_POST['option_type'];
    $option_id = $_POST['option_id'];
    $voucher_no = $_POST['voucher_no'];
    $system_id = $_POST['system_id'];
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
        $table = $option_type.'_'.$option_id.'_values';
        $sql = "DELETE FROM $table WHERE voucher_no='$voucher_no'";
        // echo $sql_insert_values;
        $result = mysqli_query($local_conn_db, $sql);
        if($result){
                echo "Deleted Successfully...!";
        }
        else{
            echo "Error in deleting data...!";
        }
    }
    else{
        echo "Database not found...!";
    }
}
?>