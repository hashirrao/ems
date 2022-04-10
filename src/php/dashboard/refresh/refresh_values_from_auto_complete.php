<?php
    include("../../connections/connection.php");
    include("../../connections/local_connection.php");
    $system_id = $_POST["system_id"];
    $table = $_POST["table_name"];
    $column = $_POST["column_name"];
    $value = $_POST["value"];
    $business = $_POST["business"];
    $database_name = "";
    $table_arr = explode("--", $table);
    $column_arr = explode("--", $column);
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
        $j=0;
        for($k=0; $k < count($table_arr); $k++){
            $table = $table_arr[$k];
            $column = $column_arr[$k];
            $table = $table."_values";
            if($table == "asset_1_values"){
                $sql="SELECT * FROM $table WHERE `$column` LIKE '%".$value."%' LIMIT 100";
            }
            else{
                $sql="SELECT * FROM $table WHERE `added_for`='$business' AND `$column` LIKE '%".$value."%' LIMIT 100";
            }
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                $i=0;
                while($row = $result->fetch_assoc()){ 
                    if($i === 0 && $j === 0 && $k === 0){
                        echo $row[$column]; 
                    }
                    else{
                        echo ",".$row[$column];
                    }
                    $i++;
                }
            }
            else{
                // echo "NO RESULTS";
                $j = -1;
            }
            $j++;
        }
    }
    else{
        echo "Database not found...!";
    }
    
?>