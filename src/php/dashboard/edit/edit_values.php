<?php

include('../../connections/connection.php');
include('../../connections/local_connection.php');

if($_POST['option_type'] === "asset"){
    $value_id = $_POST["value_id"];
    $option_type = $_POST['option_type'];
    $option_id = $_POST['option_id'];
    $inp_ids = explode(",", $_POST['inp_ids']);
    $values = explode(",", $_POST['values']);
    $system_id = $_POST['system_id'];
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
        // Fetching input ids from database
        $opt_id = "";
        $sql2 = "";
        $table = $option_type.'_'.$option_id;
        $empty_check = "False";
        $similarity_check = "False";
        for($i=0; $i<count($inp_ids); $i++){
            $sql="SELECT * FROM `$table` WHERE `option_name`='".$inp_ids[$i]."'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    if($row["option_empty_check"] === "True"){
                        if($values[$i] === ""){
                            $empty_check = "True";
                            $against_empty = $row["option_name"];
                        break;
                        }
                    }
                    if($row["option_similarity_check"] === "True"){
                        $values_table = $table."_values";
                        if($option_id === "1"){
                            $check_similarity_sql="SELECT * FROM `$values_table` WHERE `opt_".$row["id"]."`='".$values[$i]."' AND `id`!='$value_id'";
                        }
                        else{
                            $check_similarity_sql="SELECT * FROM `$values_table` WHERE `opt_".$row["id"]."`='".$values[$i]."' AND `id`!='$value_id' AND `added_for`='$business'";
                        }
                        $result = mysqli_query($local_conn_db, $check_similarity_sql);
                        if($result->num_rows > 0){
                            $similarity_check = "True";
                            $against_similarity = $row["option_name"];
                        break;
                        }
                    }
                    if($sql2 == ""){
                        $sql2 = "`opt_".$row["id"]."`='".$values[$i]."'";
                    }
                    else{
                        $sql2 = $sql2.",`opt_".$row["id"]."`='".$values[$i]."'";
                    }
                }
                if($empty_check === "True"){
                break;
                }
                if($similarity_check === "True"){
                break;
                }
            }            
        }
        if($empty_check === "False"){
            if($similarity_check === "False"){
                if($sql2 !== null){
                    $values_table = $table."_values";
                    $sql1 = "UPDATE `$values_table` SET ";
                    $sql3 = "WHERE id='".$value_id."'";   
                    $sql_update_values = $sql1.$sql2.$sql3;
                    // echo $sql_insert_values;
                    $result = mysqli_query($local_conn_db, $sql_update_values);
                    if($result){
                        echo "Updated Successfully...!";
                    }
                    else{
                        echo "Error in updating data...!";
                    }
                }
                else{
                    echo $inp_ids[$i]." not found...!";
                }
            }
            else{
                $similarity_check = "False";
                echo "'".$against_similarity."' value already exist...!";    
            }
        }
        else{
            $empty_check = "False";
            echo "'".$against_empty."' must not be empty...!";
        }
    }
    else{
        echo "Database not found...!";
    }
}

?>