<?php $permissao='head'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Notícias</title>
	<? include '_head.php';?>
	<!-- PAGINAR -->
  	<link href="/admin/funcao/datatables/jquery.dataTables.css" rel="stylesheet">
	<script src="/admin/funcao/datatables/jquery.dataTables.min.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=11; $sub=11.1; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Todas as Notícias<!--<a href="/admin/homepage"><small>nova homepage</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Notícias</a>
			</div>
		</div>
		<div class="linha">
			<? if($tipo_user=='admin'){$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia"));
				$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia"));}
			else{$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id_user='$id_user'"));
				$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id_user='$id_user'"));}
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna4">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-list iconH4"></span>
					</div>
					<div class="subH4">NOTÍCIAS</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? if($tipo_user=='admin'){$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia"));
				$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id_fase = 1"));}
			else{$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id_user='$id_user'"));
				$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id_user='$id_user' AND id_fase = 1"));}
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna4">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteAmarelo"><? echo $num_per?></h4>
						<span class="lnr lnr-thumbs-down iconH4"></span>
					</div>
					<div class="subH4">NO INÍCIO</div>
					<div class="barraFundo"><div class="barraAmarelo" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? if($tipo_user=='admin'){$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia"));
				$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id_fase>1"));}
			else{$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id_user='$id_user'"));
				$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id_user='$id_user' AND id_fase>1"));}
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna4">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteAzul"><? echo $num_per?></h4>
						<span class="lnr lnr-thumbs-up iconH4"></span>
					</div>
					<div class="subH4">EM PROCESSO</div>
					<div class="barraFundo"><div class="barraAzul" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? if($tipo_user!='admin'){
			if($tipo_user=='admin'){$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia"));
				$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id_fase=0"));}
			else{$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id_user='$id_user'"));
				$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id_user='$id_user' AND id_fase=0"));}
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna4">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $num_per?></h4>
						<span class="lnr lnr-layers iconH4"></span>
					</div>
					<div class="subH4">CONCLUÍDAS</div>
					<div class="barraFundo"><div class="barraVermelho" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? }else{ $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id_fase=0")); ?>
			<div class="coluna4">
				<div class="dadosF">
					<span class="lnr lnr-cloud-download dadosI"></span>
					<div class="dadosN"><? echo $numero?></div>
					<div class="dadosT">NOTÍCIAS</div>
					<a href="/admin/noticia_exportar">
						<div class="dadosV">
							<span class="dadosL">EXPORTAR</span>
							<span class="lnr lnr-arrow-right-circle dadosR"></span>
						</div>
					</a>
				</div>
			</div>
			<? } ?>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo tabelaBorda">
					<div class="tabelaHead">NOTÍCIAS</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th class="none"></th>
								<th class="compMin">#&ensp;</th>
								<th class="compMin">Fotografia</th>
                                <th>Titulo</th>
								<th>Responsável</th>
								<th>Estado</th>
								<th>Enviar email</th>
								<th>Destaque</th>
								<th>Online</th>
								<th>Opção</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            if($tipo_user=='admin'){$query = mysqli_query($lnk,"SELECT * FROM noticia ORDER BY id DESC");}
							else{$query = mysqli_query($lnk,"SELECT * FROM noticia WHERE id_user='$id_user' ORDER BY id DESC");}
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$id_fase = $linha["id_fase"];
								$id_responsavel = $linha["id_user"];
								$titulo = $linha["nome"];
								$destaque = $linha["destaque"];
								$online = $linha["online"];
								$linha1 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id_responsavel'"));
								$nome_resp = $linha1["nome"];
								$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fase WHERE id='$id_fase'"));
								$dias = $linha2['dias'];	
								$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id_noticia='$id' AND id_fase='$id_fase'"));
								$id_recetor = $linha3["id_recetor"];
								$data = $linha3["data"];
								if($data && $id_fase){
									$prazo1 = $dias;
									$aviso1 = date('Y-m-d', strtotime("+".$prazo1." days",strtotime($data)));
									$prazo2 = $dias+$prazo1;
									$aviso2 = date('Y-m-d', strtotime("+".$prazo2." days",strtotime($data)));
									$hoje = date('Y-m-d');
									if($hoje<=$aviso1){$estado='verde';}
									if($aviso1<$hoje && $hoje<=$aviso2){$estado='amarelo';}
									if($aviso2<$hoje){$estado='vermelho';}
									$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id_recetor'"));
									$nome_util = $linha4["nome"];
								}
								$label1='';$label3='';
								if($linha["criacao"]=='0000-00-00' || $linha["publicacao"]=='0000-00-00'){
									$label1 = 'Faltam&nbsp;Dados';
								}
								if($linha["nome_en"]=='' || $linha["nome_fr"]=='' || $linha["nome_es"]=='' || $linha["texto_en"]=='' || $linha["texto_fr"]=='' || $linha["texto_es"]==''){
									$label3 = "Faltam&nbsp;Traduções";
								}
								//$estado = str_replace(" ", "&nbsp;", $estado);
								$linha5 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM imagem WHERE id_noticia='$id' ORDER BY ordem ASC"));
								$img = $linha5["img"];
								if(!$img){ $img="/admin/icon/default.jpg"; }
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
	                            	<td class="none"></td>
	                            	<td><a href="/admin/noticia/<?echo $id;?>" class="opcoes"><? echo $id?></a></td>
	                            	<td><img src="<? echo $img?>" class="img"></td>
									<td><? echo $titulo?></td>
									<td><? echo $nome_resp?></td>
									<td>
										<!-- labelVermelho labelAmarelo labelAzul labelCinza labelRoxo labelVerde -->
										<?if($id_fase && $estado=='verde'){?><span class="labelVerde"><? echo "Fase ".$id_fase." - ".$nome_util; ?></span><?}?>
	                                	<?if($id_fase && $estado=='amarelo'){?><span class="labelAmarelo"><? echo "Fase ".$id_fase." - ".$nome_util; ?></span><?}?>
	                                	<?if($id_fase && $estado=='vermelho'){?><span class="labelVermelho"><? echo "Fase ".$id_fase." - ".$nome_util; ?></span><?}?>
	                                	<?if($id_fase && !$id_recetor){?><span class="labelCinza">Pendente</span><?}?>
	                                	<?if(!$id_fase && !$label1 && !$label3){?><a href="/new/0/<? echo $id; ?>" target="_bank"><span class="labelVerde">Completa</span></a><?}?>
	                                	<?if(!$id_fase && $label1){?><span class="labelAmarelo"><? echo $label1; ?></span><?}?>
	                                	<?if(!$id_fase && $label3){?><span class="labelVermelho"><? echo $label3; ?></span><?}?>
									</td>
									<td>
										<!-- labelVermelho labelAmarelo labelAzul labelCinza labelRoxo labelVerde -->
										<span class="labelVerde cursor-pointer" onclick="enviarEmail('<? echo $id?>','eu');">Para&nbsp;Mim</span>
	                                	<span class="labelAmarelo cursor-pointer" onclick="mostrar('SUBSCRITORES',<?echo $id;?>);">Para&nbsp;Subscritores</span>
									</td>
									<td>
	                                	<input type="checkbox" id="destaque<?echo $id;?>" class="RD" value="1" onClick="destaque('<?echo $id;?>')" <?if($destaque)echo "checked";?>>
	          							<label for="destaque<?echo $id;?>">&nbsp;</label>
									</td>
	                                <td>
	                                	<input type="checkbox" id="check<?echo $id;?>" class="RD" value="1" onClick="<?if(!$id_fase){?>onoff<?}else{?>processo<?}?>('<?echo $id;?>')" <?if($online)echo "checked";?>>
	          							<label for="check<?echo $id;?>">&nbsp;</label>
									</td>
									<td>
										<a href="/admin/noticia/<?echo $id;?>" class="opcoes">
											<?if($tipo_user=='admin'){?><span class="lnr lnr-pencil"></span>&nbsp;Editar<?}
											else{?><span class="lnr lnr-magnifier"></span>&nbsp;Ver<?}?>
										</a>&nbsp;&nbsp;
										<?if(($id_fase==1) || $tipo_user=='admin'){?><span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span><?}?>
									</td>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
					<button class="btV margin-top20 floatr" onClick="window.location.href='/admin/proc_noti';">INICIAR NOVA NOTÍCIA</button>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</div>
</article>
<? include '_footer.php';?>
<!-- MODALS -->
<div id="APAGAR" class="modal">
	<div class="modalFundo" onClick="esconder('APAGAR');"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="esconder('APAGAR');"></span>
	<div class="modalSize">
		<div class="modalHead">Apagar</div>
		<div class="modalBody">Tem a certeza que deseja apagar?</div>
		<div class="modalFoot">
			<button class="btV modalBt" name="sim" onclick="apagar()">SIM</button>
			<button class="btA modalBt" name="nao" onclick="esconder('APAGAR');">NÃO</button>
		</div>
	</div>
</div>
<div id="SUBSCRITORES" class="modal">
	<div class="modalFundo" onClick="esconder('SUBSCRITORES');"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="esconder('SUBSCRITORES');"></span>
	<div class="modalSize">
		<div class="modalHead">Enviar email</div>
		<div class="modalBody">Tem a certeza que deseja enviar email aos subscritores?</div>
		<div class="modalFoot">
			<button class="btV modalBt" name="sim" onclick="enviarEmailSub()">SIM</button>
			<button class="btA modalBt" name="nao" onclick="esconder('SUBSCRITORES');">NÃO</button>
		</div>
	</div>
</div>
<!-- -->
<script>
$(document).keyup(function(e) {
     if (e.keyCode == 27) { esconder('APAGAR'); esconder('SUBSCRITORES'); }
});
function processo(id){
	$('#check'+id).prop('checked', false);
	$.notific8('Não pode ficar online.<br>Encontra-se em fase de desenvolvimento.', {heading: 'Erro', theme: 'ruby'});
}
function onoff(id){
	$.post("/admin/funcao/js_onoff.php",{ id:id, tabela:'noticia', campo:'online' })
	$.notific8('Guardado com sucesso.', {heading: 'Guardado'});	 	
}
function destaque(id){
	$.post("/admin/funcao/js_destaque.php",{ id:id, tabela:'noticia', campo:'destaque' })
	.done(function( data ){
		var jsonRetorna = $.parseJSON(data);
		if(data!='TM'){document.getElementById('destaque'+jsonRetorna).checked = false;}
		$.notific8('Guardado com sucesso.', {heading: 'Guardado'});
    });
}
function apagar(){
	$.post("/admin/_noticia/js_del.php",{ id:id_del }) 
    .done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });
}
function enviarEmailSub(){
	enviarEmail(id_del,'sub');
	esconder('SUBSCRITORES');
}
function enviarEmail(id,destino){
	//destino eu sub
	$.post("/admin/_noticia/js_enviar_email.php",{ id:id, destino:destino })
	.done(function( data ){
		data = data.replace(/^\s+|\s+$/g,"");
		if(data=='TM'){	$.notific8('Enviado com sucesso.', {heading: 'Enviado'}); }
		else{ $.notific8(data, {heading: 'Erro', theme: 'ruby'}); }
    });
}
// GERIR TABELA
$(document).ready(function(){
     $('#sortable').dataTable({
     	aoColumnDefs: [{ "bSortable": false, "aTargets": [ 0, 2, 6, 7, 8, 9 ] }],
     	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
     });
});
</script>
</body>
</html>