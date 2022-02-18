<?php
    include("../connections/connection.php");
    include("../connections/local_connection.php");
    $id = $_POST["system_id"];
    $system_name = $_POST["system_name"];
    $user_id = $_POST["user_id"];
    $sql1="SELECT * FROM `systems` WHERE `id`='$id'";
    $result1 = mysqli_query($conn, $sql1);
    if($result1->num_rows > 0){
        while($row = $result1->fetch_assoc()){
            $sql2 = "DROP DATABASE IF EXISTS ".$row['database_name'].";";
            $result = mysqli_query($local_conn1, $sql2);
            if($result){ 
                $sql="DELETE FROM `systems` WHERE `id`='$id'";
                $result = mysqli_query($conn, $sql);
                if($result){ 
                    echo "Deleted Successfully...!";
                }
                else{
                    echo "Error in deleting...!";
                }           
            }
            else{
                echo "Error in deleting...!";
            }    
        }
    }
    else{
        echo "Error in founding system...!";
    }    
?>