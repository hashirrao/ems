
<!-- Add Panels -->

<div id="add_asset_panel" class="jumbotron panel">
    <div class="headerDiv" id="add_asset_panelheader">
    <strong style="font-size: 20px">Add Asset</strong>
    <button style="flaot: right;" id="add_asset_panel_close_btn" class="close_buttons" onclick="add_asset_cancel_btn_click()"></button>
    </div>
    <br>
    <br>
    <!-- <div class="page-header text-center">
        <h2>Add Asset</h2>
    </div> -->
    <div id="add_asset_option_panel_messageDiv"></div>
    <strong>Asset Name: </strong> <input id="add_asset_name" class="form-control form-control-sm" placeholder="ASSET NAME"> <br>
    <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="add_asset_save_btn_click()"><span class="fa fa-save"> </span> Save</button>
    <!-- <button class="btn btn-sm btn-danger" onclick="add_asset_cancel_btn_click()"><span class="fa fa-times"> </span> Cancel</button> -->
</div>

<div id="add_entry_panel" class="jumbotron panel">
    <div class="headerDiv" id="add_entry_panelheader">
        <strong style="font-size: 20px">Add Entry</strong>
        <button style="float: right;" id="add_entry_panel_close_btn" class="close_buttons" onclick="add_entry_cancel_btn_click()"></button>
    </div>
    <br>
    <br>
    <div id="add_entry_option_panel_messageDiv"></div>
    <strong>Entry Name: </strong> <input id="add_entry_name" class="form-control form-control-sm" placeholder="ENTRY NAME"> <br>
    <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="add_entry_save_btn_click()"><span class="fa fa-save"> </span> Save</button>
    <!-- <button class="btn btn-sm btn-danger" onclick="add_entry_cancel_btn_click()"><span class="fa fa-times"> </span> Cancel</button> -->
</div>

<div id="add_report_panel" class="jumbotron panel">
    <div class="headerDiv" id="add_report_panelheader">
        <strong style="font-size: 20px">Add Report</strong>
        <button style="float: right;" id="add_report_panel_close_btn" class="close_buttons" onclick="add_report_cancel_btn_click()"></button>
    </div>
    <br>
    <br>
    <div id="add_report_option_panel_messageDiv"></div>
    <strong>Report Name: </strong> <input id="add_report_name" class="form-control form-control-sm" placeholder="REPORT NAME"> <br>
    <!-- <input id="add_report_type" class="form-control form-control-sm" type="hidden" value="Single Table"> -->
    <strong>Report Type: </strong> 
    <select id="add_report_type" class="form-control form-control-sm">
    <option>Single Table</option>
    <option>Multi Table</option>
    </select> <br>
    <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="add_report_save_btn_click()"><span class="fa fa-save"> </span> Save</button>
    <!-- <button class="btn btn-sm btn-danger" onclick="add_report_cancel_btn_click()"><span class="fa fa-times"> </span> Cancel</button> -->
</div>

<div id="add_custom_table_panel" class="jumbotron panel">
    <div class="headerDiv" id="add_custom_table_panelheader">
    <button id="add_custom_table_panel_close_btn" class="close_buttons" onclick="add_custom_table_cancel_btn_click()"></button>
    </div>
    <br>
    <div class="page-header text-center">
        <h2>Add Custom Table</h2>
    </div>
    <div id="add_custom_table_option_panel_messageDiv"></div>
    <strong>Custom Table Name: </strong> <input id="add_custom_table_name" class="form-control form-control-sm" placeholder="CUSTOM TABLE NAME"> <br>
    <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="add_custom_table_save_btn_click()"><span class="fa fa-save"> </span> Save</button>
    <!-- <button class="btn btn-sm btn-danger" onclick="add_custom_table_cancel_btn_click()"><span class="fa fa-times"> </span> Cancel</button> -->
</div>

<!-- Edit Panels -->

<div id="edit_asset_panel" class="jumbotron panel">
    <div class="headerDiv" id="edit_asset_panelheader">
        <strong style="font-size: 20px">Edit Asset</strong>
        <button style="float: right;" id="edit_asset_panel_close_btn" class="close_buttons" onclick="edit_asset_cancel_btn_click()"></button>
    </div>
    <br>
    <br>
    <div id="edit_asset_option_panel_messageDiv"></div>
    <input id="edit_asset_id" class="form-control form-control-sm" type="hidden">
    <strong>Asset Name: </strong> <input id="edit_asset_name" class="form-control form-control-sm" placeholder="ASSET NAME"> <br>
    <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="edit_asset_save_btn_click()"><span class="fa fa-save"> </span> Save</button>
    <!-- <button class="btn btn-sm btn-danger" onclick="edit_asset_cancel_btn_click()"><span class="fa fa-times"> </span> Cancel</button> -->
    <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-warning" onclick="edit_asset_delete_btn_click()"><span class="fa fa-trash"> </span> Delete</button>
</div>

<div id="edit_entry_panel" class="jumbotron panel">
    <div class="headerDiv" id="edit_entry_panelheader">
        <strong style="font-size: 20px">Edit Entry</strong>
        <button style="float: right;" id="edit_entry_panel_close_btn" class="close_buttons" onclick="edit_entry_cancel_btn_click()"></button>
    </div>
    <br>
    <br>
    <div id="edit_entry_option_panel_messageDiv"></div>
    <input id="edit_entry_id" class="form-control form-control-sm" type="hidden">
    <strong>Entry Name: </strong> <input id="edit_entry_name" class="form-control form-control-sm" placeholder="ENTRY NAME"> <br>
    <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="edit_entry_save_btn_click()"><span class="fa fa-save"> </span> Save</button>
    <!-- <button class="btn btn-sm btn-danger" onclick="edit_entry_cancel_btn_click()"><span class="fa fa-times"> </span> Cancel</button> -->
    <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-warning" onclick="edit_entry_delete_btn_click()"><span class="fa fa-trash"> </span> Delete</button>
</div>

<div id="edit_report_panel" class="jumbotron panel">
    <div class="headerDiv" id="edit_report_panelheader">
        <strong style="font-size: 20px">Edit Report</strong>
        <button style="float: right;" id="edit_report_panel_close_btn" class="close_buttons" onclick="edit_report_cancel_btn_click()"></button>
    </div>
    <br>
    <br>
    <div id="edit_report_option_panel_messageDiv"></div>
    <input id="edit_report_id" class="form-control form-control-sm" type="hidden">
    <strong>Report Name: </strong> <input id="edit_report_name" class="form-control form-control-sm" placeholder="REPORT NAME"> <br>
    <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="edit_report_save_btn_click()"><span class="fa fa-save"> </span> Save</button>
    <!-- <button class="btn btn-sm btn-danger" onclick="edit_report_cancel_btn_click()"><span class="fa fa-times"> </span> Cancel</button> -->
    <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-warning" onclick="edit_report_delete_btn_click()"><span class="fa fa-trash"> </span> Delete</button>
</div>

<div id="edit_custom_table_panel" class="jumbotron panel">
    <div class="headerDiv" id="edit_custom_table_panelheader">
    <button id="edit_custom_table_panel_close_btn" class="close_buttons" onclick="edit_custom_table_cancel_btn_click()"></button>
    </div>
    <br>
    <div class="page-header text-center">
        <h2>Edit Custom Table</h2>
    </div>
    <div id="edit_custom_table_option_panel_messageDiv"></div>
    <input id="edit_custom_table_id" class="form-control form-control-sm" type="hidden">
    <strong>Custom Table Name: </strong> <input id="edit_custom_table_name" class="form-control form-control-sm" placeholder="CUSTOM Table NAME"> <br>
    <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="edit_custom_table_save_btn_click()"><span class="fa fa-save"> </span> Save</button>
    <!-- <button class="btn btn-sm btn-danger" onclick="edit_custom_table_cancel_btn_click()"><span class="fa fa-times"> </span> Cancel</button> -->
    <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-warning" onclick="edit_custom_table_delete_btn_click()"><span class="fa fa-trash"> </span> Delete</button>
</div>

<!-- Dev Panels -->

<div id="add_panel" class="jumbotron panel">
    <div style="text-align: center;" class="headerDiv" id="add_panelheader">
    <strong style="font-size: 20px;">Add</strong>
    <button id="add_panel_close_btn" class="close_buttons" onclick="add_panel_close_btn_click()"></button>
    </div>
    <br>
    <!-- <div class="page-header text-center">
        <h2>Add</h2>
    </div> -->
    <div id="add_panel_messageDiv"></div>
    <div class="text-center">
    <div>
        <button style="width: 40%;" class="btn btn-default" onclick="add_normal_option_btn_click(false)"><span>Simple Option</span></button>
        <button style="width: 40%;" class="btn btn-default" onclick="add_formulated_option_btn_click(false)"><span>Formulated Option</span></button>
    </div>
    <div style="margin-top: 5px">
        <!-- <button style="width: 40%;" class="btn btn-default" onclick="add_merged_option_btn_click()"><span>Merged Option</span></button> -->
        <button style="width: 80%;" class="btn btn-default" onclick="add_grouped_option_btn_click(false)"><span>Grouped Option</span></button>
    </div>
    </div>
</div>

<div id="add_sub_options_panel" class="jumbotron panel">
    <input id="isEdit" type="hidden" />
    <div class="headerDiv" id="add_sub_options_panelheader">
        <strong style="font-size: 20px;" id="add_sub_option_heading"></strong>
        <button id="add_sub_options_panel_close_btn" class="close_buttons" onclick="add_sub_option_panel_close_btn_click()"></button>
    </div>
    <div id="add_sub_options_panel_content" class="content"></div>
    <div style="margin-top: 15px;" id="add_sub_options_panel_buttons_div">
    </div>
</div>

<div id="report_add_panel" class="jumbotron panel">
    <div class="headerDiv" id="report_add_panelheader">
        <button id="report_add_panel_close_btn" class="close_buttons" onclick="add_panel_close_btn_click()"></button>
    </div>
    <br>
    <div class="page-header text-center">
        <h2>Add</h2>
    </div>
    <div id="add_panel_messageDiv"></div>
    <div class="text-center">
        <div>
            <button style="width: 40%;" class="btn btn-default" onclick="add_report_option_btn_click()"><span>Simple Option</span></button>
            <button style="width: 40%;" class="btn btn-default" onclick="add_formulated_report_option_btn_click()"><span>Formulated Option</span></button>
        </div>
        <div style="margin-top: 5px">
        <button style="width: 80%;" class="btn btn-default" onclick="add_grouped_report_option_btn_click()"><span>Grouped Option</span></button>
        </div>
    </div>
</div>

<div id="mt_report_add_panel" class="jumbotron panel">
    <div class="headerDiv" id="report_add_panelheader">
        <button id="report_add_panel_close_btn" class="close_buttons" onclick="add_panel_close_btn_click()"></button>
    </div>
    <br>
    <div class="page-header text-center">
        <h2>Add</h2>
    </div>
    <div id="add_panel_messageDiv"></div>
    <div class="text-center">
        <div>
            <button style="width: 45%;" class="btn btn-default" onclick="add_mt_report_parameters_btn_click()"><span>Select Parameters</span></button>
            <button style="width: 45%;" class="btn btn-default" onclick="add_mt_report_option_btn_click()"><span>Simple Option</span></button>
            
        </div>
        <div style="margin-top: 5px">
        <button style="width: 45%;" class="btn btn-default" onclick="add_mt_grouped_report_option_btn_click()"><span>Grouped Option</span></button>
        <button style="width: 45%;" class="btn btn-default" onclick="add_mt_formulated_report_option_btn_click()"><span>Formulated Option</span></button>
        </div>
    </div>
</div>

<div id="add_report_sub_options_panel" class="jumbotron panel">
    <input id="isEdit" type="hidden" />
    <div class="headerDiv" id="add_report_sub_options_panelheader">
        <strong style="font-size: 20px;" id="add_report_sub_option_heading"></strong>
        <button id="add_sub_options_panel_close_btn" class="close_buttons" onclick="add_sub_option_panel_close_btn_click()"></button>
    </div>
    <div id="add_report_sub_options_panel_content" class="content"></div>
    <div style="margin-top: 15px;" id="add_report_sub_options_panel_buttons_div">
        <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="add_report_option_save_btn_click()"><span class="fa fa-save"> </span> Save</button>
        <!-- <button class="btn btn-sm btn-danger" onclick="add_sub_option_panel_close_btn_click()"><span class="fa fa-times"> </span> Cancel</button> -->
    </div>
</div>

<!-- <div id="settings_sub_options_panel" class="jumbotron panel">
    <div class="headerDiv" id="settings_sub_options_panelheader">
        <strong style="font-size: 20px;" id="settings_sub_option_heading"></strong>
        <button id="settings_sub_options_panel_close_btn" class="close_buttons" onclick="settings_options_panel_close_btn_click()"></button>
    </div>
    <div id="settings_sub_options_panel_content" class="content"></div>
    <div style="margin-top: 15px">
        <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="settings_option_save_btn_click()"><span class="fa fa-save"> </span> Save</button>
        <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-warning" onclick="settings_option_delete_btn_click()"><span class="fa fa-trash"> </span> Delete</button>
        <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-danger" onclick="settings_options_panel_close_btn_click()"><span class="fa fa-times"> </span> Cancel</button>
    </div>
</div> -->

<!-- Search panel -->

<div id="search_panel" class="jumbotron panel">
    <div class="headerDiv" id="search_panelheader">
        <button id="search_panel_close_btn" class="close_buttons" onclick="search_panel_close_btn_click()"></button>
    </div>
    <!-- <div style="visibility: hidden;" class="headerDiv" id="'search_panelheader">
    </div>
    <button id="search_panel_close_btn" class="close_buttons_1" onclick="search_panel_close_btn_click()"></button> -->
    <div id="search_panel_content_div"></div>
</div>

<!-- Custom Panels -->

<div id="newuser_panel" class="jumbotron entry_panel lesspadding">
    <!-- <div class="headerDiv" id="search_panelheader"> -->
        <button id="adduser_panel_close_btn" class="close_buttons_1" onclick="add_user_close_btn_click()"></button>
    <!-- </div> -->
    <br>
    <div class="page-header text-center">
        <h2>Add New User</h2>
    </div>
    <div id="newuser_message_div"></div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">First Name</span>
            </div>
            <input type="text" class="form-control form-control-sm" id="firstname" placeholder="FIRST NAME" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Last Name</span>
            </div>
            <input type="text" class="form-control form-control-sm" id="lastname" placeholder="LAST NAME" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">User Name</span>
            </div>
            <input type="text" class="form-control form-control-sm" id="username" placeholder="USERNAME" required autocomplete="organization">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Password</span>
            </div>
            <input type="password" class="form-control form-control-sm" id="password" placeholder="PASSWORD" required autocomplete="organization">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Retype Password</span>
            </div>
            <input type="password" class="form-control form-control-sm" id="confirmpassword" placeholder="RETYPE PASSWORD" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Date Of Birth</span>
            </div>
            <input type="date" class="form-control form-control-sm" id="dob" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Contact</span>
            </div>
            <input type="text" class="form-control form-control-sm" id="contact" placeholder="CONTACT NO" required>
        </div>
        <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="add_user_save_btn_click()"><span class="fa fa-save"> </span> Save</button>
        <!-- <button class="btn btn-sm btn-danger" onclick="add_user_close_btn_click()"><span class="fa fa-times"> </span> Cancel</button> -->
    </div>
</div>

<div id="listuser_panel" class="jumbotron entry_panel lesspadding">
    <!-- <div class="headerDiv" id="search_panelheader"> -->
        <button id="listuser_panel_close_btn" class="close_buttons_1" onclick="list_user_close_btn_click()"></button>
    <!-- </div> -->
    <br>
    <div class="page-header text-center">
        <h2>List User(s)</h2>
    </div>
    <div id="newuser_message_div"></div>
    <div class="container" >
        <div id="users_table_div">
        </div>
    </div>
</div>

<div id="edituser_panel" class="jumbotron entry_panel lesspadding">
    <!-- <div class="headerDiv" id="search_panelheader"> -->
        <button id="edituser_panel_close_btn" class="close_buttons_1" onclick="edit_user_close_btn_click()"></button>
    <!-- </div> -->
    <br>
    <div class="page-header text-center">
        <h2>Edit User</h2>
    </div>
    <div id="edituser_message_div"></div>
    <input type="hidden" class="form-control form-control-sm" id="edit_id">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">First Name</span>
            </div>
            <input type="text" class="form-control form-control-sm" id="edit_firstname" placeholder="FIRST NAME" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Last Name</span>
            </div>
            <input type="text" class="form-control form-control-sm" id="edit_lastname" placeholder="LAST NAME" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">User Name</span>
            </div>
            <input type="text" class="form-control form-control-sm" id="edit_username" placeholder="USERNAME" required autocomplete="organization">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Date Of Birth</span>
            </div>
            <input type="date" class="form-control form-control-sm" id="edit_dob" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Contact</span>
            </div>
            <input type="text" class="form-control form-control-sm" id="edit_contact" placeholder="CONTACT NO" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Status</span>
            </div>
            <select type="text" class="form-control form-control-sm" id="edit_status">
            <option>Activated</option>
            <option>Deactivated</option>
            </select>
        </div>
        <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="edit_user_save_btn_click()"><span class="fa fa-save"> </span> Save</button>
        <!-- <button class="btn btn-sm btn-danger" onclick="edit_user_close_btn_click()"><span class="fa fa-times"> </span> Cancel</button> -->
    </div>
</div>

<div id="listuser_authorities_panel" class="jumbotron entry_panel lesspadding">
    <!-- <div class="headerDiv" id="search_panelheader"> -->
        <button id="listuser_panel_close_btn" class="close_buttons_1" onclick="list_user_authorities_close_btn_click()"></button>
    <!-- </div> -->
    <br>
    <div class="page-header text-center">
        <h2>List Authorities</h2>
    </div>
    <div id="newuser_message_div"></div>
    <div class="container" >
        <div id="users_authorities_table_div"></div>
    </div>
</div>

<div id="change_password_panel" class="jumbotron entry_panel lesspadding">
    <!-- <div class="headerDiv" id="search_panelheader"> -->
        <button id="change_password_panel_close_btn" class="close_buttons_1" onclick="change_password_close_btn_click()"></button>
    <!-- </div> -->
    <br>
    <div class="page-header text-center">
        <h2>Change Password</h2>
    </div>
    <div id="changepassword_message_div"></div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Password</span>
            </div>
            <input type="password" class="form-control form-control-sm" id="change_password" placeholder="PASSWORD" required autocomplete="off">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">New Password</span>
            </div>
            <input type="password" class="form-control form-control-sm" id="change_newpassword" placeholder="NEW PASSWORD" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
            <span class="input-group-text">Retype Password</span>
            </div>
            <input type="password" class="form-control form-control-sm" id="change_confirmpassword" placeholder="RETYPE PASSWORD" required>
        </div>
        <button style="float: right; margin-left: 5px;" class="btn btn-sm btn-success" onclick="change_password_save_btn_click()"><span class="fa fa-save"> </span> Save</button>
        <!-- <button class="btn btn-sm btn-danger" onclick="change_password_close_btn_click()"><span class="fa fa-times"> </span> Cancel</button> -->
    </div>
</div>

<div id="shortcut_keys_panel" class="jumbotron entry_panel lesspadding">
    <!-- <div class="headerDiv" id="shortcut_keys_panelheader"> -->
        <button id="shortcut_keys_panel_close_btn" class="close_buttons_1" onclick="shortcut_keys_panel_close_btn_click()"></button>
    <!-- </div> -->
    <br>
    <div class="page-header text-center">
        <h2>Shortcut Keys</h2>
    </div>
    <div class="container">
    <table class="table">
    <thead>
    <tr>
    <th>Functions</th>
    <th>Keys</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    <td>Add New</td>
    <td>Alt + a</td>
    </tr>
    <tr>
    <td>Save</td>
    <td>Alt + s</td>
    </tr>
    <tr>
    <td>Edit</td>
    <td>Shift + e</td>
    </tr>
    <tr>
    <td>Search</td>
    <td>Shift + s</td>
    </tr>
    <tr>
    <td>Print</td>
    <td>Alt + p</td>
    </tr>
    </tbody>
    </table>
    </div>
</div>