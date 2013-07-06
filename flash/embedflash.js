function embedGuy(){
    var swfVersionStr = "0";
    var xiSwfUrlStr = "";
    var flashvars = {};
    var params = {};
    params.quality = "best";
    params.bgcolor = "#f1f1f1";
    params.play="true";
    params.loop="true";
    params.wmode="window";
    params.scale="showAll";
    params.menu="true";
    params.salign="";
    params.devicefont="false";
    params.allowScriptAccess = "always";//"sameDomain";
    params.allowFullScreen="true";
    params.movie="webcam.swf";
    var attributes = {};
    attributes.id = "webcam";
    attributes.name = "webcam";
    attributes.align = "middle";
    swfobject.embedSWF(
    "webcam.swf", "flashContent",
    "100%", "100%",
    swfVersionStr, xiSwfUrlStr,
    flashvars, params, attributes);
}
embedGuy();