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
        // Checking occurrence
        $sql="SELECT * FROM `spec_options` WHERE `id`= '$asset_id'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            $sql="DELETE FROM `spec_options` WHERE `id`='$asset_id'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                // Deleting table of asset
                $sql = "DROP TABLE asset_$asset_id";
                if ($local_conn_db->query($sql) === TRUE) {
                    $sql = "DROP TABLE asset_".$asset_id."_values";
                    if ($local_conn_db->query($sql) === TRUE) {
                        echo "Deleted Successfully...!";
                    }
                }
            }
        }
        else{
            echo "Asset not found...!";
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
        // Checking occurrence
        $sql="SELECT * FROM `spec_options` WHERE `id`= '$entry_id'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            $sql="DELETE FROM `spec_options` WHERE `id`='$entry_id'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                // Deleting table of entry
                $sql = "DROP TABLE entry_$entry_id";
                if ($local_conn_db->query($sql) === TRUE) {
                    $sql = "DROP TABLE entry_".$entry_id."_values";
                    if ($local_conn_db->query($sql) === TRUE) {
                        echo "Deleted Successfully...!";
                    }
                }
            }
        }
        else{
            echo "Entry not found...!";
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
        $option_type = "";
        $sql="SELECT * FROM `spec_options` WHERE `id`='$report_id'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $option_type = $row["type"];
            }
        }
        // Checking occurrence
        $sql="SELECT * FROM `spec_options` WHERE `id`= '$report_id'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            $sql="DELETE FROM `spec_options` WHERE `id`='$report_id'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                // Deleting table of report
                $table = $option_type.'_'.$report_id;
                $sql = "DROP TABLE $table";
                if ($local_conn_db->query($sql) === TRUE) {
                    echo "Deleted Successfully...!";
                }
            }
        }
        else{
            echo "Report not found...!";
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
        // Checking occurrence
        $sql="SELECT * FROM `spec_options` WHERE `id`= '$custom_table_id'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            $sql="DELETE FROM `spec_options` WHERE `id`='$custom_table_id'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                // Deleting table of custom_table
                $sql = "DROP TABLE custom_table_$custom_table_id";
                if ($local_conn_db->query($sql) === TRUE) {
                    $sql = "DROP TABLE custom_table_".$custom_table_id."_values";
                    if ($local_conn_db->query($sql) === TRUE) {
                        echo "Deleted Successfully...!";
                    }
                }
            }
        }
        else{
            echo "Custom Table not found...!";
        }
    }
    else{
        echo "Database not found...!";
    }
}

?>