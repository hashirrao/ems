
// Start show Options.................!
var global_names;
var global_val_frm_othr_src;
var global_othr_src_tbl;
var global_othr_src_clm;
var global_othr_src_clm_val;
var global_formula;
var global_field_type;
var global_entry_sum;
var global_whole_tbl_srch;

function create_panel(id, name, type){
  var heading = "";
  var func = "";
  var func_1 = "";
  if(type === "add"){
    heading = "Add " + name;
    func = "add_values_asset_cancel_btn_click('"+id+"', '"+name+"')";
  }
  else if(type === "edit"){
    heading = "Edit " + name;
    func = "edit_values_asset_cancel_btn_click("+id+")";
  }
  else if(type === "list"){ 
    heading = name + "(s)";
    func = "list_assets_cancel_btn_click("+id+")";
    func_1 = "admin_add_asset_link_click('"+id+"', '"+name+"')";
  }
  else if(type === "entry"){ 
    // heading = "Entry " + name;
    func = "entry_cancel_btn_click("+id+")";
  }
  else if(type === "report"){ 
    heading = "Report " + name;
    func = "report_cancel_btn_click("+id+")";
  }
  if(type === "add" || type === "edit" || type === "list" || type === "report"){
    str = '<div id="'+type+'_'+id+'_panel" class="jumbotron entry_panel lesspadding">'
    + '<div style="visibility: hidden;" class="headerDiv" id="'+type+'_'+id+'_panelheader">'
    + '</div>'
    + '<button id="'+type+'_'+id+'_panel_close_btn" class="close_buttons_1" onclick="'+func+'"></button>';
    if(type === "list"){
      str += '<button class="btn btn-sm btn-primary add_btns" onclick="'+func_1+'"><span class="fa fa-plus"> </span> Add '+name+'</button>';
    }
    str += '<br>'
    + '<div class="page-header text-center">'
    +       '<h2>'+heading+'</h2>'
    + '</div>'
    + '<div id="'+type+'_'+id+'_panel_messageDiv"></div>'
    + '<div class="content_div" id="'+type+'_'+id+'_panel_content_div"></div>'
    + '</div>';
  }
  else if(type === "entry"){
    str = '<div id="'+type+'_'+id+'_panel" class="jumbotron entry_panel lesspadding">'
    + '<div style="visibility: hidden;" class="headerDiv" id="'+type+'_'+id+'_panelheader">'
    + '<strong style="position: absolute; margin-top: 5px; margin-left: 5px; color: #ced0d3;">Entry <label id="entry_heading_name">'+name+'</label></strong>'
    + '</div>'
    + '<button id="'+type+'_'+id+'_panel_close_btn" class="close_buttons_1" onclick="'+func+'"></button>'
    + '<br>'
    + '<div class="page-header text-center">'
    +       '<h2>Entry <label id="entry_heading_name">'+name+'</label></h2>'
    + '</div>'
    + '<div id="'+type+'_'+id+'_panel_messageDiv"></div>'
    + '<div class="entry_content_div" id="'+type+'_'+id+'_panel_content_div"></div>'
    + '<div class="entry_buttons_div">'
    +   '<button id="e_add_new_btn" class="entry_buttons left_radius" onclick="entry_add_new_btn_click()">'
    +     '<span class="fa fa-plus-square"></span>'
    +     '<div class="entry_buttons_writting_span">Add/New</div>'
    +   '</button>'
    +   '<button id="e_save_btn" class="entry_buttons" onclick="entry_save_btn_click()">'
    +     '<span class="fa fa-save"></span>'
    +     '<div class="entry_buttons_writting_span">Save</div>'
    +   '</button>'
    +   '<button id="e_edit_btn" class="entry_buttons" onclick="entry_edit_btn_click()">'
    +     '<span class="fa fa-edit"></span>'
    +     '<div class="entry_buttons_writting_span">Edit</div>'
    +   '</button>'
    +   '<button id="e_search_btn" class="entry_buttons" onclick="entry_search_btn_click()">'
    +     '<span class="fa fa-search"></span>'
    +     '<div class="entry_buttons_writting_span">Search</div>'
    +   '</button>'
    +   '<button id="e_print_btn" class="entry_buttons" onclick="entry_print_btn_click()">'
    +     '<span class="fa fa-print"></span>'
    +     '<div class="entry_buttons_writting_span">Print</div>'
    +   '</button>'
    +   '<button id="e_print_btn" class="entry_buttons right_radius" onclick="'+func+'">'
    +     '<span class="fa fa-times"></span>'
    +     '<div class="entry_buttons_writting_span">Close</div>'
    +   '</button>'
    + '</div>'
    + '</div>';
  }
  return str;
}

function refresh_show_options(id, name, type){
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/panels/show_panel_options.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if(type === "asset"){
        document.getElementById("add_"+id+"_panel_content_div").innerHTML = this.responseText;
      }
      else if(type === "edit"){
        document.getElementById("edit_"+id+"_panel_content_div").innerHTML = this.responseText;
      }
      else if(type === "list"){
        document.getElementById("list_"+id+"_panel_content_div").innerHTML = this.responseText;
      }
      else if(type === "entry"){
        document.getElementById("entry_"+id+"_panel_content_div").innerHTML = this.responseText;
      }
      else if(type === "report"){
        document.getElementById("report_"+id+"_panel_content_div").innerHTML = this.responseText;
      }
      refresh_options_in_panel(id, name);
    }
  }

  if(type === "asset"){
    ajax.send("asset_id=" + id + "&asset_name=" + name + "&system_id=" + system_id + "&type=" + 'asset');
  }
  else if(type === "edit"){
    ajax.send("asset_id=" + id + "&asset_name=" + name + "&system_id=" + system_id + "&type=" + 'edit_asset');
  }
  else if(type === "list"){
    ajax.send("asset_id=" + id + "&asset_name=" + name + "&system_id=" + system_id + "&type=" + 'list');
  }
  else if(type === "entry"){
    ajax.send("entry_id=" + id + "&entry_name=" + name + "&system_id=" + system_id + "&type=" + 'entry');
  }
  else if(type === "report"){
    ajax.send("report_id=" + id + "&report_name=" + name + "&system_id=" + system_id + "&type=" + 'report');
  }
}

function refresh_show_options_for_edit(id, name, type, vals, form_length, value_id){
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/panels/show_panel_options.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("edit_"+id+"_panel_content_div").innerHTML = this.responseText;
      refresh_options_in_panel_for_edit(id, name, type, vals, form_length, value_id);
    }
  }
  ajax.send("asset_id=" + id + "&asset_name=" + name + "&system_id=" + system_id + "&type=" + 'edit_asset');
}

function refresh_options_in_panel(id, name){
  var business = document.getElementById("select_business").value;
  if(document.getElementById("show_frontend_"+id+"_div")){
    var option_id = "";
    if(document.getElementById("asset_id_options_panels_dev")){
      option_id = document.getElementById("asset_id_options_panels_dev").innerHTML;
    }
    else if(document.getElementById("edit_asset_id_options_panels_dev")){
      option_id = document.getElementById("edit_asset_id_options_panels_dev").innerHTML;
    }
    else if(document.getElementById("list_id_options_panels_dev")){
      option_id = document.getElementById("list_id_options_panels_dev").innerHTML;
    }
    else if(document.getElementById("entry_id_options_panels_dev")){
      option_id = document.getElementById("entry_id_options_panels_dev").innerHTML;
    }
    else if(document.getElementById("report_id_options_panels_dev")){
      option_id = document.getElementById("report_id_options_panels_dev").innerHTML;
    }
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/refresh/refresh_sub_options.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("show_frontend_"+id+"_div").innerHTML = this.responseText;
        $('.select2-single').select2()
        if(document.getElementById("list_id_options_panels_dev")){
          $('#list_table').DataTable({
            "scrollX": true,
            "scrollY": 250,
            });
            $('.dataTables_length').addClass('bs-select');
        }
        else if(document.getElementById("entry_id_options_panels_dev")){
          entry_add_new_btn_click();
        }
      }
    }
    if(document.getElementById("asset_id_options_panels_dev")){
      ajax.send("option_id=" + option_id + "&option_name=" + name + "&system_id=" + system_id + "&option_type=asset" + "&entry_form=" + 'Yes');
    }
    else if(document.getElementById("edit_asset_id_options_panels_dev")){
      ajax.send("option_id=" + option_id + "&option_name=" + name + "&system_id=" + system_id + "&option_type=edit_asset" + "&entry_form=" + 'Yes');
    }
    else if(document.getElementById("list_id_options_panels_dev")){
      ajax.send("option_id=" + option_id + "&option_name=" + name + "&system_id=" + system_id + "&option_type=list" + "&entry_form=" + 'Yes' + "&business=" + business);
    }
    else if(document.getElementById("entry_id_options_panels_dev")){
      ajax.send("option_id=" + option_id + "&option_name=" + name + "&system_id=" + system_id + "&option_type=entry" + "&entry_form=" + 'Yes');
    }
    else if(document.getElementById("report_id_options_panels_dev")){
      ajax.send("option_id=" + option_id + "&option_name=" + name + "&system_id=" + system_id + "&option_type=report" + "&entry_form=" + 'Yes' + "&business=" + business);
    }
  }
}

function refresh_options_in_panel_for_edit(id, name, type, vals, form_length, value_id){
  if(document.getElementById("show_frontend_"+id+"_div")){
    var option_id = "";
    option_id = document.getElementById("edit_asset_id_options_panels_dev").innerHTML;
    
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/refresh/refresh_sub_options.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("show_frontend_"+id+"_div").innerHTML = this.responseText;
        vals = vals.split(",");
        var values = Array();
        var inp_ids = Array();
        for(var i = 0; i < form_length; i++){
          var input_id = document.getElementById(id+"_label_"+i).innerHTML;
          var input_value = document.getElementById(input_id).value;
          inp_ids.push(input_id);
          values.push(input_value);
        }
        for (var i = 0; i < form_length; i++) {
          var input_id = document.getElementById(id + "_label_" + i).innerHTML;
          document.getElementById(input_id).value = vals[i];
        }
        document.getElementById("value_id").value = value_id;
      }
    }
    ajax.send("option_id=" + option_id + "&option_name=" + name + "&system_id=" + system_id + "&option_type=edit_asset" + "&entry_form=" + 'Yes');
  }
}

// End show options.................!

// Use of program funcs starts....................!

function admin_add_asset_link_click(id, name) {
  document.getElementById("dashboard_main_div").innerHTML = create_panel(id, name, "add");
  document.getElementById("add_"+id+"_panel").style.visibility = "visible";
  dragElement(document.getElementById("add_"+id+"_panel"));
  document.getElementById("add_"+id+"_panel").onclick = function(){
    if(document.getElementById("add_"+id+"_panel").style.zIndex < greatestID){
      document.getElementById("add_"+id+"_panel").style.zIndex = ++greatestID;
    }
  }
  setTimeout(refresh_show_options(id, name, "asset"), 500);
}

function refresh_assets_for_admin_list_options() {
  var user_id = document.getElementById("user_id").value;
  var user_type = document.getElementById("user_type").innerHTML;
  var search = document.getElementById("list_search_inp").value;
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/refresh/refresh_admin_list_options.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("admin_list_ul").innerHTML = this.responseText;
      if (this.responseText === "<li>NO RESULTS</li>") {
        document.getElementById("admin_list_ul").style.color = "rgb(201, 30, 44)";
      }
      else {
        document.getElementById("admin_list_ul").style.color = "#58606e";
      }
    }
  }
  ajax.send("system_id=" + system_id + "&user_id=" + user_id + "&user_type=" + user_type + "&search=" + search);
}

refresh_assets_for_admin_list_options();

function refresh_entries_for_admin_entry_options() {
  var user_id = document.getElementById("user_id").value;
  var user_type = document.getElementById("user_type").innerHTML;
  var search = document.getElementById("entry_search_inp").value;
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/refresh/refresh_admin_entry_options.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("admin_entry_ul").innerHTML = this.responseText;
      if (this.responseText === "<li>NO RESULTS</li>") {
        document.getElementById("admin_entry_ul").style.color = "rgb(201, 30, 44)";
      }
      else {
        document.getElementById("admin_entry_ul").style.color = "#58606e";
      }
    }
  }
  ajax.send("system_id=" + system_id + "&user_id=" + user_id + "&user_type=" + user_type + "&search=" + search);
}

refresh_entries_for_admin_entry_options();

function refresh_reports_for_admin_report_options() {
  var user_id = document.getElementById("user_id").value;
  var user_type = document.getElementById("user_type").innerHTML;
  var search = document.getElementById("report_search_inp").value;
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/refresh/refresh_admin_report_options.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("admin_reports_ul").innerHTML = this.responseText;
      if (this.responseText === "<li>NO RESULTS</li>") {
        document.getElementById("admin_reports_ul").style.color = "rgb(201, 30, 44)";
      }
      else {
        document.getElementById("admin_reports_ul").style.color = "#58606e";
      }
    }
  }
  ajax.send("system_id=" + system_id + "&user_id=" + user_id + "&user_type=" + user_type + "&search=" + search);
}

refresh_reports_for_admin_report_options();

function add_values_asset_save_btn_click(option_id, form_length){
  var user_id = document.getElementById("user_id").value;
  var user_type = document.getElementById("user_type").innerHTML;
  var business = document.getElementById("select_business").value;
  var values = Array();
  var inp_ids = Array();
  for(var i = 0; i < form_length; i++){
    var input_id = document.getElementById(option_id+"_label_"+i).innerHTML;
    var input_value = document.getElementById(input_id).value;
    inp_ids.push(input_id);
    values.push(input_value);
  }
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/add/add_values.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "Added Successfully...!") {
        document.getElementById("add_" + option_id + "_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
          + this.responseText + "</div>";
        setTimeout(function () {
          // document.getElementById("add_" + option_id + "_panel").style.visibility = "hidden";
          for (var i = 0; i < form_length; i++) {
            var input_id = document.getElementById(option_id + "_label_" + i).innerHTML;
            document.getElementById(input_id).value = "";
          }
          var input_id = document.getElementById(option_id + "_label_" + 0).innerHTML;
          document.getElementById(input_id).focus();
          document.getElementById("add_" + option_id + "_panel_messageDiv").innerHTML = "";
        }, 700);
      }
      else {
        document.getElementById("add_" + option_id + "_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
          + this.responseText + "</div>";
      }
    }
  }
  ajax.send("option_type=asset" + "&option_id=" + option_id + "&inp_ids=" + inp_ids +  "&values=" + values + "&system_id=" + system_id + "&user_id=" + user_id + "&user_type=" + user_type + "&business=" + business);
}

function add_values_asset_cancel_btn_click(option_id, option_name){
  document.getElementById("add_"+option_id+"_panel").style.visibility = "hidden";
  admin_list_asset_link_click(option_id, option_name);
}

function admin_list_asset_link_click(id, name) {
  document.getElementById("dashboard_main_div").innerHTML = create_panel(id, name, "list");
  document.getElementById("list_"+id+"_panel").style.visibility = "visible";
  dragElement(document.getElementById("list_"+id+"_panel"));
  // document.getElementById("list_"+id+"_panel").onclick = function(){
  //   if(document.getElementById("list_"+id+"_panel").style.zIndex < greatestID){
  //     document.getElementById("list_"+id+"_panel").style.zIndex = ++greatestID;
  //   }
  // }
  setTimeout(refresh_show_options(id, name, "list"), 500);
}

function edit_asset_value_btn_click(id, name, vals, form_length, value_id){
    document.getElementById("dashboard_main_div").innerHTML = create_panel(id, name, "edit");
    document.getElementById("edit_"+id+"_panel").style.visibility = "visible";
    dragElement(document.getElementById("edit_"+id+"_panel"));
    document.getElementById("edit_"+id+"_panel").onclick = function(){
      if(document.getElementById("edit_"+id+"_panel").style.zIndex < greatestID){
        document.getElementById("edit_"+id+"_panel").style.zIndex = ++greatestID;
      }
    }
    refresh_show_options_for_edit(id, name, "edit", vals, form_length, value_id);
}

function list_assets_cancel_btn_click(option_id){
  document.getElementById("list_"+option_id+"_panel").style.visibility = "hidden";
  document.getElementById("dashboard_main_div").innerHTML = "";
}

function edit_values_asset_save_btn_click(option_id, form_length, option_name){
  var values = Array();
  var inp_ids = Array();
  var value_id = document.getElementById("value_id").value;
  var business = document.getElementById("select_business").value;
  for(var i = 0; i < form_length; i++){
    var input_id = document.getElementById(option_id+"_label_"+i).innerHTML;
    var input_value = document.getElementById(input_id).value;
    inp_ids.push(input_id);
    values.push(input_value);
  }
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/edit/edit_values.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "Updated Successfully...!") {
        document.getElementById("edit_" + option_id + "_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
          + this.responseText + "</div>";
        setTimeout(function () {
          document.getElementById("edit_" + option_id + "_panel").style.visibility = "hidden";
          for (var i = 0; i < form_length; i++) {
            var input_id = document.getElementById(option_id + "_label_" + i).innerHTML;
            document.getElementById(input_id).value = "";
          }
          document.getElementById("edit_" + option_id + "_panel_messageDiv").innerHTML = "";
          admin_list_asset_link_click(option_id, option_name);
          // refresh_entries_for_customized_options();
          // refresh_entries_for_edit_options();
        }, 700);
      }
      else {
        document.getElementById("edit_" + option_id + "_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
          + this.responseText + "</div>";
      }
    }
  }
  ajax.send("option_type=asset" + "&option_id=" + option_id + "&inp_ids=" + inp_ids +  "&values=" + values + "&system_id=" + system_id + "&value_id=" + value_id + "&business=" + business);
}

function edit_values_asset_cancel_btn_click(option_id){
  document.getElementById("edit_"+option_id+"_panel").style.visibility = "hidden";
  document.getElementById("dashboard_main_div").innerHTML = "";
}

function entry_cancel_btn_click(option_id){
  document.getElementById("entry_"+option_id+"_panel").style.visibility = "hidden";
  document.getElementById("entry_"+option_id+"_panel").innerHTML = "";
  row_index = 0;
  document.getElementById("dashboard_main_div").innerHTML = "";
}

function admin_entry_link_click(id, name) {
  row_index = 0;
  document.getElementById("dashboard_main_div").innerHTML = create_panel(id, name, "entry");
  document.getElementById("entry_"+id+"_panel").style.visibility = "visible";
  dragElement(document.getElementById("entry_"+id+"_panel"));
  document.getElementById("entry_"+id+"_panel").onclick = function(){
    if(document.getElementById("entry_"+id+"_panel")){
      if(document.getElementById("entry_"+id+"_panel").style.zIndex < greatestID){
        document.getElementById("entry_"+id+"_panel").style.zIndex = ++greatestID;
      }
    }
  }
  setTimeout(refresh_show_options(id, name, "entry"), 500);
}

function report_cancel_btn_click(option_id){
  document.getElementById("report_"+option_id+"_panel").style.visibility = "hidden";
  document.getElementById("dashboard_main_div").innerHTML = "";
}

function admin_report_link_click(id, name) {
  document.getElementById("dashboard_main_div").innerHTML = create_panel(id, name, "report");
  document.getElementById("report_"+id+"_panel").style.visibility = "visible";
  dragElement(document.getElementById("report_"+id+"_panel"));
  document.getElementById("report_"+id+"_panel").onclick = function(){
    if(document.getElementById("report_"+id+"_panel").style.zIndex < greatestID){
      document.getElementById("report_"+id+"_panel").style.zIndex = ++greatestID;
    }
  }
  setTimeout(refresh_show_options(id, name, "report"), 500);
}

function entry_add_to_table_btn_click(option_id, names, types,
  empty_check, similarity_check, opt_texts, opt_values,
  val_frm_othr_src, othr_src_tbl, othr_src_clm, othr_src_clm_val,
  whole_tbl_srch, entry_sum, custom_storage, field_type, formula,
  editable, visible, table_visible){
  add_to_table(option_id, names, types, 
    empty_check, similarity_check, opt_texts, opt_values,
    val_frm_othr_src, othr_src_tbl, othr_src_clm, othr_src_clm_val,
    whole_tbl_srch, entry_sum, custom_storage, field_type, formula,
    editable, visible, table_visible);
  
}

function fetch_order_btn_click(option_id, heading){
  var tbl_name = "entry_"+option_id;
  var h_name = heading;
  show_search_panel("5", h_name, tbl_name, "voucher_no", "fetch_order");
}

var row_index = 0;
function add_to_table(option_id, names, types,
  empty_check, similarity_check, opt_texts, opt_values,
  val_frm_othr_src, othr_src_tbl, othr_src_clm, othr_src_clm_val,
  whole_tbl_srch, entry_sum, custom_storage, field_type, formula,
  editable, visible, table_visible){
  global_names = names = names.split(",,");
  types = types.split(",,");
  empty_check = empty_check.split(",,");
  similarity_check = similarity_check.split(",,");
  opt_texts = opt_texts.split(",,");
  opt_values = opt_values.split(",,");
  val_frm_othr_src = val_frm_othr_src.split(",,");
  othr_src_tbl = othr_src_tbl.split(",,");
  othr_src_clm = othr_src_clm.split(",,");
  othr_src_clm_val = othr_src_clm_val.split(",,");
  whole_tbl_srch = whole_tbl_srch.split(",,");
  entry_sum = entry_sum.split(",,");
  custom_storage = custom_storage.split(",,");
  field_type = field_type.split(",,");
  formula = formula.split(",,");
  editable = editable.split(",,");
  visible = visible.split(",,");
  table_visible = table_visible.split(",,");
  var tbl_bdy = document.getElementById("entries_table_body");
  var str = "<tr style='cursor: pointer;' ondblclick=entries_table_body_double_click(this)>";
  var preset_ids = Array();
  var preset_values = Array();
  for(var j=0; j<row_index; j++){
    for(var i=0; i<names.length; i++){
      preset_ids.push(names[i]+"_"+j);
      preset_values.push(document.getElementById(names[i]+"_"+j).value);
    }
  }
  for(var i=0; i<names.length; i++){
    str += "<td "; 
    if(visible[i] === "False"){
      str += "class='d-none d-xs-none'";
    }
    str += "><div class='input-group mb-3'>"
    if(types[i] === "Select"){
      str += "<select class='form-control table_inputs'>"
      str += "</select>"
    }
    else{
      str += "<input autocomplete='off' id='"+names[i]+"_"+row_index+"' style=";
      str += "'width: auto;'";
      str += "class='form-control table_inputs' placeholder='"+names[i]+"'";
      if(types[i] === "Input Number" || types[i] === "Input Number With Point"){
        if(visible[i] === "False"){
          str += "type='hidden'";
        }
        else{
          str += "type='number'";
        }
      }
      else if(types[i] === "Input Text"){
        if(visible[i] === "False"){
          str += "type='hidden'";
        }
        else{
          str += "type='text'";
        }
      }
      if(editable[i] === "False"){
        str += "readonly ";
      }
      str += "/>"; 
      if(whole_tbl_srch[i] === "True"){
        str += '<div class="input-group-append">'
          + '<button id="'+names[i]+"_"+row_index+'_btn" class="input-group-text btn btn-success"><span class="fa fa-search"></span></button>'
          + '</div>';
      }
    }
    str += "</div>"
    str += "</td>";
  }
  str += "</tr>";
  tbl_bdy.innerHTML += str;
  var inp_0 = document.getElementById(names[0]+"_"+row_index)
  if(inp_0){
    inp_0.focus();
  }
  row_index++;
  for(var j=0; j<row_index; j++){
    for(var i=0; i<names.length; i++){
      set_onfocus(i, j, names, val_frm_othr_src, othr_src_tbl, othr_src_clm);
      set_onfocusin(i, j, names, othr_src_tbl, othr_src_clm, othr_src_clm_val, formula, field_type, entry_sum);
      set_onkeyup(option_id, i, j, names);
      set_btn_onclick(i, j, option_id, names, othr_src_tbl, othr_src_clm, whole_tbl_srch);
    }
  }
  for(var i=0; i<preset_values.length; i++){
    document.getElementById(preset_ids[i]).value = preset_values[i];
  }
  if(inp_0){
    inp_0.onfocus();
  }
  entry_sum_func(names, entry_sum);
  
}

function set_onfocus(i, j, names, val_frm_othr_src, othr_src_tbl, othr_src_clm){
  if(val_frm_othr_src[i] === "True"){
    document.getElementById(names[i]+"_"+j).onfocus = function(){
      autocomplete_with_db(names[i]+"_"+j, val_frm_othr_src[i], othr_src_tbl[i], othr_src_clm[i]);
    }
  }
}

function set_onfocusin(i, j, names, othr_src_tbl, othr_src_clm, othr_src_clm_val, formula, field_type, entry_sum){
  if(field_type[i] === "Grouped"){
    document.getElementById(names[i]+"_"+j).onfocusin = function(){
      fetch_value(othr_src_tbl[i], othr_src_clm[i], othr_src_clm_val[i], names[i]+"_"+j, formula[i]+"_"+j);
    }
    document.getElementById(names[i]+"_"+j).onclick = function(){
      fetch_value(othr_src_tbl[i], othr_src_clm[i], othr_src_clm_val[i], names[i]+"_"+j, formula[i]+"_"+j);
    }
  }
  else if(field_type[i] === "Formulated"){
    document.getElementById(names[i]+"_"+j).onfocusin = function(){
      run_formula_entry_multiple(formula[i], names[i]+"_"+j, j);
      entry_sum_func(names, entry_sum);
    }
    document.getElementById(names[i]+"_"+j).onclick = function(){
      run_formula_entry_multiple(formula[i], names[i]+"_"+j, j);
      entry_sum_func(names, entry_sum);
    }
  }
  document.getElementById(names[i]+"_"+j).onfocusout = function(){
    inp_onclicks();
  }
  document.getElementById(names[i]+"_"+j).onchange = function(){
    inp_onclicks();
    entry_sum_func(names, entry_sum);
  }
}

function set_onkeyup(option_id, i, j, names){
  var business = document.getElementById("select_business").value;
  document.getElementById(names[i]+"_"+j).onkeyup = function(){
    if(option_id === "5"){
      product_id = document.getElementById("Product Code"+"_"+j).value;
      quantity = document.getElementById("Quantity_"+j).value;
      var ajax = new XMLHttpRequest();
      var method = "POST";
      var url = "./dashboard/check/check_purchase_pending_order.php";
      var asynchronous = true;
      ajax.open(method, url, asynchronous);
      ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          if(this.responseText === "Cleared"){
            document.getElementById("entry_5_panel_messageDiv").innerHTML = "";
          }
          else{
            var msg = this.responseText.split("--sp--");
            document.getElementById("entry_5_panel_messageDiv").innerHTML = "<div class='alert alert-warning' role='alert'>" + 
            msg[0] + "</div>";
            // document.getElementById("Quantity_"+j).value = msg[1];
          }
        }
      }
      ajax.send("product_id=" + product_id + "&quantity=" + quantity + "&system_id=" + system_id + "&business=" + business);
    }
    else if(option_id === "6"){
      product_id = document.getElementById("Product ID"+"_"+j).value;
      quantity = document.getElementById("Quantity_"+j).value;
      van_id = document.getElementById("Van ID").value;
      if(document.getElementById("Van").value !== ""){
        var ajax = new XMLHttpRequest();
        var method = "POST";
        var url = "./dashboard/check/check_sale_clearance.php";
        var asynchronous = true;
        ajax.open(method, url, asynchronous);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            if(this.responseText === "Cleared"){
              document.getElementById("entry_6_panel_messageDiv").innerHTML = "";
            }
            else{
              var msg = this.responseText.split("--sp--");
              document.getElementById("entry_6_panel_messageDiv").innerHTML = "<div class='alert alert-warning' role='alert'>" + 
              msg[0] + " Quantity='"+ msg[1] + "</div>";
              // document.getElementById("Quantity_"+j).value = msg[1];
            }
          }
        }
        ajax.send("product_id=" + product_id + "&quantity=" + quantity + "&van_id=" + van_id + "&system_id=" + system_id + "&business=" + business);
      }
      else if(option_id === "16"){
        product_id = document.getElementById("Product ID"+"_"+j).value;
        quantity = document.getElementById("Quantity_"+j).value;
        var ajax = new XMLHttpRequest();
        var method = "POST";
        var url = "./dashboard/check/check_van_issue_clearance.php";
        var asynchronous = true;
        ajax.open(method, url, asynchronous);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            if(this.responseText === "Cleared"){
              document.getElementById("entry_16_panel_messageDiv").innerHTML = "";
            }
            else{
              var msg = this.responseText.split("--sp--");
              document.getElementById("entry_16_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>" + 
              msg[0] +"'</div>";
              document.getElementById("Quantity_"+j).value = msg[1];
            }
          }
        }
        ajax.send("product_id=" + product_id + "&quantity=" + quantity + "&system_id=" + system_id + "&business=" + business);
      }
    }
    else if(option_id === "7"){
      date = document.getElementById("Date").value;
      account_id = document.getElementById("Account").value;
      amount = document.getElementById("Amount_"+j).value;
      var ajax = new XMLHttpRequest();
      var method = "POST";
      var url = "";
      if(account_id === "0"){
        url = "./dashboard/check/check_cash_in_hand.php";  
      }
      else{
        url = "./dashboard/check/check_account_cash.php";  
      }
      var asynchronous = true;
      ajax.open(method, url, asynchronous);
      ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          if(this.responseText === "Cleared"){
            document.getElementById("entry_7_panel_messageDiv").innerHTML = "";
          }
          else{
            var msg = this.responseText.split("--sp--");
            if(account_id === "0"){
              document.getElementById("entry_7_panel_messageDiv").innerHTML = "<div class='alert alert-warning' role='alert'>" + msg[0] + " Cash in hand='"+msg[1]+"'</div>";  
            }
            else{
              document.getElementById("entry_7_panel_messageDiv").innerHTML = "<div class='alert alert-warning' role='alert'>" + msg[0] + " Balance='"+msg[1]+"'</div>";
            }
            // document.getElementById("Amount_"+j).value = msg[1];
          }
        }
      }
      if(account_id === "0"){
        ajax.send("amount=" + amount + "&date=" + date + "&system_id=" + system_id + "&business=" + business);
      }
      else{
        ajax.send("amount=" + amount + "&date=" + date + "&system_id=" + system_id + "&account_id=" + account_id + "&business=" + business);
      }
    }
    else if(option_id === "14"){
      date = document.getElementById("Date").value;
      account_id = document.getElementById("Account").value;
      amount = document.getElementById("Amount_"+j).value;
      var ajax = new XMLHttpRequest();
      var method = "POST";
      var url = "";
      if(account_id === "0"){
        url = "./dashboard/check/check_cash_in_hand.php";  
      }
      else{
        url = "./dashboard/check/check_account_cash.php";  
      }
      var asynchronous = true;
      ajax.open(method, url, asynchronous);
      ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          if(this.responseText === "Cleared"){
            document.getElementById("entry_14_panel_messageDiv").innerHTML = "";
          }
          else{
            var msg = this.responseText.split("--sp--");
            if(account_id === "0"){
              document.getElementById("entry_14_panel_messageDiv").innerHTML = "<div class='alert alert-warning' role='alert'>" + msg[0] + " Cash in hand='"+msg[1]+"'</div>";  
            }
            else{
              document.getElementById("entry_14_panel_messageDiv").innerHTML = "<div class='alert alert-warning' role='alert'>" + msg[0] + " Balance='"+msg[1]+"'</div>";
            }
            // document.getElementById("Amount_"+j).value = msg[1];
          }
        }
      }
      if(account_id === "0"){
        ajax.send("amount=" + amount + "&date=" + date + "&system_id=" + system_id + "&business=" + business);
      }
      else{
        ajax.send("amount=" + amount + "&date=" + date + "&system_id=" + system_id + "&account_id=" + account_id + "&business=" + business);
      }
    }
    else if(option_id === "17"){
      date = document.getElementById("Date").value;
      account_id = document.getElementById("Account").value;
      amount = document.getElementById("Total Salary_"+j).value;
      var ajax = new XMLHttpRequest();
      var method = "POST";
      var url = "";
      if(account_id === "0"){
        url = "./dashboard/check/check_cash_in_hand.php";  
      }
      else{
        url = "./dashboard/check/check_account_cash.php";  
      }
      var asynchronous = true;
      ajax.open(method, url, asynchronous);
      ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          if(this.responseText === "Cleared"){
            document.getElementById("entry_17_panel_messageDiv").innerHTML = "";
          }
          else{
            var msg = this.responseText.split("--sp--");
            if(account_id === "0"){
              document.getElementById("entry_17_panel_messageDiv").innerHTML = "<div class='alert alert-warning' role='alert'>" + msg[0] + " Cash in hand='"+msg[1]+"'</div>";  
            }
            else{
              document.getElementById("entry_17_panel_messageDiv").innerHTML = "<div class='alert alert-warning' role='alert'>" + msg[0] + " Balance='"+msg[1]+"'</div>";
            }
            // document.getElementById("Amount_"+j).value = msg[1];
          }
        }
      }
      if(account_id === "0"){
        ajax.send("amount=" + amount + "&date=" + date + "&system_id=" + system_id  + "&business=" + business);
      }
      else{
        ajax.send("amount=" + amount + "&date=" + date + "&system_id=" + system_id + "&account_id=" + account_id + "&business=" + business);
      }
    }
    else if(option_id === "50"){
      date = document.getElementById("Date").value;
      account_id = document.getElementById("Account ID"+"_"+j).value;
      amount = document.getElementById("Amount_"+j).value;
      var ajax = new XMLHttpRequest();
      var method = "POST";
      var url = "./dashboard/check/check_cash_in_hand.php";
      var asynchronous = true;
      ajax.open(method, url, asynchronous);
      ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          if(this.responseText === "Cleared"){
            document.getElementById("entry_50_panel_messageDiv").innerHTML = "";
          }
          else{
            var msg = this.responseText.split("--sp--");
            document.getElementById("entry_50_panel_messageDiv").innerHTML = "<div class='alert alert-warning' role='alert'>" + 
            msg[0] + " Cash in hand='"+msg[1]+"'</div>";
            // document.getElementById("Amount_"+j).value = msg[1];
          }
        }
      }
      ajax.send("account_id=" + account_id + "&amount=" + amount + "&date=" + date + "&system_id=" + system_id + "&business=" + business);
    }
    else if(option_id === "51"){
      date = document.getElementById("Date").value;
      account_id = document.getElementById("Account ID"+"_"+j).value;
      amount = document.getElementById("Amount_"+j).value;
      var ajax = new XMLHttpRequest();
      var method = "POST";
      var url = "./dashboard/check/check_account_cash.php";
      var asynchronous = true;
      ajax.open(method, url, asynchronous);
      ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      ajax.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          if(this.responseText === "Cleared"){
            document.getElementById("entry_51_panel_messageDiv").innerHTML = "";
          }
          else{
            var msg = this.responseText.split("--sp--");
            document.getElementById("entry_51_panel_messageDiv").innerHTML = "<div class='alert alert-warning' role='alert'>" + 
            msg[0] + " Balance='"+msg[1]+"'</div>";
            // document.getElementById("Amount_"+j).value = msg[1];
          }
        }
      }
      ajax.send("account_id=" + account_id + "&amount=" + amount + "&date=" + date + "&system_id=" + system_id + "&business=" + business);
    }
  }
}

function set_btn_onclick(i, j, option_id, names, othr_src_tbl, othr_src_clm, whole_tbl_srch){
  if(whole_tbl_srch[i] === "True"){
    document.getElementById(names[i]+"_"+j+'_btn').onclick = function(){
      show_search_panel(option_id, names[i]+"_"+j, othr_src_tbl[i], othr_src_clm[i]);
    }
  }
}

function entry_sum_func(names, entry_sum){
  var str = "<tr>";
  for(var i=0; i<names.length; i++){
    if(entry_sum[i] === "True"){
      str += "<td><strong>"+names[i]+": </strong><label id='sum_"+names[i]+"'></label><td>";
    }
  }
  str += "</tr>";
  document.getElementById("sum_tbl_bdy").innerHTML = str;
  for(var j=0; j<row_index; j++){
    for(var i=0; i<names.length; i++){
      if(entry_sum[i] === "True"){
        document.getElementById("sum_"+names[i]).innerHTML = (parseFloat(document.getElementById("sum_"+names[i]).innerHTML === "" ? 0 : document.getElementById("sum_"+names[i]).innerHTML) + parseFloat(document.getElementById(names[i]+"_"+j).value === "" ? 0 : document.getElementById(names[i]+"_"+j).value));
      }
    }
  }
  if(document.getElementById("entry_5_panel_content_div") || document.getElementById("entry_6_panel_content_div") || document.getElementById("entry_42_panel_content_div") || document.getElementById("entry_43_panel_content_div")){
    bags_bundles_sum();
  }
}

function bags_bundles_sum(){
  var bundles_sum = 0;
  var sub_bundles_sum = 0;
  var bags_sum = 0;
  var sub_bags_sum = 0;
  for(var j=0; j<row_index; j++){
    if(document.getElementById("P Packing 2_"+j).value === "Bags"){
      bags_sum += parseInt(document.getElementById("P Packing 1_"+j).value === "" ? 0 : (parseFloat(document.getElementById("Quantity_"+j).value)/parseFloat(document.getElementById("P Packing 1_"+j).value)));
      sub_bags_sum += (document.getElementById("P Packing 1_"+j).value === "" ? 0 : (parseInt(document.getElementById("Quantity_"+j).value)%parseInt(document.getElementById("P Packing 1_"+j).value)));
    }
    else if(document.getElementById("P Packing 2_"+j).value === "Bundles"){
      bundles_sum += parseInt(document.getElementById("P Packing 1_"+j).value === "" ? 0 : (parseFloat(document.getElementById("Quantity_"+j).value)/parseFloat(document.getElementById("P Packing 1_"+j).value)));
      sub_bundles_sum += (document.getElementById("P Packing 1_"+j).value === "" ? 0 : (parseInt(document.getElementById("Quantity_"+j).value)%parseInt(document.getElementById("P Packing 1_"+j).value)));
    }
  }
  if(!isNaN(bundles_sum)){
    document.getElementById("total_bundles").value = bundles_sum+"."+sub_bundles_sum;
  }
  if(!isNaN(bags_sum)){
    document.getElementById("total_bags").value = bags_sum+"."+sub_bags_sum;
  }
  if(document.getElementById("discount_in_per")){
    search_discount_set();
    payable_amount();
  }
}

function search_discount_set(){
  if(document.getElementById("Discount (%)").value !== "" && document.getElementById("discount_in_per").value === ""){
    document.getElementById("discount_in_per").value = document.getElementById("Discount (%)").value;
  }
}

function payable_amount(){
  var discount = document.getElementById("discount_in_per").value;
  var amount = 0;
  amount = document.getElementById("sum_Amount").innerHTML;
  document.getElementById("Payable Amount").value = (amount - (amount*discount/100));
  document.getElementById("Discount (%)").value = discount;
}

function entries_table_body_double_click(e){
  e.remove();
  row_index--;
  k=0;
  for(var j=0; j<row_index; j++){
    for(var i=0; i<global_names.length; i++){
      document.getElementsByClassName("table_inputs")[k].id = global_names[i]+"_"+j;
      k++;
    }
  }
}

function run_formula(formula, inp_id){
  if(formula !== ""){
    var formula_arr = formula.split("-,-");
    var x = document.getElementById(formula_arr[0]).value === "" ? 0 : parseFloat(document.getElementById(formula_arr[0]).value);
    for(var i=0; i<formula_arr.length; i+=2){
      if(formula_arr[i+1] === "Sum"){
        if(isNaN(formula_arr[i+2])){
          x = document.getElementById(formula_arr[i+2]).value === "" ? (x+0) : (x + parseFloat(document.getElementById(formula_arr[i+2]).value));
        }
        else{
          x = formula_arr[i+2] === "" ? (x+0) : (x + parseFloat(formula_arr[i+2]));
        }
      }
      else if(formula_arr[i+1] === "Subtract"){
        if(isNaN(formula_arr[i+2])){
          x = document.getElementById(formula_arr[i+2]).value === "" ? (x-0) : (x - parseFloat(document.getElementById(formula_arr[i+2]).value));
        }
        else{
          x = formula_arr[i+2] === "" ? (x-0) : (x - parseFloat(formula_arr[i+2]));
        }
      }
      else if(formula_arr[i+1] === "Multiplication"){
        if(isNaN(formula_arr[i+2])){
          x = document.getElementById(formula_arr[i+2]).value === "" ? (x*0) : (x * parseFloat(document.getElementById(formula_arr[i+2]).value));
        }
        else{
          x = formula_arr[i+2] === "" ? (x*0) : (x * parseFloat(formula_arr[i+2]));
        }
      }
      else if(formula_arr[i+1] === "Division"){
        if(isNaN(formula_arr[i+2])){
          x = document.getElementById(formula_arr[i+2]).value === "" ? (x/1) : (x / parseFloat(document.getElementById(formula_arr[i+2]).value));
        }
        else{
          x = formula_arr[i+2] === "" ? (x/1) : (x / parseFloat(formula_arr[i+2]));
        }
      }
      else if(formula_arr[i+1] === "Modulus"){
        if(isNaN(formula_arr[i+2])){
          x = document.getElementById(formula_arr[i+2]).value === "" ? (x%1) :(x % parseFloat(document.getElementById(formula_arr[i+2]).value));
        }
        else{
          x = formula_arr[i+2] === "" ? (x%1) :(x % parseFloat(formula_arr[i+2]));
        }
      }
      document.getElementById(inp_id).value = parseFloat(x).toFixed(2);
    }
  }
}

function run_formula_entry_multiple(formula, inp_id, r_index){
  if(formula !== ""){
    var formula_arr = formula.split("-,-");
    var x = document.getElementById(formula_arr[0]+"_"+r_index).value === "" ? 0 : parseFloat(document.getElementById(formula_arr[0]+"_"+r_index).value);
    for(var i=0; i<formula_arr.length; i+=2){
      if(formula_arr[i+1] === "Sum"){
        if(isNaN(formula_arr[i+2])){
          x = document.getElementById(formula_arr[i+2]+"_"+r_index).value === "" ? (x+0) : (x + parseFloat(document.getElementById(formula_arr[i+2]+"_"+r_index).value));
        }
        else{
          x = formula_arr[i+2] === "" ? (x+0) : (x + parseFloat(formula_arr[i+2]));
        }
      }
      else if(formula_arr[i+1] === "Subtract"){
        if(isNaN(formula_arr[i+2])){
          x = document.getElementById(formula_arr[i+2]+"_"+r_index).value === "" ? (x-0) : (x - parseFloat(document.getElementById(formula_arr[i+2]+"_"+r_index).value));
        }
        else{
          x = formula_arr[i+2] === "" ? (x-0) : (x - parseFloat(formula_arr[i+2]));
        }
      }
      else if(formula_arr[i+1] === "Multiplication"){
        if(isNaN(formula_arr[i+2])){
          x = document.getElementById(formula_arr[i+2]+"_"+r_index).value === "" ? (x*0) : (x * parseFloat(document.getElementById(formula_arr[i+2]+"_"+r_index).value));
        }
        else{
          x = formula_arr[i+2] === "" ? (x*0) : (x * parseFloat(formula_arr[i+2]));
        }
      }
      else if(formula_arr[i+1] === "Division"){
        if(isNaN(formula_arr[i+2])){
          x = document.getElementById(formula_arr[i+2]+"_"+r_index).value === "" ? (x/1) : (x / parseFloat(document.getElementById(formula_arr[i+2]+"_"+r_index).value));
        }
        else{
          x = formula_arr[i+2] === "" ? (x/1) : (x / parseFloat(formula_arr[i+2]));
        }
      }
      else if(formula_arr[i+1] === "Modulus"){
        if(isNaN(formula_arr[i+2])){
          x = document.getElementById(formula_arr[i+2]+"_"+r_index).value === "" ? (x%1) :(x % parseFloat(document.getElementById(formula_arr[i+2]+"_"+r_index).value));
        }
        else{
          x = formula_arr[i+2] === "" ? (x%1) :(x % parseFloat(formula_arr[i+2]+"_"+r_index));
        }
      }
      document.getElementById(inp_id).value = parseFloat(x).toFixed(2);
    }
  }
}

function fetch_value(table, column, column_against, inp_id, inp_id_against_val){
  var user_id = document.getElementById("user_id").value;
  var user_type = document.getElementById("user_type").innerHTML;
  var business = document.getElementById("select_business").value;
  var val = document.getElementById(inp_id_against_val).value;
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/fetch/fetch_value_for_inp.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if(this.responseText !== "NO RESULT" || this.responseText !== "Database not found...!"){
        if(document.getElementById(inp_id)){
          document.getElementById(inp_id).value = this.responseText;
        }
      }
      else{
        alert(this.responseText);
      }
    }
  }
  ajax.send("table=" + table + "&column=" + column + "&column_against=" + column_against + "&value_against=" + val + "&system_id=" + system_id + "&user_id=" + user_id + "&user_type=" + user_type + "&business=" + business);
}

function fetch_voucher_no(){
  var table = "entry_"+document.getElementById("e_option_id").value;
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/fetch/fetch_voucher_no.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if(this.responseText !== "NO RESULT" || this.responseText !== "Database not found...!"){
        document.getElementById("e_voucher_no").value = this.responseText;
      }
      else{
        alert(this.responseText);
      }
    }
  }
  ajax.send("table=" + table + "&system_id=" + system_id);
}

function disable_form(){
  var option_id = document.getElementById("e_option_id").value;
  var single_form_length = document.getElementById("e_single_form_length").value;
  var inp_id;
  var inp;
  document.getElementById("entry_" + option_id + "_panel_messageDiv").innerHTML = ""
  for(var i=0; i<single_form_length; i++){
    inp_id = document.getElementById(option_id+"_label_"+i).innerHTML;
    inp = document.getElementById(inp_id);
    inp.disabled = true;
  }
  for(var j=0; j<row_index; j++){
    for(var i=0; i<global_names.length; i++){
      inp_id = global_names[i]+"_"+j;
      inp = document.getElementById(inp_id);
      inp.disabled = true;
    }
  }
  document.getElementById("entry_add_to_table_btn").disabled = true;
}

function enable_form(){
  var option_id = document.getElementById("e_option_id").value;
  var single_form_length = document.getElementById("e_single_form_length").value;
  var inp_id;
  var inp;
  document.getElementById("entry_" + option_id + "_panel_messageDiv").innerHTML = ""
  for(var i=0; i<single_form_length; i++){
    inp_id = document.getElementById(option_id+"_label_"+i).innerHTML;
    inp = document.getElementById(inp_id);
    inp.disabled = false;
  }
  for(var j=0; j<row_index; j++){
    for(var i=0; i<global_names.length; i++){
      inp_id = global_names[i]+"_"+j;
      inp = document.getElementById(inp_id);
      inp.disabled = false;
    }
  }
  document.getElementById("entry_add_to_table_btn").disabled = false;
}

function entry_add_new_btn_click(){
  row_index = 0;
  entry_edit = false;
  var option_id = document.getElementById("e_option_id").value;
  var single_form_length = document.getElementById("e_single_form_length").value;
  var inp_id;
  var inp;
  document.getElementById("entry_" + option_id + "_panel_messageDiv").innerHTML = ""
  for(var i=0; i<single_form_length; i++){
    inp_id = document.getElementById(option_id+"_label_"+i).innerHTML;
    inp = document.getElementById(inp_id);
    if(inp.tagName !== "SELECT"){
      inp.value = "";
    }
    else{
      inp.selectedIndex = 0;
    }
  }
  document.getElementById("entries_table_body").innerHTML = "";
  document.getElementById("sum_tbl_bdy").innerHTML = "";
  fetch_voucher_no();
  document.getElementById("e_save_btn").disabled = false;
  document.getElementById("e_save_btn").innerHTML = "<span class='fa fa-save'></span><div class='entry_buttons_writting_span'>Save</div>";
  document.getElementById("e_edit_btn").disabled = true;
  document.getElementById("e_edit_btn").innerHTML = "<span class='fa fa-ban'></span><div class='entry_buttons_writting_span'>Edit</div>";
  document.getElementById("e_search_btn").disabled = false;
  document.getElementById("e_search_btn").innerHTML = "<span class='fa fa-search'></span><div class='entry_buttons_writting_span'>Search</div>";
  document.getElementById("e_print_btn").disabled = true;
  document.getElementById("e_print_btn").innerHTML = "<span class='fa fa-ban'></span><div class='entry_buttons_writting_span'>Print</div>";
  enable_form();
}

function entry_save_btn_click(){
  save_entry(entry_edit);
}

function save_entry(entry_edit){
  var option_id = document.getElementById("e_option_id").value;
  var single_form_length = document.getElementById("e_single_form_length").value;
  var inp_id;
  var inp;
  var single_ids = new Array();
  var single_values = new Array();
  var multiple_ids = new Array();
  var multiple_values = new Array();
  var clear = false;
  var missing = "";
  for(var j=0; j<row_index; j++){
    for(var i=0; i<global_names.length; i++){
      if(document.getElementById(global_names[i]+"_"+j).value !== ""){
        clear = true;
      }
      else{
        clear = false;
        missing = global_names[i];
        break;
      }
    }
    if(!clear){
      break;
    }
  }
  if(clear){
    for(var i=0; i<single_form_length; i++){
      inp_id = document.getElementById(option_id+"_label_"+i).innerHTML;
      inp = document.getElementById(inp_id);
      single_ids.push(inp_id);
      single_values.push(inp.value);
    }
    for(var j=0; j<row_index; j++){
      for(var i=0; i<global_names.length; i++){
        multiple_ids.push(global_names[i]);
        multiple_values.push(document.getElementById(global_names[i]+"_"+j).value);
      }
      multiple_ids.push("-splitter-");
      multiple_values.push("-splitter-");
    }
    if(entry_edit){
      edit_entry();
    }
    else{
      insert_entry();
    }
  }
  else{
    document.getElementById("entry_" + option_id + "_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
    + missing + " must not be empty...!</div>";
    document.getElementById("e_save_btn").disabled = false;
  }
}

function insert_entry(){
  document.getElementById("e_save_btn").disabled = true;
  var e_voucher_no = document.getElementById("e_voucher_no").value;
  var option_id = document.getElementById("e_option_id").value;
  var single_form_length = document.getElementById("e_single_form_length").value;
  var inp_id;
  var inp;
  var single_ids = new Array();
  var single_values = new Array();
  var multiple_ids = new Array();
  var multiple_values = new Array();
  var user_id = document.getElementById("user_id").value;
  var user_type = document.getElementById("user_type").innerHTML;
  var business = document.getElementById("select_business").value;
  var clear = false;
  var missing = "";
  for(var j=0; j<row_index; j++){
    for(var i=0; i<global_names.length; i++){
      if(document.getElementById(global_names[i]+"_"+j).value !== ""){
        clear = true;
      }
      else{
        clear = false;
        missing = global_names[i];
        break;
      }
    }
    if(!clear){
      break;
    }
  }
  if(clear){
    for(var i=0; i<single_form_length; i++){
      inp_id = document.getElementById(option_id+"_label_"+i).innerHTML;
      inp = document.getElementById(inp_id);
      single_ids.push(inp_id);
      single_values.push(inp.value);
    }
    for(var j=0; j<row_index; j++){
      for(var i=0; i<global_names.length; i++){
        multiple_ids.push(global_names[i]);
        multiple_values.push(document.getElementById(global_names[i]+"_"+j).value);
      }
      multiple_ids.push("-splitter-");
      multiple_values.push("-splitter-");
    }
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/add/add_values.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Inserted Successfully...!") {
          document.getElementById("entry_" + option_id + "_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>"
            + this.responseText + "</div>";
          setTimeout(function () {
            document.getElementById("entry_" + option_id + "_panel_messageDiv").innerHTML = "";
            disable_form();
          }, 700);
            document.getElementById("e_save_btn").disabled = true;
            document.getElementById("e_save_btn").innerHTML = "<span class='fa fa-ban'></span><div class='entry_buttons_writting_span'>Save</div>";
            document.getElementById("e_edit_btn").disabled = false;
            document.getElementById("e_edit_btn").innerHTML = "<span class='fa fa-edit'></span><div class='entry_buttons_writting_span'>Edit</div>";
            document.getElementById("e_search_btn").disabled = true;
            document.getElementById("e_search_btn").innerHTML = "<span class='fa fa-ban'></span><div class='entry_buttons_writting_span'>Search</div>";
            document.getElementById("e_print_btn").disabled = false;
            document.getElementById("e_print_btn").innerHTML = "<span class='fa fa-print'></span><div class='entry_buttons_writting_span'>Print</div>";
        }
        else {
          document.getElementById("entry_" + option_id + "_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
            + this.responseText + "</div>";
            document.getElementById("e_save_btn").disabled = false;
        }
      }
    }
    ajax.send("option_type=entry" + "&option_id=" + option_id + "&voucher_no=" + e_voucher_no + "&single_ids=" + single_ids +  "&single_values=" + single_values + "&multiple_ids=" + multiple_ids +  "&multiple_values=" + multiple_values + "&system_id=" + system_id + "&user_id=" + user_id + "&user_type=" + user_type + "&business=" + business);
  }
  else{
    document.getElementById("entry_" + option_id + "_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
    + missing + " must not be empty...!</div>";
    document.getElementById("e_save_btn").disabled = false;
  }
}

function edit_entry(){
  document.getElementById("e_save_btn").disabled = true;
  var e_voucher_no = document.getElementById("e_voucher_no").value;
  var option_id = document.getElementById("e_option_id").value;
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/delete/delete_entry.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "Deleted Successfully...!") {
        if(document.getElementById("entries_table_body").rows.length > 0){
          insert_entry();
        }
        else{
          document.getElementById("entry_" + option_id + "_panel_messageDiv").innerHTML = "<div class='alert alert-success' role='alert'>Deleted Successfully</div>";
          document.getElementById("e_save_btn").disabled = true;
          document.getElementById("e_save_btn").innerHTML = "<span class='fa fa-ban'></span><div class='entry_buttons_writting_span'>Save</div>";
          document.getElementById("e_edit_btn").disabled = false;
          document.getElementById("e_edit_btn").innerHTML = "<span class='fa fa-edit'></span><div class='entry_buttons_writting_span'>Edit</div>";
          document.getElementById("e_search_btn").disabled = true;
          document.getElementById("e_search_btn").innerHTML = "<span class='fa fa-ban'></span><div class='entry_buttons_writting_span'>Search</div>";
          document.getElementById("e_print_btn").disabled = false;
          document.getElementById("e_print_btn").innerHTML = "<span class='fa fa-print'></span><div class='entry_buttons_writting_span'>Print</div>";
        }
      }
      else {
        document.getElementById("entry_" + option_id + "_panel_messageDiv").innerHTML = "<div class='alert alert-danger' role='alert'>"
          + this.responseText + "</div>";
          document.getElementById("e_save_btn").disabled = false;
      }
    }
  }
  ajax.send("option_type=entry" + "&option_id=" + option_id + "&voucher_no=" + e_voucher_no + "&system_id=" + system_id);
}

var entry_edit = false;
function entry_edit_btn_click(){
  entry_edit = true;
  document.getElementById("e_save_btn").disabled = false;
  document.getElementById("e_save_btn").innerHTML = "<span class='fa fa-save'></span><div class='entry_buttons_writting_span'>Save</div>";
  document.getElementById("e_edit_btn").disabled = true;
  document.getElementById("e_edit_btn").innerHTML = "<span class='fa fa-ban'></span><div class='entry_buttons_writting_span'>Edit</div>";
  document.getElementById("e_search_btn").disabled = true;
  document.getElementById("e_search_btn").innerHTML = "<span class='fa fa-ban'></span><div class='entry_buttons_writting_span'>Search</div>";
  document.getElementById("e_print_btn").disabled = true;
  document.getElementById("e_print_btn").innerHTML = "<span class='fa fa-ban'></span><div class='entry_buttons_writting_span'>Print</div>";
  enable_form();
}

function entry_search_btn_click(){
  // var e_voucher_no = document.getElementById("e_voucher_no").value;
  var option_id = document.getElementById("e_option_id").value;
  var tbl_name = "entry_"+option_id;
  var h_name = document.getElementById("entry_heading_name").innerHTML;
  show_search_panel(option_id, h_name, tbl_name, "voucher_no");
}

function entry_print_btn_click(){
  var e_voucher_no = document.getElementById("e_voucher_no").value;
  var option_id = document.getElementById("e_option_id").value;
  var f = document.createElement('form');
    f.action='./dashboard/print/entries_print.php';
    f.method='POST';
    f.target='_blank';

    var i=document.createElement('input');
    i.id='print_voucher_no';
    i.type='text';
    i.name='print_voucher_no';
    i.value = e_voucher_no;
    i.className = "abstract_fields";
    f.appendChild(i);
    
    var j=document.createElement('input');
    j.id='print_option_id';
    j.type='text';
    j.name='print_option_id';
    j.value = option_id;
    j.className = "abstract_fields";
    f.appendChild(j);

    var k=document.createElement('input');
    k.id='print_system_id';
    k.type='text';
    k.name='system_id';
    k.value = system_id;
    k.className = "abstract_fields";
    f.appendChild(k);

    document.body.appendChild(f);
    f.submit();
}

function inp_onclicks(){
  var option_id = document.getElementById("e_option_id").value;
  var single_form_length = document.getElementById("e_single_form_length").value;
  for(var i=0; i<single_form_length; i++){
    inp_id = document.getElementById(option_id+"_label_"+i).innerHTML;
    inp = document.getElementById(inp_id);
    if(typeof inp.onclick == "function"){
      inp.onclick();
    }
  }
  for(var j=0; j<row_index; j++){
    for(var i=0; i<global_names.length; i++){
      inp_id = global_names[i]+"_"+j;
      inp = document.getElementById(inp_id);
      if(typeof inp.onclick === "function"){
        if(inp.type === "hidden"){
          inp.onclick();
        }
        else if(inp.type !== "hidden" && global_names[i] === "Amount" && option_id !== 9 && option_id !== 10){
          inp.onclick();
        }
      }
    }
  }
}

// Search panel funcs........................!

var filter_inputs = 0;
function show_search_panel(id, name, tbl_name, clm_name, type){
  var heading = "";
  var str = "";
  heading = "Search " + name;
  filter_inputs = 0;
  str = '<br>'
    + '<div class="page-header text-center">'
    + '<div id="buttons_div">'
    +   '<div class="input-group mb-3">'
    +   '<div class="input-group-prepend">'
    +   '<strong class="input-group-text">Rows Limit: </strong>'
    +   '</div>'
    +     '<input autocomplete="off" type="number" id="rows_limit_input" placeholder="ROWS LIMIT" value="1000">'
    +   '</div>'
    +     '<button id="search_panel_add_filter_btn" style="float: right; margin-right: 5px;" class="btn btn-default">'
    +       '<span class="fa fa-plus"></span>'
    +     '</button>'
    +     '<button id="search_panel_search_btn" style="float: right; margin-right: 5px;" class="btn btn-default">'
    +       '<span class="fa fa-search"></span>'
    +     '</button>'
    + '</div>'
    +     '<h2 id="heading_search_panel">'+heading+'</h2>'
    + '</div>'
    + '<div id="search_panel_messageDiv"></div>'
    + '<div id="search_panel_filters_div"></div>'
    + '<table class="table dtHorizontalExampleWrapper" cellspacing="0" width="100%" id="search_panel_table">'
    + '<thead id="search_panel_table_head"></thead>'
    + '<tbody id="search_panel_table_body"></tbody>';
    + '</table>';
  document.getElementById("search_panel").style.visibility = "visible";
  
  setTimeout(()=>{
    document.getElementById("search_panel_content_div").innerHTML = str;
    document.getElementById("search_panel").style.zIndex = ++greatestID;
    add_filter_options(tbl_name, clm_name);
    document.getElementById("search_panel_add_filter_btn").onclick = function (){
      add_filter_options(tbl_name, clm_name);
    }
    document.getElementById("search_panel_search_btn").onclick = function(){
      show_filter_table_values(tbl_name, clm_name, type, id);
      document.getElementById("buttons_div").innerHTML = "";
      document.getElementById("search_panel_filters_div").innerHTML = "";
    }
  }, 100);
}

function add_filter_options(tbl_name, clm_name){
  filter_inputs++;
  var str = '<div class="input-group mb-3">'
    + '<div class="input-group-prepend">'
    +   '<span class="input-group-text">Filter</span>'
    + '</div>'
    + '<input autocomplete="off" type="text" id="search_panel_input_'+filter_inputs+'" class="form-control" placeholder="Filter" aria-describedby="basic-addon1">'
    + '<div class="input-group-prepend">'
    +      '<span class="input-group-text">By</span>'
    + '</div>'
    + '<select id="search_panel_select_'+filter_inputs+'" class="form-control" aria-describedby="basic-addon1">'
    + '</select>'
    + '</div>';
  document.getElementById("search_panel_filters_div").innerHTML += str;
  load_search_panel_select(tbl_name, filter_inputs);
}

function load_search_panel_select(table_name, select_no){
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/refresh/refresh_columns_in_select.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("search_panel_select_"+select_no).innerHTML = this.responseText;
    }
  }
  ajax.send("table_name=" + table_name + "&system_id=" + system_id);
}

function show_filter_table_values(tbl_name, clm_name, type, option_id){
  var user_id = document.getElementById("user_id").value;
  var user_type = document.getElementById("user_type").innerHTML;
  var business = document.getElementById("select_business").value;
  var x = document.getElementById("search_panel_select_1").innerHTML.replace(/<option/g, "<th");
  x = x.replace(/option>/g, "th>");
  x = x.replace(/value=/g, "id=");
  var str = x;
  var columns_arr = getFromBetween.get(str,'"','"');
  var column_names = "";
  var column_values = "";
  var rows_limit = document.getElementById("rows_limit_input").value;
  for(var i=1; i<=filter_inputs; i++){
    column_names += document.getElementById("search_panel_select_"+i).value+",";
    column_values += document.getElementById("search_panel_input_"+i).value+",";
  }
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/refresh/refresh_filtered_data_in_table.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if(tbl_name.substr(0, 5) === "entry"){
        document.getElementById("search_panel_table_head").innerHTML = "<tr><th>ID</th><th>Voucher No</th><th>Entry By</th>"+x+"</tr>";  
      }
      else{
        document.getElementById("search_panel_table_head").innerHTML = "<tr><th>ID</th>"+x+"</tr>";
      }
      document.getElementById("search_panel_table_body").innerHTML = this.responseText;
      $('#search_panel_table').DataTable({
      "scrollX": true,
      "scrollY": 250,
      });
      $('.dataTables_length').addClass('bs-select');
    }
  }
  ajax.send("table=" + tbl_name + "&column_names=" + column_names + "&column_values=" + column_values + "&columns_arr=" + columns_arr + "&system_id=" + system_id + "&selected_clm=" + clm_name + "&rows_limit=" + rows_limit + "&type=" + type + "&option_id=" + option_id + "&user_id=" + user_id + "&user_type=" + user_type + "&business=" + business);
}

function search_panel_close_btn_click(){
  document.getElementById("search_panel").style.visibility = "hidden";
}

function filtered_list_row_click(val, table, type, option_id, entry_by){
  var x = document.getElementById("heading_search_panel").innerHTML.replace("Search ", "");
  if(document.getElementById(x)){
    document.getElementById(x).value = val;
  }
  else{
    if(document.getElementById("e_voucher_no")){
      document.getElementById("e_voucher_no").value = val;
      populate_entry_form(val, table, type, option_id, entry_by);
    }
  }
  search_panel_close_btn_click();
}

function populate_entry_form(voucher_no, table, type, option_id, entry_by){
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/populate/populate_entry.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var entries_arr = this.responseText.split("--SM--");
      var entries_arr_single = entries_arr[0].split("-+-");
      var entries_arr_multiple_rows = entries_arr[1].split("--re--");
      global_names = entries_arr[2].split("-+-");
      global_val_frm_othr_src = entries_arr[3].split("-+-");
      global_othr_src_tbl = entries_arr[4].split("-+-");
      global_othr_src_clm = entries_arr[5].split("-+-");
      global_othr_src_clm_val = entries_arr[6].split("-+-");
      global_formula = entries_arr[7].split("-+-");
      global_field_type = entries_arr[8].split("-+-");
      global_entry_sum = entries_arr[9].split("-+-");
      global_whole_tbl_srch = entries_arr[10].split("-+-");
      for(var i=0; i<entries_arr_single.length-1; i+=2){
        if(document.getElementById(entries_arr_single[i])){
          document.getElementById(entries_arr_single[i]).value = entries_arr_single[i+1];
        }
      }
      document.getElementById("entries_table_body").innerHTML = "";
      for(var i=0; i<entries_arr_multiple_rows.length-1; i++){
        document.getElementById("entries_table_body").innerHTML += "<tr style='cursor: pointer;' ondblclick=entries_table_body_double_click(this)>"+entries_arr_multiple_rows[i]+"</tr>";
        row_index = i+1;
      }
      if(document.getElementById("discount_in_per")){
        document.getElementById("discount_in_per").value = "";
      }
      for(var j=0; j<row_index; j++){
        for(var i=0; i<global_names.length; i++){
          set_onfocus(i, j, global_names, global_val_frm_othr_src, global_othr_src_tbl, global_othr_src_clm);
          set_onfocusin(i, j, global_names, global_othr_src_tbl, global_othr_src_clm, global_othr_src_clm_val, global_formula, global_field_type, global_entry_sum);
          set_onkeyup(option_id, i, j, global_names);
          set_btn_onclick(i, j, option_id, global_names, global_othr_src_tbl, global_othr_src_clm, global_whole_tbl_srch);
        }
      }
      entry_sum_func(global_names, global_entry_sum);
      if(type !== "fetch_order"){
        document.getElementById("e_save_btn").disabled = true;
        document.getElementById("e_save_btn").innerHTML = "<span class='fa fa-ban'></span><div class='entry_buttons_writting_span'>Save</div>";
        document.getElementById("e_edit_btn").disabled = false;
        document.getElementById("e_edit_btn").innerHTML = "<span class='fa fa-edit'></span><div class='entry_buttons_writting_span'>Edit</div>";
        document.getElementById("e_search_btn").disabled = true;
        document.getElementById("e_search_btn").innerHTML = "<span class='fa fa-ban'></span><div class='entry_buttons_writting_span'>Search</div>";
        document.getElementById("e_print_btn").disabled = false;
        document.getElementById("e_print_btn").innerHTML = "<span class='fa fa-print'></span><div class='entry_buttons_writting_span'>Print</div>";
        disable_form();
      }
      else{
        for(var j=0; j<row_index; j++){
          document.getElementById("Quantity_"+j).onkeyup();
        }
        fetch_voucher_no();
      }
    }
  }
  ajax.send("voucher_no=" + voucher_no +"&table=" + table + "&system_id=" + system_id + "&entry_by=" + entry_by);
}

// Use of program funcs ends....................!

// Sidebar animation......!

jQuery(function ($) {

  $(".sidebar-dropdown > a").click(function () {
    $(".sidebar-submenu").slideUp(200);
    if (
      $(this)
        .parent()
        .hasClass("active")
    ) {
      $(".sidebar-dropdown").removeClass("active");
      $(this)
        .parent()
        .removeClass("active");
    } else {
      $(".sidebar-dropdown").removeClass("active");
      $(this)
        .next(".sidebar-submenu")
        .slideDown(200);
      $(this)
        .parent()
        .addClass("active");
    }
  });

  $("#close-sidebar").click(function () {
    $(".page-wrapper").removeClass("toggled");
    // $('.panel').css({'left': '0px'});
    // $('.panel').css({'width': '100%'});
    $('.entry_panel').css({'left': '0px'});
    $('.entry_panel').css({'width': '100%'});
    $('#users_table').resize();
    $('#list_table').resize();
    $('#search_panel_table').resize();
    $("#dashboard_stock_in_hand_tbl").resize();
    $("#dashboard_profit_loss_tbl").resize();
    $("#dashboard_store_stock_tbl").resize();
    $("#dashboard_van_stock_tbl").resize();
    $("#dashboard_party_ledgers_tbl").resize();
    $("#dashboard_accounts_ledgers_tbl").resize();
  });
  $("#show-sidebar").click(function () {
    $(".page-wrapper").addClass("toggled");
    // $('.panel').css({'left': '260px'});
    // $('.panel').css({'width': 'calc(100vw - 265px)'});
    $('.entry_panel').css({'left': '260px'});
    $('.entry_panel').css({'width': 'calc(100vw - 265px)'});
    $('#users_table').resize();
    $('#list_table').resize();
    $('#search_panel_table').resize();
    $("#dashboard_stock_in_hand_tbl").resize();
    $("#dashboard_profit_loss_tbl").resize();
    $("#dashboard_store_stock_tbl").resize();
    $("#dashboard_van_stock_tbl").resize();
    $("#dashboard_party_ledgers_tbl").resize();
    $("#dashboard_accounts_ledgers_tbl").resize();
  });

});

/**************** Code for getting between value from string ************/

var getFromBetween = {
  results:[],
  string:"",
  getFromBetween:function (sub1,sub2) {
      if(this.string.indexOf(sub1) < 0 || this.string.indexOf(sub2) < 0) return false;
      var SP = this.string.indexOf(sub1)+sub1.length;
      var string1 = this.string.substr(0,SP);
      var string2 = this.string.substr(SP);
      var TP = string1.length + string2.indexOf(sub2);
      return this.string.substring(SP,TP);
  },
  removeFromBetween:function (sub1,sub2) {
      if(this.string.indexOf(sub1) < 0 || this.string.indexOf(sub2) < 0) return false;
      var removal = sub1+this.getFromBetween(sub1,sub2)+sub2;
      this.string = this.string.replace(removal,"");
  },
  getAllResults:function (sub1,sub2) {
      // first check to see if we do have both substrings
      if(this.string.indexOf(sub1) < 0 || this.string.indexOf(sub2) < 0) return;

      // find one result
      var result = this.getFromBetween(sub1,sub2);
      // push it to the results array
      this.results.push(result);
      // remove the most recently found one from the string
      this.removeFromBetween(sub1,sub2);

      // if there's more substrings
      if(this.string.indexOf(sub1) > -1 && this.string.indexOf(sub2) > -1) {
          this.getAllResults(sub1,sub2);
      }
      else return;
  },
  get:function (string,sub1,sub2) {
      this.results = [];
      this.string = string;
      this.getAllResults(sub1,sub2);
      return this.results;
  }
};

/***************** Custom Functions *****************************/

function add_user_click(){
  document.getElementById("newuser_panel").style.visibility = "Visible";
}

function add_user_save_btn_click(){
  var user_id = document.getElementById("user_id").value;
  var user_type = document.getElementById("user_type").innerHTML;
  var fname = document.getElementById("firstname").value;
  var lname = document.getElementById("lastname").value;
  var uname = document.getElementById("username").value;
  var password = document.getElementById("password").value;
  var confirmpassword = document.getElementById("confirmpassword").value;
  var contact = document.getElementById("contact").value;
  var dob = document.getElementById("dob").value;
  if(password === confirmpassword){
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/add/add_user.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Inserted Successfully...!") {
          document.getElementById("newuser_message_div").innerHTML = "<div class='alert alert-success' role='alert'>"
            + this.responseText + "</div>";
          setTimeout(function () {
            document.getElementById("newuser_message_div").innerHTML = "";
          }, 700);
        }
        else {
          document.getElementById("newuser_message_div").innerHTML = "<div class='alert alert-danger' role='alert'>"
            + this.responseText + "</div>";
        }
      }
    }
    ajax.send("system_id=" + system_id + "&fname=" + fname + "&lname=" + lname + "&uname=" + uname + "&password=" + password + "&dob=" + dob +  "&contact=" + contact + "&user_id=" + user_id + "&user_type=" + user_type);
  }
  else{
    document.getElementById("newuser_message_div").innerHTML = "<div class='alert alert-danger' role='alert'>Both passwords must be same</div>";
  }
}

function add_user_close_btn_click(){
  document.getElementById("newuser_panel").style.visibility = "Hidden";
}

function list_user_click(){
  document.getElementById("listuser_panel").style.visibility = "Visible";
  var user_id = document.getElementById("user_id").value;
  var user_type = document.getElementById("user_type").innerHTML;
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/list/list_user.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("users_table_div").innerHTML = this.responseText;
      $('#users_table').DataTable({
        "scrollX": true,
        "scrollY": 250,
        });
        $('.dataTables_length').addClass('bs-select');
    }
  }
  ajax.send("system_id=" + system_id + "&user_id=" + user_id + "&user_type=" + user_type);
}

function list_user_close_btn_click(){
  document.getElementById("listuser_panel").style.visibility = "Hidden";
  document.getElementById("users_table_div").innerHTML = "";
}

function user_edit_btn_click(id, fname, lname, uname, dob, contact, type, status, created_by){
  list_user_close_btn_click();
  document.getElementById("edituser_panel").style.visibility = "Visible";
  document.getElementById("edit_id").value = id;
  document.getElementById("edit_firstname").value = fname;
  document.getElementById("edit_lastname").value = lname;
  document.getElementById("edit_username").value = uname;
  document.getElementById("edit_dob").value = dob;
  document.getElementById("edit_contact").value = contact;
  document.getElementById("edit_status").value = status;
}

function edit_user_close_btn_click(){
  document.getElementById("edituser_panel").style.visibility = "Hidden";
  document.getElementById("edit_id").value = "";
  document.getElementById("edit_firstname").value = "";
  document.getElementById("edit_lastname").value = "";
  document.getElementById("edit_username").value = "";
  document.getElementById("edit_dob").value = "";
  document.getElementById("edit_contact").value = "";
  document.getElementById("edit_status").value = "";
}

function edit_user_save_btn_click(){
  id = document.getElementById("edit_id").value;
  fname = document.getElementById("edit_firstname").value;
  lname = document.getElementById("edit_lastname").value;
  uname = document.getElementById("edit_username").value;
  dob = document.getElementById("edit_dob").value;
  contact = document.getElementById("edit_contact").value;
  status = document.getElementById("edit_status").value;
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/edit/edit_user.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "Updated Successfully...!") {
        document.getElementById("edituser_message_div").innerHTML = "<div class='alert alert-success' role='alert'>"
          + this.responseText + "</div>";
        setTimeout(function () {
          document.getElementById("edituser_message_div").innerHTML = "";
          edit_user_close_btn_click();
          list_user_click();
        }, 700);
      }
      else {
        document.getElementById("edituser_message_div").innerHTML = "<div class='alert alert-danger' role='alert'>"
          + this.responseText + "</div>";
      }
    }
  }
  ajax.send("system_id=" + system_id + "&id=" + id + "&fname=" + fname + "&lname=" + lname + "&uname=" + uname + "&dob=" + dob + "&contact=" + contact + "&status=" + status);
}

function list_user_authorities_click(user_id, user_name, user_type){
  // list_user_close_btn_click();
  var current_user_id = document.getElementById("user_id").value;
  var current_user_type = document.getElementById("user_type").innerHTML;
  document.getElementById("listuser_authorities_panel").style.visibility = "Visible";
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/list/list_authorities.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("users_authorities_table_div").innerHTML = this.responseText;
      $('#users_authorities_table').DataTable({
        "scrollX": true,
        "scrollY": 250,
        });
        $('.dataTables_length').addClass('bs-select');
    }
  }
  ajax.send("system_id=" + system_id + "&current_user_id=" + current_user_id + "&current_user_type=" + current_user_type + "&user_id=" + user_id + "&user_type=" + user_type);
}

function list_user_authorities_close_btn_click(){
  document.getElementById("listuser_authorities_panel").style.visibility = "Hidden";
  document.getElementById("users_authorities_table_div").innerHTML = "";
}

function user_option_allowed_fuction(name, type, spec_opt_id, user_id, user_type, index){
  var current_user_id = document.getElementById("user_id").value;
  var current_user_type = document.getElementById("user_type").innerHTML;
  document.getElementById("listuser_authorities_panel").style.visibility = "Visible";
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/add/add_del_authority.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("allow_notallow_btn_"+index).innerHTML = this.responseText;
    }
  }
  ajax.send("system_id=" + system_id + "&name=" + name + "&type=" + type + "&spec_opt_id=" + spec_opt_id + "&current_user_id=" + current_user_id + "&current_user_type=" + current_user_type + "&user_id=" + user_id + "&user_type=" + user_type);
}

function change_password_click(){
  document.getElementById("change_password_panel").style.visibility = "Visible";
}

function change_password_save_btn_click(){
  var user_id = document.getElementById("user_id").value;
  var user_type = document.getElementById("user_type").innerHTML;
  var password = document.getElementById("change_password").value;
  var newpassword = document.getElementById("change_newpassword").value;
  var confirmpassword = document.getElementById("change_confirmpassword").value;
  if(newpassword === confirmpassword){
    var ajax = new XMLHttpRequest();
    var method = "POST";
    var url = "./dashboard/edit/edit_password.php";
    var asynchronous = true;
    ajax.open(method, url, asynchronous);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.responseText == "Password Changed...!") {
          document.getElementById("changepassword_message_div").innerHTML = "<div class='alert alert-success' role='alert'>"
            + this.responseText + "</div>";
          setTimeout(function () {
            document.getElementById("changepassword_message_div").innerHTML = "";
          }, 700);
        }
        else {
          document.getElementById("changepassword_message_div").innerHTML = "<div class='alert alert-danger' role='alert'>"
            + this.responseText + "</div>";
        }
      }
    }
    ajax.send("system_id=" + system_id + "&password=" + password + "&new_password=" + newpassword + "&user_id=" + user_id + "&user_type=" + user_type);
  }
  else{
    document.getElementById("changepassword_message_div").innerHTML = "<div class='alert alert-danger' role='alert'>New and confirm passwords must be same</div>";
  }
}

function change_password_close_btn_click(){
  document.getElementById("change_password_panel").style.visibility = "Hidden";
}

function shortcut_key_link_click(){
  document.getElementById("shortcut_keys_panel").style.visibility = "Visible";
}

function shortcut_keys_panel_close_btn_click(){
  document.getElementById("shortcut_keys_panel").style.visibility = "Hidden";
}

document.onkeyup = function(e) {
  if (e.altKey && e.which == 65) {
    if(document.getElementById("e_add_new_btn")){
      if(!document.getElementById("e_add_new_btn").disabled){
        document.getElementById("e_add_new_btn").onclick();
      }
    }
  } 
  else if (e.altKey && e.which == 83) {
    if(document.getElementById("e_save_btn")){
      if(!document.getElementById("e_save_btn").disabled){
        document.getElementById("e_save_btn").onclick();
      }
    }
  }
  else if (e.shiftKey && e.which == 69) {
    if(document.getElementById("e_edit_btn")){
      if(!document.getElementById("e_edit_btn").disabled){
        document.getElementById("e_edit_btn").onclick();
      }
    }
  }
  else if (e.shiftKey && e.which == 83) {
    if(document.getElementById("e_search_btn")){
      if(!document.getElementById("e_search_btn").disabled){
        document.getElementById("e_search_btn").onclick();
      }
    }
  }
  else if (e.altKey && e.which == 80) {
    if(document.getElementById("e_print_btn")){
      if(!document.getElementById("e_print_btn").disabled){
        document.getElementById("e_print_btn").onclick();
      }
    }
  }
};

window.onload = function(){
  refresh_business_in_select();
}

function refresh_dashboard(){
  // var user_type = document.getElementById("user_type").innerHTML;
  // var business = document.getElementById("select_business").value;
  // var ajax = new XMLHttpRequest();
  // var method = "POST";
  // var url = "./dashboard/refresh/refresh_dashboard.php";
  // var asynchronous = true;
  // ajax.open(method, url, asynchronous);
  // ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  // ajax.onreadystatechange = function () {
  //   if (this.readyState == 4 && this.status == 200) {
  //     document.getElementById("dashboard_main_dasboard_div").innerHTML = this.responseText;
  //     $("#dashboard_stock_in_hand_tbl").DataTable({
  //       "scrollX": true,
  //       "scrollY": 180,
  //       });
  //       $(".dataTables_length").addClass("bs-select");

  //     $("#dashboard_profit_loss_tbl").DataTable({
  //       "scrollX": true,
  //       "scrollY": 180,
  //       });
  //       $(".dataTables_length").addClass("bs-select");

  //     $("#dashboard_store_stock_tbl").DataTable({
  //       "scrollX": true,
  //       "scrollY": 180,
  //       });
  //       $(".dataTables_length").addClass("bs-select");
      
  //     $("#dashboard_van_stock_tbl").DataTable({
  //       "scrollX": true,
  //       "scrollY": 180,
  //       });
  //       $(".dataTables_length").addClass("bs-select");

  //     $("#dashboard_party_ledgers_tbl").DataTable({
  //       "scrollX": true,
  //       "scrollY": 180,
  //       });
  //       $(".dataTables_length").addClass("bs-select");

  //     $("#dashboard_accounts_ledgers_tbl").DataTable({
  //       "scrollX": true,
  //       "scrollY": 180,
  //       });
  //       $(".dataTables_length").addClass("bs-select");

      
  //     setInterval(()=>{
  //       if(document.getElementById("dashboard_main_div").innerHTML === ""){
  //         document.getElementById("dashboard_content_table").style.visibility = "visible";
  //       }
  //       else{
  //         document.getElementById("dashboard_content_table").style.visibility = "hidden";
  //       }
  //     }, 300);
  //   }
  // }
  // ajax.send("&system_id=" + system_id + "&user_type=" + user_type + "&business=" + business);
}

function refresh_business_in_select(){
  var user_id = document.getElementById("user_id").value;
  var user_type = document.getElementById("user_type").innerHTML;
  var ajax = new XMLHttpRequest();
  var method = "POST";
  var url = "./dashboard/refresh/refresh_business_in_select.php";
  var asynchronous = true;
  ajax.open(method, url, asynchronous);
  ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("select_business").innerHTML = this.responseText;
      refresh_dashboard();
    }
  }
  ajax.send("system_id=" + system_id + "&user_id=" + user_id + "&user_type=" + user_type);
}

function select_business_change(){
  document.getElementById("dashboard_main_div").innerHTML = "";
  refresh_dashboard();
}

function list_business_panel(){
  admin_list_asset_link_click('1', 'Business');
}




$(document).ready(function () {
  
  if($('.select2-single')){
    $('.select2-single').select2();
  }

  // Select2 Single  with Placeholder
  $('.select2-single-placeholder').select2({
    placeholder: "Select a Province",
    allowClear: true
  });      

  // Select2 Multiple
  // if($('.select2-multiple')){
  //   $('.select2-multiple').select2();
  // }

 

});

