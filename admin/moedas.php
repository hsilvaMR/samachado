<?php $permissao='admin'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Moedas</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=13; $sub=13.5; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Todas as Moedas<!--<a href="/admin/categoria"><small>nova categoria</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Moedas</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM moeda"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM moeda"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-database iconH4"></span>
					</div>
					<div class="subH4">MOEDAS</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM moeda"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM moeda"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $num_per?></h4>
						<span class="lnr lnr-eye iconH4"></span>
					</div>
					<div class="subH4">ONLINE</div>
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
					<div class="tabelaHead">MOEDAS</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th>Nome</th>
								<th>Simbolo</th>
								<th>Código</th>
								<th>Taxa</th>
								<th>Opção</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM moeda");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$moeda = $linha["nome"];
								$simbolo = $linha["simbolo"];
								$codigo = $linha["codigo"];
								$taxa = $linha["taxa"];
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
									<td><a href="/admin/moeda/<?echo $id;?>" class="opcoes"><? echo $moeda?></a></td>
									<td><? echo $simbolo?></td>
									<td><? echo $codigo?></td>
									<td><? echo $taxa?></td>
									<td>
										<a href="/admin/moeda/<?echo $id;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>&nbsp;&nbsp;
										<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
									</td>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
					<button class="btV margin-top20 floatr" onClick="window.location.href='/admin/moeda';">ADICIONAR NOVO</button>
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
function apagar(){
	$.post("/admin/_portfolio/js_del_moe.php",{ id:id_del }) 
    .done(function( data ){
    	var jsonRetorna = $.parseJSON(data);
    	esconder('APAGAR');
    	if(jsonRetorna!='TF'){
    		$('#linha_'+id_del).css("display","none");
			$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
		}else{
			$.notific8('Esta moeda não pode ser apagada.<br>Tem fichas de obra associadas.', {heading: 'Erro', theme: 'ruby'});
		}
    });
}
</script>
</body>
</html>