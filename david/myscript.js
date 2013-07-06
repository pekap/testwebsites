
//Properties
var selector="svg>*";
var data={};
var obj={};
data.colorOn="#999999";
data.colorOut="#333333";
data.selector=selector;

// Angle velocity w=1/3.6 sec^-1
// Velocity = r*w
var angle_velocity=0.3; // 0.3 recommended
var linear_velocity=0;
var centric_acceleration=0;

var a_color = "green";
var v_color = "red";
var a_onoff="off";
var v_onoff = "on";
var a_mode = "none";
var v_mode = "block";
var axis_color="#666666";
var myTimer;
var xx=0;
var yy=0;
var myAngle=0;
var zeroangle=0;
var cP={};
cP.x=250;
cP.y=200;
var Origin={};
Origin.x=20;
Origin.y=380;

// add initial objects
/*
$(document).ready(function(){
    d3.xml("shape.svg", "image/svg+xml", function(xml) {
              document.getElementById("svg-picture").appendChild(xml.documentElement);
            });
    var mySvg=d3.select("#svg-picture svg");
    mySvg.append("circle").style("stroke","gray").style("fill","orange").attr("r",5).attr("display","none");
    
});*/

$(document).ready(function(){
    addSvg();
});
function addSvg(){
    d3.xml("shape.svg", "image/svg+xml", function(xml) {
            var mySvg=d3.select("#svg-picture").append("svg");
            console.log(xml.documentElement.getElementById("layer1"));
            obj=xml.documentElement.getElementById("layer1");
            document.getElementsByTagName("svg")[0].appendChild(obj);
            mySvg.select("#layer1").attr("transform","translate(200,-700)");
            mySvg.attr("width",600).attr("height",400);
            appendElements();
            $("#layer1 path").css("fill","#333333");
        });
}
function appendElements(){
    var mySvg=d3.select("svg");
    mySvg.append("circle").style("stroke","none").style("fill","#f1f1f1").attr("r",5).attr("display","none")
        .attr("class","chosen-point");
    mySvg.append("circle").style("stroke","gray").style("fill","orange").attr("r",5).attr("display","none")
        .attr("class","pointer");
    mySvg.append("circle").style("stroke","gray").style("fill","none").attr("r",40).attr("display","none")
        .attr("class","trajectory");
    mySvg.append("circle").style("stroke","none").style("fill","#006666").attr("r",5)
        .attr("cx",cP.x).attr("cy",cP.y)
        .attr("class","central-point");
    
    //arrows definitions
    mySvg.append("defs").append("marker").attr("id","arrow-a").attr("refX",0)
    .attr("refY",2).attr("markerWidth",6).attr("markerHeight",4).attr("orient","auto")
    .append("path").attr("d","M 0,0 V 4 L6,2 Z").attr("style","stroke:none;fill:"+a_color+"");
    mySvg.select("defs").append("marker").attr("id","arrow-v").attr("refX",0)
    .attr("refY",2).attr("markerWidth",6).attr("markerHeight",4).attr("orient","auto")
    .append("path").attr("d","M 0,0 V 4 L6,2 Z").attr("style","stroke:none;fill:"+v_color+"");
    mySvg.select("defs").append("marker").attr("id","arrow-axis").attr("refX",0)
    .attr("refY",2).attr("markerWidth",6).attr("markerHeight",4).attr("orient","auto")
    .append("path").attr("d","M 0,0 V 4 L6,2 Z").attr("style","stroke:none;fill:"+axis_color+"");
    
    //Acceleration and velocity
    g=mySvg.append("g").attr("class","vectors").attr("display","none");
    g.append("line").attr("x1",0).attr("y1",0).attr("x2",30).attr("y2",0)
    .attr("style","stroke:"+a_color+";stroke-width:2px").attr("marker-end","url(#arrow-a)")
    .attr("class","acceleration").attr("display",a_mode).attr("pointer-events","none");
    $("[name=acceleration]").addClass(a_onoff);
    g.append("line").attr("x1",0).attr("y1",0).attr("x2",0).attr("y2",50)
    .attr("style","stroke:"+v_color+";stroke-width:2px").attr("marker-end","url(#arrow-v)")
    .attr("class","velocity").attr("display",v_mode).attr("pointer-events","none");
    $("[name=velocity]").addClass(v_onoff);
    
    //Running point
    mySvg.append("circle").style("stroke","none").style("fill","orange").attr("r",5).attr("display","none")
        .attr("class","running-point");
    mySvg.selectAll("circle").attr("pointer-events","none");
    
    //Axises
    g1=mySvg.append("g").attr("class","axises").attr("transform","translate("+Origin.x+","+Origin.y+")");
    g1.append("line").attr("x1",0).attr("y1",0).attr("x2",540).attr("y2",0)
    .attr("marker-end","url(#arrow-axis)").attr("style","stroke:"+axis_color+";stroke-width:2px").attr("pointer-events","none");
    g1.append("line").attr("x1",0).attr("y1",0).attr("x2",0).attr("y2",-340)
    .attr("marker-end","url(#arrow-axis)").attr("style","stroke:"+axis_color+";stroke-width:2px").attr("pointer-events","none");
}

$(document).on("mouseenter",selector,data,function(){
        $("#svg-picture").removeClass("out").addClass("in");        
        $("circle.pointer").css("display","block");
        fillchange(data.colorOn);
    });

$(document).on("mouseleave",selector,data,function(){
        $("#svg-picture").removeClass("in").addClass("out");
        $("circle.pointer").css("display","none");
        $("#mouse-coordinates").html("Mouse is Outside");
        fillchange(data.colorOut);
    });
$(document).on("click",selector,data,function(e){
        var leftX=$("#svg-picture svg").offset().left;
        var topY=$("#svg-picture svg").offset().top;
        var radius=Math.sqrt(Math.pow((e.pageX-leftX-cP.x),2)+Math.pow((e.pageY-topY-cP.y),2));
        linear_velocity=angle_velocity*radius;
        centric_acceleration=Math.pow(angle_velocity,2)*radius;
        $(".velocity").attr("y2",2*linear_velocity);
        $(".acceleration").attr("x2",3*centric_acceleration);
        
        zeroangle=Math.atan((e.pageY-topY-cP.y)/(e.pageX-leftX-cP.x))*180/Math.PI;
        if (e.pageX-leftX>cP.x){
            zeroangle=zeroangle+180;
        }
        $("circle.trajectory").css("display","block");
        $("circle.trajectory").attr("cx",cP.x).attr("cy",cP.y).attr("r",radius);
        $("circle.running-point").attr("display","block").attr("cx",e.pageX-leftX)
        .attr("cy",e.pageY-topY);
        $("circle.chosen-point").attr("display","block").attr("cx",e.pageX-leftX)
        .attr("cy",e.pageY-topY);
        $(".vectors").attr("display","block");
        xx=e.pageX-leftX;
        yy=e.pageY-topY;
        stopMovement();
        enableButtons();
        startMovement();
    });

function startMovement(){
    //...
    myAngle=myAngle-1;
    $(".running-point").attr("transform","rotate("+myAngle+","+cP.x+","+cP.y+")");
    $(".vectors").attr("transform","rotate("+myAngle+","+cP.x+","+cP.y+"),translate("+xx+","+yy+"),rotate("+zeroangle+")");
    myTimer=setTimeout(startMovement,Math.floor(1000/360/angle_velocity));
}
function stopMovement(){
    myAngle=0;
    clearTimeout(myTimer);
}
$(document).on("mousemove","#stage",function(e){
            if ($("#svg-picture").hasClass("in")){
                var leftX=$("#svg-picture svg").offset().left;
                var topY=$("#svg-picture svg").offset().top;
                displayposition(Math.floor(e.pageX-leftX)-Origin.x,Origin.y-Math.floor(e.pageY-topY));
                var mySvg=d3.select("#svg-picture svg");
                var dataset=[5];
                mySvg.select("circle.pointer")
                    .attr("display","block")
                    .attr("cx",e.pageX-leftX)
                    .attr("cy",e.pageY-topY);
            }
        });

function enableButtons(){
    $(".button").removeClass("disabled").addClass("enabled");
}
$(document).ready(function(){
    $(".button").on("click",function(){
        if ($(this).hasClass("enabled")){
            if ($(this).hasClass("on")){
                $(this).removeClass("on").addClass("off");
                $("."+$(this).attr('name')+"").attr("display","none");
            }
            else{
                $(this).removeClass("off").addClass("on");
                $("."+$(this).attr('name')+"").attr("display","block");
            }
        }
    });
});


function fillchange(color){
    if (color){
        $("#layer1 path").css("fill",color);
    }
}

function displayposition(x,y){
    $("#mouse-coordinates").html('Mouse is Inside: '+x+', '+y);
}

