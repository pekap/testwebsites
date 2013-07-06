$(document).ready(function(){
                
        console.log("Thanks for using us ;-)");
	// Example 1.1: A single sortable list
	$( ".sortable-list" ).disableSelection();
	$( ".sortable-list" ).sortable({ helper: 'clone' });
	$('.sortable-list li:first .vl_empty.left').css("visibility","hidden");
	$('.sortable-list li:last .vl_empty.right').css("display","none");
	$('.sortable-list').sortable();
	//$( ".sortable-list" ).sortable({ cursorAt: { left: 52,top:52 } });
	//$( '.sortable-list' ).sortable( "option", "containment", 'parent' );
	$( ".sortable-list" ).sortable({ cursor: 'crosshair' });
	$(".element").mouseover(function(){
			$( ".sortable-list" ).sortable({ cursorAt: { left: ($(this).width())/2,top:72 } });
		});
	$("li .closebutton").css("display","none");
	$("li").mouseover(function(){
			$(".closebutton",this).css("display","block");
		});
	$("li").mouseout(function(){
			$("li .closebutton").css("display","none");
		}); 
	$('.sortable-list').sortable({
			start: function(event,ui){
				$(".vl_empty").css("display","block");
				$(".vl_empty",ui.helper).css("display","none");
				//$(".vl_empty",ui.item).css("display","none");
				ui.helper.css("width","104px");
				ui.helper.css("height","104px");
				$(".ui-sortable-placeholder").css("visibility","visible");
				$(".ui-sortable-placeholder").css("width","104px");
				$(".ui-sortable-placeholder").css("height","104px");
				$(".ui-sortable-placeholder").css("opacity","0.1");
				$(".ui-sortable-placeholder").css("margin-left","0px");
				//console.log(ui.placeholder.index());
				if((ui.placeholder.index()>1)&&(ui.item.index()==1)){
					$(".sortable-list li:nth-child(2) .vl_empty.left").css("visibility","hidden");
				}
				if((ui.placeholder.index()>1)&&(ui.item.index()>1)){
					$(".sortable-list li:nth-child(1) .vl_empty.left").css("visibility","hidden");
				}
				if ((ui.placeholder.index()==0)||((ui.placeholder.index()==1)&&(ui.item.index()==0))){
					$(".ui-sortable-placeholder").css("margin-left","40px");
				}
				var nit=$(".sortable-list>li").length-1;
				//console.log($(".sortable-list>li").length);
				if(ui.placeholder.index()<nit-1){
					$(".sortable-list li:nth-child("+nit+") .vl_empty.right").css("display","none");
				//	console.log($(".sortable-list li:last .vl_empty.right"));
				}
				/*if (ui.item.hasClass("first")){
					$(".second .vl_empty.left").css("display","none");
					console.log("dfdf");
				};*/
			},
			update: function(event, ui) {

				//$("li:first").addClass('first');
				//console.log("changed");
			},
			change: function(event,ui) {
				//console.log("placehoder",ui.placeholder.index(),"itemindex",ui.item.index());
				var nit=$(".sortable-list>li").length-1;
				var plin=ui.placeholder.index()+1;
				var itin=ui.item.index()+1;
				if((plin>1)&&(itin==1)){
				//	console.log(ui.placeholder.index());
					$(".sortable-list li:nth-child(2) .vl_empty.left").css("visibility","hidden");
					$(".ui-sortable-placeholder").css("margin-left","0px");
				}
				if((plin>1)&&(itin>1)){
				//	console.log(ui.placeholder.index());
					$(".sortable-list li:nth-child(1) .vl_empty.left").css("visibility","hidden");
					$(".ui-sortable-placeholder").css("margin-left","0px");
				}
				if((plin==2)&&(itin==1)){
					$(".sortable-list li:nth-child(3) .vl_empty.left").css("visibility","visible");
					$(".ui-sortable-placeholder").css("margin-left","40px");
				}
				if((plin==1)&&(itin>1)){
					$(".sortable-list li:nth-child(2) .vl_empty.left").css("visibility","visible");
					$(".ui-sortable-placeholder").css("margin-left","40px");
				}
				//console.log($(".sortable-list>li"),nit,plin,itin);
				var nit1=nit-1;
				var nit2=nit1-1;
				if ((plin<nit)&&(itin<nit1)){
					//console.log("length",$(".sortable-list>li").length);
					$(".sortable-list li:nth-child("+nit+") .vl_empty.right").css("display","none");	
				}
				if ((plin<nit)&&(itin>=nit1)){
				//	console.log("WTF???");
					$(".sortable-list li:nth-child("+nit1+") .vl_empty.right").css("display","none");	
				}
				if ((plin==nit)&&(itin<nit-1)){
					$(".sortable-list li:nth-child("+nit1+") .vl_empty.right").css("display","block");	
				}
				if ((plin>nit-2)&&(itin>nit-2)){
					$(".sortable-list li:nth-child("+nit2+") .vl_empty.right").css("display","block");	
				}
				$(".ui-sortable-helper .vl_empty").css("display","none");
				$(".ui-sortable-placeholder").css("visibility","visible");
				$(".ui-sortable-placeholder").css("width","104px");
				$(".ui-sortable-placeholder").css("height","104px");
				$(".ui-sortable-placeholder").css("opacity","0.1");
				$(".sortable-list:first .vl_empty .left").css("display","none");
			},
			stop: function(event,ui){
				$(".first").removeClass("first");
				$(".second").removeClass("second");
				$(".sortable-list li:first").addClass("first");
				$(".sortable-list li:nth-child(2)").addClass("second");
				$(".sortable-list li .vl_empty").css("display","block");
				$(".sortable-list li .vl_empty").css("visibility","visible");
				$(".sortable-list li:first .vl_empty.left").css("visibility","hidden");
				$(".sortable-list li:last .vl_empty.right").css("display","none");
			}
		});

});
