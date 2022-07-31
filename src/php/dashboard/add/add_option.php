<?php

include('../../connections/connection.php');
include('../../connections/local_connection.php');

$message = '';
if(isset($_POST['asset_name'])){
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
        $asset_id = "";
        if($result->num_rows === 0){
            // Inserting data into database
            $sql="INSERT INTO `spec_options`(`type`, `name`) VALUES ('asset', '$asset_name')";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                $sql="SELECT * FROM `spec_options` WHERE `type`='asset' AND `name`= '$asset_name'";
                $result = mysqli_query($local_conn_db, $sql);
                $asset_id = "";
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $asset_id = $row["id"];
                    }
                }
                // Creating table of asset
                if($asset_id != ""){
                    $sql = "CREATE TABLE IF NOT EXISTS asset_$asset_id (
                        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        `option_name` VARCHAR(100) NOT NULL,
                        `option_type` VARCHAR(100) NOT NULL,
                        `option_empty_check` VARCHAR(10) NOT NULL,
                        `option_similarity_check` VARCHAR(10) NOT NULL,
                        `option_texts` TEXT,
                        `option_values` TEXT,
                        `option_val_frm_othr_src` VARCHAR(10),
                        `option_othr_src_table` VARCHAR(100),
                        `option_othr_src_column` VARCHAR(100),
                        `option_othr_src_column_value` VARCHAR(100),
                        `option_whole_table_search` VARCHAR(10),
                        `option_priority` INT(5),
                        `status` VARCHAR(20),
                        `field_type` VARCHAR(20),
                        `formula` VARCHAR(255),
                        `editable` VARCHAR(10),
                        `visible` VARCHAR(10),
                        `table_visible` VARCHAR(10),
                        `reg_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                        ) ";
                    if ($local_conn_db->query($sql) === TRUE) {
                        $sql = "CREATE TABLE IF NOT EXISTS asset_".$asset_id."_values (
                            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                            `added_by` VARCHAR(30),
                            `added_for` VARCHAR(30),
                            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                            ) ";
                        if ($local_conn_db->query($sql) === TRUE) {
                            echo "Added Successfully...!";
                        }
                        else{
                            echo "Error in creating values table...!";
                        }
                    }
                    else{
                        echo "Error in creating table...!";
                    }
                }
                else{
                    echo "Asset not found...!";
                }
            }
            else{
                echo "Error in inserting data...!";
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
        //Checking Dulication
        $sql="SELECT * FROM `spec_options` WHERE `type`='entry' AND `name`= '$entry_name'";
        $result = mysqli_query($local_conn_db, $sql);
        $entry_id = "";
        if($result->num_rows === 0){
            // Inserting data into database
            $sql="INSERT INTO `spec_options`(`type`, `name`) VALUES ('entry', '$entry_name')";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                $sql="SELECT * FROM `spec_options` WHERE `type`='entry' AND `name`= '$entry_name'";
                $result = mysqli_query($local_conn_db, $sql);
                $entry_id = "";
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $entry_id = $row["id"];
                    }
                }
                // Creating table of entry
                if($entry_id != ""){
                    $sql = "CREATE TABLE entry_$entry_id (
                        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        `option_name` VARCHAR(100) NOT NULL,
                        `option_type` VARCHAR(100) NOT NULL,
                        `option_empty_check` VARCHAR(10) NOT NULL,
                        `option_similarity_check` VARCHAR(10) NOT NULL,
                        `option_texts` TEXT,
                        `option_values` TEXT,
                        `option_val_frm_othr_src` VARCHAR(10),
                        `option_othr_src_table` VARCHAR(100),
                        `option_othr_src_column` VARCHAR(100),
                        `option_othr_src_column_value` VARCHAR(100),
                        `option_whole_table_search` VARCHAR(10),
                        `entry_type` VARCHAR(10),
                        `entry_sum` VARCHAR(10),
                        `custom_storage` VARCHAR(100),
                        `option_priority` INT(5),
                        `status` VARCHAR(20),
                        `field_type` VARCHAR(20),
                        `formula` VARCHAR(255),
                        `editable` VARCHAR(10),
                        `visible` VARCHAR(10),
                        `table_visible` VARCHAR(10),
                        `reg_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                        ) ";
                    if ($local_conn_db->query($sql) === TRUE) {
                        $sql = "CREATE TABLE IF NOT EXISTS entry_".$entry_id."_values (
                            `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                            `voucher_no` INT(11) UNSIGNED,
                            `added_by` VARCHAR(30),
                            `added_for` VARCHAR(30),
                            `reg_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                            ) ";
                        if ($local_conn_db->query($sql) === TRUE) {
                            echo "Added Successfully...!";
                        }
                        else{
                            echo "Error in creating values table...!";
                        }
                    }
                    else{
                        echo "Error in creating table...!";
                    }
                }
                else{
                    echo "Entry not found...!";
                }
            }
            else{
                echo "Error in inserting data...!";
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
    $report_name = $_POST['report_name'];
    $report_type = $_POST['report_type'];
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
        //Checking Dulication
        $sql="SELECT * FROM `spec_options` WHERE `type` LIKE '%report%' AND `name`= '$report_name'";
        $result = mysqli_query($local_conn_db, $sql);
        $report_id = "";
        if($result->num_rows === 0){
            // Inserting data into database
            if($report_type === "Single Table"){
                $sql="INSERT INTO `spec_options`(`type`, `name`) VALUES ('report', '$report_name')";
            }
            else{
                $sql="INSERT INTO `spec_options`(`type`, `name`) VALUES ('mt_report', '$report_name')";
            }
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                $sql="SELECT * FROM `spec_options` WHERE `type` LIKE '%report%' AND `name`= '$report_name'";
                $result = mysqli_query($local_conn_db, $sql);
                $report_id = "";
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $report_id = $row["id"];
                    }
                }
                // Creating table of report
                if($report_id !== ""){
                    if($report_type === "Single Table"){
                        $sql = "CREATE TABLE report_$report_id (
                            `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                            `table` VARCHAR(255),
                            `against_table` VARCHAR(255),
                            `column_name` VARCHAR(255),
                            `column` VARCHAR(255),
                            `against_column` VARCHAR(255),
                            `column_type` VARCHAR(100),
                            `is_heading` VARCHAR(10),
                            `is_visible` VARCHAR(10),
                            `is_filter` VARCHAR(10),
                            `field_type` VARCHAR(20),
                            `formula` VARCHAR(255),
                            `entry_sum` VARCHAR(10),
                            `option_priority` int(5),
                            `reg_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                            ) ";
                    }
                    else{
                        $sql = "CREATE TABLE mt_report_$report_id (
                            `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                            `parameter_table` VARCHAR(255),
                            `table` VARCHAR(255),
                            `against_table` VARCHAR(255),
                            `column_name` VARCHAR(255),
                            `parameter_column` VARCHAR(255),
                            `column` VARCHAR(255),
                            `against_column` VARCHAR(255),
                            `column_type` VARCHAR(100),
                            `column_selection` VARCHAR(100),
                            `is_heading` VARCHAR(10),
                            `is_visible` VARCHAR(10),
                            `is_filter` VARCHAR(10),
                            `field_type` VARCHAR(20),
                            `formula` VARCHAR(255),
                            `entry_sum` VARCHAR(10),
                            `option_priority` int(5),
                            `reg_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                            ) ";
                    }
                    if ($local_conn_db->query($sql) === TRUE) {
                        echo "Added Successfully...!";
                    }
                    else{
                        echo "Error in creating table...!";
                    }
                }
                else{
                    echo "Already Exists...!";
                }
            }
            else{
                echo "Error in inserting data...!";
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
        //Checking Dulication
        $sql="SELECT * FROM `spec_options` WHERE `type`='custom_table' AND `name`= '$custom_table_name'";
        $result = mysqli_query($local_conn_db, $sql);
        $custom_table_id = "";
        if($result->num_rows === 0){
            // Inserting data into database
            $sql="INSERT INTO `spec_options`(`type`, `name`) VALUES ('custom_table', '$custom_table_name')";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                $sql="SELECT * FROM `spec_options` WHERE `type`='custom_table' AND `name`= '$custom_table_name'";
                $result = mysqli_query($local_conn_db, $sql);
                $custom_table_id = "";
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $custom_table_id = $row["id"];
                    }
                }
                // Creating table of custom_table
                if($custom_table_id != ""){
                    $sql = "CREATE TABLE custom_table_$custom_table_id (
                        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        `option_name` VARCHAR(100) NOT NULL,
                        `option_type` VARCHAR(100) NOT NULL,
                        `option_priority` INT(5),
                        `status` VARCHAR(20),
                        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                        ) ";
                    if ($local_conn_db->query($sql) === TRUE) {
                        $sql = "CREATE TABLE IF NOT EXISTS custom_table_".$custom_table_id."_values (
                            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                            ) ";
                        if ($local_conn_db->query($sql) === TRUE) {
                            echo "Added Successfully...!";
                        }
                        else{
                            echo "Error in creating values table...!";
                        }
                    }
                }
                else{
                    echo "Custom table not found...!";
                }
            }
            else{
                echo "Error in inserting data...!";
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