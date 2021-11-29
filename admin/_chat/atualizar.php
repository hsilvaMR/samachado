<?
ob_start();
session_start();

include('../../_connect.php');

if (isset($_SESSION['id_user'])) {
	$id_user = $_SESSION['id_user'];
	$linha_user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_user'"));
	$nome_user = $linha_user['nome'];

	include('_chat.php');
}
?>