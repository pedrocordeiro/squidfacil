<?php
//if ($_POST["type"] == "webhook-verification-code") :
//	$fp = fopen('webhook-verification-code.json', 'w');
//	fwrite($fp, json_encode($_POST));
//	fclose($fp);
//endif;

$date = date('m-d-Y-His');
file_put_contents('webhook-call-'. $date . '.json', 
		file_get_contents('php://input'));
?>
