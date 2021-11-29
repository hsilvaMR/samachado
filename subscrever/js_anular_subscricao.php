<?php
include('../_connect.php');
session_start();

$ch1 = (isset($_POST["ch1"])) ? trim($_POST["ch1"]) : '';
$ch2 = (isset($_POST["ch2"])) ? trim($_POST["ch2"]) : '';
$ch3 = (isset($_POST["ch3"])) ? trim($_POST["ch3"]) : '';
$ch4 = (isset($_POST["ch4"])) ? trim($_POST["ch4"]) : '';
$email = (isset($_POST["email"])) ? strtolower(trim($_POST["email"])) : '';
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
$hoje = date('Y-m-d');

$IDIOMA = (isset($_COOKIE["IDIOMA"])) ? $_COOKIE["IDIOMA"] : 'PT';

if($email){
	if($ch1){ mysqli_query($lnk, "UPDATE newsletter SET perfil='0', data='$hoje' WHERE email='$email'"); }
	if($ch2){ mysqli_query($lnk, "UPDATE newsletter SET portfolio='0', data='$hoje' WHERE email='$email'"); }
	if($ch3){ mysqli_query($lnk, "UPDATE newsletter SET noticias='0', data='$hoje' WHERE email='$email'"); }
	if($ch4){ mysqli_query($lnk, "UPDATE newsletter SET emprego='0', data='$hoje' WHERE email='$email'"); }
	//mysqli_query($lnk, "DELETE FROM newsletter WHERE email='$email'");
	//mysqli_query($lnk, "INSERT INTO newsletter(email,perfil,portfolio,noticias,emprego,data) VALUES ('$email','$ch1','$ch2','$ch3','$ch4','$hoje')");
	$aux = "TM";
}else{
	if($IDIOMA=='EN'){ $aux = "Enter your email!"; }
	if($IDIOMA=='PT'){ $aux = "Insira o seu email!"; }
    if($IDIOMA=='FR'){ $aux = "Entrer votre Email!"; }
    if($IDIOMA=='ES'){ $aux = "Introduce tu correo electrónico!"; }
}

echo json_encode($aux);
?>