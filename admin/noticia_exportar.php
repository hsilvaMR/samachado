<?php $permissao='head'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Exportar Notícias</title>
	<? include '_head.php';?>
	<!-- CALENDARIO -->
	<link href="/admin/funcao/datepicker/jquery-ui.css" rel="stylesheet">
	<script src="/admin/funcao/datepicker/jquery-ui.js" type="text/javascript"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=11; $sub=11.1; include '_menu.php'; ?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Exportar Notícias<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/noticias">Notícias</a>
				<div class="ponto"></div>
				<a href="">Exportar Notícias</a>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo">
					<div class="corpoCima">
						<div class="grupo">
							<div class="grupoEsq">Informação a exportar:</div>
							<div class="grupoDir">
								<div class="linhaScroll">
									<div class="teX">
										<div class="floatl margin-bottom10"><input type="checkbox" id="check1" class="RD" value="1" checked><label for="check1">&nbsp;</label>&nbsp;Título&nbsp;(PT)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check2" class="RD" value="1" checked><label for="check2">&nbsp;</label>&nbsp;Título&nbsp;(EN)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check3" class="RD" value="1" checked><label for="check3">&nbsp;</label>&nbsp;Título&nbsp;(FR)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check4" class="RD" value="1" checked><label for="check4">&nbsp;</label>&nbsp;Título&nbsp;(ES)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check5" class="RD" value="1" checked><label for="check5">&nbsp;</label>&nbsp;Texto&nbsp;(PT)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check6" class="RD" value="1" checked><label for="check6">&nbsp;</label>&nbsp;Texto&nbsp;(EN)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check7" class="RD" value="1" checked><label for="check7">&nbsp;</label>&nbsp;Texto&nbsp;(FR)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check8" class="RD" value="1" checked><label for="check8">&nbsp;</label>&nbsp;Texto&nbsp;(ES)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check9" class="RD" value="1" checked><label for="check9">&nbsp;</label>&nbsp;Tipo&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check10" class="RD" value="1" checked><label for="check10">&nbsp;</label>&nbsp;Criação&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check11" class="RD" value="1" checked><label for="check11">&nbsp;</label>&nbsp;Publicação&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check12" class="RD" value="1" checked><label for="check12">&nbsp;</label>&nbsp;Fotografia&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check13" class="RD" value="1" checked><label for="check13">&nbsp;</label>&nbsp;Online</div>
										<div class="clear"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Iniciadas apartir de:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="inicio" id="inicio" maxlength="10" value="" onchange="mudaCal1(this);">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Concluídas até:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="fim" id="fim" maxlength="10" value="" onchange="mudaCal2(this);">
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Tipo:</div>
							<div class="grupoDir">
								<select class="seL" id="id_tipo">
									<option class="selS" value="0">&nbsp;</option>
                                	<? $query = mysqli_query($lnk,"SELECT * FROM tipo ORDER BY nome ASC");
									while($linha = mysqli_fetch_array($query)){
										$id_tip = $linha['id'];
										$tipo = $linha['nome'];?>
                                    	<option class="selS" value="<? echo $id_tip?>"><? echo $tipo?></option>
                                    <? }?>	
                                </select>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Online:</div>
							<div class="grupoDir">
								<select class="seL" id="online">
									<option class="selS" value="2">&nbsp;</option>
									<option class="selS" value="1">Sim</option>
									<option class="selS" value="0">Não</option>
                                </select>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<button type="button" class="btV" name="exportar" onClick="exportar();">EXPORTAR</button>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/noticias';">CANCELAR</button>					
					</div>
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
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/noticias';">VOLTAR</button>
		</div>
	</div>
</div>
<!-- -->
<? $linha=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM noticia WHERE criacao!='0000-00-00' ORDER BY criacao ASC"));
$inicio = $linha["criacao"]; ?>
<script>
$(function() {
	var inicio = "<? echo $inicio?>";
	inicio = inicio.replace("-",",");
	inicio = inicio.replace("-",",");
	//$("#inicio").datepicker({ maxDate: new Date(inicio) });
	$("#inicio").datepicker({ minDate: new Date(inicio) });
	$("#fim").datepicker({ minDate: new Date(inicio) });
});
function mudaCal1(input) {
    var inicio = input.value;
    inicio = inicio.replace("-",",");
	inicio = inicio.replace("-",",");
	$('#fim').datepicker('option', 'minDate', new Date(inicio));
}
function mudaCal2(input) {
    var fim = input.value;
    fim = fim.replace("-",",");
	fim = fim.replace("-",",");
	$('#inicio').datepicker('option', 'maxDate', new Date(fim));
}
function exportar(){

	if($("#check1").prop('checked')){var check1=1;}else{var check1=0;};
	if($("#check2").prop('checked')){var check2=1;}else{var check2=0;};
	if($("#check3").prop('checked')){var check3=1;}else{var check3=0;};
	if($("#check4").prop('checked')){var check4=1;}else{var check4=0;};
	if($("#check5").prop('checked')){var check5=1;}else{var check5=0;};
	if($("#check6").prop('checked')){var check6=1;}else{var check6=0;};
	if($("#check7").prop('checked')){var check7=1;}else{var check7=0;};
	if($("#check8").prop('checked')){var check8=1;}else{var check8=0;};
	if($("#check9").prop('checked')){var check9=1;}else{var check9=0;};
	if($("#check10").prop('checked')){var check10=1;}else{var check10=0;};
	if($("#check11").prop('checked')){var check11=1;}else{var check11=0;};
	if($("#check12").prop('checked')){var check12=1;}else{var check12=0;};
	if($("#check13").prop('checked')){var check13=1;}else{var check13=0;};

	var inicio=$("#inicio").val();
	if(!inicio){inicio=0;}
	var fim=$("#fim").val();
	if(!fim){fim=0;}
	var id_tipo=$("#id_tipo").val();
	var online=$("#online").val();
	window.location.replace("_noticia/exportar/"+inicio+"/"+fim+"/"+id_tipo+"/"+online+"/"+check1+"/"+check2+"/"+check3+"/"+check4+"/"+check5+"/"+check6+"/"+check7+"/"+check8+"/"+check9+"/"+check10+"/"+check11+"/"+check12+"/"+check13);
}
</script>
</body>
</html>