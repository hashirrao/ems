<?php
    include("../../connections/connection.php");
    include("../../connections/local_connection.php");
    $system_id = $_POST["system_id"];
    $business = $_POST["business"];
    $othr_src_tbl = $_POST["othr_src_tbl"]."_values";
    $othr_src_clm = $_POST["othr_src_clm"];
    $othr_src_clm_val = $_POST["othr_src_clm_val"];
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
        $sql="SELECT $othr_src_clm_val, $othr_src_clm FROM $othr_src_tbl WHERE `added_for`='$business'";
        // echo $sql;
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){ 
                    echo  '<option value="'.$row[$othr_src_clm_val].'">'.$row[$othr_src_clm].'</option>';
                }
            }
            // else{
            //     echo "<option>NO RESULT<option>";
            // }
    }
    else{
        echo "Database not found...!";
    }
?>