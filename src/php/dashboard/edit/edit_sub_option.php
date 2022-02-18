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
    $priority = $_POST['sub_option_priority'];
    $status = $_POST['sub_option_status'];
    $sub_option_entry_type = $_POST['sub_option_entry_type'];
    $sub_option_custom_storage = $_POST['sub_option_custom_storage'];
    $sub_option_entry_sum = $_POST['sub_option_entry_sum'];
    $sub_option_custom_storage_table = $_POST['sub_option_custom_storage_table'];
    $sub_option_custom_storage_column = $_POST['sub_option_custom_storage_column'];
    $sub_option_field_type = $_POST['sub_option_field_type'];
    $sub_option_formula = $_POST['sub_option_formula'];
    $sub_option_editable = $_POST['sub_option_editable'];
    $sub_option_visible = $_POST['sub_option_visible'];
    $sub_option_table_visible = $_POST['sub_option_table_visible'];
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
        // Checking duplication
        $table = $option_type.'_'.$option_id;
        $values_table = $option_type.'_'.$option_id.'_values';
        $sql="SELECT * FROM `$table` WHERE `option_name`= '$sub_option_name' AND `id`!= '$id'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows === 0){
            // Updating data into database
            if($option_type === "asset"){
                $sql="UPDATE `$table` SET `option_name`='$sub_option_name', 
                `option_type`='$sub_option_type', 
                `option_empty_check`='$sub_option_empty_check', 
                `option_similarity_check`='$sub_option_similarity_check', 
                `option_texts`='$sub_option_texts', 
                `option_values`='$sub_option_values', 
                `option_val_frm_othr_src`='$sub_option_other_source_value', 
                `option_othr_src_table`='$sub_option_other_source_table', 
                `option_othr_src_column`='$sub_option_other_source_column', 
                `option_othr_src_column_value`='$sub_option_other_source_column_value', 
                `option_whole_table_search`='$sub_option_whole_table_search', 
                `field_type`='$sub_option_field_type',
                `formula`='$sub_option_formula',
                `editable`='$sub_option_editable',
                `visible`='$sub_option_visible',
                `status`='$status',
                `option_priority`='$priority' WHERE `id`='$id'";    
            }
            else if($option_type === "entry"){
                if($sub_option_custom_storage === "True"){
                    $sub_option_custom_storage_val = $sub_option_custom_storage_table."--".$sub_option_custom_storage_column;
                }
                else{
                    $sub_option_custom_storage_val = "False";
                }
                $sql="UPDATE `$table` SET `option_name`='$sub_option_name', 
                `option_type`='$sub_option_type', 
                `option_empty_check`='$sub_option_empty_check', 
                `option_similarity_check`='$sub_option_similarity_check', 
                `option_texts`='$sub_option_texts', 
                `option_values`='$sub_option_values', 
                `option_val_frm_othr_src`='$sub_option_other_source_value', 
                `option_othr_src_table`='$sub_option_other_source_table', 
                `option_othr_src_column`='$sub_option_other_source_column', 
                `option_othr_src_column_value`='$sub_option_other_source_column_value', 
                `option_whole_table_search`='$sub_option_whole_table_search', 
                `option_priority`='$priority',   
                `status`='$status',
                `entry_type`='$sub_option_entry_type',
                `entry_sum`='$sub_option_entry_sum',
                `custom_storage`='$sub_option_custom_storage_val',
                `field_type`='$sub_option_field_type',
                `formula`='$sub_option_formula',
                `editable`='$sub_option_editable',
                `visible`='$sub_option_visible',
                `table_visible`='$sub_option_table_visible'
                 WHERE `id`='$id'";    
            }
            else if($option_type === "custom_table"){
                $sql="UPDATE `$table` SET `option_name`='$sub_option_name', 
                `option_type`='$sub_option_type' WHERE `id`='$id'";    
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
                    if($sub_option_type === "Input Number"){
                        $sql="ALTER TABLE `$values_table` MODIFY opt_$opt_id int(11)";
                    }
                    else if($sub_option_type === "Input Number With Point"){
                        $sql="ALTER TABLE `$values_table` MODIFY opt_$opt_id decimal(20, 2)";
                    }
                    else if($sub_option_type === "Input Date"){
                        $sql="ALTER TABLE `$values_table` MODIFY opt_$opt_id date";
                    }   
                    else{
                        $sql="ALTER TABLE `$values_table` MODIFY opt_$opt_id varchar(255)";
                    }
                    $result = mysqli_query($local_conn_db, $sql);
                    if($result){
                        echo "Updated Successfully...!";
                    }
                    else{
                        echo "Error in updating cloumn...!";
                    }
                }
                else {
                    echo "Value not found...!";
                }
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


?>