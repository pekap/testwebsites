<?php

function cat_array(){
	$query0="SELECT `cid`, `cname` FROM `category` WHERE 1";
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

?>



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
	
	if((isset($_POST['cid']))&&(isset($_POST['tid'])))
	{	
	$cid = intval($_POST['cid']);
	$tid = intval($_POST['tid']);
		if($cid)
		{
		$res=@mysql_query("SELECT `cname` FROM `category` WHERE `category`.`cid`=$cid");
		$res2=@mysql_query("SELECT `cid`,`name` FROM `todos` WHERE `todos`.`tid`=$tid");
		
		$buff=@mysql_fetch_assoc($res2);
		$nbuff=intval($buff['cid']);
		$nname=$buff['name'];
		//echo "cid=".$cid."   "."last cid=".$nbuff;
		
		if ($cid==$nbuff){$cid=0;}
		else{$res1=@mysql_query("UPDATE `todos` SET `cid`=$cid WHERE `todos`.`tid`=$tid");}
		$buf=@mysql_fetch_assoc($res);
		$nbuf=$buf['cname'];
		$data = array(
			"n" => trim($nbuf),
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
				$query = "INSERT INTO `todos` SET `name`='$db_name',`cid`=$cid";
				if(@mysql_query($query)){
					$id=intval(mysql_insert_id());
					$dcname=@mysql_fetch_assoc(@mysql_query("SELECT `cname`,`cid` FROM `category` WHERE `category`.`cid`=$cid"));
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
		<script type="text/javascript" src='tabs.js'></script>
		<script type="text/javascript" src='menus.js'></script>
		<link rel="stylesheet" type="text/css" href="css/todo.css" />
		<link rel="stylesheet" type="text/css" href="css/button.css" />
		<link rel="stylesheet" type="text/css" href="css/leftmenu.css" />
		
    </head>

    <body>
	
	<div class="page-wrap">
		<div class="header">
			<h1>Enter tasks</h1>
		</div>
		
		<div class="left-menu">
		<a href='#' class='all' name='all'>ALL</a>
		
		<?php
		$cat_array = cat_array();
		foreach($cat_array as $data){
			$cid=$data['cid'];
			$cname=$data['cname'];
			echo "<a href='#' name='#names$cid'>$cname</a>
			";
		}
		?>
		
		</div>
		
		<div class="enter-field">
				<div>
					<input id="name_field" type="text" name="name" size=50/>
				</div>
				<div>
					<a id="submit1" class="button">+</a>
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
					$query="SELECT `tid`, `name` FROM `todos` WHERE 1";
					$query="SELECT * FROM
						  `todos` JOIN `category`
						ON
						  `todos`.`cid`=`category`.`cid`";
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
									<tr>
										<td class='left'><a id='name_del_$tid' class='button delete'>-</a></td>
										<td class='name-text'>$name</td>
									</tr>
								</table>
								<div class='properties'>
									<div class='el-cat'>
										<a name='$cid' id='categ_top_$tid' class='categ closed'>$cname</a>
										<div class='menus' id='menu_$tid'>
											<table>";
							foreach ($cat_array as $i => $val){
								$s=$val['cname'];
								echo "<tr>
									<td>
										<a name='$tid' id='cat_menu_$i'>$s</a>
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
		</div>
		
		
	</div>	
	</body>
</html>