<?php


	$db = @mysql_connect("127.0.0.1","root","12345");
	if (!$db) // Если дескриптор равен 0 соединение не установлено
	{
	  echo("<P>В настоящий момент сервер базы данных не доступен, поэтому 
			   корректное отображение страницы невозможно.</P>");
	  exit();
	}
//echo "HUINA";
//exit();
	if (!@mysql_select_db("petya", $db)) 
	{
	  echo( "<P>В настоящий момент база данных не доступна, поэтому
				корректное отображение страницы невозможно.</P>" );
	  exit();
	}

	
	if(isset($_POST['option']))
	{
		$option = $_POST['option'];
		$option = trim($option);
		$option = @mysql_real_escape_string($option);
		
		
		
		if ($option=='add' and isset($_POST['name']))
		{
			$name = $_POST['name'];
			$name = trim($name);
			$db_name = @mysql_real_escape_string($name);
			
			if($name)
			{
				$query = "INSERT INTO `todos` SET `name`='$db_name'";
				if(@mysql_query($query)){
					$id=intval(mysql_insert_id());
					
					$data = array(
						"id" => $id,
						"name" => htmlspecialchars($name)
					);
					echo json_encode($data);
				}
			}
			
			//header("Location:index.php");
			exit();
		}
		if ($option=='del' and isset($_POST['id']))
		{
			$id = $_POST['id'];
			$id = intval($id);
			
			if($id)
			{
				$query = "DELETE FROM `todos` WHERE `tid`=$id";
				//echo $query;
				if(@mysql_query($query)) echo "success";
			}
			
			//header("Location:index.php");
			exit();
		}
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src='jquery-1.7.2.min.js'></script>
		<script type="text/javascript" src='script.js'></script>
		<link rel="stylesheet" type="text/css" href="css/todo.css" />
		
    </head>

    <body>
	
	<div class="page-wrap">
		<div class="header">
			<h1>Enter tasks</h1>
		</div>
		
		<div class="left-menu">
			<a class="menu-item">Левое меню1</a>
			<a class="menu-item">Левое меню2</a>
			<a class="menu-item">Левое меню3</a>
		</div>
		
		<div class="content">
			<div class="enter-field">
				<div>
					<input id="name_field" type="text" name="name" size=50/>
				</div>
				<div>
					<a id="submit1" class="button">+</a>
				</div>
			</div>
			<div id="names" class="names">
				<?php
					$query="SELECT `tid`, `name` FROM `todos` WHERE 1";
					if($result=@mysql_query($query))
					{
						while($data=@mysql_fetch_assoc($result))
						{
							$name=htmlspecialchars($data['name']); // преобразуем специальные символы 
							$id = intval($data['tid']); // кастуем число, что бы там ни стояло
							
							echo "	<div id='name_$id' class='todo-entry'>
									<table>
										<tr>
											<td class='left'><a id='name_del_$id' class='button delete'>-</a></td>
											<td class='name-text'>$name</td>
										</tr>
									</table>
								</div>";
						}
					}
				?>
			</div>
		</div>
		
		
	</div>	
	</body>
</html>