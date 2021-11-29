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

$nome = text_variable($_POST["nome"]);

$etapa1 = $_POST["etapa1"];
$etapa2 = $_POST["etapa2"];
$etapa3 = $_POST["etapa3"];
$etapa4 = $_POST["etapa4"];
$etapa5 = $_POST["etapa5"];
$etapa6 = $_POST["etapa6"];

if($nome && $etapa1 && $etapa2 && $etapa3 && $etapa4 && $etapa5 && $etapa6){
	//PROCESSO
	mysqli_query($lnk, "INSERT INTO noticia(id_user,id_tipo,id_fase,nome) VALUES ('$id_user',2,1,'$nome')");
	$id = mysqli_insert_id($lnk);
	$registo="Criação da notícia ".$nome." ( #".$id." )";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id',1,'$registo','$data','$hora')");
	//ETAPA 1
	mysqli_query($lnk, "INSERT INTO trabalho(id_emissor,id_recetor,id_noticia,id_fase,data) VALUES ('$id_user','$etapa1','$id',1,'$data')");
	$linha_util = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$etapa1'"));
	$nome_util1 = $linha_util['nome'];
	$email_util1 = $linha_util['email'];
	$registo="Atribuição da 1ª fase a ".$nome_util1." ( #".$etapa1." )";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$etapa1','$id',1,'$registo','$data','$hora')");	
	//ETAPA 2
	mysqli_query($lnk, "INSERT INTO trabalho(id_emissor,id_recetor,id_noticia,id_fase) VALUES ('$id_user','$etapa2','$id',2)");
	$linha_util = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$etapa2'"));
	$nome_util = $linha_util['nome'];
	$registo="Atribuição da 2ª fase a ".$nome_util." ( #".$etapa2." )";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$etapa2','$id',2,'$registo','$data','$hora')");
	//ETAPA 3
	mysqli_query($lnk, "INSERT INTO trabalho(id_emissor,id_recetor,id_noticia,id_fase) VALUES ('$id_user','$etapa3','$id',3)");
	$linha_util = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$etapa3'"));
	$nome_util = $linha_util['nome'];
	$registo="Atribuição da 3ª fase a ".$nome_util."( #".$etapa3." )";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$etapa3','$id',3,'$registo','$data','$hora')");
	//ETAPA 4
	mysqli_query($lnk, "INSERT INTO trabalho(id_emissor,id_recetor,id_noticia,id_fase) VALUES ('$id_user','$etapa4','$id',4)");
	$linha_util = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$etapa4'"));
	$nome_util = $linha_util['nome'];
	$registo="Atribuição da 4ª fase a ".$nome_util." ( #".$etapa4." )";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$etapa4','$id',4,'$registo','$data','$hora')");
	//ETAPA 5
	mysqli_query($lnk, "INSERT INTO trabalho(id_emissor,id_recetor,id_noticia,id_fase) VALUES ('$id_user','$etapa5','$id',5)");
	$linha_util = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$etapa5'"));
	$nome_util = $linha_util['nome'];
	$registo="Atribuição da 5ª fase a ".$nome_util." ( #".$etapa5." )";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$etapa5','$id',5,'$registo','$data','$hora')");
	//ETAPA 6
	mysqli_query($lnk, "INSERT INTO trabalho(id_emissor,id_recetor,id_noticia,id_fase) VALUES ('$id_user','$etapa6','$id',6)");
	$linha_util = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$etapa6'"));
	$nome_util = $linha_util['nome'];
	$registo="Atribuição da 6ª fase a ".$nome_util." ( #".$etapa6." )";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$etapa6','$id',6,'$registo','$data','$hora')");
	//EMAIL
	if($etapa1!=$id_user){
		$para = $nome_util1." <".$email_util1.">";
		$paraEmail = $email_util1;
		$paraNome = $nome_util1;
		$De = $nome_user." <".$email_user.">";
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
		<p>Na plataforma tens informações sobre as tarefa a realizares bem como um chat para te ajudar, no caso de teres dúvidas, e registo de todas as tuas interações.</p>
		<p>Cada vez que tiveres uma nova tarefa, receberás um email com essa informação!</p>
		<p>Melhores Cumprimentos</p>
		<p>'.$nome_user.'</p>
		<br><hr>
		</body>
		</html>
		';
		include('../funcao/email.php');
		$registo="Email enviado a ".$nome_util1." ( ".$email_util1." ) com indicação de uma nova tarefa";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$etapa1','$id',1,'$registo','$data','$hora')");
	}
	$aux='TM';
	
}else{$aux='Todos os campos são de preenchimento obrigatório.';}
echo $aux;
?>