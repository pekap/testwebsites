
<?php
	//******************Соединение с базой данных**********************************
	$db_adress="127.0.0.1";
	$db_username="root";
	$db_password="12345";
	$db_name="chrono";
	
	$db = @mysql_connect($db_adress,$db_username,$db_password);
	if (!$db) // Если дескриптор равен 0 соединение не установлено
	{
	  echo("<P>В настоящий момент сервер базы данных не доступен, поэтому 
			   корректное отображение страницы невозможно.</P>");
	  exit();
	}
	if (!@mysql_select_db($db_name, $db)) 
	{
	  echo( "<P>В настоящий момент база данных не доступна, поэтому
				корректное отображение страницы невозможно.</P>" );
	  exit();
	}
?>

<?php
	//*********************Geting entries**************************************
	if (isset($_POST['get'])){
		if ($_POST['get']=="entries"){
			$result=@mysql_query("SELECT * FROM `entries`");
			$i=0;
			while($data=@mysql_fetch_assoc($result)){
				$i++;
				$out_array[$i]['id']=intval($data['id']);
				$out_array[$i]['start_time']=$data['start_time'];
				$out_array[$i]['end_time']=$data['end_time'];
				$out_array[$i]['entry_content']=htmlspecialchars($data['entry_content']);
			}
			$outdata=array(
				"entries_array"=>$out_array,
				"entries_number"=>$i
			);
			echo json_encode($outdata);
			exit();
		}
	}
?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src='jquery-1.7.2.min.js'></script>
		<script type="text/javascript" src='main_script.js'></script>
		
		<link rel="icon" type="image/png" href="images/myicon.png">
		<link rel="stylesheet" type="text/css" href="css/chrono.css" />	
    </head>
    <body>				
    </body>
</html>