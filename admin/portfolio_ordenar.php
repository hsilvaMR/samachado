<?php $permissao='head'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Portfolio</title>
	<? include '_head.php';?>
	<!-- ORDENAR -->
	<script src="/admin/funcao/sortable/jquery-ui.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=13; $sub=13.7; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Todas as Fichas de Obra<!--<a href="/admin/homepage"><small>nova homepage</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Fichas de Obra</a>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo tabelaBorda">
					<div class="tabelaHead">FICHAS DE OBRA</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th class="none"></th>
								<th>#</th>
								<th class="compMin">Fotografia</th>
                                <th>Nome</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1; $i=1;
                            $query = mysqli_query($lnk,"SELECT * FROM ficha ORDER BY ordem ASC");
							while($linha = mysqli_fetch_array($query))
							{

								$id = $linha["id"];
								$nome = $linha["nome"];								
								$img = $linha["capa"];
								if(!$img){ $img="/admin/icon/default.jpg"; }
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++;
								//mysqli_query($lnk,"UPDATE ficha SET ordem='$i' WHERE id='$id'");
								//$i++; ?>
	                            <tr id="linha_<? echo $id?>" class="tabelaMover <? echo $classe?>">
	                            	<td class="none"></td>
	                            	<td><? echo $id?></td>
									<td><img src="<? echo $img?>" class="img"></td>
									<td><a href="/admin/portfolio/<?echo $id;?>" class="opcoes"><? echo $nome?></a></td>
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
// ORDENAR
$("#sortable tbody").sortable({
    opacity: 0.6, cursor: 'move',
    update: function() {
		var order = $(this).sortable("serialize")+'&tabela=ficha&campo=ordem';
		$.post("/admin/funcao/ordenar.php", order);
		$.notific8('Guardado com sucesso.', {heading: 'Guardado'});
    }
}).disableSelection();
</script>
</body>
</html>