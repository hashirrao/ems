<?php
include('connections/connection.php');
$message = '';
if(isset($_POST['register'])){
  $date = date("Y-m-d");
  $fname = $_POST['firstname'];
  $lname = $_POST['lastname'];
  $uname = $_POST['username'];
  $phone = $_POST['contact'];
  $password = $_POST['password'];
  $cpassword = $_POST['confirmpassword'];
  
  if($password === $cpassword){
    $encpassword = md5($password, "h123f3");
    
    $sql="SELECT * FROM `users` WHERE `username`='".$uname."'";
    $result = mysqli_query($conn, $sql);
    if($result->num_rows == 0){
      $sql="INSERT INTO `users`(`fname`, `lname`, `username`, `password`, `contact`, `status`, `type`, `created`, `updated`) VALUES ('$fname', '$lname', '$uname', '$password', '$phone', 'Activated', 'Developer', '$date', '$date')";
      $result = mysqli_query($conn, $sql);
        if($result == true){
            $sql="SELECT * FROM `users` WHERE `username`='".$uname."' AND `password`='".$password."' AND `status`='Activated'";
            $result = mysqli_query($conn, $sql);
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
            }
            header('Location: ./profile.php');    
        }
        }else{
          $message = "Error in creating user....!";
        }
      }
      else{
        $message = "This user name is already taken...!";
      }
  }
  else{
    $message = "Both passwords must be same...!";
  }
  
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AMS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/index.css" />
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <header class="jumbotron text-center header">
        <h2 class="headtext">Any Management System</h2>
    </header>
    <div class="container">
        <div class="col-sm-6 col-sm-offset-3">
            <h2>Register</h2>
            
            <?php if($message != ""){ ?>
            <div class="alert alert-danger"><?php echo $message ?></div>
            <?php } ?>
            <form action="./signup.php" method="post">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" name="firstname" placeholder="FIRST NAME" required>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" name="lastname" placeholder="LAST NAME" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" placeholder="USERNAME" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="PASSWORD" required>
                </div>
                <div class="form-group">
                    <label>Retype Password</label>
                    <input type="password" class="form-control" name="confirmpassword" placeholder="RETYPE PASSWORD" required>
                </div>
                <div class="form-group">
                    <label>Contact No</label>
                    <input type="text" class="form-control" name="contact" placeholder="CONTACT NO" required>
                </div>
                <input type="submit" name="register" value="Register" class="btn btn-success btn-lg">
            </form>

            <hr>

            <p>Already have an account <a href="./login.php">Login</a></p>
            <p>Go Back <a href="../../">Home</a>.</p>
        </div>
    </div>
</body>
</html>