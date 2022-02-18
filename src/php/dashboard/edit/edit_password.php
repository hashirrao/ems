<?php

include('../../connections/connection.php');
include('../../connections/local_connection.php');

$message = '';
if(isset($_POST['password'])){
    $id = $_POST['user_id'];
    $password = $_POST['password'];
    $newpassword = $_POST['new_password'];
    $encpassword = md5($password, "h123f3");
    $encnewpassword = md5($newpassword, "h123f3");
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
        $sql="SELECT * FROM `users` WHERE `id`='$id' AND `password`='$encpassword'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            // Inserting data into database
            $sql="UPDATE `users` SET `password`='$encnewpassword' WHERE `id`='$id'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                echo "Password Changed...!";
            }
            else{
                echo "Error in inserting data...!";
            }   
        }
        else{
            echo "Wrong Password...!";
        }
    }
    else{
        echo "Database not found...!";
    }
}

?>