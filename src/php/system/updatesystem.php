<?php
    include("../connections/connection.php");
    $user_id = $_POST["user_id"];
    $system_id = $_POST["system_id"];
    $system_name = $_POST["system_name"];
    $sql="SELECT * FROM `systems` WHERE `user_id`='".$user_id."' AND `system_name`='".$system_name."'";
    $result = mysqli_query($conn, $sql);
    if($result->num_rows == 0){
        $sql="UPDATE `systems` SET `system_name`='$system_name' WHERE `id`='".$system_id."'";
        $result = mysqli_query($conn, $sql);
        if($result){ 
            echo "Updated Successfully...!";
        }  
        else{
            echo "Error in updating...!";
        }
    }
    else{
        echo "This system name is already existed...!";
    }
    
?>