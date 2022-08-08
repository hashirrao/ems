<?php

include('../../connections/connection.php');
include('../../connections/local_connection.php');

$system_id = $_POST['system_id'];
$v_no = $_POST["print_voucher_no"];
$opt_id = $_POST["print_option_id"];
$sum_bundles = 0;
$sum_bags = 0;
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
    $sql="SELECT * FROM `spec_options` WHERE `id`='$opt_id'";
    $result = mysqli_query($local_conn_db, $sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $option_type = $row["type"];
            $option_name = $row["name"];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../../assets/css/print.css" />
    <title><?php echo $option_name." Print"; ?></title>
</head>
<body>
<?php

echo "<h1 style='text-align: Center;'>".$option_name."</h1>";

$table = $option_type."_".$opt_id;
$table_values = $option_type."_".$opt_id."_values";
$sql="SELECT * FROM `$table` WHERE `status`='Activate' AND `entry_type`='Single' ORDER BY `option_priority` ASC";
$result = mysqli_query($local_conn_db, $sql);
if($result->num_rows > 0){
    echo "<table class='single_table'>";
    echo "<tr>";
    echo "<td><strong>Voucher No: </strong>";
    echo "<label>".$v_no."</label></td>";
    while($row = $result->fetch_assoc()){
        $sql1="SELECT * FROM `$table_values` WHERE `voucher_no`='$v_no'";
        $result1 = mysqli_query($local_conn_db, $sql1);
        if($result1->num_rows > 0){
            while($row1 = $result1->fetch_assoc()){
                if($row["visible"] !== "False"){
                    echo "<td><strong>".$row["option_name"].": </strong>";
                    echo "<label>".$row1["opt_".$row["id"]]."</label></td>";
                }
                break;
            }
            
        }
    }
    echo "</tr>";
    echo "</table>";
}
echo "<br>";
echo "<table class='multiple_table'>";
$sql="SELECT * FROM `$table` WHERE `status`='Activate' AND `entry_type`='Multiple' ORDER BY `option_priority` ASC";
$result = mysqli_query($local_conn_db, $sql);
if($result->num_rows > 0){
    echo "<thead>";
    echo "<tr>";
    while($row = $result->fetch_assoc()){
        $sql1="SELECT * FROM `$table_values` WHERE `voucher_no`='$v_no'";
        $result1 = mysqli_query($local_conn_db, $sql1);
        if($result1->num_rows > 0){
            while($row1 = $result1->fetch_assoc()){
                if($row["table_visible"] !== "False"){
                    echo "<th><strong>".$row["option_name"]."</strong></th>";
                }  
                break;
            }
        }
    }
    echo "</tr>";
    echo "</thead>";
}
$sql1="SELECT * FROM `$table_values` WHERE `voucher_no`='$v_no'";
$result1 = mysqli_query($local_conn_db, $sql1);
if($result1->num_rows > 0){
    echo "<tbody id='entries_table_body'>";
    while($row1 = $result1->fetch_assoc()){
        echo "<tr>";
        $sql="SELECT * FROM `$table` WHERE `status`='Activate' AND `entry_type`='Multiple' ORDER BY `option_priority` ASC";
        $result = mysqli_query($local_conn_db, $sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if($row["table_visible"] !== "False"){
                    if($row["option_type"] === "Input Number" || $row["option_type"] === "Input Number With Point"){
                        echo "<td style='text-align: center;'>".$row1["opt_".$row["id"]]."</td>";
                    }
                    else if($row["option_type"] === "Select" && $row["option_othr_src_column_value"] === "id"){
                        $sql_for_select_desc = "SELECT * FROM `".$row['option_othr_src_table']."_values` WHERE `id`='".$row1["opt_".$row["id"]]."'";
                        $result_for_select_desc = mysqli_query($local_conn_db, $sql_for_select_desc);
                        if($result_for_select_desc->num_rows > 0){
                            while($row_for_select_desc = $result_for_select_desc->fetch_assoc()){
                                echo "<td>".$row_for_select_desc[$row["option_othr_src_column"]]."</td>";
                            }
                        }
                    }
                    else{
                        echo "<td>".$row1["opt_".$row["id"]]."</td>";
                    }
                }
            }
        }
        echo "</tr>";
    }
    echo "</tbody>";
}
$sql="SELECT * FROM `$table` WHERE `status`='Activate' AND `entry_type`='Multiple' ORDER BY `option_priority` ASC";
$result = mysqli_query($local_conn_db, $sql);
if($result->num_rows > 0){
    echo "<tfoot id='entries_table_foot'>";
    echo "<tr>";
    $i = 0;
    while($row = $result->fetch_assoc()){
        $sql1="SELECT * FROM `$table_values` WHERE `voucher_no`='$v_no'";
        $result1 = mysqli_query($local_conn_db, $sql1);
        if($result1->num_rows > 0){
            while($row1 = $result1->fetch_assoc()){
                if($row["table_visible"] !== "False"){
                    if($row["entry_sum"] === "True"){
                        echo "<th id='th_sum_".$i."'>0</th>";
                    }
                    else{
                        echo "<th></th>";
                    }
                    $i++;
                }
                break;
            }
        }
    }
    echo "</tr>";
    echo "</tfoot>";
}
echo "</table>";

?>
</body>
</html>

<script src="../../../js/print.js"></script>