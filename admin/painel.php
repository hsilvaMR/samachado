<?php $permissao='user'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Painel</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=1; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Painel<small>estatísticas e relatórios</small><h1>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM tarefa WHERE id_faz='$id_user' AND data!='0000-00-00'"));
			$numero2=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id_recetor='$id_user' AND data!='0000-00-00'")); 
			$numero=$numero+$numero2; ?>
			<div class="coluna4">
				<div class="dadosF">
					<span class="lnr lnr-user dadosI"></span>
					<div class="dadosN"><? echo $numero?></div>
					<div class="dadosT">NOVAS TAREFAS</div>
					<a href="/admin/tarefas">
						<div class="dadosV">
							<span class="dadosL">VER MAIS</span>
							<span class="lnr lnr-arrow-right-circle dadosR"></span>
						</div>
					</a>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM tarefa WHERE id_faz='$id_user'"));
			$numero2=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id_recetor='$id_user'")); 
			$numero=$numero+$numero2; ?>
			<div class="coluna4">
				<div class="dadosF">
					<span class="lnr lnr-list dadosI"></span>
					<div class="dadosN"><? echo $numero?></div>
					<div class="dadosT">TAREFAS</div>
					<a href="/admin/tarefas">
						<div class="dadosV">
							<span class="dadosL">VER MAIS</span>
							<span class="lnr lnr-arrow-right-circle dadosR"></span>
						</div>
					</a>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM chat WHERE lido NOT LIKE '%[$id_user]%' AND id_recetor IN('$id_user','0')")); ?>
			<div class="coluna4">
				<div class="dadosF">
					<span class="lnr lnr-keyboard dadosI"></span>
					<div class="dadosN"><? echo $numero?></div>
					<div class="dadosT">NOVAS MENSAGENS</div>
					<a href="/admin/chat">
						<div class="dadosV">
							<span class="dadosL">VER MAIS</span>
							<span class="lnr lnr-arrow-right-circle dadosR"></span>
						</div>
					</a>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM registo WHERE id_admin='$id_user' OR id_user='$id_user'")); ?>
			<div class="coluna4">
				<div class="dadosF">
					<span class="lnr lnr-spell-check dadosI"></span>
					<div class="dadosN"><? echo $numero?></div>
					<div class="dadosT">REGISTOS</div>
					<a href="/admin/historico">
						<div class="dadosV">
							<span class="dadosL">VER MAIS</span>
							<span class="lnr lnr-arrow-right-circle dadosR"></span>
						</div>
					</a>
				</div>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna2">
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
			<div class="coluna2">
				<div class="corpo tabelaBorda">
					<div class="tabelaHead">ÚLTIMOS REGISTOS</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th class="none"></th>
								<th>Emissor</th>
								<th>Recetor</th>
								<th>Registo</th>
								<th>Hora</th>
								<th>Data</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM registo WHERE id_admin='$id_user' OR id_user='$id_user' ORDER BY id DESC LIMIT 6");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$id_emissor = $linha["id_admin"];
								$id_recetor = $linha["id_user"];
								$registo = $linha["registo"];
								$data = $linha["data"];
								$hora = $linha["hora"];
								$hora = substr($hora, 0, 5);

								$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id_emissor'"));
								$nome_emissor = $linha2["nome"];
								$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id_recetor'"));
								$nome_recetor = $linha3["nome"];

								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_m<? echo $id?>" class="<? echo $classe?>">
	                            	<td class="none"></td>
	                            	<!-- labelCinza labelVerde labelAmarelo labelVermelho labelAzul labelRoxo <span class="labelCinza">pendente</span>-->
	                                <td><? echo $nome_emissor; ?></td>
									<td><? echo $nome_recetor; ?></td>
									<td><? echo $registo; ?></td>
									<td><? echo $hora; ?></td>
									<td><? echo $data; ?></td>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</article>
<? include '_footer.php';?>
</body>
</html>