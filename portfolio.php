<?php
error_reporting(E_ERROR);
ini_set('display_errors', '1');
?>
<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Sá Machado</title>
<? include '_head.php';?>
<!-- SCROLL -->
<link rel="stylesheet" href="/js/nanoscroller/nanoscroller.css">
<script type="text/javascript" src="/js/nanoscroller/jquery.nanoscroller.js"></script>
<script type="text/javascript" src="/js/nanoscroller/main.js"></script>
</head>

<body>
<? $sep='portfolio';
include '_header.php';?>
<article class="portfolio-fundo portfolio-margens">
	<section class="portfolio-conteudo">
		<div class="portfolio-filtro">
			<!--<a href="/apresentacao/Sa-machado.pdf" download><div class="news-apresentacao" style="float:right"><? if($IDIOMA=='EN'){echo "PRESENTATION";} if($IDIOMA=='PT'){echo "APRESENTAÇÃO";} if($IDIOMA=='FR'){echo "PRÉSENTATION";} if($IDIOMA=='ES'){echo "PRESENTACIÓN";} ?></div></a>-->
			<div class="portfolio-lupa DN768" id="LUPA-TLM" onClick="mostrar('MPARAMETROS');"></div>
			<div class="portfolio-lupa DB768" id="LUPA" onClick="parametros();"></div>
			<div class="DB768">
				<div id="PARAMETROS" class="portfolio-parametros none">
					<?
					$inicio='';$fim='';$id_pais='';$categoria='';$pesquisa='';

					$url_completo = $_SERVER['REQUEST_URI'];
					$url_partes = explode("/", $url_completo);
					$inicio = urldecode($url_partes[2]);
					$inicio = filter_var($inicio, FILTER_VALIDATE_INT);
					$fim = urldecode($url_partes[3]);
					$fim = filter_var($fim, FILTER_VALIDATE_INT);
					$id_pais = urldecode($url_partes[4]);
					$id_pais = filter_var($id_pais, FILTER_VALIDATE_INT);
					$categoria = urldecode($url_partes[5]);
					$categoria = filter_var($categoria, FILTER_VALIDATE_INT);
					$pesquisa = urldecode($url_partes[6]);
					?>
					<input type="text" name="pesquisa" id="PALAVRA" onKeyUp="setTimeout(function(){ pesquisa(); },200);" value="<? echo $pesquisa;?>">

					<select name="inicio" id="INICIO" onChange="setTimeout(function(){ pesquisa(); },200);">
						<option value="0"><? if($IDIOMA=='EN'){echo "Started in";} if($IDIOMA=='PT'){echo "Iniciado em";} if($IDIOMA=='FR'){echo "Commencé en";} if($IDIOMA=='ES'){echo "Inició en";} ?></option>
		            	<?
						$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE inicio!='0000-00-00' ORDER BY inicio ASC"));
						$data_inicio = $linha['inicio'];
						$ano_inicio=substr($data_inicio, 0, 4);
						$ano=date('Y');
						while ($ano >= $ano_inicio){
							?>
			            	<option value="<? echo $ano;?>" <? if($ano==$inicio){echo "selected";}?>><? echo $ano;?></option><?
			            	$ano--;
		            	}?>
		            </select>
		            <select id="select_INICIO" class="none"><option id="option_INICIO"></option></select>

		            <select name="fim" id="FIM" onChange="setTimeout(function(){ pesquisa(); },200);">
						<option value="0"><? if($IDIOMA=='EN'){echo "Finished in";} if($IDIOMA=='PT'){echo "Terminado em";} if($IDIOMA=='FR'){echo "Terminé en";} if($IDIOMA=='ES'){echo "Acabado en";} ?></option>
						<?
						$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE fim!='0000-00-00' ORDER BY fim ASC"));
						$data_fim = $linha['fim'];
						$ano_fim=substr($data_fim, 0, 4);
						$ano=date('Y');
						while ($ano >= $ano_fim){
							?>
			            	<option value="<? echo $ano;?>" <? if($ano==$fim){echo "selected";}?>><? echo $ano;?></option><?
			            	$ano--;
		            	}?>

		            	<option value="1" <? if('1'==$fim){echo "selected";}?>><? if($IDIOMA=='EN'){echo "Under construction";} if($IDIOMA=='PT'){echo "Em construção";} if($IDIOMA=='FR'){echo "En construction";} if($IDIOMA=='ES'){echo "En construcción";} ?></option>
		            </select>
		            <select id="select_FIM" class="none"><option id="option_FIM"></option></select>

		            <select name="pais" id="PAIS" onChange="setTimeout(function(){ pesquisa(); },200);">
						<option value="0"><? if($IDIOMA=='EN'){echo "Country";} if($IDIOMA=='PT'){echo "País";} if($IDIOMA=='FR'){echo "Pays";} if($IDIOMA=='ES'){echo "País";} ?>&nbsp;</option>
						<?
						$query=mysqli_query($lnk,"SELECT * FROM pais ORDER BY nome_en ASC");
						while ($linha = mysqli_fetch_array($query)){
							$id = $linha['id'];
							if($IDIOMA=='EN'){ $nome_pais=$linha["nome_en"]; }
							if($IDIOMA=='PT'){ $nome_pais=$linha["nome_pt"]; }
							if($IDIOMA=='FR'){ $nome_pais=$linha["nome_fr"]; }
							if($IDIOMA=='ES'){ $nome_pais=$linha["nome_es"]; }
							$existe=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha WHERE id_pais='$id'"));
							if($existe){?>
			            		<option value="<? echo $id;?>" <? if($id==$id_pais){echo "selected";}?>><? echo $nome_pais;?></option><?
			            	}
		            	}?>
		            </select>
		            <select id="select_PAIS" class="none"><option id="option_PAIS"></option></select>

		            <select name="categoria" id="CATEGORIA" onChange="setTimeout(function(){ pesquisa(); },200);">
						<option value="0"><? if($IDIOMA=='EN'){echo "Category";} if($IDIOMA=='PT'){echo "Categoria";} if($IDIOMA=='FR'){echo "Catégorie";} if($IDIOMA=='ES'){echo "Categoría";} ?></option>
						<?
						$query=mysqli_query($lnk,"SELECT * FROM categoria ORDER BY nome_en ASC");
						while ($linha = mysqli_fetch_array($query)){
							$id = $linha['id'];
							if($IDIOMA=='EN'){ $nome_categoria=$linha["nome_en"]; }
							if($IDIOMA=='PT'){ $nome_categoria=$linha["nome"]; }
							if($IDIOMA=='FR'){ $nome_categoria=$linha["nome_fr"]; }
							if($IDIOMA=='ES'){ $nome_categoria=$linha["nome_es"]; }
							?>
			            		<option value="<? echo $id;?>" <? if($id==$categoria){echo "selected";}?>><? echo $nome_categoria;?></option><?
		            	}?>
		            </select>
		            <select id="select_CATEGORIA" class="none"><option id="option_CATEGORIA"></option></select>
		        </div>
	        </div>
	        <a href="http://reabilitacao.aiccopn.pt" target="_blank" class="portfolio-ruis"></a>
		</div>
		<div class="portfolio-scroll nano">
			<div id="RESULTADO" class="nano-content">
				<? include('_portfolio/fichas.php'); ?>
			</div>
		</div>
	</section>
</article>
<!-- MODALS -->
<div id="MPARAMETROS" class="portfolio-modal DN768">
	<section class="portfolio-size">
		<span class="portfolio-close" onClick="limpar(); esconder('MPARAMETROS');">X</span>
		<div class="portfolio-body">
			<div class="clear"></div>
			<span><? if($IDIOMA=='EN'){echo "SEARCH";} if($IDIOMA=='PT'){echo "PESQUISA";} if($IDIOMA=='FR'){echo "CHERCHER";} if($IDIOMA=='ES'){echo "BUSCAR";} ?></span>
			<div class="clear"></div>
			<?
			$url_completo = $_SERVER['REQUEST_URI'];
			$url_partes = explode("/", $url_completo);
			$inicio = urldecode($url_partes[2]);
			$inicio = filter_var($inicio, FILTER_VALIDATE_INT);
			$fim = urldecode($url_partes[3]);
			$fim = filter_var($fim, FILTER_VALIDATE_INT);
			$id_pais = urldecode($url_partes[4]);
			$id_pais = filter_var($id_pais, FILTER_VALIDATE_INT);
			$categoria = urldecode($url_partes[5]);
			$categoria = filter_var($categoria, FILTER_VALIDATE_INT);
			$pesquisa = urldecode($url_partes[6]);
			?>
			
			<select name="inicio" id="INICIO2" onChange="setTimeout(function(){ pesquisa2(); },200);">
				<option value="0"><? if($IDIOMA=='EN'){echo "Started in";} if($IDIOMA=='PT'){echo "Iniciado em";} if($IDIOMA=='FR'){echo "Commencé en";} if($IDIOMA=='ES'){echo "Inició en";} ?></option>
            	<?
				$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE inicio!='0000-00-00' ORDER BY inicio ASC"));
				$data_inicio = $linha['inicio'];
				$ano_inicio=substr($data_inicio, 0, 4);
				$ano=date('Y');
				while ($ano >= $ano_inicio){
					?>
	            	<option value="<? echo $ano;?>" <? if($ano==$inicio){echo "selected";}?>><? echo $ano;?></option><?
	            	$ano--;
            	}?>
            </select>
            <select name="fim" id="FIM2" onChange="setTimeout(function(){ pesquisa2(); },200);">
				<option value="0"><? if($IDIOMA=='EN'){echo "Finished in";} if($IDIOMA=='PT'){echo "Terminado em";} if($IDIOMA=='FR'){echo "Terminé en";} if($IDIOMA=='ES'){echo "Acabado en";} ?></option>
				<?
				$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE fim!='0000-00-00' ORDER BY fim ASC"));
				$data_fim = $linha['fim'];
				$ano_fim=substr($data_fim, 0, 4);
				$ano=date('Y');
				while ($ano >= $ano_fim){
					?>
	            	<option value="<? echo $ano;?>" <? if($ano==$fim){echo "selected";}?>><? echo $ano;?></option><?
	            	$ano--;
            	}?>
            </select>
            <select name="pais" id="PAIS2" onChange="setTimeout(function(){ pesquisa2(); },200);">
				<option value="0"><? if($IDIOMA=='EN'){echo "Country";} if($IDIOMA=='PT'){echo "País";} if($IDIOMA=='FR'){echo "Pays";} if($IDIOMA=='ES'){echo "País";} ?>&nbsp;</option>
				<?
				$query=mysqli_query($lnk,"SELECT * FROM pais ORDER BY nome_en ASC");
				while ($linha = mysqli_fetch_array($query)){
					$id = $linha['id'];
					if($IDIOMA=='EN'){ $nome_pais=$linha["nome_en"]; }
					if($IDIOMA=='PT'){ $nome_pais=$linha["nome_pt"]; }
					if($IDIOMA=='FR'){ $nome_pais=$linha["nome_fr"]; }
					if($IDIOMA=='ES'){ $nome_pais=$linha["nome_es"]; }
					$existe=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha WHERE id_pais='$id'"));
					if($existe){?>
	            		<option value="<? echo $id;?>" <? if($id==$id_pais){echo "selected";}?>><? echo $nome_pais;?></option><?
	            	}
            	}?>
            </select>
            <select name="categoria" id="CATEGORIA2" onChange="setTimeout(function(){ pesquisa2(); },200);">
				<option value="0"><? if($IDIOMA=='EN'){echo "Category";} if($IDIOMA=='PT'){echo "Categoria";} if($IDIOMA=='FR'){echo "Catégorie";} if($IDIOMA=='ES'){echo "Categoría";} ?></option>
				<?
				$query=mysqli_query($lnk,"SELECT * FROM categoria ORDER BY nome_en ASC");
				while ($linha = mysqli_fetch_array($query)){
					$id = $linha['id'];
					if($IDIOMA=='EN'){ $nome_categoria=$linha["nome_en"]; }
					if($IDIOMA=='PT'){ $nome_categoria=$linha["nome"]; }
					if($IDIOMA=='FR'){ $nome_categoria=$linha["nome_fr"]; }
					if($IDIOMA=='ES'){ $nome_categoria=$linha["nome_es"]; }
					?>
	            		<option value="<? echo $id;?>" <? if($id==$categoria){echo "selected";}?>><? echo $nome_categoria;?></option><?
            	}?>
            </select>
            <input type="text" name="pesquisa" id="PALAVRA2" onKeyUp="setTimeout(function(){ pesquisa2(); },200);" value="<? echo $pesquisa;?>">
			<button type="button" name="subscrever" onclick="esconder('MPARAMETROS');">OK</button>
		</div>	
	</section>
</div>
<!-- -->
<script>
$(document).ready(function() {
	//$('select').prop('selectedIndex', 0);
	$('#INICIO').change(function(){
		$("#option_INICIO").html($('#INICIO option:selected').text()); 
		$(this).width($("#select_INICIO").width());
	});
	$('#FIM').change(function(){
		$("#option_FIM").html($('#FIM option:selected').text()); 
		$(this).width($("#select_FIM").width());
	});
	$('#PAIS').change(function(){
		$("#option_PAIS").html($('#PAIS option:selected').text()); 
		$(this).width($("#select_PAIS").width());
	});
	$('#CATEGORIA').change(function(){
		$("#option_CATEGORIA").html($('#CATEGORIA option:selected').text()); 
		$(this).width($("#select_CATEGORIA").width());
	});
});
function limpar(){
	$('#PALAVRA').val('');
	$('#PALAVRA_TLM').val('');
	$('select').prop('selectedIndex', 0);
	window.history.pushState("object or string", "Title", "/portfolio");
	pesquisa();
}

function ajustar_tamanho(){
	$("#option_INICIO").html($('#INICIO option:selected').text()); 
	$('#INICIO').width($("#select_INICIO").width());
	$("#option_FIM").html($('#FIM option:selected').text()); 
	$('#FIM').width($("#select_FIM").width());
	$("#option_PAIS").html($('#PAIS option:selected').text()); 
	$('#PAIS').width($("#select_PAIS").width());
	$("#option_CATEGORIA").html($('#CATEGORIA option:selected').text()); 
	$('#CATEGORIA').width($("#select_CATEGORIA").width());
}

var aux=2;
function parametros(){
	if(aux){
		$('#PARAMETROS').css("display","block");
		$('#LUPA').css("background-position","-20px 0");
		if(aux==2){ ajustar_tamanho(); }
		aux=0;
	}else{
		$('#PALAVRA_TLM').val('');
		$('#PALAVRA').val('');
		$('select').prop('selectedIndex', 0);
		ajustar_tamanho();
		window.history.pushState("object or string", "Title", "/portfolio");
		$('#PARAMETROS').css("display","none");
		$('#LUPA').css("background-position","0 0");
		pesquisa();
		aux=1;
	}
}
function pesquisa(){
	var pesquisa = $('#PALAVRA').val();
	pesquisa = pesquisa.replace(/^\s+|\s+$/g,"");
	var inicio = $('#INICIO').val();
	var fim = $('#FIM').val();
	var id_pais = $('#PAIS').val();
	var categoria = $('#CATEGORIA').val();
	jQuery.ajax({
	   type: "POST",
	   url: "/_portfolio/pesquisa.php",
	   data: 'pesquisa='+pesquisa+'&inicio='+inicio+'&fim='+fim+'&id_pais='+id_pais+'&categoria='+categoria,
	   success: function(data){ $('#RESULTADO').html(data); }
	});
	if(inicio==0 && fim==0 && id_pais==0 && categoria==0 && pesquisa==""){window.history.pushState("object or string", "Title", "/portfolio");}
	else{window.history.pushState("object or string", "Title", "/portfolio/"+inicio+"/"+fim+"/"+id_pais+"/"+categoria+"/"+pesquisa);}
}
function pesquisa2(){
	var pesquisa = $('#PALAVRA2').val();
	pesquisa = pesquisa.replace(/^\s+|\s+$/g,"");
	var inicio = $('#INICIO2').val();
	var fim = $('#FIM2').val();
	var id_pais = $('#PAIS2').val();
	var categoria = $('#CATEGORIA2').val();
	jQuery.ajax({
	   type: "POST",
	   url: "/_portfolio/pesquisa.php",
	   data: 'pesquisa='+pesquisa+'&inicio='+inicio+'&fim='+fim+'&id_pais='+id_pais+'&categoria='+categoria,
	   success: function(data){ $('#RESULTADO').html(data); }
	});
	if(inicio==0 && fim==0 && id_pais==0 && categoria==0 && pesquisa==""){window.history.pushState("object or string", "Title", "/portfolio");}
	else{window.history.pushState("object or string", "Title", "/portfolio/"+inicio+"/"+fim+"/"+id_pais+"/"+categoria+"/"+pesquisa);}
}
</script>
</body>
</html>