<?php

$conn = mysqli_connect("localhost", "root", "icanaccessroot", "ems");
if($conn->connect_error){
  die("Failed to connect with MySQL: " . $conn->connect_error);
}
?>