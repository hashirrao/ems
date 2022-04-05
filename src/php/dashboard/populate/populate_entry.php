<?php

include('../../connections/connection.php');
include('../../connections/local_connection.php');

if(isset($_POST['voucher_no'])){
    $values = '';

    $voucher_no = $_POST['voucher_no'];
    $table = $_POST['table'];
    $system_id = $_POST['system_id'];
    $user = $_POST['added_by'];
    $database_name = "";
    // Getting Database
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
        $sql="SELECT * FROM `$table` WHERE `entry_type`='Single' AND `status`='Activate' ORDER BY `option_priority` ASC";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $table1 = $table."_values";
                $sql1="SELECT * FROM `$table1` WHERE `voucher_no`='$voucher_no' AND `added_by`='$user'";
                $result1 = mysqli_query($local_conn_db, $sql1);
                if($result1->num_rows > 0){
                    while($row1 = $result1->fetch_assoc()){
                        echo $row["option_name"]."-+-".$row1["opt_".$row["id"]]."-+-";
                    }
                }
            }
        }
        echo "--SM--";
        $table1 = $table."_values";
        $sql1="SELECT * FROM `$table1` WHERE `voucher_no`='$voucher_no' AND `added_by`='$user'";
        $result1 = mysqli_query($local_conn_db, $sql1);
        if($result1->num_rows > 0){
            $j = 0;
            while($row1 = $result1->fetch_assoc()){
                $sql="SELECT * FROM `$table` WHERE `entry_type`='Multiple' AND `status`='Activate' ORDER BY `option_priority` ASC";
                $result = mysqli_query($local_conn_db, $sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<td "; 
                        if($row["visible"] === "False"){
                            echo "class='d-none d-xs-none'";
                        }
                        echo ">";
                        echo "<label class='col-form-label col-form-label-sm red'>".$row["option_name"]."</label><br>";
                        if($row["option_type"] === "Select"){
                            if($values == ""){
                                $values = $row1["opt_".$row["id"]];
                            }
                            else{
                                $values = $values."-+-".$row1["opt_".$row["id"]];
                            }
                            echo "<select id='".$row["option_name"]."_".$j."' style=";
                            echo "'width: 100%;'";
                            echo "class='form-control form-control-sm table_inputs ".$row["option_name"]."s' ></select>";
                        }
                        else{
                            echo "<input autocomplete='off' id='".$row["option_name"]."_".$j."' style=";
                            echo "'width: 100%;'";
                            echo "class='form-control form-control-sm table_inputs ".$row["option_name"]."s' placeholder='".$row["option_name"]."'";
                            if($row["option_type"] === "Input Number" || $row["option_type"] === "Input Number With Point"){
                                if($row["visible"] === "False"){
                                    echo "type='hidden'";
                                }
                                else{
                                    echo "type='number'";
                                }
                            }
                            else if($row["option_type"] === "Input Text"){
                                if($row["visible"] === "False"){
                                    echo "type='hidden'";
                                }
                                else{
                                    echo "type='text'";
                                }
                            }
                            echo " value='".$row1["opt_".$row["id"]]."' ";
                            if($row["editable"] === "False"){
                                echo "readonly ";
                            }
                            echo "/>";
                            if($row["option_whole_table_search"] === "True"){
                                ?>
                                <div class="input-group-append">
                                <button id="<?php echo $row["option_name"]."_".$j; ?>_btn" class="input-group-text btn btn-success"><span class="fa fa-search"></span></button>
                                </div>
                                <?php
                            }
                        }
                        echo "</td>";
                    }
                }
                echo "--re--";
                $j++;
            }
        }
        echo "--SM--";
        $sql="SELECT * FROM `$table` WHERE `entry_type`='Multiple' AND `status`='Activate' ORDER BY `option_priority` ASC";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            $i=0;
            while($row = $result->fetch_assoc()){
                echo $row["option_name"];
                if(mysqli_num_rows($result)-1 > $i){
                    echo "-+-";
                }
                $i++;
            }
        }
        echo "--SM--";
        $sql="SELECT * FROM `$table` WHERE `entry_type`='Multiple' AND `status`='Activate' ORDER BY `option_priority` ASC";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            $i=0;
            while($row = $result->fetch_assoc()){
                echo $row["option_val_frm_othr_src"];
                if(mysqli_num_rows($result)-1 > $i){
                    echo "-+-";
                }
                $i++;
            }
        }
        echo "--SM--";
        $sql="SELECT * FROM `$table` WHERE `entry_type`='Multiple' AND `status`='Activate' ORDER BY `option_priority` ASC";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            $i=0;
            while($row = $result->fetch_assoc()){
                echo $row["option_othr_src_table"];
                if(mysqli_num_rows($result)-1 > $i){
                    echo "-+-";
                }
                $i++;
            }
        }
        echo "--SM--";
        $sql="SELECT * FROM `$table` WHERE `entry_type`='Multiple' AND `status`='Activate' ORDER BY `option_priority` ASC";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            $i=0;
            while($row = $result->fetch_assoc()){
                echo $row["option_othr_src_column"];
                if(mysqli_num_rows($result)-1 > $i){
                    echo "-+-";
                }
                $i++;
            }
        }
        echo "--SM--";
        $sql="SELECT * FROM `$table` WHERE `entry_type`='Multiple' AND `status`='Activate' ORDER BY `option_priority` ASC";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            $i=0;
            while($row = $result->fetch_assoc()){
                echo $row["option_othr_src_column_value"];
                if(mysqli_num_rows($result)-1 > $i){
                    echo "-+-";
                }
                $i++;
            }
        }
        echo "--SM--";
        $sql="SELECT * FROM `$table` WHERE `entry_type`='Multiple' AND `status`='Activate' ORDER BY `option_priority` ASC";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            $i=0;
            while($row = $result->fetch_assoc()){
                echo $row["formula"];
                if(mysqli_num_rows($result)-1 > $i){
                    echo "-+-";
                }
                $i++;
            }
        }
        echo "--SM--";
        $sql="SELECT * FROM `$table` WHERE `entry_type`='Multiple' AND `status`='Activate' ORDER BY `option_priority` ASC";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            $i=0;
            while($row = $result->fetch_assoc()){
                echo $row["field_type"];
                if(mysqli_num_rows($result)-1 > $i){
                    echo "-+-";
                }
                $i++;
            }
        }
        echo "--SM--";
        $sql="SELECT * FROM `$table` WHERE `entry_type`='Multiple' AND `status`='Activate' ORDER BY `option_priority` ASC";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            $i=0;
            while($row = $result->fetch_assoc()){
                echo $row["entry_sum"];
                if(mysqli_num_rows($result)-1 > $i){
                    echo "-+-";
                }
                $i++;
            }
        }
        echo "--SM--";
        $sql="SELECT * FROM `$table` WHERE `entry_type`='Multiple' AND `status`='Activate' ORDER BY `option_priority` ASC";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            $i=0;
            while($row = $result->fetch_assoc()){
                echo $row["option_whole_table_search"];
                if(mysqli_num_rows($result)-1 > $i){
                    echo "-+-";
                }
                $i++;
            }
        }
        echo "--SM--";
        $sql="SELECT * FROM `$table` WHERE `entry_type`='Multiple' AND `status`='Activate' ORDER BY `option_priority` ASC";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            $i=0;
            while($row = $result->fetch_assoc()){
                echo $row["option_type"];
                if(mysqli_num_rows($result)-1 > $i){
                    echo "-+-";
                }
                $i++;
            }
        }
        echo "--SM--";
        echo $values;
    }
}

?>