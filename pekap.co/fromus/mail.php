<?php
	if (isset($_POST['email'])){
		$to = "videoroast@gmail.com"; 
		$from = "pekap@mit.edu"; 
		$subject = $_POST['email']; 
		$message= '';//content';
		$headers  = "From: $from\r\n"; 
		$headers .= "Content-type: text/html\r\n"; 
		$mailstr=mail($to, $subject, $message, $headers);
		//echo "Message has been sent to ".$cur_from."\n";
		$data = array(
			"message" => $mailstr,
		);
		echo json_encode($data);
		exit();
	}
	$data = array(
			"message" => "wrong",
		);
	echo json_encode($data);
	exit();
?>