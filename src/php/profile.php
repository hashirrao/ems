
<?php
    include("./connections/connection.php");
    session_start();
    if(isset($_SESSION["isuser"])){
        
        if($_SESSION["isuser"] !== "alreadyin"){
            header('Location: ../../');
        }
    }
    else{
        header('Location: ../../');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EMS</title>
    <link rel="stylesheet" href="../../libs/bootstrap-3.3.7-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../libs/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/css/index.css" />
    <link rel="stylesheet" href="../../assets/css/profile.css" />
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- <script src="../../assets/bootstrap-3.3.7-dist/3.3.7/js/bootstrap.min.js"></script> -->
</head>
<body>
    <header class="jumbotron text-center header">
        <h2 class="headtext">EMS</h2>
        
        <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
            <span class="caret"></span></button>
            <ul class="dropdown-menu dark">
                <li><a href="#">Change Password</a></li>
                <li class="divider"></li>
                <li><a href="./logout.php">Logout</a></a></li>
            </ul>
        </div>
    </header>
    <div class="container">
        <div class="page-header text-center">
            <h2>Profile</h2>
        </div>
        <!-- For displaying user details -->
        <div class="row">
            <div class="col-sm-12">
                <div class="well">
                    <button id="usereditbtn" style="float: right;" class="btn btn-default" onclick="edituserbtn_click()">
                        <span class="fa fa-pencil"></span>
                    </button>
                    <h3><span class="fa fa-user"></span>Welcome <?php echo $_SESSION["firstname"] ?></h3>
                    
                    <p>
                        <?php
                            $sql="SELECT * FROM `users` WHERE `id`='".$_SESSION["userid"]."'";
                            $result = mysqli_query($conn, $sql);
                            if($result->num_rows > 0){
                              while($row = $result->fetch_assoc()){
                                  $_SESSION["firstname"] = $row['fname'];
                                  $_SESSION["lastname"] = $row['lname'];
                                  $_SESSION["username"] = $row['username'];
                                  $_SESSION["password"] = $row['password'];
                                  $_SESSION["type"] = $row['type'];
                                  $_SESSION["contact"] = $row['contact'];
                                  $_SESSION["isuser"] = "alreadyin";     
                              }  
                            }
                        ?> 
                        <strong>ID : </strong> <label id="idlabel"><?php echo $_SESSION["userid"] ?></label> <br>
                        <strong>First Name: </strong> <input id="userfname" class="form-control" value="<?php echo $_SESSION["firstname"] ?>" disabled> <br>
                        <strong>Last Name: </strong> <input id="userlname" class="form-control" value="<?php echo $_SESSION["lastname"] ?>" disabled> <br>
                        <strong>Username: </strong> <input id="useruname" class="form-control" value="<?php echo $_SESSION["username"] ?>" disabled> <br>
                        <strong>Contact: </strong> <input id="usercontact" class="form-control" value="<?php echo $_SESSION["contact"] ?>" disabled> <br>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="page-header text-center">
            <h2>Management Systems</h2>
        </div>
        <!-- For displaying mangement systems -->
        <div class="row">
            <div class="col-sm-12">
                <div class="well">
                <button id="addmanagementsystembtn" style="float: right;" class="btn btn-default" onclick="addmangementsystem_btn_click()">
                        <span class="fa fa-plus"></span>
                    </button>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">System ID</th>
                            <th scope="col">Systme Name</th>
                            <th scope="col" width="80px"></th>
                            <th scope="col" width="30px"></th>
                            <th scope="col" width="30px"></th>
                            </tr>
                        </thead>
                        <tbody id="systemstbody">
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="addmanagementsystempanel" class="jumbotron">
            <div class="headerDiv" id="addmanagementsystempanelheader"></div>
            <div class="page-header text-center">
                <h2>Create Management System</h2>
            </div>
            <div id="createmanagementmessageDiv"></div>
            <strong>System Name: </strong> <input id="systemname" class="form-control" placeholder="SYSTEM NAME"> <br>
            <button style="float: right;" class="btn btn-success" onclick="addmanagementsystempanel_save_btn_click()">Save</button>
            <button class="btn btn-danger" onclick="addmanagementsystempanel_cancel_btn_click()">Cancel</button>
        </div> 

        <div id="editmanagementsystempanel" class="jumbotron">
            <div class="headerDiv" id="editmanagementsystempanelheader"></div>
            <div class="page-header text-center">
                <h2>Edit Management System</h2>
            </div>
            <div id="editmanagementmessageDiv"></div>
            <strong>System Name: </strong> <input id="edit_system_name" class="form-control" placeholder="SYSTEM NAME"> <br>
            <button style="float: right; margin-left: 5px;" class="btn btn-success" onclick="editmanagementsystempanel_save_btn_click()">Save</button>
            <button class="btn btn-danger" onclick="editmanagementsystempanel_cancel_btn_click()">Cancel</button>
        </div> 

        <div id="deletemanagementsystempanel" class="jumbotron">
        <div class="headerDiv" id="deletemanagementsystempanelheader"></div>
            <div id="deletemanagementmessageDiv"></div>
            <button class="btn btn-danger" id="deletemanagementsystempanel_yes_btn" style="float: right; margin-left: 5px;" onclick="deletemanagementsystempanel_yes_btn_click()">Yes</button>
            <button class="btn btn-success" onclick="deletemanagementsystempanel_no_btn_click()">No</button>
        </div> 

    </div>
    <script src="../js/profile.js" ></script>
    <script src="../js/drag_div.js" ></script>
</body>
</html>