<?php
    include("../../connections/connection.php");
    include("../../connections/local_connection.php");
    $system_id = $_POST["system_id"];
    $user_type = $_POST["user_type"];
    $business = $_POST["business"];
    if($user_type === "Developer" || $user_type === "Admin"){
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
        
            echo "<div id='dashboard_content_table' class='jumbotron entry_panel lesspadding'>";
            echo "<tr>";
        // Stock in hand
        {
            echo "<td style='width: 40%;'>";
            $products_table = "asset_4_values";
            $purchase_table = "entry_5_values";
            $sale_table = "entry_6_values";
            $sale_return_table = "entry_58_values";
            $sale_return = 0;
            $purchase = 0;
            $sale = 0;
            $closing_purchase = 0;
            $closing_sale = 0;
            echo "<div style='margin-top: -30px; border-bottom: 3px solid black; border-radius: 0px;' class='jumbotron lesspadding'>";
            echo "<div style='text-align: center;'><strong style='color: #ced0d3; font-size: 22px;'>Stock In Hand</strong></div>";
            echo "<table class='table dtHorizontalExampleWrapper' cellspacing='0' width='100%' id='dashboard_stock_in_hand_tbl'>";
            echo "<thead>";
            echo "<th>Product</th>";
            echo "<th>Stock In</th>";
            echo "<th>Stock Out</th>";
            echo "<th>Closing Stock</th>";
            echo "</thead>";
            echo "<tbody>";
            $sql="SELECT * FROM `$products_table` WHERE `added_for`='$business'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$row["opt_1"]."</td>";
                    $sql1="SELECT SUM(`opt_12`) as `opening_purchase` FROM `$purchase_table` WHERE `opt_5`='".$row["id"]."' AND `added_for`='$business'";
                    $result1 = mysqli_query($local_conn_db, $sql1);
                    if($result1->num_rows > 0){
                        while($row1 = $result1->fetch_assoc()){
                            $purchase = floatval($row1["opening_purchase"]);
                        }
                    }
                    $sql1="SELECT SUM(`opt_16`) as `opening_sale_return` FROM `$sale_return_table` WHERE `opt_9`='".$row["id"]."' AND `added_for`='$business'";
                    $result1 = mysqli_query($local_conn_db, $sql1);
                    if($result1->num_rows > 0){
                        while($row1 = $result1->fetch_assoc()){
                            $sale_return = floatval($row1["opening_sale_return"]);
                        }
                    }
                    $sql1="SELECT SUM(`opt_16`) as `opening_sale` FROM `$sale_table` WHERE `opt_9`='".$row["id"]."' AND `added_for`='$business'";
                    $result1 = mysqli_query($local_conn_db, $sql1);
                    if($result1->num_rows > 0){
                        while($row1 = $result1->fetch_assoc()){
                            $sale = floatval($row1["opening_sale"]);
                        }
                    }
                    echo "<td style='text-align: center;'>".($purchase + $sale_return)."</td>";
                    echo "<td style='text-align: center;'>".($sale)."</td>";
                    echo "<td style='text-align: center;'>".($purchase - $sale + $sale_return)."</td>";
                    echo "</tr>";
                }
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            echo "</td>";
        }
    
        // Profit Loss    
        {
            echo "<td style='width: 50%;'>";
            echo "<div style='margin-top: -30px; border-bottom: 3px solid black; border-radius: 0px;' class='jumbotron lesspadding'>";
            echo "<div style='text-align: center;'><strong style='color: #ced0d3; font-size: 22px;'>Profit/Loss</strong></div>";
            echo "<table class='table dtHorizontalExampleWrapper' cellspacing='0' width='100%' id='dashboard_profit_loss_tbl'>";
            echo "<thead>";
            echo "<th>Date</th>";
            echo "<th>Purchase</th>";
            echo "<th>Sale</th>";
            echo "<th>Expense</th>";
            echo "<th>Builty</th>";
            echo "<th>Salary</th>";
            echo "<th>Profit/Loss</th>";
            echo "</thead>";
            echo "<tbody>";
                
            $end_date = date("Y-m-d");
            $start_date = date ("Y-m-d", strtotime("-30 days", strtotime($end_date)));
    
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
                        $i=0;
                        if($result3->num_rows > 0){
                            while($row3 = $result3->fetch_assoc()){
                                // echo (($row3["opt_13"])-($row3["opt_13"]*$row3["opt_23"]/100))."<br>";
                                if($row3["opt_12"] > 0){
                                    $price = ((($row3["opt_13"])-($row3["opt_13"]*$row3["opt_23"]/100))/$row3["opt_12"]);
                                }
                                $sum_price += $price;
                                $i++;
                            }
                        }
                        if($i > 0){
                            $avg_price = $sum_price/$i;
                        }
                        $sql3="SELECT * FROM `$sale_table` WHERE `opt_1`='".$start_date."' AND `opt_9`='".$row2['id']."'";
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
                        else{
                            $sum_sale_amount += 0;
                        }
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
                        else{
                            $sum_expense_amount += 0;
                        }
                    }
                }
                echo "<td style='text-align: center'>".$sum_expense_amount."</td>";
                $sql2="SELECT SUM(`opt_17`) as `sum_builty_amount` FROM `$builty_table` WHERE `opt_1`='".$start_date."'"." AND `added_for`='$business'";
                $result2 = mysqli_query($local_conn_db, $sql2);
                if($result2->num_rows > 0){
                    while($row2 = $result2->fetch_assoc()){
                        if(isset($row2['sum_builty_amount'])){
                            $sum_builty_amount += ($row2['sum_builty_amount']);
                        }
                        else{
                            $sum_builty_amount += 0;
                        }
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
                        else{
                            $sum_salary_amount += 0;
                        }
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
            echo "</div>";
            echo "</td>";
        }
        
        echo "</tr>";
        echo "<tr>";
        //Store Stock
        {
            echo "<td style='width: 40%;'>";
            echo "<div style='margin-top: -30px; border-bottom: 3px solid black; border-radius: 0px;' class='jumbotron lesspadding'>";
            echo "<div style='text-align: center;'><strong style='color: #ced0d3; font-size: 22px;'>Store Stock</strong></div>";
            echo "<table class='table dtHorizontalExampleWrapper' cellspacing='0' width='100%' id='dashboard_store_stock_tbl'>";
            echo "<thead>";
            echo "<th>Product</th>";
            echo "<th>Stock In</th>";
            echo "<th>Stock Out</th>";
            echo "<th>Closing Stock</th>";
            echo "</thead>";
    
            $products_table = "asset_4_values";
            $purchase_table = "entry_5_values";
            $van_issue_table = "entry_16_values";
            $van_stock_return_table = "entry_57_values";
            $sale_return_table = "entry_58_values";
            $purchase = 0;
            $sale = 0;
            $sale_return = 0;
            $van_stock_return = 0;
            $closing_purchase = 0;
            $closing_sale = 0;
            echo "<tbody>";
            $sql="SELECT * FROM `$products_table` WHERE `added_for`='$business'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$row["opt_1"]."</td>";
                    $sql1="SELECT SUM(`opt_12`) as `opening_purchase` FROM `$purchase_table` WHERE `opt_5`='".$row["id"]."'"." AND `added_for`='$business'";
                    $result1 = mysqli_query($local_conn_db, $sql1);
                    if($result1->num_rows > 0){
                        while($row1 = $result1->fetch_assoc()){
                            $purchase = floatval($row1["opening_purchase"]);
                        }
                    }
                    $sql1="SELECT SUM(`opt_16`) as `sale` FROM `$sale_table` WHERE `opt_9`='".$row["id"]."' AND `opt_6`='' AND `added_for`='$business'";
                    $result1 = mysqli_query($local_conn_db, $sql1);
                    if($result1->num_rows > 0){
                        while($row1 = $result1->fetch_assoc()){
                            $sale = floatval($row1["sale"]);
                        }
                    }
                    $sql1="SELECT SUM(`opt_12`) as `van_stock_return` FROM `$van_stock_return_table` WHERE `opt_15`='".$row["id"]."'"." AND `added_for`='$business'";
                    $result1 = mysqli_query($local_conn_db, $sql1);
                    if($result1->num_rows > 0){
                        while($row1 = $result1->fetch_assoc()){
                            $van_stock_return = floatval($row1["van_stock_return"]);
                        }
                    }
                    $sql1="SELECT SUM(`opt_12`) as `van_issue` FROM `$van_issue_table` WHERE `opt_15`='".$row["id"]."'"." AND `added_for`='$business'";
                    $result1 = mysqli_query($local_conn_db, $sql1);
                    if($result1->num_rows > 0){
                        while($row1 = $result1->fetch_assoc()){
                            $van_issue = floatval($row1["van_issue"]);
                        }
                    }
                    $sql1="SELECT SUM(`opt_16`) as `opening_sale_return` FROM `$sale_return_table` WHERE `opt_9`='".$row["id"]."' AND `added_for`='$business'";
                    $result1 = mysqli_query($local_conn_db, $sql1);
                    if($result1->num_rows > 0){
                        while($row1 = $result1->fetch_assoc()){
                            $sale_return = floatval($row1["opening_sale_return"]);
                        }
                    }
                    echo "<td style='text-align: center;'>".($purchase + $van_stock_return + $sale_return)."</td>";
                    echo "<td style='text-align: center;'>".($van_issue + $sale)."</td>";
                    echo "<td style='text-align: center;'>".($purchase - $sale - $van_issue + $van_stock_return + $sale_return)."</td>";
                    echo "</tr>";
                }
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";

            echo "</td>";
        }

        // Van Stock
        {
            echo "<td style='width: 50%;'>";
            echo "<div style='margin-top: -30px; border-bottom: 3px solid black; border-radius: 0px;' class='jumbotron lesspadding'>";
            echo "<div style='text-align: center;'><strong style='color: #ced0d3; font-size: 22px;'>Van Stock</strong></div>";
            echo "<table class='table dtHorizontalExampleWrapper' cellspacing='0' width='100%' id='dashboard_van_stock_tbl'>";
            echo "<thead>";
            echo "<th>Van</th>";
            echo "<th>Product</th>";
            echo "<th>Stock In</th>";
            echo "<th>Stock Out</th>";
            echo "<th>Closing Stock</th>";
            echo "</thead>";
    
            $vans_table = "asset_15_values";
            $products_table = "asset_4_values";
            $van_issue_table = "entry_16_values";
            $sale_table = "entry_6_values";
            $van_stock_return_table = "entry_57_values";
            $van_issue = 0;
            $van_stock_return = 0;
            $sale = 0;
            $closing_purchase = 0;
            $closing_sale = 0;
            echo "<tbody>";
            $sql2="SELECT * FROM `$vans_table` WHERE `added_for`='$business'";
            $result2 = mysqli_query($local_conn_db, $sql2);
            if($result2->num_rows > 0){
                while($row2 = $result2->fetch_assoc()){
                    $sql="SELECT * FROM `$products_table` WHERE `added_for`='$business'";
                    $result = mysqli_query($local_conn_db, $sql);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            echo "<tr>";
                            echo "<td>".$row2["opt_1"]."</td>";
                            echo "<td>".$row["opt_1"]."</td>";
                            $sql1="SELECT SUM(`opt_12`) as `van_issue` FROM `$van_issue_table` WHERE `opt_15`='".$row["id"]."' AND `opt_3`='".$row2["id"]."'"." AND `added_for`='$business'";
                            $result1 = mysqli_query($local_conn_db, $sql1);
                            if($result1->num_rows > 0){
                                while($row1 = $result1->fetch_assoc()){
                                    $van_issue = floatval($row1["van_issue"]);
                                }
                            }
                            $sql1="SELECT SUM(`opt_12`) as `van_stock_return` FROM `$van_stock_return_table` WHERE `opt_15`='".$row["id"]."' AND `opt_3`='".$row2["id"]."'"." AND `added_for`='$business'";
                            $result1 = mysqli_query($local_conn_db, $sql1);
                            if($result1->num_rows > 0){
                                while($row1 = $result1->fetch_assoc()){
                                    $van_stock_return = floatval($row1["van_stock_return"]);
                                }
                            }
                            $sql1="SELECT SUM(`opt_16`) as `sale` FROM `$sale_table` WHERE `opt_9`='".$row["id"]."' AND `opt_7`='".$row2["id"]."'"." AND `added_for`='$business'";
                            $result1 = mysqli_query($local_conn_db, $sql1);
                            if($result1->num_rows > 0){
                                while($row1 = $result1->fetch_assoc()){
                                    $sale = floatval($row1["sale"]);
                                }
                            }
                            echo "<td style='text-align: center;'>".($van_issue)."</td>";
                            echo "<td style='text-align: center;'>".($sale + $van_stock_return)."</td>";
                            echo "<td style='text-align: center;'>".($van_issue - $sale - $van_stock_return)."</td>";
                            echo "</tr>";
                        }
                    }
                }
            }
            echo "</tbody>";
            echo "</table>";
    
            echo "</div>";
            echo "</td>";
        }

        echo "</tr>";
        echo "<tr>";
        // Party Ledgers
        {
            echo "<td style='width: 40%;'>";
            echo "<div style='margin-top: -30px; border-bottom: 3px solid black; border-radius: 0px;' class='jumbotron lesspadding'>";
            echo "<div style='text-align: center;'><strong style='color: #ced0d3; font-size: 22px;'>Party Ledgers</strong></div>";
            echo "<table class='table dtHorizontalExampleWrapper' cellspacing='0' width='100%' id='dashboard_party_ledgers_tbl'>";
            echo "<thead>";
            echo "<th>Party</th>";
            echo "<th>Debit</th>";
            echo "<th>Credit</th>";
            echo "<th>Balance</th>";
            echo "</thead>";
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
                    $total_debit_amount = 0;
                    $total_credit_amount = 0;
                    $start_date = "2020-03-01";
                    $end_date = date("Y-m-d");
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
                    $closing_balance = ($row["opt_8"] + $debit - $credit);
                    echo "<tr>";
                    echo "<td>".$row['opt_1']."</td>";
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
                    $total_debit_amount = 0;
                    $total_credit_amount = 0;
                    $start_date = "2020-03-01";
                    $end_date = date("Y-m-d");
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
                    $closing_balance = ($row["opt_8"] + $debit - $credit);
                    echo "<tr>";
                    echo "<td>".$row1['opt_1']."</td>";
                    echo "<td style='text-align: center'>".$debit."</td>";
                    echo "<td style='text-align: center'>".$credit."</td>";
                    echo "<td style='text-align: center'>".$closing_balance."</td>";
                    echo "</tr>";
                }
            }
            echo "</tbody>";
            echo "</table>";
            
            echo "</div>";
            echo "</td>";
        }

        //Accounts Ledgers
        {
            echo "<td style='width: 50%;'>";
            echo "<div style='margin-top: -30px; border-bottom: 3px solid black; border-radius: 0px;' class='jumbotron lesspadding'>";
            echo "<div style='text-align: center;'><strong style='color: #ced0d3; font-size: 22px;'>Accounts Ledgers</strong></div>";
            echo "<table class='table dtHorizontalExampleWrapper' cellspacing='0' width='100%' id='dashboard_accounts_ledgers_tbl'>";
            echo "<thead>";
            echo "<th>Account</th>";
            echo "<th>Debit</th>";
            echo "<th>Credit</th>";
            echo "<th>Balance</th>";
            echo "</thead>";
            echo "<tbody>";
            $accounts_table = "asset_49_values";
            $cash_deposit_table = "entry_50_values";
            $cash_withdrawal_table = "entry_51_values";
            $payment_table = "entry_7_values";
            $expense_table = "entry_14_values";
            $salary_table = "entry_17_values";
            $debit_table = "entry_9_values";
            $credit_table = "entry_10_values";

            $sql="SELECT * FROM `$accounts_table` WHERE `added_for`='$business'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $start_date = "2020-03-01";
                    $end_date = date("Y-m-d");
                    $sum_cash_deposit_amount = 0;
                    $sum_cash_withdrawal_amount = 0;
                    $sum_debit_amount = 0;
                    $sum_credit_amount = 0;
                    $sum_payment_amount = 0;
                    $sum_expense_amount = 0;
                    $sum_salary_amount = 0;
                    $opening_balance = 0;
                    $closing_balance = 0;
                    $total_debit_amount = 0;
                    $total_credit_amount = 0;

                    while (strtotime($start_date) <= strtotime($end_date)) {
                        $sql2="SELECT SUM(`opt_5`) as `sum_cash_deposit_amount` FROM `$cash_deposit_table` WHERE `opt_1`='".$start_date."' AND `opt_3`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_cash_deposit_amount'])){
                                    $sum_cash_deposit_amount += $row2['sum_cash_deposit_amount'];
                                }
                            }
                        }
                        $sql2="SELECT SUM(`opt_5`) as `sum_cash_withdrawal_amount` FROM `$cash_withdrawal_table` WHERE `opt_1`='".$start_date."' AND `opt_3`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_cash_withdrawal_amount'])){
                                    $sum_cash_withdrawal_amount += $row2['sum_cash_withdrawal_amount'];
                                }
                            }
                        }
                        $sql2="SELECT SUM(`opt_5`) as `sum_payment_amount` FROM `$payment_table` WHERE `opt_1`='".$start_date."' AND `opt_7`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_payment_amount'])){
                                    $sum_payment_amount += $row2['sum_payment_amount'];
                                }
                            }
                        }
                        $sql2="SELECT SUM(`opt_3`) as `sum_expense_amount` FROM `$expense_table` WHERE `opt_1`='".$start_date."' AND `opt_4`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_expense_amount'])){
                                    $sum_expense_amount += $row2['sum_expense_amount'];
                                }
                            }
                        }
                        $sql2="SELECT SUM(`opt_6`) as `sum_salary_amount` FROM `$salary_table` WHERE `opt_1`='".$start_date."' AND `opt_7`='".$row["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_salary_amount'])){
                                    $sum_salary_amount += $row2['sum_salary_amount'];
                                }
                            }
                        }
                        $sql2="SELECT (`opt_2`) as `remarks`, SUM(`opt_5`) as `sum_debit_amount` FROM `$debit_table` WHERE `opt_1`='".$start_date."' AND `opt_6`='A-".$row1["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_debit_amount'])){
                                    $sum_debit_amount += $row2['sum_debit_amount'];
                                }
                            }
                        }
                        $sql2="SELECT (`opt_2`) as `remarks`, SUM(`opt_5`) as `sum_credit_amount` FROM `$credit_table` WHERE `opt_1`='".$start_date."' AND `opt_6`='A-".$row1["id"]."'"." AND `added_for`='$business'";
                        $result2 = mysqli_query($local_conn_db, $sql2);
                        if($result2->num_rows > 0){
                            while($row2 = $result2->fetch_assoc()){
                                if(isset($row2['sum_credit_amount'])){
                                    $sum_credit_amount += $row2['sum_credit_amount'];
                                }
                            }
                        }
                        $start_date = date ("Y-m-d", strtotime("+1 days", strtotime($start_date)));
                    }
                    
                    echo "<tr>";
                    echo "<td>".$row["opt_1"]."</td>";
                    $debit = ($sum_cash_deposit_amount+$sum_debit_amount);
                    echo "<td style='text-align: center'>".$debit."</td>";
                    $credit = ($sum_cash_withdrawal_amount+$sum_credit_amount+$sum_payment_amount+$sum_expense_amount+$sum_salary_amount);
                    echo "<td style='text-align: center'>".$credit."</td>";
                    $closing_balance = ($row["opt_8"]) + ($debit) - ($credit);
                    echo "<td style='text-align: center'>".$closing_balance."</td>";
                    echo "</tr>";
                }
            }
            echo "</tbody>";
            echo "</table>";
            
            echo "</div>";
            echo "</td>";
        }

        echo "</tr>";
        echo "</div>";
    
        }
        else{
            echo "<li>Database not found...!</li>";
        }
    }
?>