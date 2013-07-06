<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
            /*body here is the size of screen*/
            body{
                margin:100px auto;
                border: 3px solid #E1E1E1;
                width: 640px;
                height: 960px;
                color: #333;
                box-shadow: inset rgba(0, 0, 0, .5)  0 0px 20px;
                z-index:2;
                border: 3px solid #888;
            }

            #block-container{
                display: table;
                margin:0 auto;
                padding-top:0;
                padding-bottom:10%;
            }
            #button{
                background: #E1E1E1;
                height: 300px;
                line-height: 300px;
                width: 300px;
                text-align: center;
                vertical-align: middle;
                font-size: 330px;
                display: table;
                margin: 0 auto;
                margin-bottom: 10%;
                margin-top:10%;
                background: -webkit-gradient(linear, left top, left bottom, color-stop(50%, rgba(249, 249, 249, 1)), color-stop(100%, rgba(240, 240, 240, 1)));
                background: -moz-linear-gradient(top, rgba(250, 250, 250, 1) 50%, rgba(245, 245, 245, 1) 100%);
                background: -ms-linear-gradient(linear, left top, left bottom, color-stop(50%, rgba(249, 249, 249, 1)), color-stop(100%, rgba(240, 240, 240, 1)));
                background: -o-linear-gradient(linear, left top, left bottom, color-stop(50%, rgba(249, 249, 249, 1)), color-stop(100%, rgba(240, 240, 240, 1)));
                background: -linear-gradient(linear, left top, left bottom, color-stop(50%, rgba(249, 249, 249, 1)), color-stop(100%, rgba(240, 240, 240, 1)));
                border-radius: 20px;
                border: 3px solid #888;
                box-shadow: rgba(0, 0, 0, .5) 0 1px 10px;
            }
            #picture{
                display: block;
                
            }
            #picture img{
                border: 3px solid #888;
                box-shadow: rgba(0, 0, 0, .5) 0 1px 10px;
            }
            #counter-line{
                padding-bottom: 10%;
            }
            #counter{
                z-index: 1;
                width: 100px;
                text-align: center;
                font-size: 100px;
                line-height: 100px;
                height: 100px;
                display: table;
                margin: 0 auto;
                border: 3px solid #888;
                border-top: 0px solid white;
                box-shadow: rgba(0, 0, 0, .5) 0 1px 10px;
                background: -webkit-gradient(linear, left top, left bottom, color-stop(50%, rgba(249, 249, 249, 1)), color-stop(100%, rgba(240, 240, 240, 1)));
                background: -moz-linear-gradient(top, rgba(250,250,250,1) 50%, rgba(245,245,245,1) 100%);
                background: -ms-linear-gradient(linear, left top, left bottom, color-stop(50%, rgba(249, 249, 249, 1)), color-stop(100%, rgba(240, 240, 240, 1)));
                background: -o-linear-gradient(linear, left top, left bottom, color-stop(50%, rgba(249, 249, 249, 1)), color-stop(100%, rgba(240, 240, 240, 1)));
                background: -linear-gradient(linear, left top, left bottom, color-stop(50%, rgba(249, 249, 249, 1)), color-stop(100%, rgba(240, 240, 240, 1)));
                padding-bottom: 5px;
                padding-left: 10px;
                padding-right: 10px;
                border-bottom-left-radius: 20px;
                border-bottom-right-radius: 20px;
            }
        </style>
    </head>
    
    <body>
        
        <div id="cent">
            <div id="counter-line">
                <div id="counter">
                    10
                </div>
            </div>
            <div id="block-container">        
                <div id="button">+</div>
                <div id="picture">
                    <img height=298 src="pic.png">
                </div>
            </div>
        </div>
        
    </body>
    
</html>