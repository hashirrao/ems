<?php

include('../../connections/connection.php');
include('../../connections/local_connection.php');

$message = '';
if(isset($_POST['sub_option_name'])){
    $option_id = $_POST['option_id'];
    $option_type = $_POST['option_type'];
    $system_id = $_POST['system_id'];
    $sub_option_name = $_POST['sub_option_name'];
    $sub_option_type = $_POST['sub_option_type'];
    $sub_option_texts = $_POST['sub_option_texts'];
    $sub_option_values = $_POST['sub_option_values'];
    $priority = $_POST['sub_option_priority'];
    $id = $_POST['sub_option_id'];
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
        // Checking existance
        $table = $option_type.'_'.$option_id;
        $values_table = $option_type.'_'.$option_id.'_values';
        $sql="SELECT * FROM `$table` WHERE `id`= '$id'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            // Deleting data into database
            $sql="DELETE FROM `$table` WHERE `id`='$id'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                // Delete Column in table
                $sql="ALTER TABLE `$values_table` DROP opt_$id;";  
                $result = mysqli_query($local_conn_db, $sql);
                if($result){
                    echo "Deleted Successfully...!";
                }
                else{
                    echo "Error in deleting cloumn...!";
                }
            }
            else{
                echo "Error in deleting data...!";
            }   
        }
        else{
            echo "Data not existed...!";
        }
    }
    else{
        echo "Database not found...!";
    }
}


?>