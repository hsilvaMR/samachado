<?
$query = mysqli_query($lnk,"SELECT * FROM chat WHERE id_emissor='$id_user' OR id_recetor='$id_user' OR id_recetor='0'");
while($linha = mysqli_fetch_array($query))
{
	$id = $linha["id"];
	$id_emissor = $linha["id_emissor"];
	$id_recetor = $linha["id_recetor"];
	$sms = $linha["mensagem"];
	$data = $linha["data"];
	$hora = $linha["hora"];
	$hora = substr($hora, 0, 5);
	$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id_emissor'"));
	$nome_emissor = $linha2["nome"];
	if($id_recetor){
		$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id_recetor'"));
		$nome_recetor = $linha3["nome"];
	}
	//Atualizar mensagens lidas
	//if($id_recetor==$id_user){mysqli_query($lnk,"UPDATE chat SET lido='[$id_user]' WHERE id='$id'");}
	//nome_user (eu)
	?>
	<?if($id_emissor==$id_user){?>
		<div class="chatI"><? echo nl2br($sms);?><br><?if($id_recetor){?><font class="fonteCinza"><? echo $nome_recetor;?></font><br><?}?><span class="chatData"><? echo $hora." ".$data;?></span></div>
	<?}
	if($id_emissor!=$id_user && $id_recetor==$id_user){?>
		<div class="chatY"><b><? echo $nome_emissor;?></b><br><? echo nl2br($sms);?><br><span class="chatData"><? echo "PRIVADO<br>".$hora." ".$data;?></span></div>
	<?}
	if($id_emissor!=$id_user && $id_recetor=='0'){?>
		<div class="chatA"><b><? echo $nome_emissor;?></b><br><? echo nl2br($sms);?><br><span class="chatData"><? echo $hora." ".$data;?></span></div>
	<?}
}?>

<?
if($id_user){
	//Atualizar mensagens lidas
	$query_lido = mysqli_query($lnk,"SELECT * FROM chat WHERE lido NOT LIKE '%[$id_user]%' AND id_recetor IN('$id_user','0')");
	while($linha_lido = mysqli_fetch_array($query_lido))
	{
		$id = $linha_lido["id"];
		$lido = $linha_lido["lido"]."[$id_user]";

		mysqli_query($lnk,"UPDATE chat SET lido='$lido' WHERE id='$id'");
	}
}
?>
<div class="clear"></div>
<div id="FUNDO" class="clear margin-top10"></div>