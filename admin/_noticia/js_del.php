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

$id = $valores["id"];

$query = mysqli_query($lnk,"SELECT * FROM imagem WHERE id_noticia='$id'");
$numero=mysqli_num_rows($query);
while($linha = mysqli_fetch_array($query))
{
	$img = $linha["img"];
	if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }
}

$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM noticia WHERE id = '$id'"));
$nome = $linha2['nome'];
//$img = $linha2['img'];
//if($img && file_exists('../..'.$img)){ unlink('../..'.$img); $numero++; }

$registo="Apagou a notícia ".$nome." ( #".$id." )";
mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");
mysqli_query($lnk, "DELETE FROM registo WHERE id_noticia='$id'");

mysqli_query($lnk, "DELETE FROM imagem WHERE id_noticia='$id'");
mysqli_query($lnk, "DELETE FROM noticia WHERE id='$id'");

echo json_encode($id);
?>