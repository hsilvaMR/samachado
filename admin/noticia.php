<?php $permissao='head'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Notícia</title>
	<? include '_head.php';?>
	<!-- CALENDARIO -->
	<link href="/admin/funcao/datepicker/jquery-ui.css" rel="stylesheet">
	<script src="/admin/funcao/datepicker/jquery-ui.js" type="text/javascript"></script>
	<!-- ORDENAR -->
	<script src="/admin/funcao/sortable/jquery-ui.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<?
	$url = $_SERVER['REQUEST_URI'];
	$urlPartes = explode("/", $url);
	$id = urldecode($urlPartes[3]);
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM noticia WHERE id='$id'")));}

	$sep=11;
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Nova";}?> Notícia<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/noticias">Notícias</a>
				<div class="ponto"></div>
				<a href="">Notícia</a>
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
					<input type="hidden" name="id" value="<? if($existe){ echo $id; }?>">
					<div id="INF1" class="corpoCima">
						<div class="grupo">
							<div class="grupoEsq">Titulo:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="titulo" value="<? echo $nome?>" autofocus>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Texto:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="20" name="noticia"><? echo $texto?></textarea>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Tipo:</div>
							<div class="grupoDir">
								<select class="seL" name="id_tipo">
                                	<? $query = mysqli_query($lnk,"SELECT * FROM tipo");
									while($linha = mysqli_fetch_array($query)){
										$id_tip = $linha['id'];
										$tipo = $linha['nome'];?>
                                    	<option class="selS" value="<? echo $id_tip?>" <? if($id_tip==$id_tipo){echo "selected";}?>><? echo $tipo?></option>
                                    <? }?>	
                                </select>
							</div>
						</div>
						<!--<div class="grupo">
							<div class="grupoEsq">Data de Criação:</div>
							<div class="grupoDir">
								<?if($criacao=='0000-00-00'){$criacao="";}?>
								<input type="text" class="inP" name="criacao" id="CALENDARIO" maxlength="10" value="<? echo $criacao?>" onchange="mudaCal1(this);">
							</div>
						</div>-->
						<div class="grupo">
							<div class="grupoEsq">Data de Publicação:</div>
							<div class="grupoDir">
								<?if($publicacao=='0000-00-00'){$publicacao="";}?>
								<input type="text" class="inP" name="publicacao" id="CALENDARIO2" maxlength="10" value="<? echo $publicacao?>"><!--onchange="mudaCal2(this);"-->
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Imagens:</div>
							<div class="grupoDir">
								<div class="upload_file btY"><span id="FICHEIRO">SELECIONAR FICHEIROS</span>
								<input type="file" name="imagem[]" accept="image/*"  onchange="lerFicheiros(this,'FICHEIRO');" multiple/>
								</div>
								<div class="linhaScroll">
									<table id="sortable" class="listagem">
										<thead>
										<tr>
											<th class="none"></th>
											<th class="compMin">Imagem</th>
			                                <th>Nome</th>
											<th>Opção</th>
										</tr>
										</thead>
										<tbody>
			                            <? $risca=1;
			                            $query = mysqli_query($lnk,"SELECT * FROM imagem WHERE id_noticia='$id' ORDER BY ordem ASC");
										while($linha = mysqli_fetch_array($query))
										{
											$id_foto = $linha["id"];
											$img = $linha["img"];
											if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
											$risca++; ?>
				                            <tr id="linha_<? echo $id_foto?>" class="tabelaMover <? echo $classe?>">
				                            	<td class="none"></td>
				                            	<td><img src="<? echo $img?>" class="img" alt="<? echo $img?>"></td>
												<td>&nbsp;<? echo $img?></td>
												<td>
													<a href="<?echo $img;?>" target="_bank" class="opcoes"><span class="lnr lnr-magnifier"></span>&nbsp;Ver</a>&nbsp;&nbsp;
													<?if(($id_fase && $id_fase<4) || ($tipo_user=='admin')){?><span class="opcoes" onclick="mostrar('APAGAR',<?echo $id_foto;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span><?}?>
												</td>
											</tr>
			                            <?}?>
										</tbody>
									</table>
								</div>
								<br>
								<p>Para encontrar imagens gratuitas e de qualidade pode procurar em <a href="https://pixabay.com/" class="opcoes" target="_bank">Pixabay</a> ou <a href="https://visualhunt.com/" class="opcoes" target="_bank">Visual Hunt</a>.</p>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div id="INF2" class="corpoCima none">
						<div class="grupo">
							<div class="grupoEsq">Titulo:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="titulo_en" value="<? echo $nome_en?>">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Texto:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="20" name="noticia_en"><? echo $texto_en?></textarea>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div id="INF3" class="corpoCima none">
						<div class="grupo">
							<div class="grupoEsq">Titulo:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="titulo_fr" value="<? echo $nome_fr?>">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Texto:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="20" name="noticia_fr"><? echo $texto_fr?></textarea>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div id="INF4" class="corpoCima none">
						<div class="grupo">
							<div class="grupoEsq">Titulo:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="titulo_es" value="<? echo $nome_es?>">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Texto:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="20" name="noticia_es"><? echo $texto_es?></textarea>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/noticias';">CANCELAR</button>
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
			<button type="button" class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/noticias';">VOLTAR</button>
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
			<button class="btV modalBt" name="sim" onclick="apagarF()">SIM</button>
			<button class="btA modalBt" name="nao" onclick="esconder('APAGAR');">NÃO</button>
		</div>
	</div>
</div>
<!-- -->
<script>
$(document).keyup(function(e) {
     if (e.keyCode == 27) { esconder('APAGAR'); }
});
function apagarF(){
	$.post("/admin/_noticia/js_delfoto.php",{ id:id_del }) 
    .done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });
}
$(function() {
	/*var publicacao = "<? echo $publicacao?>";
	publicacao = publicacao.replace("-",",");
	publicacao = publicacao.replace("-",",");
	$("#CALENDARIO").datepicker({ maxDate: new Date(publicacao) });*/
	/*var criacao = "<? echo $criacao?>";
	criacao = criacao.replace("-",",");
	criacao = criacao.replace("-",",");*/
	$("#CALENDARIO2").datepicker({ /*minDate: new Date(criacao),maxDate:0*/ });
});
/*function mudaCal1(input) {
    var criacao = input.value;
    criacao = criacao.replace("-",",");
	criacao = criacao.replace("-",",");
	$('#CALENDARIO2').datepicker('option', 'minDate', new Date(criacao));
}
function mudaCal2(input) {
    var publicacao = input.value;
    publicacao = publicacao.replace("-",",");
	publicacao = publicacao.replace("-",",");
	$('#CALENDARIO').datepicker('option', 'maxDate', new Date(publicacao));
}*/
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
			url: "/admin/_noticia/novo.php",
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
					window.history.pushState("object or string", "Title", "/admin/noticia/"+data);
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
// ORDENAR
$("#sortable tbody").sortable({
    opacity: 0.6, cursor: 'move',
    update: function() {
		var order = $(this).sortable("serialize")+'&tabela=imagem&campo=ordem';
		$.post("/admin/funcao/ordenar.php", order);
		$.notific8('Guardado com sucesso.', {heading: 'Guardado'});
    }
}).disableSelection();
</script>
</body>
</html>