<?php $permissao='guest'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Qualidade</title>
	<? include '_head.php';?>
	<!-- PAGINAR -->
  	<link href="/admin/funcao/datatables/jquery.dataTables.css" rel="stylesheet">
	<script src="/admin/funcao/datatables/jquery.dataTables.min.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=15; $sub=15.2; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Qualidade<!--<a href="/admin/categoria"><small>nova categoria</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Qualidade</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM qualidade WHERE online=1"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM qualidade WHERE online=1"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; }  ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-checkmark-circle iconH4"></span>
					</div>
					<div class="subH4">ONLINE</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM qualidade"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM qualidade"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $num_per?></h4>
						<span class="lnr lnr-menu-circle iconH4"></span>
					</div>
					<div class="subH4">TODOS</div>
					<div class="barraFundo"><div class="barraVermelho" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo tabelaBorda">
					<div class="tabelaHead">QUALIDADE</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th class="none"></th>
								<th>Titulo</th>
								<?if( $tipo_user=='admin' ){ ?>
									<th>Ficheiro</th>
									<th>Online</th>
									<th>Op????o</th>
								<? }?>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            if( $tipo_user=='admin' ){ $query = mysqli_query($lnk,"SELECT * FROM qualidade ORDER BY referencia ASC"); }
                            else{$query = mysqli_query($lnk,"SELECT * FROM qualidade WHERE online=1 AND imagem!='' ORDER BY referencia ASC");}
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$referencia = $linha["referencia"];
								$titulo = $linha["titulo"];
								$ficheiro = $linha["imagem"];
								$online = $linha["online"];
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
	                            	<!-- labelCinza labelVerde labelAmarelo labelVermelho labelAzul labelRoxo <span class="labelCinza">pendente</span>-->
	                            	<td class="none"></td>
									<td><a href="/admin/qualidade/<?echo $id;?>" class="opcoes"><? echo $referencia.' - '.$titulo; ?></a></td>
									<?if( $tipo_user=='admin' ){ ?>
										<td><?if($ficheiro){?><a href="<?echo $ficheiro;?>" class="opcoes" target="_bank"><?}?><? echo $ficheiro; ?><?if($ficheiro){?></a><?}?></td>
										<td>
		                                	<input type="checkbox" id="check<?echo $id;?>" class="RD" value="1" onClick="onoff('<?echo $id;?>')" <?if($online)echo "checked";?>>
		          							<label for="check<?echo $id;?>">&nbsp;</label>
										</td>
										<td>
											<a href="/admin/qualidade/<?echo $id;?>" class="opcoes"><span class="lnr lnr-magnifier"></span>&nbsp;Ver</a>
											<!--<a href="/admin/qualidade/<?echo $id;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>&nbsp;&nbsp;
											<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>-->
										</td>
									<? }?>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
					<!--<?if( $tipo_user=='admin' ){ ?><button class="btV margin-top20 floatr" onClick="window.location.href='/admin/qualidade';">ADICIONAR NOVO</button><? }?>
					<div class="clear"></div>-->
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
			<button class="btA modalBt" name="nao" onclick="esconder('APAGAR');">N??O</button>
		</div>
	</div>
</div>
<!-- -->
<script>
$(document).keyup(function(e) {
     if (e.keyCode == 27) { esconder('APAGAR'); }
});
function onoff(id){
	$.post("/admin/funcao/js_onoff.php",{ id:id, tabela:'qualidade', campo:'online' })
	$.notific8('Guardado com sucesso.', {heading: 'Guardado'});	
}
function apagar(){
	$.post("/admin/_impresso/js_del_qualidade.php",{ id:id_del }) 
    .done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });
}
// GERIR TABELA
$(document).ready(function(){
	$('#sortable').dataTable({
     	aoColumnDefs: [{ "bSortable": false, "aTargets": [ 0 <?if( $tipo_user=='admin' ){ echo ", 2, 3, 4";} ?> ] }],
     	lengthMenu: [[20, 25, 50, -1], [20, 25, 50, "Todos"]],
     });
});
</script>
</body>
</html>