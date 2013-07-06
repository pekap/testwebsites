<?php


	$db = @mysql_connect("127.0.0.1","root","12345");
	if (!$db) // Если дескриптор равен 0 соединение не установлено
	{
	  echo("<P>В настоящий момент сервер базы данных не доступен, поэтому 
			   корректное отображение страницы невозможно.</P>");
	  exit();
	}

	if (!@mysql_select_db("petya", $db)) 
	{
	  echo( "<P>В настоящий момент база данных не доступна, поэтому
				корректное отображение страницы невозможно.</P>" );
	  exit();
	}
?>



<?php 
    if (isset($_POST['value']))
    {
    $note = htmlspecialchars($_POST['value']);
    $id = htmlspecialchars($_POST['id']);
    $nid=intval(substr($id, strrpos($id, '_')+1));
    $res1=@mysql_query("UPDATE `todos` SET `name`='$note' WHERE `todos`.`tid`=$nid");    
    echo $note; 
    }
?>