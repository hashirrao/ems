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
    $sub_option_empty_check = $_POST['sub_option_empty_check'];
    $sub_option_similarity_check = $_POST['sub_option_similarity_check'];
    $sub_option_texts = $_POST['sub_option_texts'];
    $sub_option_values = $_POST['sub_option_values'];
    $sub_option_other_source_value = $_POST['sub_option_other_source_value'];
    $sub_option_other_source_table = $_POST['sub_option_other_source_table'];
    $sub_option_other_source_column = $_POST['sub_option_other_source_column'];
    $sub_option_other_source_column_value = $_POST['sub_option_other_source_column_value'];
    $sub_option_whole_table_search = $_POST['sub_option_whole_table_search'];
    $sub_option_entry_type = $_POST['sub_option_entry_type'];
    $sub_option_entry_sum = $_POST['sub_option_entry_sum'];
    $sub_option_custom_storage = $_POST['sub_option_custom_storage'];
    $sub_option_custom_storage_table = $_POST['sub_option_custom_storage_table'];
    $sub_option_custom_storage_column = $_POST['sub_option_custom_storage_column'];
    $sub_option_field_type = $_POST['sub_option_field_type'];
    $sub_option_formula = $_POST['sub_option_formula'];
    $sub_option_editable = $_POST['sub_option_editable'];
    $sub_option_visible = $_POST['sub_option_visible'];
    $sub_option_table_visible = $_POST['sub_option_table_visible'];
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
        $table = $option_type.'_'.$option_id;
        $values_table = $option_type.'_'.$option_id.'_values';
        $sql="SELECT * FROM `$table` WHERE `option_name`= '$sub_option_name'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows === 0){
            $max_priority = 0;
            
            $sql="SELECT MAX(`option_priority`) as `max_priority` FROM `$table`";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $max_priority = $row["max_priority"];
                }
            }
            // Inserting data into database
            $max_priority++;
            if($option_type === "asset"){
                $sql="INSERT INTO `$table` (`option_name`, `option_type`, `option_empty_check`, `option_similarity_check`, `option_texts`, `option_values`, `option_val_frm_othr_src`, `option_othr_src_table`, `option_othr_src_column`, `option_othr_src_column_value`, `option_whole_table_search`, `option_priority`, `status`, `field_type`, `formula`, `editable`, `visible`) 
                VALUES ('$sub_option_name', '$sub_option_type', '$sub_option_empty_check', '$sub_option_similarity_check', '$sub_option_texts', '$sub_option_values', '$sub_option_other_source_value', '$sub_option_other_source_table', '$sub_option_other_source_column', '$sub_option_other_source_column_value', '$sub_option_whole_table_search', '$max_priority', 'Activate', '$sub_option_field_type', '$sub_option_formula', '$sub_option_editable', '$sub_option_visible')";
            }
            else if($option_type === "entry"){
                if($sub_option_custom_storage === "True"){
                    $sub_option_custom_storage_table_and_column = $sub_option_custom_storage_table."--".$sub_option_custom_storage_column;
                    $sql="INSERT INTO `$table` (`option_name`, `option_type`, `option_empty_check`, `option_similarity_check`, `option_texts`, `option_values`, `option_val_frm_othr_src`, `option_othr_src_table`, `option_othr_src_column`, `option_othr_src_column_value`, `option_whole_table_search`, `entry_type`, `entry_sum`, `custom_storage`, `option_priority`, `status`, `field_type`, `formula`, `editable`, `visible`, `table_visible`) 
                    VALUES ('$sub_option_name', '$sub_option_type', '$sub_option_empty_check', '$sub_option_similarity_check', '$sub_option_texts', '$sub_option_values', '$sub_option_other_source_value', '$sub_option_other_source_table', '$sub_option_other_source_column', '$sub_option_other_source_column_value', '$sub_option_whole_table_search', '$sub_option_entry_type', '$sub_option_entry_sum', '$sub_option_custom_storage_table_and_column', '$max_priority', 'Activate', '$sub_option_field_type', '$sub_option_formula', '$sub_option_editable', '$sub_option_visible', '$sub_option_table_visible')";
                }
                else{
                    $sql="INSERT INTO `$table` (`option_name`, `option_type`, `option_empty_check`, `option_similarity_check`, `option_texts`, `option_values`, `option_val_frm_othr_src`, `option_othr_src_table`, `option_othr_src_column`, `option_othr_src_column_value`, `option_whole_table_search`, `entry_type`, `entry_sum`, `custom_storage`, `option_priority`, `status`, `field_type`, `formula`, `editable`, `visible`, `table_visible`) 
                    VALUES ('$sub_option_name', '$sub_option_type', '$sub_option_empty_check', '$sub_option_similarity_check', '$sub_option_texts', '$sub_option_values', '$sub_option_other_source_value', '$sub_option_other_source_table', '$sub_option_other_source_column', '$sub_option_other_source_column_value', '$sub_option_whole_table_search', '$sub_option_entry_type', '$sub_option_entry_sum', '$sub_option_custom_storage', '$max_priority', 'Activate', '$sub_option_field_type', '$sub_option_formula', '$sub_option_editable', '$sub_option_visible', '$sub_option_table_visible')";
                }
            }
            else if($option_type === "custom_table"){    
                $sql="INSERT INTO `$table` (`option_name`, `option_type`, `option_priority`, `Status`) 
                VALUES ('$sub_option_name', '$sub_option_type', '$max_priority', 'Activate')";
            }
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                $opt_id = "";
                $sql="SELECT * FROM `$table` WHERE `option_name`= '$sub_option_name'";
                $result = mysqli_query($local_conn_db, $sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $opt_id = $row["id"];
                    }
                }
                if($opt_id !== ""){
                    // Add Column in table
                    if($sub_option_type == "Input Number"){
                        $sql="ALTER TABLE `$values_table` ADD opt_$opt_id int(11);";    
                    }
                    else if($sub_option_type == "Input Number With Point"){
                        $sql="ALTER TABLE `$values_table` ADD opt_$opt_id decimal(20, 2);";    
                    }
                    else if($sub_option_type == "Input Date"){
                        $sql="ALTER TABLE `$values_table` ADD opt_$opt_id date;";
                    }   
                    else{
                        $sql="ALTER TABLE `$values_table` ADD opt_$opt_id varchar(255);";
                    }
                    $result = mysqli_query($local_conn_db, $sql);
                    if($result){
                        echo "Added Successfully...!";
                    }
                    else{
                        echo "Error in creating cloumn...!";
                    }
                }
                else {
                    echo "Value not found...!";
                }
            }
            else{
                echo "Error in inserting data...!";
            }   
        }
        else{
            echo "Option already exists...!";
        }
    }
    else{
        echo "Database not found...!";
    }
}
else if(isset($_POST['report_select_table'])){
    $option_id = $_POST['option_id'];
    $option_type = $_POST['option_type'];
    $system_id = $_POST['system_id'];
    $report_parameter_table = "";
    $report_parameter_table = $_POST['report_parameter_table'];
    $report_select_table = $_POST['report_select_table'];
    $report_against_table = $_POST['report_against_table'];
    $report_column_name = $_POST['report_column_name'];
    $report_parameter_column = "";
    $report_parameter_column = $_POST['report_parameter_column'];
    $report_select_column = $_POST['report_select_column'];
    $report_against_column = $_POST['report_against_column'];
    $report_select_column_type = $_POST['report_select_column_type'];
    $report_select_selection = $_POST['report_select_selection'];
    $report_is_heading = $_POST['report_is_heading'];
    $report_is_visible = $_POST['report_is_visible'];
    $report_is_filter = $_POST['report_is_filter'];
    $report_formula = $_POST['report_formula'];
    $report_entry_sum = $_POST['report_entry_sum'];

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
        $sql="SELECT * FROM `spec_options` WHERE `id`='$option_id'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $option_type = $row["type"];
            }
        }
        $table = $option_type.'_'.$option_id;
        $values_table = $option_type.'_'.$option_id.'_values';
        $sql="SELECT * FROM `$table` WHERE `column_name`= '$report_column_name'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows === 0){
            $max_priority = 0;
            $sql="SELECT MAX(`option_priority`) as `max_priority` FROM `$table`";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $max_priority = $row["max_priority"];
                }
            }
            // Inserting data into database
            $max_priority++;
            if($option_type === "report"){
                $sql="INSERT INTO `$table` (`table`, `against_table`, `column_name`, `column`, `against_column`, `column_type`, `is_heading`, `is_visible`, `is_filter`, `formula`, `entry_sum`, `option_priority`) 
                VALUES ('$report_select_table', '$report_against_table', '$report_column_name', '$report_select_column', '$report_against_column', '$report_select_column_type', '$report_is_heading', '$report_is_visible', '$report_is_filter', '$report_formula', '$report_entry_sum', '$max_priority')";
            }
            else if($option_type === "mt_report"){
                $sql="INSERT INTO `$table` (`parameter_table`, `table`, `against_table`, `column_name`, `parameter_column`, `column`, `against_column`, `column_type`, `column_selection`, `is_heading`, `is_visible`, `is_filter`, `formula`, `entry_sum`, `option_priority`) 
                VALUES ('$report_parameter_table', '$report_select_table', '$report_against_table', '$report_column_name', '$report_parameter_column', '$report_select_column', '$report_against_column', '$report_select_column_type', '$report_select_selection', '$report_is_heading', '$report_is_visible', '$report_is_filter', '$report_formula', '$report_entry_sum', '$max_priority')";
            }
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                echo "Added Successfully...!";
            }
            else{
                echo "Error in inserting data...!";
            }
        }
        else{
            echo "Option already exists...!";
        }   
    }
    else{
        echo "Database not found...!";
    }
}

?>