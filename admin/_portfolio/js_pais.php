<?php
include('../../_connect.php');
session_start();
$id_user = $_SESSION['id_user'];
$linha_user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_user'"));
$nome_user = $linha_user['nome'];
$email_user = $linha_user['email'];
$data=date('Y-m-d');
$hora=date('H:i');

$jsonReceiveData = json_encode($_POST);
$jsonIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator(json_decode($jsonReceiveData, TRUE)),RecursiveIteratorIterator::SELF_FIRST);

$valores = array();
foreach ($jsonIterator as $key => $val)
{
   if(is_array($val)) { foreach($val as $key1 => $val1) { $valores[$key][$key1] = $val1; } }
   else { $valores[$key] = $val; }
}

$id = $valores['id'];

$linha = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM pais WHERE id='$id'"));
$nome = $linha["nome_pt"];
$valor = $linha["online"];

if($valor=='1'){
	mysqli_query($lnk, "UPDATE pais SET online='0' WHERE id='$id'");
	$registo="Atualização do país ".$nome."( #".$id." ) para offline";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");
	$aux = 0;
}else{
	mysqli_query($lnk, "UPDATE pais SET online='1' WHERE id='$id'");
	$registo="Atualização do país ".$nome."( #".$id." ) para online";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");
	$aux = 1;
}

echo json_encode($aux);
?>