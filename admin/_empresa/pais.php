<?php
include('../../_connect.php');
include('../funcao/clear_variable.php');
session_start();

$id = $_POST["id"];
$nome = text_variable($_POST["nome"]);
$nome_en = text_variable($_POST["nome_en"]);
$nome_fr = text_variable($_POST["nome_fr"]);
$nome_es = text_variable($_POST["nome_es"]);

//echo "$id \n $nome";

if($id || $nome || $nome_en || $nome_fr || $nome_es){
	if($id){
		mysqli_query($lnk,"UPDATE world SET nome='$nome',nome_en='$nome_en',nome_fr='$nome_fr',nome_es='$nome_es' WHERE id='$id'");
	}
	else{
		mysqli_query($lnk, "INSERT INTO world(nome,nome_en,nome_fr,nome_es) VALUES ('$nome','$nome_en','$nome_fr','$nome_es')");
		$id = mysqli_insert_id($lnk);
	}
}
echo $id;
?>