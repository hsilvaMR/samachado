<?php
include('../../_connect.php');
session_start();

$id = $_POST['id'];
$id_user = $_SESSION['id_user'];
$aviso = "";

$linha = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM ficha WHERE id='$id'"));
$valor = $linha["online"];
$bloqueada = $linha["bloquear"];

if (!$bloqueada){
	if($valor=='1'){$aux = 0;}else{$aux = 1;}
	mysqli_query($lnk, "UPDATE ficha SET online='$aux' WHERE id='$id'");
}elseif ($id_user=='1' || $id_user=='2' || $id_user=='18') {
	if($valor=='1'){$aux = 0;}else{$aux = 1;}
	mysqli_query($lnk, "UPDATE ficha SET online='$aux' WHERE id='$id'");
}else{
	$aviso = "Não tem permissões suficientes para alterar esta ficha!";
}

echo $aviso;
?>