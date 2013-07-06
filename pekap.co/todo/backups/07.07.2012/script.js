$(document).ready(function(){
	

	var loader=null;
	
	var delete_handler = function(event){
			
			var el_id=$(this).attr('id');
			var id=+el_id.substring(9);
			console.log("delete #"+id);
			
			try{loader.abort()}catch(e){}
			loader=$.post("index.php",{id:id,option:'del'},function(data){
				if(data){
					$('#name_'+id).remove();	
				}
			});
			event.preventDefault();
		//}
	};
	
	$(".todo-entry .delete").live('click',delete_handler);
	
	
	var send_handler = function(){
		var field = document.getElementById("name_field");
		var name = field.value;
		
		if(name){
			try{loader.abort()}catch(e){}
			loader=$.post("index.php",{name:name,option:'add'},function(data){
				if(data && data.id && data.name){
					$("#names").append("	<div id='name_"+data.id+"' class='todo-entry'>"+
									"<table>"+
										"<tr>"+
											"<td class='left'><a id='name_del_"+data.id+"' class='button delete'>-</a></td>"+
											"<td class='name-text'>"+data.name+"</td>"+
										"</tr>"+
									"</table>"+
								"</div>")
					field.value="";
				}
			},"JSON");
		}
	}
	
	$("#name_field").keypress(function (e) { 
		if(e.which == 13){
			send_handler();
		}
	});   
	$("#submit1").click(function(){
		send_handler();
	});
	
	
	/*
	$("#delall").click('click',function(event){
			try{loader.abort()}catch(e){}
			loader=$.post("index.php",{name:name,option:'delall'},function(data){
				if(data){
				$('#S'+data).remove();
				$('#B'+data).remove();	
				}
			});
			event.preventDefault();
		//}
	});*/
	
});