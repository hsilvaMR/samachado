<?php $permissao='user'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Tarefa</title>
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
	$id_tarefa = urldecode($urlPartes[3]);
	$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id='$id_tarefa'"));
	$id_manda = $linha['id_emissor'];
	$id_faz = $linha['id_recetor'];
	$id_etapa = $linha['id_fase'];
	$id_processo = $linha['id_noticia'];
	$data = $linha['data'];
	if((!$id_processo) || ($data=='0000-00-00') || ($tipo_user=='user' &&  $id_faz!=$id_user)){ header('Location: /admin/tarefas'); }
	$id_admin=$id_user;
	extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM noticia WHERE id='$id_processo'")));
	if($tipo_user=='head' &&  $id_faz!=$id_admin && $id_admin!=$id_user){ header('Location: /admin/tarefas'); }
	$sep=4;
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? echo $nome;?><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/tarefas">Tarefas</a>
				<div class="ponto"></div>
				<a href="">Tarefa</a>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo">
					<?if($id_etapa>=4){?>
					<div class="tabs">
						<div id="TAB1" class="tab-sim" onClick="mudarTab(1);"><span class="DN1024">PT</span><span class="DB1024">Português</span></div>
						<div id="TAB2" class="tab-nao" onClick="mudarTab(2);"><span class="DN1024">EN</span><span class="DB1024">Inglês</span></div>
						<div id="TAB3" class="tab-nao" onClick="mudarTab(3);"><span class="DN1024">FR</span><span class="DB1024">Francês</span></div>
						<div id="TAB4" class="tab-nao" onClick="mudarTab(4);"><span class="DN1024">ES</span><span class="DB1024">Espanhol</span></div>
					</div>
					<?}?>
					<form id="FORMULARIO" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<? echo $id_tarefa; ?>">
					<input type="hidden" name="botao" id="BOTAO" value="guardar">
					<div id="INF1" class="corpoCima">
						<div class="grupo">
							<div class="grupoEsq">Titulo:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="titulo" value="<? echo $nome?>" id="text1" onkeyup="contar_tudo(1);" <?if($id_etapa==4 || $id_etapa==5){echo 'readonly';}else{echo 'autofocus';}?>>
								<span id="cont1">0 palavra, 0 caracter</span>
								<!--<label>O nome deve ser curto (max. 30 caracteres)</label>-->
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Texto:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="20" name="noticia" id="text2" onkeyup="contar_tudo(2);" <?if($id_etapa==4 || $id_etapa==5){echo 'readonly';}?>><? echo $texto?></textarea>
								<span id="cont2">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="grupo <?if($id_etapa==3 || $id_etapa==4 || $id_etapa==5){echo 'none';}?>">
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
						<div class="grupo <?if($id_etapa==3 || $id_etapa==4 || $id_etapa==5){echo 'none';}?>">
							<div class="grupoEsq">Data de Criação:</div>
							<div class="grupoDir">
								<?if($criacao=='0000-00-00'){$criacao="";}?>
								<input type="text" class="inP" name="criacao" id="CALENDARIO" maxlength="10" value="<? echo $criacao?>" onchange="mudaCal1(this);">
							</div>
						</div>
						<div class="grupo <?if($id_etapa==3 || $id_etapa==4 || $id_etapa==5){echo 'none';}?>">
							<div class="grupoEsq">Data de Publicação:</div>
							<div class="grupoDir">
								<?if($publicacao=='0000-00-00'){$publicacao="";}?>
								<input type="text" class="inP" name="publicacao" id="CALENDARIO2" maxlength="10" value="<? echo $publicacao?>" onchange="mudaCal2(this);">
							</div>
						</div>
						<div class="grupo <?if($id_etapa==3 || $id_etapa==4 || $id_etapa==5){echo 'none';}?>">
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
									<label>Carregue no mínimo 1 imagem (recomendado 3 imagens)</label>
								</div>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div id="INF2" class="corpoCima none">
						<div class="grupo">
							<div class="grupoEsq">Titulo:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="titulo_en" value="<? echo $nome_en?>" id="text3" onkeyup="contar(3);">
								<span id="cont3">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Texto:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="16" name="noticia_en" id="text4" onkeyup="contar(4);" maxlength="1100"><? echo $texto_en;?></textarea>
								<span id="cont4">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div id="INF3" class="corpoCima none">
						<div class="grupo">
							<div class="grupoEsq">Titulo:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="titulo_fr" value="<? echo $nome_fr?>" id="text5" onkeyup="contar(5);">
								<span id="cont5">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Texto:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="16" name="noticia_fr" id="text6" onkeyup="contar(6);" maxlength="1100"><? echo $texto_fr;?></textarea>
								<span id="cont6">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div id="INF4" class="corpoCima none">
						<div class="grupo">
							<div class="grupoEsq">Titulo:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="titulo_es" value="<? echo $nome_es?>" id="text7" onkeyup="contar(7);">
								<span id="cont7">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Texto:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="16" name="noticia_es" id="text8" onkeyup="contar(8);" maxlength="1100"><? echo $texto_es;?></textarea>
								<span id="cont8">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<?if($id_etapa!=1 && $id_etapa!=4){?><button type="button" class="btC" name="reprovar" onclick="mostrar('REPROVAR');">REPROVAR</button><?}?>
						<?if($id_etapa==6){?><button type="button" class="btG" name="finalizar" onclick="enviarFormulario();">GUARDAR E FINALIZAR</button><?}
						else{?><button type="button" class="btG" name="enviar" onclick="enviarFormulario();">GUARDAR E ENVIAR</button><?}?>
						<!--<input type="submit" class="btG" name="enviar" value="GUARDAR E ENVIAR"/>-->
						<button type="button" class="btV" name="guardar" onclick="guardarFormulario();">GUARDAR</button>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/fichas';">CANCELAR</button>		
					</div>
					<!-- MODAL -->
					<div id="REPROVAR" class="modal">
						<div class="modalFundo" onClick="esconder('REPROVAR');"></div>
						<span class="modalClose lnr lnr-cross-circle" onClick="esconder('REPROVAR');"></span>
						<div class="modalSize">
							<div class="modalHead">Reprovar</div>
							<div class="modalBody">
								Tem a certeza que deseja reprovar?
								<textarea class="teX" rows="5" id="NOTA" name="nota" placeholder="Indique as razões que o levaram a reprovar... mínimo 20 caracteres"></textarea>
								<div class="margin-top20 <?if($id_etapa!=6){echo 'none';}?>">
									Devolver para a etapa?
									<select class="seL" name="id_etapa_rep">
	                                	<? $query = mysqli_query($lnk,"SELECT * FROM etapa");
										while($linha = mysqli_fetch_array($query)){
											$id_eta = $linha['id'];
											$descricao_eta = $linha['descricao'];
											if($id_eta!=6){?>
	                                    	<option class="selS" value="<? echo $id_eta?>"><? echo "Etapa ".$id_eta." - ".$descricao_eta?></option>
	                                    	<? }
	                                    }?>	
	                                </select>
								</div>
							</div>
							<div class="modalFoot">
								<button type="button" class="btV modalBt" name="sim" onclick="reprovarFormulario()">GUARDAR E REPROVAR</button>
								<button type="button" class="btA modalBt" name="nao" onclick="esconder('REPROVAR');">CANCELAR</button>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</article>
<? include '_footer.php';?>
<!-- MODALS -->
<div id="REPROVADO" class="modal">
	<div class="modalFundo" onClick="window.location.href='/admin/tarefas';"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="window.location.href='/admin/tarefas';"></span>
	<div class="modalSize">
		<div class="modalHead">Reprovado</div>
		<div class="modalBody">Guardado e reprovado com sucesso.</div>
		<div class="modalFoot">
			<button type="button" class="btV modalBt" name="nao" onclick="window.location.href='/admin/tarefas';">FECHAR</button>
			<button type="button" class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/tarefas';">VOLTAR</button>
		</div>
	</div>
</div>
<div id="ENVIAR" class="modal">
	<div class="modalFundo" onClick="window.location.href='/admin/tarefas';"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="window.location.href='/admin/tarefas';"></span>
	<div class="modalSize">
		<div class="modalHead">Enviado</div>
		<div class="modalBody">Guardado e enviado com sucesso.</div>
		<div class="modalFoot">
			<button type="button" class="btV modalBt" name="nao" onclick="window.location.href='/admin/tarefas';">FECHAR</button>
			<button type="button" class="btC modalBt" name="voltar" onClick="window.location.href='/admin/tarefas';">VOLTAR</button>
		</div>
	</div>
</div>
<div id="FINAL" class="modal">
	<div class="modalFundo" onClick="window.location.href='/admin/fichas';"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="window.location.href='/admin/fichas';"></span>
	<div class="modalSize">
		<div class="modalHead">Finalizado</div>
		<div class="modalBody">Guardado e finalizado com sucesso.</div>
		<div class="modalFoot" id="FFINAL">
			<a href="/overview/208" target="_bank"><button type="button" class="btV modalBt" name="voltar" onClick="window.location.href='/admin/news';">VER NOTÍCIA ONLINE</button></a>
			<button type="button" class="btA modalBt" name="nao" onclick="window.location.href='/admin/noticias';">FECHAR</button>
		</div>
	</div>
</div>
<div id="GUARDAR" class="modal">
	<div class="modalFundo" onClick="window.location.reload();"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="window.location.reload();"></span>
	<div class="modalSize">
		<div class="modalHead">Guardado</div>
		<div class="modalBody">Guardado com sucesso.</div>
		<div class="modalFoot">
			<button type="button" class="btV modalBt" name="nao" onclick="window.location.reload();">FECHAR</button>
			<button type="button" class="btC modalBt" name="voltar" onClick="window.location.href='/admin/tarefas';">VOLTAR</button>
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
			<button type="button" class="btV modalBt" name="sim" onclick="apagarF()">SIM</button>
			<button type="button" class="btA modalBt" name="nao" onclick="esconder('APAGAR');">NÃO</button>
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
function lerFicheiros(input,id) {
    var quantidade = input.files.length;
    //var nome = input.value;
    if(quantidade==1){$('#'+id).html('1 FICHEIRO');}
    else{$('#'+id).html(quantidade+' FICHEIROS');}
}
function reprovarFormulario(){
	var nota=$("#NOTA").val();
	nota = nota.length;
	if(nota<20){
		$.notific8('Explique melhor a razão pela qual está a reprovar.', {heading: 'Erro', theme: 'ruby'});
	}else{
		$("#BOTAO").val('reprovar');
		esconder('REPROVAR');
		$("#FORMULARIO").submit();
	}
}
function enviarFormulario(){
	$("#BOTAO").val('enviar');
	$("#FORMULARIO").submit();
}
function guardarFormulario(){
	$("#BOTAO").val('guardar');
	$("#FORMULARIO").submit();
}
$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		mostrar('LOADING');
		e.preventDefault();
		$.ajax({
			url: "/admin/_tarefa/trabalho.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				esconder('LOADING');
				data = data.replace(/^\s+|\s+$/g,"");
				if(data){
					if (!isNaN(data)) {
					    // se for numero (#id)
					    mostrar('FINAL');
					    $('#FFINAL').html('<a href="/overview/'+data+'" target="_bank"><button type="button" class="btV modalBt" name="voltar" onClick="window.location.href=\'/admin/fichas\';">VER FICHA ONLINE</button></a><button type="button" class="btA modalBt" name="nao" onclick="window.location.href=\'/admin/fichas\';">FECHAR</button>');
					}else{
						if(data=='TM'){mostrar('ENVIAR');}
						if(data=='TF'){mostrar('GUARDAR');}
						if(data=='TC'){mostrar('REPROVADO');}
						if(data!='TM' && data!='TF' && data!='TC'){$.notific8(data, {heading: 'Erro', theme: 'ruby'});}
					}
					//$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
					//window.history.pushState("object or string", "Title", "/admin/tarefa/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});
$(function() {
	var publicacao = "<? echo $publicacao?>";
	publicacao = publicacao.replace("-",",");
	publicacao = publicacao.replace("-",",");
	$("#CALENDARIO").datepicker({ maxDate: new Date(publicacao) });
	var criacao = "<? echo $criacao?>";
	criacao = criacao.replace("-",",");
	criacao = criacao.replace("-",",");
	$("#CALENDARIO2").datepicker({ minDate: new Date(criacao) });
});
function mudaCal1(input) {
    var inicio = input.value;
    inicio = inicio.replace("-",",");
	inicio = inicio.replace("-",",");
	$('#CALENDARIO2').datepicker('option', 'minDate', new Date(inicio));
}
function mudaCal2(input) {
    var fim = input.value;
    fim = fim.replace("-",",");
	fim = fim.replace("-",",");
	$('#CALENDARIO').datepicker('option', 'maxDate', new Date(fim));
}
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
$(document).ready(function() {
	contar_tudo(1);
	contar_tudo(2);
	contar(3);
	contar(4);
	contar(5);
	contar(6);
	contar(7);
	contar(8);
});
</script>
</body>
</html>