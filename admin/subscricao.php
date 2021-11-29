<?php $permissao='head'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Subscrição</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<?
	$url = $_SERVER['REQUEST_URI'];
	$urlPartes = explode("/", $url);
	$id = urldecode($urlPartes[3]);
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM newsletter WHERE id='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM newsletter WHERE id='$id'")));}

	$sep=14;
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Nova";}?> Subscrição<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/subscricoes">Subscrições</a>
				<div class="ponto"></div>
				<a href="">Subscrição</a>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo">
					<form id="FORMULARIO" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<? if($existe){ echo $id; }?>">
					<div id="INF1" class="corpoCima">
						<div class="grupo">
							<div class="grupoEsq"><?if($email){echo "Email";}else{echo "Emails";}?>:</div>
							<div class="grupoDir">
								<?if($email){?>
								<input type="email" class="inP" name="email" value="<? echo $email?>" readonly>
								<?}else{?>
								<textarea class="teX" rows="5" name="emails"></textarea>

								<!--
								<div class="upload_file btY"><span id="EXCEL">SELECIONAR FICHEIRO</span>
								<input type="file" name="excel" accept=".xls, .xlsx, .csv" onchange="lerFicheiros(this,'EXCEL');">
								-->

								<?}?>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Lingua:</div>
							<div class="grupoDir">
								<select class="seL" name="lingua">
									<option class="selS" value="PT">&nbsp;</option>
									<option class="selS" value="PT" <?if($lingua=='PT'){echo "selected";}?>>Português</option>
									<option class="selS" value="EN" <?if($lingua=='EN'){echo "selected";}?>>Inglês</option>
									<option class="selS" value="FR" <?if($lingua=='FR'){echo "selected";}?>>Francês</option>
                                	<option class="selS" value="ES" <?if($lingua=='ES'){echo "selected";}?>>Espanhol</option>
                                </select>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Subsrições:</div>
							<div class="grupoDir">
								<input type="checkbox" name="perfil" id="perfil" class="RD" value="1" <?if($perfil){echo "checked";}?>><label for="perfil" class="margin-top20">&nbsp;</label>&ensp;Perfil
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq"></div>
							<div class="grupoDir">
								<input type="checkbox" name="portfolio" id="portfolio" class="RD" value="1" <?if($portfolio){echo "checked";}?>><label for="portfolio" class="margin-top10">&nbsp;</label>&ensp;Portfolio
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq"></div>
							<div class="grupoDir">
								<input type="checkbox" name="noticias" id="noticias" class="RD" value="1" <?if($noticias){echo "checked";}?>><label for="noticias" class="margin-top10">&nbsp;</label>&ensp;Noticias
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq"></div>
							<div class="grupoDir">
								<input type="checkbox" name="emprego" id="emprego" class="RD" value="1" <?if($emprego){echo "checked";}?>><label for="emprego" class="margin-top10">&nbsp;</label>&ensp;Emprego
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/subscricoes';">CANCELAR</button>					
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
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/subscricoes';">VOLTAR</button>
		</div>
	</div>
</div>
<div id="INSERIR" class="modal">
	<div class="modalFundo" onClick="window.location.href='/admin/subscricoes';"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="window.location.href='/admin/subscricoes';"></span>
	<div class="modalSize">
		<div class="modalHead">Guardado</div>
		<div class="modalBody">Foram inseridos <b id="numSubs"></b> novos subscritores.</div>
		<div class="modalFoot">
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/subscricoes';">OK</button>
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
		e.preventDefault();
		$.ajax({
			url: "/admin/_subscricao/novo.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				data = data.replace(/^\s+|\s+$/g,"");
				if(data){
					if(data=='sucesso'){ mostrar('GUARDAR'); }
					else{
						$('#numSubs').html(data);
						mostrar('INSERIR');
					}
					//window.history.pushState("object or string", "Title", "/admin/subscricao/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});
</script>
</body>
</html>