<?php $permissao='head'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Utilizadores</title>
	<? include '_head.php';?>
	<!-- PAGINAR -->
  	<link href="/admin/funcao/datatables/jquery.dataTables.css" rel="stylesheet">
	<script src="/admin/funcao/datatables/jquery.dataTables.min.js"></script>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=3; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Todos os Utilizadores<!--<a href="/admin/categoria"><small>nova categoria</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Utilizadores</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user WHERE tipo='guest'"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; }  ?>
			<div class="coluna4">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-sad iconH4"></span>
					</div>
					<div class="subH4">CONVIDADOS</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user WHERE tipo='user'"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna4">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteAmarelo"><? echo $num_per?></h4>
						<span class="lnr lnr-neutral iconH4"></span>
					</div>
					<div class="subH4">UTILIZADORES</div>
					<div class="barraFundo"><div class="barraAmarelo" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user WHERE tipo='head'"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; }  ?>
			<div class="coluna4">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteAzul"><? echo $num_per?></h4>
						<span class="lnr lnr-smile iconH4"></span>
					</div>
					<div class="subH4">DIRETORES</div>
					<div class="barraFundo"><div class="barraAzul" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user WHERE tipo='admin'"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna4">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $num_per?></h4>
						<span class="lnr lnr-mustache iconH4"></span>
					</div>
					<div class="subH4">ADMINISTRADORES</div>
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
					<div class="tabelaHead">UTILIZADORES</div>
					<div class="linhaScroll">
						<table id="sortable" class="listagem">
							<thead>
							<tr>
								<th class="none"></th>
								<th>Nome</th>
								<th>Email</th>
								<th>Tipo</th>
								<?if( $tipo_user=='admin' ){ ?><th>Bloqueado</th><? }?>
								<th>Opção</th>
							</tr>
							</thead>
							<tbody>
                            <? $risca=1;
                            $query = mysqli_query($lnk,"SELECT * FROM user");
							while($linha = mysqli_fetch_array($query))
							{
								$id = $linha["id"];
								$nome = $linha["nome"];
								$email = $linha["email"];
								$tipo = $linha["tipo"];
								$bloqueado = $linha["bloqueado"];
								if(($risca%2)==0){ $classe="tabelaFundoP"; }else{ $classe="tabelaFundoI"; }
								$risca++; ?>
	                            <tr id="linha_<? echo $id?>" class="<? echo $classe?>">
	                            	<td class="none"></td>
									<td><a href="/admin/utilizador/<?echo $id;?>" class="opcoes"><? echo $nome?></a></td>
									<td><? echo $email?></td>
									<td>
										<!-- labelCinza labelVerde labelAmarelo labelVermelho labelAzul labelRoxo <span class="labelCinza">pendente</span>-->
	                                	<?if($tipo=='admin'){ ?><span class="labelAzul">Administrador</span><? } ?>
	                                	<?if($tipo=='user'){ ?><span class="labelVerde">Utilizador</span><? } ?>
	                                	<?if($tipo=='head'){ ?><span class="labelRoxo">Diretor</span><? } ?>
	                                	<?if($tipo=='guest'){ ?><span class="labelAmarelo">Convidado</span><? } ?>
									</td>
									<?if( $tipo_user=='admin' ){ ?>
										<td>
		                                	<input type="checkbox" id="check<?echo $id;?>" class="RD" value="1" onClick="onoff('<?echo $id;?>')" <?if($bloqueado)echo "checked";?>>
		          							<label for="check<?echo $id;?>">&nbsp;</label>
										</td>
									<? }?>
									<td>
										<a href="/admin/utilizador/<?echo $id;?>" class="opcoes"><span class="lnr lnr-pencil"></span>&nbsp;Editar</a>&nbsp;&nbsp;
										<span class="opcoes" onclick="mostrar('APAGAR',<?echo $id;?>);"><i class="lnr lnr-trash"></i>&nbsp;Apagar</span>
									</td>
								</tr>
                            <?}?>
							</tbody>
						</table>
					</div>
					<button class="btV margin-top20 floatr" onClick="window.location.href='/admin/utilizador';">ADICIONAR NOVO</button>
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
function onoff(id){
	$.post("/admin/_utilizador/js_bloquear.php",{ id:id })
	$.notific8('Guardado com sucesso.', {heading: 'Guardado'});	 	
}
function apagar(){
	$.post("/admin/_utilizador/js_del.php",{ id:id_del }) 
    .done(function( data ){
    	var jsonRetorna = $.parseJSON(data);
    	esconder('APAGAR');
    	if(jsonRetorna!='TF'){
    		$('#linha_'+id_del).css("display","none");
			$.notific8('Apagado com sucesso.', {heading: 'Apagado'});
		}else{
			$.notific8('Este utilizador não pode ser apagado.<br>Tem tarefas para realizar.', {heading: 'Erro', theme: 'ruby'});
		}
    });
}
// GERIR TABELA
$(document).ready(function(){
     $('#sortable').dataTable({
     	aoColumnDefs: [{ "bSortable": false, "aTargets": [ <?if( $tipo_user=='admin' ){ ?>4, 5<? }else{ ?>4<? } ?>  ] }],
     	lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
     });
});
</script>
</body>
</html>