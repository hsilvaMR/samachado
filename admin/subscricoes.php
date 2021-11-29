<?php $permissao='admin'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Subscrições</title>
	<? include '_head.php';?>
	<!-- PAGINAR -->
  	<link href="/admin/funcao/datatables/jquery.dataTables.css" rel="stylesheet">
	<script src="/admin/funcao/datatables/jquery.dataTables.min.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=14; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Todas as Subscrições<!--<a href="/admin/categoria"><small>nova categoria</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Subscrições</a>
			</div>
		</div>
		<?php $emailsPerfil=$emailsPortfolio=$emailsNoticias=$emailsEmprego='';
		$query_lista = mysqli_query($lnk,"SELECT * FROM newsletter ORDER BY email ASC");
		while($line = mysqli_fetch_array($query_lista))
		{
			if($line["perfil"]){ $emailsPerfil .= ($emailsPerfil) ? ','.$line["email"] : $line["email"]; }
			if($line["portfolio"]){ $emailsPortfolio .= ($emailsPortfolio) ? ','.$line["email"] : $line["email"]; }
			if($line["noticias"]){ $emailsNoticias .= ($emailsNoticias) ? ','.$line["email"] : $line["email"]; }
			if($line["emprego"]){ $emailsEmprego .= ($emailsEmprego) ? ','.$line["email"] : $line["email"]; }
		} ?>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM newsletter"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM newsletter WHERE perfil=1"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; }  ?>
			<div class="coluna4">
			    <!--<a href="mailto:?bcc=<? echo $emailsPerfil?>">-->
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-smile iconH4"></span>
					</div>
					<div class="subH4">PERFIL</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL (<? echo $num_per?>/<? echo $numero?>)</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
				<!--</a>-->
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM newsletter"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM newsletter WHERE portfolio=1"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna4">
				<!--<a href="mailto:?bcc=<? echo $emailsPortfolio?>">-->
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteAmarelo"><? echo $num_per?></h4>
						<span class="lnr lnr-home iconH4"></span>
					</div>
					<div class="subH4">PORTFÓLIO</div>
					<div class="barraFundo"><div class="barraAmarelo" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL (<? echo $num_per?>/<? echo $numero?>)</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
				<!--</a>-->
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM newsletter"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM newsletter WHERE noticias=1"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; }  ?>
			<div class="coluna4">
				<!--<a href="mailto:?bcc=<? echo $emailsNoticias?>">-->
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteAzul"><? echo $num_per?></h4>
						<span class="lnr lnr-license iconH4"></span>
					</div>
					<div class="subH4">NOTICIAS</div>
					<div class="barraFundo"><div class="barraAzul" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL (<? echo $num_per?>/<? echo $numero?>)</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
				<!--</a>-->
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM newsletter"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM newsletter WHERE emprego=1"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna4">
				<!--<a href="mailto:?bcc=<? echo $emailsEmprego?>">-->
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $num_per?></h4>
						<span class="lnr lnr-briefcase iconH4"></span>
					</div>
					<div class="subH4">OFERTAS DE EMPREGO</div>
					<div class="barraFundo"><div class="barraVermelho" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL (<? echo $num_per?>/<? echo $numero?>)</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
				<!--</a>-->
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo tabelaBorda">
					<div class="tabelaHead">SUBSCRIÇÕES</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th class="none"></th>
								<th>Email</th>
								<th>Perfil</th>
								<th>Portfolio</th>
								<th>Noticias</th>
								<th>Ofertas&nbsp;de&nbsp;Emprego</th>
								<th>Idioma</th>
								<th>Data</th>
								<th>Opção</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM newsletter ORDER BY id DESC");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$email = $linha["email"];
								$lingua = $linha["lingua"];
								$noti1 = $linha["perfil"];
								$noti2 = $linha["portfolio"];
								$noti3 = $linha["noticias"];
								$noti4 = $linha["emprego"];
								$data = $linha["data"];
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
	                            	<td class="none"></td>
									<td><a href="mailto:<?echo $email;?>" class="opcoes"><? echo $email?></a></td>
									<td>
										<!-- labelVermelho labelAmarelo labelAzul labelCinza labelRoxo labelVerde -->
	                                	<?if($noti1){?><span class="labelRoxo">Sim</span>
	                                	<?}else{?><span class="labelCinza">Não</span><?}?>
									</td>
									<td>
										<?if($noti2){?><span class="labelRoxo">Sim</span>
	                                	<?}else{?><span class="labelCinza">Não</span><?}?>
									</td>
									<td>
										<?if($noti3){?><span class="labelRoxo">Sim</span>
	                                	<?}else{?><span class="labelCinza">Não</span><?}?>
									</td>
									<td>
										<?if($noti4){?><span class="labelRoxo">Sim</span>
	                                	<?}else{?><span class="labelCinza">Não</span><?}?>
									</td>
									<td>
										<!-- labelVermelho labelAmarelo labelAzul labelCinza labelRoxo labelVerde -->
	                                	<?if($lingua=='PT'){?><span class="labelVerde">Português</span><?}?>
	                                	<?if($lingua=='EN'){?><span class="labelAmarelo">Inglês</span><?}?>
	                                	<?if($lingua=='FR'){?><span class="labelAzul">Francês</span><?}?>
	                                	<?if($lingua=='ES'){?><span class="labelVermelho">Espanhol</span><?}?>
	                                </td>
									<td><? echo $data?></td>
									<td>
										<a href="/admin/subscricao/<?echo $id;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>&nbsp;&nbsp;
										<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
									</td>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
					<button class="btV margin-top20 floatr" onClick="window.location.href='/admin/subscricao';">ADICIONAR NOVO</button>
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
	$.post("/admin/funcao/js_del.php",{ id:id_del, tabela:'newsletter' }) 
    .done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });
}
// GERIR TABELA
$(document).ready(function(){
     $('#sortable').dataTable({
     	aoColumnDefs: [{ "bSortable": false, "aTargets": [ 8 ] }],
     	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
     });
});
</script>
</body>
</html>