<?php $permissao='admin'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Empresas</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<? 
	$url = $_SERVER['REQUEST_URI'];
	$urlPartes = explode("/", $url);
	$id_linha = urldecode($urlPartes[3]);
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM world WHERE id='$id_linha'"));
	if(!$existe){ header('Location: /admin/empresa_paises'); }
	
	$sep=12;
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Todas as Empresas<!--<a href="/admin/homepage"><small>nova homepage</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/empresa_paises">Países</a>
				<div class="ponto"></div>
				<a href="">Empresas</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM company WHERE id_world='$id_linha'"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM company WHERE id_world='$id_linha' AND online = 1"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-list iconH4"></span>
					</div>
					<div class="subH4">ONLINE</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">ONLINE</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM company WHERE id_world='$id_linha'"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM company WHERE id_world='$id_linha'"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $num_per?></h4>
						<span class="lnr lnr-layers iconH4"></span>
					</div>
					<div class="subH4">EMPRESAS</div>
					<div class="barraFundo"><div class="barraVermelho" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">ONLINE</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo tabelaBorda">
					<div class="tabelaHead">EMPRESAS</div>
					<div class="linhaScroll">
						<table class="listagem">
							<thead>
							<tr>
								<th class="compMin">Logo</th>
                                <th>Nome</th>
								<th>Online</th>
								<th>Opção</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM company WHERE id_world='$id_linha'");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$nome = $linha["nome"];
								$img = $linha["logo"];
								if(!$img){ $img="/admin/icon/default.jpg"; }
								$online = $linha["online"];
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
									<td><img src="<? echo $img?>" class="img"></td>
									<td><a href="/admin/empresa/<?echo $id_linha.'/'.$id;?>" class="opcoes"><? echo $nome?></a></td>
	                                <td>
	                                	<input type="checkbox" id="check<?echo $id;?>" class="RD" value="1" onClick="onoff('<?echo $id;?>')" <?if($online)echo "checked";?>>
	          							<label for="check<?echo $id;?>">&nbsp;</label>
									</td>
									<td>
										<a href="/admin/empresa/<?echo $id_linha.'/'.$id;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>&nbsp;&nbsp;
										<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
									</td>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
					<button class="btV margin-top20 floatr" onClick="window.location.href='/admin/empresa/<?echo $id_linha;?>';">ADICIONAR NOVO</button>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
</article>
<? include '_footer.php';?>
<!-- MODALS -->
<div id="APAGAR" class="modal">
	<div class="modalFundo" onClick="esconder('APAGAR');"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="esconder('APAGAR');"></span>
	<div class="modalSize">
		<div class="modalHead">Apagar</div>
		<div class="modalBody">Tem a certeza que deseja apagar?</div>
		<div class="modalFoot">
			<button class="btV modalBt" name="sim" onclick="apagar()">SIM</button>
			<button class="btA modalBt" name="nao" onclick="esconder('APAGAR');">NÃO</button>
		</div>
	</div>
</div>
<!-- -->
<script>
$(document).keyup(function(e) {
     if (e.keyCode == 27) { esconder('APAGAR'); }
});
function onoff(id){
	$.post("/admin/funcao/js_onoff.php",{ id:id, tabela:'company', campo:'online' })
	$.notific8('Guardado com sucesso.', {heading: 'Guardado'});	
}
function apagar(){
	$.post("/admin/_empresa/js_del_empresa.php",{ id:id_del }) 
    .done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });
}
</script>
</body>
</html>