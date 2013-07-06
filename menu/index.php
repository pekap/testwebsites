<?php

	$arr = array(
		1 => "first",
		2 => "second",
		3 => "third",
		4 => "fourth"
	);

if(isset($_POST['num']))
	{
		
	$name = $_POST['num'];
	$num=intval($name);
		if($name)
		{
		$data = array(
			"n" => trim($arr[$num]),
		);
		echo json_encode($data);
		exit();
		}
	}
	
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script type="text/javascript" src='jquery-1.7.2.min.js'></script>
		<script type="text/javascript" src='script1.js'></script>
		<link rel="stylesheet" type="text/css" href="menu.css" />
		
    </head>

    <body>
	
	<div class="page-wrap">
		<div class="header">
			<h1 style="font-size:10pt" >Menu example</h1>
		</div>
		<?php
		echo 

		?>
		<div class="content">
			
			<div id="el-cat">
			<?php
			echo "<a id='top'>$arr[1]</a>";
			echo "<div id='menu'>";
			echo "<table class='menus'>";			
			foreach ($arr as $i => $value){
				echo "<tr>
					<td>
					   <a id='$i'>$value</a>
					</td>
				      </tr>";
			};
			echo "</table>";
			?>
			</div>
			</div>
			
			<div>
				here go text text text text <br> text text text text
			</div>
		</div>
		
		
	</div>	
	</body>
</html>