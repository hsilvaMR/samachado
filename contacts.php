<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Sá Machado</title>
<? include '_head.php';?>
<!--<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>-->
</head>

<body>
<article class="contacts-fundo">
	<? $sep='contacts'; include '_header.php';?>
	<div class="contacts-margens">
		<section class="contacts-mapas">
			<div id="MAPA0" class="contacts-mapa" style="background-image:url(/img/mapa.png);"></div>
			<div id="MAPA1" class="contacts-mapa hidden"></div>
			<div id="MAPA2" class="contacts-mapa hidden"></div>
			<div id="MAPA3" class="contacts-mapa hidden"></div>
			<div id="MAPA4" class="contacts-mapa hidden"></div>
			<div id="MAPA5" class="contacts-mapa hidden"></div>
			<div id="MAPA6" class="contacts-mapa hidden"></div>
			<div id="MAPA7" class="contacts-mapa hidden"></div>
			<div id="MAPA8" class="contacts-mapa hidden"></div>
			<div id="MAPA9" class="contacts-mapa hidden"></div>
			<div class="contacts-select">
				<select id="resizing_PAIS">
					<option value="0"><? if($IDIOMA=='EN'){echo "GET IN TOUCH";} if($IDIOMA=='PT'){echo "ENTRAR EM CONTACTO";} if($IDIOMA=='FR'){echo "ENTRER EN CONTACT";} if($IDIOMA=='ES'){echo "ESTAR EN CONTACTO";} ?></option>
	            	<option value="1">Portugal</option>
	            	<option value="2">Portugal - <? if($IDIOMA=='EN'){echo "Madeira Archipelago";} if($IDIOMA=='PT'){echo "Arquipélago da Madeira";} if($IDIOMA=='FR'){echo "L'archipel de Madère";} if($IDIOMA=='ES'){echo "Archipiélago de Madeira";} ?></option>
	            	<option value="3">Angola</option>
	            	<option value="4"><? if($IDIOMA=='EN'){echo "Brazil";} if($IDIOMA=='PT'){echo "Brasil";} if($IDIOMA=='FR'){echo "Brésil";} if($IDIOMA=='ES'){echo "Brasil";} ?></option>
	            	<option value="5"><? if($IDIOMA=='EN'){echo "France";} if($IDIOMA=='PT'){echo "França";} if($IDIOMA=='FR'){echo "France";} if($IDIOMA=='ES'){echo "Francia";} ?></option>
	            	<option value="6"><? if($IDIOMA=='EN'){echo "Ghana";} if($IDIOMA=='PT'){echo "Gana";} if($IDIOMA=='FR'){echo "Ghana";} if($IDIOMA=='ES'){echo "Ghana";} ?></option>
	            	<option value="7"><? if($IDIOMA=='EN'){echo "Mozambique";} if($IDIOMA=='PT'){echo "Moçambique";} if($IDIOMA=='FR'){echo "Mozambique";} if($IDIOMA=='ES'){echo "Mozambique";} ?></option>
	            	<option value="8"><? if($IDIOMA=='EN'){echo "South Africa";} if($IDIOMA=='PT'){echo "África do Sul";} if($IDIOMA=='FR'){echo "Afrique du Sud";} if($IDIOMA=='ES'){echo "Sudáfrica";} ?></option>
					<option value="9"><? if($IDIOMA=='EN'){echo "Belgium";} if($IDIOMA=='PT'){echo "Bélgica";} if($IDIOMA=='FR'){echo "Belgique";} if($IDIOMA=='ES'){echo "Bélgica";} ?></option>
				</select>
				<select id="width_tmp_select" class="none"><option id="width_tmp_option"></option></select>
			</div>
			<div class="contacts-morada">
				<span id="MORA0" class="none"></span>
				<span id="MORA1" class="none">Sá Machado, Lda - Avenida Liberdade, N.º 434, 3.º Andar, Sala 1 4710-249 Braga | Nif: 514316403 | Tel: +351&nbsp;253&nbsp;929&nbsp;000 | Fax: +351&nbsp;253&nbsp;929&nbsp;010 | mail@sa-machado.com</span>
				<span id="MORA2" class="none">Sá Machado, Lda - Rua da Alegria, nº31 - 3º esq, 9000-040 Funchal | Tel: +351&nbsp;291&nbsp;708&nbsp;450 | Fax: +351&nbsp;291&nbsp;708&nbsp;450 | mail@sa-machado.com</span>
				<span id="MORA3" class="none">Sá Machado Angola – Construção Civil, S.A. - Via AL 16, Condomínio Village,  Moradia n.º1 ,  Talatona – Luanda | +244&nbsp;940&nbsp;946&nbsp;130/1/2/3 | angola.geral@sa-machado.com</span>
				<span id="MORA4" class="none">SM Brasil Construtora e Incorporadora, Lda. - Rua Governador Celso Ramos, 2980, SALA 03 - Bairro: CENTRO - Porto Belo - CEP: 88210-000 | samachado.br@sa-machado.com</span>
				<span id="MORA5" class="none">SM Engennering França - 2 à 12 Chemins de Fourches - 93380 Pierrefitte Sur Seine</span>
				<span id="MORA6" class="none">Sá Machado Limited - P.O. Box CT 11217, Cantonments, Accra – Ghana | +233&nbsp;(0)&nbsp;307&nbsp;038&nbsp;329 | samachado.gh@sa-machado.com</span>
				<span id="MORA7" class="none">Sá Machado Moçambique,S.A. - Av. Salvador Allende, 1097, 1º Andar</span>
				<span id="MORA8" class="none">SM Engineering South Arica (pty) Ltd - Postnet suite 164 - Private bag X9924 - Sandton 2146 - South Africa | Tel: +27&nbsp;(0)&nbsp;11&nbsp;243&nbsp;5001 | Fax: +27&nbsp;(0)&nbsp;11&nbsp;243&nbsp;5002</span>
				<span id="MORA9" class="none">SM Engennering Bélgica - SM Engineering | Chaussée d’Alsemberg 842 - B-1180 - Bruxelles</span>
			</div>
		</section>
	</div>
</article>
<script>
$(document).ready(function() {
	$('select').prop('selectedIndex', 0);

	$("#width_tmp_option").html($('#resizing_PAIS option:selected').text()); 
	$('#resizing_PAIS').width($("#width_tmp_select").width());

	$('#resizing_PAIS').change(function(){
		$("#width_tmp_option").html($('#resizing_PAIS option:selected').text()); 
		$(this).width($("#width_tmp_select").width());

		var pais = $('#resizing_PAIS').val();
		for (i = 0; i <= 9; i++) {
			if(i == pais){
				$('#MAPA'+i).css("visibility","visible");
				$('#MORA'+i).css("display","block");
			}else{
				$('#MAPA'+i).css("visibility","hidden");
				$('#MORA'+i).css("display","none");
			}
		}
	});
});
$( window ).load(function() {
	$('#MAPA1').css("background-image","url(/img/mapa-pt.png)");
	$('#MAPA2').css("background-image","url(/img/mapa-pt.png)");
	$('#MAPA3').css("background-image","url(/img/mapa-ao.png)");
	$('#MAPA4').css("background-image","url(/img/mapa-br.png)");
	$('#MAPA5').css("background-image","url(/img/mapa-fr.png)");
	$('#MAPA6').css("background-image","url(/img/mapa-gh.png)");
	$('#MAPA7').css("background-image","url(/img/mapa-mz.png)");
	$('#MAPA8').css("background-image","url(/img/mapa-za.png)");
	$('#MAPA9').css("background-image","url(/img/mapa-be.png)");
});
</script>
</body>
</html>