var system_id = document.getElementById("system_id").innerHTML;

function add_asset_link_click() {
  document.getElementById("add_asset_panel").style.visibility = "visible";
}

function add_asset_save_btn_click() {
  var asset_name = document.getElementById("add_asset_name").value;
  if (asset_name !== "") {
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/add/add_option.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Added Successfully...!") {
          document.getElementById("add_asset_option_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
            + this.responseText + "</div>";
          setTimeout(function () {
            document.getElementById("add_asset_panel").style.visibility = "hidden";
            document.getElementById("add_asset_name").value = "";
            document.getElementById("add_asset_option_panel_messageDiv").innerHTML = "";
            refresh_assets_for_customized_options();
            refresh_assets_for_admin_add_options();
            refresh_assets_for_admin_list_options();
          }, 700);
        }
        else {
          document.getElementById("add_asset_option_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
            + this.responseText + "</div>";
        }
      }
    }
    ajax.send("asset_name=" + asset_name + "&system_id=" + system_id);
  }
}

function add_asset_cancel_btn_click() {
  document.getElementById("add_asset_panel").style.visibility = "hidden";
}

function refresh_assets_for_customized_options() {
  if(document.getElementById("assets_ul")){
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/refresh/refresh_asset.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("assets_ul").innerHTML = this.responseText;
        if (this.responseText === "<li>NO RESULTS</li>") {
          document.getElementById("assets_ul").style.color = "rgb(201, 30, 44)";
        }
        else {
          document.getElementById("assets_ul").style.color = "#58606e";
        }
      }
    }
    ajax.send("system_id=" + system_id);
  }
}

function list_asset_link_click(id) {
  asset_id = id;
  var asset_name = document.getElementById("add_asset_name").value;
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/panels/option_panels_dev.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("dashboard_main_div").innerHTML = this.responseText;
      if(document.getElementById("add_sub_options_panel_content").innerHTML != ""){
        custom_table_options_div_show();
        add_option_input_change();
        entry_options_div_show();
      }
      // settings_options_panel_close_btn_click();
      refresh_sub_options_in_panel();
    }
  }
  ajax.send("asset_id=" + asset_id + "&asset_name=" + asset_name + "&system_id=" + system_id + "&type=" + 'asset');
}

refresh_assets_for_customized_options();

function add_entry_link_click() {
  document.getElementById("add_entry_panel").style.visibility = "visible";
}

function add_entry_save_btn_click() {
  var entry_name = document.getElementById("add_entry_name").value;
  if (entry_name !== "") {
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/add/add_option.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Added Successfully...!") {
          document.getElementById("add_entry_option_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
            + this.responseText + "</div>";
          setTimeout(function () {
            document.getElementById("add_entry_panel").style.visibility = "hidden";
            document.getElementById("add_entry_name").value = "";
            document.getElementById("add_entry_option_panel_messageDiv").innerHTML = "";
            refresh_entries_for_customized_options();
            refresh_entries_for_admin_entry_options();
          }, 700);
        }
        else {
          document.getElementById("add_entry_option_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
            + this.responseText + "</div>";
        }
      }
    }
    ajax.send("entry_name=" + entry_name + "&system_id=" + system_id);
  }
}

function add_entry_cancel_btn_click() {
  document.getElementById("add_entry_panel").style.visibility = "hidden";
}

function refresh_entries_for_customized_options() {
  if(document.getElementById("entries_ul")){
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/refresh/refresh_entry.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("entries_ul").innerHTML = this.responseText;
        if (this.responseText === "<li>NO RESULTS</li>") {
          document.getElementById("entries_ul").style.color = "rgb(201, 30, 44)";
        }
        else {
          document.getElementById("entries_ul").style.color = "#58606e";
        }
      }
    }
    ajax.send("system_id=" + system_id);
  }
}

refresh_entries_for_customized_options();

function list_entry_link_click(id) {
  entry_id = id;
  var entry_name = document.getElementById("add_entry_name").value;
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/panels/option_panels_dev.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("dashboard_main_div").innerHTML = this.responseText;
      refresh_sub_options_in_panel();
      if(document.getElementById("add_sub_options_panel_content").innerHTML != ""){
        custom_table_options_div_show();
        add_option_input_change();
        entry_options_div_show();
      }
      // settings_options_panel_close_btn_click();
    }
  }
  ajax.send("entry_id=" + entry_id + "&entry_name=" + entry_name + "&system_id=" + system_id + "&type=" + 'entry');
}

function add_report_link_click() {
  document.getElementById("add_report_panel").style.visibility = "visible";
}

function add_report_save_btn_click() {
  var report_name = document.getElementById("add_report_name").value;
  var report_type = document.getElementById("add_report_type").value;
  if (report_name !== "") {
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/add/add_option.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Added Successfully...!") {
          document.getElementById("add_report_option_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
            + this.responseText + "</div>";
          setTimeout(function () {
            document.getElementById("add_report_panel").style.visibility = "hidden";
            document.getElementById("add_report_name").value = "";
            document.getElementById("add_report_option_panel_messageDiv").innerHTML = "";
            refresh_reports_for_customized_options();
            refresh_reports_for_admin_report_options();
          }, 700);
        }
        else {
          document.getElementById("add_report_option_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
            + this.responseText + "</div>";
        }
      }
    }
    ajax.send("report_name=" + report_name + "&report_type=" + report_type + "&system_id=" + system_id);
  }
}

function add_report_cancel_btn_click() {
  document.getElementById("add_report_panel").style.visibility = "hidden";
}

function add_custom_table_link_click() {
  document.getElementById("add_custom_table_panel").style.visibility = "visible";
}

function refresh_reports_for_customized_options() {
  if(document.getElementById("reports_ul")){
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/refresh/refresh_report.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("reports_ul").innerHTML = this.responseText;
        if (this.responseText === "<li>NO RESULTS</li>") {
          document.getElementById("reports_ul").style.color = "rgb(201, 30, 44)";
        }
        else {
          document.getElementById("reports_ul").style.color = "#58606e";
        }
      }
    }
    ajax.send("system_id=" + system_id);
  }
}

refresh_reports_for_customized_options();

function list_report_link_click(id) {
  report_id = id;
  var report_name = document.getElementById("add_report_name").value;
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/panels/option_panels_dev.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("dashboard_main_div").innerHTML = this.responseText;
      refresh_sub_options_in_panel();
      if(document.getElementById("add_sub_options_panel_content").innerHTML != ""){
        custom_table_options_div_show();
        add_option_input_change();
        // report_options_div_show();
      }
      // settings_options_panel_close_btn_click();
    }
  }
  ajax.send("report_id=" + report_id + "&report_name=" + report_name + "&system_id=" + system_id + "&type=" + 'report');
}

function add_custom_table_save_btn_click() {
  var custom_table_name = document.getElementById("add_custom_table_name").value;
  if (custom_table_name !== "") {
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/add/add_option.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Added Successfully...!") {
          document.getElementById("add_custom_table_option_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
            + this.responseText + "</div>";
          setTimeout(function () {
            document.getElementById("add_custom_table_panel").style.visibility = "hidden";
            document.getElementById("add_custom_table_name").value = "";
            document.getElementById("add_custom_table_option_panel_messageDiv").innerHTML = "";
            refresh_custom_tables_for_customized_options();
            refresh_custom_tables_for_edit_options();
          }, 700);
        }
        else {
          document.getElementById("add_custom_table_option_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
            + this.responseText + "</div>";
        }
      }
    }
    ajax.send("custom_table_name=" + custom_table_name + "&system_id=" + system_id);
  }
}

function add_custom_table_cancel_btn_click() {
  document.getElementById("add_custom_table_panel").style.visibility = "hidden";
}

function refresh_custom_tables_for_customized_options() {
  if(document.getElementById("custom_tables_ul")){
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/refresh/refresh_custom_table.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("custom_tables_ul").innerHTML = this.responseText;
        if (this.responseText === "<li>NO RESULTS</li>") {
          document.getElementById("custom_tables_ul").style.color = "rgb(201, 30, 44)";
        }
        else {
          document.getElementById("custom_tables_ul").style.color = "#58606e";
        }
      }
    }
    ajax.send("system_id=" + system_id);
  }
}

refresh_custom_tables_for_customized_options();

function list_custom_tables_link_click(id) {
  custom_table_id = id;
  var custom_table_name = document.getElementById("add_custom_table_name").value;
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/panels/option_panels_dev.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("dashboard_main_div").innerHTML = this.responseText;
      if(document.getElementById("add_sub_options_panel_content").innerHTML != ""){
        custom_table_options_div_show();
        add_option_input_change();
        entry_options_div_show();
      }
      // settings_options_panel_close_btn_click();
      refresh_sub_options_in_panel();
    }
  }
  ajax.send("custom_table_id=" + custom_table_id + "&custom_table_name=" + custom_table_name + "&system_id=" + system_id + "&type=" + 'custom_table');
}

//Edit Options..............!

function list_asset_for_edit_link_click(id, name) {
  asset_id = id;
  asset_name = name;

  document.getElementById("edit_asset_id").value = asset_id;
  document.getElementById("edit_asset_name").value = asset_name;
  document.getElementById("edit_asset_panel").style.visibility = "visible";
}

function edit_asset_save_btn_click() {
  var asset_id = document.getElementById("edit_asset_id").value;
  var asset_name = document.getElementById("edit_asset_name").value;
  if (asset_name !== "") {
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/edit/edit_option.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Updated Successfully...!") {
          document.getElementById("edit_asset_option_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
            + this.responseText + "</div>";
          setTimeout(function () {
            document.getElementById("edit_asset_panel").style.visibility = "hidden";
            document.getElementById("edit_asset_name").value = "";
            document.getElementById("edit_asset_option_panel_messageDiv").innerHTML = "";
            refresh_assets_for_customized_options();
            refresh_assets_for_admin_add_options();
            refresh_assets_for_admin_list_options();
          }, 700);
        }
        else {
          document.getElementById("edit_asset_option_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
            + this.responseText + "</div>";
        }
      }
    }
    ajax.send("asset_id=" + asset_id + "&asset_name=" + asset_name + "&system_id=" + system_id);
  }
}

function edit_asset_delete_btn_click() {
  if (confirm("Are you sure to delete it...?")) {
    var asset_id = document.getElementById("edit_asset_id").value;
    var asset_name = document.getElementById("edit_asset_name").value;
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/delete/delete_option.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Deleted Successfully...!") {
          document.getElementById("edit_asset_option_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
            + this.responseText + "</div>";
          setTimeout(function () {
            document.getElementById("edit_asset_panel").style.visibility = "hidden";
            document.getElementById("edit_asset_name").value = "";
            document.getElementById("edit_asset_option_panel_messageDiv").innerHTML = "";
            refresh_assets_for_customized_options();
            refresh_assets_for_admin_add_options();
            refresh_assets_for_admin_list_options();
          }, 700);
        }
        else {
          document.getElementById("edit_asset_option_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
            + this.responseText + "</div>";
        }
      }
    }
    ajax.send("asset_id=" + asset_id + "&asset_name=" + asset_name + "&system_id=" + system_id);
  }
}

function edit_asset_cancel_btn_click() {
  document.getElementById("edit_asset_panel").style.visibility = "hidden";
}

function list_entry_for_edit_link_click(id, name) {
  entry_id = id;
  entry_name = name;

  document.getElementById("edit_entry_id").value = entry_id;
  document.getElementById("edit_entry_name").value = entry_name;
  document.getElementById("edit_entry_panel").style.visibility = "visible";
}

function edit_entry_save_btn_click() {
  var entry_id = document.getElementById("edit_entry_id").value;
  var entry_name = document.getElementById("edit_entry_name").value;
  if (entry_name !== "") {
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/edit/edit_option.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Updated Successfully...!") {
          document.getElementById("edit_entry_option_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
            + this.responseText + "</div>";
          setTimeout(function () {
            document.getElementById("edit_entry_panel").style.visibility = "hidden";
            document.getElementById("edit_entry_name").value = "";
            document.getElementById("edit_entry_option_panel_messageDiv").innerHTML = "";
            refresh_entries_for_customized_options();
            refresh_entries_for_admin_entry_options();
          }, 700);
        }
        else {
          document.getElementById("edit_entry_option_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
            + this.responseText + "</div>";
        }
      }
    }
    ajax.send("entry_id=" + entry_id + "&entry_name=" + entry_name + "&system_id=" + system_id);
  }
}

function edit_entry_delete_btn_click() {
  if (confirm("Are you sure to delete it...?")) {
    var entry_id = document.getElementById("edit_entry_id").value;
    var entry_name = document.getElementById("edit_entry_name").value;  
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/delete/delete_option.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Deleted Successfully...!") {
          document.getElementById("edit_entry_option_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
            + this.responseText + "</div>";
          setTimeout(function () {
            document.getElementById("edit_entry_panel").style.visibility = "hidden";
            document.getElementById("edit_entry_name").value = "";
            document.getElementById("edit_entry_option_panel_messageDiv").innerHTML = "";
            refresh_entries_for_customized_options();
            refresh_entries_for_admin_entry_options();
          }, 700);
        }
        else {
          document.getElementById("edit_entry_option_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
            + this.responseText + "</div>";
        }
      }
    }
    ajax.send("entry_id=" + entry_id + "&entry_name=" + entry_name + "&system_id=" + system_id);
  }
}

function edit_entry_cancel_btn_click() {
  document.getElementById("edit_entry_panel").style.visibility = "hidden";
}

function list_report_for_edit_link_click(id, name, type) {
  document.getElementById("edit_report_id").value = id;
  document.getElementById("edit_report_name").value = name;
  // if(type !== "report"){
  //   document.getElementById("edit_report_type").value = "Multi Table";
  // }
  // else{
  //   document.getElementById("edit_report_type").value = "Single Table";
  // }
  document.getElementById("edit_report_panel").style.visibility = "visible";
}

function edit_report_save_btn_click() {
  var report_id = document.getElementById("edit_report_id").value;
  var report_name = document.getElementById("edit_report_name").value;
  if (report_name !== "") {
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/edit/edit_option.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Updated Successfully...!") {
          document.getElementById("edit_report_option_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
            + this.responseText + "</div>";
          setTimeout(function () {
            document.getElementById("edit_report_panel").style.visibility = "hidden";
            document.getElementById("edit_report_name").value = "";
            document.getElementById("edit_report_option_panel_messageDiv").innerHTML = "";
            refresh_reports_for_customized_options();
            refresh_reports_for_admin_report_options();
          }, 700);
        }
        else {
          document.getElementById("edit_report_option_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
            + this.responseText + "</div>";
        }
      }
    }
    ajax.send("report_id=" + report_id + "&report_name=" + report_name + "&system_id=" + system_id);
  }
}

function edit_report_delete_btn_click() {
  if (confirm("Are you sure to delete it...?")) {
    var report_id = document.getElementById("edit_report_id").value;
    var report_name = document.getElementById("edit_report_name").value;  
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/delete/delete_option.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Deleted Successfully...!") {
          document.getElementById("edit_report_option_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
            + this.responseText + "</div>";
          setTimeout(function () {
            document.getElementById("edit_report_panel").style.visibility = "hidden";
            document.getElementById("edit_report_name").value = "";
            document.getElementById("edit_report_option_panel_messageDiv").innerHTML = "";
            refresh_reports_for_customized_options();
            refresh_reports_for_admin_report_options();
          }, 700);
        }
        else {
          document.getElementById("edit_report_option_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
            + this.responseText + "</div>";
        }
      }
    }
    ajax.send("report_id=" + report_id + "&report_name=" + report_name + "&system_id=" + system_id);
  }
}

function edit_report_cancel_btn_click() {
  document.getElementById("edit_report_panel").style.visibility = "hidden";
}

function list_custom_table_for_edit_link_click(id, name) {
  document.getElementById("edit_custom_table_id").value = id;
  document.getElementById("edit_custom_table_name").value = name;
  document.getElementById("edit_custom_table_panel").style.visibility = "visible";
}

function edit_custom_table_save_btn_click() {
  var custom_table_id = document.getElementById("edit_custom_table_id").value;
  var custom_table_name = document.getElementById("edit_custom_table_name").value;
  if (custom_table_name !== "") {
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/edit/edit_option.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Updated Successfully...!") {
          document.getElementById("edit_custom_table_option_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
            + this.responseText + "</div>";
          setTimeout(function () {
            document.getElementById("edit_custom_table_panel").style.visibility = "hidden";
            document.getElementById("edit_custom_table_name").value = "";
            document.getElementById("edit_custom_table_option_panel_messageDiv").innerHTML = "";
            refresh_custom_tables_for_customized_options();
            refresh_custom_tables_for_edit_options();
          }, 700);
        }
        else {
          document.getElementById("edit_custom_table_option_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
            + this.responseText + "</div>";
        }
      }
    }
    ajax.send("custom_table_id=" + custom_table_id + "&custom_table_name=" + custom_table_name + "&system_id=" + system_id);
  }
}

function edit_custom_table_delete_btn_click() {
  if (confirm("Are you sure to delete it...?")) {
    var custom_table_id = document.getElementById("edit_custom_table_id").value;
    var custom_table_name = document.getElementById("edit_custom_table_name").value;  
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/delete/delete_option.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Deleted Successfully...!") {
          document.getElementById("edit_custom_table_option_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
            + this.responseText + "</div>";
          setTimeout(function () {
            document.getElementById("edit_custom_table_panel").style.visibility = "hidden";
            document.getElementById("edit_custom_table_name").value = "";
            document.getElementById("edit_custom_table_option_panel_messageDiv").innerHTML = "";
            refresh_custom_tables_for_customized_options();
            refresh_custom_tables_for_edit_options();
          }, 700);
        }
        else {
          document.getElementById("edit_custom_table_option_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
            + this.responseText + "</div>";
        }
      }
    }
    ajax.send("custom_table_id=" + custom_table_id + "&custom_table_name=" + custom_table_name + "&system_id=" + system_id);
  }
}

function edit_custom_table_cancel_btn_click() {
  document.getElementById("edit_custom_table_panel").style.visibility = "hidden";
}

// Start functionalities of sub options............!

function add_option_btn_click() {
  if(document.getElementById("report_id_options_panels_dev")){
    // add_report_option_btn_click();
    if(document.getElementById("report_type_options_panels_dev").innerHTML === "Multi Table"){
      document.getElementById("mt_report_add_panel").style.visibility = "visible";
    }
    else{
      document.getElementById("report_add_panel").style.visibility = "visible";
    }
  }
  else{
    document.getElementById("add_panel").style.visibility = "visible";
  }
}

function add_panel_close_btn_click() {
  document.getElementById("add_panel").style.visibility = "hidden";
  document.getElementById("report_add_panel").style.visibility = "hidden";
  document.getElementById("mt_report_add_panel").style.visibility = "hidden";
}

function add_report_option_btn_click() {
  document.getElementById("report_add_panel").style.visibility = "hidden";
  document.getElementById("add_report_sub_options_panel").style.visibility = "visible";
  document.getElementById("add_report_sub_options_panel_content").innerHTML = '<br>'
  + '<div class="page-header text-center">'
  +    '<h2>Option(Report)</h2>'
  + '</div>'
  + '<div id="add_sub_options_panel_messageDiv"></div>'
  + '<input type="hidden" id="field_type" value="Report">'
  + '<div class="form-group">'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Select Table</span>'
  +     '</div>'
  +     '<select id="report_select_table" class="form-control form-control-sm select2-single"></select>'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Select Column</span>'
  +     '</div>'
  +     '<select id="report_select_column" class="form-control form-control-sm select2-single"></select>'
  + '</div>'
  + '<div class="form-group" id="report_column_div">'
  + '</div>'
  + '<div class="form-group">'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Is Heading</span>'
  +     '</div>'
  +     '<select id="report_is_heading" class="form-control form-control-sm select2-single">'
  +       '<option>False</option>'
  +       '<option>True</option>'
  +     '</select>'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Is Visible</span>'
  +     '</div>'
  +     '<select id="report_is_visible" class="form-control form-control-sm select2-single">'
  +       '<option>True</option>'
  +       '<option>False</option>'
  +     '</select>'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Is Filter</span>'
  +     '</div>'
  +     '<select id="report_is_filter" class="form-control form-control-sm select2-single">'
  +       '<option>True</option>'
  +       '<option>False</option>'
  +     '</select>'
  + '</div>';
  report_coulmn_type_change();
  refresh_tables_in_select("reports_tables");
  document.getElementById("report_select_table").onchange = function(){
    refresh_columns_in_select("report_select_column", document.getElementById("report_select_table").value);
  }
}

function report_coulmn_div_html(){
  var str = "";
  if(document.getElementById("report_select_column_type") && document.getElementById("report_select_column_type").value === "Number"){
    str = '<div class="input-group-prepend">'
    +         '<span class="btn red btn-sm">Column Name</span>'
    +     '</div>'
    +     '<input id="report_column_name" placeholder="Column Name" class="form-control form-control-sm">'
    +     '<div class="input-group-prepend">'
    +         '<span class="btn red btn-sm">Column Type</span>'
    +     '</div>'
    +     '<select id="report_select_column_type" class="form-control form-control-sm select2-single" onchange="report_coulmn_type_change()">'
    +     '<option>Text</option>'
    +     '<option>Number</option>';
    if(!document.getElementById("report_against_table")){
      str += '<option>Date</option>';
    }
    str += '</select>'
    +     '<div class="input-group-prepend">'
    +         '<span class="btn red btn-sm">Entry Sum</span>'
    +     '</div>'
    +     '<select id="report_entry_sum" class="form-control form-control-sm select2-single">'
    +     '<option>False</option>'
    +     '<option>True</option>'
    +     '</select>';
  }
  else{
    str = '<div class="input-group-prepend">'
    +         '<span class="btn red btn-sm">Column Name</span>'
    +     '</div>'
    +     '<input id="report_column_name" placeholder="Column Name" class="form-control form-control-sm">'
    +     '<div class="input-group-prepend">'
    +         '<span class="btn red btn-sm">Column Type</span>'
    +     '</div>'
    +     '<select id="report_select_column_type" class="form-control form-control-sm select2-single" onchange="report_coulmn_type_change()">'
    +     '<option>Text</option>'
    +     '<option>Number</option>';
    if(!document.getElementById("report_against_table")){
      str += '<option>Date</option>';
    }
    str += '</select>';
  }
  return str;
}

function report_coulmn_type_change(){
  var val = "";
  var nam = "";
  val = "Text";
  if(document.getElementById("report_select_column_type")){
    val = document.getElementById("report_select_column_type").value;
    nam = document.getElementById("report_column_name").value;
  }
  document.getElementById("report_column_div").innerHTML = report_coulmn_div_html();
  document.getElementById("report_select_column_type").value = val;
  document.getElementById("report_select_column_type").focus();
  document.getElementById("report_column_name").value = nam;
}

function add_formulated_report_option_btn_click() {
  document.getElementById("report_add_panel").style.visibility = "hidden";
  document.getElementById("add_report_sub_options_panel").style.visibility = "visible";
  document.getElementById("add_report_sub_options_panel_content").innerHTML = '<br>'
  + '<div class="page-header text-center">'
  +    '<h2>Option(Report)</h2>'
  + '</div>'
  + '<div id="add_sub_options_panel_messageDiv"></div>'
  + '<input type="hidden" id="field_type" value="Report">'
  + '<div class="form-group">'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Select Table</span>'
  +     '</div>'
  +     '<select id="report_select_table" class="form-control form-control-sm select2-single"></select>'
  + '</div>'
  + '<div class="form-group">'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Column Name</span>'
  +     '</div>'
  +     '<input id="report_column_name" placeholder="Column Name" class="form-control form-control-sm">'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Column Type</span>'
  +     '</div>'
  +     '<select id="report_select_column_type" class="form-control form-control-sm select2-single">'
  +     '<option>Number</option>'
  +     '</select>'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Entry Sum</span>'
  +     '</div>'
  +     '<select id="report_entry_sum" class="form-control form-control-sm select2-single">'
  +     '<option>False</option>'
  +     '<option>True</option>'
  +     '</select>'
  + '</div>'
  + '<div class="form-group">'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Is Visible</span>'
  +     '</div>'
  +     '<select id="report_is_visible" class="form-control form-control-sm select2-single">'
  +       '<option>True</option>'
  +       '<option>False</option>'
  +     '</select>'
  + '</div>'
  + '<div>'
  +    '<button style="float: right; margin-bottom: 5px;" class="btn btn-default" onclick="add_formula_btn_click()"><span class="fa fa-plus"></span> Add Formula</button>'
  +    '<button style="float: right; margin-bottom: 5px;margin-right: 5px;" class="btn btn-default" onclick="reset_formula_btn_click()"><span class="fa fa-undo"></span> Reset Formula</button>'
  + '</div>'
  + '<div id="formulas_div"></div>';
  refresh_tables_in_select("reports_tables");
  document.getElementById("report_select_table").onchange = function(){
    refresh_columns_in_select("report_select_column", document.getElementById("report_select_table").value);
  }
}

function add_grouped_report_option_btn_click() {
  document.getElementById("report_add_panel").style.visibility = "hidden";
  document.getElementById("add_report_sub_options_panel").style.visibility = "visible";
  document.getElementById("add_report_sub_options_panel_content").innerHTML = '<br>'
  + '<div class="page-header text-center">'
  +    '<h2>Option(Report)</h2>'
  + '</div>'
  + '<div id="add_sub_options_panel_messageDiv"></div>'
  + '<input type="hidden" id="field_type" value="Report">'
  + '<div class="form-group">'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Select Table</span>'
  +     '</div>'
  +     '<select id="report_select_table" class="form-control form-control-sm select2-single"></select>'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Select Column</span>'
  +     '</div>'
  +     '<select id="report_select_column" class="form-control form-control-sm select2-single"></select>'
  + '</div>'
  + '<div class="form-group">'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Against Table</span>'
  +     '</div>'
  +     '<select id="report_against_table" class="form-control form-control-sm select2-single"></select>'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Against Column</span>'
  +     '</div>'
  +     '<select id="report_against_column" class="form-control form-control-sm select2-single"></select>'
  + '</div>'
  + '<div class="form-group" id="report_column_div">'
  + '</div>'
  + '<div class="form-group">'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Is Heading</span>'
  +     '</div>'
  +     '<select id="report_is_heading" class="form-control form-control-sm select2-single">'
  +       '<option>False</option>'
  +       '<option>True</option>'
  +     '</select>'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Is Visible</span>'
  +     '</div>'
  +     '<select id="report_is_visible" class="form-control form-control-sm select2-single">'
  +       '<option>True</option>'
  +       '<option>False</option>'
  +     '</select>'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Is Filter</span>'
  +     '</div>'
  +     '<select id="report_is_filter" class="form-control form-control-sm select2-single">'
  +       '<option>True</option>'
  +       '<option>False</option>'
  +     '</select>'
  + '</div>';
  report_coulmn_type_change();
  refresh_tables_in_select("reports_tables");
  refresh_tables_in_select("reports_against_tables");
  document.getElementById("report_select_table").onchange = function(){
    refresh_columns_in_select("report_select_column", document.getElementById("report_select_table").value);
  }
  if(document.getElementById("report_against_table")){
    document.getElementById("report_against_table").onchange = function(){
      refresh_columns_in_select("report_against_column", document.getElementById("report_against_table").value);
    }
  }
}

function report_reset_columns_btn_click(){
  document.getElementById("report_columns_div").innerHTML = "";
  report_columns_no = 0;
}

function add_mt_report_parameters_btn_click(){
  document.getElementById("mt_report_add_panel").style.visibility = "hidden";
  document.getElementById("add_report_sub_options_panel").style.visibility = "visible";
  document.getElementById("add_report_sub_options_panel_content").innerHTML = '<br>'
  + '<div class="page-header text-center">'
  +    '<h2>Option(Report)</h2>'
  + '</div>'
  + '<div id="add_sub_options_panel_messageDiv"></div>'
  + '<input type="hidden" id="field_type" value="parameter">'
  + '<div class="form-group">'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Select Table</span>'
  +     '</div>'
  +     '<select id="report_select_table" class="form-control form-control-sm select2-single"></select>'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Select Column</span>'
  +     '</div>'
  +     '<select id="report_select_column" class="form-control form-control-sm select2-single"></select>'
  + '</div>'
  + '<div class="form-group" id="report_column_div">'
  + '</div>'
  + '<div class="form-group">'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Is Heading</span>'
  +     '</div>'
  +     '<select id="report_is_heading" class="form-control form-control-sm select2-single">'
  +       '<option>False</option>'
  +       '<option>True</option>'
  +     '</select>'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Is Visible</span>'
  +     '</div>'
  +     '<select id="report_is_visible" class="form-control form-control-sm select2-single">'
  +       '<option>True</option>'
  +       '<option>False</option>'
  +     '</select>'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Is Filter</span>'
  +     '</div>'
  +     '<select id="report_is_filter" class="form-control form-control-sm select2-single">'
  +       '<option>True</option>'
  +       '<option>False</option>'
  +     '</select>'
  + '</div>';
  report_coulmn_type_change();
  refresh_tables_in_select("parameters_tables");
  document.getElementById("report_select_table").onchange = function(){
    if(document.getElementById("report_select_table").value === "Date"){
      document.getElementById("report_select_column").innerHTML = "<option>Date</option>";
    }
    else{
      refresh_columns_in_select("report_select_column", document.getElementById("report_select_table").value);
    }
  }
}

function add_mt_report_option_btn_click() {
  document.getElementById("mt_report_add_panel").style.visibility = "hidden";
  document.getElementById("add_report_sub_options_panel").style.visibility = "visible";
  document.getElementById("add_report_sub_options_panel_content").innerHTML = '<br>'
  + '<div class="page-header text-center">'
  +    '<h2>Option(Report)</h2>'
  + '</div>'
  + '<div id="add_sub_options_panel_messageDiv"></div>'
  + '<input type="hidden" id="field_type" value="Report">'
  + '<div class="form-group" id="report_column_div">'
  + '</div>'
  + '<div class="form-group">'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Select Table</span>'
  +     '</div>'
  +     '<select id="report_select_table" class="form-control form-control-sm select2-single"></select>'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Select Column</span>'
  +     '</div>'
  +     '<select id="report_select_column" class="form-control form-control-sm select2-single"></select>'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Selection As</span>'
  +     '</div>'
  +     '<select id="report_select_selection" class="form-control form-control-sm select2-single">'
  +     '<option>DISTINCT</option>'
  +     '<option>SUM</option>'
  +     '</select>'
  + '</div>'
  + '<div class="form-group">'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Is Heading</span>'
  +     '</div>'
  +     '<select id="report_is_heading" class="form-control form-control-sm select2-single">'
  +       '<option>False</option>'
  +       '<option>True</option>'
  +     '</select>'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Is Visible</span>'
  +     '</div>'
  +     '<select id="report_is_visible" class="form-control form-control-sm select2-single">'
  +       '<option>True</option>'
  +       '<option>False</option>'
  +     '</select>'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Is Filter</span>'
  +     '</div>'
  +     '<select id="report_is_filter" class="form-control form-control-sm select2-single">'
  +       '<option>True</option>'
  +       '<option>False</option>'
  +     '</select>'
  + '</div>'
  + '<button style="float: right;" class="btn btn-default" onclick="add_parmeters_btn_click()"><span class="fa fa-plus"> </span> Add Parameter</button>'
  + '<button style="float: right; margin-right: 5px;" class="btn btn-default" onclick="reset_parmeters_btn_click()"><span class="fa fa-undo"> </span> Reset Parameter</button><br><br>'
  + '<div id="parameters_div">'
  + '</div>';
  report_coulmn_type_change();
  refresh_tables_in_select("reports_tables");
  if(document.getElementById("report_select_table")){
    document.getElementById("report_select_table").onchange = function(){
      refresh_columns_in_select("report_select_column", document.getElementById("report_select_table").value);
    }
  }
}

function add_mt_formulated_report_option_btn_click() {
  document.getElementById("mt_report_add_panel").style.visibility = "hidden";
  document.getElementById("add_report_sub_options_panel").style.visibility = "visible";
  document.getElementById("add_report_sub_options_panel_content").innerHTML = '<br>'
  + '<div class="page-header text-center">'
  +    '<h2>Option(Report)</h2>'
  + '</div>'
  + '<div id="add_sub_options_panel_messageDiv"></div>'
  + '<input type="hidden" id="field_type" value="Report">'
  + '<input type="hidden" id="report_select_column_type" value="Number" class="form-control form-control-sm select2-single">'
  + '<div class="form-group">'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Column Name</span>'
  +     '</div>'
  +     '<input id="report_column_name" placeholder="Column Name" class="form-control form-control-sm">'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Entry Sum</span>'
  +     '</div>'
  +     '<select id="report_entry_sum" class="form-control form-control-sm select2-single">'
  +         '<option>False</option>'
  +         '<option>True</option>'
  +     '</select>'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Is Visible</span>'
  +     '</div>'
  +     '<select id="report_is_visible" class="form-control form-control-sm select2-single">'
  +       '<option>True</option>'
  +       '<option>False</option>'
  +     '</select>'
  + '</div>'
  + '<div>'
  +    '<button style="float: right;" class="btn btn-default" onclick="add_mt_report_formula_btn_click()"><span class="fa fa-plus"></span> Add Formula</button>'
  +    '<button style="float: right; margin-right: 5px;" class="btn btn-default" onclick="reset_mt_report_formula_btn_click()"><span class="fa fa-undo"></span> Reset Formula</button>'
  +    '<button style="float: right; margin-right: 5px;" class="btn btn-default" onclick="add_parmeters_btn_click()"><span class="fa fa-plus"> </span> Add Parameter</button>'
  +    '<button style="float: right; margin-right: 5px;" class="btn btn-default" onclick="reset_parmeters_btn_click()"><span class="fa fa-undo"> </span> Reset Parameter</button><br><br>'
  + '</div>'
  + '<div id="mt_formulas_div"></div>';

  reset_mt_report_formula_btn_click();
}

var parameters_fields = 0;
function add_parmeters_btn_click(){
  if(document.getElementById("parameters_div_"+index_of_formulas_fields_mt_report)){
    document.getElementById("parameters_div_"+index_of_formulas_fields_mt_report).innerHTML += add_parameter();
  }
  else{
    document.getElementById("parameters_div").innerHTML += add_parameter();
  }
  refresh_parameters_in_select(parameters_fields);
  parameters_fields++;
  parameters_fields_in_formula[index_of_formulas_fields_mt_report] = parameters_fields;
}

function reset_parmeters_btn_click(){
  if(document.getElementById("parameters_div_"+index_of_formulas_fields_mt_report)){
    document.getElementById("parameters_div_"+index_of_formulas_fields_mt_report).innerHTML = "";
  }
  else{
    document.getElementById("parameters_div").innerHTML = "";
  }
  parameters_fields = 0;
  add_parmeters_btn_click();
}

function add_parameter(){
  var str = "";
  if(document.getElementById("parameters_div_"+index_of_formulas_fields_mt_report)){
    str = '<div class="form-group">'
    +     '<div class="input-group-prepend">'
    +         '<span class="btn red btn-sm">Parameter Table</span>'
    +     '</div>'
    +     '<select id="report_parameter_table_'+index_of_formulas_fields_mt_report+'_'+parameters_fields+'" class="form-control form-control-sm report_parameter_select_tables select2-single" onchange="report_select_table_change('+parameters_fields+')"></select>'
    +     '<div class="input-group-prepend">'
    +         '<span class="btn red btn-sm">Parameter Column</span>'
    +     '</div>'
    +     '<select id="report_parameter_column_'+index_of_formulas_fields_mt_report+'_'+parameters_fields+'" class="form-control form-control-sm report_parameter_select_columns select2-single"></select>'
    +     '<div class="input-group-prepend">'
    +         '<span class="btn red btn-sm">Against Column</span>'
    +     '</div>'
    +     '<select id="report_against_column_'+index_of_formulas_fields_mt_report+'_'+parameters_fields+'" class="form-control form-control-sm report_parameter_against_columns select2-single"></select>'
    + '</div>';
  }
  else{
    str = '<div class="form-group">'
    +     '<div class="input-group-prepend">'
    +         '<span class="btn red btn-sm">Parameter Table</span>'
    +     '</div>'
    +     '<select id="report_parameter_table_'+parameters_fields+'" class="form-control form-control-sm report_parameter_select_tables select2-single" onchange="report_select_table_change('+parameters_fields+')"></select>'
    +     '<div class="input-group-prepend">'
    +         '<span class="btn red btn-sm">Parameter Column</span>'
    +     '</div>'
    +     '<select id="report_parameter_column_'+parameters_fields+'" class="form-control form-control-sm report_parameter_select_columns select2-single"></select>'
    +     '<div class="input-group-prepend">'
    +         '<span class="btn red btn-sm">Against Column</span>'
    +     '</div>'
    +     '<select id="report_against_column_'+parameters_fields+'" class="form-control form-control-sm report_parameter_against_columns select2-single"></select>'
    + '</div>';
  }
  return str;
}

function report_select_table_change(p_f){
  if(document.getElementById("parameters_div_"+index_of_formulas_fields_mt_report)){
    if(document.getElementById("report_parameter_table_"+index_of_formulas_fields_mt_report+"_"+p_f).value === "Date"){
      document.getElementById("report_parameter_column_"+index_of_formulas_fields_mt_report+"_"+p_f).innerHTML = "<option>Date</option>";
    }
    else{
      refresh_columns_in_select("report_parameter_column_"+index_of_formulas_fields_mt_report+"_"+p_f, document.getElementById("report_parameter_table_"+index_of_formulas_fields_mt_report+"_"+p_f).value);
    }
  }
  else{
    if(document.getElementById("report_parameter_table_"+p_f).value === "Date"){
      document.getElementById("report_parameter_column_"+p_f).innerHTML = "<option>Date</option>";
    }
    else{
      refresh_columns_in_select("report_parameter_column_"+p_f, document.getElementById("report_parameter_table_"+p_f).value);
    }
  }
}

function add_normal_option_btn_click(isEdit) {
  document.getElementById("add_panel").style.visibility = "hidden";
  document.getElementById("add_sub_options_panel").style.visibility = "visible";
  document.getElementById("add_sub_option_heading").innerHTML = 'Option(Simple)'
  var str = '<br>'
  + '<div id="add_sub_options_panel_messageDiv"></div>'
  + '<div class="row">'
  +   '<input type="hidden" id="field_type" value="Normal">'
  +   '<input type="hidden" id="sub_option_id" class="form-control form-control-sm" placeholder="Option ID">'
  + '<div class="col-md-6">'
  + '<div class="form-group">'
  +     '<div class="input-group-prepend">'
  +         '<span class="btn red btn-sm">Option Name</span>'
  +     '</div>'
  +     '<input type="text" id="add_option_name" class="form-control form-control-sm" placeholder="Option Name" >'
  + '</div>'
  + '</div>'
  + '</div>'
  + '<div class="row" id="add_option_opt_type_and_othr_src_div"></div>'
  + '<div class="row" id="extra_options_div" class="jumbotron lesspadding" style="visibility: hidden; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; z-index: 5;">'
  + '<div class="col-sm-12">'
  + '<div class="input-group mb3">'
  +    '<div class="input-group-prepend">'
  +      '<span class="btn label-fill btn-sm">Add Option Value</span>'
  +    '</div>'
  +    '<input type="text" id="add_option_input" class="form-control form-control-sm" placeholder="Add Option Value">'
  +    '<div class="input-group-append">'
  +     '<button class="input-group-text btn btn-success" onclick="add_options_add_btn_click()"><span class="fa fa-arrow-right"></span></button>'
  +     '<button class="input-group-text btn btn-danger" onclick="close_option_btn_click()"><span class="fa fa-times"></span></button>'
  +    '</div>'
  + '</div>'
  + '</div>'
  + '</div>'
  + '<div class="row" id="extra_values_div"></div>'
  + '<div class="row" id="value_from_other_src_div"></div>'
  + '<div class="row" id="other_sources_div"></div>'
  + '<div class="row" id="entry_options_div"></div>'
  + '<div class="row" id="entry_custom_storage_options_div"></div>'
  if(isEdit){
    str += edit_options()
  }

  document.getElementById("add_sub_options_panel_content").innerHTML = str
  if(isEdit){
    document.getElementById("add_sub_options_panel_buttons_div").innerHTML = '<button style="float:right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="add_option_save_btn_click()"><span class="fa fa-save"> </span> Save</button>'
    + '<button style="float: right; margin-left: 5px;" class="btn btn-sm btn-danger" onclick="settings_option_delete_btn_click()"><span class="fa fa-trash"> </span> Delete</button>'
    // + '<button style="float:right;" class="btn btn-sm btn-secondary" onclick="add_sub_option_panel_close_btn_click()"><span class="fa fa-times"> </span> Cancel</button>'
    str += edit_options()
  }
  else{
    document.getElementById("add_sub_options_panel_buttons_div").innerHTML = '<button style="float:right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="add_option_save_btn_click()"><span class="fa fa-save"> </span> Save</button>'
  }
  custom_table_options_div_show();
  add_option_input_change();
  entry_options_div_show();
  $('.select2-single').select2();
}

function edit_options(){
  var str = '<div class="row">'
    + '<div class="col-md-6">'
    + '<div class="form-group">'
    +     '<div class="input-group-prepend">'
    +         '<span class="btn red btn-sm">Priority</span>'
    +     '</div>'
    +     '<input type="text" id="add_option_priority" class="form-control form-control-sm" >'
    + '</div>'
    + '</div>' 
    + '<div class="col-md-6">'
    + '<div class="form-group">'
    +     '<div class="input-group-prepend">'
    +         '<span class="btn red btn-sm">Status</span>'
    +     '</div>'
    +   '<select id="add_option_status" type="text" class="form-control form-control-sm select2-single" onchange="add_option_other_sources_input_change()">'
    +      '<option>Activate</option>'
    +      '<option>Deactivate</option>'
    +   '</select>'
    + '</div>'
    + '</div>'       
    + '</div>'
  return str
}

function add_sub_option_panel_close_btn_click() {
  document.getElementById("add_report_sub_options_panel").style.visibility = "hidden";
  document.getElementById("add_sub_options_panel").style.visibility = "hidden";
}

function add_formulated_option_btn_click(isEdit) {
  document.getElementById("add_panel").style.visibility = "hidden";
  document.getElementById("add_sub_options_panel").style.visibility = "visible";
  document.getElementById("add_sub_option_heading").innerHTML = 'Option(Formulated)'
  var str = '<br>'
  + '<div id="add_sub_options_panel_messageDiv"></div>'
  + '<div class="row">'
  + '<input type="hidden" id="field_type" value="Formulated">'
  +   '<input type="hidden" id="sub_option_id" class="form-control form-control-sm" placeholder="Option ID">'
  + '<div class="col-sm-12">'
  +       '<span class="btn red btn-sm">Option Name</span>'
  +    '<input type="text" id="add_option_name" class="form-control form-control-sm" placeholder="Option Name">'
  + '</div>'
  + '</div>'
  + '<div class="row" id="add_option_opt_type_and_othr_src_div"></div>'
  + '<div class="row">'
  + '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">'
  +        '<span class="btn red btn-sm">Editable</span>'
  +    '<select id="add_option_editable" class="form-control form-control-sm select2-single">'
  +      '<option>False</option>'
  +      '<option>True</option>'
  +    '</select>'
  + '</div>'
  + '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">'
  +        '<span class="btn red btn-sm">Visible</span>'
  +    '<select id="add_option_visible" class="form-control form-control-sm select2-single">'
  +     '<option>False</option>'
  +     '<option>True</option>'
  +    '</select>'
  + '</div>'
  + '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">'
  +        '<span class="btn red btn-sm">Table Visible</span>'
  +    '<select id="add_option_table_visible" class="form-control form-control-sm select2-single">'
  +     '<option>True</option>'
  +     '<option>False</option>'
  +    '</select>'
  + '</div>'
  + '</div>'
  + '<div class="row" id="entry_options_div"></div>'
  + '<div class="row" id="entry_custom_storage_options_div"></div>'
  if(isEdit){
    str += edit_options()
  }
  str += '<div class="row" style="margin-top: 20px;">'
  + '<div class="col-md-12">'
  +    '<button style="float: right;" class="btn btn-default" onclick="add_formula_btn_click()"><span class="fa fa-plus"></span> Add Formula</button>'
  +    '<button style="float: right; margin-right: 5px;" class="btn btn-default" onclick="reset_formula_btn_click()"><span class="fa fa-undo"></span> Reset Formula</button>'
  + '</div>'
  + '</div>'
  + '<div class="row" style="padding-top: 20px;"><div class="col-12" id="formulas_div"></div></div>'
  document.getElementById("add_sub_options_panel_content").innerHTML = str
  document.getElementById("formulas_div").innerHTML = "<div class='col-md-12'><table id='formulas_table' style='width: 100%'></table></div>";
  if(isEdit){
    document.getElementById("add_sub_options_panel_buttons_div").innerHTML = '<button style="float:right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="add_option_save_btn_click()"><span class="fa fa-save"> </span> Save</button>'
    + '<button style="float: right; margin-left: 5px;" class="btn btn-sm btn-danger" onclick="settings_option_delete_btn_click()"><span class="fa fa-trash"> </span> Delete</button>'
    // + '<button style="float:right;" class="btn btn-sm btn-secondary" onclick="add_sub_option_panel_close_btn_click()"><span class="fa fa-times"> </span> Cancel</button>'
    str += edit_options()
  }
  else{
    document.getElementById("add_sub_options_panel_buttons_div").innerHTML = '<button style="float:right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="add_option_save_btn_click()"><span class="fa fa-save"> </span> Save</button>'
  }
  index_of_formulas_fields = 0;
  add_formula_btn_click();
  custom_table_options_div_show("formulated");
  entry_options_div_show();

  $('.select2-single').select2()
}

function add_formula_row_click(){
  // var rows_to_added = document.getElementById("add_rows").value;
  adding_rows(1);
}

function adding_rows(rows_to_be_added){
  for(add_rows = 0; add_rows<rows_to_be_added; add_rows++){
    var index = document.getElementById("formulas_table").rows.length
    var tbody = document.getElementById("formulas_table")
    var row = tbody.insertRow(index)
    // var cell_0 = row.insertCell(0)
    // cell_0.innerHTML = '<div class="form-group">'
    // + '<label class="col-form-label col-form-label-sm red">Option Name</label><br>'
    // + '<select id="formula_' + index_of_formulas_fields + '_field_1" class="form-control form-control-sm" onchange="set_onchange_formula_select('+index_of_formulas_fields+')"">'
    // + '</select>'
    // + '</div>'
    row.innerHTML = formula_row(index)

    var table_name = "";
    if(document.getElementById("entry_id_options_panels_dev")){
      table_name = "entry_"+document.getElementById("entry_id_options_panels_dev").innerHTML;
    }
    else if(document.getElementById("asset_id_options_panels_dev")){
      table_name = "asset_"+document.getElementById("asset_id_options_panels_dev").innerHTML;
    }
    else if(document.getElementById("report_select_table")){
      table_name = document.getElementById("report_select_table").value;
    }

    refresh_options('formula_'+index+'_field_1', table_name);
    refresh_options('formula_'+index+'_field_2', table_name);

    if(document.getElementById('formula_'+index+'_field_1')){
      $('#formula_'+index+'_field_1').select2()
      document.getElementById('formula_'+index+'_field_1').onchange()
    }
    
    if(document.getElementById('formula_'+index+'_field_2')){
      $('#formula_'+index+'_field_2').select2()
      if(typeof document.getElementById('formula_'+index+'_field_2').onchange == "function"){
        document.getElementById('formula_'+index+'_field_2').onchange()
      }
    }
    if(document.getElementById('formula_'+index+'_operator_1')){
      $('#formula_'+index+'_operator_1').select2()
    }

    // purchase_invoice_commission_holder_type_onchange(index)

    // purchase_invoice_button_set_onclick(index)

    // document.getElementById("commission_holder_type_"+index).onchange()
    
    // if(add_rows == rows_to_be_added-1){
      // document.getElementById("commission_holder_type_"+(index - (rows_to_be_added-1))).focus()
    // }
  }
}

function formula_row(index_of_formulas_fields){
  var str = ""
  if (index_of_formulas_fields === 0) {
    str = ''
      + '<td style="width: 20%">'
      + '<label class="col-form-label col-form-label-sm red">Option Name</label><br>'
      + '<select id="formula_' + index_of_formulas_fields + '_field_1" class="form-control form-control-sm" onchange="set_onchange_formula_select('+index_of_formulas_fields+')"">'
      + '</select>'
      + '</td>'
      + '<td style="width: 20%">'
      + '<div id="formula_span_div' + index_of_formulas_fields + '_field_1">'
      + '</div>'
      + '<input type="hidden" id="formula_custom' + index_of_formulas_fields + '_field_1" class="form-control form-control-sm" style="width: auto;">'
      + '</td>'
      + '<td style="width: 20%">'
      + '<label class="col-form-label col-form-label-sm red">Operator</label><br>'
      + '<select id="formula_' + index_of_formulas_fields + '_operator_1" class="form-control form-control-sm" style="width: auto;">'
      + '<option>Sum</option>'
      + '<option>Subtract</option>'
      + '<option>Multiplication</option>'
      + '<option>Division</option>'
      + '<option>Modulus</option>'
      + '</select>'
      + '</td>'
      + '<td style="width: 20%">'
      + '<label class="col-form-label col-form-label-sm red">Option Name</label><br>'
      + '<select id="formula_' + index_of_formulas_fields + '_field_2" class="form-control form-control-sm" onchange="set_onchange_formula_select_2('+index_of_formulas_fields+')"">'
      + '</select>'
      + '</td>'
      + '<td style="width: 20%">'
      + '<div id="formula_span_div' + index_of_formulas_fields + '_field_2">'
      + '</div>'
      + '<input type="hidden" id="formula_custom' + index_of_formulas_fields + '_field_2" class="form-control form-control-sm ">'
      + '</div>'
      + '</td>'
  }
  else {
    str = ''
      + '<td style="width: 30%">'
      + '<span class="btn red btn-sm">Operator</span><br>'
      + '<select id="formula_' + index_of_formulas_fields + '_operator_1" class="form-control form-control-sm select2-single">'
      + '<option>Sum</option>'
      + '<option>Subtract</option>'
      + '<option>Multiplication</option>'
      + '<option>Division</option>'
      + '<option>Modulus</option>'
      + '</select>'
      + '</td>'
      + '<td colspan="2" style="width: 35%">'
      + '<span class="btn red btn-sm">Option Name</span><br>'
      + '<select id="formula_' + index_of_formulas_fields + '_field_1" class="form-control form-control-sm select2-single" onchange="set_onchange_formula_select('+index_of_formulas_fields+')" style="width: auto;">'
      + '</select>'
      + '</td>'
      + '<td colspan="2" style="width: 35%">'
      + '<div class="input-group-prepend" id="formula_span_div' + index_of_formulas_fields + '_field_1">'
      + '</div>'
      + '<input type="hidden" id="formula_custom' + index_of_formulas_fields + '_field_1" class="form-control form-control-sm">'
      + '</div>'
      + '</td>'
  }
  return str;
}


function add_grouped_option_btn_click() {
  document.getElementById("add_panel").style.visibility = "hidden";
  document.getElementById("add_sub_options_panel").style.visibility = "visible";
  document.getElementById("add_sub_option_heading").innerHTML = 'Option(Grouped)'
  document.getElementById("add_sub_options_panel_content").innerHTML = '<br>'
  + '<div id="add_sub_options_panel_messageDiv"></div>'
  + '<input type="hidden" id="field_type" value="Grouped">'
  +   '<input type="hidden" id="sub_option_id" class="form-control form-control-sm" placeholder="Option ID">'
  + '<div class="row">'
  + '<div class="col-md-6 col-sm-12">'
  +     '<span class="btn red btn-sm">Group With</span>'
  +     '<select id="group_with_select" class="form-control form-control-sm select2-single" onchange="group_with_select_change()">'
  +     '</select>'
  + '</div>'
  + '<div class="col-md-6 col-sm-12">'
  +         '<span class="btn red btn-sm">Option Name</span>'
  +     '<input type="text" id="add_option_name" class="form-control form-control-sm" placeholder="Option Name">'
  + '</div>'
  + '</div>'
  + '<div class="row" id="add_option_opt_type_and_othr_src_div"></div>'
  + '<div class="row">'
  +   '<div class="col-lg-4 col-md-6 col-sm-12">'
  +    '<span class="btn red btn-sm">Editable</span>'
  +    '<select id="add_option_editable" class="form-control form-control-sm select2-single">'
  +      '<option>False</option>'
  +      '<option>True</option>'
  +    '</select>'
  +   '</div>'
  +   '<div class="col-lg-4 col-md-6 col-sm-12">'
  +    '<span class="btn red btn-sm">Visible</span>'
  +    '<select id="add_option_visible" class="form-control form-control-sm select2-single">'
  +     '<option>False</option>'
  +     '<option>True</option>'
  +    '</select>'
  +   '</div>'
  +   '<div class="col-lg-4 col-md-6 col-sm-12">'
  +    '<span class="btn red btn-sm">Table Visible</span>'
  +    '<select id="add_option_table_visible" class="form-control form-control-sm select2-single">'
  +     '<option>True</option>'
  +     '<option>False</option>'
  +    '</select>'
  +   '</div>'
  + '</div>'
  + '<div class="row" id="other_sources_div"></div>'
  + '<div class="row" id="entry_options_div"></div>'
  + '<div class="row" id="entry_custom_storage_options_div"></div>';

  document.getElementById("other_sources_div").innerHTML = '<input id="add_option_other_source_value" type="hidden" value="True" >'
    + '<input id="add_option_select_table" class="form-control form-control-sm" type="hidden" value="True" >'
    + '<input id="add_option_select_column_value" class="form-control form-control-sm" type="hidden">'
    + '<input id="option_against_value_inp_id" class="form-control form-control-sm" type="hidden">'
    +   '<div class="col-md-6 col-sm-12">'
    +      '<span class="btn red btn-sm">Columns</span>'
    +   '<select id="add_option_select_column" class="form-control form-control-sm select2-single" >'
    +   '</select>'
    +   '</div>'
    +   '<div class="col-md-6 col-sm-12">'
    +     '<span class="btn red btn-sm">Whole Table Search</span>'
    +     '<select id="add_option_whole_table_search" class="form-control form-control-sm select2-single" >'
    +     '<option>False</option>'
    +     '<option>True</option>'
    +     '</select>'
    +   '</div>'

  custom_table_options_div_show("grouped");
  entry_options_div_show();
  setTimeout(group_with_select_change, 500);
  if(isEdit){
    document.getElementById("add_sub_options_panel_buttons_div").innerHTML = '<button style="float:right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="add_option_save_btn_click()"><span class="fa fa-save"> </span> Save</button>'
    + '<button style="float: right; margin-left: 5px;" class="btn btn-sm btn-danger" onclick="settings_option_delete_btn_click()"><span class="fa fa-trash"> </span> Delete</button>'
    // + '<button style="float:right;" class="btn btn-sm btn-secondary" onclick="add_sub_option_panel_close_btn_click()"><span class="fa fa-times"> </span> Cancel</button>'
    str += edit_options()
  }
  else{
    document.getElementById("add_sub_options_panel_buttons_div").innerHTML = '<button style="float:right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="add_option_save_btn_click()"><span class="fa fa-save"> </span> Save</button>'
  }
  var table_name = "";
  if(document.getElementById("entry_id_options_panels_dev")){
    table_name = "entry_"+document.getElementById("entry_id_options_panels_dev").innerHTML;
  }
  else if(table_name = document.getElementById("asset_id_options_panels_dev")){
    table_name = "asset_"+document.getElementById("asset_id_options_panels_dev").innerHTML;
  }
  refresh_options('group_with_select', table_name, "grouped", "false");

  $('.select2-single').select2();
}

function group_with_select_change(){
  document.getElementById("add_option_select_table").value = document.getElementById("group_with_select").value.split("--")[0];
  document.getElementById("add_option_select_column_value").value = document.getElementById("group_with_select").value.split("--")[1];
  var s = document.getElementById("group_with_select")
  if(document.getElementById("option_against_value_inp_id")){
    if(s.selectedIndex > -1){
      document.getElementById("option_against_value_inp_id").value = s.options[s.selectedIndex].text
    }
  }
  refresh_columns_in_select("add_option_select_column", document.getElementById("add_option_select_table").value);
}

var index_of_formulas_fields = 0;
function add_formula_btn_click(){
  add_formula_row_click()
  index_of_formulas_fields++;
}

function reset_formula_btn_click(){
  document.getElementById("formulas_div").innerHTML = "<div class='col-md-12'><table id='formulas_table' style='width: 100%'></table></div>";
  index_of_formulas_fields = 0;
  add_formula_btn_click();
}

var parameters_fields_in_formula = Array();
var index_of_formulas_fields_mt_report = 0;
function add_mt_report_formula_btn_click(){
  parameters_fields = 0;
  var formula = "";
  var formula_vals = "";
  if (document.getElementById("formula_1_field_1")) {
    for (var i = 1; i <= index_of_formulas_fields_mt_report; i++) {
      if (i === 1) {
        formula += "formula_" + i + "_field_t_1";
        formula +=  "-,-" + "formula_" + i + "_field_1";
        var ft1 = document.getElementById("formula_" + i + "_field_t_1");
        var f1 = document.getElementById("formula_" + i + "_field_1");
        formula_vals += ft1.value;
        formula_vals += "-,-" + f1.value;
      }
      else {
        formula += "-,-" + "formula_" + i + "_operator_1";
        formula += "-,-" + "formula_" + i + "_field_t_1";
        formula += "-,-" + "formula_" + i + "_field_1";
        var ft1 = document.getElementById("formula_" + i + "_field_t_1");
        var f1 = document.getElementById("formula_" + i + "_field_1");
        formula_vals += "-,-" + document.getElementById("formula_" + i + "_operator_1").value;
        formula_vals += "-,-" + ft1.value;
        formula_vals += "-,-" + f1.value;
      }
    }
  }
  
  index_of_formulas_fields_mt_report++;
  if (index_of_formulas_fields_mt_report === 1) {
    document.getElementById("mt_formulas_div").innerHTML += '<div id="formula_' + index_of_formulas_fields_mt_report + '">'
      + '<div class="form-group">'
      + '<div class="input-group-prepend">'
      + '<span class="btn red btn-sm">Table</span>'
      + '</div>'
      + '<select id="formula_' + index_of_formulas_fields_mt_report + '_field_t_1" class="form-control form-control-sm select2-single" onchange="set_onchange_formula_select('+index_of_formulas_fields_mt_report+')">'
      + '</select>'
      + '<div class="input-group-prepend">'
      + '<span class="btn red btn-sm">Column</span>'
      + '</div>'
      + '<select id="formula_' + index_of_formulas_fields_mt_report + '_field_1" class="form-control form-control-sm select2-single" onchange="set_onchange_formula_select('+index_of_formulas_fields_mt_report+')">'
      + '</select>'
      + '<div class="input-group-prepend" id="formula_span_div' + index_of_formulas_fields_mt_report + '_field_1">'
      + '</div>'
      + '<input type="hidden" id="formula_custom' + index_of_formulas_fields_mt_report + '_field_1" class="form-control form-control-sm select2-single">'
      + '</div>'
      + '</div>'
      + '<div id="parameters_div_' + index_of_formulas_fields_mt_report + '">'
      + '</div>';
  }
  else {
    document.getElementById("mt_formulas_div").innerHTML += '<div id="formula_' + index_of_formulas_fields_mt_report + '">'
      + '<div class="form-group">'
      + '<div class="input-group-prepend">'
      + '<span class="btn red btn-sm">Operator</span>'
      + '</div>'
      + '<select id="formula_' + index_of_formulas_fields_mt_report + '_operator_1" class="form-control form-control-sm select2-single">'
      + '<option>Sum</option>'
      + '<option>Subtract</option>'
      + '<option>Multiplication</option>'
      + '<option>Division</option>'
      + '<option>Modulus</option>'
      + '</select>'
      + '<div class="input-group-prepend">'
      + '<span class="btn red btn-sm">Table</span>'
      + '</div>'
      + '<select id="formula_' + index_of_formulas_fields_mt_report + '_field_t_1" class="form-control form-control-sm select2-single" onchange="set_onchange_formula_select('+index_of_formulas_fields_mt_report+')">'
      + '</select>'
      + '<div class="input-group-prepend">'
      + '<span class="btn red btn-sm">Column</span>'
      + '</div>'
      + '<select id="formula_' + index_of_formulas_fields_mt_report + '_field_1" class="form-control form-control-sm select2-single" onchange="set_onchange_formula_select('+index_of_formulas_fields_mt_report+')">'
      + '</select>'
      + '<div class="input-group-prepend" id="formula_span_div' + index_of_formulas_fields_mt_report + '_field_1">'
      + '</div>'
      + '<input type="hidden" id="formula_custom' + index_of_formulas_fields_mt_report + '_field_1" class="form-control form-control-sm select2-single">'
      + '</div>'
      + '</div>'
      + '<div id="parameters_div_' + index_of_formulas_fields_mt_report + '">'
      + '</div>';
  }

  add_parmeters_btn_click();

  for(var ij=1; ij<=index_of_formulas_fields_mt_report; ij++){
    refresh_tables_in_select('formula_'+ij+'_field_t_1', ij);
  }

  if(formula !== ""){
    var formula_arr = formula.split("-,-");
    var formula_vals_arr = formula_vals.split("-,-");
    for(var i=0; i<formula_arr.length; i++){
      document.getElementById(formula_arr[i]).value = formula_vals_arr[i];
    }
  }
}

function reset_mt_report_formula_btn_click(){
  document.getElementById("mt_formulas_div").innerHTML = "";
  index_of_formulas_fields_mt_report = 0;
  add_mt_report_formula_btn_click();
}

function set_onchange_formula_select(i){
  if(document.getElementById("formula_"+i+"_field_1").value === "Custom"){
    document.getElementById("formula_span_div"+i+"_field_1").innerHTML = '<label class="col-form-label col-form-label-sm red">Value</label>';
    document.getElementById("formula_custom"+i+"_field_1").type = 'number';
  }
  else{
    document.getElementById("formula_span_div"+i+"_field_1").innerHTML = '';
    document.getElementById("formula_custom"+i+"_field_1").type = 'hidden';
  }
}

function set_onchange_formula_select_2(i){
  if(document.getElementById("formula_"+i+"_field_2").value === "Custom"){
    document.getElementById("formula_span_div"+i+"_field_2").innerHTML = '<label class="col-form-label col-form-label-sm red">Value</label>';
    document.getElementById("formula_custom"+i+"_field_2").type = 'number';
  }
  else{
    document.getElementById("formula_span_div"+i+"_field_2").innerHTML = '';
    document.getElementById("formula_custom"+i+"_field_2").type = 'hidden';
  }
}

function refresh_options(clm_id, table_name, fld_typ, custom){
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/refresh/refresh_columns_in_select.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (document.getElementById(clm_id)) {
        document.getElementById(clm_id).innerHTML = this.responseText;
        if(custom !== "false"){
          document.getElementById(clm_id).innerHTML += "<option>Custom</option>";
        }
        if (this.responseText === "<option>NO RESULTS</option>") {
          document.getElementById(clm_id).style.color = "rgb(201, 30, 44)";
        }
        else {
          document.getElementById(clm_id).style.color = "#bbd1f3";
        }
        // $('.select2-single').select2();
      }
    }
  }
  if(fld_typ === "grouped"){
    ajax.send("system_id=" + system_id + "&table_name=" + table_name + "&field_type=" + "grouped");
  }
  else{
    ajax.send("system_id=" + system_id + "&table_name=" + table_name + "&inp_type=" + "number");
  }
}

function add_text_merge_input_string(label_text, inp_id, func){
  var str = '<div class="col-sm-12" style="margin-top: 20px;">' 
  + '<div class="input-group mb3">'
  + '<div class="input-group-prepend">'
  + '<span class="btn label-fill btn-sm">'+ label_text +'</span>'
  + '</div>'
  + '<input type="text" id="'+inp_id+'" class="form-control form-control-sm" placeholder="'+ label_text +'" aria-label="Username">'
  + '<div class="input-group-append">'
  + '<button class="input-group-text btn btn-success" onclick="'+func+'"><span class="fa fa-plus"></span></button>'
  + '</div>'
  + '</div>'
  + '</div>'

  return str;
}

function add_text_merge_table_string(table_id){
  var str = '<div class="col-sm-12" style="margin-top: 10px">'
  + '<div style="max-height: 150px; overflow: auto;">'
  + '<table id="'+table_id+'" class="table table-dark" style="color: #ced0d3">'
  + '</table>'
  + '</div>'
  + '</div><br>'

  return str;
}

function add_text_merge_search_input_string(label_text, inp_id, func){
  var str = '<div class="form-group">'
  + '<div class="input-group-prepend">'
  + '<span class="btn red btn-sm">'+ label_text +'</span>'
  + '</div>'
  + '<input type="text" id="'+inp_id+'" class="form-control form-control-sm" placeholder="'+ label_text +'" aria-label="Username">'
  + '<div class="input-group-append">'
  + '<button class="input-group-text btn btn-success" onclick="'+func+'"><span class="fa fa-search"></span></button>'
  + '</div>'
  + '</div>';

  return str;
}

function add_option_input_change() {
  if(document.getElementById("custom_table_id_options_panels_dev")){
    document.getElementById("value_from_other_src_div").innerHTML = "";
  }
  else{
    var option = document.getElementById("add_option_input_type").value;
    if (option === "Select") {
      document.getElementById("extra_values_div").innerHTML = add_text_merge_input_string("Add Option Text", "add_text_input", "add_texts_add_btn_click()")
      + add_text_merge_table_string("option_values_table");
    }
    else {
      if(document.getElementById("extra_values_div")){
        document.getElementById("extra_values_div").innerHTML = "";
      }
    }
    value_from_other_src_div_show();
    $("#add_option_other_source_value").select2()
  }
  entry_options_div_show();
}

function add_texts_add_btn_click() {
  var option = document.getElementById("add_option_input_type").value;
  if(option !== "Select"){
    if (document.getElementById("option_values_table")) {
      var tbl = document.getElementById("option_values_table");
      var value = document.getElementById("add_text_input").value;
      if (value !== "") {
        tbl.innerHTML += "<tr><td width='95%'>" + value + "</td>"
          + "<td width='5%'><li class='fa fa-times'></li></td></tr>";
      }
      remove_row();
      document.getElementById("add_text_input").focus();
    }
  }
  else{
    var value = document.getElementById("add_text_input").value;
    if (value !== "") {
      document.getElementById("extra_options_div").style.visibility = "visible";
      document.getElementById("add_option_input").value = document.getElementById("add_text_input").value;
      document.getElementById("add_option_input").focus();
    }
  }
}

function close_option_btn_click(){
  document.getElementById("extra_options_div").style.visibility = "hidden";
}

function add_options_add_btn_click() {
  if (document.getElementById("option_values_table")) {
    var tbl = document.getElementById("option_values_table");
    var text = document.getElementById("add_text_input").value;
    var value = document.getElementById("add_option_input").value;
    if (value !== "") {
      tbl.innerHTML += "<tr><td width='45%'>" + text + "</td>"
        + "<td width='40%'>" + value + "</td>"
        + "<td width='5%'><li class='fa fa-times'></li></td></tr>";
    }
    remove_row();
    document.getElementById("add_text_input").focus();
    close_option_btn_click();
  }
}

function remove_row() {
  var tbl = document.getElementById("option_values_table");
  for (var i = 0; i < tbl.rows.length; i++) {
    tbl.rows[i].onclick = function (e) {
      if (e.target.matches("li")) {
        tbl.deleteRow(this.rowIndex);
      }
    }
  }
}

function value_from_other_src_div_show(){
  if(document.getElementById("add_option_input_type").value === "Input Text" || document.getElementById("add_option_input_type").value === "Input Number" || document.getElementById("add_option_input_type").value === "Input Number With Point" || document.getElementById("add_option_input_type").value === "Select"){
    if(document.getElementById("value_from_other_src_div")){
      document.getElementById("value_from_other_src_div").innerHTML = '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12" style="margin-top: 10px">'
      + '<div class="form-group">'
      +  '<div class="input-group-prepend">'
      +     '<span class="btn red btn-sm">Values From Other Source</span>'
      +   '</div>'
      +   '<select id="add_option_other_source_value" type="text" class="form-control form-control-sm select2-single" onchange="add_option_other_sources_input_change()">'
      +      '<option>False</option>'
      +      '<option>True</option>'
      +   '</select>'
      + '</div>'
      + '</div>'
    }
  }
  else{
    document.getElementById("value_from_other_src_div") ? document.getElementById("value_from_other_src_div").innerHTML = "" : "";
    document.getElementById("other_sources_div") ? document.getElementById("other_sources_div").innerHTML = "" : "";
  }
  add_option_other_sources_input_change();
}

function entry_options_div_show(){
  if(document.getElementById("entry_id_options_panels_dev")){
    document.getElementById("entry_options_div").innerHTML = entry_options_html();
    custom_storage_select_change();
  }
  else{
    document.getElementById("entry_options_div").innerHTML = "";
  }
}

function entry_type_select_change(){
  if (document.getElementById("entry_type_select")) {
    var e_type = document.getElementById("entry_type_select").value;
    var c_storage = document.getElementById("custom_storage_select").value;
    if (document.getElementById("entry_type_select").value === "Multiple") {
      if (document.getElementById("add_option_input_type").value === "Input Number" || document.getElementById("add_option_input_type").value === "Input Number With Point") {
        document.getElementById("entry_options_div").innerHTML = entry_options_html_multiple();
      }
    }
    else {
      document.getElementById("entry_options_div").innerHTML = entry_options_html();
    }
    document.getElementById("entry_type_select").value = e_type;
    document.getElementById("custom_storage_select").value = c_storage;
    document.getElementById("entry_type_select").focus();
  }
}

function custom_storage_select_change(){
  if(document.getElementById("custom_storage_select").value === "True"){
    document.getElementById("entry_custom_storage_options_div").innerHTML = '<div class="col-md-6 col-sm-12">'
    +  '<div class="input-group-prepend">'
    +     '<span class="btn red btn-sm">Custom Table</span>'
    +   '</div>'
    +   '<select id="custom_storage_tables_select" type="text" class="form-control form-control-sm select2-single" >'
    +   '</select>'
    + '</div>'
    + '<div class="col-md-6 col-sm-12">'
    +  '<div class="input-group-prepend">'
    +     '<span class="btn red btn-sm">Custom Column</span>'
    +   '</div>'
    +   '<select id="custom_storage_columns_select" type="text" class="form-control form-control-sm select2-single" >'
    +   '</select>'
    + '</div>';
    refresh_tables_in_select("custom_tables");
    document.getElementById("custom_storage_tables_select").onchange = function(){
      refresh_columns_in_select("custom_storage_columns_select", document.getElementById("custom_storage_tables_select").value)
    }
  }
  else{
    document.getElementById("entry_custom_storage_options_div").innerHTML = "";
  }
}

function entry_options_html(){
  var str = '<div class="col-md-6 col-sm-12">'
    +  '<div class="input-group-prepend">'
    +     '<span class="btn red btn-sm">Entry Type</span>'
    +   '</div>'
    +   '<select id="entry_type_select" type="text" class="form-control form-control-sm select2-single" onchange="entry_type_select_change()">'
    +      '<option>Single</option>'
    +      '<option>Multiple</option>'
    +   '</select>'
    + '</div>'
    + '<div class="col-md-6 col-sm-12">'
    +  '<div class="input-group-prepend">'
    +     '<span class="btn red btn-sm">Custom Storage</span>'
    +   '</div>'
    +   '<select id="custom_storage_select" type="text" class="form-control form-control-sm select2-single" onchange="custom_storage_select_change()">'
    +      '<option>False</option>'
    +      '<option>True</option>'
    +   '</select>'
    + '</div>';
  return str;
}

function entry_options_html_multiple(){
  var str = '<div class="form-group">'
  + '<div class="input-group-prepend">'
  + '<span class="btn red btn-sm">Entry Type</span>'
  + '</div>'
  + '<select id="entry_type_select" type="text" class="form-control form-control-sm select2-single" onchange="entry_type_select_change()">'
  + '<option>Single</option>'
  + '<option>Multiple</option>'
  + '</select>'
  + '<div class="input-group-prepend">'
  + '<span class="btn red btn-sm">Entry Sum</span>'
  + '</div>'
  + '<select id="entry_sum_select" type="text" class="form-control form-control-sm select2-single">'
  + '<option>False</option>'
  + '<option>True</option>'
  + '</select>'
  + '<div class="input-group-prepend">'
  + '<span class="btn red btn-sm">Custom Storage</span>'
  + '</div>'
  + '<select id="custom_storage_select" type="text" class="form-control form-control-sm select2-single" onchange="custom_storage_select_change()">'
  + '<option>False</option>'
  + '<option>True</option>'
  + '</select>'
  + '</div>';
  return str;
}

function custom_table_options_div_show(type){
  if(!document.getElementById("custom_table_id_options_panels_dev")){
    if(type === "grouped"){
      document.getElementById("add_option_opt_type_and_othr_src_div").innerHTML = '<div class="col-md-6 col-sm-12">'
      + '<span class="btn red btn-sm">Option Type</span>'
      + '<select id="add_option_input_type" class="form-control form-control-sm select2-single" onchange="group_with_select_change()">'
      +    '<option>Input Text</option>'
      +    '<option>Input Number</option>'
      +    '<option>Input Number With Point</option>'
      + '</select>'
      + '</div>'
      + '<div class="col-md-6 col-sm-12">'
      + '<span class="btn red btn-sm">Empty Check</span>'
      + '<select id="add_option_empty_check" class="form-control form-control-sm select2-single">'
      +    '<option>False</option>'
      +    '<option>True</option>'
      + '</select>'
      + '</div>'
    }
    else if(type === "formulated"){
      document.getElementById("add_option_opt_type_and_othr_src_div").innerHTML = '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">'
      +    '<span class="btn red btn-sm">Option Type</span>'
      + '<select id="add_option_input_type" class="form-control form-control-sm select2-single">'
      +    '<option>Input Number</option>'
      +    '<option>Input Number With Point</option>'
      + '</select>'
      + '</div>'
      + '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">'
      +    '<span class="btn red btn-sm">Empty Check</span>'
      + '<select id="add_option_empty_check" class="form-control form-control-sm select2-single">'
      +    '<option>False</option>'
      +    '<option>True</option>'
      + '</select>'
      + '</div>'
    }
    else{
      document.getElementById("add_option_opt_type_and_othr_src_div").innerHTML = '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">'
      + '<span class="btn red btn-sm">Option Type</span>'      
      + '<select id="add_option_input_type" class="form-control form-control-sm select2-single" onchange="add_option_input_change()">'
      +    '<option>Input Text</option>'
      +    '<option>Input Number</option>'
      +    '<option>Input Number With Point</option>'
      +    '<option>Input Date</option>'
      +    '<!-- <option>Check Box</option> -->'
      +    '<option>Select</option>'
      +    '<!-- <option>Radio Buttons</option>  -->'
      + '</select>'
      + '</div>'
      + '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">'
      +  '<span class="btn red btn-sm">Empty Check</span>'
      + '<select id="add_option_empty_check" class="form-control form-control-sm select2-single">'
      +    '<option>False</option>'
      +    '<option>True</option>'
      + '</select>'
      + '</div>'
      + '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">'
      +    '<span class="btn red btn-sm">Similarity Check</span>'
      + '<select id="add_option_similarity_check" class="form-control form-control-sm select2-single">'
      +    '<option>False</option>'
      +    '<option>True</option>'
      + '</select>'
      + '</div>'
      + '</div>'
    }
  }
  else{
    document.getElementById("add_option_opt_type_and_othr_src_div").innerHTML = '<div class="form-group">'
    + '<div class="input-group-prepend">'
    +    '<span class="btn red btn-sm">Option Type</span>'
    + '</div>'
    + '<select id="add_option_input_type" type="text" class="form-control form-control-sm select2-single" onchange="add_option_input_change()">'
    +    '<option value="Input Text">Text</option>'
    +    '<option value="Input Number">Number</option>'
    +    '<option value="Input Date">Date</option>'
    + '</select>';
    document.getElementById("entry_custom_storage_options_div").innerHTML = '';
    document.getElementById("other_sources_div").innerHTML = '';
  }
}

function add_option_other_sources_input_change(){
  if(document.getElementById("add_option_other_source_value")){
    if(document.getElementById("add_option_other_source_value").value == "True"){
      if(document.getElementById("add_option_input_type").value == "Select"){
        document.getElementById("other_sources_div").innerHTML = '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">'
        +   '<span class="btn red btn-sm" >Tables</span>'
        + '<select id="add_option_select_table" class="form-control form-control-sm select2-single"></select>'
        + '</div>'
        + '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">'
        +   '<span class="btn red btn-sm" >Column Text</span>'
        + '<select id="add_option_select_column" class="form-control form-control-sm select2-single"></select>'
        + '</div>'
        + '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">'
        +   '<span class="btn red btn-sm" >Column Value</span>'
        + '<select id="add_option_select_column_value" class="form-control form-control-sm select2-single"></select>'
        + '</div>'
      }
      else{
        document.getElementById("other_sources_div").innerHTML = '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">' 
        +   '<span class="btn red btn-sm" >Tables</span>'
        + '<select id="add_option_select_table" class="form-control form-control-sm select2-single"></select>'
        + '</div>'
        + '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">'
        +   '<span class="btn red btn-sm" >Columns</span>'
        + '<select id="add_option_select_column" class="form-control form-control-sm select2-single"></select>'
        + '</div>'
        + '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">'
        +   '<span class="btn red btn-sm" >Whole Table Search</span>'
        + '<select id="add_option_whole_table_search" class="form-control form-control-sm select2-single">'
        + '<option>False</option>'
        + '<option>True</option>'
        + '</select>'
        + '</div>'
      }
      refresh_tables_in_select("non_custom_tables");
      document.getElementById("add_option_select_table").onchange = function(){
        refresh_columns_in_select("add_option_select_column", document.getElementById("add_option_select_table").value)
      }

      // $('#add_option_select_table').select2();
      // $('#add_option_select_column').select2();
      $('.select2-single').select2();

      document.getElementById("add_option_select_table").style.background = "black"

    }
    else{
      document.getElementById("other_sources_div").innerHTML = "";
    }
  }
}

function refresh_tables_in_select(tables_type, ind) {
  report_id = "";
  if(tables_type === "reports_tables"){
    report_id = document.getElementById("report_id_options_panels_dev").innerHTML;
  }
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/refresh/refresh_tables_in_select.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if(tables_type === "non_custom_tables"){
        document.getElementById("add_option_select_table").innerHTML = this.responseText;
        if (this.responseText === "<option>NO RESULTS</option>") {
          document.getElementById("add_option_select_table").style.color = "rgb(201, 30, 44)";
        }
        else {
          document.getElementById("add_option_select_table").style.color = "#bbd1f3";
          refresh_columns_in_select("add_option_select_column", document.getElementById("add_option_select_table").value);
        }
      }
      else if(tables_type === "custom_tables"){
        document.getElementById("custom_storage_tables_select").innerHTML = this.responseText;
        if (this.responseText === "<option>NO RESULTS</option>") {
          document.getElementById("custom_storage_tables_select").style.color = "rgb(201, 30, 44)";
        }
        else {
          document.getElementById("custom_storage_tables_select").style.color = "#bbd1f3";
          refresh_columns_in_select("custom_storage_columns_select" ,document.getElementById("custom_storage_tables_select").value);
        }
      }
      else if(tables_type === "reports_tables"){
        document.getElementById("report_select_table").innerHTML = this.responseText;
        if (this.responseText === "<option>NO RESULTS</option>") {
          document.getElementById("report_select_table").style.color = "rgb(201, 30, 44)";
        }
        else {
          document.getElementById("report_select_table").style.color = "#bbd1f3";
          refresh_columns_in_select("report_select_column", document.getElementById("report_select_table").value);
        }
      }
      else if(tables_type === "parameters_tables"){
        document.getElementById("report_select_table").innerHTML = "<option>Date</option>" + this.responseText;
        if (this.responseText === "<option>NO RESULTS</option>") {
          document.getElementById("report_select_table").style.color = "rgb(201, 30, 44)";
        }
        else {
          document.getElementById("report_select_table").style.color = "#bbd1f3";
          document.getElementById("report_select_column").innerHTML = "<option>Date</option>";
        }
      }
      else if(tables_type === "reports_against_tables"){
        if(document.getElementById("report_against_table")){
          document.getElementById("report_against_table").innerHTML = this.responseText;
        }
        if (this.responseText === "<option>NO RESULTS</option>") {
          if(document.getElementById("report_against_table")){
            document.getElementById("report_against_table").style.color = "rgb(201, 30, 44)";
          }
        }
        else {
          if(document.getElementById("report_against_column")){
            refresh_columns_in_select("report_against_column", document.getElementById("report_against_table").value);
          }
        }
      }
      else{
        if(document.getElementById(tables_type)){
          if(document.getElementById(tables_type).innerHTML === "")
            document.getElementById(tables_type).innerHTML = this.responseText;
        }
        if (this.responseText === "<option>NO RESULTS</option>") {
          document.getElementById(tables_type).style.color = "rgb(201, 30, 44)";
        }
      }
      if(document.getElementById("formulas_div")){
        reset_formula_btn_click();
      }
    }
  }
  ajax.send("system_id=" + system_id + "&tables_type=" + tables_type + "&report_id=" + report_id);
}

function refresh_parameters_in_select(p_f) {
  report_id = "";
  // if(tables_type === "reports_tables"){
    report_id = document.getElementById("report_id_options_panels_dev").innerHTML;
  // }  
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/refresh/refresh_parameters_in_select.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if(document.getElementById("parameters_div_"+index_of_formulas_fields_mt_report)){
        document.getElementById("report_parameter_table_"+index_of_formulas_fields_mt_report+"_"+p_f).innerHTML = this.responseText;
        if (this.responseText === "<option>NO RESULTS</option>") {
          document.getElementById("report_parameter_table_"+index_of_formulas_fields_mt_report+"_"+p_f).style.color = "rgb(201, 30, 44)";
        }
        else {
          document.getElementById("report_parameter_table_"+index_of_formulas_fields_mt_report+"_"+p_f).style.color = "#bbd1f3";
          if(document.getElementById("report_parameter_table_"+index_of_formulas_fields_mt_report+"_"+p_f).value === "Date"){
            document.getElementById("report_parameter_column_"+index_of_formulas_fields_mt_report+"_"+p_f).innerHTML = "<option>Date</option>";
          }
          else{
            if(document.getElementById("report_parameter_table_"+p_f)){
              refresh_columns_in_select("report_parameter_column_"+index_of_formulas_fields_mt_report+"_"+p_f, document.getElementById("report_parameter_table_"+p_f).value);
            }
          }
          if(document.getElementById("report_select_table")){
            refresh_columns_in_select("report_against_column_"+index_of_formulas_fields_mt_report+"_"+p_f, document.getElementById("report_select_table").value);
          }
          else if(document.getElementById('formula_' + index_of_formulas_fields_mt_report + '_field_t_1')){
            document.getElementById('formula_' + index_of_formulas_fields_mt_report + '_field_t_1').onchange = function(){
              refresh_columns_in_select("report_against_column_"+index_of_formulas_fields_mt_report+"_"+p_f, document.getElementById('formula_' + index_of_formulas_fields_mt_report + '_field_t_1').value);
              refresh_options('formula_'+index_of_formulas_fields_mt_report+'_field_1', document.getElementById('formula_'+index_of_formulas_fields_mt_report+'_field_t_1').value, "mt_report", "True");
            }
          }
        }
      }
      else{
        document.getElementById("report_parameter_table_"+p_f).innerHTML = this.responseText;
        if (this.responseText === "<option>NO RESULTS</option>") {
          document.getElementById("report_parameter_table_"+p_f).style.color = "rgb(201, 30, 44)";
        }
        else {
          document.getElementById("report_parameter_table_"+p_f).style.color = "#bbd1f3";
          if(document.getElementById("report_parameter_table_"+p_f).value === "Date"){
            document.getElementById("report_parameter_column_"+p_f).innerHTML = "<option>Date</option>";
          }
          else{
            refresh_columns_in_select("report_parameter_column_"+p_f, document.getElementById("report_parameter_table_"+p_f).value);
          }
          if(document.getElementById("report_select_table")){
            refresh_columns_in_select("report_against_column_"+p_f, document.getElementById("report_select_table").value);
          }
          else if(document.getElementById('formula_' + index_of_formulas_fields_mt_report + '_field_t_1')){
            document.getElementById('formula_' + index_of_formulas_fields_mt_report + '_field_t_1').onchange = function(){
              refresh_columns_in_select("report_against_column_"+p_f, document.getElementById('formula_' + index_of_formulas_fields_mt_report + '_field_t_1').value);
              refresh_options('formula_'+index_of_formulas_fields_mt_report+'_field_1', document.getElementById('formula_'+index_of_formulas_fields_mt_report+'_field_t_1').value, "mt_report", "True");
            }
          }
        }
      }
    }
  }
  ajax.send("system_id=" + system_id + "&report_id=" + report_id);
}

function refresh_columns_in_select(clm_id, table_name) {
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/refresh/refresh_columns_in_select.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  if(document.getElementById("add_option_input_type") && document.getElementById("add_option_input_type").value === "Select"){
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if(document.getElementById(clm_id)){
          document.getElementById(clm_id).innerHTML = this.responseText;
          refresh_columns_in_select_for_values();
          if (this.responseText === "<option>NO RESULTS</option>") {
            document.getElementById(clm_id).style.color = "rgb(201, 30, 44)";
          }
          else {
            document.getElementById(clm_id).style.color = "#bbd1f3";
          }
        }
      }
    }
  }
  else{
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if(document.getElementById(clm_id)){
          document.getElementById(clm_id).innerHTML = this.responseText;
          if(document.getElementById("field_type").value = "Grouped"){
            document.getElementById("add_option_select_column").innerHTML += "<option value='id'>id</option>";
            $("#add_option_select_column").select2()
          }
          if (this.responseText === "<option>NO RESULTS</option>") {
            document.getElementById(clm_id).style.color = "rgb(201, 30, 44)";
          }
          else {
            document.getElementById(clm_id).style.color = "#bbd1f3";
          }
        }
      }
    }
  }
  if(document.getElementById("add_option_input_type")){
    if(document.getElementById("add_option_input_type").value === "Input Number" || document.getElementById("add_option_input_type").value === "Input Number With Point"){
      ajax.send("system_id=" + system_id + "&table_name=" + table_name + "&inp_type=" + "number");
    }
    else if(document.getElementById("add_option_input_type").value === "Select"){
      ajax.send("system_id=" + system_id + "&table_name=" + table_name + "&inp_type=" + "select");
    }
    else{
      ajax.send("system_id=" + system_id + "&table_name=" + table_name);
    }
  }else{
    ajax.send("system_id=" + system_id + "&table_name=" + table_name + "&inp_type=" + "report");
  }
}

function refresh_columns_in_select_for_values() {
  var table_name = "";
  if(document.getElementById("add_option_select_table")){
    table_name = document.getElementById("add_option_select_table").value;
  }
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/refresh/refresh_columns_in_select_for_values.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        
          document.getElementById("add_option_select_column_value").innerHTML = this.responseText;
          if (this.responseText === "<option>NO RESULTS</option>") {
            document.getElementById("add_option_select_column_value").style.color = "rgb(201, 30, 44)";
          }
          else {
            document.getElementById("add_option_select_column_value").style.color = "#bbd1f3";
          }
        
      }
    }
  
    ajax.send("system_id=" + system_id + "&table_name=" + table_name);
  
}

function add_option_save_btn_click() {
  if(document.getElementById("add_option_name").value !== ""){
    var option_type = "";
    var option_id = "";
    var sub_option_id = document.getElementById("sub_option_id").value;
    if(document.getElementById("asset_id_options_panels_dev")){
      option_type = "asset";
      option_id = document.getElementById("asset_id_options_panels_dev").innerHTML;
    }
    else if(document.getElementById("entry_id_options_panels_dev")){
      option_type = "entry";
      option_id = document.getElementById("entry_id_options_panels_dev").innerHTML;
    }
    else if(document.getElementById("custom_table_id_options_panels_dev")){
      option_type = "custom_table";
      option_id = document.getElementById("custom_table_id_options_panels_dev").innerHTML;
    }
    if(option_type !== ""){
      var sub_option_name = "";
      if(document.getElementById("add_option_name")){
        sub_option_name = document.getElementById("add_option_name").value;
      }
      var sub_option_type = "";
      if(document.getElementById("add_option_input_type")){
        sub_option_type = document.getElementById("add_option_input_type").value;
      }
      var sub_option_empty_check = "";
      if(document.getElementById("add_option_empty_check")){
        sub_option_empty_check = document.getElementById("add_option_empty_check").value;
      }
      var sub_option_similarity_check = "";
      if(document.getElementById("add_option_similarity_check")){
        sub_option_similarity_check = document.getElementById("add_option_similarity_check").value;
      }
      var sub_option_texts = Array();
      var sub_option_values = Array();
      var sub_option_other_source_value = "";
      var sub_option_other_source_table = "";
      var sub_option_other_source_column = "";
      var sub_option_other_source_column_value = "";
      var sub_option_whole_table_search = "";
      if(document.getElementById("add_option_other_source_value")){
        sub_option_other_source_value = document.getElementById("add_option_other_source_value").value;
        if(sub_option_other_source_value === "True"){
          if(document.getElementById("add_option_select_table")){
            sub_option_other_source_table = document.getElementById("add_option_select_table").value;
          }
          if(document.getElementById("add_option_select_column")){
            sub_option_other_source_column = document.getElementById("add_option_select_column").value;
          }
          if(document.getElementById("add_option_whole_table_search")){
            sub_option_whole_table_search = document.getElementById("add_option_whole_table_search").value;
          }
          if(document.getElementById("add_option_select_column_value")){
            sub_option_other_source_column_value = document.getElementById("add_option_select_column_value").value;
          }
        }
      }
      if(document.getElementById("option_values_table")){
        var sub_option_values_table = document.getElementById("option_values_table");
        for (var i = 0; i < sub_option_values_table.rows.length; i++) {
          sub_option_texts[i] = sub_option_values_table.rows[i].cells[0].innerHTML;
          if(sub_option_values_table.rows[i].cells.length === 3){
            sub_option_values[i] = sub_option_values_table.rows[i].cells[1].innerHTML;
          }
        }
      }
      var sub_option_entry_type = "";
      if(document.getElementById("entry_type_select")){
        sub_option_entry_type = document.getElementById("entry_type_select").value;
      }
      var sub_option_custom_storage = "";
      if(document.getElementById("custom_storage_select")){
        sub_option_custom_storage = document.getElementById("custom_storage_select").value;
      }
      var sub_option_entry_sum = "";
      if(document.getElementById("entry_sum_select")){
        sub_option_entry_sum = document.getElementById("entry_sum_select").value;
      }
      var sub_option_custom_storage_table = "";
      if(document.getElementById("custom_storage_tables_select")){
        sub_option_custom_storage_table = document.getElementById("custom_storage_tables_select").value;
      }
      var sub_option_custom_storage_column = "";
      if(document.getElementById("custom_storage_columns_select")){
        sub_option_custom_storage_column = document.getElementById("custom_storage_columns_select").value;
      }
      var sub_option_field_type = document.getElementById("field_type").value;
      var sub_option_editable = "";
      if(document.getElementById("add_option_editable")){
        sub_option_editable = document.getElementById("add_option_editable").value;
      }
      var sub_option_visible = "";
      if(document.getElementById("add_option_visible")){
        sub_option_visible = document.getElementById("add_option_visible").value;
      }
      var sub_option_table_visible = "";
      if(document.getElementById("add_option_table_visible")){
        sub_option_table_visible = document.getElementById("add_option_table_visible").value;
      }
      var sub_option_priority = "";
      if(document.getElementById("add_option_priority")){
        sub_option_priority = document.getElementById("add_option_priority").value;
      }
      var sub_option_status = "";
      if(document.getElementById("add_option_status")){
        sub_option_status = document.getElementById("add_option_status").value;
      }
      var sub_option_formula = formula();
      var ajax = new XMLHttpRequest();
      var method = "POST";
      var url = "./dashboard/edit/edit_sub_option.php";
      if(sub_option_id == ""){
        url = "./dashboard/add/add_sub_option.php";
      }
      var asynchronous = true;
      ajax.open(method, url, asynchronous);
      ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          if (this.responseText == "Saved Successfully...!") {
            document.getElementById("add_sub_options_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
              + this.responseText + "</div>";
            setTimeout(function () {
              //document.getElementById("add_sub_option_panel").style.visibility = "hidden";
              document.getElementById("add_option_name").value = "";
              // document.getElementById("add_option_input").value = "";
              if(document.getElementById("option_values_table"))
                document.getElementById("option_values_table").innerHTML = "";
              document.getElementById("add_sub_options_panel_messageDiv").innerHTML = "";
              refresh_sub_options_in_panel();
            }, 700);
          }
          else {
            document.getElementById("add_sub_options_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
              + this.responseText + "</div>";
          }
        }
      }
      ajax.send("option_id=" + option_id 
      + "&option_type=" + option_type 
      + "&sub_option_name=" + sub_option_name 
      + "&sub_option_type=" + sub_option_type 
      + "&sub_option_empty_check=" + sub_option_empty_check
      + "&sub_option_similarity_check=" + sub_option_similarity_check
      + "&sub_option_texts=" + sub_option_texts 
      + "&sub_option_values=" + sub_option_values 
      + "&sub_option_other_source_value=" + sub_option_other_source_value
      + "&sub_option_other_source_table=" + sub_option_other_source_table
      + "&sub_option_other_source_column=" + sub_option_other_source_column
      + "&sub_option_other_source_column_value=" + sub_option_other_source_column_value
      + "&sub_option_whole_table_search=" + sub_option_whole_table_search
      + "&sub_option_entry_type=" + sub_option_entry_type
      + "&sub_option_custom_storage=" + sub_option_custom_storage
      + "&sub_option_entry_sum=" + sub_option_entry_sum
      + "&sub_option_custom_storage_table=" + sub_option_custom_storage_table
      + "&sub_option_custom_storage_column=" + sub_option_custom_storage_column
      + "&sub_option_field_type=" + sub_option_field_type
      + "&sub_option_formula=" + sub_option_formula
      + "&sub_option_editable=" + sub_option_editable
      + "&sub_option_visible=" + sub_option_visible
      + "&sub_option_table_visible=" + sub_option_table_visible
      + "&sub_option_status=" + sub_option_status
      + "&sub_option_priority=" + sub_option_priority
      + "&sub_option_id=" + sub_option_id
      + "&system_id=" + system_id);
    }
  }
  else{
    document.getElementById("add_sub_options_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>Option name missing..?</div>";
  }
}

function formula(){
  var sub_option_formula = "";
  if (document.getElementById("formula_1_operator_1")) {
    for (var i = 0; i < index_of_formulas_fields; i++) {
      if (i === 0) {
        var f1 = document.getElementById("formula_" + i + "_field_1");
        var f2 = document.getElementById("formula_" + i + "_field_2");
        if (f1.options[f1.selectedIndex].text === "Custom") {
          sub_option_formula += document.getElementById("formula_custom" + i + "_field_1").value;
          sub_option_formula += "-,-" + document.getElementById("formula_" + i + "_operator_1").value;
        }
        else {
          sub_option_formula += f1.options[f1.selectedIndex].text;
          sub_option_formula += "-,-" + document.getElementById("formula_" + i + "_operator_1").value;

        }
        if (f2.options[f2.selectedIndex].text === "Custom") {
          sub_option_formula += "-,-" + document.getElementById("formula_custom" + i + "_field_2").value;
        }
        else {
          sub_option_formula += "-,-" + f2.options[f2.selectedIndex].text;
        }
      }
      else {
        var f1 = document.getElementById("formula_" + i + "_field_1");
        if (f1.options[f1.selectedIndex].text === "Custom") {
          sub_option_formula += "-,-" + document.getElementById("formula_" + i + "_operator_1").value;
          sub_option_formula += "-,-" + document.getElementById("formula_custom" + i + "_field_1").value;
        }
        else {
          sub_option_formula += "-,-" + document.getElementById("formula_" + i + "_operator_1").value;
          sub_option_formula += "-,-" + f1.options[f1.selectedIndex].text;
        }
      }
    }
  }
  else if (document.getElementById("option_against_value_inp_id")) {
    sub_option_formula = document.getElementById("option_against_value_inp_id").value;
  }
  return sub_option_formula;
}

function formula_report(){
  var sub_option_formula = "";
  if (document.getElementById("formula_1_operator_1")) {
    for (var i = 1; i <= index_of_formulas_fields; i++) {
      if (i === 1) {
        var f1 = document.getElementById("formula_" + i + "_field_1");
        var f2 = document.getElementById("formula_" + i + "_field_2");
        if (f1.options[f1.selectedIndex].text === "Custom") {
          sub_option_formula += document.getElementById("formula_custom" + i + "_field_1").value;
          sub_option_formula += "-,-" + document.getElementById("formula_" + i + "_operator_1").value;
        }
        else {
          sub_option_formula += f1.value;
          sub_option_formula += "-,-" + document.getElementById("formula_" + i + "_operator_1").value;
        }
        if (f2.options[f2.selectedIndex].text === "Custom") {
          sub_option_formula += "-,-" + document.getElementById("formula_custom" + i + "_field_2").value;
        }
        else {
          sub_option_formula += "-,-" + f2.value;
        }
      }
      else {
        var f1 = document.getElementById("formula_" + i + "_field_1");
        if (f1.options[f1.selectedIndex].text === "Custom") {
          sub_option_formula += "-,-" + document.getElementById("formula_" + i + "_operator_1").value;
          sub_option_formula += "-,-" + document.getElementById("formula_custom" + i + "_field_1").value;
        }
        else {
          sub_option_formula += "-,-" + document.getElementById("formula_" + i + "_operator_1").value;
          sub_option_formula += "-,-" + f1.value;
        }
      }
    }
  }
  else if (document.getElementById("option_against_value_inp_id")) {
    sub_option_formula = document.getElementById("option_against_value_inp_id").value;
  }
  return sub_option_formula;
}

function formula_mt_report(){
  var sub_option_formula = "";
  if (document.getElementById("formula_" + (index_of_formulas_fields_mt_report) + "_field_t_1")) {
    for (var i = 1; i <= index_of_formulas_fields_mt_report; i++) {
      if (i === 1) {
        var ft1 = document.getElementById("formula_" + i + "_field_t_1");
        var f1 = document.getElementById("formula_" + i + "_field_1");
        
        if (f1.options[f1.selectedIndex].text === "Custom") {
          sub_option_formula += ft1.value;
          sub_option_formula += "-,-" + f1.value;
        }
        else {
          sub_option_formula += ft1.value;
          sub_option_formula += "-,-" + f1.value;
        }
      }
      else {
        var ft1 = document.getElementById("formula_" + i + "_field_t_1");
        var f1 = document.getElementById("formula_" + i + "_field_1");
        if (f1.options[f1.selectedIndex].text === "Custom") {
          sub_option_formula += "-,-" + document.getElementById("formula_" + i + "_operator_1").value;
          sub_option_formula += "-,-" + ft1.value;
          sub_option_formula += "-,-" + f1.value;
        }
        else {
          sub_option_formula += "-,-" + document.getElementById("formula_" + i + "_operator_1").value;
          sub_option_formula += "-,-" + ft1.value;
          sub_option_formula += "-,-" + f1.value;
        }
      }
      for(var j=0; j<parameters_fields_in_formula[i]; j++){
        sub_option_formula += "-,-" + document.getElementById("report_parameter_table_"+i+"_"+j+"").value;
        sub_option_formula += "-,-" + document.getElementById("report_parameter_column_"+i+"_"+j+"").value;
        sub_option_formula += "-,-" + document.getElementById("report_against_column_"+i+"_"+j+"").value;
      }
    }
  }
  return sub_option_formula;
}

function add_report_option_save_btn_click(){
  var option_type = "";
  var option_id = "";
  if(document.getElementById("report_id_options_panels_dev")){
    option_type = "report";
    option_id = document.getElementById("report_id_options_panels_dev").innerHTML;
  }
  var report_parameter_table = "";
  if(document.getElementsByClassName("report_parameter_select_tables").length>0){
    for(var i=0; i < document.getElementsByClassName("report_parameter_select_tables").length; i++){
      if(i===0){
        report_parameter_table = document.getElementsByClassName("report_parameter_select_tables")[0].value;
      }
      else{
        report_parameter_table += "--"+document.getElementsByClassName("report_parameter_select_tables")[i].value;
      }
    }
  }
  var report_select_table = "";
  if(document.getElementById("report_select_table")){
    report_select_table = document.getElementById("report_select_table").value;
  }
  var report_against_table = "";
  if(document.getElementById("report_against_table")){
    report_against_table = document.getElementById("report_against_table").value;
  }
  var report_column_name = "";
  if(document.getElementById("report_column_name")){
    report_column_name = document.getElementById("report_column_name").value;
  }
  var report_select_column_type = "";
  if(document.getElementById("report_select_column_type")){
    report_select_column_type = document.getElementById("report_select_column_type").value;
  }
  var report_select_selection = "";
  if(document.getElementById("report_select_selection")){
    report_select_selection = document.getElementById("report_select_selection").value;
  }
  var report_parameter_column = "";
  if(document.getElementsByClassName("report_parameter_select_columns").length>0){
    for(var i=0; i < document.getElementsByClassName("report_parameter_select_columns").length; i++){
      if(i===0){
        report_parameter_column = document.getElementsByClassName("report_parameter_select_columns")[0].value;
      }
      else{
        report_parameter_column += "--"+document.getElementsByClassName("report_parameter_select_columns")[i].value;
      }
    }
  }
  var report_select_column = "";
  if(document.getElementById("report_select_column")){
    report_select_column = document.getElementById("report_select_column").value;
  }
  var report_against_column = "";
  if(document.getElementById("report_against_column")){
    report_against_column = document.getElementById("report_against_column").value;
  }
  else{
    if(document.getElementsByClassName("report_parameter_against_columns").length>0){
      for(var i=0; i < document.getElementsByClassName("report_parameter_against_columns").length; i++){
        if(i===0){
          report_against_column = document.getElementsByClassName("report_parameter_against_columns")[0].value;
        }
        else{
          report_against_column += "--"+document.getElementsByClassName("report_parameter_against_columns")[i].value;
        }
      }
    }
  }
  var report_is_heading = "";
  if(document.getElementById("report_is_heading")){
    report_is_heading = document.getElementById("report_is_heading").value;
  }
  var report_is_visible = "";
  if(document.getElementById("report_is_visible")){
    report_is_visible = document.getElementById("report_is_visible").value;
  }
  var report_is_filter = "";
  if(document.getElementById("report_is_filter")){
    report_is_filter = document.getElementById("report_is_filter").value;
  }
  var report_formula = "";
  if(document.getElementById("parameters_div_"+(index_of_formulas_fields_mt_report))){
    report_formula = formula_mt_report();
  }
  else{
    report_formula = formula_report();
  }
  if(document.getElementById("field_type")){
    if(document.getElementById("field_type").value === "parameter"){
      report_formula = "parameter";
    }
  }

  var report_entry_sum = "";
  if(document.getElementById("report_entry_sum")){
    report_entry_sum = document.getElementById("report_entry_sum").value;
  }
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/add/add_sub_option.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "Added Successfully...!") {
        document.getElementById("add_sub_options_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
          + this.responseText + "</div>";
        setTimeout(function () {
          document.getElementById("report_column_name").value = "";
          document.getElementById("add_sub_options_panel_messageDiv").innerHTML = "";
          refresh_sub_options_in_panel();
        }, 700);
      }
      else {
        document.getElementById("add_sub_options_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
          + this.responseText + "</div>";
      }
    }
  }
  ajax.send("option_id=" + option_id
  + "&option_type=" + option_type
  + "&report_parameter_table=" + report_parameter_table
  + "&report_select_table=" + report_select_table
  + "&report_against_table=" + report_against_table
  + "&report_column_name=" + report_column_name
  + "&report_select_column_type=" + report_select_column_type
  + "&report_select_selection=" + report_select_selection
  + "&report_parameter_column=" + report_parameter_column
  + "&report_select_column=" + report_select_column
  + "&report_against_column=" + report_against_column
  + "&report_is_heading=" + report_is_heading
  + "&report_is_visible=" + report_is_visible
  + "&report_is_filter=" + report_is_filter
  + "&report_formula=" + report_formula
  + "&report_entry_sum=" + report_entry_sum
  + "&system_id=" + system_id);
}

function refresh_sub_options_in_panel(){
  if(document.getElementById("show_frontend_div")){
    var option_id = "";
    if(document.getElementById("asset_id_options_panels_dev")){
      option_id = document.getElementById("asset_id_options_panels_dev").innerHTML;
    }
    else if(document.getElementById("entry_id_options_panels_dev")){
      option_id = document.getElementById("entry_id_options_panels_dev").innerHTML;
    }
    else if(document.getElementById("report_id_options_panels_dev")){
      option_id = document.getElementById("report_id_options_panels_dev").innerHTML;
    }
    else if(document.getElementById("custom_table_id_options_panels_dev")){
      option_id = document.getElementById("custom_table_id_options_panels_dev").innerHTML;
    }
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/refresh/refresh_sub_options.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        // console.log(this.responseText)
        document.getElementById("show_frontend_div").innerHTML = this.responseText;
        if(document.getElementById("options_table")){
         $('#options_table').DataTable({
            "scrollX": true,
            "scrollY": 250,
          });
          $('.dataTables_length').addClass('bs-select');
        }
      }
    }
    if(document.getElementById("asset_id_options_panels_dev")){
      ajax.send("option_id=" + option_id + "&system_id=" + system_id + "&option_type=asset");
    }
    else if(document.getElementById("entry_id_options_panels_dev")){
      // alert("in")
      ajax.send("option_id=" + option_id + "&system_id=" + system_id + "&option_type=entry");
    }
    else if(document.getElementById("report_id_options_panels_dev")){
      ajax.send("option_id=" + option_id + "&system_id=" + system_id + "&option_type=report");
    }
    else if(document.getElementById("custom_table_id_options_panels_dev")){
      ajax.send("option_id=" + option_id + "&system_id=" + system_id + "&option_type=custom_table");
    }
  }
}

function refresh_details_of_sub_options(){
  
}

// Settings of sub options........!

function settings_sub_option(id, name, type, empty_check, 
  similarity_check, texts, values, val_frm_othr_src, 
  othr_src_tbl, othr_src_clm, othr_src_clm_val, 
  whole_tbl_srch, priority, 
  entry_type, entry_sum, custom_storage, status,
  field_type, formula, editable, visible, table_visible)
  {
  if(field_type === "Normal"){
    // settings_normal_option();
    add_normal_option_btn_click(true)
  }
  else if(field_type === "Formulated"){
    // settings_formulated_option();
    add_formulated_option_btn_click(true)
  }
  else if(field_type === "Grouped"){
    // settings_grouped_option();
    add_grouped_option_btn_click(true)
  }
  
  // settings_custom_table_options_div_show(field_type);
  // settings_entry_options_div_show();
  document.getElementById("sub_option_id").value = id
  document.getElementById("add_option_name").value = name
  document.getElementById("add_option_input_type").value = type
  
  setTimeout(() => {
    if(document.getElementById("group_with_select")){
      setSelectByText("group_with_select", formula)
      // document.getElementById("group_with_select").value = othr_src_tbl + "--" + othr_src_clm_val
      $('#group_with_select').select2()
      if(typeof document.getElementById("group_with_select").onchange == "function"){
        document.getElementById("group_with_select").onchange()
      }
    }
  }, 200);

  $('#add_option_input_type').select2()
  if(typeof document.getElementById("add_option_input_type").onchange == "function"){
    document.getElementById("add_option_input_type").onchange()   
  }
  if(document.getElementById("add_option_empty_check")){
    document.getElementById("add_option_empty_check").value = empty_check
    $('#add_option_empty_check').select2()
  }
  if(document.getElementById("add_option_similarity_check")){
    document.getElementById("add_option_similarity_check").value = similarity_check
    $('#add_option_similarity_check').select2()
  }
  if(document.getElementById("add_option_editable")){
    document.getElementById("add_option_editable").value = editable
    $('#add_option_editable').select2()
  }
  if(document.getElementById("add_option_visible")){
    document.getElementById("add_option_visible").value = visible
    $('#add_option_visible').select2()
  }
  if(document.getElementById("add_option_table_visible")){
    document.getElementById("add_option_table_visible").value = table_visible
    $('#add_option_table_visible').select2()
  }

  if (document.getElementById("option_values_table")) {
    var tbl = document.getElementById("option_values_table");
    var t = texts.split(",");
    var v = values.split(",");
    if (v[0] !== "") {
      for(var i = 0; i < t.length; i++){
        var text = t[i];
        var value = v[i];
        tbl.innerHTML += "<tr><td width='45%'>" + text + "</td>"
        + "<td width='40%'>" + value + "</td>"
        + "<td width='5%'><li class='fa fa-times'></li></td></tr>";
      }
    }
    remove_row();
    document.getElementById("add_text_input").focus();
    // close_option_btn_click();
  }

  if(document.getElementById("add_option_other_source_value")){
    document.getElementById("add_option_other_source_value").value = val_frm_othr_src
    if(document.getElementById("add_option_other_source_value").type == "select-one"){
      $('#add_option_other_source_value').select2()
    }
    if(typeof document.getElementById("add_option_other_source_value").onchange == "function"){
      document.getElementById("add_option_other_source_value").onchange()
    }
  }

  setTimeout(() => {
    if(document.getElementById("add_option_select_table")){
      document.getElementById("add_option_select_table").value = othr_src_tbl
      if(document.getElementById("add_option_select_table").type == "select-one"){
        $('#add_option_select_table').select2()
      }
      if(typeof document.getElementById("add_option_select_table").onchange == "function"){
        document.getElementById("add_option_select_table").onchange()
      }
    }

    setTimeout(() => {
      if(document.getElementById("add_option_select_column")){
        document.getElementById("add_option_select_column").value = othr_src_clm
        if(document.getElementById("add_option_select_column").type == "select-one"){
          $('#add_option_select_column').select2()
        }
        setTimeout(()=>{
          document.getElementById("add_option_select_column").value = othr_src_clm;
          $('#add_option_select_column').select2()
        }, 500);
        document.getElementById("add_option_select_column_value").value = othr_src_clm_val
        if(document.getElementById("add_option_select_column_value").type == "select-one"){
          $('#add_option_select_column_value').select2()
        }
      }
    }, 1000);

  }, 500)

  document.getElementById("add_option_priority").value = priority
  document.getElementById("add_option_status").value = status
  if(document.getElementById("add_option_status").type == "select-one"){
    $('#add_option_status').select2()
  }

  if (field_type === "Formulated") {
    var formula_arr = formula.split("-,-");
    var i = 0;
    for (var j = 1; j < parseInt(formula_arr.length / 2); j++) {
      add_formula_btn_click();
    }
    setTimeout(() => {
      for (var j = 0; j < formula_arr.length; j++) {
        if (j === 2) {
          if(isNaN(formula_arr[j])){
            setSelectByText("formula_" + i + "_field_2", formula_arr[j]);
            $("#formula_" + i + "_field_2").select2()
          }
          else{
            setSelectByText("formula_" + i + "_field_2", "Custom");
            $("#formula_" + i + "_field_2").select2()
            document.getElementById("formula_custom"+i+"_field_2").value = formula_arr[j];
            document.getElementById("formula_" + i + "_field_2").onchange();
          }
          i++;
        }
        else {
          if (j % 2 === 0) {
            if(isNaN(formula_arr[j])){
              setSelectByText("formula_" + i + "_field_1", formula_arr[j]);
              $("#formula_" + i + "_field_1").select2()
            }
            else{
              setSelectByText("formula_" + i + "_field_1", "Custom");
              $("#formula_" + i + "_field_1").select2()
              document.getElementById("formula_custom"+i+"_field_1").value = formula_arr[j];
              document.getElementById("formula_" + i + "_field_1").onchange();
            }
            if (j !== 0) {
              i++;
            }
          }
          else {
            document.getElementById("formula_" + i + "_operator_1").value = formula_arr[j];
            $("#formula_" + i + "_operator_1").select2()
          }
        }
      }
    }, 1000);
  }
  
  // document.getElementById("sub_options_panel").style.visibility = "visible";
}

function setSelectByText(eID,text)
{ //Loop through sequentially//
  var ele=document.getElementById(eID);
  for(var ii=0; ii<ele.length; ii++)
    if(ele.options[ii].text==text) { //Found!
      ele.options[ii].selected=true;
      return true;
    }
  return false;
}

// var settings_index_of_formulas_fields = 0;
// function settings_formula_btn_click(){
//   var formula = "";
//   var formula_vals = "";
//   if (document.getElementById("settings_formula_1_operator_1")) {
//     for (var i = 1; i <= settings_index_of_formulas_fields; i++) {
//       if (i === 1) {
//         formula += "settings_formula_" + i + "_field_1";
//         formula += "-,-" + "settings_formula_" + i + "_operator_1";
//         formula += "-,-" + "settings_formula_" + i + "_field_2";
//         var f1 = document.getElementById("settings_formula_" + i + "_field_1");
//         var f2 = document.getElementById("settings_formula_" + i + "_field_2");
//         formula_vals += f1.value;
//         formula_vals += "-,-" + document.getElementById("settings_formula_" + i + "_operator_1").value;
//         formula_vals += "-,-" + f2.value;
//       }
//       else {
//         formula += "-,-" + "settings_formula_" + i + "_operator_1";
//         formula += "-,-" + "settings_formula_" + i + "_field_1";
//         var f1 = document.getElementById("settings_formula_" + i + "_field_1");
//         formula_vals += "-,-" + document.getElementById("settings_formula_" + i + "_operator_1").value;
//         formula_vals += "-,-" + f1.value;
//       }
//     }
//   }
  
//   settings_index_of_formulas_fields++;
//   if (settings_index_of_formulas_fields === 1) {
//     document.getElementById("settings_formulas_div").innerHTML += '<div id="settings_formula_' + index_of_formulas_fields + '">'
//       + '<div class="form-group">'
//       + '<div class="input-group-prepend">'
//       + '<span class="btn red btn-sm">Option Name</span>'
//       + '</div>'
//       + '<select id="settings_formula_' + settings_index_of_formulas_fields + '_field_1" class="form-control form-control-sm select2-single" onchange="settings_set_onchange_formula_select('+settings_index_of_formulas_fields+')">'
//       + '</select>'
//       + '<div class="input-group-prepend" id="settings_formula_span_div' + index_of_formulas_fields + '_field_1">'
      
//       + '</div>'
//       + '<input type="hidden" id="settings_formula_custom' + settings_index_of_formulas_fields + '_field_1" class="form-control form-control-sm select2-single">'
//       + '<div class="input-group-prepend">'
//       + '<span class="btn red btn-sm">Operator</span>'
//       + '</div>'
//       + '<select id="settings_formula_' + settings_index_of_formulas_fields + '_operator_1" class="form-control form-control-sm select2-single">'
//       + '<option>Sum</option>'
//       + '<option>Subtract</option>'
//       + '<option>Multiplication</option>'
//       + '<option>Division</option>'
//       + '<option>Modulus</option>'
//       + '</select>'
//       + '<div class="input-group-prepend">'
//       + '<span class="btn red btn-sm">Option Name</span>'
//       + '</div>'
//       + '<select id="settings_formula_' + settings_index_of_formulas_fields + '_field_2" class="form-control form-control-sm select2-single" onchange="settings_set_onchange_formula_select_2('+settings_index_of_formulas_fields+')">'
//       + '</select>'
//       + '<div class="input-group-prepend" id="settings_formula_span_div' + settings_index_of_formulas_fields + '_field_2">'
      
//       + '</div>'
//       + '<input type="hidden" id="settings_formula_custom' + settings_index_of_formulas_fields + '_field_2" class="form-control form-control-sm select2-single">'
//       + '</div>'
//       + '</div>';
//   }
//   else {
//     document.getElementById("settings_formulas_div").innerHTML += '<div id="settings_formula_' + settings_index_of_formulas_fields + '">'
//       + '<div class="form-group">'
//       + '<div class="input-group-prepend">'
//       + '<span class="btn red btn-sm">Operator</span>'
//       + '</div>'
//       + '<select id="settings_formula_' + settings_index_of_formulas_fields + '_operator_1" class="form-control form-control-sm select2-single">'
//       + '<option>Sum</option>'
//       + '<option>Subtract</option>'
//       + '<option>Multiplication</option>'
//       + '<option>Division</option>'
//       + '<option>Modulus</option>'
//       + '</select>'
//       + '<div class="input-group-prepend">'
//       + '<span class="btn red btn-sm">Option Name</span>'
//       + '</div>'
//       + '<select id="settings_formula_' + settings_index_of_formulas_fields + '_field_1" class="form-control form-control-sm select2-single" onchange="settings_set_onchange_formula_select('+settings_index_of_formulas_fields+')">'
//       + '</select>'
//       + '<div class="input-group-prepend" id="settings_formula_span_div' + settings_index_of_formulas_fields + '_field_1">'
      
//       + '</div>'
//       + '<input type="hidden" id="settings_formula_custom' + settings_index_of_formulas_fields + '_field_1" class="form-control form-control-sm select2-single">'
//       + '</div>'
//       + '</div>';
//   }

//   var table_name = "";
//   if(document.getElementById("entry_id_options_panels_dev")){
//     table_name = "entry_"+document.getElementById("entry_id_options_panels_dev").innerHTML;
//   }
//   else if(table_name = document.getElementById("asset_id_options_panels_dev")){
//     table_name = "asset_"+document.getElementById("asset_id_options_panels_dev").innerHTML;
//   }
  
//   refresh_options('settings_formula_'+settings_index_of_formulas_fields+'_field_1', table_name);
//   refresh_options('settings_formula_'+settings_index_of_formulas_fields+'_field_2', table_name);

//   if(formula !== ""){
//     var formula_arr = formula.split("-,-");
//     var formula_vals_arr = formula_vals.split("-,-");
//     for(var i=0; i<formula_arr.length; i++){
//       document.getElementById(formula_arr[i]).value = formula_vals_arr[i];
//     }
//   }
// }

// function settings_formula_reset_btn_click(){
//   document.getElementById("settings_formulas_div").innerHTML = "";
//   settings_index_of_formulas_fields = 0;
//   settings_formula_btn_click();
// }

// function settings_set_onchange_formula_select(i){
//   if(document.getElementById("settings_formula_"+i+"_field_1").value === "Custom"){
//     document.getElementById("settings_formula_span_div"+i+"_field_1").innerHTML = '<span class="btn red btn-sm">Value</span>';
//     document.getElementById("settings_formula_custom"+i+"_field_1").type = 'number';
//   }
//   else{
//     document.getElementById("settings_formula_span_div"+i+"_field_1").innerHTML = '';
//     document.getElementById("settings_formula_custom"+i+"_field_1").type = 'hidden';
//   }
// }

// function settings_set_onchange_formula_select_2(i){
//   if(document.getElementById("settings_formula_"+i+"_field_2").value === "Custom"){
//     document.getElementById("settings_formula_span_div"+i+"_field_2").innerHTML = '<span class="btn red btn-sm">Value</span>';
//     document.getElementById("settings_formula_custom"+i+"_field_2").type = 'number';
//   }
//   else{
//     document.getElementById("settings_formula_span_div"+i+"_field_2").innerHTML = '';
//     document.getElementById("settings_formula_custom"+i+"_field_2").type = 'hidden';
//   }
// }

// function settings_option_input_change() {
//   if(document.getElementById("custom_table_id_options_panels_dev")){
//     document.getElementById("settings_value_from_other_src_div") ? document.getElementById("settings_value_from_other_src_div").innerHTML = "" : "";
//   }
//   else{
//     var option = document.getElementById("settings_option_input_type").value;
//     if(document.getElementById("settings_extra_values_div")){
//       if (option === "Select") {
//         document.getElementById("settings_extra_values_div").innerHTML = add_text_merge_input_string("Add Option Text", "settings_add_text_input", "settings_texts_add_btn_click()")
//           + add_text_merge_table_string("settings_option_values_table");
//       }
//       else {
//         document.getElementById("settings_extra_values_div").innerHTML = "";
//       }
//       settings_value_from_other_src_div_show();
//     }
//   }
// }

// function settings_entry_options_div_show(){
//   if(document.getElementById("entry_id_options_panels_dev")){
//     document.getElementById("settings_entry_options_div").innerHTML = settings_entry_options_html();
//     settings_custom_storage_select_change();
//   }
//   else{
//     document.getElementById("settings_entry_options_div").innerHTML = "";
//   }
// }

// function settings_entry_type_select_change(){
//   var e_type = document.getElementById("settings_entry_type_select").value;
//   var c_storage = document.getElementById("settings_custom_storage_select").value;
//   if(document.getElementById("settings_entry_type_select").value === "Multiple"){
//     document.getElementById("settings_entry_options_div").innerHTML = '<div class="form-group">'
//     +  '<div class="input-group-prepend">'
//     +     '<span class="btn red btn-sm">Entry Type</span>'
//     +   '</div>'
//     +   '<select id="settings_entry_type_select" type="text" class="form-control form-control-sm select2-single" onchange="settings_entry_type_select_change()">'
//     +      '<option>Single</option>'
//     +      '<option>Multiple</option>'
//     +   '</select>'
//     +  '<div class="input-group-prepend">'
//     +     '<span class="btn red btn-sm">Entry Sum</span>'
//     +   '</div>'
//     +   '<select id="settings_entry_sum_select" type="text" class="form-control form-control-sm select2-single">'
//     +      '<option>False</option>'
//     +      '<option>True</option>'
//     +   '</select>'
//     +  '<div class="input-group-prepend">'
//     +     '<span class="btn red btn-sm">Custom Storage</span>'
//     +   '</div>'
//     +   '<select id="settings_custom_storage_select" type="text" class="form-control form-control-sm select2-single" onchange="settings_custom_storage_select_change()">'
//     +      '<option>False</option>'
//     +      '<option>True</option>'
//     +   '</select>'
//     + '</div>';
//   }
//   else{
//     document.getElementById("settings_entry_options_div").innerHTML = settings_entry_options_html();
//   }
//   document.getElementById("settings_entry_type_select").value = e_type;
//   document.getElementById("settings_custom_storage_select").value = c_storage;
//   document.getElementById("settings_entry_type_select").focus();
// }

// function settings_custom_storage_select_change(){
//   if(document.getElementById("settings_custom_storage_select").value === "True"){
//     document.getElementById("settings_entry_custom_storage_options_div").innerHTML = '<div class="form-group">'
//     +  '<div class="input-group-prepend">'
//     +     '<span class="btn red btn-sm">Cutom Table</span>'
//     +   '</div>'
//     +   '<select id="settings_custom_storage_tables_select" type="text" class="form-control form-control-sm select2-single" >'
//     +   '</select>'
//     +  '<div class="input-group-prepend">'
//     +     '<span class="btn red btn-sm">Custom Column</span>'
//     +   '</div>'
//     +   '<select id="settings_custom_storage_columns_select" type="text" class="form-control form-control-sm select2-single" >'
//     +   '</select>'
//     + '</div>';
//     settings_refresh_tables_in_select("custom_tables");
//     document.getElementById("settings_custom_storage_tables_select").onchange = function(){
//       settings_refresh_columns_in_select("settings_custom_storage_columns_select", document.getElementById("settings_custom_storage_tables_select").value)
//     }
//   }
//   else{
//     document.getElementById("settings_entry_custom_storage_options_div").innerHTML = "";
//   }
// }

// function settings_entry_options_html(){
//   var str = '<div class="form-group">'
//     +  '<div class="input-group-prepend">'
//     +     '<span class="btn red btn-sm">Entry Type</span>'
//     +   '</div>'
//     +   '<select id="settings_entry_type_select" type="text" class="form-control form-control-sm select2-single" onchange="settings_entry_type_select_change()">'
//     +      '<option>Single</option>'
//     +      '<option>Multiple</option>'
//     +   '</select>'
//     +  '<div class="input-group-prepend">'
//     +     '<span class="btn red btn-sm">Custom Storage</span>'
//     +   '</div>'
//     +   '<select id="settings_custom_storage_select" type="text" class="form-control form-control-sm select2-single" onchange="settings_custom_storage_select_change()">'
//     +      '<option>False</option>'
//     +      '<option>True</option>'
//     +   '</select>'
//     + '</div>';
//   return str;
// }

// function settings_custom_table_options_div_show(type){
//   if(!document.getElementById("custom_table_id_options_panels_dev")){
//     if(type === "Grouped"){
//       document.getElementById("settings_option_opt_type_and_othr_src_div").innerHTML = '<div class="col-lg-4 col-md-6 col-sm-12">'
//       +    '<span class="btn red btn-sm">Option Type</span>'
//       + '<select id="settings_option_input_type" type="text" class="form-control form-control-sm select2-single" onchange="settings_group_with_select_change()">'
//       +    '<option>Input Text</option>'
//       +    '<option>Input Number</option>'
//       +    '<option>Input Number With Point</option>'
//       + '</select>'
//       + '</div>'
//       + '<div class="col-lg-4 col-md-6 col-sm-12">'
//       +    '<span class="btn red btn-sm">Empty Check</span>'
//       + '<select id="settings_option_empty_check" class="form-control form-control-sm select2-single">'
//       +    '<option>False</option>'
//       +    '<option>True</option>'
//       + '</select>'
//       + '</div>'
//       + '</div>'
//     }
//     else if(type === "Formulated"){
//       document.getElementById("settings_option_opt_type_and_othr_src_div").innerHTML = '<div class="col-lg-4 col-md-6 col-sm-12">'
//       +    '<span class="btn red btn-sm">Option Type</span>'
//       + '<select id="settings_option_input_type" type="text" class="form-control form-control-sm select2-single" onchange="settings_option_input_change()">'
//       +    '<option>Input Number</option>'
//       +    '<option>Input Number With Point</option>'
//       + '</select>'
//       + '</div>'
//       + '<div class="col-lg-4 col-md-6 col-sm-12">'
//       +    '<span class="btn red btn-sm">Empty Check</span>'
//       + '<select id="settings_option_empty_check" class="form-control form-control-sm select2-single">'
//       +    '<option>False</option>'
//       +    '<option>True</option>'
//       + '</select>'
//       + '</div>'
//       + '</div>'
//     }
//     else{
//       document.getElementById("settings_option_opt_type_and_othr_src_div").innerHTML = '<div class="col-lg-4 col-md-6 col-sm-12">'
//       +    '<span class="btn red btn-sm">Option Type</span>'
//       +   '<select id="settings_option_input_type" type="text" class="form-control form-control-sm select2-single" onchange="settings_option_input_change()">'
//       +    '<option>Input Text</option>'
//       +    '<option>Input Number</option>'
//       +    '<option>Input Number With Point</option>'
//       +    '<option>Input Date</option>'
//       +    '<!-- <option>Check Box</option> -->'
//       +    '<option>Select</option>'
//       +    '<!-- <option>Radio Buttons</option>  -->'
//       + '</select>'
//       + '</div>'
//       + '<div class="col-lg-4 col-md-6 col-sm-12">'
//       +    '<span class="btn red btn-sm">Empty Check</span>'
//       + '<select id="settings_option_empty_check" class="form-control form-control-sm select2-single">'
//       +    '<option>False</option>'
//       +    '<option>True</option>'
//       + '</select>'
//       + '</div>'
//       + '<div class="col-lg-4 col-md-6 col-sm-12">'
//       +    '<span class="btn red btn-sm">Similarity Check</span>'
//       + '<select id="settings_option_similarity_check" class="form-control form-control-sm select2-single">'
//       +    '<option>False</option>'
//       +    '<option>True</option>'
//       + '</select>'
//       + '</div>'
//       + '</div>'
//     }
//   }
//   else{
//     document.getElementById("settings_option_opt_type_and_othr_src_div").innerHTML = '<div class="form-group">'
//     + '<div class="input-group-prepend">'
//     +    '<span class="btn red btn-sm">Option Type</span>'
//     + '</div>'
//     + '<select id="settings_option_input_type" type="text" class="form-control form-control-sm select2-single" onchange="settings_option_input_change()">'
//     +    '<option value="Input Text">Text</option>'
//     +    '<option value="Input Number">Number</option>'
//     +    '<option value="Input Date">Date</option>'
//     + '</select>';
//     document.getElementById("settings_entry_custom_storage_options_div").innerHTML = '';
//     document.getElementById("settings_other_sources_div").innerHTML = '';
//   }
// }

// function settings_texts_add_btn_click() {
//   var option = document.getElementById("settings_option_input_type").value;
//   if(option !== "Select"){
//     if (document.getElementById("settings_option_values_table")) {
//       var tbl = document.getElementById("settings_option_values_table");
//       var value = document.getElementById("settings_add_text_input").value;
//       if (value !== "") {
//         tbl.innerHTML += "<tr><td width='95%'>" + value + "</td>"
//           + "<td width='5%'><li class='fa fa-times'></li></td></tr>";
//       }
//       settings_remove_row();
//       document.getElementById("settings_add_text_input").focus();
//     }
//   }
//   else{
//     var value = document.getElementById("settings_add_text_input").value;
//     if (value !== "") {
//       document.getElementById("settings_extra_options_div").style.visibility = "visible";
//       document.getElementById("settings_option_input").value = document.getElementById("settings_add_text_input").value;
//       document.getElementById("settings_option_input").focus();
//     }
//   }
// }

// function settings_close_option_btn_click(){
//   document.getElementById("settings_extra_options_div").style.visibility = "hidden";
// }

// function settings_options_add_btn_click() {
//   if (document.getElementById("settings_option_values_table")) {
//     var tbl = document.getElementById("settings_option_values_table");
//     var text = document.getElementById("settings_add_text_input").value;
//     var value = document.getElementById("settings_option_input").value;
//     if (value !== "") {
//       tbl.innerHTML += "<tr><td width='45%'>" + text + "</td>"
//         + "<td width='40%'>" + value + "</td>"
//         + "<td width='5%'><li class='fa fa-times'></li></td></tr>";
//     }
//     settings_remove_row();
//     document.getElementById("settings_add_text_input").focus();
//     settings_close_option_btn_click();
//   }
// }

// function settings_remove_row() {
//   var tbl = document.getElementById("settings_option_values_table");
//   for (var i = 0; i < tbl.rows.length; i++) {
//     tbl.rows[i].onclick = function (e) {
//       if (e.target.matches("li")) {
//         tbl.deleteRow(this.rowIndex);
//       }
//     }
//   }
// }

// function settings_value_from_other_src_div_show(){
//   if(document.getElementById("settings_option_input_type").value === "Input Text" || document.getElementById("settings_option_input_type").value === "Input Number" || document.getElementById("settings_option_input_type").value === "Input Number With Point" || document.getElementById("settings_option_input_type").value === "Select"){
//     document.getElementById("settings_value_from_other_src_div").innerHTML = '<div class="form-group">'
//     +  '<div class="input-group-prepend">'
//     +     '<span class="btn red btn-sm">Values From Other Source</span>'
//     +   '</div>'
//     +   '<select id="settings_option_other_source_value" type="text" class="form-control form-control-sm select2-single" onchange="settings_option_other_sources_input_change()">'
//     +      '<option>False</option>'
//     +      '<option>True</option>'
//     +   '</select>'
//     + '</div>'
//   }
//   else{
//     document.getElementById("settings_value_from_other_src_div").innerHTML = "";
//     if(document.getElementById("settings_other_sources_div")){
//       document.getElementById("settings_other_sources_div").innerHTML = "";
//     }
//   }
//   settings_option_other_sources_input_change();
// }

// function settings_option_other_sources_input_change(){
//   if(document.getElementById("settings_option_other_source_value")){
//     if(document.getElementById("settings_option_other_source_value").value == "True"){
//       if(document.getElementById("settings_option_input_type").value == "Select"){
//         document.getElementById("settings_other_sources_div").innerHTML = '<div class="form-group">'
//         + '<div class="input-group-prepend">'
//         +      '<span class="btn red btn-sm">Tables</span>'
//         + '</div>'
//         + '<select id="settings_option_select_table" class="form-control form-control-sm select2-single">'
//         + '</select>'
//         + '<div class="input-group-prepend">'
//         +    '<span class="btn red btn-sm">Cloumns Text</span>'
//         + '</div>'
//         + '<select id="settings_option_select_column" class="form-control form-control-sm select2-single" >'
//         + '</select>'
//         + '<div class="input-group-prepend">'
//         +    '<span class="btn red btn-sm">Column Value</span>'
//         + '</div>'
//         + '<select id="settings_option_select_column_value" class="form-control form-control-sm select2-single" >'
//         + '</select>'
//         + '</div>'
//         + '</div>';
//       }
//       else{
//         document.getElementById("settings_other_sources_div").innerHTML = '<div class="form-group">'
//         + '<div class="input-group-prepend">'
//         +      '<span class="btn red btn-sm">Tables</span>'
//         + '</div>'
//         + '<select id="settings_option_select_table" class="form-control form-control-sm select2-single">'
//         + '</select>'
//         + '<div class="input-group-prepend">'
//         +    '<span class="btn red btn-sm">Cloumns</span>'
//         + '</div>'
//         + '<select id="settings_option_select_column" class="form-control form-control-sm select2-single" >'
//         + '</select>'
//         + '<div class="input-group-prepend">'
//         +    '<span class="btn red btn-sm">Whole Table Search</span>'
//         + '</div>'
//         + '<select id="settings_option_whole_table_search" class="form-control form-control-sm select2-single" >'
//         + '<option>False</option>'
//         + '<option>True</option>'
//         + '</select>'
//         + '</div>'
//         + '</div>';
//       }
//       settings_refresh_tables_in_select("non_custom_tables");
//       document.getElementById("settings_option_select_table").onchange = function(){
//         settings_refresh_columns_in_select("settings_option_select_column", document.getElementById("settings_option_select_table").value)
//       }
//     }
//     else{
//       document.getElementById("settings_other_sources_div").innerHTML = "";
//     }
//   }
// }

// function settings_refresh_tables_in_select(tables_type) {
//   var ajax = new XMLHttpRequest();
//   var method = "POST";
//   var url = "./dashboard/refresh/refresh_tables_in_select.php";
//   var asynchronous = true;
//   ajax.open(method, url, asynchronous);
//   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//   ajax.onreadystatechange = function () {
//     if (this.readyState == 4 && this.status == 200) {
//       if(tables_type === "non_custom_tables"){
//         document.getElementById("settings_option_select_table").innerHTML = this.responseText;
//         if (this.responseText === "<option>NO RESULTS</option>") {
//           document.getElementById("settings_option_select_table").style.color = "rgb(201, 30, 44)";
//         }
//         else {
//           document.getElementById("settings_option_select_table").style.color = "#bbd1f3";
//           settings_refresh_columns_in_select("settings_option_select_column", document.getElementById("settings_option_select_table").value);
//         }
//       }
//       else if(tables_type === "custom_tables"){
//         document.getElementById("settings_custom_storage_tables_select").innerHTML = this.responseText;
//         if (this.responseText === "<option>NO RESULTS</option>") {
//           document.getElementById("settings_custom_storage_tables_select").style.color = "rgb(201, 30, 44)";
//         }
//         else {
//           document.getElementById("settings_custom_storage_tables_select").style.color = "#bbd1f3";
//           settings_refresh_columns_in_select("settings_custom_storage_columns_select" ,document.getElementById("settings_custom_storage_tables_select").value);
//         }
//       }
//     }
//   }
//   ajax.send("system_id=" + system_id + "&tables_type=" + tables_type);
// }

// function settings_refresh_columns_in_select(clm_id, table_name) {
//   var ajax = new XMLHttpRequest();
//   var method = "POST";
//   var url = "./dashboard/refresh/refresh_columns_in_select.php";
//   var asynchronous = true;
//   ajax.open(method, url, asynchronous);
//   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//   if(document.getElementById("settings_option_input_type").value === "Select"){
//     ajax.onreadystatechange = function () {
//       if (this.readyState == 4 && this.status == 200) {
//         if(document.getElementById(clm_id)){
//           document.getElementById(clm_id).innerHTML = this.responseText;
//           settings_refresh_columns_in_select_for_values();
//           if (this.responseText === "<option>NO RESULTS</option>") {
//             document.getElementById(clm_id).style.color = "rgb(201, 30, 44)";
//           }
//           else {
//             document.getElementById(clm_id).style.color = "#bbd1f3";
//           }
//         }
//       }
//     }
//   }
//   else{
//     ajax.onreadystatechange = function () {
//       if (this.readyState == 4 && this.status == 200) {
//         if(document.getElementById(clm_id)){
//           document.getElementById(clm_id).innerHTML = this.responseText;
//           if (this.responseText === "<option>NO RESULTS</option>") {
//             document.getElementById(clm_id).style.color = "rgb(201, 30, 44)";
//           }
//           else {
//             document.getElementById(clm_id).style.color = "#bbd1f3";
//           }
//         }
//       }
//     }
//   }
//   if(document.getElementById("settings_option_input_type").value === "Input Number" || document.getElementById("settings_option_input_type").value === "Input Number With Point"){
//     ajax.send("system_id=" + system_id + "&table_name=" + table_name + "&inp_type=" + "number");
//   }
//   else if(document.getElementById("settings_option_input_type").value === "Select"){
//     ajax.send("system_id=" + system_id + "&table_name=" + table_name + "&inp_type=" + "select");
//   }
//   else{
//     ajax.send("system_id=" + system_id + "&table_name=" + table_name);
//   }
// }

// function settings_refresh_columns_in_select_for_values() {
//   var table_name = "";
//   if(document.getElementById("settings_option_select_table")){
//     table_name = document.getElementById("settings_option_select_table").value;
//   }
//   var ajax = new XMLHttpRequest();
//   var method = "POST";
//   var url = "./dashboard/refresh/refresh_columns_in_select_for_values.php";
//   var asynchronous = true;
//   ajax.open(method, url, asynchronous);
//   ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  
//     ajax.onreadystatechange = function () {
//       if (this.readyState == 4 && this.status == 200) {
//         if(document.getElementById("settings_option_select_column")){
//           document.getElementById("settings_option_select_column_value").innerHTML = this.responseText;
//           if (this.responseText === "<option>NO RESULTS</option>") {
//             document.getElementById("settings_option_select_column_value").style.color = "rgb(201, 30, 44)";
//           }
//           else {
//             document.getElementById("settings_option_select_column_value").style.color = "#bbd1f3";
//           }
//         }
//       }
//     }
  
//   ajax.send("system_id=" + system_id + "&table_name=" + table_name);
  
// }

// function settings_option_save_btn_click() {
//   var option_type = "";
//   var option_id = "";
//   if(document.getElementById("asset_id_options_panels_dev")){
//     option_type = "asset";
//     option_id = document.getElementById("asset_id_options_panels_dev").innerHTML;
//   }
//   else if(document.getElementById("entry_id_options_panels_dev")){
//     option_type = "entry";
//     option_id = document.getElementById("entry_id_options_panels_dev").innerHTML;
//   }
//   else if(document.getElementById("custom_table_id_options_panels_dev")){
//     option_type = "custom_table";
//     option_id = document.getElementById("custom_table_id_options_panels_dev").innerHTML;
//   }
//   if(option_type !== ""){
//     var sub_option_id = document.getElementById("settings_sub_option_id").value;
//     var sub_option_name = document.getElementById("settings_option_name").value;
//     var sub_option_type = document.getElementById("settings_option_input_type").value;
//     var sub_option_empty_check = "";
//     if(document.getElementById("settings_option_empty_check")){
//       sub_option_empty_check = document.getElementById("settings_option_empty_check").value;
//     }
//     var sub_option_similarity_check = "";
//     if(document.getElementById("settings_option_similarity_check")){
//       sub_option_similarity_check = document.getElementById("settings_option_similarity_check").value;
//     }
//     var sub_option_priority = "";
//     if(document.getElementById("settings_option_priority")){
//       sub_option_priority = document.getElementById("settings_option_priority").value;
//     }
//     var sub_option_status = "";
//     if(document.getElementById("settings_active_deactive")){
//       sub_option_status = document.getElementById("settings_active_deactive").value;
//     }
//     var sub_option_texts = Array();
//     var sub_option_values = Array();
//     var sub_option_other_source_value = "";
//     var sub_option_other_source_table = "";
//     var sub_option_other_source_column = "";
//     var sub_option_other_source_column_value = "";
//     var sub_option_whole_table_search = "";
//     if (document.getElementById("settings_option_other_source_value")) {
//       sub_option_other_source_value = document.getElementById("settings_option_other_source_value").value;
//       if (sub_option_other_source_value === "True") {
//         sub_option_other_source_table = document.getElementById("settings_option_select_table").value;
//         if (sub_option_other_source_column = document.getElementById("settings_option_select_column")) {
//           sub_option_other_source_column = document.getElementById("settings_option_select_column").value;
//         }
//         if (document.getElementById("settings_option_whole_table_search")) {
//           sub_option_whole_table_search = document.getElementById("settings_option_whole_table_search").value;
//         }
//         if (document.getElementById("settings_option_select_column_value")) {
//           sub_option_other_source_column_value = document.getElementById("settings_option_select_column_value").value;
//         }
//       }
//     }
//     if(document.getElementById("settings_option_values_table")){
//       var sub_option_values_table = document.getElementById("settings_option_values_table");
//       for (var i = 0; i < sub_option_values_table.rows.length; i++) {
//         sub_option_texts[i] = sub_option_values_table.rows[i].cells[0].innerHTML;
//         if(sub_option_values_table.rows[i].cells.length === 3){
//           sub_option_values[i] = sub_option_values_table.rows[i].cells[1].innerHTML;
//         }
//       }
//     }
    
//     var sub_option_entry_type = "";
//     if(document.getElementById("settings_entry_type_select")){
//       sub_option_entry_type = document.getElementById("settings_entry_type_select").value;
//     }
//     var sub_option_custom_storage = "";
//     if(document.getElementById("settings_custom_storage_select")){
//       sub_option_custom_storage = document.getElementById("settings_custom_storage_select").value;
//     }
//     var sub_option_entry_sum = "";
//     if(document.getElementById("settings_entry_sum_select")){
//       sub_option_entry_sum = document.getElementById("settings_entry_sum_select").value;
//     }
//     var sub_option_custom_storage_table = "";
//     if(document.getElementById("settings_custom_storage_tables_select")){
//       sub_option_custom_storage_table = document.getElementById("settings_custom_storage_tables_select").value;
//     }
//     var sub_option_custom_storage_column = "";
//     if(document.getElementById("settings_custom_storage_columns_select")){
//       sub_option_custom_storage_column = document.getElementById("settings_custom_storage_columns_select").value;
//     }
//     var sub_option_field_type = document.getElementById("settings_field_type").value;
//     var sub_option_editable = "";
//     if (document.getElementById("settings_option_editable")) {
//       sub_option_editable = document.getElementById("settings_option_editable").value;
//     }
//     var sub_option_visible = "";
//     if (document.getElementById("settings_option_visible")) {
//       sub_option_visible = document.getElementById("settings_option_visible").value;
//     }
//     var sub_option_table_visible = "";
//     if (document.getElementById("settings_option_table_visible")) {
//       sub_option_table_visible = document.getElementById("settings_option_table_visible").value;
//     }
//     var sub_option_formula = "";
//     if (document.getElementById("settings_formula_1_operator_1")) {
//       for (var i = 1; i <= settings_index_of_formulas_fields; i++) {
//         if(i === 1){
//           var f1 = document.getElementById("settings_formula_"+i+"_field_1");
//           var f2 = document.getElementById("settings_formula_"+i+"_field_2");
//           if(f1.options[f1.selectedIndex].text === "Custom"){
//             sub_option_formula += document.getElementById("settings_formula_custom"+i+"_field_1").value;
//             sub_option_formula += "-,-"+document.getElementById("settings_formula_"+i+"_operator_1").value;
//           }
//           else{
//             sub_option_formula += f1.options[f1.selectedIndex].text;
//             sub_option_formula += "-,-"+document.getElementById("settings_formula_"+i+"_operator_1").value;
            
//           }
//           if(f2.options[f2.selectedIndex].text === "Custom"){
//             sub_option_formula += "-,-"+document.getElementById("settings_formula_custom"+i+"_field_2").value;
//           }
//           else{
//             sub_option_formula += "-,-"+f2.options[f2.selectedIndex].text;
//           }
//         }
//         else{
//           var f1 = document.getElementById("settings_formula_"+i+"_field_1");
//           if(f1.options[f1.selectedIndex].text === "Custom"){
//             sub_option_formula += "-,-"+document.getElementById("settings_formula_"+i+"_operator_1").value;
//             sub_option_formula += "-,-"+document.getElementById("settings_formula_custom"+i+"_field_1").value;
//           }
//           else{
//             sub_option_formula += "-,-"+document.getElementById("settings_formula_"+i+"_operator_1").value;
//             sub_option_formula += "-,-"+f1.options[f1.selectedIndex].text;
//           }
//         }
//       }
//     }
//     else if(document.getElementById("settings_option_against_value_inp_id")){
//       sub_option_formula = document.getElementById("settings_option_against_value_inp_id").value;
//     }
//     var ajax = new XMLHttpRequest();
//     var method = "POST";
//     var url = "./dashboard/edit/edit_sub_option.php";
//     var asynchronous = true;
//     ajax.open(method, url, asynchronous);
//     ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     ajax.onreadystatechange = function () {
//       if (this.readyState == 4 && this.status == 200) {
//         if (this.responseText == "Updated Successfully...!") {
//           document.getElementById("settings_sub_options_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
//             + this.responseText + "</div>";
//           setTimeout(function () {
//             document.getElementById("settings_sub_options_panel").style.visibility = "hidden";
//             document.getElementById("settings_option_name").value = "";
//             // document.getElementById("settings_option_input").value = "";
//             if(document.getElementById("settings_option_values_table"))
//               document.getElementById("settings_option_values_table").innerHTML = "";
//             document.getElementById("settings_sub_options_panel_messageDiv").innerHTML = "";
//             refresh_sub_options_in_panel();
//           }, 700);
//         }
//         else {
//           document.getElementById("settings_sub_options_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
//             + this.responseText + "</div>";
//         }
//       }
//     }
//     ajax.send("option_id=" + option_id 
//       + "&option_type=" + option_type
//       + "&sub_option_name=" + sub_option_name
//       + "&sub_option_type=" + sub_option_type
//       + "&sub_option_empty_check=" + sub_option_empty_check
//       + "&sub_option_similarity_check=" + sub_option_similarity_check
//       + "&sub_option_texts=" + sub_option_texts
//       + "&sub_option_values=" + sub_option_values
//       + "&sub_option_other_source_value=" + sub_option_other_source_value
//       + "&sub_option_other_source_table=" + sub_option_other_source_table
//       + "&sub_option_other_source_column=" + sub_option_other_source_column
//       + "&sub_option_other_source_column_value=" + sub_option_other_source_column_value
//       + "&sub_option_whole_table_search=" + sub_option_whole_table_search
//       + "&sub_option_priority=" + sub_option_priority
//       + "&sub_option_status=" + sub_option_status
//       + "&sub_option_entry_type=" + sub_option_entry_type
//       + "&sub_option_custom_storage=" + sub_option_custom_storage
//       + "&sub_option_entry_sum=" + sub_option_entry_sum
//       + "&sub_option_custom_storage_table=" + sub_option_custom_storage_table
//       + "&sub_option_custom_storage_column=" + sub_option_custom_storage_column
//       + "&sub_option_field_type=" + sub_option_field_type
//       + "&sub_option_formula=" + sub_option_formula
//       + "&sub_option_editable=" + sub_option_editable
//       + "&sub_option_visible=" + sub_option_visible
//       + "&sub_option_table_visible=" + sub_option_table_visible
//       + "&system_id=" + system_id
//       + "&sub_option_id=" + sub_option_id);
//   }
// }

function settings_option_delete_btn_click() {
  if(confirm("Are you sure to delete...?")){
    var option_type = "";
  var option_id = "";
  if(document.getElementById("asset_id_options_panels_dev")){
    option_type = "asset";
    option_id = document.getElementById("asset_id_options_panels_dev").innerHTML;
  }
  else if(document.getElementById("entry_id_options_panels_dev")){
    option_type = "entry";
    option_id = document.getElementById("entry_id_options_panels_dev").innerHTML;
  }
  else if(document.getElementById("custom_table_id_options_panels_dev")){
    option_type = "custom_table";
    option_id = document.getElementById("custom_table_id_options_panels_dev").innerHTML;
  }
  if(option_type !== ""){
    var sub_option_id = document.getElementById("sub_option_id").value;
    var sub_option_name = document.getElementById("add_option_name").value;
    var sub_option_type = document.getElementById("add_option_input_type").value;
    var sub_option_priority = document.getElementById("add_option_priority").value;
    var sub_option_texts = Array();
    var sub_option_values = Array();
    if(document.getElementById("option_values_table")){
      var sub_option_values_table = document.getElementById("option_values_table");
      for (var i = 0; i < sub_option_values_table.rows.length; i++) {
        sub_option_texts[i] = sub_option_values_table.rows[i].cells[0].innerHTML;
        if(sub_option_values_table.rows[i].cells.length === 3){
          sub_option_values[i] = sub_option_values_table.rows[i].cells[1].innerHTML;
        }
      }
    }
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/delete/delete_sub_option.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Deleted Successfully...!") {
          document.getElementById("add_sub_options_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
            + this.responseText + "</div>";
          setTimeout(function () {
            document.getElementById("sub_options_panel").style.visibility = "hidden";
            document.getElementById("add_option_name").value = "";
            document.getElementById("add_option_input").value = "";
            if(document.getElementById("add_option_values_table"))
              document.getElementById("add_option_values_table").innerHTML = "";
            document.getElementById("add_sub_options_panel_messageDiv").innerHTML = "";
            refresh_sub_options_in_panel();
          }, 700);
        }
        else {
          document.getElementById("add_sub_options_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
            + this.responseText + "</div>";
        }
      }
    }
    ajax.send("option_id=" + option_id + "&option_type=" + option_type + "&sub_option_name=" + sub_option_name + "&sub_option_type=" + sub_option_type + "&sub_option_texts=" + sub_option_texts + "&sub_option_values=" + sub_option_values + "&sub_option_priority=" + sub_option_priority + "&system_id=" + system_id + "&sub_option_id=" + sub_option_id);
  }
  }
}

// function settings_options_panel_close_btn_click(){
//   document.getElementById("settings_sub_options_panel").style.visibility = "hidden";
// }

// End functionalities of sub options..........!


// setInterval(() => {
//   document.getElementsByTagName('input').foreach((element) => {
//     element.au
//   })
// }, 2000);

