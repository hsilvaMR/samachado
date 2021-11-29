<?php
include('../../_connect.php');
session_start();
$id_user = $_SESSION['id_user'];
$linha_user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_user'"));
$nome_user = $linha_user['nome'];
$email_user = $linha_user['email'];
$hoje=date('Y-m-d');
$hora=date('H:i');

$id = $_POST["id"];
$fic_not = $_POST["tipo"]; //ficha ou noticia
$id_util = $_POST["id_util"]; //novo

if($fic_not=='ficha'){
	$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tarefa WHERE id = '$id'"));
	$id_manda = $linha['id_manda'];
	$id_faz = $linha['id_faz'];
	$id_etapa = $linha['id_etapa'];
	$id_processo = $linha['id_processo'];
	$data = $linha['data'];

	$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM processo WHERE id = '$id_processo'"));
	$referencia = $linha2['referencia'];
	$processo = $linha2['processo'];
	$nome = $referencia.' - '.$processo;
}
elseif($fic_not=='noticia'){
	$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id = '$id'"));
	$id_manda = $linha['id_emissor'];
	$id_faz = $linha['id_recetor'];
	$id_etapa = $linha['id_fase'];
	$id_processo = $linha['id_noticia'];
	$data = $linha['data'];

	$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM noticia WHERE id = '$id_processo'"));
	$nome = $linha2['nome'];

}

$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_util'"));
$nome_util = $linha3['nome'];
$email_util = $linha3['email'];

if($id_faz!=$id_util){

	if($fic_not=='ficha'){
		mysqli_query($lnk,"UPDATE tarefa SET id_manda='$id_user',id_faz='$id_util' WHERE id='$id'");
		$registo="Mudança de responsável da etapa ".$id_etapa." da ficha ".$nome." ( #".$id_processo." ) para ".$nome_util." ( #".$id_util." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_util','$id_processo','$id_etapa','$registo','$hoje','$hora')");
	}
	elseif($fic_not=='noticia'){
		mysqli_query($lnk,"UPDATE trabalho SET id_emissor='$id_user',id_recetor='$id_util' WHERE id='$id'");
		$registo="Mudança de responsável da fase ".$id_etapa." da noticia ".$nome." ( #".$id_processo." ) para ".$nome_util." ( #".$id_util." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_util','$id_processo','$id_etapa','$registo','$hoje','$hora')");
	}

	if($data!='0000-00-00' && $id_util!=$id_user){
		if($fic_not=='ficha'){mysqli_query($lnk,"UPDATE tarefa SET data='$hoje' WHERE id='$id'");}
		elseif($fic_not=='noticia'){mysqli_query($lnk,"UPDATE trabalho SET data='$hoje' WHERE id='$id'");}

		$para = $nome_util." <".$email_util.">";
		$paraEmail = $email_util;
		$paraNome = $nome_util;
		$De = $nome_user." <".$email_user.">";
		$assunto = "Plataforma Online Sá Machado";
		$mensagem = '
		<html>
		<head>
		 <title>'.$assunto.'</title>
		 <style>*{font-size:14px;}</style>
		</head>
		<body>
		<p>Olá '.$nome_util.', tem uma <b>nova tarefa</b>.</p>
		<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
		<p>Na plataforma tens informações sobre a tarefa a realizares bem como um chat para te ajudar, no caso de teres dúvidas.</p>
		<p>Todas as tuas interações são guardadas e apresentadas no histórico!</p>
		<p>Melhores Cumprimentos</p>
		<p>'.$nome_user.'</p>
		<br><hr>
		</body>
		</html>
		';
		include('../funcao/email.php');
	}
}
echo $fic_not."/".$id;
?>