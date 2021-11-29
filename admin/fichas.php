<?php $permissao='head'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Fichas</title>
	<? include '_head.php';?>
	<!-- PAGINAR -->
  	<link href="/admin/funcao/datatables/jquery.dataTables.css" rel="stylesheet">
	<script src="/admin/funcao/datatables/jquery.dataTables.min.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=2; include '_menu.php';?>
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
			<? if($tipo_user=='admin'){$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo"));
				$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo"));}
			else{$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE id_responsavel='$id_user'"));
				$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE id_responsavel='$id_user'"));}
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
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
			<? if($tipo_user=='admin'){$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo"));
				$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE ficha=0 AND id_etapa = 1"));}
			else{$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE id_responsavel='$id_user'"));
				$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE id_responsavel='$id_user' AND ficha=0 AND id_etapa = 1"));}
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
			<? if($tipo_user=='admin'){$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo"));
				$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE ficha=0 AND id_etapa!=1"));}
			else{$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE id_responsavel='$id_user'"));
				$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE id_responsavel='$id_user' AND ficha=0 AND id_etapa!=1"));}
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
			<? if($tipo_user=='admin'){$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo"));
				$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE ficha!=0"));}
			else{$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE id_responsavel='$id_user'"));
				$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE id_responsavel='$id_user' AND ficha!=0"));}
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
                                <th>Nome</th>
								<th>Responsável</th>
								<th>Estado</th>
								<th>Opção</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            if($id_user==1){$query = mysqli_query($lnk,"SELECT * FROM processo ORDER BY id DESC");}
                            elseif($tipo_user=='admin'){$query = mysqli_query($lnk,"SELECT * FROM processo ORDER BY id DESC");}
							else{$query = mysqli_query($lnk,"SELECT * FROM processo WHERE id_responsavel='$id_user' AND online=1 ORDER BY id DESC");}
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$id_etapa = $linha["id_etapa"];
								$id_responsavel = $linha["id_responsavel"];
								$linha5 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id_responsavel'"));
								$nome_resp = $linha5["nome"];
								$referencia = $linha["referencia"];
								$processo = $linha["processo"];
								$ficha = $linha["ficha"];
								$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM etapa WHERE id='$id_etapa'"));
								$dias = $linha2['dias'];
								$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tarefa WHERE id_processo='$id' AND id_etapa='$id_etapa'"));
								$id_faz = $linha3["id_faz"];
								$data = $linha3["data"];
								if(!$data || $data=='0000-00-00'){$estado='pendente';}
								else{
									$prazo1 = $dias;
									$aviso1 = date('Y-m-d', strtotime("+".$prazo1." days",strtotime($data)));
									$prazo2 = $dias+$prazo1;
									$aviso2 = date('Y-m-d', strtotime("+".$prazo2." days",strtotime($data)));
									$hoje = date('Y-m-d');
									if($hoje<=$aviso1){$estado='verde';}
									if($aviso1<$hoje && $hoje<=$aviso2){$estado='amarelo';}
									if($aviso2<$hoje){$estado='vermelho';}
								}
								$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id_faz'"));
								$nome_faz = $linha4["nome"];

								if(!mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM tarefa WHERE id_etapa='$id_etapa' AND id_processo='$id'")) && $id_etapa && !$ficha){
									$hoje=date('Y-m-d');
									$hora=date('H:i');
									$registo="Atribuição da etapa ao responsável";
									mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_responsavel','$id_responsavel','$id','$id_etapa','$registo','$hoje','$hora')");
									mysqli_query($lnk, "INSERT INTO tarefa(id_manda,id_faz,id_etapa,id_processo,data) VALUES ('$id_responsavel','$id_responsavel','$id_etapa','$id','$hoje')");
								}
								//$estado = str_replace(" ", "&nbsp;", $estado);
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
	                            	<td class="none"></td>
									<td><a href="/admin/ficha/<?echo $id;?>" class="opcoes"><? echo $referencia." - ".$processo;?></a></td>
									<td><? echo $nome_resp?></td>
									<td>
										<!-- labelCinza labelVerde labelAmarelo labelVermelho labelAzul labelRoxo -->
	                                	<?if(!$ficha && $estado=='pendente'){?><span class="labelCinza"><? echo "Etapa ".$id_etapa." - ".$nome_resp; ?></span><?}?>
	                                	<?if(!$ficha && $estado=='verde'){?><span class="labelVerde"><? echo "Etapa ".$id_etapa." - ".$nome_faz; ?></span><?}?>
	                                	<?if(!$ficha && $estado=='amarelo'){?><span class="labelAmarelo"><? echo "Etapa ".$id_etapa." - ".$nome_faz; ?></span><?}?>
	                                	<?if(!$ficha && $estado=='vermelho'){?><span class="labelVermelho"><? echo "Etapa ".$id_etapa." - ".$nome_faz; ?></span><?}?>
										<?if($ficha){?><a href="/overview/<? echo $ficha; ?>" target="_bank"><span class="labelAzul">Concluída&nbsp;( #<? echo $ficha; ?> )</span></a><?}?>
									</td>
									<td>
										<a href="/admin/ficha/<?echo $id;?>" class="opcoes">
											<?if($ficha==0){?><span class="lnr lnr-pencil"></span>&nbsp;Editar<?}
											else{?><span class="lnr lnr-magnifier"></span>&nbsp;Ver<?}?>
										</a>&nbsp;&nbsp;
										<?if(($id_etapa==1 && $ficha==0) || $tipo_user=='admin'){?><span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span><?}?>
									</td>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
					<button class="btV margin-top20 floatr" onClick="window.location.href='/admin/processo';">INICIAR NOVA FICHA</button>
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
<!-- -->
<script>
$(document).keyup(function(e) {
     if (e.keyCode == 27) { esconder('APAGAR'); }
});
function apagar(){
	$.post("/admin/funcao/js_del.php",{ id:id_del, tabela:'processo' })
	.done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });

	/*$.post("/admin/_ficha/js_del.php",{ id:id_del }) 
    .done(function( data ){
		$('#linha_'+id_del).css("display","none");
		esconder('APAGAR');
		$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
    });*/
}
// GERIR TABELA
$(document).ready(function(){
     $('#sortable').dataTable({
     	aoColumnDefs: [{ "bSortable": false, "aTargets": [ 0, 4 ] }],
     	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
     });
});
</script>
</body>
</html>