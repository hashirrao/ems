<?php

include('../../connections/connection.php');
include('../../connections/local_connection.php');

$message = '';
if(isset($_POST['uname'])){
    $user_id = $_POST['user_id'];
    $user_type = $_POST['user_type'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['uname'];
    $password = $_POST['password'];
    $contact = $_POST['contact'];
    $dob = $_POST['dob'];
    $system_id = $_POST['system_id'];
    $encpassword = md5($password, "h123f3");
    $created_by = $user_type."_".$user_id;
    if($user_type === "Developer"){
        $type = "Admin";
    }
    else{
        $type = "User";
    }
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
        $sql="SELECT * FROM `users` WHERE `uname`='$uname'";
        $result = mysqli_query($local_conn_db, $sql);
        $asset_id = "";
        if($result->num_rows === 0){
            // Inserting data into database
            $sql="INSERT INTO `users`(`fname`, `lname`, `uname`, `password`, `dob`, `contact`, `type`, `status`, `created_by`) 
                VALUES ('$fname','$lname','$uname','$encpassword', '$dob', '$contact', '$type', 'Activated', '$created_by')";
            $result = mysqli_query($local_conn_db, $sql);
            if($result){
                echo "Inserted Successfully...!";
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