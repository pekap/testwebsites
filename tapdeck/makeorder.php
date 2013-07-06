<?php

	$db = @mysql_connect("p49143.mysql.ihc.ru","p49143_nfc","123456");
	if (!$db) // Если дескриптор равен 0 соединение не установлено
	{
	  echo("<P>В настоящий момент сервер базы данных не доступен, поэтому 
			   корректное отображение страницы невозможно.</P>");
	  exit();
	}

	if (!@mysql_select_db("p49143_nfc", $db)) 
	{
	  echo( "<P>В настоящий момент база данных не доступна, поэтому
				корректное отображение страницы невозможно.</P>" );
	  exit();
	}
        if(isset($_POST['name'])){
            $name = $_POST['name'];
            $name = trim($name);
            $db_name = @mysql_real_escape_string($name);
            if($name){
                if (@mysql_query("INSERT INTO `orders` SET `email`='$db_name'")){
                    $id=intval(mysql_insert_id());
                    $data=array(
                      "id" => $id,
                      "email" => $email           
                    );
                    echo json_encode($data);
                }
            }
        }
        exit();
?>

