var entries_array;
var entries_number=0;
$(document).ready(function(){
    
var s;

//*******************************************************************************
//Outputing start content

//1. create page-wrap div
s="<div id='page-wrap'></div>";
$("body").append(s);

//2. create div for entries
s="<div id='entries'></div>";
$("body").append(s);

//3. obtaining massive of entries
$.post("index.php",{get:'entries'},xyz=function(data){
    if(data.entries_number>0){
        entries_array=data.entries_array;
        entries_number=data.entries_number;
    }
    return entries_number;
},"JSON");
console.log(entries_number,xyz);

//4. Output entries
for (var i in entries_array){
    var id=entries_array[i]['id'];
    var entry_content=entries_array[i]['entry_content'];
        s="<div id=e_block_'"+id+"' class='entry_block'>"+
            "<div id=e_core_"+id+"' class='entry_core'>"+entry_content+
            "/<div>"+
          "</div>";
    $("#entries").append(s);
        
}
    
});