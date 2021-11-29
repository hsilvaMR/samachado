<?php
include('../../_connect.php');
session_start();
$id_user = $_SESSION['id_user'];
$linha_user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_user'"));
$nome_user = $linha_user['nome'];
$email_user = $linha_user['email'];
$password_user = $linha_user['password'];
$data=date('Y-m-d');
$hora=date('H:i');

$antiga = $_POST["antiga"];
$nova = $_POST["nova"];
$confirmacao = $_POST["confirmacao"];
$str = strlen($nova);

if($password_user==$antiga){
	if($str>5){
		if($nova==$confirmacao){
			mysqli_query($lnk,"UPDATE user SET password='$nova' WHERE id='$id_user'");
			$registo="Atualização da password do utilizador ".$nome_user." ( #".$id_user." )";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");
			$aviso='TM';
		}else{ $aviso='As password\'s não coincidem.';}
	}else{ $aviso='Nova password demasiado curta. <br>Mínimo 6 caracteres.';}
}else{ $aviso='Password incorreta.';}
echo $aviso;
?>