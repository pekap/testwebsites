$(document).ready(function(){
//$(".m_1").focus();


window.onpopstate = function(event) {
	resetTabs();
	var myUrlTab = document.location.hash;
	if (myUrlTab=="#tab_team"){
		$("td[name='#tab_team']").attr("id","current"); // ���������� ������ ��������
		$("#tab_team").fadeIn(); // ���������� ���������� ������ ��������
		$("td[name='#tab_team']").addClass("tdopened");
	}
	else{
		if (myUrlTab=="#tab_about"){
		$("td[name='#tab_about']").attr("id","current"); // ���������� ������ ��������
		$("#tab_about").fadeIn(); // ���������� ���������� ������ ��������
		$("td[name='#tab_about']").addClass("tdopened");
		}
		else{
			if (myUrlTab=="#tab_makeanorder"){
			$("td[name='#tab_makeanorder']").attr("id","current"); // ���������� ������ ��������
			$("#tab_makeanorder").fadeIn(); // ���������� ���������� ������ ��������			
			$("td[name='#tab_makeanorder']").addClass("tdopened");
			}else{
				$(".tdm_1").attr("id","current"); // ���������� ������ ��������
				$("#tab_tapdeck").fadeIn(); // ���������� ���������� ������ ��������
				$("td[name='#tab_tapdeck']").addClass("tdopened");
			}
		}
	}
};



function resetTabs(){
        $("#bbody>div").hide(); //�������� ����������
        $("#menu td").attr("id",""); //���������� id
	
	$("#menu td").removeClass("tdopened");
    }

    (function(){
        $("#bbody>div").hide(); // �������� ��� ���������� ��� �������������
	var myUrl = window.location.href; //�������� URL
	var myUrlTab = myUrl.substring(myUrl.indexOf("#")); // ��� localhost/tabs.html#tab2 myUrlTab = #tab2 
        console.log(myUrlTab);
	if (myUrlTab=="#tab_team"){
		$("td[name='#tab_team']").attr("id","current"); // ���������� ������ ��������
		$("#tab_team").fadeIn(); // ���������� ���������� ������ ��������
		window.history.replaceState({pg:'#team'}, '#team' , '#tab_team');
		$("td[name='#tab_team']").addClass("tdopened");
	}
	else{
		if (myUrlTab=="#tab_about"){
		$("td[name='#tab_about']").attr("id","current"); // ���������� ������ ��������
		$("#tab_about").fadeIn(); // ���������� ���������� ������ ��������
		window.history.replaceState({pg:'#tab_about'}, '#tab_about' , '#tab_about');
		$("td[name='#tab_about']").addClass("tdopened");
		}
		else{
			if (myUrlTab=="#tab_makeanorder"){
			$("td[name='#tab_makeanorder']").attr("id","current"); // ���������� ������ ��������
			$("#tab_makeanorder").fadeIn(); // ���������� ���������� ������ ��������			
			window.history.replaceState({pg:'#tab_makeanorder'}, '#tab_makeanorder' , '#tab_makeanorder');
			$("td[name='#tab_makeanorder']").addClass("tdopened");
			}else{
				$("td[name='#tab_tapdeck']").attr("id","current"); // ���������� ������ ��������
				$("#tab_tapdeck").fadeIn(); // ���������� ���������� ������ ��������
				window.history.replaceState({pg:'#tab_tapdeck'}, '#tab_tapdeck' , '#tab_tapdeck');
				$("td[name='#tab_tapdeck']").addClass("tdopened");
			}
		}
	}
	
        $("#menu td").live("click",function(e) {
            console.log("click");
            e.preventDefault();
            if ($(this).attr("id") == "current"){ //����������� �������� ��������
             return       
            }
            else{
		resetTabs();
		$(this).attr("id","current"); // ���������� ������� ��������
		
		
		$("#current").addClass("tdopened");
		$($(this).attr('name')).fadeIn(); // ���������� ���������� ������� ��������
		var nm=$(this).attr('name');
		window.history.pushState({pg:nm}, nm , nm);
            }
        });
        
})()
    
// send order    
	var send_handler = function(){
		var field = document.getElementById("name_field");
		var name = field.value;
		
		if(name){
			try{loader.abort()}catch(e){}
			loader=$.post("makeorder.php",{email:name},function(data){
				if(data){
					console.log(data.id);
					console.log(data.email);
				}
			},"JSON");
		}
	}
	$("#name_field").keypress(function (e) { 
	if(e.which == 13){
		send_handler();
	}
	});   
	$("#enter-field-submit").click(function(){
		send_handler();
	});
});
