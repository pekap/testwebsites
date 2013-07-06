$(document).ready(function(){		
    console.log("Document is ready to function!")
    function pass_initial(){
        //console.log(serverName);
        console.log("we were called!")
        passed_object=new Object();
        passed_object.serverName="changed Servername";
        passed_object.number=32;
        return passed_object.serverName;
    }
    
    
});

function passing_init(){
    console.log("initialized");
    var passed_obj={};
    passed_obj.movieName="Recorder1";
    amazonadress="rtmp://ec2-54-225-22-152.compute-1.amazonaws.com/fromus";
    localadress="rtmp://localhost/webcamrecording";
    passed_obj.serverName=amazonadress;
    
    
    // Buttons
    $("#record").on("click",function(){
        webcam.recordbutton();
    });
    $("#play").on("click",function(){
        webcam.playbutton();
    });
    
    return passed_obj;
}

    
    
    
    
