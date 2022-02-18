<?php

$server = "localhost";
$server_user = "root";
$server_pass = "icanaccessroot";

$local_conn1 = mysqli_connect($server, $server_user, $server_pass);
if($local_conn1->connect_error){
  die("Failed to connect with MySQL: " . $local_conn1->connect_error);
}
?>