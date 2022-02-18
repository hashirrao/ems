<?php
    header("Location: ./src/php/login_user.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EMS</title>
    <link rel="stylesheet" href="./libs/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/index.css" />
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="./libs/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <script src="./src/js/index.js"></script>
</head>
<body>
    <header class="jumbotron text-center header">
        <h2 class="headtext">EMS</h2>

        <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
            <span class="caret"></span></button>
            <ul class="dropdown-menu dark">
                <li><a href="./src/php/login.php">Login</a></li>
                <li><a href="./src/php/signup.php">Register</a></li>
                <li class="divider"></li> 
                <li id="user_login_li"><a href="./src/php/login_user.php">User Login</a></li>
            </ul>
        </div>
    </header>

    <div class="container">
        <div class="jumbotron text-center">
            
        </div>
    </div>
</body>
</html>