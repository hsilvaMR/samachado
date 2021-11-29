<?php
include('../../_connect.php');
session_start();
$id_user = $_SESSION['id_user'];
$linha_user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_user'"));
$nome_user = $linha_user['nome'];
$email_user = $linha_user['email'];
$password_user = $linha_user['password'];
$data=date('Y-m-d');
$hora=date('H:i');

$id = $_POST["id"];
$emails = (isset($_POST["emails"])) ? strtolower(trim($_POST["emails"])) : '';
$lingua = isset($_POST["lingua"]) ? $_POST["lingua"] : 'PT';
$noti1 = isset($_POST["perfil"]) ? $_POST["perfil"] : '';
$noti2 = isset($_POST["portfolio"]) ? $_POST["portfolio"] : '';
$noti3 = isset($_POST["noticias"]) ? $_POST["noticias"] : '';
$noti4 = isset($_POST["emprego"]) ? $_POST["emprego"] : '';

if($id){
	mysqli_query($lnk,"UPDATE newsletter SET perfil='$noti1',portfolio='$noti2',noticias='$noti3',emprego='$noti4',lingua='$lingua' WHERE id='$id'");
	$registo="Atualização da subscrição ".$email." ( #".$id." )";
	mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");

	echo 'sucesso';
}else{

	$total=0;
	$exploded = multiexplode(array(" ",",",";","|",":","<",">","#"),$emails);
	foreach($exploded as $val){
		if(filter_var($val, FILTER_VALIDATE_EMAIL)){
			mysqli_query($lnk, "DELETE FROM newsletter WHERE email='$val'");
			mysqli_query($lnk, "INSERT INTO newsletter(email,perfil,portfolio,noticias,emprego,lingua,data) VALUES ('$val', '$noti1', '$noti2', '$noti3', '$noti4', '$lingua', '$data')");
			//$id = mysqli_insert_id($lnk);
			$total++;
		}
	}
	echo $total;
}

function multiexplode ($delimiters,$string) {
	$ready = str_replace($delimiters, $delimiters[0], $string);
	$launch = explode($delimiters[0], $ready);
	return  $launch;
}
?>