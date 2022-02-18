
var system_id = "";
var system_name = "";
var user_id = document.getElementById("idlabel").innerHTML;

function close_all() {
    addmanagementsystempanel_cancel_btn_click();
}

function edituserbtn_click() {
    if (document.getElementById("usereditbtn").innerHTML != "<span class=\"glyphicon glyphicon-floppy-disk\"></span>") {
        document.getElementById("userfname").disabled = false;
        document.getElementById("userlname").disabled = false;
        document.getElementById("useruname").disabled = false;
        document.getElementById("usercontact").disabled = false;
        document.getElementById("usereditbtn").innerHTML = "<span class='glyphicon glyphicon-floppy-disk'></span>";
    }
    else {
        var id = document.getElementById("idlabel").innerHTML;
        var fname = document.getElementById("userfname").value;
        var lname = document.getElementById("userlname").value;
        var uname = document.getElementById("useruname").value;
        var phone = document.getElementById("usercontact").value;
        var ajax = new XMLHttpRequest();
        var method = "POST";
        var url = "./updateuser.php";
        var asynchronous = true;
        ajax.open(method, url, asynchronous);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == "User successfully updated...!") {
                    document.getElementById("userfname").disabled = true;
                    document.getElementById("userlname").disabled = true;
                    document.getElementById("useruname").disabled = true;
                    document.getElementById("usercontact").disabled = true;
                    document.getElementById("usereditbtn").innerHTML = "<span class='fa fa-pencil'></span>";
                }
                else {
                    alert(this.responseText);
                }
            }
        }
        ajax.send("id=" + id + "&fname=" + fname + "&lname=" + lname + "&uname=" + uname + "&phone=" + phone);
    }
}

function addmangementsystem_btn_click() {
    document.getElementById("addmanagementsystempanel").style.visibility = "visible";
}

function addmanagementsystempanel_cancel_btn_click() {
    document.getElementById("addmanagementsystempanel").style.visibility = "hidden";
    document.getElementById("systemname").value = "";
    document.getElementById("createmanagementmessageDiv").innerHTML = "";
}

function addmanagementsystempanel_save_btn_click() {
    var id = document.getElementById("idlabel").innerHTML;
    var sname = document.getElementById("systemname").value;
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./system/addsystem.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == "System successfully created...!") {
                document.getElementById("createmanagementmessageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
                    + this.responseText + "</div>";
                refresh_systems();
                setTimeout(function () {
                    document.getElementById("addmanagementsystempanel").style.visibility = "hidden";
                    document.getElementById("systemname").value = "";
                    document.getElementById("createmanagementmessageDiv").innerHTML = "";
                }, 700);
            }
            else {
                document.getElementById("createmanagementmessageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
                    + this.responseText + "</div>";
            }
        }
    }
    ajax.send("uid=" + id + "&sname=" + sname);
}

function refresh_systems() {
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./system/refreshsystems.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("systemstbody").innerHTML = this.responseText;
        }
    }
    ajax.send("");
}

refresh_systems();

function dashboard_btn_click(i) {
    var row = document.getElementById("systemstablerow_" + i);
    system_id = row.cells[1].innerHTML;
    document.getElementById("edit_system_name").value = row.cells[2].innerHTML;
    document.getElementById("editmanagementsystempanel").style.visibility = "visible";

}

function editsystem_btn_click(i) {
    var row = document.getElementById("systemstablerow_" + i);
    system_id = row.cells[1].innerHTML;
    document.getElementById("edit_system_name").value = row.cells[2].innerHTML;
    document.getElementById("editmanagementsystempanel").style.visibility = "visible";

}

function editmanagementsystempanel_save_btn_click() {
    var system_name = document.getElementById("edit_system_name").value;
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./system/updatesystem.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == "Updated Successfully...!") {
                document.getElementById("editmanagementmessageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
                    + this.responseText + "</div>";
                refresh_systems();
                setTimeout(function () {
                    document.getElementById("editmanagementsystempanel").style.visibility = "hidden";
                    document.getElementById("edit_system_name").value = "";
                    document.getElementById("editmanagementmessageDiv").innerHTML = "";
                }, 700);
            }
            else {
                document.getElementById("editmanagementmessageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
                    + this.responseText + "</div>";
            }
        }
    }
    ajax.send("user_id=" + user_id + "&system_id=" + system_id + "&system_name=" + system_name);
}

function editmanagementsystempanel_cancel_btn_click() {
    document.getElementById("editmanagementsystempanel").style.visibility = "hidden";
    document.getElementById("edit_system_name").value = "";
    document.getElementById("editmanagementmessageDiv").innerHTML = "";
}

function deletesystem_btn_click(i) {
    var row = document.getElementById("systemstablerow_" + i);
    system_id = row.cells[1].innerHTML;
    system_name = row.cells[2].innerHTML;
    var text = "Are you sure to delete '"+system_name+"' whole system...?";
    document.getElementById("deletemanagementmessageDiv").innerHTML = "<div class='alert alert-warning' role='alert'>"
                    + text + "</div>";
                    document.getElementById("deletemanagementsystempanel_yes_btn").innerHTML = "Yes";                    
    document.getElementById("deletemanagementsystempanel").style.visibility = "visible";
}

function deletemanagementsystempanel_yes_btn_click(){
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./system/deletesystem.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == "Deleted Successfully...!") {
                document.getElementById("deletemanagementmessageDiv").innerHTML = "<div class='alert alert-warning' role='alert'>"
                    + this.responseText + "</div>";
                refresh_systems();
                setTimeout(function () {
                    document.getElementById("deletemanagementsystempanel").style.visibility = "hidden";
                    document.getElementById("deletemanagementmessageDiv").innerHTML = "";
                }, 700);
            }
            else {
                document.getElementById("deletemanagementmessageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
                    + this.responseText + "</div>";
                    document.getElementById("deletemanagementsystempanel_yes_btn").innerHTML = "Try Again";
            }
        }
    }
    ajax.send("user_id=" + user_id + "&system_id=" + system_id + "&system_name=" + system_name);
}

function deletemanagementsystempanel_no_btn_click(){
    document.getElementById("deletemanagementsystempanel").style.visibility = "hidden";
                    document.getElementById("deletemanagementmessageDiv").innerHTML = "";
}