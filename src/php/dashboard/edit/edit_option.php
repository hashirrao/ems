<?php

include('../../connections/connection.php');
include('../../connections/local_connection.php');

$message = '';
if(isset($_POST['asset_name'])){
    $asset_id = $_POST['asset_id'];
    $asset_name = $_POST['asset_name'];
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
        // Checking duplication
        $sql="SELECT * FROM `spec_options` WHERE `type`='asset' AND `name`= '$asset_name'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows === 0){
            // Updating data from database
            $sql="UPDATE `spec_options` SET `name`='$asset_name' WHERE `id`='$asset_id'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                echo "Updated Successfully...!";
            }
            else{
                echo "Error in updating data...!";
            }   
        }
        else{
            echo "Asset already exists...!";
        }
    }
    else{
        echo "Database not found...!";
    }
}
else if(isset($_POST['entry_name'])){
    $entry_id = $_POST['entry_id'];
    $entry_name = $_POST['entry_name'];
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
        // Checking duplication
        $sql="SELECT * FROM `spec_options` WHERE `type`='entry' AND `name`= '$entry_name'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows === 0){
            // Updating data from database
            $sql="UPDATE `spec_options` SET `name`='$entry_name' WHERE `id`='$entry_id'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                echo "Updated Successfully...!";
            }
            else{
                echo "Error in updating data...!";
            }   
        }
        else{
            echo "Entry already exists...!";
        }
    }
    else{
        echo "Database not found...!";
    }
}
else if(isset($_POST['report_name'])){
    $report_id = $_POST['report_id'];
    $report_name = $_POST['report_name'];
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
        // Checking duplication
        $sql="SELECT * FROM `spec_options` WHERE `type` LIKE '%report%' AND `name`= '$report_name'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows === 0){
            // Updating data from database
            $sql="UPDATE `spec_options` SET `name`='$report_name' WHERE `id`='$report_id'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                echo "Updated Successfully...!";
            }
            else{
                echo "Error in updating data...!";
            }   
        }
        else{
            echo "Report already exists...!";
        }
    }
    else{
        echo "Database not found...!";
    }
}
else if(isset($_POST['custom_table_name'])){
    $custom_table_id = $_POST['custom_table_id'];
    $custom_table_name = $_POST['custom_table_name'];
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
        // Checking duplication
        $sql="SELECT * FROM `spec_options` WHERE `type`='custom_table' AND `name`= '$custom_table_name'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows === 0){
            // Updating data from database
            $sql="UPDATE `spec_options` SET `name`='$custom_table_name' WHERE `id`='$custom_table_id'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                echo "Updated Successfully...!";
            }
            else{
                echo "Error in updating data...!";
            }   
        }
        else{
            echo "Custom Table already exists...!";
        }
    }
    else{
        echo "Database not found...!";
    }
}

?>