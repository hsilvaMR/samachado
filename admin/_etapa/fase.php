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

$id = $_POST["id"];
$descricao = text_variable($_POST["descricao"]);

if($descricao){
	$registo="Atualização da fase ".$nome." ( #".$id." )";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id','$registo','$data','$hora')");
	mysqli_query($lnk,"UPDATE fase SET fase='$descricao' WHERE id='$id'");
}
echo $id;
?>