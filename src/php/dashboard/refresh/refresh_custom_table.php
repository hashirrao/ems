<?php
    include("../../connections/connection.php");
    include("../../connections/local_connection.php");
    $system_id = $_POST["system_id"];
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
        $sql="SELECT * FROM `spec_options` WHERE `type`='custom_table'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){ ?>
                <li>
                  <a onclick="list_custom_tables_link_click('<?php echo $row['id']; ?>')"><?php echo $row["name"]; ?></a>
                </li>
            <?php }  
        }
        else{
            echo "<li>NO RESULTS</li>";
        }
    }
    else{
        echo "<li>Database not found...!</li>";
    }
?>