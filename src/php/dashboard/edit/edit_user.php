<?php

include('../../connections/connection.php');
include('../../connections/local_connection.php');

$message = '';
if(isset($_POST['uname'])){
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['uname'];
    $contact = $_POST['contact'];
    $dob = $_POST['dob'];
    $status = $_POST['status'];
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
        $sql="SELECT * FROM `users` WHERE `uname`='$uname' AND `id`!='$id'";
        $result = mysqli_query($local_conn_db, $sql);
        $asset_id = "";
        if($result->num_rows === 0){
            // Inserting data into database
            $sql="UPDATE `users` SET `fname`='$fname', `lname`='$lname', `uname`='$uname', `dob`='$dob', `contact`='$contact', `status`='$status' WHERE `id`='$id'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                echo "Updated Successfully...!";
            }
            else{
                echo "Error in inserting data...!";
            }   
        }
        else{
            echo "User already exists...!";
        }
    }
    else{
        echo "Database not found...!";
    }
}

?>