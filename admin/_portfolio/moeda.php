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
$nome = text_variable($_POST["nome"]);
$simbolo = text_variable($_POST["simbolo"]);
$codigo = text_variable($_POST["codigo"]);
$taxa = str_replace(",", ".", $_POST["taxa"]);

//echo "$id \n $nome";

if($id || $nome || $simbolo || $codigo || $taxa){
	if($id){
		$registo="Atualização da moeda ".$nome."( #".$id." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");
		mysqli_query($lnk,"UPDATE moeda SET nome='$nome',simbolo='$simbolo',codigo='$codigo',taxa='$taxa' WHERE id='$id'");
	}
	else{
		mysqli_query($lnk, "INSERT INTO moeda(nome,simbolo,codigo,taxa) VALUES ('$nome','$simbolo','$codigo','$taxa')");
		$id = mysqli_insert_id($lnk);
		$registo="Nova moeda ".$nome."( #".$id." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");
	}
}
echo $id;
?>