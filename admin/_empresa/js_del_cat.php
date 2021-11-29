<?php
include('../../_connect.php');
session_start();

$jsonReceiveData = json_encode($_POST);
$jsonIterator = new RecursiveIteratorIterator(new RecursiveArrayIterator(json_decode($jsonReceiveData, TRUE)),RecursiveIteratorIterator::SELF_FIRST);

$valores = array();
foreach ($jsonIterator as $key => $val)
{
   if(is_array($val)) { foreach($val as $key1 => $val1) { $valores[$key][$key1] = $val1; } }
   else { $valores[$key] = $val; }
}	

$id = $valores["id"];

$numero = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM company WHERE id_category='$id'"));
if($numero){ $aux='TF'; }
else{
	mysqli_query($lnk, "DELETE FROM category WHERE id='$id'");
	$aux=$id;
}

echo json_encode($aux);
?>