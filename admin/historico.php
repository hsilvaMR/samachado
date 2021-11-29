<?php $permissao='user'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Histórico</title>
	<? include '_head.php';?>
	<!-- PAGINAR -->
  	<link href="/admin/funcao/datatables/jquery.dataTables.css" rel="stylesheet">
	<script src="/admin/funcao/datatables/jquery.dataTables.min.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=5; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Todos os Registos<!--<a href="/admin/categoria"><small>nova categoria</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Registos</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM registo"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM registo WHERE id_admin='$id_user' OR id_user='$id_user'"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; }  ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-sort-amount-asc iconH4"></span>
					</div>
					<div class="subH4">MEUS REGISTOS</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM registo"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM registo"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $num_per?></h4>
						<span class="lnr lnr-sort-alpha-asc iconH4"></span>
					</div>
					<div class="subH4">REGISTOS</div>
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
					<div class="tabelaHead">HISTÓRICO</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th class="none"></th>
								<th>Emissor</th>
								<th>Recetor</th>
								<th>Registo</th>
								<th>Hora</th>
								<th>Data</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            if( $tipo_user=='admin' ){ $query = mysqli_query($lnk,"SELECT * FROM registo ORDER BY id DESC"); }
                            else{$query = mysqli_query($lnk,"SELECT * FROM registo WHERE id_admin='$id_user' OR id_user='$id_user' ORDER BY id DESC");}
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$id_emissor = $linha["id_admin"];
								$id_recetor = $linha["id_user"];
								$registo = $linha["registo"];
								$data = $linha["data"];
								$hora = $linha["hora"];
								$hora = substr($hora, 0, 5);

								$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id_emissor'"));
								$nome_emissor = $linha2["nome"];
								$nome_emissor = str_replace(" ", "&nbsp;", $nome_emissor);
								$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id_recetor'"));
								$nome_recetor = $linha3["nome"];
								$nome_recetor = str_replace(" ", "&nbsp;", $nome_recetor);

								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_m<? echo $id?>" class="<? echo $classe?>">
	                            	<!-- labelCinza labelVerde labelAmarelo labelVermelho labelAzul labelRoxo <span class="labelCinza">pendente</span>-->
	                            	<td class="none"></td>
									<td><? echo $nome_emissor; ?></td>
									<td><? echo $nome_recetor; ?></td>
									<td><? echo $registo; ?></td>
									<td><? echo $hora; ?></td>
									<td><? echo $data; ?></td>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</article>
<? include '_footer.php';?>
<script>
// GERIR TABELA
$(document).ready(function(){
	$('#sortable').dataTable({
     	aoColumnDefs: [{ "bSortable": false, "aTargets": [ 0 ] }],
     	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
     });
});
</script>
</body>
</html>