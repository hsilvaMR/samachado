<?php $permissao='user'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Tarefas</title>
	<? include '_head.php';?>
	<!-- PAGINAR -->
  	<link href="/admin/funcao/datatables/jquery.dataTables.css" rel="stylesheet">
	<script src="/admin/funcao/datatables/jquery.dataTables.min.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=4; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Tarefas<!--<a href="/admin/categoria"><small>nova categoria</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Tarefas</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM tarefa"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM tarefa WHERE id_faz='$id_user'"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; }  ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-indent-increase iconH4"></span>
					</div>
					<div class="subH4">TAREFAS DE FICHA DE OBRA</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM trabalho"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id_recetor='$id_user'"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $num_per?></h4>
						<span class="lnr lnr-indent-decrease iconH4"></span>
					</div>
					<div class="subH4">TAREFAS DE NOTÍCIAS</div>
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
					<div class="tabelaHead">MINHAS TAREFAS</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th>Nome</th>
								<th>Tarefa</th>
								<th>Data</th>
								<th>Opção</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM tarefa WHERE id_faz='$id_user'");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$id_manda = $linha["id_manda"];
								$id_faz = $linha["id_faz"];
								$id_processo = $linha["id_processo"];
								$id_etapa = $linha["id_etapa"];
								$data = $linha["data"];
								$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM etapa WHERE id='$id_etapa'"));
								$tarefa = $linha2["descricao"];
								$dias = $linha2['dias'];
								$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM processo WHERE id='$id_processo'"));
								$referencia = $linha3["referencia"];
								$processo = $linha3["processo"];
								if($data=='0000-00-00'){$estado='pendente';}
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
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_mo<? echo $id?>" class="<? echo $classe?>">
	                            	<td><span class="labelAzul">F</span> &nbsp;<? echo $referencia." - ".$processo;?></td>
									<td>
										<!-- labelCinza labelVerde labelAmarelo labelVermelho labelAzul labelRoxo -->
	                                	<?if($estado=='pendente'){?><span class="labelCinza"><? echo "Etapa ".$id_etapa; ?></span><?}?>
	                                	<?if($estado=='verde'){?><span class="labelVerde"><? echo "Etapa ".$id_etapa; ?></span><?}?>
	                                	<?if($estado=='amarelo'){?><span class="labelAmarelo"><? echo "Etapa ".$id_etapa; ?></span><?}?>
	                                	<?if($estado=='vermelho'){?><span class="labelVermelho"><? echo "Etapa ".$id_etapa; ?></span><?}?>
	                                	&nbsp;<? echo $tarefa?>
	                                </td>
									<td>
										<?if($estado!='pendente'){ echo $data; }?>
									</td>
									<td>
										<?if($estado=='pendente'){?><span class="lnr lnr-hand"></span>&nbsp;Pendente<?}
	                                	else{?><a href="/admin/tarefa/<?echo $id;?>" class="opcoes"><span class="lnr lnr-highlight"></span>&nbsp;Executar</a><?}?>
										<!--&nbsp;&nbsp;<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>-->
									</td>
								</tr>
                            <?}
                            $query = mysqli_query($lnk,"SELECT * FROM trabalho WHERE id_recetor='$id_user'");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$id_manda = $linha["id_emissor"];
								$id_faz = $linha["id_recetor"];
								$id_processo = $linha["id_noticia"];
								$id_etapa = $linha["id_fase"];
								$data = $linha["data"];
								$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fase WHERE id='$id_etapa'"));
								$tarefa = $linha2["fase"];
								$dias = $linha2['dias'];
								$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM noticia WHERE id='$id_processo'"));
								$referencia = $linha3["nome"];
								if($data=='0000-00-00'){$estado='pendente';}
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
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_mn<? echo $id?>" class="<? echo $classe?>">
	                            	<td><span class="labelRoxo">N</span> &nbsp;<? echo $referencia;?></td>
	                            	<td>
										<!-- labelCinza labelVerde labelAmarelo labelVermelho labelAzul labelRoxo -->
	                                	<?if($estado=='pendente'){?><span class="labelCinza"><? echo "Etapa ".$id_etapa; ?></span><?}?>
	                                	<?if($estado=='verde'){?><span class="labelVerde"><? echo "Etapa ".$id_etapa; ?></span><?}?>
	                                	<?if($estado=='amarelo'){?><span class="labelAmarelo"><? echo "Etapa ".$id_etapa; ?></span><?}?>
	                                	<?if($estado=='vermelho'){?><span class="labelVermelho"><? echo "Etapa ".$id_etapa; ?></span><?}?>
	                                	&nbsp;<? echo $tarefa?>
	                                </td>
									<td>
										<?if($estado!='pendente'){ echo $data; }?>
									</td>
									<td>
										<?if($estado=='pendente'){?><span class="lnr lnr-hand"></span>&nbsp;Pendente<?}
	                                	else{?><a href="/admin/trabalho/<?echo $id;?>" class="opcoes"><span class="lnr lnr-highlight"></span>&nbsp;Executar</a><?}?>
										<!--&nbsp;&nbsp;<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>-->
									</td>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<? if( $tipo_user!='user' ){ ?>
			<div class="coluna1">
				<div class="corpo tabelaBorda">
					<div class="tabelaHead">TODAS AS TAREFAS</div>
					<div class="linhaScroll">
						<table id="sortable2" class="listagem">
							<thead>
							<tr>
								<th class="none"></th>
								<th>Nome</th>
								<th>Tarefa</th>
								<th>Data</th>
								<th>Opção</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM tarefa");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$id_manda = $linha["id_manda"];
								$id_faz = $linha["id_faz"];
								$id_processo = $linha["id_processo"];
								$id_etapa = $linha["id_etapa"];
								$data = $linha["data"];
								$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM etapa WHERE id='$id_etapa'"));
								$tarefa = $linha2["descricao"];
								$dias = $linha2['dias'];
								$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM processo WHERE id='$id_processo'"));
								$id_responsavel = $linha3["id_responsavel"];
								$referencia = $linha3["referencia"];
								$processo = $linha3["processo"];
                           		if($tipo_user=='admin' ||  $id_responsavel==$id_user){
                           			if($data=='0000-00-00'){$estado='pendente';}
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
									if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
									$risca++; ?>
		                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
		                            	<td class="none"></td>
		                            	<td>
		                            		<?if($estado!='pendente'){?><a href="/admin/tarefa/<?echo $id;?>" class="opcoes"><span class="labelAzul">F</span> &nbsp;<? echo $referencia." - ".$processo;?></a><?}
		                            		else{?><span class="labelAzul">F</span> &nbsp;<? echo $referencia." - ".$processo;?><?}?>
		                            	</td>
		                            	<td>
											<!-- labelCinza labelVerde labelAmarelo labelVermelho labelAzul labelRoxo -->
		                                	<?if($estado=='pendente'){?><span class="labelCinza"><? echo $nome_faz." - Etapa ".$id_etapa; ?></span><?}?>
		                                	<?if($estado=='verde'){?><span class="labelVerde"><? echo $nome_faz." - Etapa ".$id_etapa; ?></span><?}?>
		                                	<?if($estado=='amarelo'){?><span class="labelAmarelo"><? echo $nome_faz." - Etapa ".$id_etapa; ?></span><?}?>
		                                	<?if($estado=='vermelho'){?><span class="labelVermelho"><? echo $nome_faz." - Etapa ".$id_etapa; ?></span><?}?>
		                                	&nbsp;<? echo $tarefa?>
		                                </td>
										<td>
											<?if($estado!='pendente'){ echo $data; }?>
										</td>
										<td>
											<a href="/admin/tarefa_user/ficha/<?echo $id;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>
										</td>
									</tr>
                            	<?}
                            }
                            $query = mysqli_query($lnk,"SELECT * FROM trabalho");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$id_manda = $linha["id_emissor"];
								$id_faz = $linha["id_recetor"];
								$id_processo = $linha["id_noticia"];
								$id_etapa = $linha["id_fase"];
								$data = $linha["data"];
								$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fase WHERE id='$id_etapa'"));
								$tarefa = $linha2["fase"];
								$dias = $linha2['dias'];
								$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM noticia WHERE id='$id_processo'"));
								$id_responsavel = $linha3["id_user"];
								$referencia = $linha3["nome"];
                           		if($tipo_user=='admin' ||  $id_responsavel==$id_user){
                           			if($data=='0000-00-00'){$estado='pendente';}
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
									if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
									$risca++; ?>
		                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
		                            	<td class="none"></td>
		                            	<td>
		                            		<?if($estado!='pendente'){?><a href="/admin/trabalho/<?echo $id;?>" class="opcoes"><span class="labelRoxo">N</span> &nbsp;<? echo $referencia;?></a><?}
		                            		else{?><span class="labelRoxo">N</span> &nbsp;<? echo $referencia;?><?}?>
		                            	</td>
		                            	<td>
											<!-- labelCinza labelVerde labelAmarelo labelVermelho labelAzul labelRoxo -->
		                                	<?if($estado=='pendente'){?><span class="labelCinza"><? echo $nome_faz." - Etapa ".$id_etapa; ?></span><?}?>
		                                	<?if($estado=='verde'){?><span class="labelVerde"><? echo $nome_faz." - Etapa ".$id_etapa; ?></span><?}?>
		                                	<?if($estado=='amarelo'){?><span class="labelAmarelo"><? echo $nome_faz." - Etapa ".$id_etapa; ?></span><?}?>
		                                	<?if($estado=='vermelho'){?><span class="labelVermelho"><? echo $nome_faz." - Etapa ".$id_etapa; ?></span><?}?>
		                                	&nbsp;<? echo $tarefa?>
		                                </td>
										<td>
											<?if($estado!='pendente'){ echo $data; }?>
										</td>
										<td>
											<a href="/admin/tarefa_user/noticia/<?echo $id;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>
										</td>
									</tr>
                            	<?}
                            }?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<? } ?>
		</div>
	</div>
</article>
<? include '_footer.php';?>
<script>
// GERIR TABELA
$(document).ready(function(){
     $('#sortable2').dataTable({
     	aoColumnDefs: [{ "bSortable": false, "aTargets": [ 4 ] }],
     	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
     });
});
</script>
</body>
</html>