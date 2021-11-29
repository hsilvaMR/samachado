<?php $permissao='head'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Documentos</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<?
	$url = $_SERVER['REQUEST_URI'];
	$urlPartes = explode("/", $url);
	$id = urldecode($urlPartes[3]);

	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha WHERE id='$id'"));
	if(!$existe){ header('Location: /admin/portfolios'); }
	
	$sep=13;
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Editar Documentos<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/portfolios">Fichas de Obra</a>
				<div class="ponto"></div>
				<a href="">Documentos</a>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo">
					<form id="FORMULARIO" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<? echo $id; ?>">
					<div id="INF1" class="corpoCima">
						<div class="grupo">
							<div class="grupoEsq">Documentos:</div>
							<div class="grupoDir">
								<div class="linhaScroll margin-top10">
									<table id="sortable" class="listagem">
										<thead>
										<tr>
											<th class="none"></th>
											<th class="compMin">Icone&nbsp;&nbsp;</th>
			                                <th>Nome</th>
											<th>Opção</th>
										</tr>
										</thead>
										<tbody>
			                            <? $risca=1;
			                            $query = mysqli_query($lnk,"SELECT * FROM documentos WHERE id_ficha='$id' ORDER BY tipo ASC");
										while($linha = mysqli_fetch_array($query))
										{
											$id_doc = $linha["id"];
											$nome = $linha["nome"];
											$caminho = $linha["documento"];
											switch ($linha["tipo"]) {
												case 'imagem': $icone = '<img src="'.$caminho.'" class="img" alt="'.$nome.'">'; break;
												case 'audio': $icone = '<span class="lnr lnr-music-note"></span>'; break;
												case 'video': $icone = '<span class="lnr lnr-camera-video"></span>'; break;
												case 'word': $icone = '<span class="lnr lnr-book"></span>'; break;
												case 'powerpoint': $icone = '<span class="lnr lnr-pie-chart"></span>'; break;
												case 'excel': $icone = '<span class="lnr lnr-chart-bars icone"></span>'; break;
												case 'zip': $icone = '<span class="lnr lnr-lock"></span>'; break;
												case 'texto': $icone = '<span class="lnr lnr-text-format"></span>'; break;
												case 'pdf': $icone = '<span class="lnr lnr-license"></span>'; break;
												case 'codigo': $icone = '<span class="lnr lnr-code"></span>'; break;												
												default: $icone = '<span class="lnr lnr-paperclip"></span>'; break;
											}
											if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
											$risca++; ?>
				                            <tr id="linha_<? echo $id_doc?>" class="<? echo $classe ?>">
				                            	<td class="none"></td>
				                            	<td><a href="<? echo $caminho?>" target="_blank"><? echo $icone?></a></td>
												<td>&nbsp;<? echo $nome?></td>
												<td>
													<a href="<?echo $caminho;?>" class="opcoes" download="<?echo $nome;?>"><span class="lnr lnr-download"></span>&nbsp;Download</a>&nbsp;&nbsp;
													<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id_doc;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
												</td>
											</tr>
			                            <?}?>
										</tbody>
									</table>
								</div>

								<div class="upload_file btY">
									<span id="FICHEIRO">SELECIONAR FICHEIROS</span>
									<input type="file" name="documentos[]" onchange="lerFicheiros(this,'FICHEIRO');" multiple/>
								</div>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/portfolios';">CANCELAR</button>
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
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/portfolios';">VOLTAR</button>
		</div>
	</div>
</div>
<div id="APAGAR" class="modal">
	<div class="modalFundo" onClick="esconder('APAGAR');"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="esconder('APAGAR');"></span>
	<div class="modalSize">
		<div class="modalHead">Apagar</div>
		<div class="modalBody">Tem a certeza que deseja apagar?</div>
		<div class="modalFoot">
			<button class="btV modalBt" name="sim" onclick="apagarD()">SIM</button>
			<button class="btA modalBt" name="nao" onclick="esconder('APAGAR');">NÃO</button>
		</div>
	</div>
</div>
<!-- -->
<script>
$(document).keyup(function(e) {
     if (e.keyCode == 27) { esconder('APAGAR'); }
});
function apagarD(){
	$.post("/admin/_portfolio/js_deldoc.php",{ id:id_del }) 
    .done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });
}
function lerFicheiros(input,id) {
    var quantidade = input.files.length;
    //var nome = input.value;
    if(quantidade==1){$('#'+id).html(quantidade+' FICHEIRO');}
    else{$('#'+id).html(quantidade+' FICHEIROS');}
}
$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		mostrar('LOADING');
		e.preventDefault();
		$.ajax({
			url: "/admin/_portfolio/documento.php",
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
					window.history.pushState("object or string", "Title", "/admin/documentos/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});
</script>
</body>
</html>