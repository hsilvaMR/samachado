<?php $permissao='head'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Ficha de Obra</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=2; include '_menu.php'; ?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Nova Ficha de Obra<h1>
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
					<form id="FORMULARIO" method="post" enctype="multipart/form-data">
					<div class="corpoCima">
						<div class="grupo">
							<div class="grupoEsq">Referência:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="referencia" value="" autofocus required>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Processo:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="nome" value="" required>
							</div>
						</div>
						<?
						if($id_user==1){ $tiago=" OR id=1 "; } 
						$query = mysqli_query($lnk,"SELECT * FROM etapa");
						$linha = mysqli_fetch_array($query);
						$id_etapa = $linha['id'];
						$nome_etapa = $linha['nome'];
						$descricao_etapa = $linha['descricao'];?>
                    	<div class="grupo">
							<div class="grupoEsq">Etapa 1:</div>
							<div class="grupoDir">
								<select class="seL" name="etapa1" required>
									<option class="selS" value="">&nbsp;</option>
                                	<? $query2 = mysqli_query($lnk,"SELECT * FROM user WHERE bloqueado=0 ORDER BY nome ASC");
									while($linha2 = mysqli_fetch_array($query2)){
										$id_uti = $linha2['id'];
										$nome_uti = $linha2['nome'];
										$email_uti = $linha2['email'];?>
                                    	<option class="selS" value="<? echo $id_uti?>"><? echo $nome_uti?></option>
                                    <? }?>
                                </select>
                                <div class="margin-top10"><b>Função:</b> <? echo $descricao_etapa?></div>
							</div>
						</div>
						<? $linha = mysqli_fetch_array($query);
						$id_etapa = $linha['id'];
						$nome_etapa = $linha['nome'];
						$descricao_etapa = $linha['descricao'];?>
                    	<div class="grupo">
							<div class="grupoEsq">Etapa 2:</div>
							<div class="grupoDir">
								<select class="seL" name="etapa2" required>
									<option class="selS" value="">&nbsp;</option>
                                	<? $query2 = mysqli_query($lnk,"SELECT * FROM user WHERE bloqueado=0 ORDER BY nome ASC");
									while($linha2 = mysqli_fetch_array($query2)){
										$id_uti = $linha2['id'];
										$nome_uti = $linha2['nome'];
										$email_uti = $linha2['email'];?>
                                    	<option class="selS" value="<? echo $id_uti?>"><? echo $nome_uti?></option>
                                    <? }?>
                                </select>
                                <div class="margin-top10"><b>Função:</b> <? echo $descricao_etapa?></div>
							</div>
						</div>
						<? $linha = mysqli_fetch_array($query);
						$id_etapa = $linha['id'];
						$nome_etapa = $linha['nome'];
						$descricao_etapa = $linha['descricao'];?>
                    	<div class="grupo">
							<div class="grupoEsq">Etapa 3:</div>
							<div class="grupoDir">
								<select class="seL" name="etapa3" required>
									<option class="selS" value="">&nbsp;</option>
                                	<? $query2 = mysqli_query($lnk,"SELECT * FROM user WHERE id=2 OR id=18 $tiago ORDER BY nome ASC");
									while($linha2 = mysqli_fetch_array($query2)){
										$id_uti = $linha2['id'];
										$nome_uti = $linha2['nome'];
										$email_uti = $linha2['email'];?>
                                    	<option class="selS" value="<? echo $id_uti?>"><? echo $nome_uti?></option>
                                    <? }?>
                                </select>
                                <div class="margin-top10"><b>Função:</b> <? echo $descricao_etapa?></div>
							</div>
						</div>
						<? $linha = mysqli_fetch_array($query);
						$id_etapa = $linha['id'];
						$nome_etapa = $linha['nome'];
						$descricao_etapa = $linha['descricao'];?>
                    	<div class="grupo">
							<div class="grupoEsq">Etapa 4:</div>
							<div class="grupoDir">
								<select class="seL" name="etapa4" required>
									<option class="selS" value="">&nbsp;</option>
									<? $query2 = mysqli_query($lnk,"SELECT * FROM user WHERE bloqueado=0 ORDER BY nome ASC");
									while($linha2 = mysqli_fetch_array($query2)){
										$id_uti = $linha2['id'];
										$nome_uti = $linha2['nome'];
										$email_uti = $linha2['email'];?>
                                    	<option class="selS" value="<? echo $id_uti?>"><? echo $nome_uti?></option>
                                    <? }?>
                                </select>
                                <div class="margin-top10"><b>Função:</b> <? echo $descricao_etapa?></div>
							</div>
						</div>
						<? $linha = mysqli_fetch_array($query);
						$id_etapa = $linha['id'];
						$nome_etapa = $linha['nome'];
						$descricao_etapa = $linha['descricao'];?>
                    	<div class="grupo">
							<div class="grupoEsq">Etapa 5:</div>
							<div class="grupoDir">
								<select class="seL" name="etapa5" required>
									<option class="selS" value="">&nbsp;</option>
									<? $query2 = mysqli_query($lnk,"SELECT * FROM user WHERE bloqueado=0 ORDER BY nome ASC");
									while($linha2 = mysqli_fetch_array($query2)){
										$id_uti = $linha2['id'];
										$nome_uti = $linha2['nome'];
										$email_uti = $linha2['email'];?>
                                    	<option class="selS" value="<? echo $id_uti?>"><? echo $nome_uti?></option>
                                    <? }?>
                                </select>
                                <div class="margin-top10"><b>Função:</b> <? echo $descricao_etapa?></div>
							</div>
						</div>
						<? $linha = mysqli_fetch_array($query);
						$id_etapa = $linha['id'];
						$nome_etapa = $linha['nome'];
						$descricao_etapa = $linha['descricao'];?>
                    	<div class="grupo">
							<div class="grupoEsq">Etapa 6:</div>
							<div class="grupoDir">
								<select class="seL" name="etapa6" required>
									<option class="selS" value="">&nbsp;</option>
                                	<? $query2 = mysqli_query($lnk,"SELECT * FROM user WHERE id=2 OR id=18 $tiago ORDER BY nome ASC");
									while($linha2 = mysqli_fetch_array($query2)){
										$id_uti = $linha2['id'];
										$nome_uti = $linha2['nome'];
										$email_uti = $linha2['email'];?>
                                    	<option class="selS" value="<? echo $id_uti?>"><? echo $nome_uti?></option>
                                    <? }?>
                                </select>
                                <div class="margin-top10"><b>Função:</b> <? echo $descricao_etapa?></div>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/fichas';">CANCELAR</button>		
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
			<button class="btV modalBt" name="nao" onclick="window.location.href='/admin/fichas';">FECHAR</button>
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/fichas';">VOLTAR</button>
		</div>
	</div>
</div>
<!-- -->
<script>
$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		mostrar('LOADING');
		e.preventDefault();
		$.ajax({
			url: "/admin/_ficha/processo.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				esconder('LOADING');
				data = data.replace(/^\s+|\s+$/g,"");
				if(data=='TM'){
		    		mostrar('GUARDAR');
					window.history.pushState("object or string", "Title", "/admin/fichas");
					//window.location.replace("pagina?id="+data);
				}else{
					$.notific8(data, {heading: 'Erro', theme: 'ruby'});
				}
			}         
		});
	}));
});
</script>
</body>
</html>