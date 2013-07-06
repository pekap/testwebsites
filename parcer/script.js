$(document).ready(function(){
    
    a=1;
    flag1=1;
    flag2=1;
    mf1=1;
    mf2=1;
    zx=0;
    var fun=function(){
        try{loader.abort()}catch(e){};
        loader=$.ajax({
            type:'POST',
            url:'index.php',
            async:false,
            data: {new:"abba"},
            success: function(data){
                    flag2=flag1;
                    mf2=mf1;
                    zx=zx+1;
                    console.log('1='+flag1+' 2='+flag2+' zx='+zx);
                    smob=data.mob;
                    var dday= new Date();
                    var dd={
                        hrs: dday.getHours(),
                        min: dday.getMinutes(),
                        day: dday.getDay()
                    };
                    var s='Сейчас '+dd.hrs+':'+dd.min+' ';
                    if(data.style==1)
                    {
                        if (smob.length>23){
                            s=s+'Online '+'с компа ';
                            mf1=1;
                        }
                        else
                        {
                            s=s+'Online '+'с мобилки ';
                            mf1=0;
                        }
                        flag1=1;
                    }
                    else
                    {
                        s=s+'Последний раз ';
                        s=s+data.time;
                        flag1=0;
                    }
                    if ((flag1!=flag2)||(zx==1)||(mf1!=mf2)){
                        $("#main").append(s+"<br>");
                    }
                    setTimeout(fun,60000);
                    },
            dataType: 'JSON',
        });
    }
    fun();
});