$(document).ready(function(){
        MathJax.Hub.Queue(function () {
                        obj=allFormulas();
                        //enable cursor pointer;
                        $(".mi").addClass("pointer");
                        setHandlers(obj);
                });
        function allFormulas(){
                arrayList=$(".mi").get();
                var arrayHtml=[];
                $.each(arrayList,function(){
                        var f=1;
                        var s=processString($(this).html());
                        for(var j=0;j<arrayHtml.length;j++){
                                if (s==arrayHtml[j]){
                                        f=0;
                                }
                        }
                        if (f==1){
                                arrayHtml[arrayHtml.length]=s;
                        }
                        $(this).attr("name",s);
                });
                return arrayHtml;
        }
        function setHandlers(obj){
                console.log("start setting handlers");
                $(".mi").mouseover(function(){
                        var s=processString($(this).html());
                        $("[name="+s+"]").addClass("colorize");
                        //$("[dscr="+s+"]").addClass("bg_colorize");
                        $("#descriptioncolumn [name="+s+"]").closest(".descr-el").addClass("bg_colorize");
                });
                $(".mi").mouseout(function(){
                        var s=processString($(this).html());
                        $("[name="+s+"]").removeClass("colorize");
                        $("#descriptioncolumn [name="+s+"]").closest(".descr-el").removeClass("bg_colorize");
                });
        }
        function processString(str){
                var s="";
                if (str.indexOf("<")!=-1){
                        s = str.substring(0, str.indexOf('<'));
                }
                else{
                        s=str;
                }
                return s;
        }
});