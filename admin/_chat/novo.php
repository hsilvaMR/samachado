<?php
include('../../_connect.php');
include('../funcao/clear_variable.php');
session_start();

$id_user = $_SESSION['id_user'];
$id_recetor = $_POST["id_recetor"];
$mensagem = text_variable($_POST["mensagem"]);

if($mensagem){
	$data=date('Y-m-d');
	$hora=date('H:i');
	mysqli_query($lnk, "INSERT INTO chat(id_emissor,id_recetor,mensagem,data,hora) VALUES ('$id_user','$id_recetor','$mensagem','$data','$hora')");
	
}
echo $id_user;
?>