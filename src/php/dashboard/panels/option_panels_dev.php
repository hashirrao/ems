
<?php 
include('../../connections/connection.php');
include('../../connections/local_connection.php');
if($_POST["type"] == "asset"){ 
    $asset_id = $_POST["asset_id"];
    $system_id = $_POST["system_id"];
    $database = "";
    $asset_name = "";
    ?>
    <div id="show_opt_div" class="jumbotron lesspadding all_border">
        <strong>ASSET ID: </strong><label style='text-decoration: underline;' id="asset_id_options_panels_dev"><?php echo $asset_id ?></label>
        <?php 
        $sql="SELECT * FROM `systems` WHERE `id`=$system_id";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $database = $row["database_name"];
            }
        }
        if($database != ""){
            $local_conn_db = mysqli_connect($server, $server_user, $server_pass, $database);
            if($local_conn_db->connect_error){
                die("Failed to connect with MySQL: " . $local_conn_db->connect_error);
            }
            $sql="SELECT * FROM `spec_options` WHERE `id`='".$asset_id."'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $asset_name = $row["name"];
                }
            }
        }
        ?>
        <strong>ASSET NAME: </strong><label style='text-decoration: underline;' id="asset_name_options_panels_dev"><?php echo $asset_name; ?></label>
        <button style="margin-left: 5px;" class="btn btn-transparent" onclick="list_asset_for_edit_link_click('<?php echo $asset_id; ?>', '<?php echo $asset_name; ?>')">
                            <span class="fa fa-pencil"></span>
                        </button>

                        <!-- <div id="opts_div" style="text-align: right; padding-bottom: 5px; margin-top: -25px;"> -->
        <button style="float: right; margin-right: 10px;" class="btn btn-default" onclick="add_option_btn_click()">
                            <span class="fa fa-plus"></span>
                        Add Option</button>
        <button style="float: right; margin-right: 10px;" class="btn btn-info" onclick="refresh_sub_options_in_panel()">
                            <span class="fa fa-refresh"></span>
                        Refresh Options</button>
    <!-- </div> -->
    </div>
    
    <div id="show_frontend_div" class="jumbotron lesspadding all_border">
    </div>

<?php }
else if($_POST["type"] === "entry"){ 
    $entry_id = $_POST["entry_id"];
    $system_id = $_POST["system_id"];
    $database = "";
    $entry_name = "";
    ?>
    <div id="show_opt_div" class="jumbotron lesspadding all_border">
        <strong>ENTRY ID: </strong><label style='text-decoration: underline;' id="entry_id_options_panels_dev"><?php echo $entry_id ?></label>
        <?php 
        $sql="SELECT * FROM `systems` WHERE `id`=$system_id";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $database = $row["database_name"];
            }
        }
        if($database != ""){
            $local_conn_db = mysqli_connect($server, $server_user, $server_pass, $database);
            if($local_conn_db->connect_error){
                die("Failed to connect with MySQL: " . $local_conn_db->connect_error);
            }
            $sql="SELECT * FROM `spec_options` WHERE `id`='".$entry_id."'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $entry_name = $row["name"];
                }
            }
        }
        ?>
        <strong>ENTRY NAME: </strong><label style='text-decoration: underline;' id="entry_name_options_panels_dev"><?php echo $entry_name; ?></label>
        <button style="margin-left: 5px;" class="btn btn-transparent" onclick="list_entry_for_edit_link_click('<?php echo $entry_id; ?>', '<?php echo $entry_name; ?>')">
                            <span class="fa fa-pencil"></span>
                        </button>

        <button style="float: right; margin-right: 10px;" class="btn btn-default" onclick="add_option_btn_click()">
                            <span class="fa fa-plus"></span>
                        Add Option</button>
        <button style="float: right; margin-right: 10px;" class="btn btn-info" onclick="refresh_sub_options_in_panel()">
                            <span class="fa fa-refresh"></span>
                        Refresh Options</button>
        
    </div>
    <!-- <div id="opts_div" style="text-align: right; padding-bottom: 5px; margin-top: -25px;">
        
    </div> -->
    <div id="show_frontend_div" class="jumbotron lesspadding all_border">
    </div>

<?php }
else if($_POST["type"] === "report"){ 
    $report_id = $_POST["report_id"];
    $system_id = $_POST["system_id"];
    $database = "";
    $report_name = "";
    ?>
    <div id="show_opt_div" class="jumbotron lesspadding all_border">
        <strong>REPORT ID: </strong><label style='text-decoration: underline;' id="report_id_options_panels_dev"><?php echo $report_id ?></label>
        <?php 
        $sql="SELECT * FROM `systems` WHERE `id`=$system_id";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $database = $row["database_name"];
            }
        }
        if($database != ""){
            $local_conn_db = mysqli_connect($server, $server_user, $server_pass, $database);
            if($local_conn_db->connect_error){
                die("Failed to connect with MySQL: " . $local_conn_db->connect_error);
            }
            $sql="SELECT * FROM `spec_options` WHERE `id`='".$report_id."'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $report_name = $row["name"];
                    $report_type = $row["type"];
                }
            }
        }
        ?>
        <strong>NAME: </strong><label style='text-decoration: underline;' id="report_name_options_panels_dev"><?php echo $report_name; ?></label>
        <?php if($report_type === "mt_report"){ ?>
            <strong>TYPE: </strong><label style='text-decoration: underline;' id="report_type_options_panels_dev"><?php echo "Multi Table"; ?></label>
        <?php } else { ?>
            <strong>TYPE: </strong><label style='text-decoration: underline;' id="report_type_options_panels_dev"><?php echo "Single Table"; ?></label>
        <?php } ?>
        <button style="margin-left: 5px;" class="btn btn-transparent" onclick="list_report_for_edit_link_click('<?php echo $report_id; ?>', '<?php echo $report_name; ?>', '<?php $report_type; ?>')">
                            <span class="fa fa-pencil"></span>
                        </button>
    <!-- </div>
    <div id="opts_div" style="text-align: right; padding-bottom: 5px; margin-top: -25px;"> -->
    <button style="float: right; margin-right: 10px;" class="btn btn-default" onclick="add_option_btn_click()">
                            <span class="fa fa-plus"> </span>
                        Add Option</button>
    <button style="float: right; margin-right: 10px;" class="btn btn-info" onclick="refresh_sub_options_in_panel()">
                            <span class="fa fa-refresh"> </span>
                            Refresh Options</button>
    </div>
    <div id="show_frontend_div" class="jumbotron lesspadding all_border">
    </div>

<?php }
else if($_POST["type"] === "custom_table"){ 
    $custom_table_id = $_POST["custom_table_id"];
    $system_id = $_POST["system_id"];
    $database = "";
    $custom_table_name = "";
    ?>
    <div id="show_opt_div" class="jumbotron lesspadding">
    <strong>CUSTOM TABLE ID: </strong><label id="custom_table_id_options_panels_dev"><?php echo $custom_table_id ?></label>
    <?php 
    $sql="SELECT * FROM `systems` WHERE `id`=$system_id";
    $result = mysqli_query($conn, $sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $database = $row["database_name"];
        }
    }
    if($database != ""){
        $local_conn_db = mysqli_connect($server, $server_user, $server_pass, $database);
        if($local_conn_db->connect_error){
            die("Failed to connect with MySQL: " . $local_conn_db->connect_error);
        }
        $sql="SELECT * FROM `spec_options` WHERE `id`='".$custom_table_id."'";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $custom_table_name = $row["name"];
            }
        }
    }
    ?>
    <strong>CUSTOM TABLE NAME: </strong><label id="custom_table_name_options_panels_dev"><?php echo $custom_table_name; ?></label>
    <button style="float: right; margin-right: 5px;" class="btn btn-default" onclick="list_custom_table_for_edit_link_click('<?php echo $custom_table_id; ?>', '<?php echo $custom_table_name; ?>')">
                        <span class="fa fa-pencil"></span>
                    </button>
    </div>
    <div id="opts_div" style="text-align: right; padding-bottom: 5px; margin-top: -25px;">
        <button class="btn btn-default" onclick="add_option_btn_click()">
                        <span class="fa fa-plus"></span>
                    Add Option</button>
        <button class="btn btn-default" onclick="refresh_sub_options_in_panel()">
                            <span class="fa fa-refresh"></span>
                        Refresh Options</button>
    </div>
    <div id="show_frontend_div" class="jumbotron lesspadding">
    </div>

<?php } ?>