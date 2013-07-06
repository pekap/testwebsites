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

function todo_array(){
	$query0="SELECT `tid`, `name` FROM `todos` WHERE 1";
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


	$db = @mysql_connect("pekap.db.10783474.hostedresource.com","pekap","Invictus140!");
	if (!$db) // Если дескриптор равен 0 соединение не установлено
	{
	  echo("<P>В настоящий момент сервер базы данных не доступен, поэтому 
			   корректное отображение страницы невозможно.</P>");
	  exit();
	}
//echo "HUINA";
//exit();
	if (!@mysql_select_db("pekap", $db)) 
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
		if ($option=='ref' and isset($_POST['val']))
		{
			$id = $_POST['id'];
			$id = intval($id);
			$val = $_POST['val'];
			$val = intval($val);
			
			if($id)
			{
				$query = "UPDATE `todos` SET `state`=$val WHERE `todos`.`tid`=$id";
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
		if ($res=@mysql_query("DELETE FROM `category` WHERE `cid`=$cid")){
			echo "success in deleting";
		}
		if ($res=@mysql_query("UPDATE `todos` SET `cid`=1 WHERE `todos`.`cid`=$cid")){
			echo "success in uploading";
		}
		
		exit();
	}
?>

<?php 
    if (isset($_POST['cname']))
    {
	$cname=htmlspecialchars($_POST['cname']);
	$res1=@mysql_query("INSERT INTO `category` SET `cname`='$cname'");
	$cid=intval(mysql_insert_id());
	$data = array(
		"cname" => $cname,
		"cid" => $cid,
		"todo_array" => todo_array()
	);
	echo json_encode($data);
	exit();
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
		<script type="text/javascript" src='jquery_jeditable.js'></script>
		
		<link rel="icon" type="image/png" href="images/myicon.png">
		<link rel="stylesheet" type="text/css" href="css/todo.css" />
		<link rel="stylesheet" type="text/css" href="css/button.css" />
		<link rel="stylesheet" type="text/css" href="css/leftmenu.css" />
		
    </head>

    <body>
	
	<div class="page-wrap">
		<div class="header">
			It is "NiceTODO" project
		</div>
		
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
					<input id="name_field" type="text" name="name" size=50/>
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
						  `todos`.`cid`=`category`.`cid`
						WHERE `todos`.`state`=1";
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
					WHERE `todos`.`state`=0";
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