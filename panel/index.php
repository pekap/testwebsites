<?php

define('INCLUDE_CHECK',true);

require 'connect.php';
require 'functions.php';
// Данные два файла нужно включать только в случае определения INCLUDE_CHECK


session_name('tzLogin');
// Запуск сессии

session_set_cookie_params(2*7*24*60*60);
// Устанавливаем время жизни куки 2 недели

session_start();

$uid=$_SESSION['id'];

function inbox_id(){
	$uid=$_SESSION['id'];
	$data=@mysql_fetch_assoc(@mysql_query("SELECT `ft` FROM `users` WHERE `users`.`id`=$uid"));
	return $data['ft'];
}
if (isset($_POST['inboxid'])){
	$in_id=inbox_id();
	$data=array(
		"in_id" => $in_id
	);
	echo json_encode($data);
	exit();
}

if($_SESSION['id'] && !isset($_COOKIE['tzRemember']) && !$_SESSION['rememberMe'])
{
	// Если вы вошли в систему, но куки tzRemember (рестарт браузера) отсутствует
	// и вы не отметили чекбокс 'Запомнить меня':

	$_SESSION = array();
	session_destroy();
	
	// Удалаяем сессию
}


if(isset($_GET['logoff']))
{
	$_SESSION = array();
	session_destroy();
	
	header("Location: index.php");
	exit;
}

if($_POST['submit']=='Войти')
{
	// Проверяем, что представлена форма Войти
	
	$err = array();
	// Запоминаем ошибки
	
	
	if(!$_POST['username'] || !$_POST['password'])
		$err[] = 'Все поля должны быть заполнены!';
	
	if(!count($err))
	{
		$_POST['username'] = mysql_real_escape_string($_POST['username']);
		$_POST['password'] = mysql_real_escape_string($_POST['password']);
		$_POST['rememberMe'] = (int)$_POST['rememberMe'];
		
		// Получаем все ввденые данные

		$row = mysql_fetch_assoc(mysql_query("SELECT `id`,`usr`,`ft` FROM `users` WHERE `usr`='{$_POST['username']}' AND `pass`='{$_POST['password']}'"));

		if($row['usr'])
		{
			// Если все в порядке - входим в систему
			
			$_SESSION['usr']=$row['usr'];
			$_SESSION['id'] = $row['id'];
			$uid=$row['id'];
			$_SESSION['rememberMe'] = $_POST['rememberMe'];
			if ($row['ft']=="0"){
				@mysql_query("INSERT INTO `category` SET `cname`='Inbox', `uid`=$uid");
				$data=@mysql_fetch_assoc(@mysql_query("SELECT `cid` FROM `category` WHERE `category`.`uid`=$uid"));
				$in_id=$data['cid'];
				@mysql_query("UPDATE `users` SET `ft`=$in_id WHERE `id`=$uid");
				
			}
			// Сохраняем некоторые данные сессии
			
			setcookie('tzRemember',$_POST['rememberMe']);
		}
		else{
			$err[]="Ошибочный пароль или/и имя пользователя!.{$_POST['username']}.{$_POST['password']}";
		}
	}
	
	if($err)
	$_SESSION['msg']['login-err'] = implode('<br />',$err);
	// Сохраняем сообщение об ошибке сессии

	header("Location: index.php");
	exit;
}
else if($_POST['submit']=='Зарегистрироваться')
{
	// Проверяем, что представлена форма Зарегистрироваться
	
	$err = array();
	
	if(strlen($_POST['email'])<4 || strlen($_POST['email'])>32)
	{
		$err[]='Пароль должен быть больше 3 символов';
	}
	
	if(preg_match('/[^a-z0-9\-\_\.]+/i',$_POST['email']))
	{
		$err[]='Ваш пароль сожержит недопустимые символы!';
	}
	
	if(!checkEmail($_POST['username']))
	{
		$err[]='Email не правильный!';
	}
	
	if(!count($err))
	{
		// Если нет ошибок
		
		$pass = mysql_real_escape_string($_POST['email']);
		// Генерируем случайный пароль
		$_POST['username'] = mysql_real_escape_string($_POST['username']);
		// Получаем введеные данные
		
		
		mysql_query("	INSERT INTO users(usr,pass,regIP,dt,ft)
						VALUES(
							'".$_POST['username']."',
							'".$pass."',
							'".$_SERVER['REMOTE_ADDR']."',
							NOW(),
							'0'
						)");
		//@mysql_query($query);
		
		if(mysql_affected_rows()==1)
		{/*
			send_mail(	'petr@pekap.com',
						$_POST['username'],
						'Регистрация в системe прошла успешно',
						'Ваш пароль: '.$pass);*/

			$_SESSION['msg']['reg-success']='Спасибо за регистрацию!';
		}
		else $err[]='Данное имя пользователя уже занято!';
	}

	if(count($err))
	{
		$_SESSION['msg']['reg-err'] = implode('<br />',$err);
	}	
	
	header("Location: index.php");
	exit;
}

$script = '';

if($_SESSION['msg'])
{
	// Скрипт ниже показывает выскаьзывающую панель
	
	$script = '
	<script type="text/javascript">
	
		$(function(){
		
			$("div#panel").show();
			$("#toggle a").toggle();
		});
	
	</script>';
	
}
?>

<?php

function cat_array(){
	$uid=$_SESSION['id'];
	$query0="SELECT `cid`, `cname` FROM `category` WHERE `category`.`uid`=$uid";
	$result0=@mysql_query($query0);
	if($result0=@mysql_query($query0)){
		$i=0;
		while($data0=@mysql_fetch_assoc($result0)){
			$i++;
			$out_array[$i]['cid']=intval($data0['cid']);
			$out_array[$i]['cname']=htmlspecialchars($data0['cname']);
		}
	}
	return $out_array;
}

function todo_array(){
	$uid=$_SESSION['id'];
	$query0="SELECT `tid`, `name` FROM `todos` WHERE `todos`.`uid`=$uid";
	$result0=@mysql_query($query0);
	if($result0=@mysql_query($query0)){
		$i=0;
		while($data0=@mysql_fetch_assoc($result0)){
			$i++;
			$out_array[$i]['tid']=intval($data0['tid']);
			$out_array[$i]['name']=htmlspecialchars($data0['name']);
		}
	}
	return $out_array;
}

?>



<?php

/*
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
*/

	if((isset($_POST['cid']))&&(isset($_POST['tid'])))
	{	
	$cid = intval($_POST['cid']);
	$tid = intval($_POST['tid']);
		if($cid)
		{
		$res=@mysql_query("SELECT `cname` FROM `category` WHERE `category`.`cid`=$cid AND `category`.`uid`=$uid");
		$res2=@mysql_query("SELECT `cid`,`name` FROM `todos` WHERE `todos`.`tid`=$tid AND `todos`.`uid`=$uid");
		
		$buff=@mysql_fetch_assoc($res2);
		$nbuff=intval($buff['cid']);
		$nname=$buff['name'];
		//echo "cid=".$cid."   "."last cid=".$nbuff;
		
		if ($cid==$nbuff){$cid=0;}
		else{$res1=@mysql_query("UPDATE `todos` SET `cid`=$cid WHERE `todos`.`tid`=$tid AND `todos`.`uid`=$uid");}
		$buf=@mysql_fetch_assoc($res);
		$nbuf=$buf['cname'];
		$data = array(
			"n" => trim($nbuf),
			"id" => $tid,
			"cid" => $cid,
			"cat_array" => cat_array(),
			"name" => $nname
		);
		echo json_encode($data);
		exit();
		}
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
			
			$cid = $_POST['cid'];
			$cid = trim($cid);
			$cid = intval($cid);
			
			
			if($name)
			{
				$query = "INSERT INTO `todos` SET `name`='$db_name',`cid`=$cid,`uid`=$uid";
				if(@mysql_query($query)){
					$id=intval(mysql_insert_id());
					$dcname=@mysql_fetch_assoc(@mysql_query("SELECT `cname`,`cid` FROM `category` WHERE `category`.`cid`=$cid AND `category`.`uid`=$uid"));
					$cname=$dcname['cname'];
					$cid=$dcname['cid'];
					
					$data = array(
						"id" => $id,
						"name" => htmlspecialchars($name),
						"cname" => $cname,
						"cat_array" => cat_array(),
						"cid" => $cid
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
				$query = "DELETE FROM `todos` WHERE `tid`=$id AND `todos`.`uid`=$uid";
				//echo $query;
				if(@mysql_query($query)) echo "success";
			}
			
			//header("Location:index.php");
			exit();
		}
		if ($option=='ref' and isset($_POST['val']))
		{
			$id = $_POST['id'];
			$id = intval($id);
			$val = $_POST['val'];
			$val = intval($val);
			
			if($id)
			{
				$query = "UPDATE `todos` SET `state`=$val WHERE `todos`.`tid`=$id AND `todos`.`uid`=$uid";
				//echo $query;
				if(@mysql_query($query)) echo "success";
			}
			
			//header("Location:index.php");
			exit();
		}
	}
?>

<?php
	if (isset($_POST['del_cid'])){
		$cid=intval($_POST['del_cid']);
		if ($res=@mysql_query("DELETE FROM `category` WHERE `cid`=$cid AND `category`.`uid`=$uid")){
			echo "success in deleting";
		}
		if ($res=@mysql_query("UPDATE `todos` SET `cid`=1 WHERE `todos`.`cid`=$cid AND `todos`.`uid`=$uid")){
			echo "success in uploading";
		}
		
		exit();
	}
?>

<?php 
    if (isset($_POST['cname']))
    {
	$cname=htmlspecialchars($_POST['cname']);
	$res1=@mysql_query("INSERT INTO `category` SET `cname`='$cname',`uid`=$uid");
	$cid=intval(mysql_insert_id());
	if (todo_array()) {
		$data = array(
			"cname" => $cname,
			"cid" => $cid,
			"todo_array" => todo_array(),
			"okay" => 1
		);}
	else{
		$data = array(
			"cname" => $cname,
			"cid" => $cid,
			"okay" => 0
		);
	}
	echo json_encode($data);
	exit();
    }
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Система регистрации с использованием PHP MySQL и jQuery | Демо ruseller.com</title>
    
    <link rel="stylesheet" type="text/css" href="login_panel/css/slide.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/todo.css" />
	<link rel="stylesheet" type="text/css" href="css/button.css" />
	<link rel="stylesheet" type="text/css" href="css/leftmenu.css" />
 
    <script type="text/javascript" src='jquery-1.7.2.min.js'></script>
    <script type="text/javascript" src='jquery_jeditable.js'></script>    
	<script type="text/javascript" src='script.js'></script>
	<script type="text/javascript" src='tabs.js'></script>
	<script type="text/javascript" src='menus.js'></script>	
<!--	<script type="text/javascript" src="panelscript.js"></script>
-->

    <?php echo $script; ?>
</head>

<body>

<!-- Панель -->
<div id="toppanel">
	<div id="panel">
		<div class="pcontent clearfix">
			<div class="panelleft">
				<h1>NiceTODO project</h1>
				<h2>регистрация/вход</h2>
				<p>Для ознакомления можно использовать пользователя <strong>user@pekap.com</strong> с паролем <strong>user</strong></p>	
			</div>
            <?php
			
			if(!$_SESSION['id']):
			
			?>
            
			<div class="panelleft">
				<!-- Форма входа -->
				<form class="clearfix" action="" method="post">
					<h1>Пожалуйста представься!</h1>
                    
                    <?php
						
						if($_SESSION['msg']['login-err'])
						{
							echo '<div class="err">'.$_SESSION['msg']['login-err'].'</div>';
							unset($_SESSION['msg']['login-err']);
						}
					?>
					
					<label class="grey" for="username">Email:</label>
					<input class="pfield" type="text" name="username" id="username" value="" size="23" />
					<label class="grey" for="password">Password:</label>
					<input class="pfield" type="password" name="password" id="password" size="23" />
	            	<label><input name="rememberMe" id="rememberMe" type="checkbox" checked="checked" value="1" /> &nbsp;Remember me</label>
        			<div class="clear"></div>
					<input type="submit" name="submit" value="Войти" class="bt_login" />
				</form>
			</div>
			<div class="panelleft right">			
				<!-- Форма регистрации -->
				<form action="" method="post">
					<h1>Еще не зарегистрирован? Вводи данные!</h1>		
                    
                    <?php
						
						if($_SESSION['msg']['reg-err'])
						{
							echo '<div class="err">'.$_SESSION['msg']['reg-err'].'</div>';
							unset($_SESSION['msg']['reg-err']);
						}
						
						if($_SESSION['msg']['reg-success'])
						{
							echo '<div class="success">'.$_SESSION['msg']['reg-success'].'</div>';
							unset($_SESSION['msg']['reg-success']);
						}
					?>
                    		
					<label class="grey" for="username">Email:</label>
					<input class="pfield" type="text" name="username" id="username" value="" size="23" />
					<label class="grey" for="email">Password:</label>
					<input class="pfield" type="text" name="email" id="email" size="23" />
					<input type="submit" name="submit" value="Зарегистрироваться" class="bt_register" />
				</form>
			</div>
            
            <?php
			
			else:
			
			?>
            
            <div class="left">
            <a href="?logoff">Выйти из системы</a>
            
            </div>
            
            <div class="left right">
            </div>
            
            <?php
			endif;
			?>
		</div>
	</div> 

    <!-- Закладка наверху -->	
	<div class="tab">
		<ul class="login">
	    	<li class="panelleft">&nbsp;</li>
	        <li>Привет, <?php echo $_SESSION['usr'] ? $_SESSION['usr'] : 'Гость';?>!</li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#"><?php echo $_SESSION['id']?'Открыть панель':'Вход | Регистрация';?></a>
				<a id="close" style="display: none;" class="close" href="#">Закрыть панель</a>			
			</li>
	    	<li class="right">&nbsp;</li>
		</ul> 
	</div> 
	
</div>
<?php if (!$_SESSION['id'])
	{echo "
	<div class='page-wrap' style='margin-top: 300px'>
		Привет, сейчас ты находишься в одном шаге от регистрации в очередной тудушке, коих пруд пруди. От других
		эта выгодно отличается суперминималистичным дизайном и только необходимыми опциями. Например я никогда не мог
		понять разницу между выполненным заданием и удаленным заданием - ' так зачем платить больше? ' :) Надеюсь тебе понравится
	</div>
	</body> </html>"; exit();}?>
	
	<div class="page-wrap">
		<!--<div class="header">
			It is "NiceTODO" project
		</div>-->
		
		<div id="leftp"> 
			<div class="left-menu">
				<div class="temp_menu"><a href='#' class='all' name='all'>ALL</a></div>
				<div name='deleted_todos' class='temp_menu'>
					<a href='#' name='#deleted_todos'>Deleted</a>
				</div>
				<?php
				$cat_array = cat_array();
				foreach($cat_array as $data){
					$cid=$data['cid'];
					$cname=$data['cname'];
					echo "	<div name='$cid' class='temp_menu'>
						<a href='#' name='#names$cid'>$cname</a>
						<div id='r_b_$cid' name='$cid' class='cat_remove_button'>-</div></div>";
				}
				?>
				
				<!--<div>
					<a id="category-submit" class="button">+</a>
				</div> -->
			</div>
			
			<div class="cat_enter_field">
				<div class="field">
					<input id="category_field" type="text" name="name" size=15 maxlength=12/>
				</div>
				<div class="fbut">
					<a>Add category</a>
				</div>
			</div>

		</div>	
		
		<div class="enter-field">
				<div id="enter-field-submit" autocomplete="off">
					<a id="submit1" class="button">+</a>
				</div>
				<div>
					<input id="name_field" type="text" name="name" size=50 />
				</div>

		</div>
		<div class="content">
			
			<?php
			$cat_array = cat_array();
			foreach($cat_array as $data0){	
			$cid=$data0['cid'];
			$cname=$data0['cname'];
			$tcid=$cid;
			echo "<div id='names$cid' class='names'>";
					$query="SELECT `tid`, `name` FROM `todos` WHERE ";
					$query="SELECT * FROM
						  `todos` JOIN `category`
						ON
						  `todos`.`cid`=`category`.`cid`
						WHERE `todos`.`state`=1
						AND `todos`.`uid`=$uid";
					$result=@mysql_query($query);
					if($result=@mysql_query($query))
					{
						while($data=@mysql_fetch_assoc($result))
						{
							$tid=intval($data['tid']);
							$cid=intval($data['cid']);
							if ($cid==$tcid)//or $tcid==1
							{
							$name=htmlspecialchars($data['name']);
							$cname=htmlspecialchars($data['cname']);
							echo "	<div id='name_$tid' class='todo-entry'>
								<table class='thentr'>
									<tr name='thentr_$tid'>
										<td class='left'><a id='name_del_$tid' class='button delete'>-</a></td>
										<td class='name-text'><div id='text_$tid'>$name</div></td>
									</tr>
								</table>
								<div class='properties'>
									<div class='el-cat'>
										<a name='$cid' id='categ_top_$tid' class='categ closed'>$cname</a>
										<div class='menus' id='menu_$tid'>
											<table class='m_table'>";
							foreach ($cat_array as $i => $val){
								$s=$val['cname'];
								$cid=$val['cid'];
								echo "<tr name='$cid'>
									<td>
										<a name='$tid' class='cat_menu_$cid'>$s</a>
									</td>
								      </tr>";
							}
							
									echo	"</table> </div>
								        </div>
								</div>
							</div>";
							}
						}
					}
			echo "</div>";
			}
			?>
			
			<div id='deleted_todos' class='names'>
			<?php
				$query="SELECT * FROM
					  `todos` JOIN `category`
					ON
					  `todos`.`cid`=`category`.`cid`
					WHERE `todos`.`state`=0
					AND `todos`.`uid`=$uid";
				$result=@mysql_query($query);
				if($result=@mysql_query($query))
				{
					while($data=@mysql_fetch_assoc($result))
					{
						$tid=intval($data['tid']);
						$cid=intval($data['cid']);
						if (1==1)//or $tcid==1
						{
						$name=htmlspecialchars($data['name']);
						$cname=htmlspecialchars($data['cname']);
						echo "	<div id='name_$tid' class='todo-entry'>
							<table class='thentr'>
								<tr name='thentr_$tid'>
									<td class='left'>
										<a id='name_ref_$tid' class='button refresh'>↑</a>
										<a id='name_del_$tid' class='button delete removed'>-</a></td>
									<td class='name-text'><div id='text_$tid'>$name</div></td>
								</tr>
							</table>
							<div class='properties'>
								<div class='el-cat'>
									<a name='$cid' id='categ_top_$tid' class='categ closed'>$cname</a>
									<div class='menus' id='menu_$tid'>
										<table class='m_table'>";
						foreach ($cat_array as $i => $val){
							$s=$val['cname'];
							$cid=$val['cid'];
							echo "<tr name='$cid'>
								<td>
									<a name='$tid' class='cat_menu_$cid'>$s</a>
								</td>
							      </tr>";
						}
						
								echo	"</table> </div>
								</div>
							</div>
						</div>";
						}
					}
				}
			?>
			</div>
		</div>
		
		
	</div>

</body>
</html>
