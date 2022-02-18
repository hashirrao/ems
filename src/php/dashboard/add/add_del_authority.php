<?php

include('../../connections/connection.php');
include('../../connections/local_connection.php');

$message = '';
if(isset($_POST['spec_opt_id'])){
    $name = $_POST['name'];
    $type = $_POST['type'];
    $spec_opt_id = $_POST['spec_opt_id'];
    $current_user_id = $_POST['current_user_id'];
    $current_user_type = $_POST['current_user_type'];
    $user_id = $_POST['user_id'];
    $user_type = $_POST['user_type'];
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
        $sql="SELECT * FROM `spec_options_users` WHERE `user_id`='$user_id' AND `spec_option_id`='$spec_opt_id'";
        $result = mysqli_query($local_conn_db, $sql);
        $asset_id = "";
        if($result->num_rows === 0){
            // Inserting data into database
            $sql="INSERT INTO `spec_options_users` (`type`, `name`, `spec_option_id`, `user_id`) VALUES ('$type' ,'$name', '$spec_opt_id', '$user_id')";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                echo "Allowed";
            }
            else{
                echo "Some Error";
            }
        }
        else{
            $sql="DELETE FROM spec_options_users WHERE `user_id`='$user_id' AND `spec_option_id`='$spec_opt_id'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                echo "Not Allowed";
            }
            else{
                echo "Some Error";
            }
        }
    }
    else{
        echo "Database not found...!";
    }
}

?>