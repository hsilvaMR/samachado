<?php $permissao='head'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Utilizador</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<?
	$url = $_SERVER['REQUEST_URI'];
	$urlPartes = explode("/", $url);
	$id = urldecode($urlPartes[3]);
	$existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id'"));
	if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id'")));}

	$sep=3;
	include '_menu.php';
	?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1><? if($existe){echo "Editar";}else{echo "Novo";}?> Utilizador<h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="/admin/utilizadores">Utilizadores</a>
				<div class="ponto"></div>
				<a href="">Utilizador</a>
			</div>
		</div>
		<div class="linhaScroll">
			<div class="coluna1">
				<div class="corpo">
					<form id="FORMULARIO" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<? if($existe){ echo $id; }?>">
					<div id="INF1" class="corpoCima">
						<div class="grupo">
							<div class="grupoEsq">Nome:</div>
							<div class="grupoDir">
								<input type="text" class="inP" name="nome" value="<? echo $nome?>" required autofocus>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Email:</div>
							<div class="grupoDir">
								<input type="email" class="inP" name="email" value="<? echo $email?>" required>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Password:</div>
							<div class="grupoDir">
								<?
								include 'funcao/gerar_codigo.php';
								if(!$password){ $password=gerarCodigo(8); }
								?>
								<input type="password" class="inP" name="password" value="<? echo $password?>" <? if($tipo_user!='admin'){ echo "readonly"; }?> required>
							</div>
						</div>
						<div class="grupo">
							<div class="grupoEsq">Tipo:</div>
							<div class="grupoDir">
								<select class="seL" name="tipo">
                                	<?if( $tipo_user=='admin' OR $tipo=='user' OR $tipo=='guest' OR !$existe){ ?>
                                		<option class="selS" value="user" <? if($tipo=='user'){echo "selected";}?>>Utilizador</option>
                                		<option class="selS" value="guest" <? if($tipo=='guest'){echo "selected";}?>>Convidado</option>
                                	<?}?>
                                	<?if( $tipo_user=='admin' OR $tipo=='head'){ ?><option class="selS" value="head" <? if($tipo=='head'){echo "selected";}?>>Diretor</option><?}?>
                                	<?if( $tipo_user=='admin'){ ?><option class="selS" value="admin" <? if($tipo=='admin'){echo "selected";}?>>Administrador</option><?}?>
                                </select>
							</div>
						</div>
						<div class="clear"></div>			
					</div>
					<div class="corpoBaixo">
						<input type="submit" class="btV" name="guardar" value="GUARDAR"/>
						<button type="button" class="btA" name="cancelar" onClick="window.location.href='/admin/utilizadores';">CANCELAR</button>					
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
			<button class="btC modalBt" name="cancelar" onClick="window.location.href='/admin/utilizadores';">VOLTAR</button>
		</div>
	</div>
</div>
<!-- -->
<script>
$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
			url: "/admin/_utilizador/novo.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				data = data.replace(/^\s+|\s+$/g,"");
				if(data){
					if((data!='TF') && (data!='TC')){
			    		mostrar('GUARDAR');
						window.history.pushState("object or string", "Title", "/admin/utilizador/"+data);
						//window.location.replace("pagina?id="+data);
					}else{
						if(data=='TF'){	$.notific8('Este email já existe.', {heading: 'Erro', theme: 'ruby'}); }
						if(data=='TC'){	$.notific8('Todos os campos são de preenchimento obrigatório. A password deve ter no minimo 6 caracteres.', {theme: 'ruby'}); }
					}
				}
			}         
		});
	}));
});
</script>
</body>
</html>