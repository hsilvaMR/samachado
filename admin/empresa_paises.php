<?php $permissao='admin'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Países</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=12; $sub=12.1; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Todos os Países<!--<a href="/admin/homepage"><small>nova homepage</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Países</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM world"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM world WHERE online = 1"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-map iconH4"></span>
					</div>
					<div class="subH4">PAÍSES</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">ONLINE</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM company"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM company WHERE online = 1"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $num_per?></h4>
						<span class="lnr lnr-linearicons iconH4"></span>
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
					<div class="tabelaHead">PAÍSES</div>
					<div class="linhaScroll">
						<table class="listagem">
							<thead>
							<tr>
								<th>País (PT)</th>
								<th>País (EN)</th>
								<th>País (FR)</th>
								<th>País (ES)</th>
								<th>Online</th>
								<th>Opção</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM world");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$nome = $linha["nome"];
								$nome_en = $linha["nome_en"];
								$nome_fr = $linha["nome_fr"];
								$nome_es = $linha["nome_es"];
								$online = $linha["online"];
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
									<td><a href="/admin/empresas/<?echo $id;?>" class="opcoes"><? echo $nome;?></a></td>
									<td><? echo $nome_en;?></td>
									<td><? echo $nome_fr;?></td>
									<td><? echo $nome_es;?></td>
	                                <td>
	                                	<input type="checkbox" id="check<?echo $id;?>" class="RD" value="1" onClick="onoff('<?echo $id;?>')" <?if($online)echo "checked";?>>
	          							<label for="check<?echo $id;?>">&nbsp;</label>
									</td>
									<td>
										<a href="/admin/empresas/<?echo $id;?>" class="opcoes"><span class="lnr lnr-menu-circle"></span>&nbsp;Empresas</a>&nbsp;&nbsp;
										<a href="/admin/empresa_pais/<?echo $id;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>&nbsp;&nbsp;
										<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
									</td>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
					<button class="btV margin-top20 floatr" onClick="window.location.href='/admin/empresa_pais';">ADICIONAR NOVO</button>
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
	$.post("/admin/funcao/js_onoff.php",{ id:id, tabela:'world', campo:'online' })
	$.notific8('Guardado com sucesso.', {heading: 'Guardado'});	
}
function apagar(){
	$.post("/admin/_empresa/js_del_pais.php",{ id:id_del }) 
    .done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });
}
</script>
</body>
</html>