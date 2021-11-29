<?php $permissao='admin'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Países</title>
	<? include '_head.php';?>
	<!-- PAGINAR -->
  	<link href="/admin/funcao/datatables/jquery.dataTables.css" rel="stylesheet">
	<script src="/admin/funcao/datatables/jquery.dataTables.min.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=13; $sub=13.6; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Todas os Países<!--<a href="/admin/homepage"><small>nova notícia</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Países</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM pais"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM pais"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-earth iconH4"></span>
					</div>
					<div class="subH4">PAÍSES</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM pais"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM pais WHERE online='1'"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $num_per?></h4>
						<span class="lnr lnr-location iconH4"></span>
					</div>
					<div class="subH4">VISIVEIS</div>
					<div class="barraFundo"><div class="barraVermelho" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">VISIVEIS</span>
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
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th class="none"></th>
                                <th>País (PT)</th>
								<th>País (EN)</th>
								<th>País (FR)</th>
								<th>País (ES)</th>
								<th>Visível</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM pais ORDER BY nome_pt ASC");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$nome_pt = $linha["nome_pt"];
								$nome_en = $linha["nome_en"];
								$nome_fr = $linha["nome_fr"];
								$nome_es = $linha["nome_es"];
								$online = $linha["online"];
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
	                            	<td class="none"></td>
									<td><? echo $nome_pt?></td>
									<td><? echo $nome_en?></td>
									<td><? echo $nome_fr?></td>
									<td><? echo $nome_es?></td>
	                                <td>
	                                	<input type="checkbox" id="check<?echo $id;?>" class="RD" value="1" onClick="onoff('<?echo $id;?>')" <?if($online)echo "checked";?>>
	          							<label for="check<?echo $id;?>">&nbsp;</label>
									</td>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
</article>
<? include '_footer.php';?>
<script>
function onoff(id){
	$.post("/admin/_portfolio/js_pais.php",{ id:id })
	$.notific8('Guardado com sucesso.', {heading: 'Guardado'});	 	
}
// GERIR TABELA
$(document).ready(function(){
     $('#sortable').dataTable({
     	aoColumnDefs: [{ "bSortable": false, "aTargets": [ 0, 5 ] }],
     	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
     });
});
</script>
</body>
</html>