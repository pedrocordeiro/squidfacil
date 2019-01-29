<?php
//if ($_POST["type"] == "webhook-verification-code") :
//	$fp = fopen('webhook-verification-code.json', 'w');
//	fwrite($fp, json_encode($_POST));
//	fclose($fp);
//endif;

/*
@TODO implementar a verificação abxo:

Saiba como verificar a autenticidade de uma mensagem recebida.

A requisição do webhook que vem da Squid Fácil possui um campo no cabeçalho (HEADER) X-Squid-Signature que contém um json web token (JWT) https://jwt.io/ assinado pelo client_secret da sua loja.

O algoritmo utilizado é HS256.
*/

$date = date('m-d-Y-His');
$input = json_decode(file_get_contents('php://input'));

if (isset($input->type)) :
	file_put_contents('webhook-' . $input->type  . '-' . $date . '.json', 
		file_get_contents('php://input'));

	echo 'File saved: webhook-' . $input->type  . '-' . $date . '.json';
else :
	if ($_SERVER['REQUEST_METHOD'] === 'POST') :
		file_put_contents('unknown-call-POST-' . $date . '.txt', 
			print_r($_POST, true));
	else :
		file_put_contents('unknown-call-GET-' . $date . '.txt', 
			print_r($_GET, true));
	endif;

	$verifcode = json_decode(file_get_contents('webhook-verification-code.json'));
	echo 'type: '.$verifcode->type.'<BR>';
	echo 'clientId: '.$verifcode->clientId.'<BR>';
	echo 'verificationCode: '.$verifcode->verificationCode;
	echo '<BR><BR>';

	$filelist = glob( getcwd().'/*.{json,txt}', GLOB_BRACE );

	foreach ($filelist as $filename) :
		echo '<a href="' . basename($filename) . '" target="_blank">' . basename($filename) . '</a><BR>';
	endforeach;
endif;
?>
