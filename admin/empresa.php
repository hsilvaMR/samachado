<?php $permissao='admin'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Empresa</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<?
	$url = $_SERVER['REQUEST_URI'];
	$urlPartes = explode("/", $url);
	$id_world = urldecode($urlPartes[3]);
	$existe_menu = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM world WHERE id='$id_world'"));
	if(!$existe_menu){ header('Location: /admin/empresa_paises'); }

	$id = urldecode($urlPartes[4]);
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM company WHERE id='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM company WHERE id='$id'")));}

	$sep=12;
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Nova";}?> Empresa<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/empresa_paises">Países</a>
				<div class="ponto"></div>
				<a href="/admin/empresas/<? echo $id_world;?>">Empresas</a>
				<div class="ponto"></div>
				<a href="">Empresa</a>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo">
					<div class="tabs">
						<div id="TAB1" class="tab-sim" onClick="mudarTab(1);"><span class="DN1024">PT</span><span class="DB1024">Português</span></div>
						<div id="TAB2" class="tab-nao" onClick="mudarTab(2);"><span class="DN1024">EN</span><span class="DB1024">Inglês</span></div>
						<div id="TAB3" class="tab-nao" onClick="mudarTab(3);"><span class="DN1024">FR</span><span class="DB1024">Francês</span></div>
						<div id="TAB4" class="tab-nao" onClick="mudarTab(4);"><span class="DN1024">ES</span><span class="DB1024">Espanhol</span></div>
					</div>
					<form id="FORMULARIO" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id_world" value="<? echo $id_world; ?>">
					<input type="hidden" name="id" value="<? if($existe){ echo $id; }?>">
					<div id="INF1" class="corpoCima">
						<div class="grupo">
							<div class="grupoEsq">Nome:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="nome" value="<? echo $nome?>" autofocus>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Texto:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="20" name="texto"><? echo $texto?></textarea>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Categoria:</div>
							<div class="grupoDir">
								<select class="seL" name="id_category">
                                	<? $query = mysqli_query($lnk,"SELECT * FROM category");
									while($linha = mysqli_fetch_array($query)){
										$id_cat = $linha['id'];
										$categoria = $linha['nome'];?>
                                    	<option class="selS" value="<? echo $id_cat?>" <? if($id_cat==$id_category){echo "selected";}?>><? echo $categoria?></option>
                                    <? }?>	
                                </select>
							</div>
						</div>
						<div class="grupo linhaScroll">
							<div class="grupoEsq">Fotografia:</div>
							<div class="grupoDir">
								<div class="upload_file btY"><span id="FICHEIRO">SELECIONAR FICHEIRO</span>
								<input type="file" name="imagem" accept="image/*" onchange="lerFicheiros(this);">
								</div>
								<div class="linhaScroll">
									<table class="listagem">
										<thead>
										<tr>
											<th class="compMin">Logo</th>
			                                <th>Caminho</th>
										</tr>
										</thead>
										<tbody>
			                            <tr class="tabelaFundoI">
											<td><img src="<? echo $logo?>" class="img" alt="<? echo $logo?>"></td>
											<td>&nbsp;<? echo $logo?></td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div id="INF2" class="corpoCima none">
						<div class="grupo">
							<div class="grupoEsq">Texto:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="20" name="texto_en"><? echo $texto_en?></textarea>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div id="INF3" class="corpoCima none">
						<div class="grupo">
							<div class="grupoEsq">Texto:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="20" name="texto_fr"><? echo $texto_fr?></textarea>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div id="INF4" class="corpoCima none">
						<div class="grupo">
							<div class="grupoEsq">Texto:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="20" name="texto_es"><? echo $texto_es?></textarea>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/empresas/<? echo $id_world;?>';">CANCELAR</button>					
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
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/empresas/<? echo $id_world;?>';">VOLTAR</button>
		</div>
	</div>
</div>
<!-- -->
<script>
function lerFicheiros(input) {
    var nome = input.value;
	$('#FICHEIRO').html(nome);
}
$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
			url: "/admin/_empresa/empresa.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				data = data.replace(/^\s+|\s+$/g,"");
				if(data){
					mostrar('GUARDAR');
					window.history.pushState("object or string", "Title", "/admin/empresa/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});
function mudarTab(numero) {
	for (var i=4; i>0; i--) {
		if(i==numero){
			$("#TAB"+i).removeClass("tab-nao");
			$("#TAB"+i).addClass("tab-sim");
			$("#INF"+i).css("display","block");
		}
		else{
			$("#TAB"+i).removeClass("tab-sim");
			$("#TAB"+i).addClass("tab-nao");
			$("#INF"+i).css("display","none");
		}
	}
}
</script>
</body>
</html>