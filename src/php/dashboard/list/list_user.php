<?php
    include("../../connections/connection.php");
    include("../../connections/local_connection.php");
    $system_id = $_POST["system_id"];
    $user_id = $_POST["user_id"];
    $user_type = $_POST["user_type"];
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
        $created_by = $user_type."_".$user_id;
        $sql = "SELECT * FROM `users` WHERE `created_by`='$created_by'";
        $result = mysqli_query($local_conn_db, $sql);
        echo '<table class="table dtHorizontalExampleWrapper" cellspacing="0" width="100%" id="users_table">';
        echo "<thead>";
        echo "<tr>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>User Name</th>";
        echo "<th>Date Of Birth</th>";
        echo "<th>Contact</th>";
        echo "<th>Type</th>";
        echo "<th>Status</th>";
        echo "<th>Edit</th>";
        echo "<th>Auth</th>";
        echo "</tr>";
        echo "</thead>";
        if($result->num_rows > 0){
            echo "<tbody>";
            while($row = $result->fetch_assoc()){ 
                echo "<tr>";
                echo "<td>".$row['fname']."</td>";
                echo "<td>".$row['lname']."</td>";
                echo "<td>".$row['uname']."</td>";
                echo "<td>".$row['dob']."</td>";
                echo "<td>".$row['contact']."</td>";
                echo "<td>".$row['type']."</td>";
                echo "<td>".$row['status']."</td>";
                ?>
                <td><button class='btn btn-default' onclick="user_edit_btn_click(
                    '<?php echo $row['id'] ?>',
                    '<?php echo $row['fname'] ?>',
                    '<?php echo $row['lname'] ?>',
                    '<?php echo $row['uname'] ?>',
                    '<?php echo $row['dob'] ?>',
                    '<?php echo $row['contact'] ?>',
                    '<?php echo $row['type'] ?>',
                    '<?php echo $row['status'] ?>',
                    '<?php echo $row['created_by'] ?>'
                    )"><span class="fa fa-pencil"></span></button></td>
                <td><button class='btn btn-default' onclick="list_user_authorities_click(
                    '<?php echo $row['id'] ?>',
                    '<?php echo $row['uname'] ?>',
                    '<?php echo $row['type'] ?>'
                    )"><span class="fa fa-lock"></span></button></td>
                <?php
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        else{
            echo "<tr>NO RESULTS</tr>";
        }
    }
    else{
        echo "<tr>Database not found...!</tr>";
    }
?>