<?php

include('../connections/connection.php');
include('../connections/local_connection.php');

if(isset($_POST['uid'])){

  $date = date("Y-m-d");
  $uid = $_POST['uid'];
  $sname = $_POST['sname'];
  
    $sql="SELECT * FROM `systems` WHERE `user_id`='".$uid."' AND `system_name`='".$sname."'";
    $result = mysqli_query($conn, $sql);
    if($result->num_rows == 0){
      $sql="INSERT INTO `systems`(`user_id`, `system_name` , `status`) VALUES ('$uid','$sname','Activated')";
      $result = mysqli_query($conn, $sql);
        if($result == true){
          $system_id = "";
          $sql="SELECT * FROM `systems` WHERE `user_id`='".$uid."' AND `system_name`='".$sname."'";
          $result = mysqli_query($conn, $sql);
          if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){  
              $system_id = $row["id"];
              $dname = "DB_".$system_id;
            }
          }
          if($system_id !== ""){
            $sql="UPDATE `systems` SET `database_name`='$dname' WHERE `id`='$system_id'";
            $result = mysqli_query($conn, $sql);
            if($result){
              $sql = "CREATE DATABASE $dname";
              if ($local_conn1->query($sql) === TRUE) {
                $local_conn_db = mysqli_connect($server, $server_user, $server_pass, $dname);
                if($local_conn_db->connect_error){
                  die("Failed to connect with MySQL: " . $local_conn_db->connect_error);
                }
                $sql = "CREATE TABLE IF NOT EXISTS spec_options (
                  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `type` VARCHAR(100) NOT NULL,
                  `name` VARCHAR(100) NOT NULL,
                  reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                  ) ";
                  if ($local_conn_db->query($sql) === TRUE) {
                    $sql = "CREATE TABLE IF NOT EXISTS users (
                      id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                      `fname` VARCHAR(100) NOT NULL,
                      `lname` VARCHAR(100) NOT NULL,
                      `uname` VARCHAR(100) NOT NULL,
                      `password` VARCHAR(100) NOT NULL,
                      `dob` DATE,
                      `contact` VARCHAR(20),
                      `type` VARCHAR(30) NOT NULL,
                      `status` VARCHAR(15) NOT NULL,
                      `created_by` VARCHAR(100) NOT NULL,
                      reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                      ) ";
                      if ($local_conn_db->query($sql) === TRUE) {
                        $sql = "CREATE TABLE IF NOT EXISTS spec_options_users (
                          id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                          `type` VARCHAR(100) NOT NULL,
                          `name` VARCHAR(100) NOT NULL,
                          `spec_option_id` VARCHAR(11) NOT NULL,
                          `user_id` VARCHAR(11) NOT NULL,
                          reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                          ) ";
                          if ($local_conn_db->query($sql) === TRUE) {
                            $sql = "CREATE TABLE IF NOT EXISTS asset_1 (
                              id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                              `option_name` varchar(100) NOT NULL,
                              `option_type` varchar(100) NOT NULL,
                              `option_empty_check` varchar(10) NOT NULL,
                              `option_similarity_check` varchar(10) NOT NULL,
                              `option_texts` text,
                              `option_values` text,
                              `option_val_frm_othr_src` varchar(10) DEFAULT NULL,
                              `option_othr_src_table` varchar(100) DEFAULT NULL,
                              `option_othr_src_column` varchar(100) DEFAULT NULL,
                              `option_othr_src_column_value` varchar(100) DEFAULT NULL,
                              `option_whole_table_search` varchar(10) DEFAULT NULL,
                              `option_priority` int DEFAULT NULL,
                              `status` varchar(20) DEFAULT NULL,
                              `field_type` varchar(20) DEFAULT NULL,
                              `formula` varchar(255) DEFAULT NULL,
                              `editable` varchar(10) DEFAULT NULL,
                              `visible` varchar(10) DEFAULT NULL,
                              `table_visible` varchar(10) DEFAULT NULL,
                              `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                              )";
                              if ($local_conn_db->query($sql) === TRUE) {
                                $sql = "INSERT INTO `asset_1` VALUES (1,'Business Name','Input Text','True','True','','','False','','','','',1,'Activate','Normal','','','','','2020-05-12 17:16:37'),(2,'Address','Input Text','False','False','','','False','','','','',2,'Activate','Normal','','','','','2020-03-26 14:19:50'),(3,'Contact','Input Text','False','False','','','False','','','','',3,'Activate','Normal','','','','','2020-04-03 17:35:11'),(4,'Remarks','Input Text','False','False','','','False','','','','',4,'Activate','Normal','','','','','2020-03-26 14:08:30'),(5,'NTN No','Input Text','False','False','','','False','','','','',5,'Activate','Normal','','','','','2020-05-12 17:16:57');";
                                  if ($local_conn_db->query($sql) === TRUE) {
                                    
                                      $sql = "CREATE TABLE `asset_1_values` (
                                        `id` int unsigned NOT NULL AUTO_INCREMENT,
                                        `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                        `opt_1` varchar(255) DEFAULT NULL,
                                        `opt_2` varchar(255) DEFAULT NULL,
                                        `opt_3` varchar(255) DEFAULT NULL,
                                        `opt_4` varchar(255) DEFAULT NULL,
                                        `opt_5` varchar(255) DEFAULT NULL,
                                        PRIMARY KEY (`id`)
                                      )";
                                        if ($local_conn_db->query($sql) === TRUE) {
                                            $sql = "INSERT INTO `asset_1_values` VALUES (1,'2020-07-26 10:20:54','Main Business','','','','')";
                                              if ($local_conn_db->query($sql) === TRUE) {
                                                $sql = "INSERT INTO `spec_options` (`id`, `type`, `name`) VALUES ('1', 'asset', 'Business')";
                                                if ($local_conn_db->query($sql) === TRUE) {
                                                  echo "System successfully created...!";
                                                }  
                                                else{
                                                  echo "Error in creating database....!";
                                                }
                                              }  
                                              else{
                                                echo "Error in creating database....!";
                                              }
                                          
                                        }  
                                        else{
                                          echo "Error in creating database....!";
                                        }
                                     
                                  }  
                                  else{
                                    echo "Error in creating database....!";
                                  }
                              }  
                              else{
                                echo "Error in creating database....!";
                              }
                          }  
                          else{
                            echo "Error in creating database....!";
                          }
                      }  
                      else{
                        echo "Error in creating database....!";
                      }
                  }  
                  else{
                    echo "Error in creating database....!";
                  }
              }
              else{
                echo "Error in creating database....!";
              }
            }
          }
          else{
            echo "Error in creating system....!";
          }
      }    
    }
    else{
        echo "This system name is already existed...!";
    }  
}

?>