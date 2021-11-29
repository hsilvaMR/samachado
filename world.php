<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Sá Machado</title>
<? include '_head.php';?>
<!--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>-->
</head>

<body>
<article class="world-fundo">
	<? $sep='world'; include '_header.php';?>
	<div class="world-margens">
		<section class="world-mapas">
			<div class="world-mapa"></div>
			<div class="world-sel">
				<select id="res_PAIS">
					<option value="0"><? if($IDIOMA=='EN'){echo "AROUND THE WORLD";} if($IDIOMA=='PT'){echo "À VOLTA DO MUNDO";} if($IDIOMA=='FR'){echo "AUTOUR DU MONDE";} if($IDIOMA=='ES'){echo "ALREDEDOR DEL MUNDO";} ?></option>
	            	<?
                    $query = mysqli_query($lnk,"SELECT * FROM world WHERE online=1");
					while($linha = mysqli_fetch_array($query))
					{
						$id = $linha["id"];
						if($IDIOMA=='EN'){$nome = $linha["nome_en"];}
						if($IDIOMA=='PT'){$nome = $linha["nome"];}
						if($IDIOMA=='FR'){$nome = $linha["nome_fr"];}
						if($IDIOMA=='ES'){$nome = $linha["nome_es"];}
						$nomeUp = strtoupper($nome);
						$nomeUp = str_replace("ç", "Ç", $nomeUp);
						$nomeUp = str_replace("á", "Á", $nomeUp);
						$nomeUp = str_replace("à", "À", $nomeUp);
						$nomeUp = str_replace("é", "É", $nomeUp);
						$nomeUp = str_replace("è", "È", $nomeUp);
						$url_nome = str_replace(" ", "-", $nome); ?>
                        <option value="<? echo $id.'/'.$url_nome; ?>"><? echo $nomeUp; ?></option>
                    <?}?>
				</select>
				<select id="width_tmp_select" class="none"><option id="width_tmp_option"></option></select>
			</div>
		</section>
	</div>
</article>
<script>
$(document).ready(function() {
	$('select').prop('selectedIndex', 0);

	$("#width_tmp_option").html($('#res_PAIS option:selected').text()); 
	$('#res_PAIS').width($("#width_tmp_select").width());

	$('#res_PAIS').change(function(){
		$("#width_tmp_option").html($('#res_PAIS option:selected').text()); 
		$(this).width($("#width_tmp_select").width());

		var pais = $('#res_PAIS').val();
		window.location.replace("/companies/"+pais);
	});
});
</script>
</body>
</html>