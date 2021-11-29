<?php $permissao='head'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Tarefa</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<?
	$url = $_SERVER['REQUEST_URI'];
	$urlPartes = explode("/", $url);
	$fic_not = urldecode($urlPartes[3]);
	$id = urldecode($urlPartes[4]);
	if($fic_not=='ficha'){
		$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM tarefa WHERE id='$id'"));
		if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tarefa WHERE id='$id'")));}
		else{ header('Location: /admin/tarefas'); }

		$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM processo WHERE id='$id_processo'"));
		$id_responsavel = $linha["id_responsavel"];
		$referencia = $linha["referencia"];
		$processo = $linha["processo"];
		$nome = $referencia.' - '.$processo;
		if($tipo_user=='head' &&  $id_responsavel!=$id_user){ header('Location: /admin/tarefas'); }
		$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM etapa WHERE id='$id_etapa'"));
		$descricao = $linha2["descricao"];

	}elseif ($fic_not=='noticia'){
		$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id='$id'"));
		if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id='$id'")));}
		else{ header('Location: /admin/tarefas'); }
		$id_faz = $id_recetor;

		$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM noticia WHERE id='$id_noticia'"));
		$id_responsavel = $linha["id_user"];
		$nome = $linha["nome"];
		if($tipo_user=='head' &&  $id_responsavel!=$id_user){ header('Location: /admin/tarefas'); }
		$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fase WHERE id='$id_fase'"));
		$id_etapa = $linha2["id"];
		$descricao = $linha2["fase"];
	}

	$sep=4;
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Novo";}?> Tarefa<h1>
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
					<form id="FORMULARIO" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<? echo $id; ?>">
					<input type="hidden" name="tipo" value="<? echo $fic_not; ?>">
					<div id="INF1" class="corpoCima">
						<div class="grupo">
							<div class="grupoEsq"><? if($fic_not=='ficha'){ echo "Ficha"; }else{ echo "Notícia"; } ?>:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="titulo" value="<? echo $nome; ?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq"><? if($fic_not=='ficha'){ echo "Etapa"; }else{ echo "Fase"; } ?>:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="funcao" value="<? echo $id_etapa.' - '.$descricao; ?>" readonly>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Responsável:</div>
							<div class="grupoDir">
								<select class="seL" name="id_util">
                                	<? $query2 = mysqli_query($lnk,"SELECT * FROM user ORDER BY nome ASC");
									while($linha2 = mysqli_fetch_array($query2)){
										$id_util = $linha2['id'];
										$utilizador = $linha2['nome'];?>
                                    	<option class="selS" value="<? echo $id_util?>" <? if($id_util==$id_faz){echo "selected";}?>><? echo $utilizador?></option>
                                    <? }?>	
                                </select>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/tarefas';">CANCELAR</button>					
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
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/tarefas';">VOLTAR</button>
		</div>
	</div>
</div>
<!-- -->
<script>
$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
			url: "/admin/_tarefa/editar_user.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				data = data.replace(/^\s+|\s+$/g,"");
				if(data){
		    		mostrar('GUARDAR');
					window.history.pushState("object or string", "Title", "/admin/tarefa_user/"+data);
					//window.location.replace("pagina?id="+data);
				}
			}         
		});
	}));
});
</script>
</body>
</html>