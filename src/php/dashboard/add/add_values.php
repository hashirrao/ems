<?php

include('../../connections/connection.php');
include('../../connections/local_connection.php');

if($_POST['option_type'] === "asset"){
    $option_type = $_POST['option_type'];
    $option_id = $_POST['option_id'];
    $inp_ids = explode(",", $_POST['inp_ids']);
    $values = explode(",", $_POST['values']);
    $system_id = $_POST['system_id'];
    $user_id = $_POST['user_id'];
    $user_type = $_POST['user_type'];
    $user = $user_type."_".$user_id;
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
        $sql_columns = "";
        $sql_values = "";
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
                            $check_similarity_sql="SELECT * FROM `$values_table` WHERE `opt_".$row["id"]."`='".$values[$i]."'";
                        }
                        else{
                            $check_similarity_sql="SELECT * FROM `$values_table` WHERE `opt_".$row["id"]."`='".$values[$i]."' AND `added_for`='$business'";
                        }
                        $result = mysqli_query($local_conn_db, $check_similarity_sql);
                        if($result->num_rows > 0){
                            $similarity_check = "True";
                            $against_similarity = $row["option_name"];
                        break;
                        }
                    }
                    if($sql_columns == ""){
                        $sql_columns = "`opt_".$row["id"]."`";
                        $sql_values = "'".$values[$i]."'";
                    }
                    else{
                        $sql_columns = $sql_columns.",`opt_".$row["id"]."`";
                        $sql_values = $sql_values.",'".$values[$i]."'";
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
                if($sql_columns !== null){
                    $values_table = $table."_values";
                    if($option_id === "1"){
                        $sql1 = "INSERT INTO `$values_table` (";
                        $sql2 = ") VALUES (";
                    }
                    else{
                        $sql1 = "INSERT INTO `$values_table` (added_by, `added_for`,";
                        $sql2 = ") VALUES ('$user', '$business',";
                    }
                    $sql3 = ")";   
                    $sql_insert_values = $sql1.$sql_columns.$sql2.$sql_values.$sql3;
                    // echo $sql_insert_values;
                    $result = mysqli_query($local_conn_db, $sql_insert_values);
                    if($result){
                        echo "Added Successfully...!";
                    }
                    else{
                        echo "Error in inserting data...!";
                    }
                }
                else{
                    echo $inp_ids[$i]." not found...!";
                }   
            }
            else{
                $similarity_check = "False";
                echo "'".$against_similarity."' already exist...!";    
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
elseif($_POST['option_type'] === "entry"){
    $option_type = $_POST['option_type'];
    $option_id = $_POST['option_id'];
    $voucher_no = $_POST['voucher_no'];
    $single_ids = explode(",", $_POST['single_ids']);
    $single_values = explode(",", $_POST['single_values']);
    $multiple_ids = explode("-splitter-", $_POST['multiple_ids']);
    $multiple_values = explode("-splitter-", $_POST['multiple_values']);
    $system_id = $_POST['system_id'];
    $user_id = $_POST['user_id'];
    $user_type = $_POST['user_type'];
    $user = $user_type."_".$user_id;
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
        for($i=0; $i<count($multiple_ids)-1; $i++){
            $opt_id = "";
            $sql_columns = "`voucher_no`,`added_by`,`added_for`";
            $sql_values = "'".$voucher_no."','".$user."','".$business."'";
            $table = $option_type.'_'.$option_id;
            $empty_check = "False";
            $similarity_check = "False";
            for($j=0; $j<count($single_ids); $j++){
                $sql="SELECT * FROM `$table` WHERE `option_name`='".$single_ids[$j]."'";
                $result = mysqli_query($local_conn_db, $sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        if($row["option_empty_check"] === "True"){
                            if($single_values[$j] === ""){
                                $empty_check = "True";
                                $against_empty = $row["option_name"];
                                break;
                            }
                        }
                        if($row["option_similarity_check"] === "True"){
                            $values_table = $table."_values";
                            $check_similarity_sql="SELECT * FROM `$values_table` WHERE `opt_".$row["id"]."`='".$values[$i]."'";
                            $result = mysqli_query($local_conn_db, $check_similarity_sql);
                            if($result->num_rows > 0){
                                $similarity_check = "True";
                                $against_similarity = $row["option_name"];
                                break;
                            }
                        }
                        $sql_columns = $sql_columns.",`opt_".$row["id"]."`";
                        $sql_values = $sql_values.",'".$single_values[$j]."'";
                    }
                    if($empty_check === "True"){
                    break;
                    }
                    if($similarity_check === "True"){
                    break;
                    }
                }
            }
            $m_ids_arr = explode(",", $multiple_ids[$i]);
            $m_values_arr = explode(",", $multiple_values[$i]);
            for($j=0; $j<count($m_ids_arr); $j++){
                $sql1="SELECT * FROM `$table` WHERE `option_name`='".$m_ids_arr[$j]."'";
                $result1 = mysqli_query($local_conn_db, $sql1);
                if($result1->num_rows > 0){
                    while($row1 = $result1->fetch_assoc()){
                        if($row1["option_empty_check"] === "True"){
                            if($m_values_arr[$j] === ""){
                                $empty_check = "True";
                                $against_empty = $row["option_name"];
                                break;
                            }
                        }
                        if($row1["option_similarity_check"] === "True"){
                            $values_table = $table."_values";
                            $check_similarity_sql="SELECT * FROM `$values_table` WHERE `opt_".$row1["id"]."`='".$m_values_arr[$j]."'";
                            $result1 = mysqli_query($local_conn_db, $check_similarity_sql);
                            if($result1->num_rows > 0){
                                $similarity_check = "True";
                                $against_similarity = $row1["option_name"];
                                break;
                            }
                        }
                        if($sql_columns == ""){
                            $sql_columns = "`opt_".$row1["id"]."`";
                            $sql_values = "'".$m_values_arr[$j]."'";
                        }
                        else{
                            $sql_columns = $sql_columns.",`opt_".$row1["id"]."`";
                            $sql_values = $sql_values.",'".$m_values_arr[$j]."'";
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
                    if($sql_columns !== null){
                        $values_table = $table."_values";
                        $sql1 = "INSERT INTO `$values_table` (";
                        $sql2 = ") VALUES (";
                        $sql3 = ")";   
                        $sql_insert_values = $sql1.$sql_columns.$sql2.$sql_values.$sql3;
                        // echo $sql_insert_values;
                        $result = mysqli_query($local_conn_db, $sql_insert_values);
                        if($result){
                            if($i === count($multiple_ids)-2){
                                echo "Inserted Successfully...!";
                            }
                        }
                        else{
                            echo "Error in inserting data...!";
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
    }
    else{
        echo "Database not found...!";
    }
}
?>