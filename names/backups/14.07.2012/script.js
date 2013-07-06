$(document).ready(function(){
	
	$("#name_field").focus();
	$("#r_b_1").remove();
	$(".left-menu div[name='1']").css({
		marginBottom:"20px"
	});
	$(".cat_remove_button").hide();
	$(".left-menu .all").attr("id","current"); // Активируем первую закладку
        $(".field").hide();
	var editableOptions = {
		indicator : '',
		tooltip : 'Кликни, чтобы изменить текст',
		placeholder : ''
	};
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
			var nm=($("#current").attr('name'));
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
					var s="<div id='name_"+data.id+"' class='todo-entry'>"+
									"<table class='thentr'>"+
										"<tr>"+
											"<td class='left'><a id='name_del_"+data.id+"' class='button delete'>-</a></td>"+
											"<td class='name-text'><div id='text_"+data.id+"'>"+data.name+"</div></td>"+
										"</tr>"+
									"</table>"+
									"<div class='properties'><div class='el-cat'><a name='"+data.cid+"' id='categ_top_"+data.id+"' class='categ closed'>"+data.cname+"</a>"+
									"<div class='menus' id='menu_"+data.id+"'><table class='m_table'>";
					var cnm;
					var ci;
					for ( var i in data.cat_array){
						cnm=data.cat_array[i]['cname'];
						ci=data.cat_array[i]['cid'];
						s=s+"<tr name='"+ci+"'>"+
							     "<td>"+
							     "<a name='"+data.id+"' class='cat_menu_"+ci+"'>"+cnm+"</a>"+
							     "</td>"+
							     "</tr>";
					}
					s=s+"</table></div></div></div></div>";
					$(nm).append(s);
					$("#name_"+data.id+" .menus").hide();
					field.value="";
					$("#text_"+data.id).editable('update.php',editableOptions);
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
	
	
 
	$(".name-text div").editable('update.php', editableOptions);



// Add category


	var send_cat_handler = function(){
		var cat_field = document.getElementById("category_field");
		var new_cat = cat_field.value;
		
		if(new_cat){
			try{loader.abort()}catch(e){}

			loader=$.post("index.php",{cname:new_cat},function(data){
				if(data.cname && data.cid && data.todo_array){
					//1. Add div to .content
					var s_content="<div id='names"+data.cid+"' class='names'></div>";
					$(".content").append(s_content);
					
					//2. Add entry into each table
					var s_menus;
					for ( var i in data.todo_array){
						s_menus="<tr name='"+data.cid+"'><td><a name='"+data.todo_array[i]['tid']+"' class='cat_menu_"+
									data.cid+"'>"+data.cname+"</a></td></tr>";
						$("#name_"+data.todo_array[i]['tid']+" .m_table").append(s_menus);
						$("#name_"+data.todo_array[i]['tid']+" .menus").hide();
					}
					
					//3. Add to left menu
					var s_leftmenu="<div name='"+data.cid+"' class='temp_menu'><a href='#' name='#names"+data.cid+"'>"+data.cname+"</a>"+
						"<div name='"+data.cid+"' id='r_b_"+data.cid+"' class='cat_remove_button'>-</div></div>";
					$(".left-menu").append(s_leftmenu);
					$("#r_b_"+data.cid).hide();			
					//4. may be it would be better to change current tab

					cat_field.value="";
					//$("#text_"+data.id).editable('update.php',editableOptions);
				}
			},"JSON");
		}
	}

	$("#category_field").keypress(function (e) { 
		if(e.which == 13){
			send_cat_handler();
			$(".fbut").show();
			$(".field").hide();
			$("#name_field").focus();
		}
	});   


	$(".fbut").click(function(){
		$(".fbut").hide();
		$(".field").show();
		$("#category_field").focus();
	});
	$("#category_field").focusout(function(){
		$(".field").hide();
		$(".fbut").show();
		$("#name_field").focus();		
	});
	$(".temp_menu").live('mouseover',function(){
		var name=$(this).attr('name');
		$("#r_b_"+name).show();	
	});
	$(".temp_menu").live('mouseout',function(){
		$(".cat_remove_button").hide();	
	});

	
	// deleting categories
	var delete_cat_handler = function(event){
			
			var cid=$(this).attr('name');

			try{loader.abort()}catch(e){}
			
			
			$(".el-cat>a[name="+cid+"]").text("inbox");
			$(".el-cat>a[name="+cid+"]").attr("name","1"); //вместо 1 должно быть номер inbox
			$("#names1").append($("#names"+cid).html());
			$("#names"+cid).remove();
			$(".m_table tr[name="+cid+"]").remove();
			$(".left-menu div[name="+cid+"]").remove();
			loader=$.post("index.php",{del_cid:cid},function(){});
			event.preventDefault();
	};
	
	$(".cat_remove_button").live('click',delete_cat_handler);	

	$(".el-cat").live('mouseleave',function(){
		$(".menus").hide();
		$(".categ").removeClass("opened").addClass("closed");
	});
});

