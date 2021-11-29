<?php $permissao='guest'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Tutorial</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=10; include '_menu.php'; ?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Tutorial<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Tutorial</a>
			</div>
		</div>
		<div class="linha">
			<div class="coluna1">
				<div class="corpo">
					<form id="FORMULARIO" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<? echo $id_linha; ?>">
					<div class="corpoCima">
						<div class="grupo linhaScroll">
							<div class="grupoEsq"><!--Tutorial:--></div>
							<div class="grupoDir">
								<!--<div class="upload_file btY"><span id="FICHEIRO">SELECIONAR FICHEIRO</span>
								<input type="file" name="pdf" accept="application/pdf" onchange="lerFicheiros(this);">
								</div>-->
								<div class="linhaScroll margin-top20">
									<iframe src="/admin/_tutorial/Tutorial.pdf"></iframe>
								</div>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo none">
						<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/pdfs';">CANCELAR</button>					
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