<?php
include('../../_connect.php');
session_start();
$id_admin = $_SESSION['id_user'];
$linha_user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_admin'"));
$nome_user = $linha_user['nome'];
$email_user = $linha_user['email'];
$data=date('Y-m-d');
$hora=date('H:i');

$id = $_POST["id"];
$destino = $_POST["destino"];

switch ($destino) {
	case 'eu':
		extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE id='$id'")));
		$imagem = 'http://www.sa-machado.com'.$capa;
		list($width, $height) = getimagesize($imagem);
		$sizeFoto = ($width > $height) ? 'width="100%"' : 'height="480"';

		$url_nome = preg_replace(array("/( )/","/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/","/(&)/"),explode(" ","- a A e E i I o O u U n N c C e"),$nome);
		$url='http://www.sa-machado.com/overview/'.$id.'/'.$url_nome;

		$paraNome = $nome_user;
		$paraEmail = $email_user;

		$assunto = $nome;
		$mensagem = '
		<!doctype html>
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		    <title></title>
		    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,700" rel="stylesheet">
		    <style type="text/css">
		        body, table, td, a { font-family:"Open Sans",Arial,sans-serif;}
		        a:link, a:hover, a:visited, a:active {text-decoration:none;}
		    </style>
		    <!--[if mso]>
		    <style type="text/css">
		    body, table, td, a, center {font-family: Arial, Helvetica, sans-serif !important;cursor:default;}
		    </style>
		    <![endif]-->
		</head>
		<body style="width:100%;background-color:#f3f3f3;margin:0;padding:0;font-size:14px;-webkit-font-smoothing:antialiased;cursor:default;color:#58595b;">
		    <table border="0" cellpadding="0" align="center" width="500">
		        <tr>
		            <td style="padding:0 10px;">

		            	<table style="padding-top:40px;" border="0" cellpadding="0" width="100%">
						    <tr>
							  <td align="center" width="100%">
							    <img src="http://sa-machado.com/img/icons/sm-logo.png" alt="Sá-Machado" width="91" height="70">
							  </td>
							</tr>
						</table>

		            	<table style="padding-top:40px;" border="0" cellpadding="0" width="100%">
						    <tr>
							    <td align="center" width="100%" style="color:#58595b;font-size:22px;line-height:28px;">
							        <b>'.$nome.'</b>
								</td>
							</tr>
						</table>

						<table style="padding-top:40px;" border="0" cellpadding="0" width="100%">
						    <tr>
							  <td align="center" width="100%">
							    <img src="'.$imagem.'" alt="Article" '.$sizeFoto.'>
							  </td>
							</tr>
						</table>


						<table style="padding-top:30px;" border="0" cellpadding="0" width="100%">
						    <tr>
							    <td width="100%" style="color:#58595b;font-size:14px;line-height:20px;text-align:justify;">'.nl2br($descricao).'</td>
							</tr>
						</table>

						<table style="padding-top:40px;" border="0" cellpadding="0" width="100%">
						    <tr>
							  	<td align="center" width="100%">
								    <table style="font-size:14px;padding:8px 13px;color:#ffffff;background-color:#777777;">
										<tr><td><a href="'.$url.'" target="_blank" style="color:#ffffff;text-decoration:none;background:#777777;">Ficha de Obra</a></td></tr>
									</table>
								</td>
							</tr>
						</table>

						<table style="padding-top:50px;" border="0" cellpadding="0" width="100%">
						   <tr>
							  	<td align="center" width="100%" style="color:#58595b;font-size:11px;line-height:15px;">
							    	Para assegurar que recebe os nossos emails, por favor adicione o nosso email à sua lista de contacto: <a href="" style="text-decoration:none;color:#444444;cursor:default;">no-reply@sa-machado.com</a>
							    	<br><br>
							    	Para anular subscrição <a href="http://www.sa-machado.com/unsubscribe/'.$paraEmail.'" style="text-decoration:none;color:#444444;cursor:default;">clique aqui</a>
								</td>
							</tr>
						</table>

		            </td>
		        </tr>
		        <table style="padding-top:40px;" border="0" cellpadding="0" width="100%"><tr><td></td></tr></table>
		    </table>
		</body>
		</html>
		';
		include('../funcao/email.php');
		break;
	case 'sub':
		$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha WHERE id='$id' AND online=1"));
		if(!$numero){
			echo 'A ficha de obra não se encontra online.';
			return;
		}		
		extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE id='$id' AND online=1")));
		$imagem = 'http://www.sa-machado.com'.$capa;
		list($width, $height) = getimagesize($imagem);
		$sizeFoto = ($width > $height) ? 'width="100%"' : 'height="480"';

		$nome_pt=$nome; $descricao_pt=$descricao;
		$query_lista = mysqli_query($lnk,"SELECT * FROM newsletter WHERE portfolio=1 ORDER BY email ASC");
		while($line = mysqli_fetch_array($query_lista))
		{
			$botao='Ficha de Obra';
			$footerTx='Para assegurar que recebe os nossos emails, por favor adicione o nosso email à sua lista de contacto:';
			$unsubscribe='Para anular subscrição <a href="http://www.sa-machado.com/unsubscribe/'.$line["email"].'" style="text-decoration:none;color:#444444;cursor:default;">clique aqui</a>';

			$nome=$nome_pt; $descricao=$descricao_pt;
			if($line["lingua"]=='EN' && $nome_en && $descricao_en){
				$nome=$nome_en;
				$descricao=$descricao_en;
				$botao='Technical Overview';
				$footerTx='To ensure you will always receive our emails and notifications, please add our email to your contact list:';
				$unsubscribe='To unsubscribe <a href="http://www.sa-machado.com/unsubscribe/'.$line["email"].'" style="text-decoration:none;color:#444444;cursor:default;">click here</a>';
			}
			if($line["lingua"]=='FR' && $nome_fr && $descricao_fr){
				$nome=$nome_fr;
				$descricao=$descricao_fr;
				$botao='Présentation Technique';
				$footerTx='Pour vous assurer que vous recevrez toujours nos courriels et nos notifications, veuillez ajouter notre mail à votre liste de contacts:';
				$unsubscribe='Pour vous désinscrire, <a href="http://www.sa-machado.com/unsubscribe/'.$line["email"].'" style="text-decoration:none;color:#444444;cursor:default;">cliquez ici</a>';
			}
			if($line["lingua"]=='ES' && $nome_es && $descricao_es){
				$nome=$nome_es;
				$descricao=$descricao_es;
				$botao='Descripción Técnica';
				$footerTx='Para asegurarse de recibir nuestros correos, por favor, añada nuestro email a su lista de contacto:';
				$unsubscribe='Para anular suscripción haga <a href="http://www.sa-machado.com/unsubscribe/'.$line["email"].'" style="text-decoration:none;color:#444444;cursor:default;">clic aquí</a>';
			}

			$url_nome = preg_replace(array("/( )/","/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/","/(&)/"),explode(" ","- a A e E i I o O u U n N c C e"),$nome);
			$url='http://www.sa-machado.com/overview/'.$id.'/'.$url_nome;

			$paraNome = '';
			$paraEmail = $line["email"];

			$assunto = $nome;
			$mensagem = '
			<!doctype html>
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			    <title></title>
			    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,700" rel="stylesheet">
			    <style type="text/css">
			        body, table, td, a { font-family:"Open Sans",Arial,sans-serif;}
			        a:link, a:hover, a:visited, a:active {text-decoration:none;}
			    </style>
			    <!--[if mso]>
			    <style type="text/css">
			    body, table, td, a, center {font-family: Arial, Helvetica, sans-serif !important;cursor:default;}
			    </style>
			    <![endif]-->
			</head>
			<body style="width:100%;background-color:#f3f3f3;margin:0;padding:0;font-size:14px;-webkit-font-smoothing:antialiased;cursor:default;color:#58595b;">
			    <table border="0" cellpadding="0" align="center" width="500">
			        <tr>
			            <td style="padding:0 10px;">

			            	<table style="padding-top:40px;" border="0" cellpadding="0" width="100%">
							    <tr>
								  <td align="center" width="100%">
								    <img src="http://sa-machado.com/img/icons/sm-logo.png" alt="Sá-Machado" width="91" height="70">
								  </td>
								</tr>
							</table>

			            	<table style="padding-top:40px;" border="0" cellpadding="0" width="100%">
							    <tr>
								    <td align="center" width="100%" style="color:#58595b;font-size:24px;line-height:30px;">
								        <b>'.$nome.'</b>
									</td>
								</tr>
							</table>

							<table style="padding-top:40px;" border="0" cellpadding="0" width="100%">
							    <tr>
								  <td align="center" width="100%">
								    <img src="'.$imagem.'" alt="Article" '.$sizeFoto.'>
								  </td>
								</tr>
							</table>

							<table style="padding-top:30px;" border="0" cellpadding="0" width="100%">
							    <tr>
								    <td width="100%" style="color:#58595b;font-size:14px;line-height:20px;text-align:justify;">'.nl2br($descricao).'</td>
								</tr>
							</table>

							<table style="padding-top:40px;" border="0" cellpadding="0" width="100%">
							    <tr>
								  	<td align="center" width="100%">
									    <table style="font-size:14px;padding:8px 13px;color:#ffffff;background-color:#777777;">
											<tr><td><a href="'.$url.'" target="_blank" style="color:#ffffff;text-decoration:none;background:#777777;">'.$botao.'</a></td></tr>
										</table>
									</td>
								</tr>
							</table>

							<table style="padding-top:50px;" border="0" cellpadding="0" width="100%">
							   <tr>
								  	<td align="center" width="100%" style="color:#58595b;font-size:11px;line-height:15px;">
								    	'.$footerTx.' <a href="" style="text-decoration:none;color:#444444;cursor:default;">no-reply@sa-machado.com</a>
								    	<br><br>
								    	'.$unsubscribe.'
									</td>
								</tr>
							</table>

			            </td>
			        </tr>
			        <table style="padding-top:40px;" border="0" cellpadding="0" width="100%"><tr><td></td></tr></table>
			    </table>
			</body>
			</html>
			';
			include('../funcao/email.php');
		} 

		$registo="Email enviado aos subscritores da ficha de obra ".$nome." ( #".$id." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_admin','$id_admin','$registo','$data','$hora')");
		break;	
	default:
		break;
}
echo 'TM';
//echo "<script>window.close();</script>"
?>