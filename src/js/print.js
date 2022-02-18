function entry_sum(){
    var tbl_bdy = document.getElementById("entries_table_body");
    if(tbl_bdy.rows.length > 0){
        for(var i=0; i < tbl_bdy.rows[0].cells.length; i++){
            if(document.getElementById("th_sum_"+i)){
                var sum = 0;
                for(var j=0; j < tbl_bdy.rows.length; j++){
                    sum += (tbl_bdy.rows[j].cells[i].innerHTML === "" ? 0 : parseFloat(tbl_bdy.rows[j].cells[i].innerHTML));
                }
                document.getElementById("th_sum_"+i).innerHTML = sum;
            }
        }
    }
    else{
        var tbl_foot = document.getElementById("entries_table_foot");
        for(var i=0; i < tbl_foot.rows[0].cells.length; i++){
            if(tbl_foot.rows[0].cells[i].innerHTML !== ""){
                tbl_foot.rows[0].cells[i].innerHTML = "0";
            }
        }
    }
}

function payable_amount_purchase(){
  var amount = document.getElementById("th_sum_5").innerHTML;
  var discount = document.getElementById("discount_amount").innerHTML;
  document.getElementById("payable_amount").innerHTML = (amount - (amount*discount/100));
}

// function payable_amount_sale(){
//   var amount = document.getElementById("th_sum_7").innerHTML;
//   var discount = document.getElementById("discount_amount").innerHTML;
//   document.getElementById("payable_amount").innerHTML = (amount - (amount*discount/100));
// }
  

window.onload = entry_sum();
