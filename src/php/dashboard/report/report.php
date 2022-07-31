<?php

include('../../connections/connection.php');
include('../../connections/local_connection.php');

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


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $option_name." Report"; ?></title>
    <link rel="stylesheet" href="../../../../assets/css/report.css" />
</head>
<body>
<h1><?php echo $option_name." Report" ?></h1>
<?php
    if($database_name != ""){
        $local_conn_db = mysqli_connect($server, $server_user, $server_pass, $database_name);
        if($local_conn_db->connect_error){
            die("Failed to connect with MySQL: " . $local_conn_db->connect_error);
        }
        if($option_type === "report"){
            $table = $option_type.'_'.$option_id;
            $sql="SELECT * FROM `$table` ORDER BY `option_priority` ASC";
            $result = mysqli_query($local_conn_db, $sql);
            echo "<table id='head_table'>";
            echo "<tr>";
            $filters = "";
            if($result->num_rows > 0){
                    $i=0;
                    while($row = $result->fetch_assoc()){
                        $r_column_name = str_replace(" ","_",$row["column_name"]);
                        if($row["is_heading"] === "True"){
                            if($row["column_type"] === "Date"){
                                echo "<td><strong>".$row["column_name"].": </strong>";
                                echo "<label>".$_POST[$row["column_name"]]."</label>";
                                echo "<strong>  to  </strong>";
                                echo "<label> ".$_POST["To"]."</label></td>";
                            }
                            else{
                                echo "<td><strong>".$row["column_name"].": </strong>";
                                echo "<label>".$_POST[$row["column_name"]]."</label></td>";
                            }
                        }
                        if($row["is_filter"] === "True"){
                            if($row["against_column"] !== ""){
                                $sql1="SELECT * FROM `".$row["against_table"]."_values` WHERE `".$row["against_column"]."` LIKE '%".$_POST[$r_column_name]."%'";
                                // echo $sql1;
                                $result1 = mysqli_query($local_conn_db, $sql1);
                                if($result1->num_rows > 0){
                                    $j=0;
                                    while($row1 = $result1->fetch_assoc()){
                                        if($i === 0){
                                            $filters .= " WHERE `".$row["column"]."`='".$row1["id"]."'";
                                        }
                                        else if($j === 0){
                                            $filters .= " AND (`".$row["column"]."`='".$row1["id"]."'";
                                        }
                                        else{
                                            $filters .= " OR `".$row["column"]."`='".$row1["id"]."'";
                                        }
                                        $j++;
                                    }
                                    $filters .= ") ";
                                }
                            }
                            else{
                                if($row["column_type"] === "Date"){
                                    if($i === 0){
                                        $filters .= " WHERE `".$row["column"]."` BETWEEN '".$_POST[$r_column_name]."' AND '".$_POST["To"]."'";
                                    }
                                    else{
                                        $filters .= " AND `".$row["column"]."` BETWEEN '".$_POST[$r_column_name]."' AND '".$_POST["To"]."'";
                                    }
                                }
                                else{
                                    if($i === 0){
                                        $filters .= " WHERE `".$row["column"]."` LIKE '%".$_POST[$r_column_name]."%'";
                                    }
                                    else{
                                        $filters .= " AND `".$row["column"]."` LIKE '%".$_POST[$r_column_name]."%'";
                                    }
                                }
                            }
                        }
                        ++$i;
                        if($i % 3 === 0){
                            echo "</tr><tr>";
                        }
                    }
            }
            echo "</tr>";
            echo "</table>";
            $sql="SELECT * FROM `$table` ORDER BY `option_priority` ASC";
            $result = mysqli_query($local_conn_db, $sql);
            ?>
            <br>
            <table id='body_table'>
            <?php
                if($result->num_rows > 0){
                    // Fetching data from database
                    echo "<thead>";
                    echo "<tr>";
                    $columns = "";
                    $column_names = "";
                    $column_types = "";
                    $against_columns = "";
                    $against_tables = "";
                    $entry_sums = "";
                    $i=0;
                    while($row = $result->fetch_assoc()){
                        echo "<th>".$row["column_name"]."</th>";
                        if($i === 0){
                            if($row["formula"] !== ""){
                                $columns .= str_replace(",", "-",$row["formula"]);
                            }
                            else{
                                $columns .= $row["column"];
                            }
                            $column_names .= $row["column_name"];
                            $column_types .= $row["column_type"];
                            $against_columns .= $row["against_column"];
                            $against_tables .= $row["against_table"];
                            $entry_sums .= $row["entry_sum"];
                        }
                        else{
                            if($row["formula"] !== ""){
                                $columns .= ",".str_replace(",", "-",$row["formula"]);
                            }
                            else{
                                $columns .= ",".$row["column"];
                            }
                            $column_names .= ",".$row["column_name"];
                            $column_types .= ",".$row["column_type"];
                            $against_columns .= ",".$row["against_column"];
                            $against_tables .= ",".$row["against_table"];
                            $entry_sums .= ",".$row["entry_sum"];
                        }
                        $i++;
                    }
                    echo "</tr>";
                    echo "</thead>";
            }
            $sql="SELECT * FROM `$table` ORDER BY `option_priority` ASC";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                    $t_columns = "";
                    $i=0;
                    while($row = $result->fetch_assoc()){
                        if($i === 0){
                            $t_columns .= $row["table"]."_values.".$row["column"];
                        }
                        else{
                            $t_columns .= ",".$row["table"]."_values.".$row["column"];
                        }
                        $i++;
                    }
            }
            $sql="SELECT DISTINCT(`table`) FROM `$table` ORDER BY `option_priority` ASC";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                    $val_tables = "";
                    $tables = "";
                    $i=0;
                    while($row = $result->fetch_assoc()){
                        if($i === 0){
                            $tables .= $row["table"];
                            $val_tables .= $row["table"]."_values";
                        }
                        else{
                            $tables .= ", ".$row["table"];
                            $val_tables .= ", ".$row["table"]."_values";
                        }
                        $i++;
                    }
            }
                    echo "<tbody>";
                    $sql_vals = "SELECT * FROM ".$val_tables.$filters." AND `added_for`='$business'";
                    $sum = array();
                    $column = explode(",", $columns);
                    $column_name = explode(",", $column_names);
                    $column_type = explode(",", $column_types);
                    $against_column = explode(",", $against_columns);
                    $against_table = explode(",", $against_tables);
                    $entry_sum = explode(",", $entry_sums);
                    $result_vals = mysqli_query($local_conn_db, $sql_vals);
                    for($i=0; $i<count($column); $i++){
                        $sum[$i] = "";
                    }
                    if($result_vals->num_rows > 0){
                        while($row_vals = $result_vals->fetch_assoc()){
                            echo "<tr>";
                            for($i=0; $i<count($column); $i++){
                                if(isset($row_vals[$against_column[$i]])){
                                    $sql1 = "SELECT `".$against_column[$i]."` FROM `".$against_table[$i]."_values` WHERE `id`='".$row[$column[$i]]."'";
                                    $result1 = mysqli_query($local_conn_db, $sql1);
                                    if($result1->num_rows > 0){
                                        while($row1 = $result1->fetch_assoc()){
                                            if(is_numeric($row1[$against_column[$i]])){
                                                echo "<td style='text-align: center;'>".$row1[$against_column[$i]]."</td>";
                                            }
                                            else{
                                                echo "<td>".$row1[$against_column[$i]]."</td>";
                                            }
                                            if($entry_sum[$i] === "True"){
                                                if($sum[$i] === ""){
                                                    $sum[$i] = 0;
                                                }
                                                $sum[$i] = $sum[$i]+$row1[$against_column[$i]];
                                            }
                                        }
                                    }
                                }
                                else{
                                    $formula = explode("---",$column[$i]);
                                    if(count($formula) > 1){
                                        for($k=1; $k < count($formula); $k+=2){
                                            if($k === 1){
                                                $value = $row_vals[$formula[0]];
                                            }
                                            if($formula[$k] === "Sum"){
                                                $value = $value + $row_vals[$formula[$k+1]];
                                            }
                                            else if($formula[$k] === "Subtract"){
                                                $value = $value - $row_vals[$formula[$k+1]];
                                            }
                                            else if($formula[$k] === "Multiplication"){
                                                $value = $value * $row_vals[$formula[$k+1]];
                                            }
                                            else if($formula[$k] === "Division"){
                                                $value = $value / $row_vals[$formula[$k+1]];
                                            }
                                            else if($formula[$k] === "Modulus"){
                                                $value = $value % $row_vals[$formula[$k+1]];
                                            }
                                        }
                                        if($entry_sum[$i] === "True"){
                                            if($sum[$i] === ""){
                                                $sum[$i] = 0;
                                            }
                                            $sum[$i] += $value;
                                        }
                                        echo "<td style='text-align: center;'>".$value."</td>";
                                    }
                                    else{
                                        $opt_id = $column[$i] ? explode("_", $column[$i])[1] : "";
                                        if($opt_id != ""){
                                            $sql_1 = "SELECT * FROM ".$tables." WHERE id='".$opt_id."'";
                                            $result_1 = mysqli_query($local_conn_db, $sql_1);
                                            $other_src_check = false;
                                            if($result_1->num_rows > 0){
                                                while($row_1 = $result_1->fetch_assoc()){
                                                    if($row_1["option_type"] == "Select" && $row_1["option_val_frm_othr_src"] == "True"){
                                                        $other_src_check = true;
                                                        $other_src_table = $row_1["option_othr_src_table"];
                                                        $other_src_column = $row_1["option_othr_src_column"];
                                                        $other_src_column_value = $row_1["option_othr_src_column_value"];
                                                        break;
                                                    }
                                                }
                                            }
                                            if($other_src_check){
                                                $sql_othr_src = "SELECT $other_src_column FROM ".$other_src_table."_values WHERE $other_src_column_value='".$row_vals[$column[$i]]."'";
                                                $result_othr_src = mysqli_query($local_conn_db, $sql_othr_src);
                                                if($result_othr_src->num_rows > 0){
                                                    while($row_othr_src = $result_othr_src->fetch_assoc()){
                                                        echo "<td>".$row_othr_src[$other_src_column]."</td>";
                                                    }
                                                }
                                            }
                                            else{
                                                if(is_numeric($row_vals[$column[$i]])){
                                                    echo "<td style='text-align: center;'>".$row_vals[$column[$i]]."</td>";
                                                }
                                                else{
                                                    echo "<td>".$row_vals[$column[$i]]."</td>";
                                                }
                                                if($entry_sum[$i] === "True"){
                                                    if($sum[$i] === ""){
                                                        $sum[$i] = 0;
                                                    }
                                                    $sum[$i] += $row_vals[$column[$i]];
                                                }
                                            }     
                                        }
                                        else{
                                            // echo $row_vals[$column[$i]];
                                        }
                                    }
                                }                       
                            }
                            echo "</tr>";
                        }
                    }
                    echo "</tbody>";
                    echo "</table>";
                    echo "<br>";
                    echo "<table id='foot_table'>";
                    echo "<tr>";
                    for($i=0; $i<count($column); $i++){
                        if($sum[$i] !== ""){
                            echo "<td><strong>Total ".$column_name[$i].": </strong>";
                            echo "<label>".$sum[$i]."</label></td>";
                        }
                    }
                    echo "</tr>";
                    echo "</table>";
            
        }
        else{
            $table = $option_type.'_'.$option_id;
            $sql="SELECT * FROM `$table` ORDER BY `option_priority` ASC";
            $result = mysqli_query($local_conn_db, $sql);
            echo "<table id='head_table'>";
            echo "<tr>";
            $filters = "";
            if($result->num_rows > 0){
                    $i=0;
                    while($row = $result->fetch_assoc()){
                        $r_column_name = str_replace(" ","_",$row["column_name"]);
                        if($row["is_heading"] === "True"){
                            if($row["column_type"] === "Date"){
                                echo "<td><strong>".$row["column_name"].": </strong>";
                                echo "<label>".$_POST[$row["column_name"]]."</label>";
                                echo "<strong>  to  </strong>";
                                echo "<label> ".$_POST["To"]."</label></td>";
                            }
                            else{
                                echo "<td><strong>".$row["column_name"].": </strong>";
                                echo "<label>".$_POST[$row["column_name"]]."</label></td>";
                            }
                        }
                        if($row["is_filter"] === "True"){
                            if($row["against_column"] !== ""){
                                $sql1="SELECT * FROM `".$row["against_table"]."_values` WHERE `".$row["against_column"]."` LIKE '%".$_POST[$r_column_name]."%'";
                                // echo $sql1;
                                $result1 = mysqli_query($local_conn_db, $sql1);
                                if($result1->num_rows > 0){
                                    $j=0;
                                    while($row1 = $result1->fetch_assoc()){
                                        if($i === 0){
                                            $filters .= " WHERE `".$row["column"]."`='".$row1["id"]."'";
                                        }
                                        else if($j === 0){
                                            $filters .= " AND (`".$row["column"]."`='".$row1["id"]."'";
                                        }
                                        else{
                                            $filters .= " OR `".$row["column"]."`='".$row1["id"]."'";
                                        }
                                        $j++;
                                    }
                                    $filters .= ") ";
                                }
                            }
                            else{
                                if($row["column_type"] === "Date"){
                                    if($i === 0){
                                        $filters .= " WHERE `".$row["column"]."` BETWEEN '".$_POST[$r_column_name]."' AND '".$_POST["To"]."'";
                                    }
                                    else{
                                        $filters .= " AND `".$row["column"]."` BETWEEN '".$_POST[$r_column_name]."' AND '".$_POST["To"]."'";
                                    }
                                }
                                else{
                                    if($i === 0){
                                        $filters .= " WHERE `".$row["column"]."` LIKE '%".$_POST[$r_column_name]."%'";
                                    }
                                    else{
                                        $filters .= " AND `".$row["column"]."` LIKE '%".$_POST[$r_column_name]."%'";
                                    }
                                }
                            }
                        }
                        ++$i;
                        if($i % 3 === 0){
                            echo "</tr><tr>";
                        }
                    }
            }
            echo "</tr>";
            echo "</table>";
            $sql="SELECT * FROM `$table` ORDER BY `option_priority` ASC";
            $result = mysqli_query($local_conn_db, $sql);
            ?>
            <br>
            <table id='body_table'>
            <?php
            if($result->num_rows > 0){
                    // Fetching data from database
                    echo "<thead>";
                    echo "<tr>";
                    $columns = "";
                    $column_names = "";
                    $against_columns = "";
                    $against_tables = "";
                    $entry_sums = "";
                    $i=0;
                    while($row = $result->fetch_assoc()){
                        echo "<th>".$row["column_name"]."</th>";
                        if($i === 0){
                            $columns .= $row["column"];
                            $column_names .= $row["column_name"];
                            $against_columns .= $row["against_column"];
                            $against_tables .= $row["against_table"];
                            $entry_sums .= $row["entry_sum"];
                        }
                        else{
                            $columns .= ",".$row["column"];
                            $column_names .= ",".$row["column_name"];
                            $against_columns .= ",".$row["against_column"];
                            $against_tables .= ",".$row["against_table"];
                            $entry_sums .= ",".$row["entry_sum"];
                        }
                        $i++;
                    }
                    echo "</tr>";
                    echo "</thead>";
            }
            $sql="SELECT * FROM `$table` WHERE `formula`='parameter' ORDER BY `option_priority` ASC";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                echo "<tbody>";
                while($row = $result->fetch_assoc()){
                    if($row["table"] === "Date"){
                        // $start_date = $_POST['Date'];
                        // $end_date = $_POST['To'];
                        // while (strtotime($start_date) <= strtotime($end_date)) {
                            
                        //     $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                        // }
                    }
                    else{
                        $sum = array();
                        $column = explode(",", $columns);
                        $column_name = explode(",", $column_names);
                        $against_column = explode(",", $against_columns);
                        $against_table = explode(",", $against_tables);
                        $entry_sum = explode(",", $entry_sums);
                        
                        for($i=0; $i<count($column); $i++){
                            $sum[$i] = "";
                        }
                        if($_POST['Date']){
                            $start_date = $_POST['Date'];
                            $end_date = $_POST['To'];    
                        }
                        else{
                            $start_date = date();
                            $end_date = date();    
                        }
                        while (strtotime($start_date) <= strtotime($end_date)) {
                            $sub_table = $row['table']."_values";
                            $sql1 = "SELECT * FROM $sub_table WHERE `added_for`='$business'";
                            $result1 = mysqli_query($local_conn_db, $sql1);
                            if($result1->num_rows > 0){
                                while($row1 = $result1->fetch_assoc()){
                                    $sql2="SELECT * FROM `$table` WHERE `formula`!='parameter' ORDER BY `option_priority` ASC";
                                    $result2 = mysqli_query($local_conn_db, $sql2);
                                    if($result2->num_rows > 0){
                                        $i=0;
                                        while($row2 = $result2->fetch_assoc()){
                                            if($i===0){
                                                echo "<tr>";
                                                echo "<td>".$start_date."</td>";
                                                echo "<td>".$row1[$row['column']]."</td>";
                                            }
                                            $tbls = explode("--", $row2["parameter_table"]);
                                            $clms = explode("--", $row2["parameter_column"]);
                                            $against_clms = explode("--", $row2["against_column"]);
                                            $where_clause = "WHERE ";
                                            for($i=0; $i<count($against_clms); $i++){
                                                if($i > 0){
                                                    $where_clause = $where_clause." AND ";
                                                }
                                                if($clms[$i] === "Date"){
                                                    $where_clause = $where_clause."`".$against_clms[$i]."`='".$start_date."'";
                                                }
                                                else{
                                                    $where_clause = $where_clause."`".$against_clms[$i]."`='".$row1["id"]."'";
                                                }
                                            }
                                            if($row2["table"] !== ""){
                                                $a_table = $row2["table"]."_values";
                                                $sql3="SELECT ".$row2["column_selection"]."(`".$row2["column"]."`) AS `clm` FROM `$a_table` ".$where_clause;
                                                $result3 = mysqli_query($local_conn_db, $sql3);
                                                if($result3->num_rows > 0){
                                                    while($row3 = $result3->fetch_assoc()){
                                                        echo "<td>".$row3["clm"]."</td>";
                                                    }
                                                }
                                                else{
                                                    echo "<td></td>";
                                                }
                                            }
                                            else{
                                                echo "<td>".$row2["formula"]."</td>";
                                            }
                                            if($i===0){
                                                echo "</tr>";
                                            }
                                            $i++;
                                        }
                                    }
                                }
                            }
                            $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                        }
                        
                    }
                }
                echo "</tbody>";
                echo "</table>";
                echo "<br>";
                // echo "<table id='foot_table'>";
                // echo "<tr>";
                // for($i=0; $i<count($column); $i++){
                //     if($sum[$i] !== ""){
                //         echo "<td><strong>Total ".$column_name[$i].": </strong>";
                //         echo "<label>".$sum[$i]."</label></td>";
                //     }
                // }
                // echo "</tr>";
                // echo "</table>";
            }
        }    
    }
    else{
        echo "Database not found...!";
    }

?>
</body>
</html>