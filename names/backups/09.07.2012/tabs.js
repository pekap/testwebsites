function resetTabs(){
        $(".content>div").hide(); //�������� ����������
        $(".left-menu a").attr("id",""); //���������� id      
    }

    var myUrl = window.location.href; //�������� URL
    var myUrlTab = myUrl.substring(myUrl.indexOf("#")); // ��� localhost/tabs.html#tab2 myUrlTab = #tab2     
    var myUrlTabName = myUrlTab.substring(0,6); // ��� ���� ����������� ������� myUrlTabName = #tab

    (function(){
        $(".content>div").hide(); // �������� ��� ���������� ��� �������������
        $(".left-menu:first a").attr("id","current"); // ���������� ������ ��������
        $(".content>div:first").fadeIn(); // ���������� ���������� ������ ��������
        
        $(".left-menu a").live("click",function(e) {
            console.log("click");
            e.preventDefault();
            if ($(this).attr("id") == "current"){ //����������� �������� ��������
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
            $(this).attr("id","current"); // ���������� ������� ��������
            
	    
            $($(this).attr('name')).fadeIn(); // ���������� ���������� ������� ��������
            }
            }
        });
        
        for (i = 1; i <= $(".left-menu a").length; i++) {
          if (myUrlTab == myUrlTabName + i) {
              resetTabs();
              $("a[name='"+myUrlTab+"']").attr("id","current"); // ���������� �������� �� url
              $(myUrlTab).fadeIn(); // ���������� ���������� ��������
          }
        }
})()