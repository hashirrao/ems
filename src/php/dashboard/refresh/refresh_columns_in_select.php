<?php
    include("../../connections/connection.php");
    include("../../connections/local_connection.php");
    $system_id = $_POST["system_id"];
    $table_name = $_POST["table_name"];
    $inp_type = "";
    if(isset($_POST["inp_type"])){
        $inp_type = $_POST["inp_type"];
    }
    $field_type = "";
    if(isset($_POST["field_type"])){
        $field_type = $_POST["field_type"];
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
        $table_arr = explode("--", $table_name);
        for($i=0; $i<count($table_arr); $i++){
            $table_name = $table_arr[$i];
            if($field_type === "grouped"){
                $sql="SELECT * FROM `$table_name` WHERE `option_val_frm_othr_src`='True' AND `status`='Activate' ORDER BY `option_priority` ASC";
            }
            else if($inp_type === "number"){
                $sql="SELECT * FROM `$table_name` WHERE `option_type`='Input Number' OR `option_type`='Input Number With Point' AND `status`='Activate' ORDER BY `option_priority` ASC";
            }
            else{
                $sql="SELECT * FROM `$table_name` WHERE `status`='Activate' ORDER BY `option_priority` ASC";
            }
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                if($inp_type === "report"){ ?>
                    <option value='<?php echo 'id'; ?>'>
                        <?php echo "ID" ?>
                    </option>
                <?php }
                while($row = $result->fetch_assoc()){ 
                    if($field_type === "grouped"){ ?>
                        <option value='<?php echo $row['option_othr_src_table']."--".$row['option_othr_src_column']; ?>'>
                      <?php echo $row['option_name']; ?>
                    </option>
                    <?php }
                    else{ ?>
                    <option value='<?php echo 'opt_'.$row['id']; ?>'>
                      <?php echo $row['option_name']; ?>
                    </option>
                <?php }
                }
            }
            else{
                // echo "<option>NO RESULTS</option>";
            }
        }
    }
    else{
        echo "<option>Database not found...!</option>";
    }
?>