<?php 

//your settings
$remixsid = "7d00450ba506017988d693eb987450559a92ef60ded60cc1c0ddaaaef2fb";

$data="";
//open connection
$socket= fsockopen ("www.vk.com",80);

if ($socket){
	//send request
	$headers=	"GET http://vk.com/pekap HTTP/1.0\r\n".
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
		
		echo $data;
		
		//
		//here you can do whatever you want
		//
	}
}

?>