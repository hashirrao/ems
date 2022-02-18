<?php
    include("../../connections/connection.php");
    include("../../connections/local_connection.php");
    $system_id = $_POST["system_id"];
    $report_id = $_POST["report_id"];
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
        $table = "mt_report_".$report_id;
        echo $table;
        $sql="SELECT * FROM `$table` WHERE `formula`='parameter'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){ ?>
                <option value='<?php echo $row['table']; ?>'>
                  <?php echo $row['column_name']; ?>
                </option>
            <?php }
        }
        else{
            echo "<option>NO RESULTS</option>";
        }
    }
    else{
        echo "<option>Database not found...!</option>";
    }
?>