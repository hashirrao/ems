<?php
    include("../connections/connection.php");
    session_start();
    $sql="SELECT * FROM `systems` WHERE `user_id`='".$_SESSION["userid"]."'";
    $result = mysqli_query($conn, $sql);
    if($result->num_rows > 0){
        $i = 1;
        while($row = $result->fetch_assoc()){  ?>
        <tr id="<?php echo "systemstablerow_$i" ?>">
        <th scope="row"><?php echo $i++ ?></th>
        <td><?php echo $row["id"] ?></td>
        <td><?php echo $row["system_name"] ?></td>
        <td width="80px">
        <form method="POST" action="./dashboard.php" target="_blank">
            <input name="id" value="<?php echo $row["id"] ?>" type="hidden">
            <input name="system_name" value="<?php echo $row["system_name"] ?>" type="hidden">
            <button name="dashboard" type="submit" class="btn btn-default">Dashboard</button>
        </form>
        </td>
        <td width="30px"><button class="btn btn-default" onclick="editsystem_btn_click(<?php echo $i-1 ?>)"><span class="fa fa-pencil"></button></td>
        <td width="30px"><button class="btn btn-default" onclick="deletesystem_btn_click(<?php echo $i-1 ?>)"><span class="fa fa-trash"></button></td>
        </tr>
    <?php }  
    }
?>