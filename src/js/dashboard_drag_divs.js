// Make the DIV element draggable:
var addAssetDiv = document.getElementById("add_asset_panel");
dragElement(addAssetDiv);
var addEntryDiv = document.getElementById("add_entry_panel");
dragElement(addEntryDiv);
var addReportDiv = document.getElementById("add_report_panel");
dragElement(addReportDiv);
var addReportSubOptionDiv = document.getElementById("add_report_sub_options_panel");
dragElement(addReportSubOptionDiv);
var editAssetDiv = document.getElementById("edit_asset_panel");
dragElement(editAssetDiv);
var editEntryDiv = document.getElementById("edit_entry_panel");
dragElement(editEntryDiv);
var editReportDiv = document.getElementById("edit_report_panel");
dragElement(editReportDiv);
var addOptionsDiv = document.getElementById("add_panel");
dragElement(addOptionsDiv);
var addSubOptionsDiv = document.getElementById("add_sub_options_panel");
dragElement(addSubOptionsDiv);
var subSettingsOptionsDiv = document.getElementById("settings_sub_options_panel");
dragElement(subSettingsOptionsDiv);
var searchDiv = document.getElementById("search_panel");
dragElement(searchDiv);

var greatestID = 5;

addAssetDiv.onclick = function(){
    if(addAssetDiv.style.zIndex < greatestID){
        addAssetDiv.style.zIndex = ++greatestID;
    }
    // console.log("Add Div = "+addDiv.style.zIndex);
    // console.log("Edit Div = "+editDiv.style.zIndex);
}

addEntryDiv.onclick = function(){
    if(addEntryDiv.style.zIndex < greatestID){
        addEntryDiv.style.zIndex = ++greatestID;
    }
}

addReportDiv.onclick = function(){
    if(addReportDiv.style.zIndex < greatestID){
        addReportDiv.style.zIndex = ++greatestID;
    }
}

addReportSubOptionDiv.onclick = function(){
    if(addReportSubOptionDiv.style.zIndex < greatestID){
        addReportSubOptionDiv.style.zIndex = ++greatestID;
    }
}

editAssetDiv.onclick = function(){
    if(editAssetDiv.style.zIndex < greatestID){
        editAssetDiv.style.zIndex = ++greatestID;
    }
}

editEntryDiv.onclick = function(){
    if(editEntryDiv.style.zIndex < greatestID){
        editEntryDiv.style.zIndex = ++greatestID;
    }
}

editReportDiv.onclick = function(){
    if(editReportDiv.style.zIndex < greatestID){
        editReportDiv.style.zIndex = ++greatestID;
    }
}

addOptionsDiv.onclick = function(){
    if(addOptionsDiv.style.zIndex < greatestID){
        addOptionsDiv.style.zIndex = ++greatestID;
    }
}

addSubOptionsDiv.onclick = function(){
    if(addSubOptionsDiv.style.zIndex < greatestID){
        addSubOptionsDiv.style.zIndex = ++greatestID;
    }
}

subSettingsOptionsDiv.onclick = function(){
    if(subSettingsOptionsDiv.style.zIndex < greatestID){
        subSettingsOptionsDiv.style.zIndex = ++greatestID;
    }
}

searchDiv.onclick = function(){
    if(searchDiv.style.zIndex < greatestID){
        searchDiv.style.zIndex = ++greatestID;
    }
}

function dragElement(elmnt) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id + "header")) {
    // if present, the header is where you move the DIV from:
    document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
  } else {
    // otherwise, move the DIV from anywhere inside the DIV:
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.event;
    e.preventDefault();
    // get the mouse cursor position at startup:
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    // call a function whenever the cursor moves:
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    e.preventDefault();
    // calculate the new cursor position:
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    // set the element's new position:
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
  }

  function closeDragElement() {
    // stop moving when mouse button is released:
    document.onmouseup = null;
    document.onmousemove = null;
  }
}