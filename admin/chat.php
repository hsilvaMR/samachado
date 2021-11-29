<?php $permissao='guest'; include('_seguranca.php'); ?>
<!doctype html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8">
	<title>Chat</title>
	<? include '_head.php';?>
</head>

<body>
<? include '_header.php';?>
<article>
	<? $sep=6; include '_menu.php';?>
	<div class="conteudo">
		<div class="linha">
			<div class="titulo">
				<h1>Chat<!--<a href="/admin/categoria"><small>nova categoria</small></a>--><h1>
				<a href="/admin/painel">Painel</a>
				<div class="ponto"></div>
				<a href="">Chat</a>
			</div>
		</div>
		<div class="linha">
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM chat WHERE id_emissor='$id_user' OR id_recetor='$id_user' OR id_recetor='0'"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM chat WHERE id_emissor='$id_user' OR id_recetor='$id_user' OR id_recetor='0'"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; }  ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVerde"><? echo $num_per?></h4>
						<span class="lnr lnr-envelope iconH4"></span>
					</div>
					<div class="subH4">MENSAGENS</div>
					<div class="barraFundo"><div class="barraVerde" style="width:<? echo $percentagem?>%;"></div></div>
					<div class="linha">
						<span class="legH4">TOTAL</span>
						<span class="perH4"><? echo $percentagem?>%</span>
					</div>
				</div>
			</div>
			<? $numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user WHERE bloqueado='0'"));
			$num_per=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user WHERE bloqueado='0'"));
			if($numero){ $percentagem=round($num_per*100/$numero); }else{ $percentagem=0; } ?>
			<div class="coluna2">
				<div class="corpo">
					<div class="linha">
						<h4 class="fonteVermelho"><? echo $num_per?></h4>
						<span class="lnr lnr-smile iconH4"></span>
					</div>
					<div class="subH4">PESSOAS</div>
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
					<div class="tabelaHead">CHAT</div>
					<form id="FORMULARIO" method="post">
					<div class="linhaScroll">
						<div id="CHAT" class="chat">
							<? include '_chat/_chat.php';?>
						</div>
					</div>
					<div class="clear margin-top10"></div>
					<!--<input type="text" class="inP chatInput" id="mensagem" name="mensagem" value="" autofocus>-->
					<textarea class="teX" rows="3" id="mensagem" name="mensagem" autofocus></textarea>
					<select class="seL chatSel" id="id_recetor" name="id_recetor">
						<option class="selS" value="0">Todos</option>
						<option class="selS" value="1">Assistência</option>
                    	<? $query = mysqli_query($lnk,"SELECT * FROM user WHERE id!='$id_user' ORDER BY nome ASC");
						while($linha = mysqli_fetch_array($query)){
							$id_util = $linha['id'];
							$nome = $linha['nome'];?>
                        	<option class="selS" value="<? echo $id_util?>"><? echo $nome?></option>
                        <? }?>	
                    </select>
                    <input type="button" class="btV margin-top10 floatr" name="guardar" value="ENVIAR" onclick="enviar();" />
					<div class="clear"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</article>
<? include '_footer.php';?>
<!-- MODALS -->
<div id="ENVIARTODOS" class="modal">
	<div class="modalFundo" onClick="esconder('ENVIARTODOS');"></div>
	<span class="modalClose lnr lnr-cross-circle" onClick="esconder('ENVIARTODOS');"></span>
	<div class="modalSize">
		<div class="modalHead">Enviar para todos</div>
		<div class="modalBody">Tem a certeza que deseja enviar esta mensagem para todos?</div>
		<div class="modalFoot">
			<button class="btV modalBt" name="sim" onclick="$('#FORMULARIO').submit();">ENVIAR</button>
			<button class="btA modalBt" name="nao" onclick="esconder('ENVIARTODOS');">CANCELAR</button>
		</div>
	</div>
</div>
<!-- -->
<script>
function enviar(){
	var mensagem = $('#mensagem').val();
	if(mensagem){
		var recetor = $('#id_recetor').val();
		if(recetor==0){mostrar('ENVIARTODOS');}
		else{$('#FORMULARIO').submit();}
	}
}
$(document).ready(function (e) {
	$("#FORMULARIO").on('submit',(function(e) {
		e.preventDefault();
		$.ajax({
			url: "/admin/_chat/novo.php",
			type: "POST",
			data: new FormData(this),
			contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
			cache: false,
			processData:false, // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
			success: function(data){
				data = data.replace(/^\s+|\s+$/g,"");
				if(data){
					$('#mensagem').val('');
				}
				esconder('ENVIARTODOS');
			}         
		});
	}));
});
$( document ).ready(function() {
	//$('#CHAT').scrollTop($('#CHAT').outerHeight());
	//$('#CHAT').animate({ scrollTop: $('#FUNDO').offset().top}, 0);
	$('#CHAT').animate({ scrollTop: document.getElementById('CHAT').scrollHeight}, 0);

	function loadLog(){
        var oldscrollHeight = $("#CHAT").scrollTop();
        //$('#CHAT').animate({ scrollTop: $('#FUNDO').offset().top}, 0);
        var fundocrollHeight = document.getElementById('CHAT').scrollHeight - 498;
        //alert(oldscrollHeight+" - "+fundocrollHeight);
        $.ajax({
            url: "_chat/atualizar.php",
            cache: false,
            success: function(html){
                $("#CHAT").html(html);                
                //Auto-scroll
                if(oldscrollHeight >= fundocrollHeight){
                    $('#CHAT').animate({ scrollTop: document.getElementById('CHAT').scrollHeight}, 0);
                }
            }
        });
    }
    setInterval (loadLog, 5000);
});
</script>
</body>
</html>