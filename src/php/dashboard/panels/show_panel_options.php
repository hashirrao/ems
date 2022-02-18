
<?php 
include('../../connections/connection.php');
include('../../connections/local_connection.php');
if($_POST["type"] === "asset" || $_POST["type"] === "edit_asset"){
    $asset_id = $_POST["asset_id"];
    $system_id = $_POST["system_id"];
    $database = "";
    $asset_name = "";
    ?>
    <div style="visibility: hidden; position: absolute;" id="show_opt_div" class="jumbotron lesspadding">
    <?php if($_POST["type"] === "edit_asset"){ ?>
        <strong>ASSET ID: </strong><label id="edit_asset_id_options_panels_dev"><?php echo $asset_id ?></label>
    <?php } else {?>
        <strong>ASSET ID: </strong><label id="asset_id_options_panels_dev"><?php echo $asset_id ?></label>
    <?php } ?>
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
    <strong >ASSET NAME: </strong><label id="asset_name_options_panels_dev"><?php echo $asset_name; ?></label>
    </div>
    <div id="show_frontend_<?php echo $asset_id ?>_div">
    
    </div>

<?php 
}

else if($_POST["type"] === "list"){ 
    $asset_id = $_POST["asset_id"];
    $system_id = $_POST["system_id"];
    $database = "";
    $asset_name = "";
    ?>
    <div style="visibility: hidden; position: absolute;" id="show_opt_div" class="jumbotron lesspadding">
    <strong>ASSET ID: </strong><label id="list_id_options_panels_dev"><?php echo $asset_id ?></label>
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
    <strong >ASSET NAME: </strong><label id="list_name_options_panels_dev"><?php echo $asset_name; ?></label>
    </div>
    <div id="show_frontend_<?php echo $asset_id ?>_div">
        
    </div>

<?php } 

else if($_POST["type"] === "entry"){
    $entry_id = $_POST["entry_id"];
    $system_id = $_POST["system_id"];
    $database = "";
    $entry_name = "";
    ?>
    <div style="visibility: hidden; position: absolute;" id="show_opt_div" class="jumbotron lesspadding">
    <strong>ENTRY ID: </strong><label id="entry_id_options_panels_dev"><?php echo $entry_id ?></label>
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
    <strong >ENTRY NAME: </strong><label id="entry_name_options_panels_dev"><?php echo $entry_name; ?></label>
    </div>
    <div id="show_frontend_<?php echo $entry_id ?>_div">
    
    </div>
<?php }

else if($_POST["type"] === "report"){
    $report_id = $_POST["report_id"];
    $system_id = $_POST["system_id"];
    $database = "";
    $report_name = "";
    ?>
    <div style="visibility: hidden; position: absolute;" id="show_opt_div" class="jumbotron lesspadding">
    <strong>REPORT ID: </strong><label id="report_id_options_panels_dev"><?php echo $report_id ?></label>
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
            }
        }
    }
    ?>
    <strong >REPORT NAME: </strong><label id="report_name_options_panels_dev"><?php echo $report_name; ?></label>
    </div>
    <div id="show_frontend_<?php echo $report_id ?>_div">
    
    </div>
<?php } ?>