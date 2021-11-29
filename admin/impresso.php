<?php $permissao='admin'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Impresso</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<?
	$url = $_SERVER['REQUEST_URI'];
	$urlPartes = explode("/", $url);
	$id = urldecode($urlPartes[3]);
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM impressos WHERE id='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM impressos WHERE id='$id'")));}
	$sep=15;
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Novo";}?> Impresso<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/impressos">Impressos</a>
				<div class="ponto"></div>
				<a href="">Impresso</a>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo">
					<form id="FORMULARIO" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<? if($existe){ echo $id; }?>">
					<div id="INF1" class="corpoCima">
						<div class="grupo">
							<div class="grupoEsq">Referência:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="referencia" value="<? echo $referencia?>" autofocus required>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Titulo:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="titulo" value="<? echo $titulo?>">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Ficheiro:</div>
							<div class="grupoDir">
								<div class="upload_file btY"><span id="FICHEIRO">SELECIONAR FICHEIRO</span>
								<input type="file" name="ficheiro" accept="file_extension|audio/*|video/*|image/*|media_type" onchange="lerFicheiros(this,'FICHEIRO');">
								</div>
								<div class="linhaScroll">
									<table class="listagem">
										<thead>
											<tr>
												<th>Ficheiro</th>
											</tr>
										</thead>
										<tbody>
				                            <tr class="tabelaFundoI">
				                            	<td>&nbsp;<a href="<?echo $ficheiro;?>" class="opcoes" target="_bank"><? echo $ficheiro?></a></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/impressos';">CANCELAR</button>					
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</article>
<? include '_footer.php';?>
<!-- MODALS -->
<div id="GUARDAR" class="modal">
	<div class="modalFundo" onClick="window.location.reload();"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="window.location.reload();"></span>
	<div class="modalSize">
		<div class="modalHead">Guardado</div>
		<div class="modalBody">Guardado com sucesso.</div>
		<div class="modalFoot">
			<button class="btV modalBt" name="nao" onclick="window.location.reload();">FECHAR</button>
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/impressos';">VOLTAR</button>
		</div>
	</div>
</div>
<!-- -->
<script>
function lerFicheiros(input,id) {
    var quantidade = input.files.length;
    var nome = input.value;
    if(quantidade==1){$('#'+id).html(nome);}
    else{$('#'+id).html(quantidade+' FICHEIROS');}
}
$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		mostrar('LOADING');
		e.preventDefault();
		$.ajax({
			url: "/admin/_impresso/novo.php",
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
					window.history.pushState("object or string", "Title", "/admin/impresso/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});
</script>
</body>
</html>