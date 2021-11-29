<?php $permissao='admin'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Etapas</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=8; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Etapas<!--<a href="/admin/categoria"><small>nova categoria</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Etapas</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM etapa"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM etapa"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; }  ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-calendar-full iconH4"></span>
					</div>
					<div class="subH4">ETAPAS</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM fase"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM fase"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $num_per?></h4>
						<span class="lnr lnr-license iconH4"></span>
					</div>
					<div class="subH4">FASES</div>
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
					<div class="tabelaHead">ETAPAS DAS FICHAS DE OBRA</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th>#</th>
								<th>Descricao</th>
								<?if( $tipo_user=='admin' ){ ?><th>Opção</th><? }?>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM etapa");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$descricao = $linha["descricao"];
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
	                            	<td><? echo $id?></td>
	                            	<!-- labelCinza labelVerde labelAmarelo labelVermelho labelAzul labelRoxo <span class="labelVerde">etapa</span> -->
									<td><? echo $descricao?></td>
									<?if( $tipo_user=='admin' ){ ?>
										<td>
											<a href="/admin/etapa/<?echo $id;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>
											<!--&nbsp;&nbsp;<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>-->
										</td>
									<? }?>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo tabelaBorda">
					<div class="tabelaHead">FASES DAS NOTÍCIAS</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th>#</th>
								<th>Descricao</th>
								<?if( $tipo_user=='admin' ){ ?><th>Opção</th><? }?>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM fase");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$descricao = $linha["fase"];
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
	                            	<td><? echo $id?></td>
	                            	<!-- labelCinza labelVerde labelAmarelo labelVermelho labelAzul labelRoxo <span class="labelVerde">etapa</span> -->
									<td><? echo $descricao?></td>
									<?if( $tipo_user=='admin' ){ ?>
										<td>
											<a href="/admin/fase/<?echo $id;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>
											<!--&nbsp;&nbsp;<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>-->
										</td>
									<? }?>
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
</body>
</html>