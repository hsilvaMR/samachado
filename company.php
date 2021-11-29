<? ob_start(); ?>
<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Sá Machado</title>
<? include '_head.php';?>
<!-- SLIDE -->
<link rel="stylesheet" href="/js/swiper/swiper.css" type="text/css">
<script type="text/javascript" src="/js/swiper/swiper.js"></script>
<!-- SCROLL -->
<link rel="stylesheet" href="/js/nanoscroller/nanoscroller.css">
<script type="text/javascript" src="/js/nanoscroller/jquery.nanoscroller.js"></script>
<script type="text/javascript" src="/js/nanoscroller/main.js"></script>
</head>

<body>
<? $sep='company';
include '_header.php';?>
<article class="companies-fundo companies-margens">
	<section class="company-conteudo">
		<div class="company-filtro">
			<?
			$url_completo = $_SERVER['REQUEST_URI'];
			$url_partes = explode("/", $url_completo);
			$id_linha = urldecode($url_partes[2]);
			$id_linha = filter_var($id_linha, FILTER_VALIDATE_INT);
			$existe=mysqli_num_rows(mysqli_query($lnk, "SELECT * FROM company WHERE online=1 AND id='$id_linha'"));
			if(!$existe){ header('Location: /world'); }
  			$linha = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM company WHERE online=1 AND id='$id_linha'"));
  			$id_world=$linha["id_world"];
  			$linha2 = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM world WHERE id='$id_world'"));
  			if($IDIOMA=='EN'){$pais = $linha2["nome_en"];}
			if($IDIOMA=='PT'){$pais = $linha2["nome"];}
			if($IDIOMA=='FR'){$pais = $linha2["nome_fr"];}
			if($IDIOMA=='ES'){$pais = $linha2["nome_es"];}
			$url_pais = str_replace(" ", "-", $pais);
			$quantidade=mysqli_num_rows(mysqli_query($lnk, "SELECT * FROM company WHERE online=1 AND id_world='$id_world'"));
	  		?>
			<!--<div class="world-circ"></div>
			<div class="companies-notificacoes"><? echo $nomeUp; ?></div>-->
			<div class="companies-notificacoes">
				<select id="res_PAIS">
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
						$url_nome = str_replace(" ", "-", $nome); ?>
                        <option value="<? echo $id.'/'.$url_nome; ?>" <? if($id==$id_world){echo "selected";}?>><? echo $nomeUp; ?></option>
                    <?}?>
				</select>
				<select id="width_tmp_select" class="none"><option id="width_tmp_option"></option></select>
			</div>	
			<?if($quantidade>1){?><a href="/companies/<? echo $id_world.'/'.$url_pais; ?>"><div class="companies-all"><? if($IDIOMA=='EN'){echo "VIEW ALL";} if($IDIOMA=='PT'){echo "VER TUDO";} if($IDIOMA=='FR'){echo "VOIR TOUT";} if($IDIOMA=='ES'){echo "VER TODO";} ?></div></a><?}?>

		</div>
		<div class="company-scroll">
			<div class="swiper-container">
	    		<div class="swiper-wrapper">
				<?
				$url_completo = $_SERVER['REQUEST_URI'];
				$url_partes = explode("/", $url_completo);
				$id_linha = urldecode($url_partes[2]);
				$id_linha = filter_var($id_linha, FILTER_VALIDATE_INT);
				$slide_inicial = 0;
				$i=0;

				$query=mysqli_query($lnk, "SELECT * FROM company WHERE online=1 AND id_world='$id_world'");
	  			while ($linha=mysqli_fetch_array($query)){
					$id=$linha["id"];
					$id_category=$linha["id_category"];
					$nome=$linha["nome"];
					$url_nome = str_replace(" ", "-", $nome);
					$img=$linha["logo"];
					$linha2=mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM category WHERE id='$id_category'"));
					if($IDIOMA=='EN'){ $category=$linha2["nome_en"]; }
					if($IDIOMA=='PT'){ $category=$linha2["nome"]; }
					if($IDIOMA=='FR'){ $category=$linha2["nome_fr"]; }
					if($IDIOMA=='ES'){ $category=$linha2["nome_es"]; }

					if($id==$id_linha){$slide_inicial = $i;}
					if($IDIOMA=='EN'){ $texto=$linha["texto_en"]; }
					if($IDIOMA=='PT'){ $texto=$linha["texto"]; }
					if($IDIOMA=='FR'){ $texto=$linha["texto_fr"]; }
					if($IDIOMA=='ES'){ $texto=$linha["texto_es"]; }

					$img=$linha["logo"];
					$i++;
					?>
					<div class="swiper-slide">
						<div class="company-esquerda" style="background-image:url(<? echo $img; ?>);"></div>
			            <div class="company-direita">
			            	<div class="nano">
				            	<div class="nano-content">
					            	<div class="company-data"><b><? echo $category; ?></b></div>
					            	<div class="company-titulo"><? echo $nome; ?></div>
					            	<div class="company-texto"><? echo $texto; ?></div>
					            </div>
					        </div>
			            </div>
					</div><?
				} ?>
				</div>
			</div>
			<!-- Add Arrows -->
	        <div class="swiper-button-next swiper-button-cinza"></div>
	        <div class="swiper-button-prev swiper-button-cinza"></div>
		</div>
	</section>
</article>
<script>
var swiper = new Swiper('.swiper-container', {
    slidesPerView: 1,
    spaceBetween: 80,
    keyboardControl: true,
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
	loop: false,
	initialSlide: '<? echo $slide_inicial;?>',
});
$(document).ready(function() {
	//$('select').prop('selectedIndex', 0);

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