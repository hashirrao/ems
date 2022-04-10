<?php
    include("../../connections/connection.php");
    include("../../connections/local_connection.php");
    $system_id = $_POST["system_id"];
    $user_id = $_POST["user_id"];
    $user_type = $_POST["user_type"];
    $search = $_POST["search"];
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
        if($user_type === "Developer"){
            $sql="SELECT * FROM `spec_options` WHERE `type`='entry' AND `name` LIKE '%$search%'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){ ?>
                    <li>
                      <a onclick="admin_entry_link_click('<?php echo $row['id']; ?>', '<?php echo $row['name']; ?>')" ondblclick="admin_entry_link_dbl_click('<?php echo $row['id']; ?>', '<?php echo $row['name']; ?>')"><?php echo $row["name"]; ?></a>
                    </li>
                <?php }
            }
            else{
                echo "<li>NO RESULTS</li>";
            }
        }
        else{
            $sql="SELECT * FROM `spec_options_users` WHERE `type`='entry' AND `user_id`='$user_id' AND `name` LIKE '%$search%'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){ ?>
                    <li>
                    <a onclick="admin_entry_link_click('<?php echo $row['spec_option_id']; ?>', '<?php echo $row['name']; ?>')" ondblclick="admin_entry_link_dbl_click('<?php echo $row['id']; ?>', '<?php echo $row['name']; ?>')"><?php echo $row["name"]; ?></a>
                    </li>
                <?php }  
            }
            else{
                echo "<li>NO RESULTS</li>";
            }
        }
    }
    else{
        echo "<li>Database not found...!</li>";
    }
?>