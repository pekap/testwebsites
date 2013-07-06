function resetTabs(){
        $(".content>div").hide(); //Скрываем содержание
        $(".left-menu a").attr("id",""); //Сбрасываем id      
    }

    var myUrl = window.location.href; //Получаем URL
    var myUrlTab = myUrl.substring(myUrl.indexOf("#")); // Для localhost/tabs.html#tab2 myUrlTab = #tab2     
    var myUrlTabName = myUrlTab.substring(0,6); // Для выше привденного примера myUrlTabName = #tab

    (function(){
        $(".content>div").hide(); // Скрываем все содержание при инициализации
        $(".left-menu:first a").attr("id","current"); // Активируем первую закладку
        $(".content>div:first").fadeIn(); // Показываем содержание первой закладки
        
        $(".left-menu a").live("click",function(e) {
            console.log("click");
	    $(".el-cat>a").removeClass("opened").addClass("closed");
	    $(".menus").hide();
            e.preventDefault();
            if ($(this).attr("id") == "current"){ //Определение текущейй закладки
             return       
            }
            else{
            if ($(this).attr("class") == "all")
            {
            resetTabs();
            $(this).attr("id","current");
            $(".names").fadeIn();
            }
            else{
            resetTabs();
            $(this).attr("id","current"); // Активируем текущую закладку
            
	    
            $($(this).attr('name')).fadeIn(); // Показываем содержание текущей закладки
            }
            }
        });
        
})()