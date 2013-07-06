$(document).ready(function(){

function Menu(){
        $(".menus").hide(); // Скрываем все содержание при инициализации
        //$("#top").attr("name","1"); // Активируем первую закладку
        //$("#0").attr("class","opened");
        console.log("working");
        $(".el-cat>a").live("click",function(e) {
            $(".menus").hide();
            console.log("click");
            e.preventDefault();
            if ($(this).hasClass("opened")){ //Определение текущейй закладки
                $(this).removeClass("opened").addClass("closed");
                $(".menus").hide();
            }
            else
            {
            nm=$(this).attr('id');
            nm=nm.substring(10);
            $(this).removeClass("closed").addClass("opened");
            $("#menu_"+nm).show();
            }
        });
        
        $(".menus a").live("click",function(e){
            
            nm=$(this).attr('class');
            nnm=$(this).attr('name');
            nm=nm.substring(9);
            try{loader.abort()}catch(e){}
	    loader=$.post("index.php",{tid:nnm,cid:nm},function(data){
                if(data){	          
                    console.log(data.n);
                    console.log(data.cid);
                    if (data.cid!=0){
                        $("#categ_top_"+nnm).replaceWith("<a name='"+nm+"' id='categ_top_"+nnm+"' class='categ closed'>"+data.n+"</a>");
                        $("#name_"+nnm).fadeOut();
                        $("#name_"+nnm).remove();
                        
                        
                        var s="<div id='name_"+nnm+"' class='todo-entry'>"+
                                                        "<table class='thentr'>"+
                                                                "<tr>"+
                                                                        "<td class='left'><a id='name_del_"+nnm+"' class='button delete'>-</a></td>"+
                                                                        "<td class='name-text'><div id='text_"+data.id+"'>"+data.name+"</div></td>"+
                                                                "</tr>"+
                                                        "</table>"+
                                                        "<div class='properties'><div class='el-cat'><a name='"+data.cid+"' id='categ_top_"+nnm+"' class='categ closed'>"+data.n+"</a><div class='menus' id='menu_"+nnm+"'><table class='m_table'>";
                        $obj=$("#names"+data.cid);
			var cnm;
			var ci;
                        for ( var i in data.cat_array){
                                cnm=data.cat_array[i]['cname'];
                                ci=data.cat_array[i]['cid'];
                                s=s+"<tr name='"+ci+"'>"+
                                             "<td>"+
                                             "<a name='"+nnm+"' class='cat_menu_"+ci+"'>"+cnm+"</a>"+
                                             "</td>"+
                                             "</tr>";
                        }
                        s=s+"</table></div></div></div></div>";
                        $obj.append(s);
                        $("#name_"+nnm+" .menus").hide();
                        var editableOptions = {
                                indicator : '',
                                tooltip : 'Кликни, чтобы изменить текст',
                                placeholder : ''
                        };                        
                        $("#text_"+data.id).editable('update.php',editableOptions);
                        
                    }
                }
            },"JSON");
            // Еще нужно найти в таблице элемент с таким id и заменить у него категорию
            $(".menus").hide();
	    $("#name_field").focus();
        });
        
}
Menu();
})