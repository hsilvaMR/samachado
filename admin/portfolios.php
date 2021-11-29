<?php $permissao='head'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Portfolio</title>
	<? include '_head.php';?>
	<!-- PAGINAR -->
  	<link href="/admin/funcao/datatables/jquery.dataTables.css" rel="stylesheet">
	<script src="/admin/funcao/datatables/jquery.dataTables.min.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=13; $sub=13.1; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Todas as Fichas de Obra<!--<a href="/admin/homepage"><small>nova homepage</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Fichas de Obra</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna4">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-list iconH4"></span>
					</div>
					<div class="subH4">FICHAS DE OBRA</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha WHERE nome='' OR nome_en='' OR nome_fr='' OR nome_es='' OR dono='' OR dono_en='' OR dono_fr='' OR 
				dono_es='' OR descricao='' OR descricao_en='' OR descricao_fr='' OR descricao_es=''"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna4">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteAmarelo"><? echo $num_per?></h4>
						<span class="lnr lnr-thumbs-down iconH4"></span>
					</div>
					<div class="subH4">FALTAM TRADUÇÕES</div>
					<div class="barraFundo"><div class="barraAmarelo" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha WHERE nome='' OR dono='' OR area='' OR piso='' OR subpiso='' OR valor='' OR prazo=0 OR 
				inicio='0000-00-00' OR fim='0000-00-00' OR descricao='' OR morada='' OR capa='' OR frente='' OR tras='' OR img1='' OR img2='' OR img3='' OR img4=''"));
			$percentagem=round($num_per*100/$numero); ?>
			<div class="coluna4">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteAzul"><? echo $num_per?></h4>
						<span class="lnr lnr-thumbs-up iconH4"></span>
					</div>
					<div class="subH4">FALTAM DADOS OU FOTOS</div>
					<div class="barraFundo"><div class="barraAzul" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha")); ?>
			<div class="coluna4">
				<div class="dadosF">
					<span class="lnr lnr-cloud-download dadosI"></span>
					<div class="dadosN"><? echo $numero?></div>
					<div class="dadosT">FICHAS DE OBRA</div>
					<a href="/admin/portfolio_exportar">
						<div class="dadosV">
							<span class="dadosL">EXPORTAR</span>
							<span class="lnr lnr-arrow-right-circle dadosR"></span>
						</div>
					</a>
				</div>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo tabelaBorda">
					<div class="tabelaHead">FICHAS DE OBRA</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th class="none"></th>
								<th class="compMin">#&ensp;</th>
                                <th class="compMin">Referência</th>
								<th class="compMin">Fotografia</th>
                                <th>Nome</th>
								<th>Label</th>
								<th>Categoria</th>
								<th>País</th>
								<th>Início</th>
								<th>Conclusão</th>
								<th>Enviar email</th>
								<?if( $id_user=='1' || $id_user=='2' || $id_user=='18' ){ ?>
									<th>Bloqueada</th>
								<? }?>
								<?if( $tipo_user=='admin' ){ ?>
									<th>Online</th>
									<th>Opção</th>
								<? }?>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM ficha ORDER BY id DESC");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$id_pais = $linha["id_pais"];
								$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM pais WHERE id='$id_pais'"));
								$pais = $linha4["nome_pt"];
								$id_estado = $linha["id_estado"];
								$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM estado WHERE id='$id_estado'"));
								$estado = $linha3["nome"];
								$estado = str_replace(" ", "&nbsp;", $estado);
								$id_categoria = $linha["id_categoria"];
								$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM categoria WHERE id='$id_categoria'"));
								$categoria = $linha2["nome"];
								$referencia = $linha["referencia"];
								$nome = $linha["nome"];
								$bloquear = $linha["bloquear"];
								$online = $linha["online"];
								$latitude=$linha["latitude"];
								$longitude=$linha["longitude"];
								$label1='';$label2='';$label3='';
								if($linha["nome"]=='' || $linha["dono"]=='' || $linha["area"]=='' || $linha["piso"]=='' || $linha["subpiso"]=='' || $linha["valor"]=='' || 
									$linha["prazo"]=='0' || $linha["inicio"]=='0000-00-00' || $linha["fim"]=='0000-00-00' || $linha["descricao"]=='' || $linha["morada"]==''){
									$label1 = 'Faltam&nbsp;Dados';
								}
								if($linha["capa"]=='' || $linha["frente"]=='' || $linha["tras"]=='' || $linha["img1"]=='' || $linha["img2"]=='' || $linha["img3"]=='' || $linha["img4"]==''){
									$label2 = "Faltam&nbsp;Fotografias";
								}
								if($linha["nome_en"]=='' || $linha["nome_fr"]=='' || $linha["nome_es"]=='' || $linha["dono_en"]=='' || $linha["dono_fr"]=='' || $linha["dono_es"]=='' || 
									$linha["descricao_en"]=='' || $linha["descricao_fr"]=='' || $linha["descricao_es"]==''){
									$label3 = "Faltam&nbsp;Traduções";
								}
								$inicio = ($linha["inicio"]!='0000-00-00') ? $linha["inicio"] : '';
								$fim = ($linha["fim"]!='0000-00-00') ? $linha["fim"] : '';
								$img = $linha["capa"];
								if(!$img){ $img="/admin/icon/default.jpg"; }
								$obs = $linha["obs"];
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
	                            	<td class="none"></td>
	                            	<td><? echo $id?></td>
									<td><? echo $referencia?></td>
									<td><img src="<? echo $img?>" class="img"></td>
									<td>
										<a href="/admin/portfolio/<?echo $id;?>" class="opcoes"><? echo $nome?></a>
										<? if($obs){?>&nbsp;&nbsp;<span class="opcoes" onclick="mostrar('OBS'); $('#TEXTO_OBS').html('<?echo $obs;?>');"><i class="lnr lnr-alarm"></i></span><? }?>
									</td>
									<td>
										<!-- labelVermelho labelAmarelo labelAzul labelCinza labelRoxo labelVerde -->
	                                	<?if(!$label1 && !$label2 && !$label3){?><span class="labelVerde">Completa</span><?}?>
	                                	<?if($label1){?><span class="labelAmarelo"><? echo $label1; ?></span><?}?>
	                                	<?if($label2){?><span class="labelAzul"><? echo $label2; ?></span><?}?>
	                                	<?if($label3){?><span class="labelVermelho"><? echo $label3; ?></span><?}?>
									</td>
									<td><? echo $categoria?></td>
									<td><?if($latitude && $longitude){?><a href="https://www.google.com/maps/search/<? echo $latitude; ?>,+<? echo $longitude; ?>" class="opcoes" target="_blank"><?}?><? echo $pais?><?if($latitude && $longitude){?></a><?}?></td>
									<td><? echo $inicio?></td>
									<td><? echo $fim?></td>
									<td>
										<!-- labelVermelho labelAmarelo labelAzul labelCinza labelRoxo labelVerde -->
										<span class="labelVerde cursor-pointer" onclick="enviarEmail('<? echo $id?>','eu');">Para&nbsp;Mim</span>
	                                	<span class="labelAmarelo cursor-pointer" onclick="mostrar('SUBSCRITORES',<?echo $id;?>);">Para&nbsp;Subscritores</span>
									</td>
									<?if( $id_user=='1' || $id_user=='2' || $id_user=='18' ){ ?>
										<td>
		                                	<input type="checkbox" id="checkB<?echo $id;?>" class="RD" value="1" onClick="onoffB('<?echo $id;?>')" <?if($bloquear)echo "checked";?>>
		          							<label for="checkB<?echo $id;?>">&nbsp;</label>
										</td>
									<? }?>
									<?if( $tipo_user=='admin' ){ ?>
		                                <td>
		                                	<input type="checkbox" id="check<?echo $id;?>" class="RD" value="1" onClick="onoff('<?echo $id;?>')" <?if($online)echo "checked";?>>
		          							<label for="check<?echo $id;?>">&nbsp;</label>
										</td>
										<td>
											<a href="/admin/portfolio/<?echo $id;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>&nbsp;&nbsp;
											<a href="/admin/documentos/<?echo $id;?>" class="opcoes"><span class="lnr lnr-database"></span>&nbsp;Documentos</a>&nbsp;&nbsp;
											<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
										</td>
									<? }?>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
					<?if( $tipo_user=='admin' && ($id_user==1 || $id_user==2 || $id_user==18)){ ?><button class="btV margin-top20 floatr" onClick="window.location.href='/admin/portfolio';">ADICIONAR NOVO</button><? }?>
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
<div id="OBS" class="modal">
	<div class="modalFundo" onClick="esconder('OBS');"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="esconder('OBS');"></span>
	<div class="modalSize">
		<div class="modalHead">Observações</div>
		<div class="modalBody" id="TEXTO_OBS"></div>
		<div class="modalFoot"><button class="btA modalBt" name="nao" onclick="esconder('OBS');">OK</button></div>
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
function onoffB(id){
	$.post("/admin/funcao/js_onoff.php",{ id:id, tabela:'ficha', campo:'bloquear' })
	$.notific8('Guardado com sucesso.', {heading: 'Guardado'});	
}
function onoff(id){
	$.post("/admin/_portfolio/js_onoff.php",{ id:id })
	.done(function( data ){
		if (data) {
			if ($('#check'+id).prop("checked")) {$('#check'+id).prop("checked", false);
			}else{ $('#check'+id).prop("checked", true); }

			$.notific8(data, {heading: 'Erro', theme: 'ruby'});
		}else{
			$.notific8('Guardado com sucesso.', {heading: 'Guardado'});
		}
    });		
}
function apagar(){
	$.post("/admin/_portfolio/js_del.php",{ id:id_del }) 
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
	$.post("/admin/_portfolio/js_enviar_email.php",{ id:id, destino:destino })
	.done(function( data ){
		data = data.replace(/^\s+|\s+$/g,"");
		if(data=='TM'){	$.notific8('Enviado com sucesso.', {heading: 'Enviado'}); }
		else{ $.notific8(data, {heading: 'Erro', theme: 'ruby'}); }
    });
}
// GERIR TABELA
$(document).ready(function(){
     $('#sortable').dataTable({
     	aoColumnDefs: [{ "bSortable": false, "aTargets": [ 0, 3, <?if($id_user=='1' || $id_user=='2' || $id_user=='18'){?>10, 11, 12, 13<? }elseif( $tipo_user=='admin' ){ ?>10, 11<?}?> ] }],
     	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
     });
});
</script>
</body>
</html>