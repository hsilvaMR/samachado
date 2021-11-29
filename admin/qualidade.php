<?php $permissao='guest'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Qualidade</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<?
	$url = $_SERVER['REQUEST_URI'];
	$urlPartes = explode("/", $url);
	$id = urldecode($urlPartes[3]);
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM qualidade WHERE id='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM qualidade WHERE id='$id'")));}
	else{header('Location: /admin/qualidades');}

	$sep=15; $sub=15.2; include '_menu.php'; ?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><?echo $referencia.' - '.$titulo?><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/qualidades">Qualidade</a>
				<div class="ponto"></div>
				<a href=""><?echo $titulo?></a>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo">
					<form id="FORMULARIO" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<? echo $id_linha; ?>">
					<div class="corpoCima">
						<div class="grupo linhaScroll">
							<div class="grupoEsq"><!--Tutorial:--></div>
							<div class="grupoDir margin-top20">
								<b class="font18">MATRIZ DO PROCESSO</b>
								<div class="linhaScroll margin-top20">
									<img src="<?echo $imagem;?>" style="max-width:100%;margin-top:30px;margin-bottom:50px;">
								</div>
								<b class="font18">LISTA DE ACTIVIDADES</b>
								<? $query = mysqli_query($lnk,"SELECT * FROM atividade WHERE id_qualidade='$id'");
	                            while($linha = mysqli_fetch_array($query))
								{
									$id_atividade = $linha["id"];
									$referencia = $linha["referencia"];
									$titulo = $linha["titulo"];
									?>
									<br><br><font class="font16 fonteAzul"><?echo $referencia.' - '.$titulo;?></font>
									<div class="linhaScroll" style="padding:0 32px;">
										<table class="listagem margin-top10">
											<thead>
											<tr>
												<th>Tarefa</th>
												<th>Resp</th>
												<th>Env</th>
												<th>Entrada</th>
												<th>Saída</th>
											</tr>
											</thead>
											<tbody>
				                            <? $risca=1;
				                            $query2 = mysqli_query($lnk,"SELECT * FROM atividades WHERE id_atividade='$id_atividade'");
											while($linha2 = mysqli_fetch_array($query2))
											{
												$id_tarefa = $linha2["id"];
												$tarefa = $linha2["tarefa"];
												$resp = $linha2["resp"];
												$env = $linha2["env"];
												$entrada = $linha2["entrada"];
												$arrayEntrada = explode("#", $entrada);
												$saida = $linha2["saida"];
												$arraySaida = explode("#", $saida);
												
												if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
												$risca++; ?>
					                            <tr class="<? echo $classe?>">
					                            	<!-- labelCinza labelVerde labelAmarelo labelVermelho labelAzul labelRoxo <span class="labelCinza">pendente</span>-->
													<td><? echo nl2br($tarefa); ?></td>
													<td><? echo nl2br($resp); ?></td>
													<td><? echo nl2br($env); ?></td>
													<td>
														<? foreach ($arrayEntrada as &$value) {
															if(is_numeric($value)){
																$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM impressos WHERE id='$value'"));
																$referencia = $linha3["referencia"];
																$titulo = $linha3["titulo"];
																$ficheiro = $linha3["ficheiro"];
																if($ficheiro){?><p title="<?echo $titulo;?>"><a href="<?echo $ficheiro;?>" class="opcoes" target="_bank"><?}?><? echo '-'.$referencia; ?><?if($ficheiro){?></a></p><?}
															}else{echo '<p>'.$value.'</p>';}
														} ?>
													</td>
													<td>
														<? foreach ($arraySaida as &$value) {
															if(is_numeric($value)){
																$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM impressos WHERE id='$value'"));
																$referencia = $linha3["referencia"];
																$titulo = $linha3["titulo"];
																$ficheiro = $linha3["ficheiro"];
																if($ficheiro){?><p title="<?echo $titulo;?>"><a href="<?echo $ficheiro;?>" class="opcoes" target="_bank"><?}?><? echo '-'.$referencia; ?><?if($ficheiro){?></a></p><?}
															}else{echo '<p>'.$value.'</p>';}
														} ?>
													</td>													
												</tr>
				                            <?}?>
											</tbody>
										</table>
									</div>
									<?
								}?>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<!--<input type="submit" class="btV" name="guardar" value="GUARDAR"/>-->
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/qualidades';">VOLTAR</button>					
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</article>
<? include '_footer.php';?>
<!-- MODALS
<div id="GUARDAR" class="modal">
	<div class="modalFundo" onClick="window.location.reload();"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="window.location.reload();"></span>
	<div class="modalSize">
		<div class="modalHead">Guardado</div>
		<div class="modalBody">Guardado com sucesso.</div>
		<div class="modalFoot">
			<button class="btV modalBt" name="nao" onclick="window.location.reload();">FECHAR</button>
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/painel';">VOLTAR</button>
		</div>
	</div>
</div> -->
<!-- 
<script>
function lerFicheiros(input) {
    var nome = input.value;
	$('#FICHEIRO').html(nome);
}
$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		mostrar('LOADING');
		e.preventDefault();
		$.ajax({
			url: "/admin/_pdf/novo.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				esconder('LOADING');
				data = data.replace(/^\s+|\s+$/g,"");
				if(data){
					mostrar('GUARDAR');
					//window.history.pushState("object or string", "Title", "/admin/pdf/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});
</script>-->
</body>
</html>