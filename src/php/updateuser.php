<?php
include('connections/connection.php');
$message = '';
if(isset($_POST['fname'])){
    
    $date = date("Y-m-d");
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $uname = $_POST['uname'];
    $phone = $_POST['phone'];


    $sql="SELECT * FROM `users` WHERE `username`='".$uname."' AND `id`!='$id'";
    $result = mysqli_query($conn, $sql);
    if($result->num_rows == 0){
        $sql="UPDATE `users` SET `fname`='$fname', `lname`='$lname', `username`='$uname',  `contact`='$phone', `updated`='$date' WHERE `Id`='$id'";
        $result = mysqli_query($conn, $sql);
        if($result == true){
            echo "User successfully updated...!";
        }else{
            echo "Error in updating user....!";
        }
    }
    else{
        echo "This user name is already taken...!";
    }    
}

?>