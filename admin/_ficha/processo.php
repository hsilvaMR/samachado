<?php
include('../../_connect.php');
include('../funcao/clear_variable.php');
session_start();
$id_user = $_SESSION['id_user'];
$linha_user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_user'"));
$nome_user = $linha_user['nome'];
$email_user = $linha_user['email'];
$data=date('Y-m-d');
$hora=date('H:i');

$referencia = text_variable($_POST["referencia"]);
$nome = text_variable($_POST["nome"]);

$etapa1 = $_POST["etapa1"];
$etapa2 = $_POST["etapa2"];
$etapa3 = $_POST["etapa3"];
$etapa4 = $_POST["etapa4"];
$etapa5 = $_POST["etapa5"];
$etapa6 = $_POST["etapa6"];

if($referencia && $nome && $etapa1 && $etapa2 && $etapa3 && $etapa4 && $etapa5 && $etapa6){
	//PROCESSO
	mysqli_query($lnk, "INSERT INTO processo(id_responsavel,id_pais,id_categoria,id_moeda,id_estado,id_etapa,referencia,processo) VALUES ('$id_user',1,1,1,2,1,'$referencia','$nome')");
	$id_processo = mysqli_insert_id($lnk);
	$registo="Criação da ficha de obra ".$referencia." - ".$nome."( #".$id_processo." )";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo',1,'$registo','$data','$hora')");
	//ETAPA 1
	mysqli_query($lnk, "INSERT INTO tarefa(id_manda,id_faz,id_etapa,id_processo,data) VALUES ('$id_user','$etapa1',1,'$id_processo','$data')");
	$linha_util = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$etapa1'"));
	$nome_util1 = $linha_util['nome'];
	$email_util1 = $linha_util['email'];
	$registo="Atribuição da 1ª etapa a ".$nome_util1."( #".$etapa1." )";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$etapa1','$id_processo',1,'$registo','$data','$hora')");	

	$data=date('Y-m-d');
	$hora=date('H:i');
	$paraEmail = $email_util1;
	$paraNome = $nome_util1;
	$assunto = "Plataforma Online Sá Machado";
	$mensagem = '
	<html>
	<head>
	 <title>'.$assunto.'</title>
	 <style>*{font-size:14px;}</style>
	</head>
	<body>
	<p>Olá '.$nome_util1.', tem uma <b>nova tarefa</b>.</p>
	<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
	<p>Na plataforma tens informações sobre a tarefa a realizar bem como um chat para te ajudar, no caso de teres dúvidas, e registo de todas as tuas interações.</p>
	<p>Cada vez que tiveres uma nova tarefa, receberás um email com essa informação!</p>
	<p>Melhores Cumprimentos</p>
	<p>'.$nome_user.'</p>
	<br><hr>
	</body>
	</html>
	';
	include('../funcao/email.php');
	$registo="Email enviado a ".$nome_util1." ( ".$email_util1." ) com indicação de uma nova tarefa";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$etapa1','$id_processo',1,'$registo','$data','$hora')");

	//ETAPA 2
	mysqli_query($lnk, "INSERT INTO tarefa(id_manda,id_faz,id_etapa,id_processo) VALUES ('$id_user','$etapa2',2,'$id_processo')");
	$linha_util = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$etapa2'"));
	$nome_util = $linha_util['nome'];
	$email_util = $linha_util['email'];
	$registo="Atribuição da 2ª etapa a ".$nome_util."( #".$etapa2." )";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$etapa2','$id_processo',2,'$registo','$data','$hora')");

	$data=date('Y-m-d');
	$hora=date('H:i');
	$paraEmail = $email_util;
	$paraNome = $nome_util;
	$assunto = "Plataforma Online Sá Machado";
	$mensagem = '
	<html>
	<head>
	 <title>'.$assunto.'</title>
	 <style>*{font-size:14px;}</style>
	</head>
	<body>
	<p>Olá '.$nome_util.', foi designado para uma <b>nova tarefa</b> no processo de uma ficha de obra.</p>
	<p>Voltará a ser notificado na altura de a realizar.</p>
	<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
	<p>Na plataforma tens informações sobre a tarefa a realizar bem como um chat para te ajudar, no caso de teres dúvidas, e registo de todas as tuas interações.</p>
	<p>Cada vez que tiveres uma nova tarefa, receberás um email com essa informação!</p>
	<p>Melhores Cumprimentos</p>
	<p>'.$nome_user.'</p>
	<br><hr>
	</body>
	</html>
	';
	include('../funcao/email.php');
	$registo="Email enviado a ".$nome_util." ( ".$email_util." ) com indicação de que foi designado para uma nova tarefa";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$etapa2','$id_processo',2,'$registo','$data','$hora')");

	//ETAPA 3
	mysqli_query($lnk, "INSERT INTO tarefa(id_manda,id_faz,id_etapa,id_processo) VALUES ('$id_user','$etapa3',3,'$id_processo')");
	$linha_util = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$etapa3'"));
	$nome_util = $linha_util['nome'];
	$email_util = $linha_util['email'];
	$registo="Atribuição da 3ª etapa a ".$nome_util."( #".$etapa3." )";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$etapa3','$id_processo',3,'$registo','$data','$hora')");

	$data=date('Y-m-d');
	$hora=date('H:i');
	$paraEmail = $email_util;
	$paraNome = $nome_util;
	$assunto = "Plataforma Online Sá Machado";
	$mensagem = '
	<html>
	<head>
	 <title>'.$assunto.'</title>
	 <style>*{font-size:14px;}</style>
	</head>
	<body>
	<p>Olá '.$nome_util.', foi designado para uma <b>nova tarefa</b> no processo de uma ficha de obra.</p>
	<p>Voltará a ser notificado na altura de a realizar.</p>
	<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
	<p>Na plataforma tens informações sobre a tarefa a realizar bem como um chat para te ajudar, no caso de teres dúvidas, e registo de todas as tuas interações.</p>
	<p>Cada vez que tiveres uma nova tarefa, receberás um email com essa informação!</p>
	<p>Melhores Cumprimentos</p>
	<br><hr>
	</body>
	</html>
	';
	include('../funcao/email.php');
	$registo="Email enviado a ".$nome_util." ( ".$email_util." ) com indicação de que foi designado para uma nova tarefa";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$etapa3','$id_processo',3,'$registo','$data','$hora')");

	//ETAPA 4
	mysqli_query($lnk, "INSERT INTO tarefa(id_manda,id_faz,id_etapa,id_processo) VALUES ('$id_user','$etapa4',4,'$id_processo')");
	$linha_util = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$etapa4'"));
	$nome_util = $linha_util['nome'];
	$email_util = $linha_util['email'];
	$registo="Atribuição da 4ª etapa a ".$nome_util."( #".$etapa4." )";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$etapa4','$id_processo',4,'$registo','$data','$hora')");

	$data=date('Y-m-d');
	$hora=date('H:i');
	$paraEmail = $email_util;
	$paraNome = $nome_util;
	$assunto = "Plataforma Online Sá Machado";
	$mensagem = '
	<html>
	<head>
	 <title>'.$assunto.'</title>
	 <style>*{font-size:14px;}</style>
	</head>
	<body>
	<p>Olá '.$nome_util.', foi designado para uma <b>nova tarefa</b> no processo de uma ficha de obra.</p>
	<p>Voltará a ser notificado na altura de a realizar.</p>
	<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
	<p>Na plataforma tens informações sobre a tarefa a realizar bem como um chat para te ajudar, no caso de teres dúvidas, e registo de todas as tuas interações.</p>
	<p>Cada vez que tiveres uma nova tarefa, receberás um email com essa informação!</p>
	<p>Melhores Cumprimentos</p>
	<p>'.$nome_user.'</p>
	<br><hr>
	</body>
	</html>
	';
	include('../funcao/email.php');
	$registo="Email enviado a ".$nome_util." ( ".$email_util." ) com indicação de que foi designado para uma nova tarefa";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$etapa4','$id_processo',4,'$registo','$data','$hora')");

	//ETAPA 5
	mysqli_query($lnk, "INSERT INTO tarefa(id_manda,id_faz,id_etapa,id_processo) VALUES ('$id_user','$etapa5',5,'$id_processo')");
	$linha_util = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$etapa5'"));
	$nome_util = $linha_util['nome'];
	$email_util = $linha_util['email'];
	$registo="Atribuição da 5ª etapa a ".$nome_util."( #".$etapa5." )";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$etapa5','$id_processo',5,'$registo','$data','$hora')");

	$data=date('Y-m-d');
	$hora=date('H:i');
	$paraEmail = $email_util;
	$paraNome = $nome_util;
	$assunto = "Plataforma Online Sá Machado";
	$mensagem = '
	<html>
	<head>
	 <title>'.$assunto.'</title>
	 <style>*{font-size:14px;}</style>
	</head>
	<body>
	<p>Olá '.$nome_util.', foi designado para uma <b>nova tarefa</b> no processo de uma ficha de obra.</p>
	<p>Voltará a ser notificado na altura de a realizar.</p>
	<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
	<p>Na plataforma tens informações sobre a tarefa a realizar bem como um chat para te ajudar, no caso de teres dúvidas, e registo de todas as tuas interações.</p>
	<p>Cada vez que tiveres uma nova tarefa, receberás um email com essa informação!</p>
	<p>Melhores Cumprimentos</p>
	<p>'.$nome_user.'</p>
	<br><hr>
	</body>
	</html>
	';
	include('../funcao/email.php');
	$registo="Email enviado a ".$nome_util." ( ".$email_util." ) com indicação de que foi designado para uma nova tarefa";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$etapa5','$id_processo',5,'$registo','$data','$hora')");

	//ETAPA 6
	mysqli_query($lnk, "INSERT INTO tarefa(id_manda,id_faz,id_etapa,id_processo) VALUES ('$id_user','$etapa6',6,'$id_processo')");
	$linha_util = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$etapa6'"));
	$nome_util = $linha_util['nome'];
	$email_util = $linha_util['email'];
	$registo="Atribuição da 6ª etapa a ".$nome_util."( #".$etapa6." )";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$etapa6','$id_processo',6,'$registo','$data','$hora')");

	$data=date('Y-m-d');
	$hora=date('H:i');
	$paraEmail = $email_util;
	$paraNome = $nome_util;
	$assunto = "Plataforma Online Sá Machado";
	$mensagem = '
	<html>
	<head>
	 <title>'.$assunto.'</title>
	 <style>*{font-size:14px;}</style>
	</head>
	<body>
	<p>Olá '.$nome_util.', foi designado para uma <b>nova tarefa</b> no processo de uma ficha de obra.</p>
	<p>Voltará a ser notificado na altura de a realizar.</p>
	<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
	<p>Na plataforma tens informações sobre a tarefa a realizar bem como um chat para te ajudar, no caso de teres dúvidas, e registo de todas as tuas interações.</p>
	<p>Cada vez que tiveres uma nova tarefa, receberás um email com essa informação!</p>
	<p>Melhores Cumprimentos</p>
	<br><hr>
	</body>
	</html>
	';
	include('../funcao/email.php');
	$registo="Email enviado a ".$nome_util." ( ".$email_util." ) com indicação de que foi designado para uma nova tarefa";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$etapa6','$id_processo',6,'$registo','$data','$hora')");


	//EMAIL
	//if($etapa1!=$id_user){
		//$para = $nome_util1." <".$email_util1.">";
		//$paraEmail = $email_util1;
		//$paraNome = $nome_util1;
		//$De = $nome_user." <".$email_user.">";
		/*$assunto = "Plataforma Online Sá Machado";
		$mensagem = '
		<html>
		<head>
		 <title>'.$assunto.'</title>
		 <style>*{font-size:14px;}</style>
		</head>
		<body>
		<p>Olá '.$nome_util1.', tem uma <b>nova tarefa</b>.</p>
		<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
		<p>Na plataforma tens informações sobre a tarefa a realizar bem como um chat para te ajudar, no caso de teres dúvidas, e registo de todas as tuas interações.</p>
		<p>Cada vez que tiveres uma nova tarefa, receberás um email com essa informação!</p>
		<p>Melhores Cumprimentos</p>
		<p>'.$nome_user.'</p>
		<br><hr>
		</body>
		</html>
		';
		include('../funcao/email.php');
		$registo="Email enviado a ".$nome_util1." ( ".$email_util1." ) com indicação de uma nova tarefa";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$etapa1','$id_processo',1,'$registo','$data','$hora')");*/
	//}

	$aux='TM';
}else{$aux='Todos os campos são de preenchimento obrigatório.';}
echo $aux;
?>