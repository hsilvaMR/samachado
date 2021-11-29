<?php
include('../../_connect.php');
include('../funcao/clear_variable.php');
session_start();
$id_user = $_SESSION['id_user'];
$linha_user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_user'"));
$nome_user = $linha_user['nome'];
$email_user = $linha_user['email'];
$hoje=date('Y-m-d');
$hora=date('H:i');

$id = $_POST["id"];
$nome = text_variable($_POST["nome"]);
$nome_en = text_variable($_POST["nome_en"]);
$nome_fr = text_variable($_POST["nome_fr"]);
$nome_es = text_variable($_POST["nome_es"]);
//echo "$id \n $nome";

if($id || $nome || $nome_en || $nome_fr || $nome_es){
	if($id){
		mysqli_query($lnk,"UPDATE tipo SET nome='$nome',nome_en='$nome_en',nome_fr='$nome_fr',nome_es='$nome_es' WHERE id='$id'");

		$registo="Atualização do tipo ".$nome." ( #".$id." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$hoje','$hora')");
	}
	else{
		mysqli_query($lnk, "INSERT INTO tipo(nome,nome_en,nome_fr,nome_es) VALUES ('$nome','$nome_en','$nome_fr','$nome_es')");
		$id = mysqli_insert_id($lnk);

		$registo="Novo tipo ".$nome." ( #".$id." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$hoje','$hora')");
	}
}
echo $id;
?>