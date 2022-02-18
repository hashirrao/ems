// Make the DIV element draggable:
var addDiv = document.getElementById("addmanagementsystempanel");
var editDiv = document.getElementById("editmanagementsystempanel");
var deleteDiv = document.getElementById("deletemanagementsystempanel");
dragElement(addDiv);
dragElement(editDiv);
dragElement(deleteDiv);
var greatestID = 5;

addDiv.onclick = function(){
    if(addDiv.style.zIndex < greatestID){
        addDiv.style.zIndex = ++greatestID;
    }
    // console.log("Add Div = "+addDiv.style.zIndex);
    // console.log("Edit Div = "+editDiv.style.zIndex);
}

editDiv.onclick = function(){
    if(editDiv.style.zIndex < greatestID){
      editDiv.style.zIndex = ++greatestID;
    }
}

deleteDiv.onclick = function(){
    if(deleteDiv.style.zIndex < greatestID){
      deleteDiv.style.zIndex = ++greatestID;
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