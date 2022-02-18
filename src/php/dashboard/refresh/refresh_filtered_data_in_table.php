<?php
    include("../../connections/connection.php");
    include("../../connections/local_connection.php");
    $system_id = $_POST["system_id"];
    $table = $_POST["table"];
    $column_names = explode(",", $_POST["column_names"]);
    $column_values = explode(",", $_POST["column_values"]);
    $columns_arr = explode(",", $_POST["columns_arr"]);
    $selected_clm = $_POST["selected_clm"];
    $rows_limit = $_POST["rows_limit"];
    $type = $_POST["type"];
    $option_id = $_POST["option_id"];
    $user_id = $_POST["user_id"];
    $user_type = $_POST["user_type"];
    $user = $user_type."_".$user_id;
    $business = $_POST["business"];
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
        if (strpos($table, 'asset') !== false) {
            $sql = "SELECT * FROM ".$table."_values WHERE `added_for`='$business' AND ";
        }
        else{
            $sql = "SELECT * FROM ".$table."_values WHERE `entry_of`='$business' AND ";
        }
        if($user_type === "User"){
            $sql = $sql."`entry_by`='$user' AND";
        }
        for($i=0; $i < (count($column_names)-1); $i++){
            $sql2 = "SELECT ".$column_names[$i]." FROM ".$table."_values LIMIT 1";
            $result2 = mysqli_query($local_conn_db, $sql2);
            if($result2->num_rows > 0){
                while($row2 = $result2->fetch_assoc()){
                    $y = $row2[$column_names[$i]];
                }
            }
            $x = explode("--", $y);
            if(count($x) === 3){
                $sql1 = "SELECT * FROM `".$x[2]."_values` WHERE ".$x[0]." LIKE '%".$column_values[$i]."%'";
                $result1 = mysqli_query($local_conn_db, $sql1);
                if($result1->num_rows > 0){
                    $z = 1;
                    $val_for_filter = "";
                    while($row1 = $result1->fetch_assoc()){
                        if($z < $result1->num_rows){
                            $val_for_filter .= $column_names[$i]." LIKE '%".$x[0]."--".$row1["id"]."--".$x[2]."%' OR ";
                        }
                        else{
                            $val_for_filter .= $column_names[$i]." LIKE '%".$x[0]."--".$row1["id"]."--".$x[2]."%' ";
                        }
                        $z++;
                    }
                }
                else{
                    $val_for_filter = $column_names[$i]."='NULLLLLLLLLLLLLLLLLLLLLLLLL'";
                }
            }
            else{
                $val_for_filter = $column_names[$i]." LIKE '%".$column_values[$i]."%'";
            }
            $sql = $sql.$val_for_filter;
            if($i !== (count($column_names)-2)){
                $sql = $sql." AND ";
            }
        }
        $sql = $sql." LIMIT ".$rows_limit;
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){ 
                ?>
                <tr class='filtered_list_row'
                <?php
                $x = explode("--", $row[$selected_clm]);
                if(count($x) === 3){
                    $sql1 = "SELECT * FROM ".$x[2]."_values WHERE id=".$x[1];
                    $result1 = mysqli_query($local_conn_db, $sql1);
                    if($result1->num_rows > 0){
                        while($row1 = $result1->fetch_assoc()){
                            ?>onclick='filtered_list_row_click("<?php echo $row1[$x[0]]; ?>", "<?php echo $table; ?>", "<?php echo $type; ?>", "<?php echo $option_id; ?>")'<?php
                        }
                    }
                }
                else{
                    ?>onclick='filtered_list_row_click("<?php echo $row[$selected_clm]; ?>", "<?php echo $table; ?>", "<?php echo $type; ?>", "<?php echo $option_id; ?>", "<?php if(isset($row["entry_by"])){echo $row["entry_by"];} ?>")'<?php
                }
                ?>
                >
                <?php
                echo "<td>".$row["id"]."</td>";
                if(substr($table,0,5) === "entry"){
                    echo "<td>".$row["voucher_no"]."</td>";
                    echo "<td>".$row["entry_by"]."</td>";
                }
                for($i=0; $i < (count($columns_arr)); $i++){
                    $x = explode("--", $row[$columns_arr[$i]]);
                    if(count($x) === 3){
                        $sql1 = "SELECT * FROM ".$x[2]."_values WHERE id=".$x[1];
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $y = explode("--", $row1[$x[0]]);
                                if(count($y) === 2 ){
                                    echo "<td>".$y[1]."</td>";
                                }
                                else{
                                    echo "<td>".$row1[$x[0]]."</td>";
                                }
                            }
                        }
                    }
                    else{
                        $y = explode("--", $row[$columns_arr[$i]]);
                        if(count($y) === 2 ){
                            echo "<td>".$y[1]."</td>";
                        }
                        else{
                            echo "<td>".$row[$columns_arr[$i]]."</td>";
                        }
                    }
                }
                ?>
                </tr>
                <?php
            }
        }
        else{
            echo "<tr>NO RESULTS</tr>";
        }
    }
    else{
        echo "<tr>Database not found...!</tr>";
    }
?>