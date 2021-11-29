<?php $permissao='admin'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Exportar Portfólio</title>
	<? include '_head.php';?>
	<!-- CALENDARIO -->
	<link href="/admin/funcao/datepicker/jquery-ui.css" rel="stylesheet">
	<script src="/admin/funcao/datepicker/jquery-ui.js" type="text/javascript"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=13; $sub=13.1; include '_menu.php'; ?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Exportar Portfólio<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/portfolios">Fichas de Obra</a>
				<div class="ponto"></div>
				<a href="">Exportar Portfólio</a>
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
										<div class="floatl margin-bottom10"><input type="checkbox" id="check1" class="RD" value="1" checked><label for="check1">&nbsp;</label>&nbsp;Referência&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check2" class="RD" value="1" checked><label for="check2">&nbsp;</label>&nbsp;Nome&nbsp;(PT)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check3" class="RD" value="1" checked><label for="check3">&nbsp;</label>&nbsp;Nome&nbsp;(EN)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check4" class="RD" value="1" checked><label for="check4">&nbsp;</label>&nbsp;Nome&nbsp;(FR)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check5" class="RD" value="1" checked><label for="check5">&nbsp;</label>&nbsp;Nome&nbsp;(ES)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check6" class="RD" value="1" checked><label for="check6">&nbsp;</label>&nbsp;Dono&nbsp;(PT)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check7" class="RD" value="1" checked><label for="check7">&nbsp;</label>&nbsp;Dono&nbsp;(EN)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check8" class="RD" value="1" checked><label for="check8">&nbsp;</label>&nbsp;Dono&nbsp;(FR)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check9" class="RD" value="1" checked><label for="check9">&nbsp;</label>&nbsp;Dono&nbsp;(ES)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check10" class="RD" value="1" checked><label for="check10">&nbsp;</label>&nbsp;Texto&nbsp;(PT)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check11" class="RD" value="1" checked><label for="check11">&nbsp;</label>&nbsp;Texto&nbsp;(EN)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check12" class="RD" value="1" checked><label for="check12">&nbsp;</label>&nbsp;Texto&nbsp;(FR)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check13" class="RD" value="1" checked><label for="check13">&nbsp;</label>&nbsp;Texto&nbsp;(ES)&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check14" class="RD" value="1" checked><label for="check14">&nbsp;</label>&nbsp;Área&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check15" class="RD" value="1" checked><label for="check15">&nbsp;</label>&nbsp;Prazo&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check16" class="RD" value="1" checked><label for="check16">&nbsp;</label>&nbsp;Pisos&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check17" class="RD" value="1" checked><label for="check17">&nbsp;</label>&nbsp;Pisos&nbsp;subterrâneos&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check18" class="RD" value="1" checked><label for="check18">&nbsp;</label>&nbsp;Valor&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check19" class="RD" value="1" checked><label for="check19">&nbsp;</label>&nbsp;Inicio&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check20" class="RD" value="1" checked><label for="check20">&nbsp;</label>&nbsp;Fim&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check21" class="RD" value="1" checked><label for="check21">&nbsp;</label>&nbsp;Estado&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check22" class="RD" value="1" checked><label for="check22">&nbsp;</label>&nbsp;Categoria&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check23" class="RD" value="1" checked><label for="check23">&nbsp;</label>&nbsp;Morada&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check24" class="RD" value="1" checked><label for="check24">&nbsp;</label>&nbsp;País&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check25" class="RD" value="1" checked><label for="check25">&nbsp;</label>&nbsp;Fotografias&nbsp;&nbsp;&nbsp;&nbsp;</div>
										<div class="floatl margin-bottom10"><input type="checkbox" id="check26" class="RD" value="1" checked><label for="check26">&nbsp;</label>&nbsp;Online</div>
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
							<div class="grupoEsq">Categoria:</div>
							<div class="grupoDir">
								<select class="seL" id="id_categoria">
									<option class="selS" value="0">&nbsp;</option>
                                	<? $query = mysqli_query($lnk,"SELECT * FROM categoria ORDER BY nome ASC");
									while($linha = mysqli_fetch_array($query)){
										$id_cat = $linha['id'];
										$categoria = $linha['nome'];?>
                                    	<option class="selS" value="<? echo $id_cat?>"><? echo $categoria?></option>
                                    <? }?>	
                                </select>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Estado:</div>
							<div class="grupoDir">
								<select class="seL" id="id_estado">
									<option class="selS" value="0">&nbsp;</option>
                                	<? $query = mysqli_query($lnk,"SELECT * FROM estado ORDER BY nome ASC");
									while($linha = mysqli_fetch_array($query)){
										$id_est = $linha['id'];
										$estado = $linha['nome'];?>
                                    	<option class="selS" value="<? echo $id_est?>"><? echo $estado?></option>
                                    <? }?>	
                                </select>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">País:</div>
							<div class="grupoDir">
								<select class="seL" id="id_pais">
									<option class="selS" value="0">&nbsp;</option>
                                	<? $query = mysqli_query($lnk,"SELECT * FROM pais WHERE online=1 ORDER BY nome_pt ASC");
									while($linha = mysqli_fetch_array($query)){
										$id_pai = $linha['id'];
										$pais = $linha['nome_pt'];?>
                                    	<option class="selS" value="<? echo $id_pai?>"><? echo $pais?></option>
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
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/portfolios';">CANCELAR</button>					
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
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/portfolios';">VOLTAR</button>
		</div>
	</div>
</div>
<!-- -->
<? $linha=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE inicio!='0000-00-00' ORDER BY inicio ASC"));
$inicio = $linha["inicio"]; ?>
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
	if($("#check14").prop('checked')){var check14=1;}else{var check14=0;};
	if($("#check15").prop('checked')){var check15=1;}else{var check15=0;};
	if($("#check16").prop('checked')){var check16=1;}else{var check16=0;};
	if($("#check17").prop('checked')){var check17=1;}else{var check17=0;};
	if($("#check18").prop('checked')){var check18=1;}else{var check18=0;};
	if($("#check19").prop('checked')){var check19=1;}else{var check19=0;};
	if($("#check20").prop('checked')){var check20=1;}else{var check20=0;};
	if($("#check21").prop('checked')){var check21=1;}else{var check21=0;};
	if($("#check22").prop('checked')){var check22=1;}else{var check22=0;};
	if($("#check23").prop('checked')){var check23=1;}else{var check23=0;};
	if($("#check24").prop('checked')){var check24=1;}else{var check24=0;};
	if($("#check25").prop('checked')){var check25=1;}else{var check25=0;};
	if($("#check26").prop('checked')){var check26=1;}else{var check26=0;};

	var inicio=$("#inicio").val();
	var fim=$("#fim").val();
	var id_categoria=$("#id_categoria").val();
	var id_estado=$("#id_estado").val();
	var id_pais=$("#id_pais").val();
	var online=$("#online").val();
	window.location.replace("_portfolio/exportar/"+inicio+"/"+fim+"/"+id_categoria+"/"+id_estado+"/"+id_pais+"/"+online+"/"+check1+"/"+check2+"/"+check3+"/"+check4+"/"+check5+"/"+check6+"/"+check7+"/"+check8+"/"+check9+"/"+check10+"/"+check11+"/"+check12+"/"+check13+"/"+check14+"/"+check15+"/"+check16+"/"+check17+"/"+check18+"/"+check19+"/"+check20+"/"+check21+"/"+check22+"/"+check23+"/"+check24+"/"+check25+"/"+check26);
}
</script>
</body>
</html>