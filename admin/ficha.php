<?php $permissao='head'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Ficha de Obra</title>
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
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE id='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM processo WHERE id='$id'")));}
	else{ header('Location: /admin/fichas'); }
	
	$sep=2;
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Nova";}?> Ficha de Obra <?if($id_etapa!=4 && $id_etapa!=5){?><a href="../../mpdf/PT/<? echo $id;?>/processo"><small>Ficha em PDF</small></a><?}?><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/fichas">Fichas de Obra</a>
				<div class="ponto"></div>
				<a href="">Ficha de Obra</a>
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
							<div class="grupoEsq">Referencia:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="referencia" value="<? echo $referencia?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Processo:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="processo" value="<? echo $processo?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Nome:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="nome" value="<? echo $nome?>" id="text1" autofocus onkeyup="contar(1);">
								<span id="cont1">0 palavra, 0 caracter</span>
								<br>
								<input type="checkbox" name="escuro" id="escuro" class="RD" value="1" <?if($escuro){echo "checked";}?>><label for="escuro" class="margin-top10">&nbsp;</label>&nbsp;Nome escuro
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Dono:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="dono" value="<? echo $dono?>" id="text2" onkeyup="contar(2);">
								<span id="cont2">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Categoria:</div>
							<div class="grupoDir">
								<select class="seL" name="id_categoria">
                                	<? $query = mysqli_query($lnk,"SELECT * FROM categoria");
									while($linha = mysqli_fetch_array($query)){
										$id_cat = $linha['id'];
										$categoria = $linha['nome'];?>
                                    	<option class="selS" value="<? echo $id_cat?>" <? if($id_cat==$id_categoria){echo "selected";}?>><? echo $categoria?></option>
                                    <? }?>	
                                </select>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Área (m&sup2;):</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="area" value="<? echo $area?>">
								<span>Se não se aplicar, coloque 0</span>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Prazo (meses):</div>
							<div class="grupoDir">
								<?if($prazo=='0'){$prazo="";}?>
								<input type="number" class="inP" name="prazo" step="1" value="<? echo $prazo?>">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Pisos (abaixo do solo):</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="subpiso" value="<? echo $subpiso?>">
								<span>Se não se aplicar, coloque 0</span>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Pisos (acima do solo):</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="piso" value="<? echo $piso?>">
								<span>Se não se aplicar, coloque 0</span>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Inicio:</div>
							<div class="grupoDir">
								<?if($inicio=='0000-00-00'){$inicio="";}?>
								<input type="text" class="inP" name="inicio" id="CALENDARIO" maxlength="10" value="<? echo $inicio?>" onchange="mudaCal1(this);">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Fim:</div>
							<div class="grupoDir">
								<?if($fim=='0000-00-00'){$fim="";}?>
								<input type="text" class="inP" name="fim" id="CALENDARIO2" maxlength="10" value="<? echo $fim?>" onchange="mudaCal2(this);">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Estado:</div>
							<div class="grupoDir">
								<select class="seL" name="id_estado">
                                	<? $query = mysqli_query($lnk,"SELECT * FROM estado ORDER BY nome ASC");
									while($linha = mysqli_fetch_array($query)){
										$id_est = $linha['id'];
										$estado = $linha['nome'];?>
                                    	<option class="selS" value="<? echo $id_est?>" <? if($id_est==$id_estado){echo "selected";}?>><? echo $estado?></option>
                                    <? }?>	
                                </select>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Valor:</div>
							<div class="grupoDir">
								<input type="number" class="inP" name="valor" value="<? echo $valor?>">
								<input type="checkbox" name="oculto" id="oculto" class="RD" value="1" <?if($oculto){echo "checked";}?>><label for="oculto" class="margin-top10">&nbsp;</label>&nbsp;Ocultar valor
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Moeda:</div>
							<div class="grupoDir">
								<select class="seL" name="id_moeda">
                                	<? $query = mysqli_query($lnk,"SELECT * FROM moeda");
									while($linha = mysqli_fetch_array($query)){
										$id_moe = $linha['id'];
										$moeda = $linha['nome'];?>
                                    	<option class="selS" value="<? echo $id_moe?>" <? if($id_moe==$id_moeda){echo "selected";}?>><? echo $moeda?></option>
                                    <? }?>	
                                </select>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Morada:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="3" name="morada"><? echo $morada?></textarea>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">País:</div>
							<div class="grupoDir">
								<select class="seL" name="id_pais">
                                	<? $query = mysqli_query($lnk,"SELECT * FROM pais WHERE online=1 ORDER BY nome_pt ASC");
									while($linha = mysqli_fetch_array($query)){
										$id_pai = $linha['id'];
										$pais = $linha['nome_pt'];?>
                                    	<option class="selS" value="<? echo $id_pai?>" <? if($id_pai==$id_pais){echo "selected";}?>><? echo $pais?></option>
                                    <? }?>	
                                </select>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Latitude:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="latitude" value="<? echo $latitude?>">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Longitude:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="longitude" value="<? echo $longitude?>">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Descrição:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="20" name="descricao" id="text3" onkeyup="contar(3);"><? echo $descricao?></textarea>
								<span id="cont3">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Fotografias:</div>
							<div class="grupoDir">
								<div class="upload_file btY"><span id="FICHEIRO">SELECIONAR FICHEIROS</span>
								<input type="file" name="imagem[]" accept="image/*"  onchange="lerFicheiros(this,'FICHEIRO');" multiple/>
								</div>
								<div class="linhaScroll">
									<table id="sortable" class="listagem">
										<thead>
										<tr>
											<th class="none"></th>
											<th class="compMin">Fundo&nbsp;&nbsp;</th>
			                                <th>Nome</th>
											<th>Capa</th>
											<?if(!$ficha){?><th>Opção</th><?}?>
										</tr>
										</thead>
										<tbody>
			                            <? $risca=1;
			                            $query = mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id' AND tipo='vertical' ORDER BY ordem ASC");
										while($linha = mysqli_fetch_array($query))
										{
											$id_foto = $linha["id"];
											$img = $linha["img"];
											$capa = $linha["capa"];
											if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
											$risca++; ?>
				                            <tr id="linha_<? echo $id_foto?>" class="<?if(!$ficha){echo 'tabelaMover';}?> <? echo $classe?>">
				                            	<td class="none"></td>
				                            	<td><a href="<? echo $img?>" target="_bank"><img src="<? echo $img?>" class="img" alt="<? echo $img?>"></a></td>
												<td>&nbsp;<? echo $img?></td>
												<td>
													<input type="radio" id="capa<?echo $id_foto;?>" name="radiobutton" class="RD" value="1" onClick="onunico('<?echo $id_foto;?>')" <?if($capa){echo "checked";}?> <?if($ficha){echo "disabled";}?>>
				          							<label for="capa<?echo $id_foto;?>">&nbsp;</label>
												</td>
												<?if(!$ficha){?>
													<td>
														<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id_foto;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
													</td>
												<?}?>
											</tr>
			                            <?}?>
										</tbody>
									</table>
									<table id="sortable2" class="listagem">
										<thead>
										<tr>
											<th class="none"></th>
											<th class="compMin">Galeria</th>
			                                <th>Nome</th>
											<th>Capa</th>
											<?if(!$ficha){?><th>Opção</th><?}?>
										</tr>
										</thead>
										<tbody>
			                            <? $risca=1;
			                            $query = mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id' AND tipo='horizontal' ORDER BY ordem ASC");
										while($linha = mysqli_fetch_array($query))
										{
											$id_foto = $linha["id"];
											$img = $linha["img"];
											$capa = $linha["capa"];
											if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
											$risca++; ?>
				                            <tr id="linha_<? echo $id_foto?>" class="<?if(!$ficha){echo 'tabelaMover';}?> <? echo $classe?>">
				                            	<td class="none"></td>
				                            	<td><a href="<? echo $img?>" target="_bank"><img src="<? echo $img?>" class="img" alt="<? echo $img?>"></a></td>
												<td>&nbsp;<? echo $img?></td>
												<td>
				                                	<input type="radio" id="capa<?echo $id_foto;?>" name="radiobutton" class="RD" value="1" onClick="onunico('<?echo $id_foto;?>')" <?if($capa)echo "checked";?> <?if($ficha){echo "disabled";}?>>
				          							<label for="capa<?echo $id_foto;?>">&nbsp;</label>
												</td>
												<?if(!$ficha){?>
													<td>
														<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id_foto;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
													</td>
												<?}?>
											</tr>
			                            <?}?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="clear"></div>
							<div class="grupo margin-top20">
								<div class="grupoEsq"></div>
								<div class="grupoDir">
									<a href="../../mpdf/PT/<? echo $id;?>/processo" class="opcoes">Para ver estado atual da ficha clique aqui</a>
								</div>
							</div>
						<div class="clear"></div>			
					</div>
					<div id="INF2" class="corpoCima none">
						<div class="grupo">
							<div class="grupoEsq">Nome:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="nome_en" value="<? echo $nome_en?>" id="text4" onkeyup="contar(4);">
								<span id="cont4">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Dono:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="dono_en" value="<? echo $dono_en?>" id="text5" onkeyup="contar(5);">
								<span id="cont5">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Descrição:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="20" name="descricao_en" id="text6" onkeyup="contar(6);"><? echo $descricao_en;?></textarea>
								<span id="cont6">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div id="INF3" class="corpoCima none">
						<div class="grupo">
							<div class="grupoEsq">Nome:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="nome_fr" value="<? echo $nome_fr?>" id="text7" onkeyup="contar(7);">
								<span id="cont7">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Dono:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="dono_fr" value="<? echo $dono_fr?>" id="text8" onkeyup="contar(8);">
								<span id="cont8">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Descrição:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="20" name="descricao_fr" id="text9" onkeyup="contar(9);"><? echo $descricao_fr;?></textarea>
								<span id="cont9">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div id="INF4" class="corpoCima none">
						<div class="grupo">
							<div class="grupoEsq">Nome:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="nome_es" value="<? echo $nome_es?>" id="text10" onkeyup="contar(10);">
								<span id="cont10">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Dono:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="dono_es" value="<? echo $dono_es?>" id="text11" onkeyup="contar(11);">
								<span id="cont11">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Descrição:</div>
							<div class="grupoDir">
								<textarea class="teX" rows="20" name="descricao_es" id="text12" onkeyup="contar(12);"><? echo $descricao_es;?></textarea>
								<span id="cont12">0 palavra, 0 caracter</span>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<?if($ficha){?>
							<!--<a href="/admin/categoria"><small>nova categoria</small></a>--><button type="button" class="btA" name="voltar" onClick="window.location.href='/admin/fichas';">VOLTAR</button>
						<?}else{?>
							<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
							<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/fichas';">CANCELAR</button>
						<?}?>		
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
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/fichas';">VOLTAR</button>
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
function onunico(id){
	$.post("/admin/_ficha/js_onunico.php",{ id:id })
	.done(function( data ){
		var jsonRetorna = $.parseJSON(data);
		if(jsonRetorna=='TM'){$.notific8('Guardado com sucesso.', {heading: 'Guardado'});}
    });
}
function apagarF(){
	$.post("/admin/_ficha/js_delfoto.php",{ id:id_del }) 
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
			url: "/admin/_ficha/novo.php",
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
					window.history.pushState("object or string", "Title", "/admin/ficha/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});
$(function() {
	var fim = "<? echo $fim?>";
	fim = fim.replace("-",",");
	fim = fim.replace("-",",");
	$("#CALENDARIO").datepicker({ maxDate: new Date(fim) });
	var inicio = "<? echo $inicio?>";
	inicio = inicio.replace("-",",");
	inicio = inicio.replace("-",",");
	$("#CALENDARIO2").datepicker({ minDate: new Date(inicio) });
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
<?if(!$ficha){?>
$("#sortable tbody").sortable({
    opacity: 0.6, cursor: 'move',
    update: function() {
		var order = $(this).sortable("serialize")+'&tabela=galeria&campo=ordem';
		$.post("/admin/funcao/ordenar.php", order);
		$.notific8('Guardado com sucesso.', {heading: 'Guardado'});
    }
}).disableSelection();
$("#sortable2 tbody").sortable({
    opacity: 0.6, cursor: 'move',
    update: function() {
		var order = $(this).sortable("serialize")+'&tabela=galeria&campo=ordem';
		$.post("/admin/funcao/ordenar.php", order);
		$.notific8('Guardado com sucesso.', {heading: 'Guardado'});
    }
}).disableSelection();
<?}?>
$(document).ready(function() {
	contar(1);
	contar(2);
	contar(3);
	contar(4);
	contar(5);
	contar(6);
	contar(7);
	contar(8);
	contar(9);
	contar(10);
	contar(11);
	contar(12);
});
</script>
</body>
</html>