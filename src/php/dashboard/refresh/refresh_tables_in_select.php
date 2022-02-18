<?php
    include("../../connections/connection.php");
    include("../../connections/local_connection.php");
    $system_id = $_POST["system_id"];
    $tables_type = $_POST["tables_type"];
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
        if($tables_type === "custom_tables"){
            $sql="SELECT * FROM `spec_options` WHERE `type`='custom_table'";
        }
        else if($tables_type === "reports_tables"){
            $table = "report_".$report_id;
            $sql="SELECT * FROM `$table`";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                $sql="SELECT * FROM `$table`";
                $table_exist = true;
            }
            else{
                $sql="SELECT * FROM `spec_options` WHERE `type`='asset' OR `type`='entry' OR `type`='custom_tables'";
            }
        }
        else if($tables_type === "parameters_tables"){
            $sql="SELECT * FROM `spec_options` WHERE `type`='asset'";
        }
        else{
            $sql="SELECT * FROM `spec_options` WHERE `type`='asset' OR `type`='entry'";
        }
        if($table_exist){
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){ ?>
                    <option value='<?php echo $row['table']; ?>'>
                      <?php echo "Table Already Selected"; ?>
                    </option>
                <?php break; }
            }
            else{
                echo "<option>NO RESULTS</option>";
            }
        }
        else{
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){ ?>
                    <option value='<?php echo $row['type'].'_'.$row['id']; ?>'>
                      <?php echo $row['name']; 
                      if($tables_type === "reports_tables"){
                        echo ' "'.$row['type'].'"';
                      }?>
                    </option>
                <?php }
            }
            else{
                echo "<option>NO RESULTS</option>";
            }
        }
        
    }
    else{
        echo "<option>Database not found...!</option>";
    }
?>