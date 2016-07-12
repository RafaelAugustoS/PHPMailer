<?php
print_r($_GET);
require_once("class.phpmailer.php");
require_once("class.smtp.php");
require_once("barcode.inc.php");


$email    = $_GET['email'];
$nome  	  = $_GET['nome'];
$evento   = $_GET['evento'];
$artista  = $_GET['artista'];
$data     = $_GET['data'];
$local    = $_GET['local'];
$endereco = $_GET['endereco'];
$telefone = $_GET['telefone'];
$event_ID = $_GET['idEvent'];

$html = '';

foreach($_GET['tickets'] as $id => $qtd){
	for($i = 1; $i <= $qtd; $i++){
		$codigo = $event_ID.'000000'.$id.$i; 
		new barCodeGenrator($codigo,1,"../barcode/".$codigo.".gif",150, 50, true); 
		$html .= '

			<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>Document</title>
			<link href=\'https://fonts.googleapis.com/css?family=Roboto:400,100,300,400italic\' rel=\'stylesheet\' type=\'text/css\'>
			<style>
				body{
					font-family: "Roboto", sans-serif;
				}

				p{
					font-size: 14px;
				}
			</style>
		</head>
		<body>
			<div style="border: 1px solid #000; width: 600px; float: left; padding: 10px;">
				<div style="float: left">
					<img style="width: 80px;" src="http://getmyidol.com/webservice/PDO/phpmailer/images/image001.png">
				</div>
				<div style="float: left; margin-left: 10px;">
					<h1 style="margin: 0; font-size: 2em;">Código: '.$codigo.'</h1>
					<p style="margin: 0">Evento: '.$evento.'</p>
					<p style="margin: 0">Atista: '.$artista.'</p>
					<p style="margin: 0">Data: '.$data.'</p>
					<p style="margin: 0">Local: '.$local.'</p>
					<p style="margin: 0">Endereço: '.$endereco.'</p>
					<p style="margin: 0">Telefone: '.$telefone.'</p>
					<h1 style="margin: 0; font-size: 1.5em;">Comprador: '.$nome.'</h1>
				</div>
				<div style="width: 590px; margin-top: 15px; text-align: center; color: #FFF; background: black; padding: 5px; float: left;">
					<h1 style="margin: 0">PISTA LIVRE</h1>
					
				</div>
				<div style="float: left">
					<img src="http://getmyidol.com/webservice/PDO/phpmailer/images/image004.png">
				</div>
				<div style="float: right">
					<img src="http://getmyidol.com/webservice/PDO/barcode/'.$codigo.'.gif">
				</div>
			</div>
		</body>
		</html>

		';
	}	
}

$mail = new PHPMailer();

//$mail->IsSMTP(); 
$mail->Host = "mail.getmyidol.com";
//$mail->SMTPAuth = true;
$mail->Username = 'system@getmyidol.com'; 
$mail->Password = '@@Gmi2016'; 

$mail->From     = 'system@getmyidol.com'; 
$mail->FromName = 'Contato Getmyidol';


$mail->AddAddress($email, $nome);
$mail->IsHTML(true); 

$mail->Subject  = "Compra efetuada com sucesso"; 
$mail->Body = $html;
$mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano! \r\n :)";

//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo

$enviado = $mail->Send();
$mail->ClearAllRecipients();
$mail->ClearAttachments();
if ($enviado) {
  echo "E-mail enviado com sucesso!";
} else {
  echo "Não foi possível enviar o e-mail.";
  echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
}