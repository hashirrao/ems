<?php
    include("../../connections/connection.php");
    include("../../connections/local_connection.php");
    $system_id = $_POST["system_id"];
    $table = $_POST["table"];
    $column = $_POST["column"];
    $column_against = $_POST["column_against"];
    $value_against = $_POST["value_against"];
    $user_id = $_POST['user_id'];
    $user_type = $_POST['user_type'];
    $user = $user_type."_".$user_id;
    $business = $_POST["business"];
    $database_name = "";
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
        $table_arr = explode("--", $table);
        $column_arr = explode("--", $column);
        $column_against_arr = explode("--", $column_against);
        for($i=0; $i<count($table_arr); $i++){
            $table = $table_arr[$i];
            $column = $column_arr[$i];
            $column_against = $column_against_arr[$i];
            $table = $table."_values";
            if (strpos($table, 'asset') !== false) {
                $sql="SELECT * FROM $table WHERE `$column_against`='$value_against' AND `added_for`='$business'";
            }
            else{
                $sql="SELECT * FROM $table WHERE `$column_against`='$value_against' AND `entry_of`='$business'";
            }
            // echo $sql;
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){ 
                    if(count($table_arr) > 1){
                        if($table === "asset_2_values"){
                            echo "S-".$row[$column];
                        }
                        else if($table === "asset_3_values"){
                            echo "C-".$row[$column];
                        }
                        else if($table === "asset_49_values"){
                            echo "A-".$row[$column];
                        }
                    }
                    else{
                        echo $row[$column]; 
                    }
                }
            }
            // else{
            //     echo "NO RESULT";
            // }
        }
    }
    else{
        echo "Database not found...!";
    }
?>