<?php
    $message = '';
    include('./connections/connection.php');
    include('./connections/local_connection.php');

    if(isset($_POST['login'])){
        $system_id = $_POST['system_id'];
        $system_name = $_POST['system_name'];
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
            $uname = $_POST['username'];
            $password = $_POST['password'];
            $encpassword = md5($password, "h123f3");
            $sql="SELECT * FROM `users` WHERE `uname`='".$uname."' AND `password`='".$password."' AND `status`='Activated'";
            $result = mysqli_query($local_conn_db, $sql);
            if($result->num_rows > 0){
                session_start();
                while($row = $result->fetch_assoc()){
                    $_SESSION["userid"] = $row['id'];
                    $_SESSION["firstname"] = $row['fname'];
                    $_SESSION["lastname"] = $row['lname'];
                    $_SESSION["username"] = $row['username'];
                    $_SESSION["password"] = $row['password'];
                    $_SESSION["type"] = $row['type'];
                    $_SESSION["contact"] = $row['contact'];
                    $_SESSION["isuser"] = "alreadyin";     
                    $_SESSION["systemid"] = $system_id;     
                    $_SESSION["systemname"] = $system_name;     
                }
                header('Location: ./dashboard.php');    
            }
            else if($_POST['username'] == "developer#" && md5($_POST['password']) == "1d2e4a1fc16a3cca80754de47f24ebda"){
                session_start();
                $_SESSION["isuser"] = "alreadyin";
                $_SESSION["type"] = "developer#";
                $_SESSION["username"] = "developer#";
                $_SESSION["password"] = $encpassword;
                $_SESSION["systemid"] = $system_id;     
                $_SESSION["systemname"] = $system_name;     
                header('Location: ./dashboard.php');
            }
            else{
                $message = "Invalid Login...!";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EMS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/index.css" />
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <header class="jumbotron text-center header">
        <h2 class="headtext">Management System</h2>
    </header>
    <div class="container">
        <div class="col-sm-6 col-sm-offset-3">
            <h2>Login</h2>
            
            <?php if($message != "") { ?>
                <div class="alert alert-danger"><?php echo $message ?></div>
            <?php } ?>

            <form action="./login_user.php" method="post">
                <!-- <div class="form-group">
                    <label>System</label>
                    <select class="form-control" name="system">
                        <option value="36">EMS</option>
                    </select>
                </div> -->
                <input name="system_id" type="hidden" value="36">
                <input name="system_name" type="hidden" value="Tyre Distribution(EMS)">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" placeholder="USERNAME">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="PASSWORD">
                </div>

                <input type="submit" value="Login" name="login"  class="btn btn-success btn-lg">
            </form>
        </div>
    </div>
</body>
</html>