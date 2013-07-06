$(document).ready(function(){
	var send_handler = function(){
		var field = document.getElementById("emailinput");
		var email = field.value;	
		if(email){
			try{loader.abort()}catch(e){};
			loader=$.post("mail.php",{email:email},function(data){
				if(data){
					console.log(data.message);
				}
			},"JSON");
		}
	}
	
	$("#emailinput").keypress(function (e) { 
		if(e.which == 13){
			send_handler();
			document.getElementById("emailinput").value='';
		}
	});   
	$("#joinbutton").click(function(){
		send_handler();
		document.getElementById("emailinput").value='';
	});
});