<?php

include('../../connections/connection.php');
include('../../connections/local_connection.php');

if(!isset($_POST['entry_form']) && $_POST['option_type'] != "report"){
    $option_id = $_POST['option_id'];
    $option_type = $_POST['option_type'];
    // if($_POST["option_type"] === "asset"){
    //     $option_type = $_POST['option_type'];
    // }
    // else if($_POST['option_type'] === "edit_asset") {
    //     $option_type = "asset";
    //     $option_name = $_POST['option_name'];
    // }
    $system_id = $_POST['system_id'];
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
        $table = $option_type.'_'.$option_id;
        $sql="SELECT * FROM `$table`";
        $sql = $sql." ORDER BY `option_priority` ASC";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            // Fetching data from database
            echo '<table id="options_table" class="table dtHorizontalExampleWrapper" cellspacing="0" width="100%">';
            echo "<thead>";
            echo "<th>Name</th>";
            echo "<th>Type</th>";
            echo "<th>Empty Check</th>";
            echo "<th>Similarity Check</th>";
            // echo "<th>Texts</th>";
            // echo "<th>Values</th>";
            echo "<th>Other Source</th>";
            echo "<th>Status</th>";
            // echo "<th>Other Source Table</th>";
            // echo "<th>Other Source Column</th>";
            // echo "<th>Other Source Column Value</th>";
            echo "<th>Edit</th>";
            echo "</thead>";
            echo "<tbody>";
            $j = 0;
            while($row = $result->fetch_assoc()){
                
                    echo "<tr>";
                    echo "<td>".$row["option_name"]."</td>";
                    echo "<td>".$row["option_type"]."</td>";
                    echo "<td>".$row["option_empty_check"]."</td>";
                    echo "<td>".$row["option_similarity_check"]."</td>";
                    // echo "<td>".$row["option_texts"]."</td>";
                    // echo "<td>".$row["option_values"]."</td>";
                    echo "<td>".$row["option_val_frm_othr_src"]."</td>";
                    echo "<td>".$row["status"]."</td>";
                    // echo "<td>".$row["option_othr_src_table"]."</td>";
                    // echo "<td>".$row["option_othr_src_column"]."</td>";
                    // echo "<td>".$row["option_othr_src_column_value"]."</td>";
                    ?><td>
                    <button class="btn btn-warning btn-sm" onclick="settings_sub_option(
                    '<?php echo $row['id']; ?>', 
                    '<?php echo $row['option_name']; ?>', 
                    '<?php echo $row['option_type']; ?>', 
                    '<?php echo $row['option_empty_check']; ?>', 
                    '<?php echo $row['option_similarity_check']; ?>', 
                    '<?php echo $row['option_texts']; ?>', 
                    '<?php echo $row['option_values']; ?>',
                    '<?php echo $row['option_val_frm_othr_src']; ?>',
                    '<?php echo $row['option_othr_src_table']; ?>', 
                    '<?php echo $row['option_othr_src_column']; ?>', 
                    '<?php echo $row['option_othr_src_column_value']; ?>', 
                    '<?php echo $row['option_whole_table_search']; ?>', 
                    '<?php echo $row['option_priority']; ?>',
                    '<?php if(isset($row['entry_type'])) echo $row['entry_type']; ?>',
                    '<?php if(isset($row['entry_sum'])) echo $row['entry_sum']; ?>',
                    '<?php if(isset($row['custom_storage']))echo $row['custom_storage']; ?>',
                    '<?php if(isset($row['status']))echo $row['status']; ?>',
                    '<?php if(isset($row['field_type']))echo $row['field_type']; ?>',
                    '<?php if(isset($row['formula']))echo $row['formula']; ?>',
                    '<?php if(isset($row['editable']))echo $row['editable']; ?>',
                    '<?php if(isset($row['visible']))echo $row['visible']; ?>',
                    '<?php if(isset($row['table_visible']))echo $row['table_visible']; ?>'
                    )">
                        <span class="fa fa-pencil"></span>
                    </button>
                    </td><?php
                    echo "</tr>";
                    // echo '<div class="autocomplete"></div>';
                
                $j++;
            }
            echo "</tbody>";
            echo "</table>";
        }
    }
    else{
        echo "Database not found...!";
    }
}
else{
    if($_POST['option_type'] === "asset" || $_POST['option_type'] === "edit_asset"){
        $option_id = $_POST['option_id'];
        if($_POST["option_type"] === "asset"){
            $option_type = $_POST['option_type'];
        }
        else if($_POST['option_type'] === "edit_asset") {
            $option_type = "asset";
            $option_name = $_POST['option_name'];
        }
        $system_id = $_POST['system_id'];
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
            $table = $option_type.'_'.$option_id;
            $sql="SELECT * FROM `$table`";
            // if(isset($_POST['entry_form'])){
                $sql = $sql." WHERE `status`='Activate'";
            // }
            $sql = $sql." ORDER BY `option_priority` ASC";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                // Fetching data from database
                echo "<div class='container'>";
                if($_POST['option_type'] === "edit_asset") {
                    echo "<input type='hidden' id='value_id'>";
                }
                $j = 0;
                echo "<div class='row'>";
                while($row = $result->fetch_assoc()){
                    // echo '<div class="col-md-6 col-sm-12">';
                    print_options($row, isset($_POST['entry_form']), $option_id, $j, $local_conn_db, false, false);
                    // echo '</div>';
                    // echo '<div class="autocomplete"></div>';
                    $j++;
                }
                echo "</div>";
                if(isset($_POST['entry_form'])){
                    echo '<input id="e_option_id" type="hidden" value="'.$option_id.'" >';
                    echo '<input id="e_single_form_length" type="hidden" value="'.$j.'" >';
                }
                // if(isset($_POST['entry_form'])){
                    if($_POST['option_type'] === "asset"){
                        if(isset($row['option_name']))echo $row['option_name'];
                        echo '<button style="float: right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="add_values_asset_save_btn_click('.$option_id.', '.$j.')"><span class="fa fa-save"> </span> Save</button>';
                        ?><!-- <button class="btn btn-danger" onclick="add_values_asset_cancel_btn_click('<?php //echo $option_id; ?>', '<?php //echo $row['option_name']; ?>')"><span class="fa fa-times"> </span> Cancel</button> --><?php
                    }
                    else if($_POST['option_type'] === "edit_asset"){
                        ?><button style="float: right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="edit_values_asset_save_btn_click('<?php echo $option_id; ?>', '<?php echo $j; ?>', '<?php echo $option_name; ?>')"><span class="fa fa-save"> </span> Save</button><?php
                        ?><button class="btn btn-sm btn-danger" onclick="edit_values_asset_cancel_btn_click('<?php echo $option_id; ?>')"><span class="fa fa-times"> </span> Cancel</button><?php
                    }
                // }
                echo "</div>";
            }
        }
        else{
            echo "Database not found...!";
        }
    }
    
    else if($_POST['option_type'] === "list"){
        $option_id = $_POST['option_id'];
        $option_name = $_POST['option_name'];
        $option_type = $_POST['option_type'];
        $system_id = $_POST['system_id'];
        $business = $_POST['business'];
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
            // Checking duplication
            $table = 'asset_'.$option_id;
            $sql="SELECT * FROM `$table`";
            if(isset($_POST['entry_form'])){
                $sql = $sql." WHERE `status`='Activate'";
            }
            $sql = $sql." ORDER BY `option_priority` ASC";
            $result = mysqli_query($local_conn_db, $sql);
            $sql_columns = array();
            if($result->num_rows > 0){
                // Fetching data from database
                ?>
                <table id="list_table" class="table dtHorizontalExampleWrapper" cellspacing="0"
                width="100%">
                <thead>
                <tr>
                    <?php
                    //echo '<th scope="col" width="200px" data-visible="false">ID</th>';
                    echo '<th scope="col" width="200px">Reg Date Time</th>';
                    while($row = $result->fetch_assoc()){
                        array_push($sql_columns, "opt_".$row["id"]);
                        echo '<th scope="col" width="200px">'.$row['option_name'].'</th>';
                    }
                    echo '<th>Edit</th>';
                    ?>
                </tr>
                </thead>
                <?php
            }
            if($sql_columns !== null){
                ?>
                <tbody>
                <?php
                    $values_table = $table."_values";
                    if($values_table === "asset_1_values"){
                        $sql = "SELECT * FROM ".$values_table;
                    }
                    else{
                        $sql = "SELECT * FROM ".$values_table." WHERE `added_for`='$business'";
                    }
                    $result = mysqli_query($local_conn_db, $sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            echo '<tr>';
                            //echo '<td width="200px">'.$row["id"].'</td>';
                            echo '<td width="200px">'.$row["reg_date"].'</td>';
                            $arr = "";
                            for($i=0; $i<count($sql_columns); $i++){
                                if($i === 0){
                                    $arr = $arr . $row[$sql_columns[$i]];
                                }
                                else{
                                    $arr = $arr . "," . $row[$sql_columns[$i]];
                                }
                                $x = explode("--", $row[$sql_columns[$i]]);
                                if(count($x) === 3){
                                    $sql1 = "SELECT * FROM ".$x[2]."_values WHERE id=".$x[1];
                                    $result1 = mysqli_query($local_conn_db, $sql1);
                                    if($result1->num_rows > 0){
                                        while($row1 = $result1->fetch_assoc()){
                                            echo '<td width="200px">'.$row1[$x[0]].'</td>';
                                        }
                                    }
                                }
                                else{
                                    echo '<td width="200px">'.$row[$sql_columns[$i]].'</td>';
                                }
                                
                            }
                            ?><td width="30px"><button class="btn btn-sm btn-warning" onclick="edit_asset_value_btn_click('<?php echo $option_id ?>', '<?php echo $option_name ?>', '<?php echo $arr ?>', '<?php echo $i ?>', '<?php echo $row['id'] ?>')"><span class="fa fa-pencil"></button></td>
                            </tr><?php
                        }
                    }
                ?>
                </tbody>
                </table>
                <?php
            }
        }
        else{
            echo "Database not found...!";
        }
    }
    
    else if($_POST['option_type'] === "entry"){
        $option_id = $_POST['option_id'];
        if($_POST["option_type"] === "entry"){
            $option_type = $_POST['option_type'];
        }
        $system_id = $_POST['system_id'];
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
            $table = $option_type.'_'.$option_id;
            if($option_id === "5"){
                ?><button style='float: right;' class='btn btn-default' onclick='fetch_order_btn_click("42", "Purchase Order")'><span class="fa fa-shopping-cart"> </span> Fetch Order</button><?php
            }
            $sql="SELECT * FROM `$table` WHERE `entry_type`='Single'";
            if(isset($_POST['entry_form'])){
                $sql = $sql." AND `status`='Activate'";
                echo '<input id="e_voucher_no" type="hidden">';
            }
            $sql = $sql." ORDER BY `option_priority` ASC";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                // Fetching data from database
                echo "<div class='container' style='margin-bottom: 5px;'>";
                echo "<div class='row'>";
                $j = 0;
                while($row = $result->fetch_assoc()){
                    print_options($row, isset($_POST['entry_form']), $option_id, $j, $local_conn_db, false, true);
                    $j++;
                }
                if(isset($_POST['entry_form'])){
                    echo '<input id="e_option_id" type="hidden" value="'.$option_id.'" >';
                    echo '<input id="e_single_form_length" type="hidden" value="'.$j.'" >';
                }
                echo "</div>";
                echo "</div>";
            }
                // echo "<div class='col-sm-12' style='max-height: calc(100vh - 450px); overflow: auto;'>";
                $j = 0;
                $names = "";
                $types = "";
                $empty_check = "";
                $similarity_check = "";
                $opt_texts = "";
                $opt_values = "";
                $val_frm_othr_src = "";
                $othr_src_tbl = "";
                $othr_src_clm = "";
                $othr_src_clm_val = "";
                $whole_tbl_srch = "";
                $entry_sum = "";
                $custom_storage = "";
                $field_type = "";
                $formula = "";
                $editable = "";
                $visible = "";
                $table_visible = "";
                ?>
                <table id="entries_table" class="table">
                    <thead id="entries_table_head">
                        <tr><?php
                        $table = $option_type.'_'.$option_id;
                        $sql="SELECT * FROM `$table` WHERE `entry_type`='Multiple' AND `status`='Activate' ORDER BY `option_priority` ASC";
                        $result = mysqli_query($local_conn_db, $sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                
                                if(!isset($_POST['entry_form'])){
                                    echo "<div class='container' style='margin-bottom: 5px;'>";
                                    echo "<div class='row'>";
                                    print_options($row, isset($_POST['entry_form']), $option_id, $j, $local_conn_db, false, true);    
                                    echo "</div>";
                                    echo "</div>";
                                }
                                if($row["visible"] !== "False"){
                                    echo "<th scope='col'>";
                                    echo $row["option_name"];
                                    echo "</th>";
                                }
                                else{
                                    echo "<th scope='col' class='d-none d-xs-none'>";
                                    echo $row["option_name"];
                                    echo "</th>";
                                }
                                if($j === 0){
                                    $names = $row["option_name"];
                                    $types = $row["option_type"];
                                    $empty_check = $row["option_empty_check"];
                                    $similarity_check = $row["option_similarity_check"];
                                    $opt_texts = $row["option_texts"];
                                    $opt_values = $row["option_values"];
                                    $val_frm_othr_src = $row["option_val_frm_othr_src"];
                                    $othr_src_tbl = $row["option_othr_src_table"];
                                    $othr_src_clm = $row["option_othr_src_column"];
                                    $othr_src_clm_val = $row["option_othr_src_column_value"];
                                    $whole_tbl_srch = $row["option_whole_table_search"];
                                    $entry_sum = $row["entry_sum"];
                                    $custom_storage = $row["custom_storage"];
                                    $field_type = $row["field_type"];
                                    $formula = $row["formula"];
                                    $editable = $row["editable"];
                                    $visible = $row["visible"];
                                    $table_visible = $row["table_visible"];
                                }
                                else{
                                    $names = $names.",,".$row["option_name"];
                                    $types = $types.",,".$row["option_type"];
                                    $empty_check = $empty_check.",,".$row["option_empty_check"];
                                    $similarity_check = $similarity_check.",,".$row["option_similarity_check"];
                                    $opt_texts = $opt_texts.",,".$row["option_texts"];
                                    $opt_values = $opt_values.",,".$row["option_values"];
                                    $val_frm_othr_src = $val_frm_othr_src.",,".$row["option_val_frm_othr_src"];
                                    $othr_src_tbl = $othr_src_tbl.",,".$row["option_othr_src_table"];
                                    $othr_src_clm = $othr_src_clm.",,".$row["option_othr_src_column"];
                                    $othr_src_clm_val = $othr_src_clm_val.",,".$row["option_othr_src_column_value"];
                                    $whole_tbl_srch = $whole_tbl_srch.",,".$row["option_whole_table_search"];
                                    $entry_sum = $entry_sum.",,".$row["entry_sum"];
                                    $custom_storage = $custom_storage.",,".$row["custom_storage"];
                                    $field_type = $field_type.",,".$row["field_type"];
                                    $formula = $formula.",,".$row["formula"];
                                    $editable = $editable.",,".$row["editable"];
                                    $visible = $visible.",,".$row["visible"];
                                    $table_visible = $table_visible.",,".$row["table_visible"];
                                }
                                $j++;
                            }
                        }
                        ?></tr>
                    </thead>
                    <tbody id="entries_table_body">
                        
                    </tbody>
                </table>
                <?php
                if(isset($_POST['entry_form'])){
                    if($_POST['option_type'] === "entry"){
                        ?><button id="entry_add_to_table_btn" style="float: right; margin: 0 0 8px 14px; height: 38px" class="btn btn-success" onclick="entry_add_to_table_btn_click(
                        '<?php echo $option_id; ?>',
                        '<?php echo $names; ?>',
                        '<?php echo $types; ?>',
                        '<?php echo $empty_check; ?>',
                        '<?php echo $similarity_check; ?>',
                        '<?php echo $opt_texts; ?>',
                        '<?php echo $opt_values; ?>',
                        '<?php echo $val_frm_othr_src; ?>',
                        '<?php echo $othr_src_tbl; ?>',
                        '<?php echo $othr_src_clm; ?>',
                        '<?php echo $othr_src_clm_val; ?>',
                        '<?php echo $whole_tbl_srch; ?>',
                        '<?php echo $entry_sum; ?>',
                        '<?php echo $custom_storage; ?>',
                        '<?php echo $field_type; ?>',
                        '<?php echo $formula; ?>',
                        '<?php echo $editable; ?>',
                        '<?php echo $visible; ?>',
                        '<?php echo $table_visible; ?>'
                        )"><span class="fa fa-plus"></span> (Add Row)</button><?php
                    }
                }
                ?>
                <br>
                <table style="width: 100%; border-top: 2px solid rgb(161, 163, 168); border-bottom: 2px solid rgb(161, 163, 168);">
                    <tbody id='sum_tbl_bdy'></tbody>
                </table>
                <br>
                <?php
                // echo "</div>";
            
        }
        else{
            echo "Database not found...!";
        }
    }
    
    else if($_POST['option_type'] === "report"){
        $option_id = $_POST['option_id'];
        $option_type = $_POST['option_type'];
        $system_id = $_POST['system_id'];
        $business = "";
        if(isset($_POST['business'])){
            $business = $_POST['business'];
        }
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
            $sql="SELECT * FROM `spec_options` WHERE `id`='$option_id'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $option_type = $row["type"];
                }
            }
            $table = $option_type.'_'.$option_id;
            $sql="SELECT * FROM `$table` ORDER BY `option_priority` ASC";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                // Fetching data from database
                if(isset($_POST['entry_form'])){
                    $option_name = $_POST['option_name'];
                    echo "<form method='POST' action='./dashboard/report/report.php' target='_blank'>";
                    echo "<input type='hidden' name='system_id' value='".$system_id."'>";
                    echo "<input type='hidden' name='option_id' value='".$option_id."'>";
                    echo "<input type='hidden' name='option_name' value='".$option_name."'>";
                    echo "<input type='hidden' name='option_type' value='".$option_type."'>";
                    echo "<input type='hidden' name='business' value='".$business."'>";
                }
                echo "<div class='container'>";
                $j = 0;
                while($row = $result->fetch_assoc()){
                    if($row["is_filter"] === "True"){
                        echo "<div class='row'>";
                        if(isset($_POST['entry_form'])){
                            echo "<div class='col-sm-12'>";
                        }
                        else{
                            echo "<div class='col-sm-11'>";
                        }
                        echo "<div class='input-group mb-3'>";
                        if($row["column_type"] === "Text"){
                            echo "<div class='input-group-prepend'>";
                            echo "<strong id='".$option_id."_label_".$j."' class='input-group-text'>".$row["column_name"]."</strong>";
                            echo "</div>"; 
                            if($row["column_name"] === "Party" && $option_id === "41" && $option_type === "report"){
                                ?> <input autocomplete="off" type='text' id='<?php echo $row["column_name"]; ?>' name='<?php echo $row["column_name"]; ?>' class='form-control' placeholder='<?php echo $row["column_name"] ?>' aria-describedby='basic-addon1' 
                                onfocus='autocomplete_with_db("<?php echo $row["column_name"]; ?>", "<?php echo "True"; ?>", "<?php echo $row["table"]; ?>", "<?php echo $row["column"]; ?>" )' required> <?php
                            }
                            else if($row["column_name"] === "Account" && $option_id === "55" && $option_type === "report"){
                                ?> <input autocomplete="off" type='text' id='<?php echo $row["column_name"]; ?>' name='<?php echo $row["column_name"]; ?>' class='form-control' placeholder='<?php echo $row["column_name"] ?>' aria-describedby='basic-addon1' 
                                onfocus='autocomplete_with_db("<?php echo $row["column_name"]; ?>", "<?php echo "True"; ?>", "<?php echo $row["against_table"]; ?>", "<?php echo $row["against_column"]; ?>" )' required> <?php
                            }
                            else{
                                ?> <input autocomplete="off" type='text' id='<?php echo $row["column_name"]; ?>' name='<?php echo $row["column_name"]; ?>' class='form-control' placeholder='<?php echo $row["column_name"] ?>' aria-describedby='basic-addon1' > <?php
                            }
                        }
                        else if($row["column_type"] === "Number"){
                            echo "<div class='input-group-prepend'>";
                            echo "<strong id='".$option_id."_label_".$j."' class='input-group-text'>".$row["column_name"]."</strong>";
                            echo "</div>"; 
                            ?> <input autocomplete="off" type='number' id='<?php echo $row["column_name"]; ?>' name='<?php echo $row["column_name"]; ?>' class='form-control' placeholder='<?php echo $row["column_name"] ?>' aria-describedby='basic-addon1' > <?php
                        }
                        else if($row["column_type"] === "Date"){
                            echo "<div class='input-group-prepend'>";
                            echo "<strong id='".$option_id."_label_".$j++."' class='input-group-text'>".$row["column_name"]."</strong>";
                            echo "</div>";
                            echo "<input type='date' id='".$row["column_name"]."' name='".$row["column_name"]."' class='form-control' aria-describedby='basic-addon1' required>";    
                            echo "<div class='input-group-prepend'>";
                            echo "<strong id='".$option_id."_label_".$j."' class='input-group-text'>To</strong>";
                            echo "</div>";
                            echo "<input type='date' id='To' name='To' class='form-control' aria-describedby='basic-addon1' required>";
                        }
                        echo "</div>";
                        echo "</div>";
                        if(!isset($_POST["entry_form"])){
                            ?><div class='col-sm-1'>
                            <button class="btn btn-default" onclick="settings_report_sub_option(
                            '<?php echo $row['id']; ?>', 
                            '<?php echo $row['table']; ?>', 
                            '<?php echo $row['column_name']; ?>', 
                            '<?php echo $row['column']; ?>', 
                            '<?php echo $row['column_type']; ?>', 
                            '<?php echo $row['option_priority']; ?>'
                            )">
                                <span class="fa fa-gear"></span>
                            </button>
                            </div><?php
                        }
                        $j++;
                        echo "</div>";
                        echo '<div class="autocomplete"></div>';    
                    }
                }
                if(isset($_POST['entry_form'])){
                    echo '<button type="submit" style="float: right; margin-left: 5px;" class="btn btn-success" ><span class="fa fa-file"> </span> Report</button>';
                }
                echo "</div>";
                if(isset($_POST['entry_form'])){
                    echo "<input type='hidden' name='form_length' value='".$j."'>";
                    echo "</form>";
                }
            }
        }
        else{
            echo "Database not found...!";
        }
    }
    
    else if($_POST['option_type'] === "custom_table"){
        $option_id = $_POST['option_id'];
        $system_id = $_POST['system_id'];
        $option_type = $_POST['option_type'];
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
            $table = $option_type.'_'.$option_id;
            $sql="SELECT * FROM `$table`";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                // Fetching data from database
                echo "<div class='container'>";
                echo "<div class='row'>";
                echo "<div class='col-sm-5'>";
                echo "<strong style='text-decoration: underline;'>Column Name</strong>";
                echo "</div>";
                echo "<div class='col-sm-5'>";
                echo "<strong style='text-decoration: underline;'>Column Type</strong>";
                echo "</div>";
                echo "</div>";
                while($row = $result->fetch_assoc()){
                    echo "<div class='row'>";
                    echo "<div class='col-sm-5'>";
                    echo $row["option_name"];
                    echo "</div>";
                    echo "<div class='col-sm-5'>";
                    echo $row["option_type"];
                    echo "</div>";
                    echo "<div class='col-sm-2'>"; 
                    ?>
                    <button class="btn btn-default" onclick="settings_sub_option('<?php echo $row['id']; ?>', '<?php echo $row['option_name']; ?>', '<?php echo $row['option_type']; ?>', '', '', '', '','','', '', '', '', '<?php echo $row['option_priority']; ?>')">
                        <span class="fa fa-gear"></span>
                    </button>
                    <?php
                    echo "</div>";
                    echo "</div>";
                }
            }
            
        }
        else{
            echo "Database not found...!";
        }
    }
}

function print_options($row, $post, $option_id, $j, $local_conn_db, $row_allow, $is_single)
{
    // if($row_allow){
    //     echo "<div class='row'>";
    // }
    if($post){
        if($row["visible"] === "False"){
            if($is_single){
                echo "<div class='col-sm-4' style='visibility: hidden; position: absolute;'>";
            }
            else{
                echo "<div class='col-sm-6' style='visibility: hidden; position: absolute;'>";
            }
        }
        else{
            if($is_single){
                echo "<div class='col-sm-4'>"; 
            }
            else{
                echo "<div class='col-sm-6'>";    
            }
        }
    }
    else{
        if($row_allow){
            if($row["visible"] === "False"){
                echo "<div class='col-sm-10' style='visibility: hidden;'>";
            }
            else{
                echo "<div class='col-sm-10'>";
            }
        }
        else{
            if($row["visible"] === "False" && $post){
                echo "<div class='col-sm-10' style='visibility: hidden;'>";
            }
            else{
                echo "<div class='col-sm-11'>";
            }
        }
    }
    echo "<div class='form-group'>";
    if($row["option_type"] !== "Check Box"){
        // echo "<div class='input-group-prepend'>";
        if($row_allow){
            echo "<label id='".$option_id."_label_".$j."_multiple' class='col-form-label col-form-label-sm red'>".$row["option_name"]."</label>";
        }
        else{
            echo "<label id='".$option_id."_label_".$j."' class='col-form-label col-form-label-sm red'>".$row["option_name"]."</label>";
        }
        // echo "</div>";
    } 
    if($row["option_type"] === "Input Text"){
        if($row['field_type'] === 'Grouped'){
            ?> <input autocomplete="off" type='<?php if($row["visible"] === "False"){ echo "hidden"; }else{ echo "text"; } ?>' id='<?php echo $row["option_name"]; ?>' name='<?php echo $row["option_name"]; ?>' class='form-control form-control-sm' placeholder='<?php echo $row["option_name"] ?>' aria-describedby='basic-addon1' onfocus='autocomplete_with_db("<?php echo $row["option_name"]; ?>", "<?php echo $row["option_val_frm_othr_src"]; ?>", "<?php echo $row["option_othr_src_table"]; ?>", "<?php echo $row["option_othr_src_column"]; ?>" )' <?php if($row["editable"] === "False"){ echo "readonly"; } ?> onfocusin="fetch_value('<?php echo $row['option_othr_src_table']; ?>', '<?php echo $row['option_othr_src_column']; ?>', '<?php echo $row['option_othr_src_column_value']; ?>', '<?php echo $row['option_name']; ?>', '<?php echo $row['formula']; ?>')"
             onclick="fetch_value('<?php echo $row['option_othr_src_table']; ?>', '<?php echo $row['option_othr_src_column']; ?>', '<?php echo $row['option_othr_src_column_value']; ?>', '<?php echo $row['option_name']; ?>', '<?php echo $row['formula']; ?>')"> <?php
        }
        else{
            ?> <input autocomplete="off" type='<?php if($row["visible"] === "False"){ echo "hidden"; }else{ echo "text"; } ?>' id='<?php echo $row["option_name"]; ?>' name='<?php echo $row["option_name"]; ?>' class='form-control form-control-sm' placeholder='<?php echo $row["option_name"] ?>' aria-describedby='basic-addon1' onfocus='autocomplete_with_db("<?php echo $row["option_name"]; ?>", "<?php echo $row["option_val_frm_othr_src"]; ?>", "<?php echo $row["option_othr_src_table"]; ?>", "<?php echo $row["option_othr_src_column"]; ?>" )' onfocusout="inp_onclicks()"> <?php
        }
    }
    else if($row["option_type"] === "Input Number" || $row["option_type"] === "Input Number With Point"){
        if($row['field_type'] === 'Grouped'){
            ?> <input autocomplete="off" type='<?php if($row["visible"] === "False"){ echo "hidden"; }else{ echo "number"; } ?>' id='<?php echo $row["option_name"]; ?>' name='<?php echo $row["option_name"]; ?>' class='form-control form-control-sm' placeholder='<?php echo $row["option_name"] ?>' aria-describedby='basic-addon1' onfocus='autocomplete_with_db("<?php echo $row["option_name"]; ?>", "<?php echo $row["option_val_frm_othr_src"]; ?>", "<?php echo $row["option_othr_src_table"]; ?>", "<?php echo $row["option_othr_src_column"]; ?>" )' <?php if($row["editable"] === "False"){ echo "readonly"; } ?> onfocusin="fetch_value('<?php echo $row['option_othr_src_table']; ?>', '<?php echo $row['option_othr_src_column']; ?>', '<?php echo $row['option_othr_src_column_value']; ?>', '<?php echo $row['option_name']; ?>', '<?php echo $row['formula']; ?>')" 
            onclick="fetch_value('<?php echo $row['option_othr_src_table']; ?>', '<?php echo $row['option_othr_src_column']; ?>', '<?php echo $row['option_othr_src_column_value']; ?>', '<?php echo $row['option_name']; ?>', '<?php echo $row['formula']; ?>')" > <?php
        }
        else if($row['field_type'] === 'Formulated'){
            ?> <input autocomplete="off" type='<?php if($row["visible"] === "False"){ echo "hidden"; }else{ echo "number"; } ?>' id='<?php echo $row["option_name"]; ?>' name='<?php echo $row["option_name"]; ?>' class='form-control form-control-sm' placeholder='<?php echo $row["option_name"] ?>' aria-describedby='basic-addon1' onfocus='autocomplete_with_db("<?php echo $row["option_name"]; ?>", "<?php echo $row["option_val_frm_othr_src"]; ?>", "<?php echo $row["option_othr_src_table"]; ?>", "<?php echo $row["option_othr_src_column"]; ?>" )' <?php if($row["editable"] === "False"){ echo "readonly"; } ?> onfocusin="run_formula('<?php echo $row['formula']; ?>', '<?php echo $row['option_name']; ?>')" onclick="run_formula('<?php echo $row['formula']; ?>', '<?php echo $row['option_name']; ?>')" > <?php
        }
        else{
            ?> <input autocomplete="off" type='<?php if($row["visible"] === "False"){ echo "hidden"; }else{ echo "number"; } ?>' id='<?php echo $row["option_name"]; ?>' name='<?php echo $row["option_name"]; ?>' class='form-control form-control-sm' placeholder='<?php echo $row["option_name"] ?>' aria-describedby='basic-addon1'  onfocus='autocomplete_with_db("<?php echo $row["option_name"]; ?>", "<?php echo $row["option_val_frm_othr_src"]; ?>", "<?php echo $row["option_othr_src_table"]; ?>", "<?php echo $row["option_othr_src_column"]; ?>" )' <?php if($row["editable"] === "False"){ echo "readonly"; } ?> onfocusout="inp_onclicks()"> <?php
        }
    }
    else if($row["option_type"] === "Input Date"){
        echo "<input type='date' id='".$row["option_name"]."' name='".$row["option_name"]."' class='form-control form-control-sm'>";
    }
    else if($row["option_type"] === "Select"){
        echo "<select id='".$row["option_name"]."' name='".$row["option_name"]."' class='form-control form-control-sm  border-1 small select2-single'>";
            $opt_texts = explode(",", $row["option_texts"]);
            $opt_values = explode(",", $row["option_values"]);
            if($opt_texts[0] != ""){
                for($i = 0; $i < count($opt_texts); $i++){
                    echo "<option value=".$opt_values[$i].">".$opt_texts[$i]."</option>";
                }
            }
            if($row["option_val_frm_othr_src"] === "True"){
                $sql1="SELECT * FROM ".$row["option_othr_src_table"]."_values";
                $result1 = mysqli_query($local_conn_db, $sql1);
                if($result1->num_rows > 0){
                    while($row1 = $result1->fetch_assoc()){ 
                        if($row["option_othr_src_column_value"] === "id"){
                            // echo "<option value='".$row["option_othr_src_column"].'--'.$row1[$row["option_othr_src_column_value"]].'--'.$row["option_othr_src_table"]."'>".$row1[$row["option_othr_src_column"]]."</option>"; 
                            echo "<option value='".$row1["id"]."'>".$row1[$row["option_othr_src_column"]]."</option>"; 
                        }
                        else{
                            echo "<option value='".$row1[$row["option_othr_src_column_value"]]."'>".$row1[$row["option_othr_src_column"]]."</option>"; 
                        }
                    }
                }
            }
        echo "</select>";
    }
    if($row["option_whole_table_search"] === "True"){
    ?>
    <!-- <div class="input-group-append"> -->
    <button class="btn btn-sm btn-info" onclick="show_search_panel('<?php echo $row['id']; ?>', '<?php echo $row['option_name']; ?>', '<?php echo $row['option_othr_src_table']; ?>' , '<?php echo $row['option_othr_src_column']; ?>')"><span class="fa fa-search"></span></button>
    <!-- </div> -->
    <?php
    }
    echo "</div>";
    echo "</div>";
    // if($row_allow){
    //     echo "</div>";
    // }
}

function print_options_spec($row, $post, $option_id, $j, $local_conn_db, $row_allow, $is_single)
{
    if($row["option_type"] === "Input Text"){
        if($row['field_type'] === 'Grouped'){
            ?> <input autocomplete="off" type='<?php if($row["visible"] === "False"){ echo "hidden"; }else{ echo "text"; } ?>' id='<?php echo $row["option_name"]; ?>' name='<?php echo $row["option_name"]; ?>' class='form-control' placeholder='<?php echo $row["option_name"] ?>' aria-describedby='basic-addon1' onfocus='autocomplete_with_db("<?php echo $row["option_name"]; ?>", "<?php echo $row["option_val_frm_othr_src"]; ?>", "<?php echo $row["option_othr_src_table"]; ?>", "<?php echo $row["option_othr_src_column"]; ?>" )' <?php if($row["editable"] === "False"){ echo "readonly"; } ?> onfocusin="fetch_value('<?php echo $row['option_othr_src_table']; ?>', '<?php echo $row['option_othr_src_column']; ?>', '<?php echo $row['option_othr_src_column_value']; ?>', '<?php echo $row['option_name']; ?>', '<?php echo $row['formula']; ?>')"
             onclick="fetch_value('<?php echo $row['option_othr_src_table']; ?>', '<?php echo $row['option_othr_src_column']; ?>', '<?php echo $row['option_othr_src_column_value']; ?>', '<?php echo $row['option_name']; ?>', '<?php echo $row['formula']; ?>')"> <?php
        }
        else{
            ?> <input autocomplete="off" type='<?php if($row["visible"] === "False"){ echo "hidden"; }else{ echo "text"; } ?>' id='<?php echo $row["option_name"]; ?>' name='<?php echo $row["option_name"]; ?>' class='form-control' placeholder='<?php echo $row["option_name"] ?>' aria-describedby='basic-addon1' onfocus='autocomplete_with_db("<?php echo $row["option_name"]; ?>", "<?php echo $row["option_val_frm_othr_src"]; ?>", "<?php echo $row["option_othr_src_table"]; ?>", "<?php echo $row["option_othr_src_column"]; ?>" )' onfocusout="inp_onclicks()"> <?php
        }
    }
    else if($row["option_type"] === "Input Number" || $row["option_type"] === "Input Number With Point"){
        if($row['field_type'] === 'Grouped'){
            ?> <input autocomplete="off" type='<?php if($row["visible"] === "False"){ echo "hidden"; }else{ echo "number"; } ?>' id='<?php echo $row["option_name"]; ?>' name='<?php echo $row["option_name"]; ?>' class='form-control' aria-describedby='basic-addon1' onfocus='autocomplete_with_db("<?php echo $row["option_name"]; ?>", "<?php echo $row["option_val_frm_othr_src"]; ?>", "<?php echo $row["option_othr_src_table"]; ?>", "<?php echo $row["option_othr_src_column"]; ?>" )' <?php if($row["editable"] === "False"){ echo "readonly"; } ?> onfocusin="fetch_value('<?php echo $row['option_othr_src_table']; ?>', '<?php echo $row['option_othr_src_column']; ?>', '<?php echo $row['option_othr_src_column_value']; ?>', '<?php echo $row['option_name']; ?>', '<?php echo $row['formula']; ?>')" 
            onclick="fetch_value('<?php echo $row['option_othr_src_table']; ?>', '<?php echo $row['option_othr_src_column']; ?>', '<?php echo $row['option_othr_src_column_value']; ?>', '<?php echo $row['option_name']; ?>', '<?php echo $row['formula']; ?>')" > <?php
        }
        else if($row['field_type'] === 'Formulated'){
            ?> <input autocomplete="off" type='<?php if($row["visible"] === "False"){ echo "hidden"; }else{ echo "number"; } ?>' id='<?php echo $row["option_name"]; ?>' name='<?php echo $row["option_name"]; ?>' class='form-control' aria-describedby='basic-addon1' onfocus='autocomplete_with_db("<?php echo $row["option_name"]; ?>", "<?php echo $row["option_val_frm_othr_src"]; ?>", "<?php echo $row["option_othr_src_table"]; ?>", "<?php echo $row["option_othr_src_column"]; ?>" )' <?php if($row["editable"] === "False"){ echo "readonly"; } ?> onfocusin="run_formula('<?php echo $row['formula']; ?>', '<?php echo $row['option_name']; ?>')" onclick="run_formula('<?php echo $row['formula']; ?>', '<?php echo $row['option_name']; ?>')" > <?php
        }
        else{
            ?> <input autocomplete="off" type='<?php if($row["visible"] === "False"){ echo "hidden"; }else{ echo "number"; } ?>' id='<?php echo $row["option_name"]; ?>' name='<?php echo $row["option_name"]; ?>' class='form-control' aria-describedby='basic-addon1'  onfocus='autocomplete_with_db("<?php echo $row["option_name"]; ?>", "<?php echo $row["option_val_frm_othr_src"]; ?>", "<?php echo $row["option_othr_src_table"]; ?>", "<?php echo $row["option_othr_src_column"]; ?>" )' <?php if($row["editable"] === "False"){ echo "readonly"; } ?> onfocusout="inp_onclicks()"> <?php
        }
    }
    else if($row["option_type"] === "Input Date"){
        echo "<input type='date' id='".$row["option_name"]."' name='".$row["option_name"]."' class='form-control' aria-describedby='basic-addon1'>";
    }
    else if($row["option_type"] === "Select"){
        echo "<select id='".$row["option_name"]."' name='".$row["option_name"]."' class='form-control' aria-describedby='basic-addon1'>";
            $opt_texts = explode(",", $row["option_texts"]);
            $opt_values = explode(",", $row["option_values"]);
            if($opt_texts[0] != ""){
                for($i = 0; $i < count($opt_texts); $i++){
                    echo "<option value=".$opt_values[$i].">".$opt_texts[$i]."</option>";
                }
            }
            if($row["option_val_frm_othr_src"] === "True"){
                $sql1="SELECT * FROM ".$row["option_othr_src_table"]."_values";
                $result1 = mysqli_query($local_conn_db, $sql1);
                if($result1->num_rows > 0){
                    while($row1 = $result1->fetch_assoc()){ 
                        if($row["option_othr_src_column_value"] === "id"){
                            echo "<option value='".$row["option_othr_src_column"].'--'.$row1[$row["option_othr_src_column_value"]].'--'.$row["option_othr_src_table"]."'>".$row1[$row["option_othr_src_column"]]."</option>"; 
                        }
                        else{
                            echo "<option value='".$row1[$row["option_othr_src_column_value"]]."'>".$row1[$row["option_othr_src_column"]]."</option>"; 
                        }
                    }
                }
            }
        echo "</select>";
    }
    if(!$post){
        ?><div class='col-sm-1'>
        <button class="btn btn-default" onclick="settings_sub_option(
        '<?php echo $row['id']; ?>', 
        '<?php echo $row['option_name']; ?>', 
        '<?php echo $row['option_type']; ?>', 
        '<?php echo $row['option_empty_check']; ?>', 
        '<?php echo $row['option_similarity_check']; ?>', 
        '<?php echo $row['option_texts']; ?>', 
        '<?php echo $row['option_values']; ?>',
        '<?php echo $row['option_val_frm_othr_src']; ?>',
        '<?php echo $row['option_othr_src_table']; ?>', 
        '<?php echo $row['option_othr_src_column']; ?>', 
        '<?php echo $row['option_othr_src_column_value']; ?>', 
        '<?php echo $row['option_whole_table_search']; ?>', 
        '<?php echo $row['option_priority']; ?>',
        '<?php if(isset($row['entry_type'])) echo $row['entry_type']; ?>',
        '<?php if(isset($row['entry_sum'])) echo $row['entry_sum']; ?>',
        '<?php if(isset($row['custom_storage']))echo $row['custom_storage']; ?>',
        '<?php if(isset($row['status']))echo $row['status']; ?>',
        '<?php if(isset($row['field_type']))echo $row['field_type']; ?>',
        '<?php if(isset($row['formula']))echo $row['formula']; ?>',
        '<?php if(isset($row['editable']))echo $row['editable']; ?>',
        '<?php if(isset($row['visible']))echo $row['visible']; ?>',
        '<?php if(isset($row['table_visible']))echo $row['table_visible']; ?>'
        )">
            <span class="fa fa-gear"></span>
        </button>
        </div><?php
    }
}

?>