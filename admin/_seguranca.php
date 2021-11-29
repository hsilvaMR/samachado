<?php
ob_start();
session_start();
include('../_connect.php');

if(isset($_SESSION['id_user']))
{
	$id_user = $_SESSION['id_user'];
	$linha_user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_user'"));
	$nome_user = $linha_user['nome'];
	$email_user = $linha_user['email'];
	$tipo_user = $linha_user['tipo'];

	if($tipo_user!='admin' && $tipo_user!='head' && $tipo_user!='user' && $tipo_user!='guest' ){ header('Location: /admin');}

	if( $permissao=='admin' && $tipo_user!='admin' ){ header('Location: /admin/painel'); }
	if( $permissao=='head' && ($tipo_user=='user' || $tipo_user=='guest') ){ header('Location: /admin/painel'); }
	if( $permissao!='guest' && $tipo_user=='guest' ){ header('Location: /admin/chat'); }
}
else
{
	session_destroy();
	header('Location: /admin');
}
?>