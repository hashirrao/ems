<?php
    include("../../connections/connection.php");
    include("../../connections/local_connection.php");
    $system_id = $_POST["system_id"];
    $current_user_id = $_POST["current_user_id"];
    $current_user_type = $_POST["current_user_type"];
    $user_id = $_POST["user_id"];
    $user_type = $_POST["user_type"];
    $database_name = "";
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
        if($current_user_type === "Developer"){
            echo '<table class="table dtHorizontalExampleWrapper" cellspacing="0" width="100%" id="users_authorities_table">';
            echo "<thead>";
            echo "<tr>";
            echo "<th>Panel</th>";
            echo "<th>Type</th>";
            echo "<th>Status</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            $sql = "SELECT * FROM `spec_options` WHERE `type`!='custom_table'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                $i=0;
                while($row = $result->fetch_assoc()){ 
                    echo "<tr>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['type']."</td>";
                    ?>
                    <td><button id='allow_notallow_btn_<?php echo $i; ?>' class='btn btn-default' onclick='user_option_allowed_fuction(
                    "<?php echo $row["name"]; ?>",
                    "<?php echo $row["type"]; ?>",
                    "<?php echo $row["id"]; ?>",
                    "<?php echo $user_id; ?>",
                    "<?php echo $user_type; ?>",
                    "<?php echo $i; ?>"
                    )'>
                    <?php    
                    $sql1 = "SELECT * FROM `spec_options_users` WHERE `spec_option_id`='".$row['id']."' AND `user_id`='$user_id'";
                    $result1 = mysqli_query($local_conn_db, $sql1);
                    if($result1->num_rows > 0){
                        echo "Allowed";
                    }
                    else{
                        echo "Not Allowed";
                    }
                    ?></button></td>
                    <?php
                    echo "</tr>";
                    $i++;
                }
            }
            else{
                echo "<tr>NO RESULTS</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        else{
            echo '<table class="table dtHorizontalExampleWrapper" cellspacing="0" width="100%" id="users_authorities_table">';
            echo "<thead>";
            echo "<tr>";
            echo "<th>Panel</th>";
            echo "<th>Type</th>";
            echo "<th>Status</th>";
            echo "</tr>";
            echo "</thead>";
            $sql = "SELECT * FROM `spec_options_users` WHERE `user_id`='$current_user_id'";
            $result = mysqli_query($local_conn_db, $sql);
            echo "<tbody>";
            if($result->num_rows > 0){
                $i=0;
                while($row = $result->fetch_assoc()){ 
                    echo "<tr>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['type']."</td>";
                    ?>
                    <td><button id='allow_notallow_btn_<?php echo $i; ?>' class='btn btn-default' onclick='user_option_allowed_fuction(
                    "<?php echo $row["name"]; ?>",
                    "<?php echo $row["type"]; ?>",
                    "<?php echo $row["spec_option_id"]; ?>",
                    "<?php echo $user_id; ?>",
                    "<?php echo $user_type; ?>",
                    "<?php echo $i; ?>"
                    )'>
                    <?php    
                    $sql1 = "SELECT * FROM `spec_options_users` WHERE `spec_option_id`='".$row['spec_option_id']."' AND `user_id`='$user_id'";
                    $result1 = mysqli_query($local_conn_db, $sql1);
                    if($result1->num_rows > 0){
                        echo "Allowed";
                    }
                    else{
                        echo "Not Allowed";
                    }
                    ?></button></td>
                    <?php
                    echo "</tr>";
                    $i++;
                }
            }
            else{
                echo "<tr>NO RESULTS</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
    }
    else{
        echo "<tr>Database not found...!</tr>";
    }
?>