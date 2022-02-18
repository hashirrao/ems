<?php
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive sidebar template with sliding effect and dropdown menu based on bootstrap 3">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../libs/bootstrap_4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="../../libs/font-awesome-4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="../../libs/select2/dist/css/select2.min.css">

    <link rel="stylesheet" href="../../assets/css/theme.css" />
    <link rel="stylesheet" href="../../assets/css/index.css" />
    <link rel="stylesheet" href="../../assets/css/dashboard.css" />
    <!-- MDBootstrap Datatables  -->
    <link rel="stylesheet" href="../../libs/MDB_Free_4.10.0/css/addons/datatables.min.css">
</head>

<body>
<header class="jumbotron text-center header">
        <h2 class="headtext">
        <?php 
        if(isset($_POST["dashboard"])){
          echo $_POST["system_name"];
        }
        else{
          echo $_SESSION["systemname"];
        }
        ?>
        </h2>

        <div class="input-group mb-0" style="float: right; min-width: 150px; width: 25%; margin-top: -43px;">
          <!-- <div class="input-group-prepend "> -->
            
          <!-- </div> -->
          <table style="width: 100%; padding: 0px;">
            <tr style="padding: 0px;">
              <td style="padding: 0px;"><select id="select_business" class="form-control form-control-sm select2-single" onchange="select_business_change()"></select></td>
              <td style="padding: 0px;"><button class="btn btn-info btn-sm" onclick="list_business_panel()"><span class="fa fa-list"></span></button></td>
            </tr>
          </table>
        </div>

        <!-- <div class="input-group mb-3" style="width: 25%; float: right; margin-top: -43px">
          <div class="input-group-prepend">
                <span class="input-group-text">Business</span>
          </div>
          <select id="select_business" class="form-control" aria-describedby="basic-addon1" onchange="select_business_change()"></select>
          <div class="input-group-append">
            <button class="input-group-text btn btn-default" onclick="list_business_panel()"><span class="fa fa-list-alt"></span></button>
          </div>
        </div> -->
    </header>

<div class="page-wrapper chiller-theme toggled">
  <a id="show-sidebar" class="btn btn-sm btn-dark">
    <i style="color: white;" class="fas fa-bars"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a>System ID: <span id="system_id">
        <?php 
        if(isset($_POST["dashboard"])){
          echo $_POST["id"];
        }
        else{
          echo $_SESSION["systemid"];
        }
        ?>
        </span></a>
        <input id='user_id' type='hidden' value='<?php echo $_SESSION['userid']; ?>'>
        <div id="close-sidebar">
          <button class="close_buttons"></button>
        </div>
      </div>
      <div class="sidebar-header">
        <!--
        <div class="user-pic">
          <img style="height: 60px;" class="img-responsive img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg" alt="User picture">
        </div>  -->
        <div class="user-info">
          <span class="user-name"><?php echo $_SESSION["firstname"] ?>
            <strong><?php echo $_SESSION["lastname"] ?></strong>
          </span>
          <span class="user-role" id="user_type"><?php echo $_SESSION["type"] ?></span>
          <span class="user-status">
            <i class="fa fa-circle"></i>
            <span>Online</span>
          </span>
        </div>
      </div>
      <!-- sidebar-header  -->
      <!--
      <div class="sidebar-search">
        <div>
          <div class="input-group">
            <input type="text" class="form-control search-menu" placeholder="Search...">
            <div class="input-group-append">
              <span class="input-group-text">
                <i class="fa fa-search" aria-hidden="true"></i>
              </span>
            </div>
          </div>
        </div>
      </div>  -->
      <!-- sidebar-search  -->
      <div class="sidebar-menu">
      <?php 
        if($_SESSION["type"] === "Developer"){
      ?>
        <ul>
          <li class="header-menu">
            <span>Add Options</span>
          </li>
          <li class="sidebar-dropdown">
            <a>
              <i class="fa fa-plus"></i>
              <span>Add</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a onclick="add_asset_link_click()">Asset
                    <!-- <span class="badge badge-pill badge-success">Pro</span>  -->
                  </a>
                </li>
                <li>
                  <a onclick="add_entry_link_click()">Entry</a>
                </li>
                <li>
                  <a onclick="add_report_link_click()">Report</a>
                </li>
                <!-- <li>
                  <a onclick="add_custom_table_link_click()">Custom Table</a>
                </li> -->
              </ul>
            </div>
          </li>
        </ul>
        
        <!-- Customized Options -->
        <ul>
          <li class="header-menu">
            <span>Customized Options</span>
          </li>
          <li class="sidebar-dropdown">
            <a>
              <i class="fa fa-list-alt"></i>
              <span>Assets</span>
            </a>
            <div class="sidebar-submenu">
              <ul id="assets_ul">
                
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a>
              <i class="fa fa-pencil-square-o"></i>
              <span>Entries</span>
            </a>
            <div class="sidebar-submenu">
              <ul id="entries_ul">
                
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a>
              <i class="fa fa-file"></i>
              <span>Reports</span>
            </a>
            <div class="sidebar-submenu">
              <ul id="reports_ul">
                
              </ul>
            </div>
          </li>
          <!-- <li class="sidebar-dropdown">
            <a>
              <i class="fa fa-table"></i>
              <span>Custom Tables</span>
            </a>
            <div class="sidebar-submenu">
              <ul id="custom_tables_ul">
                
              </ul>
            </div>
          </li> -->
        </ul>
        <?php 
        }
        ?>
        <!-- Admin Options -->
        <ul>
          <li class="header-menu">
            <span>Options</span>
          </li>
          <li class="sidebar-dropdown">
            <a>
              <i class="fa fa-list-alt"></i>
              <span>Assets</span>
            </a>
            <div class="sidebar-submenu">
              <input id='list_search_inp' placeholder='SEARCH' class='form-control search_inps' onkeyup='refresh_assets_for_admin_list_options()'>
              <ul id="admin_list_ul">
                
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a>
              <i class="fa fa-pencil-square-o"></i>
              <span>Entries</span>
            </a>
            <div class="sidebar-submenu">
            <input id='entry_search_inp' placeholder='SEARCH' class='form-control search_inps' onkeyup='refresh_entries_for_admin_entry_options()'>
              <ul id="admin_entry_ul">
                
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a>
              <i class="fa fa-file"></i>
              <span>Reports</span>
            </a>
            <div class="sidebar-submenu">
              <input id='report_search_inp' placeholder='SEARCH' class='form-control search_inps' onkeyup='refresh_reports_for_admin_report_options()'>
              <ul id="admin_reports_ul">
                
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a>
              <i class="fa fa-gear"></i>
              <span>Settings</span>
            </a>
            <div class="sidebar-submenu">
              <ul id="admin_settings_ul">
                <li><a onclick="add_user_click()">Add User</a></li>
                <li><a onclick="list_user_click()">List Users</a></li>
                <li><a onclick="change_password_click()">Change Password</a></li>
                <li><a onclick="shortcut_key_link_click()">Shortcut Keys</a></li>
                <li><a href="./logout.php">Log Out</a></li>
              </ul>
            </div>
          </li>
        </ul>
      <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <!-- 
    <div class="sidebar-footer">
      <a href="#">
        <i class="fa fa-bell"></i>
        <span class="badge badge-pill badge-warning notification">3</span>
      </a>
      <a href="#">
        <i class="fa fa-envelope"></i>
        <span class="badge badge-pill badge-success notification">7</span>
      </a>
      <a href="#">
        <i class="fa fa-cog"></i>
        <span class="badge-sonar"></span>
      </a>
      <a href="#">
        <i class="fa fa-power-off"></i>
      </a>
    </div> -->
  </nav>
  <!-- sidebar-wrapper  -->
  <div id="dashboard_main_dasboard_div"></div>
  <main class="page-content">
    <div class="container-fluid">      
      <div id="dashboard_main_div"></div>
    </div>
  </main>
  <!-- page-content" -->
</div>


<?php include("./dashboard/panels/option_panels.php") ?>

<!-- page-wrapper -->
    <script src="../../libs/MDB_Free_4.10.0/js/jquery.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script> -->
    <script src="../../libs/bootstrap_4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
    <script src="../js/auto_complete.js"></script>
    <script src="../js/dashboard.js"></script>    
    <script src="../js/dashboard_user.js"></script>    
    <script src="../js/dashboard_drag_divs.js"></script>    
    <!-- MDBootstrap Datatables  -->
    <script type="text/javascript" src="../../libs/MDB_Free_4.10.0/js/addons/datatables.min.js"></script>

    <script src="../../libs/select2/dist/js/select2.min.js"></script>
</body>

</html>