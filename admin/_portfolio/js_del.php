<?php
include('../../_connect.php');
session_start();
$id_user = $_SESSION['id_user'];
$linha_user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_user'"));
$nome_user = $linha_user['nome'];
$email_user = $linha_user['email'];
$hoje=date('Y-m-d');
$hora=date('H:i');

$jsonReceiveData = json_encode($_POST);
$jsonIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator(json_decode($jsonReceiveData, TRUE)),RecursiveIteratorIterator::SELF_FIRST);

$valores = array();
foreach ($jsonIterator as $key => $val)
{
   if(is_array($val)) { foreach($val as $key1 => $val1) { $valores[$key][$key1] = $val1; } }
   else { $valores[$key] = $val; }
}	

$id = $valores["id"];

/*$query = mysqli_query($lnk,"SELECT * FROM galeria WHERE id_ficha='$id'");
while($linha = mysqli_fetch_array($query))
{
	$img = $linha["img"];
	if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }
}
mysqli_query($lnk, "DELETE FROM galeria WHERE id_ficha='$id'");*/

$linha_ficha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE id='$id'"));
$nome = $linha_ficha['nome'];

$registo="Apagou a ficha ".$nome." ( #".$id." ) do portfólio";
mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$hoje','$hora')");

$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE id='$id'"));
$capa = $linha2["capa"];
if($capa && file_exists('../..'.$capa)){ unlink('../..'.$capa); }
$frente = $linha2["frente"];
if($frente && file_exists('../..'.$frente)){ unlink('../..'.$frente); }
$tras = $linha2["tras"];
if($tras && file_exists('../..'.$tras)){ unlink('../..'.$tras); }
$img1 = $linha2["img1"];
if($img1 && file_exists('../..'.$img1)){ unlink('../..'.$img1); }
$img2 = $linha2["img2"];
if($img2 && file_exists('../..'.$img2)){ unlink('../..'.$img2); }
$img3 = $linha2["img3"];
if($img3 && file_exists('../..'.$img3)){ unlink('../..'.$img3); }
$img4 = $linha2["img4"];
if($img4 && file_exists('../..'.$img4)){ unlink('../..'.$img4); }
mysqli_query($lnk, "DELETE FROM ficha WHERE id='$id'");

echo json_encode($id);
?>