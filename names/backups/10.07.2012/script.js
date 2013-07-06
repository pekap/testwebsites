$(document).ready(function(){
	
	$(".left-menu .all").attr("id","current"); // Активируем первую закладку
        
	var loader=null;
	var tabnum=1;
	var delete_handler = function(event){
			
			var el_id=$(this).attr('id');
			var id=+el_id.substring(9);
			console.log("delete #"+id);
			
			try{loader.abort()}catch(e){}
			loader=$.post("index.php",{id:id,option:'del'},function(data){
				if(data){
					//$('#name_'+id).fadeOut();
					$('#name_'+id).remove();	
				}
			});
			event.preventDefault();
	};
	
	$(".todo-entry .delete").live('click',delete_handler);
	
		
	
	var send_handler = function(){
		var field = document.getElementById("name_field");
		var name = field.value;
		
		if(name){
			try{loader.abort()}catch(e){}
			//var myUrl = window.location.href; //Получаем URL
			//var myUrlTab = myUrl.substring(myUrl.indexOf("#")); // Для localhost/tabs.html#tab2 myUrlTab = #tab2  
			//var tabnum = myUrlTab.substring(5,6); // Для выше привденного примера myUrlTabName = #tab
			nm=($("#current").attr('name'));
			if (nm=='all')
			{
				tabnum=1;
				nm='#names1'
			}
			else{
			tabnum=nm.substring(6);
			console.log(tabnum);
			}
			loader=$.post("index.php",{name:name,option:'add',cid:tabnum},function(data){
				if(data && data.id && data.name){
					s="<div id='name_"+data.id+"' class='todo-entry'>"+
									"<table class='thentr'>"+
										"<tr>"+
											"<td class='left'><a id='name_del_"+data.id+"' class='button delete'>-</a></td>"+
											"<td class='name-text'>"+data.name+"</td>"+
										"</tr>"+
									"</table>"+
									"<div class='properties'><div class='el-cat'><a name='"+data.cid+"' id='categ_top_"+data.id+"' class='categ closed'>"+data.cname+"</a><div class='menus' id='menu_"+data.id+"'><table>";
					$obj=$(nm);
					for ( var i in data.cat_array){
						cnm=data.cat_array[i]['cname'];
						ci=data.cat_array[i]['cid'];
						s=s+"<tr>"+
							     "<td>"+
							     "<a name='"+data.id+"' id='cat_menu_"+ci+"'>"+cnm+"</a>"+
							     "</td>"+
							     "</tr>";
					}
					s=s+"</table></div></div></div></div>";
					$obj.append(s);
					$("#name_"+data.id+" .menus").hide();
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

