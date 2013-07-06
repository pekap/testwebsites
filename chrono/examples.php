<?php
	
	
	if((isset($_POST['cid']))&&(isset($_POST['tid'])))
		$res=@mysql_query("SELECT `cname` FROM `category` WHERE `category`.`cid`=$cid");
		else{$res1=@mysql_query("UPDATE `todos` SET `cid`=$cid WHERE `todos`.`tid`=$tid");}
		$buf=@mysql_fetch_assoc($res);
		$data = array(
			"n" => trim($nbuf),
			"id" => $tid,
			"cid" => $cid,
			"cat_array" => cat_array(),
			"name" => $nname
		);
		echo json_encode($data);
		exit();
		$option = trim($option);
		$option = @mysql_real_escape_string($option);
		$query="SELECT * FROM
						  `todos` JOIN `category`
						ON
						  `todos`.`cid`=`category`.`cid`
						WHERE `todos`.`state`=1";
	
	
				$query = "DELETE FROM `todos` WHERE `tid`=$id";
	?>
