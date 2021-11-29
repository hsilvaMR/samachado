<? ob_start(); ?>
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
<? $sep='disclaimer';
include '_header.php';?>
<?php
// Facebook
$url_completo = $_SERVER['REQUEST_URI'];
$url_partes = explode("/", $url_completo);
$url_email = urldecode($url_partes[2]);
$url_email = filter_var($url_email, FILTER_VALIDATE_EMAIL);
if($url_email){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM newsletter WHERE email='$url_email'")));}
?>
<article class="home-fundo portfolio-margens">
	<section class="portfolio-conteudo">
		<div class="portfolio-scroll nano">
			<div class="nano-content">
				<div class="unsubscribe">
					<div class="unsubscribe-titulo">
						<? if($IDIOMA=='EN'){ echo "Select the categories you want to cancel*"; } ?>
						<? if($IDIOMA=='PT'){ echo "Selecione as categorias que deseja anular*"; } ?>
					    <? if($IDIOMA=='FR'){ echo "Sélectionnez les catégories que vous souhaitez annuler*"; } ?>
					    <? if($IDIOMA=='ES'){ echo "Seleccione las categorías que desea deshacer*"; } ?>
					</div>
					<input type="checkbox" id="check1" class="RD" value="1" <?php if(isset($perfil) && $perfil) echo 'checked';?>>
					<label for="check1">&nbsp;</label>
					<label for="check1">&nbsp;<? if($IDIOMA=='EN'){echo "Profile";} if($IDIOMA=='PT'){echo "Perfil";} if($IDIOMA=='FR'){echo "Profil";} if($IDIOMA=='ES'){echo "Perfil";} ?></label>
					<br><br>
					<input type="checkbox" id="check2" class="RD" value="1" <?php if(isset($portfolio) && $portfolio) echo 'checked';?>>
					<label for="check2">&nbsp;</label>
					<label for="check2">&nbsp;<? if($IDIOMA=='EN'){echo "Portfolio";} if($IDIOMA=='PT'){echo "Portfólio";} if($IDIOMA=='FR'){echo "Portefeuille";} if($IDIOMA=='ES'){echo "Portafolio";} ?></label>					
					<br><br>
					<input type="checkbox" id="check3" class="RD" value="1" <?php if(isset($noticias) && $noticias) echo 'checked';?>>
					<label for="check3">&nbsp;</label>
					<label for="check3">&nbsp;<? if($IDIOMA=='EN'){echo "News";} if($IDIOMA=='PT'){echo "Notícias";} if($IDIOMA=='FR'){echo "Nouvelles";} if($IDIOMA=='ES'){echo "Noticias";} ?></label>					
					<br><br>
					<input type="checkbox" id="check4" class="RD" value="1" <?php if(isset($emprego) && $emprego) echo 'checked';?>>
					<label for="check4">&nbsp;</label>
					<label for="check4">&nbsp;<? if($IDIOMA=='EN'){echo "Job offers";} if($IDIOMA=='PT'){echo "Ofertas de Emprego";} if($IDIOMA=='FR'){echo "Offres D'Emplois";} if($IDIOMA=='ES'){echo "Ofertas de Trabajo";} ?></label>					
					<!--
					<input type="checkbox" id="check5" class="RD" value="1">
					<label for="check5">&nbsp;</label>
					<label for="check5">&nbsp;<? if($IDIOMA=='EN'){echo "Contacts";} if($IDIOMA=='PT'){echo "Contactos";} if($IDIOMA=='FR'){echo "Contacts";} if($IDIOMA=='ES'){echo "Contactos";} ?></label>
					<input type="checkbox" id="check6" class="RD" value="1">
					<label for="check6">&nbsp;</label>
					<label for="check6">&nbsp;<? if($IDIOMA=='EN'){echo "Prizes";} if($IDIOMA=='PT'){echo "Prizes";} if($IDIOMA=='FR'){echo "Prizes";} if($IDIOMA=='ES'){echo "Prizes";} ?></label>
					-->
					<br><br>
					<div class="clear"></div>
					<input type="email" id="email" name="email" placeholder="<? if($IDIOMA=='EN'){echo "your email";} if($IDIOMA=='PT'){echo "seu email";} if($IDIOMA=='FR'){echo "ton email";} if($IDIOMA=='ES'){echo "tu correo electrónico";} ?>" value="<?php if(isset($email) && $email) echo $email;?>">
					<button type="button" name="subscrever" onclick="unsubscribe();"><? if($IDIOMA=='EN'){echo "UNSUBSCRIBE";} if($IDIOMA=='PT'){echo "ANULAR SUBSCRIÇÃO";} if($IDIOMA=='FR'){echo "SE DÉSABONNER";} if($IDIOMA=='ES'){echo "DESCABEZAR";} ?></button>
					<div class="clear"></div>
					<div class="unsubscribe-alerta" id="alerta"></div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</section>
</article>
<!-- -->
<script>
function unsubscribe(){
	var email = $('#email').val();
	var ch1 = document.getElementById('check1').checked;
	if(ch1){ ch1=1; }else{ ch1=0; }
	var ch2 = document.getElementById('check2').checked;
	if(ch2){ ch2=1; }else{ ch2=0; }
	var ch3 = document.getElementById('check3').checked;
	if(ch3){ ch3=1; }else{ ch3=0; }
	var ch4 = document.getElementById('check4').checked;
	if(ch4){ ch4=1; }else{ ch4=0; }
	$.post("/subscrever/js_anular_subscricao.php",{ ch1:ch1, ch2:ch2, ch3:ch3, ch4:ch4, email:email }) 
    .done(function( data ){
    	var jsonRetorna = $.parseJSON(data);
		if(jsonRetorna == 'TM') {
			<? if($IDIOMA=='EN'){ ?> $('#alerta').html('Successfully saved.'); <? } ?>
			<? if($IDIOMA=='PT'){ ?> $('#alerta').html('Guardado com sucesso.'); <? } ?>
		    <? if($IDIOMA=='FR'){ ?> $('#alerta').html('Enregistré avec succès.'); <? } ?>
		    <? if($IDIOMA=='ES'){ ?> $('#alerta').html('Guardado con éxito.'); <? } ?>
			setTimeout(function(){
				$('#alerta').html('');
			}, 3000);
		}else{
			$('#alerta').html(jsonRetorna);
		}
    });
}
</script>
</body>
</html>