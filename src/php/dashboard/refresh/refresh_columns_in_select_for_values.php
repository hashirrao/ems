<?php
    include("../../connections/connection.php");
    include("../../connections/local_connection.php");
    $system_id = $_POST["system_id"];
    $table_name = $_POST["table_name"];
    $inp_type = "";
    if(isset($_POST["inp_type"])){
        $inp_type = $_POST["inp_type"];
    }
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
        if($inp_type === "number"){
            $sql="SELECT * FROM `$table_name` WHERE `option_type`='Input Number' ORDER BY `option_priority` ASC";
        }
        else{
            $sql="SELECT * FROM `$table_name` ORDER BY `option_priority` ASC";
        }
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            ?>
                <option value='<?php echo 'id'; ?>'>
                  <?php echo 'Auto ID'; ?>
                </option>
            <?php
            while($row = $result->fetch_assoc()){ ?>
                <option value='<?php echo 'opt_'.$row['id']; ?>'>
                  <?php echo $row['option_name']; ?>
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