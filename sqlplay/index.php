<?php


	$db = @mysql_connect("127.0.0.1","root","12345");
	if (!$db) // ���� ���������� ����� 0 ���������� �� �����������
	{
	  echo("<P>� ��������� ������ ������ ���� ������ �� ��������, ������� 
			   ���������� ����������� �������� ����������.</P>");
	  exit();
	}

	if (!@mysql_select_db("test1", $db)) 
	{
	  echo( "<P>� ��������� ������ ���� ������ �� ��������, �������
				���������� ����������� �������� ����������.</P>" );
	  exit();
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>

    <body>
    
    
    <?php
    
    $option="sel";    
    if ($option=="ins")   
    {    
        $query="INSERT INTO
                    `tasks` (`name`,'cid')
                VALUES
                    ('wash',1),
                    ('eat',1),
                    ('sleep',2)";
        $result=@mysql_query($query);
        $query="INSERT INTO
                    `category` (`name`)
                VALUES
                    ('kitchen'),
                    ('bedroom')";
        $result=@mysql_query($query);
    
    }
        if ($option=="sel")   
    {    
        $query="SELECT * FROM
                    `tasks` JOIN `category`
                ON
                    `tasks`.`cid`=`category`.`cid`";
        $result=@mysql_query($query);
        while($data=@mysql_fetch_assoc($result))
        {
            $tid=intval($data['tid']);
            $cid=intval($data['cid']);
            $name=htmlspecialchars($data['name']);
            $cname=htmlspecialchars($data['cname']);
            echo "$tid $name $cid $cname<br>";
        }
    }
    ?>

    </body>
</html>
        
       <!--
	$query="SELECT `tid`, `name` FROM `todos` WHERE 1";
	if($result=@mysql_query($query))
	{
            while($data=@mysql_fetch_assoc($result))
	    {
		$name=htmlspecialchars($data['name']); // ����������� ����������� ������� 
                $id = intval($data['tid']); // ������� �����, ��� �� ��� �� ������
		//$categ = htmlspecialchars($data['category']);
            }
        }
        */
        -->