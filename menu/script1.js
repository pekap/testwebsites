$(document).ready(function(){

function Menu(){
        $(".menus").hide(); // Скрываем все содержание при инициализации
        $("#top").attr("name","1"); // Активируем первую закладку
        //$("#0").attr("class","opened");
        console.log("working");
        $("#top").live("click",function(e) {
            $(".menus").hide();
            console.log("click");
            e.preventDefault();
            if ($(this).hasClass("opened")){ //Определение текущейй закладки
                $(this).removeClass("opened").addClass("closed");
                $(".menus").hide();
                resetTabs();
            }
            else
            {
            $(this).removeClass("closed").addClass("opened");
            $(".menus").show();
            }
        });
        
        $(".menus a").live("click",function(e){
            
            nm=$(this).attr('id');
            try{loader.abort()}catch(e){}
	    loader=$.post("index.php",{num:nm},function(data){
                if(data){	          
                    $("#top").attr("name",nm);
                    console.log(data.n);
                    $("#top").replaceWith("<a id='top' class='closed' name='"+nm+"'>"+data.n+"</a>");
                    console.log("<a id='top' class='closed' name='"+nm+"'>"+data.n+"</a>");
                }
            },"JSON");
            $(".menus").hide();
        });
        
}
Menu();
})