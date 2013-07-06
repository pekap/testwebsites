<?php
	ini_set('max_execution_time', 300);
	include('simple_html_dom.php');
	$db = @mysql_connect("127.0.0.1","root","12345");
	if (!$db) 
	{
	  echo(' ');
	  exit();
	}

	if (!@mysql_select_db("petya", $db)) 
	{
	  echo(' ');
	  exit();
	}
	
	
	if (isset($_POST['new'])){
		
			
		//your settings
		$remixsid = "7d00450ba506017988d693eb987450559a92ef60ded60cc1c0ddaaaef2fb";
		
		$data="";
		//open connection
		$socket= fsockopen ("www.vk.com",80);
		
		if ($socket){
			//send request
			$headers=	"GET http://vk.com/id3083773 HTTP/1.0\r\n".
						"Host: vk.com\r\n".
						"Cookie: remixsid=$remixsid\r\n\r\n";
			fputs ($socket, $headers);
			
			//read answer
			while (!feof($socket)) {$data .= fgets ($socket,128);}
			fclose ($socket);
			
			//parse answer
			if(($headers_end=strrpos($data,"\r\n\r\n")) !== false){
				$data=substr($data, $headers_end+4);
				$data = mb_convert_encoding($data,"UTF-8","CP1251");
				$data = str_replace("charset=windows-1251", "charset=utf-8", $data);
				
				$result_data=$data;

				//
				$html = new simple_html_dom();
				$html->load($result_data);
				$text=1;
				$time=0;
				
				
				if($online_status = $html->find("#profile_online_lv")){
					foreach($online_status as $onl_s){
					if($ttt=$onl_s->style){
						$text=0;
					}
					}
				}
				if($online_mob = $html->find("#profile_mobile_online")){
					foreach($online_mob as $onl_m){
					if($ttt=$onl_m->class){
						$mob=$onl_m->class;
					}
					}
				}		
				if($online_time = $html->find("#profile_time_lv")){
					foreach($online_time as $onl_t){
					$time = $onl_t->plaintext;
					}
				}
				
				$data = array(
					"style" => $text,
					"time" => $time,//mb_convert_encoding($time, "UTF-8","CP1251"),
					"mob" => $mob
				);
				echo json_encode($data);
				sleep(1);
				exit();
				}
		}	
				

	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" src='jquery-1.7.2.min.js'></script>
	<script type="text/javascript" src='script.js'></script>	
</head>
<body>
<?php
/*
$file = file_get_contents('http://www.vk.com/pekap');
function file_get_contents_utf8($content) {
      return mb_convert_encoding($content, 'UTF-8');
      
      // ,mb_detect_encoding($content, 'UTF-8, windows-1251', true)
}

$file=file_get_contents_utf8($file);
echo $file;
*/
?>
<div id="main">
</div>
</body>
</html>