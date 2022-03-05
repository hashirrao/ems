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
                    $against_columns = "";
                    $against_tables = "";
                    $entry_sums = "";
                    $i=0;
                    while($row = $result->fetch_assoc()){
                        if($option_id === "36" || $option_id === "39" || $option_id === "40" || $option_id === "46" || $option_id === "47"){
                            if($row["column_name"] !== "Date"){
                                echo "<th>".$row["column_name"]."</th>";
                            }
                        }
                        else if($option_id === "41"){
                            if($row["column_name"] !== "Party"){
                                echo "<th>".$row["column_name"]."</th>";
                            }
                        }
                        else if($option_id === "55"){
                            if($row["column_name"] !== "Account"){
                                echo "<th>".$row["column_name"]."</th>";
                            }
                        }
                        else if($option_id === "56"){
                            if($row["column_name"] === "Date"){
                                echo "<th>".$row["column_name"]."</th>";
                            }
                        }
                        else if($option_id === "60"){
                            
                        }
                        else{
                            echo "<th>".$row["column_name"]."</th>";
                        }
                        if($i === 0){
                            if($row["formula"] !== ""){
                                $columns .= str_replace(",", "-",$row["formula"]);
                            }
                            else{
                                $columns .= $row["column"];
                            }
                            $column_names .= $row["column_name"];
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
                            $against_columns .= ",".$row["against_column"];
                            $against_tables .= ",".$row["against_table"];
                            $entry_sums .= ",".$row["entry_sum"];
                        }
                        $i++;
                    }
                    if($option_id === "36" || $option_id === "39" || $option_id === "40" || $option_id === "46" || $option_id === "47"){
                        echo "<th>Opening</th>";
                        echo "<th>Stock In</th>";
                        echo "<th>Stock Out</th>";
                        echo "<th>Closing</th>";
                    }
                    else if($option_id === "41" || $option_id === "55"){
                        echo "<th>Entry From</th>";
                        if($option_id === "41"){
                            echo "<th>VC</th>";
                        }
                        echo "<th>Remarks</th>";
                        echo "<th>Debit</th>";
                        echo "<th>Credit</th>";
                        echo "<th>Balance</th>";
                    }
                    else if($option_id === "56"){
                        echo "<th>Purchase</th>";
                        echo "<th>Sale</th>";
                        echo "<th>Expense</th>";
                        echo "<th>Builty</th>";
                        echo "<th>Salary</th>";
                        echo "<th>Profit/Loss</th>";
                    }
                    else if($option_id === "60"){
                        echo "<th>Party</th>";
                        echo "<th>Opening</th>";
                        echo "<th>Debit</th>";
                        echo "<th>Credit</th>";
                        echo "<th>Balance</th>";
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
                    $tables = "";
                    $i=0;
                    while($row = $result->fetch_assoc()){
                        if($i === 0){
                            $tables .= $row["table"]."_values";
                        }
                        else{
                            $tables .= ", ".$row["table"]."_values";
                        }
                        $i++;
                    }
            }
            // Stock in hand report
            if($option_id === "36"){
                $products_table = "asset_4_values";
                $purchase_table = "entry_5_values";
                $sale_table = "entry_6_values";
                $sale_return_table = "entry_58_values";
                $opening_purchase = 0;
                $opening_sale = 0;
                $opening_sale_return = 0;
                $purchase = 0;
                $sale = 0;
                $sale_return = 0;
                $closing_purchase = 0;
                $closing_sale = 0;
                $closing_sale_return = 0;
                echo "<tbody>";
                $filters = substr_replace($filters, "", 7, 49);
                $sql="SELECT * FROM `$products_table`".$filters." AND `added_for`='$business'";
                $result = mysqli_query($local_conn_db, $sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".$row["opt_1"]."</td>";
                        $sql1="SELECT SUM(`opt_12`) as `opening_purchase` FROM `$purchase_table` WHERE `opt_1` < '".$_POST["Date"]."' AND `opt_5`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $opening_purchase = floatval($row1["opening_purchase"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_16`) as `opening_sale` FROM `$sale_table` WHERE `opt_1` < '".$_POST["Date"]."' AND `opt_9`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $opening_sale = floatval($row1["opening_sale"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_16`) as `opening_sale_return` FROM `$sale_return_table` WHERE `opt_1` < '".$_POST["Date"]."' AND `opt_9`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $opening_sale_return = floatval($row1["opening_sale_return"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_12`) as `opening_purchase` FROM `$purchase_table` WHERE `opt_1` BETWEEN '".$_POST["Date"]."' AND '".$_POST["To"]."' AND `opt_5`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $purchase = floatval($row1["opening_purchase"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_16`) as `opening_sale` FROM `$sale_table` WHERE `opt_1` BETWEEN '".$_POST["Date"]."' AND '".$_POST["To"]."' AND `opt_9`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $sale = floatval($row1["opening_sale"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_16`) as `sale_return` FROM `$sale_table` WHERE `opt_1` BETWEEN '".$_POST["Date"]."' AND '".$_POST["To"]."' AND `opt_9`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $sale_return = floatval($row1["sale_return"]);
                            }
                        }
                        echo "<td style='text-align: center;'>".($opening_purchase -  $opening_sale + $opening_sale_return)."</td>";
                        echo "<td style='text-align: center;'>".($purchase + $sale_return)."</td>";
                        echo "<td style='text-align: center;'>".($sale)."</td>";
                        echo "<td style='text-align: center;'>".($opening_purchase - $opening_sale + $opening_sale_return + $purchase - $sale + $sale_return)."</td>";
                        echo "</tr>";
                    }
                }
                echo "</tbody>";
            }
            // Van stock report
            else if($option_id === "39"){
                $vans_table = "asset_15_values";
                $products_table = "asset_4_values";
                $van_issue_table = "entry_16_values";
                $van_stock_return_table = "entry_57_values";
                $sale_table = "entry_6_values";
                $opening_van_stock = 0;
                $opening_van_stock_return = 0;
                $opening_sale = 0;
                $van_stock = 0;
                $van_stock_return = 0;
                $sale = 0;
                $closing_purchase = 0;
                $closing_sale = 0;
                echo "<tbody>";
                $filters = substr_replace($filters, "", 7, 49);
                $product_filters = substr_replace($filters, "", 0, 23);
                $index = strpos($product_filters,"%");
                $product_filters = substr_replace($product_filters, "WHERE ", 0, $index+6);
                // echo $product_filters;
                $van_filters = explode(" AND ", $filters);
                $van_filters = $van_filters[0];
                // echo $van_filters;
                $sql2="SELECT * FROM `$vans_table` ".$van_filters." AND `added_for`='$business'";
                $result2 = mysqli_query($local_conn_db, $sql2);
                if($result2->num_rows > 0){
                    while($row2 = $result2->fetch_assoc()){
                        $sql="SELECT * FROM `$products_table`".$product_filters." AND `added_for`='$business'";
                        $result = mysqli_query($local_conn_db, $sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                echo "<tr>";
                                echo "<td>".$row2["opt_1"]."</td>";
                                echo "<td>".$row["opt_1"]."</td>";
                                $sql1="SELECT SUM(`opt_12`) as `opening_van_stock` FROM `$van_issue_table` WHERE `opt_1` < '".$_POST["Date"]."' AND `opt_15`='".$row["id"]."' AND `opt_3`='".$row2["id"]."'"." AND `added_for`='$business'";
                                $result1 = mysqli_query($local_conn_db, $sql1);
                                if($result1->num_rows > 0){
                                    while($row1 = $result1->fetch_assoc()){
                                        $opening_van_stock = floatval($row1["opening_van_stock"]);
                                    }
                                }
                                $sql1="SELECT SUM(`opt_12`) as `opening_van_stock_return` FROM `$van_stock_return_table` WHERE `opt_1` < '".$_POST["Date"]."' AND `opt_15`='".$row["id"]."' AND `opt_3`='".$row2["id"]."'"." AND `added_for`='$business'";
                                $result1 = mysqli_query($local_conn_db, $sql1);
                                if($result1->num_rows > 0){
                                    while($row1 = $result1->fetch_assoc()){
                                        $opening_van_stock_return = floatval($row1["opening_van_stock_return"]);
                                    }
                                }
                                $sql1="SELECT SUM(`opt_16`) as `opening_sale` FROM `$sale_table` WHERE `opt_1` < '".$_POST["Date"]."' AND `opt_19`='".$row["id"]."' AND `opt_7`='".$row2["id"]."'"." AND `added_for`='$business'";
                                $result1 = mysqli_query($local_conn_db, $sql1);
                                if($result1->num_rows > 0){
                                    while($row1 = $result1->fetch_assoc()){
                                        $opening_sale = floatval($row1["opening_sale"]);
                                    }
                                }
                                $sql1="SELECT SUM(`opt_12`) as `van_issue` FROM `$van_issue_table` WHERE `opt_1` BETWEEN '".$_POST["Date"]."' AND '".$_POST["To"]."' AND `opt_15`='".$row["id"]."' AND `opt_3`='".$row2["id"]."'"." AND `added_for`='$business'";
                                $result1 = mysqli_query($local_conn_db, $sql1);
                                if($result1->num_rows > 0){
                                    while($row1 = $result1->fetch_assoc()){
                                        $van_stock = floatval($row1["van_issue"]);
                                    }
                                }
                                $sql1="SELECT SUM(`opt_12`) as `van_stock_return` FROM `$van_stock_return_table` WHERE `opt_1` BETWEEN '".$_POST["Date"]."' AND '".$_POST["To"]."' AND `opt_15`='".$row["id"]."' AND `opt_3`='".$row2["id"]."'"." AND `added_for`='$business'";
                                $result1 = mysqli_query($local_conn_db, $sql1);
                                if($result1->num_rows > 0){
                                    while($row1 = $result1->fetch_assoc()){
                                        $van_stock_return = floatval($row1["van_stock_return"]);
                                    }
                                }
                                $sql1="SELECT SUM(`opt_16`) as `sale` FROM `$sale_table` WHERE `opt_1` BETWEEN '".$_POST["Date"]."' AND '".$_POST["To"]."' AND `opt_9`='".$row["id"]."' AND `opt_7`='".$row2["id"]."'"." AND `added_for`='$business'";
                                $result1 = mysqli_query($local_conn_db, $sql1);
                                if($result1->num_rows > 0){
                                    while($row1 = $result1->fetch_assoc()){
                                        $sale = floatval($row1["sale"]);
                                    }
                                }
                                echo "<td style='text-align: center;'>".($opening_van_stock - $opening_sale - $opening_van_stock_return)."</td>";
                                echo "<td style='text-align: center;'>".($van_stock)."</td>";
                                echo "<td style='text-align: center;'>".($sale + $van_stock_return)."</td>";
                                echo "<td style='text-align: center;'>".($opening_van_stock - $opening_sale - $opening_van_stock_return + $van_stock - $van_stock_return - $sale)."</td>";
                                echo "</tr>";
                            }
                        }
                    }
                }
                echo "</tbody>";
            }
            // Store stock report
            else if($option_id === "40"){
                $products_table = "asset_4_values";
                $purchase_table = "entry_5_values";
                $sale_table = "entry_6_values";
                $sale_return_table = "entry_58_values";
                $van_issue_table = "entry_16_values";
                $van_stock_return_table = "entry_57_values";
                $opening_purchase = 0;
                $opening_sale = 0;
                $opening_sale_return = 0;
                $opening_van_issue = 0;
                $opening_van_stock_return = 0;
                $purchase = 0;
                $van_issue = 0;
                $van_stock_return = 0;
                $sale = 0;
                $sale_return = 0;
                $closing_purchase = 0;
                $closing_sale = 0;
                echo "<tbody>";
                $filters = substr_replace($filters, "", 7, 49);
                $sql="SELECT * FROM `$products_table`".$filters." AND `added_for`='$business'";
                $result = mysqli_query($local_conn_db, $sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".$row["opt_1"]."</td>";
                        $sql1="SELECT SUM(`opt_12`) as `opening_purchase` FROM `$purchase_table` WHERE `opt_1` < '".$_POST["Date"]."' AND `opt_5`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $opening_purchase = floatval($row1["opening_purchase"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_16`) as `opening_sale` FROM `$sale_table` WHERE `opt_1` < '".$_POST["Date"]."' AND `opt_9`='".$row["id"]."' AND `opt_6`=''"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $opening_sale = floatval($row1["opening_sale"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_16`) as `opening_sale_return` FROM `$sale_return_table` WHERE `opt_1` < '".$_POST["Date"]."' AND `opt_9`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $opening_sale_return = floatval($row1["opening_sale_return"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_12`) as `opening_van_issue` FROM `$van_issue_table` WHERE `opt_1` < '".$_POST["Date"]."' AND `opt_15`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $opening_van_issue = floatval($row1["opening_van_issue"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_12`) as `opening_van_stock_return` FROM `$van_stock_return_table` WHERE `opt_1` < '".$_POST["Date"]."' AND `opt_15`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $opening_van_stock_return = floatval($row1["opening_van_stock_return"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_12`) as `purchase` FROM `$purchase_table` WHERE `opt_1` BETWEEN '".$_POST["Date"]."' AND '".$_POST["To"]."' AND `opt_5`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $purchase = floatval($row1["purchase"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_16`) as `sale` FROM `$sale_table` WHERE `opt_1` BETWEEN '".$_POST["Date"]."' AND '".$_POST["To"]."' AND `opt_9`='".$row["id"]."' AND `opt_6`='' AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $sale = floatval($row1["sale"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_16`) as `sale_return` FROM `$sale_return_table` WHERE `opt_1` BETWEEN '".$_POST["Date"]."' AND '".$_POST["To"]."' AND `opt_9`='".$row["id"]."' AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $sale_return = floatval($row1["sale_return"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_12`) as `van_issue` FROM `$van_issue_table` WHERE `opt_1` BETWEEN '".$_POST["Date"]."' AND '".$_POST["To"]."' AND `opt_15`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $van_issue = floatval($row1["van_issue"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_12`) as `van_stock_return` FROM `$van_stock_return_table` WHERE `opt_1` BETWEEN '".$_POST["Date"]."' AND '".$_POST["To"]."' AND `opt_15`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $van_stock_return = floatval($row1["van_stock_return"]);
                            }
                        }
                        echo "<td style='text-align: center;'>".($opening_purchase - $opening_van_issue - $opening_sale + $opening_sale_return + $opening_van_stock_return)."</td>";
                        echo "<td style='text-align: center;'>".($purchase + $sale_return + $van_stock_return)."</td>";
                        echo "<td style='text-align: center;'>".($van_issue + $sale)."</td>";
                        echo "<td style='text-align: center;'>".($opening_purchase - $opening_van_issue - $opening_sale + $opening_sale_return + $opening_van_stock_return + $purchase - $van_issue - $sale + $sale_return + $van_stock_return)."</td>";
                        echo "</tr>";
                    }
                }
                echo "</tbody>";
            }
            // Party ledgers
            else if($option_id === "41"){
                echo "<tbody>";
                $suppliers_table = "asset_2_values";
                $customers_table = "asset_3_values";
                $purchase_table = "entry_5_values";
                $sale_table = "entry_6_values";
                $sale_return_table = "entry_58_values";
                $payment_table = "entry_7_values";
                $reciept_table = "entry_8_values";
                $debit_table = "entry_9_values";
                $credit_table = "entry_10_values";
                $builty_table = "entry_48_values";
    
                $sum_purchase_amount = 0;
                $sum_payment_amount = 0;
                $sum_sale_amount = 0;
                $sum_sale_return_amount = 0;
                $sum_reciept_amount = 0;
                $sum_debit_amount = 0;
                $sum_credit_amount = 0;
                $sum_builty_amount = 0;
                $opening_balance = 0;
                $closing_balance = 0;
                $total_debit_amount = 0;
                $total_credit_amount = 0;
                $sql="SELECT * FROM `$suppliers_table` WHERE `opt_1`='".$_POST['Party']."' AND `added_for`='$business'";
                $result = mysqli_query($local_conn_db, $sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $sql2="SELECT (`opt_13`) as `sum_purchase_amount`, (`opt_23`) as `discount` FROM `$purchase_table` WHERE `opt_1`<'".$_POST['Date']."' AND `opt_15`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                $sum_purchase_amount += ($row2['sum_purchase_amount']-($row2['sum_purchase_amount'] * $row2['discount'] / 100));
                            }
                        }
                        $sql2="SELECT SUM(`opt_5`) as `sum_payment_amount` FROM `$payment_table` WHERE `opt_1`<'".$_POST['Date']."'  AND `opt_6`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                $sum_payment_amount = $row2['sum_payment_amount'];
                            }
                        }
                        $sql2="SELECT SUM(`opt_5`) as `sum_debit_amount` FROM `$debit_table` WHERE `opt_1`<'".$_POST['Date']."' AND `opt_6`='S-".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                $sum_debit_amount = $row2['sum_debit_amount'];
                            }
                        }
                        $sql2="SELECT SUM(`opt_5`) as `sum_credit_amount` FROM `$credit_table` WHERE `opt_1`<'".$_POST['Date']."' AND `opt_6`='S-".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                $sum_credit_amount = $row2['sum_credit_amount'];
                            }
                        }
                        $opening_balance = ($row["opt_8"]+$sum_payment_amount-$sum_purchase_amount+$sum_debit_amount-$sum_credit_amount);
                        echo "<span style='float: right; border: 1px solid black; padding: 5px; border-bottom: none;'><strong>Opening Balance: </strong><label>".($opening_balance)."</label></span>";
                        $start_date = $_POST['Date'];
                        $end_date = $_POST['To'];
                        $closing_balance = $opening_balance;
                        while (strtotime($start_date) <= strtotime($end_date)) {
                            $sum_purchase_amount = 0;
                            $sum_payment_amount = 0;
                            $sum_sale_amount = 0;
                            $sum_sale_return_amount = 0;
                            $sum_reciept_amount = 0;
                            $sum_debit_amount = 0;
                            $sum_credit_amount = 0;
                            $sum_builty_amount = 0;
                            $sql2="SELECT `voucher_no`, (`opt_13`) as `sum_purchase_amount`, (`opt_23`) as `discount` FROM `$purchase_table` WHERE `opt_1`='".$start_date."' AND `opt_15`='".$row["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                $i=0;
                                $old_v_no = "";
                                $v_no = "";
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_purchase_amount'])){
                                        $sum_purchase_amount += ($row2['sum_purchase_amount']-($row2['sum_purchase_amount'] * $row2['discount'] / 100));
                                        if($i===0){
                                            $v_no = $row2["voucher_no"];
                                        }
                                        if($old_v_no !== $v_no){
                                            echo "<tr>";
                                            echo "<td>".$start_date."</td>";
                                            echo "<td>Purchase Invoice</td>";
                                            echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                            echo "<td>Stock purchase from ".$row['opt_1']."</td>";
                                            echo "<td style='text-align: center'>0</td>";
                                            echo "<td style='text-align: center'>".$sum_purchase_amount."</td>";
                                            $closing_balance = ($closing_balance-$sum_purchase_amount);
                                            echo "<td style='text-align: center'>".$closing_balance."</td>";
                                            echo "</tr>";
                                            $sum_purchase_amount = 0;
                                        }
                                        else if($i === mysqli_num_rows ($result2)-1){
                                            echo "<tr>";
                                            echo "<td>".$start_date."</td>";
                                            echo "<td>Purchase Invoice</td>";
                                            echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                            echo "<td>Stock purchase from ".$row['opt_1']."</td>";
                                            echo "<td style='text-align: center'>0</td>";
                                            echo "<td style='text-align: center'>".$sum_purchase_amount."</td>";
                                            $closing_balance = ($closing_balance-$sum_purchase_amount);
                                            echo "<td style='text-align: center'>".$closing_balance."</td>";
                                            echo "</tr>";
                                        }
                                        $i++;
                                        $old_v_no = $v_no;
                                    }
                                }
                            }
                            $sql2="SELECT `voucher_no`, `opt_4` as `remarks`, SUM(`opt_5`) as `sum_payment_amount` FROM `$payment_table` WHERE `opt_1`='".$start_date."' AND `opt_6`='".$row["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                $i=0;
                                $old_v_no = "";
                                $v_no = "";
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_payment_amount'])){
                                        $sum_payment_amount = $row2['sum_payment_amount'];
                                        if($i===0){
                                            $v_no = $row2["voucher_no"];
                                        }
                                        if($old_v_no !== $v_no){
                                            echo "<tr>";
                                            echo "<td>".$start_date."</td>";
                                            echo "<td>Payment</td>";
                                            echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                            echo "<td>".$row2["remarks"]."</td>";
                                            echo "<td style='text-align: center'>".$sum_payment_amount."</td>";
                                            echo "<td style='text-align: center'>0</td>";
                                            $closing_balance = ($closing_balance+$sum_payment_amount);
                                            echo "<td style='text-align: center'>".$closing_balance."</td>";
                                            echo "</tr>";
                                            $sum_payment_amount = 0;
                                        }
                                        else if($i === mysqli_num_rows ($result2)-1){
                                            echo "<tr>";
                                            echo "<td>".$start_date."</td>";
                                            echo "<td>Payment</td>";
                                            echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                            echo "<td>".$row2["remarks"]."</td>";
                                            echo "<td style='text-align: center'>".$sum_payment_amount."</td>";
                                            echo "<td style='text-align: center'>0</td>";
                                            $closing_balance = ($closing_balance+$sum_payment_amount);
                                            echo "<td style='text-align: center'>".$closing_balance."</td>";
                                            echo "</tr>";
                                        }
                                        $i++;
                                        $old_v_no = $v_no;
                                    }
                                }
                            }
                            $sql2="SELECT `voucher_no`, (`opt_2`) as `remarks`, SUM(`opt_5`) as `sum_debit_amount` FROM `$debit_table` WHERE `opt_1`='".$start_date."' AND `opt_6`='S-".$row["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                $i=0;
                                $old_v_no = "";
                                $v_no = "";
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_debit_amount'])){
                                        $sum_debit_amount = $row2['sum_debit_amount'];
                                        if($i===0){
                                            $v_no = $row2["voucher_no"];
                                        }
                                        if($old_v_no !== $v_no){
                                            echo "<tr>";
                                            echo "<td>".$start_date."</td>";
                                            echo "<td >Debit Note</td>";
                                            echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                            echo "<td>".$row2["remarks"]."</td>";
                                            echo "<td style='text-align: center'>".$sum_debit_amount."</td>";
                                            echo "<td style='text-align: center'>0</td>";
                                            $closing_balance = ($closing_balance+$sum_debit_amount);
                                            echo "<td style='text-align: center'>".$closing_balance."</td>";
                                            echo "</tr>";
                                            $sum_debit_amount = 0;
                                        }
                                        else if($i === mysqli_num_rows ($result2)-1){
                                            echo "<tr>";
                                            echo "<td>".$start_date."</td>";
                                            echo "<td >Debit Note</td>";
                                            echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                            echo "<td>".$row2["remarks"]."</td>";
                                            echo "<td style='text-align: center'>".$sum_debit_amount."</td>";
                                            echo "<td style='text-align: center'>0</td>";
                                            $closing_balance = ($closing_balance+$sum_debit_amount);
                                            echo "<td style='text-align: center'>".$closing_balance."</td>";
                                            echo "</tr>";
                                        }
                                        $i++;
                                        $old_v_no = $v_no;
                                    }
                                }
                            }
                            $sql2="SELECT `voucher_no`, (`opt_2`) as `remarks`, SUM(`opt_5`) as `sum_credit_amount` FROM `$credit_table` WHERE `opt_1`='".$start_date."' AND `opt_6`='S-".$row["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_credit_amount'])){
                                        $sum_credit_amount = $row2['sum_credit_amount'];
                                        if($i===0){
                                            $v_no = $row2["voucher_no"];
                                        }
                                        if($old_v_no !== $v_no){
                                            echo "<td>".$start_date."</td>";
                                            echo "<td>Credit Note</td>";
                                            echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";echo "<tr>";
                                            echo "<td>".$row2["remarks"]."</td>";
                                            echo "<td style='text-align: center'>0</td>";
                                            echo "<td style='text-align: center'>".$sum_credit_amount."</td>";
                                            $closing_balance = ($closing_balance-$sum_credit_amount);
                                            echo "<td style='text-align: center'>".$closing_balance."</td>";
                                            echo "</tr>";
                                            $sum_credit_amount = 0;
                                        }
                                        else if($i === mysqli_num_rows ($result2)-1){
                                            echo "<td>".$start_date."</td>";
                                            echo "<td>Credit Note</td>";
                                            echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";echo "<tr>";
                                            echo "<td>".$row2["remarks"]."</td>";
                                            echo "<td style='text-align: center'>0</td>";
                                            echo "<td style='text-align: center'>".$sum_credit_amount."</td>";
                                            $closing_balance = ($closing_balance-$sum_credit_amount);
                                            echo "<td style='text-align: center'>".$closing_balance."</td>";
                                            echo "</tr>";
                                        }
                                        $i++;
                                        $old_v_no = $v_no;
                                    }
                                }
                            }
                            $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                        }
                    }
                }
                else{
                    $sql1="SELECT * FROM `$customers_table` WHERE `opt_1`='".$_POST['Party']."' AND `added_for`='$business'";
                    $result1 = mysqli_query($local_conn_db, $sql1);
                    if($result1->num_rows > 0){
                        while($row1 = $result1->fetch_assoc()){
                            $sql2="SELECT (`opt_17`) as `sum_sale_amount`, (`opt_27`) as `discount` FROM `$sale_table` WHERE `opt_1`<'".$_POST['Date']."' AND `opt_3`='".$row1["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    $sum_sale_amount += ($row2['sum_sale_amount'] - ($row2['sum_sale_amount']*$row2['discount']/100));
                                }
                            }
                            $sql2="SELECT (`opt_17`) as `sum_sale_return_amount`, (`opt_27`) as `discount` FROM `$sale_return_table` WHERE `opt_1`<'".$_POST['Date']."' AND `opt_3`='".$row1["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    $sum_sale_return_amount += ($row2['sum_sale_return_amount'] - ($row2['sum_sale_return_amount']*$row2['discount']/100));
                                }
                            }
                            $sql2="SELECT SUM(`opt_6`) as `sum_reciept_amount` FROM `$reciept_table` WHERE `opt_1`<'".$_POST['Date']."' AND `opt_4`='".$row1["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    $sum_reciept_amount += $row2['sum_reciept_amount'];
                                }
                            }
                            $sql2="SELECT SUM(`opt_5`) as `sum_debit_amount` FROM `$debit_table` WHERE `opt_1`<'".$_POST['Date']."' AND `opt_6`='C-".$row1["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    $sum_debit_amount += $row2['sum_debit_amount'];
                                }
                            }
                            $sql2="SELECT SUM(`opt_5`) as `sum_credit_amount` FROM `$credit_table` WHERE `opt_1`<'".$_POST['Date']."' AND `opt_6`='C-".$row1["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    $sum_credit_amount += $row2['sum_credit_amount'];
                                }
                            }
                            $sql2="SELECT SUM(`opt_17`) as `sum_builty_amount` FROM `$builty_table` WHERE `opt_1`<'".$_POST['Date']."' AND `opt_3`='".$row1["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    $sum_builty_amount += $row2['sum_builty_amount'];
                                }
                            }
                            $opening_balance = ($row1["opt_8"] + $sum_sale_amount - $sum_sale_return_amount - $sum_reciept_amount + $sum_debit_amount - $sum_credit_amount - $sum_builty_amount);
                            echo "<span style='float: right; border: 1px solid black; padding: 5px; border-bottom: none;'><strong>Opening Balance: </strong><label>".($opening_balance)."</label></span>";
                            $start_date = $_POST['Date'];
                            $end_date = $_POST['To'];
                            $closing_balance = $opening_balance;
                            while (strtotime($start_date) <= strtotime($end_date)) {
                                $sum_purchase_amount = 0;
                                $sum_payment_amount = 0;
                                $sum_sale_amount = 0;
                                $sum_sale_return_amount = 0;
                                $sum_reciept_amount = 0;
                                $sum_debit_amount = 0;
                                $sum_credit_amount = 0;
                                $sum_builty_amount = 0;
                                $sql2="SELECT `voucher_no`, (`opt_17`) as `sum_sale_amount`, (`opt_27`) as `discount` FROM `$sale_table` WHERE `opt_1`='".$start_date."' AND `opt_3`='".$row1["id"]."'"." AND `added_for`='$business'";
                                $result2 = mysqli_query($local_conn_db, $sql2);
                                if($result2->num_rows > 0){
                                    $i=0;
                                    $old_v_no = "";
                                    $v_no = "";
                                    while($row2 = $result2->fetch_assoc()){
                                        if(isset($row2['sum_sale_amount'])){
                                            $sum_sale_amount += ($row2['sum_sale_amount'] - ($row2['sum_sale_amount']*$row2['discount']/100));
                                            if($i===0){
                                                $v_no = $row2["voucher_no"];
                                            }
                                            if($old_v_no !== $v_no){
                                                $old_v_no = $v_no;
                                                echo "<tr>";
                                                echo "<td>".$start_date."</td>";
                                                echo "<td>Sale Invoice</td>";
                                                echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                                echo "<td>Stock sold to ".$row1["opt_1"]."</td>";
                                                echo "<td style='text-align: center'>".$sum_sale_amount."</td>";
                                                echo "<td style='text-align: center'>0</td>";
                                                $closing_balance = ($closing_balance+$sum_sale_amount);
                                                echo "<td style='text-align: center'>".$closing_balance."</td>";
                                                echo "</tr>";
                                                $sum_sale_amount = 0;
                                            }
                                            else if($i === mysqli_num_rows ($result2)-1){
                                                echo "<tr>";
                                                echo "<td>".$start_date."</td>";
                                                echo "<td>Sale Invoice</td>";
                                                echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                                echo "<td>Stock sold to ".$row1["opt_1"]."</td>";
                                                echo "<td style='text-align: center'>".$sum_sale_amount."</td>";
                                                echo "<td style='text-align: center'>0</td>";
                                                $closing_balance = ($closing_balance+$sum_sale_amount);
                                                echo "<td style='text-align: center'>".$closing_balance."</td>";
                                                echo "</tr>";
                                            }
                                            $i++;
                                            $v_no = $row2["voucher_no"];
                                        }
                                    }
                                }
                                $sql2="SELECT `voucher_no`, (`opt_17`) as `sum_sale_return_amount`, (`opt_27`) as `discount` FROM `$sale_return_table` WHERE `opt_1`='".$start_date."' AND `opt_3`='".$row1["id"]."'"." AND `added_for`='$business'";
                                $result2 = mysqli_query($local_conn_db, $sql2);
                                if($result2->num_rows > 0){
                                    $i=0;
                                    $old_v_no = "";
                                    $v_no = "";
                                    while($row2 = $result2->fetch_assoc()){
                                        if(isset($row2['sum_sale_return_amount'])){
                                            $sum_sale_return_amount += ($row2['sum_sale_return_amount'] - ($row2['sum_sale_return_amount']*$row2['discount']/100));
                                            if($i===0){
                                                $v_no = $row2["voucher_no"];
                                            }
                                            if($old_v_no !== $v_no){
                                                echo "<tr>";
                                                echo "<td>".$start_date."</td>";
                                                echo "<td>Sale Return</td>";
                                                echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                                echo "<td>Stock return from ".$row1["opt_1"]."</td>";
                                                echo "<td style='text-align: center'>0</td>";
                                                echo "<td style='text-align: center'>".$sum_sale_return_amount."</td>";
                                                $closing_balance = ($closing_balance-$sum_sale_return_amount);
                                                echo "<td style='text-align: center'>".$closing_balance."</td>";
                                                echo "</tr>";
                                                $sum_sale_return_amount = 0;
                                                
                                            }
                                            else if($i === mysqli_num_rows ($result2)-1){
                                                echo "<tr>";
                                                echo "<td>".$start_date."</td>";
                                                echo "<td>Sale Return</td>";
                                                echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                                echo "<td>Stock return from ".$row1["opt_1"]."</td>";
                                                echo "<td style='text-align: center'>0</td>";
                                                echo "<td style='text-align: center'>".$sum_sale_return_amount."</td>";
                                                $closing_balance = ($closing_balance-$sum_sale_return_amount);
                                                echo "<td style='text-align: center'>".$closing_balance."</td>";
                                                echo "</tr>";
                                            }
                                            $i++;
                                            $old_v_no = $v_no;
                                        }
                                    }
                                }
                                $sql2="SELECT `voucher_no`, (`opt_2`) as `remarks`, (`opt_6`) as `sum_reciept_amount` FROM `$reciept_table` WHERE `opt_1`='".$start_date."' AND `opt_4`='".$row1["id"]."'"." AND `added_for`='$business'";
                                $result2 = mysqli_query($local_conn_db, $sql2);
                                if($result2->num_rows > 0){
                                    $i=0;
                                    $old_v_no = "";
                                    $v_no = "";
                                    while($row2 = $result2->fetch_assoc()){
                                        if(isset($row2['sum_reciept_amount'])){
                                            $sum_reciept_amount += $row2['sum_reciept_amount'];
                                            if($i===0){
                                                $v_no = $row2["voucher_no"];
                                            }
                                            if($old_v_no !== $v_no){
                                                echo "<tr>";
                                                echo "<td>".$start_date."</td>";
                                                echo "<td>Reciept</td>";
                                                echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                                echo "<td>".$row2["remarks"]."</td>";
                                                echo "<td style='text-align: center'>0</td>";
                                                echo "<td style='text-align: center'>".$sum_reciept_amount."</td>";
                                                $closing_balance = ($closing_balance-$sum_reciept_amount);
                                                echo "<td style='text-align: center'>".$closing_balance."</td>";
                                                echo "</tr>";
                                                $sum_reciept_amount = 0;
                                            }
                                            else if($i === mysqli_num_rows ($result2)-1){
                                                echo "<tr>";
                                                echo "<td>".$start_date."</td>";
                                                echo "<td>Reciept</td>";
                                                echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                                echo "<td>".$row2["remarks"]."</td>";
                                                echo "<td style='text-align: center'>0</td>";
                                                echo "<td style='text-align: center'>".$sum_reciept_amount."</td>";
                                                $closing_balance = ($closing_balance-$sum_reciept_amount);
                                                echo "<td style='text-align: center'>".$closing_balance."</td>";
                                                echo "</tr>";
                                            }
                                            $i++;
                                            $old_v_no = $v_no;
                                        }
                                    }
                                }
                                $sql2="SELECT `voucher_no`, (`opt_2`) as `remarks`, (`opt_5`) as `sum_debit_amount` FROM `$debit_table` WHERE `opt_1`='".$start_date."' AND `opt_6`='C-".$row1["id"]."'"." AND `added_for`='$business'";
                                $result2 = mysqli_query($local_conn_db, $sql2);
                                if($result2->num_rows > 0){
                                    $i=0;
                                    $old_v_no = "";
                                    $v_no = "";
                                    while($row2 = $result2->fetch_assoc()){
                                        if(isset($row2['sum_debit_amount'])){
                                            $sum_debit_amount += $row2['sum_debit_amount'];
                                            if($i===0){
                                                $v_no = $row2["voucher_no"];
                                            }
                                            if($old_v_no !== $v_no){
                                                echo "<tr>";
                                                echo "<td>".$start_date."</td>";
                                                echo "<td>Debit Note</td>";
                                                echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                                echo "<td>".$row2["remarks"]."</td>";
                                                echo "<td style='text-align: center'>".$sum_debit_amount."</td>";
                                                echo "<td style='text-align: center'>0</td>";
                                                $closing_balance = ($closing_balance+$sum_debit_amount);
                                                echo "<td style='text-align: center'>".$closing_balance."</td>";
                                                echo "</tr>";
                                                $sum_debit_amount = 0;
                                            }
                                            else if($i === mysqli_num_rows ($result2)-1){
                                                echo "<tr>";
                                                echo "<td>".$start_date."</td>";
                                                echo "<td>Debit Note</td>";
                                                echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                                echo "<td>".$row2["remarks"]."</td>";
                                                echo "<td style='text-align: center'>".$sum_debit_amount."</td>";
                                                echo "<td style='text-align: center'>0</td>";
                                                $closing_balance = ($closing_balance+$sum_debit_amount);
                                                echo "<td style='text-align: center'>".$closing_balance."</td>";
                                                echo "</tr>";
                                            }
                                            $i++;
                                            $old_v_no = $v_no;
                                        }
                                    }
                                }
                                $sql2="SELECT `voucher_no`, (`opt_2`) as `remarks`, (`opt_5`) as `sum_credit_amount` FROM `$credit_table` WHERE `opt_1`='".$start_date."' AND `opt_6`='C-".$row1["id"]."'"." AND `added_for`='$business'";
                                $result2 = mysqli_query($local_conn_db, $sql2);
                                if($result2->num_rows > 0){
                                    $i=0;
                                    $old_v_no = "";
                                    $v_no = "";
                                    while($row2 = $result2->fetch_assoc()){
                                        if(isset($row2['sum_credit_amount'])){
                                            $sum_credit_amount += $row2['sum_credit_amount'];
                                            if($i===0){
                                                $v_no = $row2["voucher_no"];
                                            }
                                            if($old_v_no !== $v_no){
                                                echo "<tr>";
                                                echo "<td>".$start_date."</td>";
                                                echo "<td>Credit Note</td>";
                                                echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                                echo "<td>".$row2["remarks"]."</td>";
                                                echo "<td style='text-align: center'>0</td>";
                                                echo "<td style='text-align: center'>".$sum_credit_amount."</td>";
                                                $closing_balance = ($closing_balance-$sum_credit_amount);
                                                echo "<td style='text-align: center'>".$closing_balance."</td>";
                                                echo "</tr>";
                                                $sum_credit_amount = 0;
                                            }
                                            else if($i === mysqli_num_rows ($result2)-1){
                                                echo "<tr>";
                                                echo "<td>".$start_date."</td>";
                                                echo "<td>Credit Note</td>";
                                                echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                                echo "<td>".$row2["remarks"]."</td>";
                                                echo "<td style='text-align: center'>0</td>";
                                                echo "<td style='text-align: center'>".$sum_credit_amount."</td>";
                                                $closing_balance = ($closing_balance-$sum_credit_amount);
                                                echo "<td style='text-align: center'>".$closing_balance."</td>";
                                                echo "</tr>";
                                            }
                                            $i++;
                                            $old_v_no = $v_no;
                                        }
                                    }
                                }
                                $sql2="SELECT `voucher_no`, (`opt_17`) as `sum_builty_amount` FROM `$builty_table` WHERE `opt_1`='".$start_date."' AND `opt_3`='".$row1["id"]."'"." AND `added_for`='$business'";
                                $result2 = mysqli_query($local_conn_db, $sql2);
                                if($result2->num_rows > 0){
                                    $i=0;
                                    $old_v_no = "";
                                    $v_no = "";
                                    while($row2 = $result2->fetch_assoc()){
                                        if(isset($row2['sum_builty_amount'])){
                                            $sum_builty_amount += $row2['sum_builty_amount'];
                                            if($i===0){
                                                $v_no = $row2["voucher_no"];
                                            }
                                            if($old_v_no !== $v_no){
                                                echo "<tr>";
                                                echo "<td>".$start_date."</td>";
                                                echo "<td>Builty</td>";
                                                echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                                echo "<td>Stock deliver through builty</td>";
                                                echo "<td style='text-align: center'>0</td>";
                                                echo "<td style='text-align: center'>".$sum_builty_amount."</td>";
                                                $closing_balance = ($closing_balance-$sum_builty_amount);
                                                echo "<td style='text-align: center'>".$closing_balance."</td>";
                                                echo "</tr>";
                                                $sum_builty_amount = 0;
                                            }
                                            else if($i === mysqli_num_rows ($result2)-1){
                                                echo "<tr>";
                                                echo "<td>".$start_date."</td>";
                                                echo "<td>Builty</td>";
                                                echo "<td style='text-align: center'>".$row2["voucher_no"]."</td>";
                                                echo "<td>Stock deliver through builty</td>";
                                                echo "<td style='text-align: center'>0</td>";
                                                echo "<td style='text-align: center'>".$sum_builty_amount."</td>";
                                                $closing_balance = ($closing_balance-$sum_builty_amount);
                                                echo "<td style='text-align: center'>".$closing_balance."</td>";
                                                echo "</tr>";
                                            }
                                            $i++;
                                            $old_v_no = $v_no;
                                        }
                                    }
                                }
                                $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                            }
                        }
                    }
                    else{
                        echo "<tr><td><strong style='color: red; font-size: 20px;'>No Party Selected</strong></td></tr>";
                    }    
                }
                echo "</tbody>";
            }
            // Pending purahcase order
            else if($option_id === "46"){
                $products_table = "asset_4_values";
                $purchase_order_table = "entry_42_values";
                $purchase_table = "entry_5_values";
                $opening_purchase = 0;
                $opening_sale = 0;
                $purchase = 0;
                $sale = 0;
                $closing_purchase = 0;
                $closing_sale = 0;
                echo "<tbody>";
                $filters = substr_replace($filters, "", 7, 49);
                $sql="SELECT * FROM `$products_table`".$filters." AND `added_for`='$business'";
                $result = mysqli_query($local_conn_db, $sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".$row["opt_1"]."</td>";
                        $sql1="SELECT SUM(`opt_12`) as `opening_purchase` FROM `$purchase_order_table` WHERE `opt_1` < '".$_POST["Date"]."' AND `opt_5`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $opening_purchase = floatval($row1["opening_purchase"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_12`) as `opening_sale` FROM `$purchase_table` WHERE `opt_1` < '".$_POST["Date"]."' AND `opt_5`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $opening_sale = floatval($row1["opening_sale"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_12`) as `opening_purchase` FROM `$purchase_order_table` WHERE `opt_1` BETWEEN '".$_POST["Date"]."' AND '".$_POST["To"]."' AND `opt_5`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $purchase = floatval($row1["opening_purchase"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_12`) as `opening_sale` FROM `$purchase_table` WHERE `opt_1` BETWEEN '".$_POST["Date"]."' AND '".$_POST["To"]."' AND `opt_5`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $sale = floatval($row1["opening_sale"]);
                            }
                        }
                        echo "<td style='text-align: center;'>".($opening_purchase - $opening_sale)."</td>";
                        echo "<td style='text-align: center;'>".($purchase)."</td>";
                        echo "<td style='text-align: center;'>".($sale)."</td>";
                        echo "<td style='text-align: center;'>".($opening_purchase - $opening_sale + $purchase - $sale)."</td>";
                        echo "</tr>";
                    }
                }
                echo "</tbody>";
            }
            // Pending sale order
            else if($option_id === "47"){
                $products_table = "asset_4_values";
                $purchase_order_table = "entry_43_values";
                $purchase_table = "entry_6_values";
                $opening_purchase = 0;
                $opening_sale = 0;
                $purchase = 0;
                $sale = 0;
                $closing_purchase = 0;
                $closing_sale = 0;
                echo "<tbody>";
                $filters = substr_replace($filters, "", 7, 49);
                $sql="SELECT * FROM `$products_table`".$filters." AND `added_for`='$business'";
                $result = mysqli_query($local_conn_db, $sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".$row["opt_1"]."</td>";
                        $sql1="SELECT SUM(`opt_16`) as `opening_purchase` FROM `$purchase_order_table` WHERE `opt_1` < '".$_POST["Date"]."' AND `opt_9`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $opening_purchase = floatval($row1["opening_purchase"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_16`) as `opening_sale` FROM `$purchase_table` WHERE `opt_1` < '".$_POST["Date"]."' AND `opt_9`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $opening_sale = floatval($row1["opening_sale"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_16`) as `opening_purchase` FROM `$purchase_order_table` WHERE `opt_1` BETWEEN '".$_POST["Date"]."' AND '".$_POST["To"]."' AND `opt_9`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $purchase = floatval($row1["opening_purchase"]);
                            }
                        }
                        $sql1="SELECT SUM(`opt_16`) as `opening_sale` FROM `$purchase_table` WHERE `opt_1` BETWEEN '".$_POST["Date"]."' AND '".$_POST["To"]."' AND `opt_9`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result1 = mysqli_query($local_conn_db, $sql1);
                        if($result1->num_rows > 0){
                            while($row1 = $result1->fetch_assoc()){
                                $sale = floatval($row1["opening_sale"]);
                            }
                        }
                        echo "<td style='text-align: center;'>".($opening_purchase - $opening_sale)."</td>";
                        echo "<td style='text-align: center;'>".($purchase)."</td>";
                        echo "<td style='text-align: center;'>".($sale)."</td>";
                        echo "<td style='text-align: center;'>".($opening_purchase - $opening_sale + $purchase - $sale)."</td>";
                        echo "</tr>";
                    }
                }
                echo "</tbody>";
            }
            // Acounts ledgers
            else if($option_id === "55"){
                echo "<tbody>";
                $accounts_table = "asset_49_values";
                $cash_deposit_table = "entry_50_values";
                $cash_withdrawal_table = "entry_51_values";
                $payment_table = "entry_7_values";
                $expense_table = "entry_14_values";
                $salary_table = "entry_17_values";
                $debit_table = "entry_9_values";
                $credit_table = "entry_10_values";
    
                $sum_cash_deposit_amount = 0;
                $sum_cash_withdrawal_amount = 0;
                $sum_debit_amount = 0;
                $sum_payment_amount = 0;
                $sum_expense_amount = 0;
                $sum_salary_amount = 0;
                $sum_credit_amount = 0;
                $opening_balance = 0;
                $closing_balance = 0;
                $total_debit_amount = 0;
                $total_credit_amount = 0;
                $sql="SELECT * FROM `$accounts_table` WHERE `opt_1`='".$_POST['Account']."'"." AND `added_for`='$business'";
                $result = mysqli_query($local_conn_db, $sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $sql2="SELECT SUM(`opt_5`) as `sum_cash_deposit_amount` FROM `$cash_deposit_table` WHERE `opt_1`<'".$_POST['Date']."' AND `opt_3`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                $sum_cash_deposit_amount = $row2['sum_cash_deposit_amount'];
                            }
                        }
                        $sql2="SELECT SUM(`opt_5`) as `sum_cash_withdrawal_amount` FROM `$cash_withdrawal_table` WHERE `opt_1`<'".$_POST['Date']."'  AND `opt_3`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                $sum_cash_withdrawal_amount = $row2['sum_cash_withdrawal_amount'];
                            }
                        }
                        $sql2="SELECT SUM(`opt_5`) as `sum_debit_amount` FROM `$debit_table` WHERE `opt_1`<'".$_POST['Date']."' AND `opt_6`='A-".$row1["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                $sum_debit_amount = $row2['sum_debit_amount'];
                            }
                        }
                        $sql2="SELECT SUM(`opt_5`) as `sum_credit_amount` FROM `$credit_table` WHERE `opt_1`<'".$_POST['Date']."' AND `opt_6`='A-".$row1["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                $sum_credit_amount = $row2['sum_credit_amount'];
                            }
                        }
                        $sql2="SELECT SUM(`opt_5`) as `sum_payment_amount` FROM `$payment_table` WHERE `opt_1`<'".$_POST['Date']."' AND `opt_7`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_payment_amount'])){
                                        $sum_payment_amount += $row2['sum_payment_amount'];
                                    }
                            }
                        }
                        $sql2="SELECT SUM(`opt_3`) as `sum_expense_amount` FROM `$expense_table` WHERE `opt_1`<'".$_POST['Date']."' AND `opt_4`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_expense_amount'])){
                                        $sum_expense_amount += $row2['sum_expense_amount'];
                                    }
                                }
                        }
                        $sql2="SELECT SUM(`opt_6`) as `sum_salary_amount` FROM `$salary_table` WHERE `opt_1`<'".$_POST['Date']."' AND `opt_7`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_salary_amount'])){
                                        $sum_salary_amount += $row2['sum_salary_amount'];
                                    }
                                }
                        }
                        $opening_balance = ($row["opt_8"]+$sum_debit_amount+$sum_cash_deposit_amount-$sum_cash_withdrawal_amount-$sum_credit_amount-$sum_payment_amount-$sum_expense_amount-$sum_salary_amount);
                        echo "<span style='float: right; border: 1px solid black; padding: 5px; border-bottom: none;'><strong>Opening Balance: </strong><label>".($opening_balance)."</label></span>";
                        $start_date = $_POST['Date'];
                        $end_date = $_POST['To'];
                        $closing_balance = $opening_balance;
                        while (strtotime($start_date) <= strtotime($end_date)) {
                            $sql2="SELECT SUM(`opt_5`) as `sum_cash_deposit_amount` FROM `$cash_deposit_table` WHERE `opt_1`='".$start_date."' AND `opt_3`='".$row["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_cash_deposit_amount'])){
                                        $sum_cash_deposit_amount = $row2['sum_cash_deposit_amount'];
                                        echo "<tr>";
                                        echo "<td>".$start_date."</td>";
                                        echo "<td>Cash Deposit</td>";
                                        echo "<td>Cash deposit to ".$row['opt_1']."</td>";
                                        echo "<td style='text-align: center'>".$sum_cash_deposit_amount."</td>";
                                        echo "<td style='text-align: center'>0</td>";
                                        $closing_balance = ($closing_balance+$sum_cash_deposit_amount);
                                        echo "<td style='text-align: center'>".$closing_balance."</td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                            $sql2="SELECT SUM(`opt_5`) as `sum_cash_withdrawal_amount` FROM `$cash_withdrawal_table` WHERE `opt_1`='".$start_date."' AND `opt_3`='".$row["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_cash_withdrawal_amount'])){
                                        $sum_cash_withdrawal_amount = $row2['sum_cash_withdrawal_amount'];
                                        echo "<tr>";
                                        echo "<td>".$start_date."</td>";
                                        echo "<td>Cash Withdrawal</td>";
                                        echo "<td>Cash withdrawal from ".$row["opt_1"]."</td>";
                                        echo "<td style='text-align: center'>0</td>";
                                        echo "<td style='text-align: center'>".$sum_cash_withdrawal_amount."</td>";
                                        $closing_balance = ($closing_balance-$sum_cash_withdrawal_amount);
                                        echo "<td style='text-align: center'>".$closing_balance."</td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                            $sql2="SELECT (`opt_2`) as `remarks`, SUM(`opt_5`) as `sum_debit_amount` FROM `$debit_table` WHERE `opt_1`='".$start_date."' AND `opt_6`='A-".$row1["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_debit_amount'])){
                                        $sum_debit_amount = $row2['sum_debit_amount'];
                                        echo "<tr>";
                                        echo "<td>".$start_date."</td>";
                                        echo "<td>Debit Note</td>";
                                        echo "<td>".$row2["remarks"]."</td>";
                                        echo "<td style='text-align: center'>".$sum_debit_amount."</td>";
                                        echo "<td style='text-align: center'>0</td>";
                                        $closing_balance = ($closing_balance+$sum_debit_amount);
                                        echo "<td style='text-align: center'>".$closing_balance."</td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                            $sql2="SELECT (`opt_2`) as `remarks`, SUM(`opt_5`) as `sum_credit_amount` FROM `$credit_table` WHERE `opt_1`='".$start_date."' AND `opt_6`='A-".$row1["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_credit_amount'])){
                                        $sum_credit_amount = $row2['sum_credit_amount'];
                                        echo "<tr>";
                                        echo "<td>".$start_date."</td>";
                                        echo "<td>Credit Note</td>";
                                        echo "<td>".$row2["remarks"]."</td>";
                                        echo "<td style='text-align: center'>0</td>";
                                        echo "<td style='text-align: center'>".$sum_credit_amount."</td>";
                                        $closing_balance = ($closing_balance-$sum_credit_amount);
                                        echo "<td style='text-align: center'>".$closing_balance."</td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                            $sql2="SELECT SUM(`opt_5`) as `sum_payment_amount`, `opt_4` as remarks FROM `$payment_table` WHERE `opt_1`='".$start_date."' AND `opt_7`='".$row["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_payment_amount'])){
                                        $sum_payment_amount = $row2['sum_payment_amount'];
                                        echo "<tr>";
                                        echo "<td>".$start_date."</td>";
                                        echo "<td>Payment</td>";
                                        echo "<td>".$row2["remarks"]."</td>";
                                        echo "<td style='text-align: center'>0</td>";
                                        echo "<td style='text-align: center'>".$sum_payment_amount."</td>";
                                        $closing_balance = ($closing_balance-$sum_payment_amount);
                                        echo "<td style='text-align: center'>".$closing_balance."</td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                            $sql2="SELECT SUM(`opt_3`) as `sum_expense_amount` FROM `$expense_table` WHERE `opt_1`='".$start_date."' AND `opt_4`='".$row["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_expense_amount'])){
                                        $sum_expense_amount = $row2['sum_expense_amount'];
                                        echo "<tr>";
                                        echo "<td>".$start_date."</td>";
                                        echo "<td>Expense</td>";
                                        echo "<td>Expenses of the day</td>";
                                        echo "<td style='text-align: center'>0</td>";
                                        echo "<td style='text-align: center'>".$sum_expense_amount."</td>";
                                        $closing_balance = ($closing_balance-$sum_expense_amount);
                                        echo "<td style='text-align: center'>".$closing_balance."</td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                            $sql2="SELECT SUM(`opt_6`) as `sum_salary_amount` FROM `$salary_table` WHERE `opt_1`='".$start_date."' AND `opt_7`='".$row["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_salary_amount'])){
                                        $sum_salary_amount = $row2['sum_salary_amount'];
                                        echo "<tr>";
                                        echo "<td>".$start_date."</td>";
                                        echo "<td>Salary</td>";
                                        echo "<td>Paid salary of employees</td>";
                                        echo "<td style='text-align: center'>0</td>";
                                        echo "<td style='text-align: center'>".$sum_salary_amount."</td>";
                                        $closing_balance = ($closing_balance-$sum_salary_amount);
                                        echo "<td style='text-align: center'>".$closing_balance."</td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                            $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                        }
                    }
                }
                echo "</tbody>";
            }
            // Profit/Loss report
            else if($option_id === "56"){
                echo "<tbody>";
                $start_date = $_POST['Date'];
                $end_date = $_POST['To'];
    
                $products_table = "asset_4_values";
                $purchase_table = "entry_5_values";
                $sale_table = "entry_6_values";
                $expense_table = "entry_14_values";
                $builty_table = "entry_48_values";
                $salary_table = "entry_17_values";
    
                $total_purchase_amount = 0;
                $total_sale_amount = 0;
                $total_expense_amount = 0;
                $total_builty_amount = 0;
                $total_salary_amount = 0;
                $total_profitloss_amount = 0;
    
                while (strtotime($start_date) <= strtotime($end_date)) {
                    $sum_purchase_amount = 0;
                    $sum_sale_amount = 0;
                    $sum_expense_amount = 0;
                    $sum_builty_amount = 0;
                    $sum_salary_amount = 0;
    
                    echo "<tr>";
                    echo "<td>".$start_date."</td>";
                    $sql2="SELECT * FROM `$products_table` WHERE `added_for`='$business'";
                    $result2 = mysqli_query($local_conn_db, $sql2);
                    if($result2->num_rows > 0){
                        while($row2 = $result2->fetch_assoc()){
                            $price = 0;
                            $sum_price = 0;
                            // $sum_purchase_amount = 0;
                            $sql3="SELECT * FROM `$purchase_table` WHERE `opt_5`='".$row2['id']."'"." AND `added_for`='$business'";
                            $result3 = mysqli_query($local_conn_db, $sql3);
                            if($result3->num_rows > 0){
                                $i=0;
                                while($row3 = $result3->fetch_assoc()){
                                    // echo (($row3["opt_13"])-($row3["opt_13"]*$row3["opt_23"]/100))."<br>";
                                    $price = ((($row3["opt_13"])-($row3["opt_13"]*$row3["opt_23"]/100))/$row3["opt_12"]);
                                    $sum_price += $price;
                                    $i++;
                                }
                            }
                            $avg_price = $sum_price/$i;
                            $sql3="SELECT * FROM `$sale_table` WHERE `opt_1`='".$start_date."' AND `opt_9`='".$row2['id']."'"." AND `added_for`='$business'";
                            $result3 = mysqli_query($local_conn_db, $sql3);
                            if($result3->num_rows > 0){
                                while($row3 = $result3->fetch_assoc()){
                                    $amount = ($row3["opt_16"]*$avg_price);
                                    $sum_purchase_amount += $amount;
                                }
                            }                        
                        }
                    }
                    echo "<td style='text-align: center'>".$sum_purchase_amount."</td>";
                    $sql2="SELECT `opt_17` as `sum_sale_amount`, `opt_27` as `discount` FROM `$sale_table` WHERE `opt_1`='".$start_date."'"." AND `added_for`='$business'";
                    $result2 = mysqli_query($local_conn_db, $sql2);
                    if($result2->num_rows > 0){
                        while($row2 = $result2->fetch_assoc()){
                            if(isset($row2['sum_sale_amount'])){
                                $sum_sale_amount += (($row2['sum_sale_amount'])-($row2['sum_sale_amount']*$row2['discount']/100));
                            }
                            // else{
                            //     $sum_sale_amount += 0;
                            // }
                        }
                    }
                    echo "<td style='text-align: center'>".$sum_sale_amount."</td>";
                    $sql2="SELECT SUM(`opt_3`) as `sum_expense_amount` FROM `$expense_table` WHERE `opt_1`='".$start_date."'"." AND `added_for`='$business'";
                    $result2 = mysqli_query($local_conn_db, $sql2);
                    if($result2->num_rows > 0){
                        while($row2 = $result2->fetch_assoc()){
                            if(isset($row2['sum_expense_amount'])){
                                $sum_expense_amount += ($row2['sum_expense_amount']);
                            }
                            // else{
                            //     $sum_expense_amount += 0;
                            // }
                        }
                    }
                    echo "<td style='text-align: center'>".$sum_expense_amount."</td>";
                    $sql2="SELECT SUM(`opt_7`) as `sum_builty_amount` FROM `$builty_table` WHERE `opt_1`='".$start_date."'"." AND `added_for`='$business'";
                    $result2 = mysqli_query($local_conn_db, $sql2);
                    if($result2->num_rows > 0){
                        while($row2 = $result2->fetch_assoc()){
                            if(isset($row2['sum_builty_amount'])){
                                $sum_builty_amount += ($row2['sum_builty_amount']);
                            }
                            // else{
                            //     $sum_builty_amount += 0;
                            // }
                        }
                    }
                    echo "<td style='text-align: center'>".$sum_builty_amount."</td>";
                    $sql2="SELECT SUM(`opt_6`) as `sum_salary_amount` FROM `$salary_table` WHERE `opt_1`='".$start_date."'"." AND `added_for`='$business'";
                    $result2 = mysqli_query($local_conn_db, $sql2);
                    if($result2->num_rows > 0){
                        while($row2 = $result2->fetch_assoc()){
                            if(isset($row2['sum_salary_amount'])){
                                $sum_salary_amount += ($row2['sum_salary_amount']);
                            }
                            // else{
                            //     $sum_salary_amount += 0;
                            // }
                        }
                    }
                    echo "<td style='text-align: center'>".$sum_salary_amount."</td>";
                    
                    $total_purchase_amount += $sum_purchase_amount;
                    $total_sale_amount += $sum_sale_amount;
                    $total_expense_amount += $sum_expense_amount;
                    $total_builty_amount += $sum_builty_amount;
                    $total_salary_amount += $sum_salary_amount;
                    $total_profitloss_amount += ($sum_sale_amount-$sum_purchase_amount-$sum_expense_amount-$sum_builty_amount-$sum_salary_amount);
                    echo "<td style='text-align: center'>".($sum_sale_amount-$sum_purchase_amount-$sum_expense_amount-$sum_builty_amount-$sum_salary_amount)."</td>";
                    echo "</tr>";
                    $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                }
                echo "</tbody>";
                echo "</table>";
                echo "<br>";
                echo "<table id='foot_table'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Total Purchase</th>";
                echo "<th>Total Sale</th>";
                echo "<th>Total Expense</th>";
                echo "<th>Total Builty</th>";
                echo "<th>Total Salary</th>";
                echo "<th>Total Profit/Loss</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                echo "<tr>";
                echo "<td style='text-align: center'>".$total_purchase_amount."</td>";
                echo "<td style='text-align: center'>".$total_sale_amount."</td>";
                echo "<td style='text-align: center'>".$total_expense_amount."</td>";
                echo "<td style='text-align: center'>".$total_builty_amount."</td>";
                echo "<td style='text-align: center'>".$total_salary_amount."</td>";
                echo "<td style='text-align: center'>".$total_profitloss_amount."</td>";
                echo "</tr>";
                echo "</tbody>";
                echo "</table>";
            }
            // Trial Balance
            else if($option_id === "60"){
                echo "<tbody>";
                $suppliers_table = "asset_2_values";
                $customers_table = "asset_3_values";
                $purchase_table = "entry_5_values";
                $sale_table = "entry_6_values";
                $sale_return_table = "entry_58_values";
                $payment_table = "entry_7_values";
                $reciept_table = "entry_8_values";
                $debit_table = "entry_9_values";
                $credit_table = "entry_10_values";
                $builty_table = "entry_48_values";

                $total_opening_amount = 0;
                $total_debit_amount = 0;
                $total_credit_amount = 0;
                $total_closing_amount = 0;

                $sql="SELECT * FROM `$suppliers_table` WHERE `added_for`='$business'";
                $result = mysqli_query($local_conn_db, $sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $sum_purchase_amount = 0;
                        $sum_sale_amount = 0;
                        $sum_payment_amount = 0;
                        $sum_reciept_amount = 0;
                        $sum_debit_amount = 0;
                        $sum_credit_amount = 0;
                        $sum_builty_amount = 0;
                        $opening_balance = 0;
                        $closing_balance = 0;
                        $start_date = $_POST['Date'];
                        $end_date = $_POST['To'];


                        $sql2="SELECT (`opt_13`) as `sum_purchase_amount`, (`opt_23`) as `discount` FROM `$purchase_table` WHERE `opt_1`<'".$start_date."' AND `opt_15`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_purchase_amount'])){
                                    $sum_purchase_amount += ($row2['sum_purchase_amount']-($row2['sum_purchase_amount'] * $row2['discount'] / 100));
                                }
                            }
                        }
                        $sql2="SELECT `opt_4` as `remarks`, SUM(`opt_5`) as `sum_payment_amount` FROM `$payment_table` WHERE `opt_1`<'".$start_date."' AND `opt_6`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_payment_amount'])){
                                    $sum_payment_amount += $row2['sum_payment_amount'];
                                }
                            }
                        }
                        $sql2="SELECT (`opt_2`) as `remarks`, SUM(`opt_5`) as `sum_debit_amount` FROM `$debit_table` WHERE `opt_1`<'".$start_date."' AND `opt_6`='S-".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_debit_amount'])){
                                    $sum_debit_amount += $row2['sum_debit_amount'];
                                }
                            }
                        }
                        $sql2="SELECT (`opt_2`) as `remarks`, SUM(`opt_5`) as `sum_credit_amount` FROM `$credit_table` WHERE `opt_1`<'".$start_date."' AND `opt_6`='S-".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_credit_amount'])){
                                    $sum_credit_amount += $row2['sum_credit_amount'];
                                }
                            }
                        }
                        $debit = ($sum_debit_amount+$sum_payment_amount);
                        $credit = ($sum_credit_amount+$sum_purchase_amount);
                        $opening_balance = ($row["opt_8"] + $debit - $credit);
                        $sum_purchase_amount = 0;
                        $sum_sale_amount = 0;
                        $sum_payment_amount = 0;
                        $sum_reciept_amount = 0;
                        $sum_debit_amount = 0;
                        $sum_credit_amount = 0;
                        $sum_builty_amount = 0;
                        // while (strtotime($start_date) <= strtotime($end_date)) {
                            $sql2="SELECT (`opt_13`) as `sum_purchase_amount`, (`opt_23`) as `discount` FROM `$purchase_table` WHERE `opt_1` BETWEEN '".$start_date."' AND '".$end_date."' AND `opt_15`='".$row["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_purchase_amount'])){
                                        $sum_purchase_amount += ($row2['sum_purchase_amount']-($row2['sum_purchase_amount'] * $row2['discount'] / 100));
                                    }
                                }
                            }
                            $sql2="SELECT `opt_4` as `remarks`, SUM(`opt_5`) as `sum_payment_amount` FROM `$payment_table` WHERE `opt_1` BETWEEN '".$start_date."' AND '".$end_date."' AND `opt_6`='".$row["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_payment_amount'])){
                                        $sum_payment_amount += $row2['sum_payment_amount'];
                                    }
                                }
                            }
                            $sql2="SELECT (`opt_2`) as `remarks`, SUM(`opt_5`) as `sum_debit_amount` FROM `$debit_table` WHERE `opt_1` BETWEEN '".$start_date."' AND '".$end_date."' AND `opt_6`='S-".$row["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_debit_amount'])){
                                        $sum_debit_amount += $row2['sum_debit_amount'];
                                    }
                                }
                            }
                            $sql2="SELECT (`opt_2`) as `remarks`, SUM(`opt_5`) as `sum_credit_amount` FROM `$credit_table` WHERE `opt_1` BETWEEN '".$start_date."' AND '".$end_date."' AND `opt_6`='S-".$row["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_credit_amount'])){
                                        $sum_credit_amount += $row2['sum_credit_amount'];
                                    }
                                }
                            }
                            // $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                        // }

                        $debit = ($sum_debit_amount+$sum_payment_amount);
                        $credit = ($sum_credit_amount+$sum_purchase_amount);
                        $closing_balance = ($opening_balance + $debit - $credit);
                        $total_opening_amount += $opening_balance;
                        $total_debit_amount += $debit;
                        $total_credit_amount += $credit;
                        $total_closing_amount += $closing_balance;
                        echo "<tr>";
                        echo "<td>".$row['opt_1']."</td>";
                        echo "<td style='text-align: center'>".$opening_balance."</td>";
                        echo "<td style='text-align: center'>".$debit."</td>";
                        echo "<td style='text-align: center'>".$credit."</td>";
                        echo "<td style='text-align: center'>".$closing_balance."</td>";
                        echo "</tr>";
                    }
                }
                $sql1="SELECT * FROM `$customers_table` WHERE `added_for`='$business'";
                $result1 = mysqli_query($local_conn_db, $sql1);
                if($result1->num_rows > 0){
                    while($row1 = $result1->fetch_assoc()){
                        $sum_purchase_amount = 0;
                        $sum_sale_amount = 0;
                        $sum_sale_return_amount = 0;
                        $sum_payment_amount = 0;
                        $sum_reciept_amount = 0;
                        $sum_debit_amount = 0;
                        $sum_credit_amount = 0;
                        $sum_builty_amount = 0;
                        $opening_balance = 0;
                        $closing_balance = 0;
                        $start_date = $_POST['Date'];
                        $end_date = $_POST['To'];
                        $sql2="SELECT (`opt_17`) as `sum_sale_amount`, (`opt_27`) as `discount` FROM `$sale_table` WHERE `opt_1`<'".$start_date."' AND `opt_3`='".$row1["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_sale_amount'])){
                                    $sum_sale_amount += ($row2['sum_sale_amount'] - ($row2['sum_sale_amount']*$row2['discount']/100));
                                }
                            }
                        }
                        $sql2="SELECT (`opt_17`) as `sum_sale_return_amount`, (`opt_27`) as `discount` FROM `$sale_return_table` WHERE `opt_1`<'".$start_date."' AND `opt_3`='".$row1["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_sale_return_amount'])){
                                    $sum_sale_return_amount += ($row2['sum_sale_return_amount'] - ($row2['sum_sale_return_amount']*$row2['discount']/100));
                                }
                            }
                        }
                        $sql2="SELECT (`opt_2`) as `remarks`, SUM(`opt_6`) as `sum_reciept_amount` FROM `$reciept_table` WHERE `opt_1`<'".$start_date."' AND `opt_4`='".$row1["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_reciept_amount'])){
                                    $sum_reciept_amount += $row2['sum_reciept_amount'];
                                }
                            }
                        }
                        $sql2="SELECT (`opt_2`) as `remarks`, SUM(`opt_5`) as `sum_debit_amount` FROM `$debit_table` WHERE `opt_1`<'".$start_date."' AND `opt_6`='C-".$row1["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_debit_amount'])){
                                    $sum_debit_amount += $row2['sum_debit_amount'];
                                }
                            }
                        }
                        $sql2="SELECT (`opt_2`) as `remarks`, SUM(`opt_5`) as `sum_credit_amount` FROM `$credit_table` WHERE `opt_1`<'".$start_date."' AND `opt_6`='C-".$row1["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_credit_amount'])){
                                    $sum_credit_amount += $row2['sum_credit_amount'];
                                }
                            }
                        }
                        $sql2="SELECT SUM(`opt_17`) as `sum_builty_amount` FROM `$builty_table` WHERE `opt_1`<'".$start_date."' AND `opt_3`='".$row1["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_builty_amount'])){
                                    $sum_builty_amount += $row2['sum_builty_amount'];
                                }
                            }
                        }
                        $debit = ($sum_debit_amount+$sum_sale_amount);
                        $credit = ($sum_sale_return_amount+$sum_credit_amount+$sum_reciept_amount+$sum_builty_amount);
                        $opening_balance = ($row["opt_8"] + $debit - $credit);
                        $sum_purchase_amount = 0;
                        $sum_sale_amount = 0;
                        $sum_payment_amount = 0;
                        $sum_reciept_amount = 0;
                        $sum_debit_amount = 0;
                        $sum_credit_amount = 0;
                        $sum_builty_amount = 0;


                        // while (strtotime($start_date) <= strtotime($end_date)) {
                            $sql2="SELECT (`opt_17`) as `sum_sale_amount`, (`opt_27`) as `discount` FROM `$sale_table` WHERE `opt_1` BETWEEN '".$start_date."' AND '".$end_date."' AND `opt_3`='".$row1["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_sale_amount'])){
                                        $sum_sale_amount += ($row2['sum_sale_amount'] - ($row2['sum_sale_amount']*$row2['discount']/100));
                                    }
                                }
                            }
                            $sql2="SELECT (`opt_17`) as `sum_sale_return_amount`, (`opt_27`) as `discount` FROM `$sale_return_table` WHERE `opt_1` BETWEEN '".$start_date."' AND '".$end_date."' AND `opt_3`='".$row1["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_sale_return_amount'])){
                                        $sum_sale_return_amount += ($row2['sum_sale_return_amount'] - ($row2['sum_sale_return_amount']*$row2['discount']/100));
                                    }
                                }
                            }
                            $sql2="SELECT (`opt_2`) as `remarks`, SUM(`opt_6`) as `sum_reciept_amount` FROM `$reciept_table` WHERE `opt_1` BETWEEN '".$start_date."' AND '".$end_date."' AND `opt_4`='".$row1["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_reciept_amount'])){
                                        $sum_reciept_amount += $row2['sum_reciept_amount'];
                                    }
                                }
                            }
                            $sql2="SELECT (`opt_2`) as `remarks`, SUM(`opt_5`) as `sum_debit_amount` FROM `$debit_table` WHERE `opt_1` BETWEEN '".$start_date."' AND '".$end_date."' AND `opt_6`='C-".$row1["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_debit_amount'])){
                                        $sum_debit_amount += $row2['sum_debit_amount'];
                                    }
                                }
                            }
                            $sql2="SELECT (`opt_2`) as `remarks`, SUM(`opt_5`) as `sum_credit_amount` FROM `$credit_table` WHERE `opt_1` BETWEEN '".$start_date."' AND '".$end_date."' AND `opt_6`='C-".$row1["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_credit_amount'])){
                                        $sum_credit_amount += $row2['sum_credit_amount'];
                                    }
                                }
                            }
                            $sql2="SELECT SUM(`opt_17`) as `sum_builty_amount` FROM `$builty_table` WHERE `opt_1` BETWEEN '".$start_date."' AND '".$end_date."' AND `opt_3`='".$row1["id"]."'"." AND `added_for`='$business'";
                            $result2 = mysqli_query($local_conn_db, $sql2);
                            if($result2->num_rows > 0){
                                while($row2 = $result2->fetch_assoc()){
                                    if(isset($row2['sum_builty_amount'])){
                                        $sum_builty_amount += $row2['sum_builty_amount'];
                                    }
                                }
                            }
                            // $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                        // }
                        $debit = ($sum_debit_amount+$sum_sale_amount);
                        $credit = ($sum_sale_return_amount+$sum_credit_amount+$sum_reciept_amount+$sum_builty_amount);
                        $closing_balance = ($opening_balance + $debit - $credit);
                        $total_opening_amount += $opening_balance;
                        $total_debit_amount += $debit;
                        $total_credit_amount += $credit;
                        $total_closing_amount += $closing_balance;
                        echo "<tr>";
                        echo "<td>".$row1['opt_1']."</td>";
                        echo "<td style='text-align: center'>".$opening_balance."</td>";
                        echo "<td style='text-align: center'>".$debit."</td>";
                        echo "<td style='text-align: center'>".$credit."</td>";
                        echo "<td style='text-align: center'>".$closing_balance."</td>";
                        echo "</tr>";
                    }
                }
                echo "</tbody>";
                echo "</table>";
                echo "<br>";
                echo "<table id='foot_table'>";
                echo "<tr>";
                echo "<td><strong>Total Opening Balance: </strong>".$total_opening_amount."</td>";
                echo "<td><strong>Total Debit: </strong>".$total_debit_amount."</td>";
                echo "<td><strong>Total Credit: </strong>".$total_credit_amount."</td>";
                echo "<td><strong>Total Closing Balance: </strong>".$total_closing_amount."</td>";
                echo "</tr>";
                echo "</table>";
            }
            else{
                    echo "<tbody>";
                    $sql = "SELECT * FROM ".$tables.$filters." AND `added_for`='$business'";
                    // echo $sql;
                    $sum = array();
                    $column = explode(",", $columns);
                    $column_name = explode(",", $column_names);
                    $against_column = explode(",", $against_columns);
                    $against_table = explode(",", $against_tables);
                    $entry_sum = explode(",", $entry_sums);
                    $result = mysqli_query($local_conn_db, $sql);
                    for($i=0; $i<count($column); $i++){
                        $sum[$i] = "";
                    }
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            echo "<tr>";
                            for($i=0; $i<count($column); $i++){
                                if(isset($row[$against_column[$i]])){
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
                                                $value = $row[$formula[0]];
                                            }
                                            if($formula[$k] === "Sum"){
                                                $value = $value + $row[$formula[$k+1]];
                                            }
                                            else if($formula[$k] === "Subtract"){
                                                $value = $value - $row[$formula[$k+1]];
                                            }
                                            else if($formula[$k] === "Multiplication"){
                                                $value = $value * $row[$formula[$k+1]];
                                            }
                                            else if($formula[$k] === "Division"){
                                                $value = $value / $row[$formula[$k+1]];
                                            }
                                            else if($formula[$k] === "Modulus"){
                                                $value = $value % $row[$formula[$k+1]];
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
                                        if(is_numeric($row[$column[$i]])){
                                            echo "<td style='text-align: center;'>".$row[$column[$i]]."</td>";
                                        }
                                        else{
                                            echo "<td>".$row[$column[$i]]."</td>";
                                        }
                                        if($entry_sum[$i] === "True"){
                                            if($sum[$i] === ""){
                                                $sum[$i] = 0;
                                            }
                                            $sum[$i] += $row[$column[$i]];
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