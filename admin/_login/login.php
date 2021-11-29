<?php
include('../../_connect.php');
session_start();

$email = $_POST['email'];
$email = trim($email);
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
$password = $_POST['password'];
$password = trim($password);

if($email && $password){
	$numero = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user WHERE email = '$email' AND password = '$password'"));
	if($numero){
		$login = mysqli_query($lnk,"SELECT * FROM user WHERE email = '$email' AND password = '$password' AND bloqueado = '0'");
		$num_util = mysqli_num_rows($login);
		if($num_util == 1)
		{
			$linha = mysqli_fetch_array($login);
			$id = $linha['id'];   
			$_SESSION['id_user'] = $id;
			echo "TM";
		}else{ echo "Conta bloqueada!<br>Contacte o administrador.";}
	}else{ echo "Dados incorretos.";}
}else{ echo "Insira os seus dados corretamente."; }
?>