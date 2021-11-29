<!-- MODALS -->
<div id="NOTIFICACOES" class="notificacoes-modal">
	<section class="notificacoes-size">
		<span class="notificacoes-close" onClick="esconder('NOTIFICACOES');">X</span>
		<div class="clear"></div>
			<div class="notificacoes-body">
				<div class="notificacoes-titulo">
					<? if($IDIOMA=='EN'){ echo "Select the categories you have interest in*"; } ?>
					<? if($IDIOMA=='PT'){ echo "Selecione as categorias do seu interesse*"; } ?>
				    <? if($IDIOMA=='FR'){ echo "Sélectionner les catégories de votre intérêt*"; } ?>
				    <? if($IDIOMA=='ES'){ echo "Seleccione las categorías de su interés*"; } ?>
				</div>
				<div class="notificacoes-categorias">
					<div class="notificacoes-cat-esq">
						<label for="check1"><? if($IDIOMA=='EN'){echo "Profile";} if($IDIOMA=='PT'){echo "Perfil";} if($IDIOMA=='FR'){echo "Profil";} if($IDIOMA=='ES'){echo "Perfil";} ?></label>
						<input type="checkbox" id="check1" class="RD" value="1">
						<label for="check1">&nbsp;</label>
					</div>
					<div class="notificacoes-cat-dir">
						<label for="check2"><? if($IDIOMA=='EN'){echo "Portfolio";} if($IDIOMA=='PT'){echo "Portfólio";} if($IDIOMA=='FR'){echo "Portefeuille";} if($IDIOMA=='ES'){echo "Portafolio";} ?></label>
						<input type="checkbox" id="check2" class="RD" value="1">
						<label for="check2">&nbsp;</label>
					</div>
					<div class="notificacoes-cat-esq">
						<label for="check3"><? if($IDIOMA=='EN'){echo "News";} if($IDIOMA=='PT'){echo "Notícias";} if($IDIOMA=='FR'){echo "Nouvelles";} if($IDIOMA=='ES'){echo "Noticias";} ?></label>
						<input type="checkbox" id="check3" class="RD" value="1">
						<label for="check3">&nbsp;</label>
					</div>
					<div class="notificacoes-cat-dir">
						<label for="check4"><? if($IDIOMA=='EN'){echo "Job offers";} if($IDIOMA=='PT'){echo "Ofertas de Emprego";} if($IDIOMA=='FR'){echo "Offres D'Emplois";} if($IDIOMA=='ES'){echo "Ofertas de Trabajo";} ?></label>
						<input type="checkbox" id="check4" class="RD" value="1">
						<label for="check4">&nbsp;</label>
					</div>
					<!--<div class="notificacoes-cat-dir">
						<label for="check5"><? if($IDIOMA=='EN'){echo "Contacts";} if($IDIOMA=='PT'){echo "Contactos";} if($IDIOMA=='FR'){echo "Contacts";} if($IDIOMA=='ES'){echo "Contactos";} ?></label>
						<input type="checkbox" id="check5" class="RD" value="1">
						<label for="check5">&nbsp;</label>
					</div>
					<div class="notificacoes-cat-cen">
						<label for="check6"><? if($IDIOMA=='EN'){echo "Prizes";} if($IDIOMA=='PT'){echo "Prizes";} if($IDIOMA=='FR'){echo "Prizes";} if($IDIOMA=='ES'){echo "Prizes";} ?></label>
						<input type="checkbox" id="check6" class="RD" value="1">
						<label for="check6">&nbsp;</label>
					</div>-->
				</div>
				<div class="clear"></div>
				<input type="email" id="email" name="email" placeholder="<? if($IDIOMA=='EN'){echo "your email";} if($IDIOMA=='PT'){echo "seu email";} if($IDIOMA=='FR'){echo "ton email";} if($IDIOMA=='ES'){echo "tu correo electrónico";} ?>" value="">
				<button type="button" name="subscrever" onclick="subscrever();"><? if($IDIOMA=='EN'){echo "SUBSCRIBE";} if($IDIOMA=='PT'){echo "SUBSCREVER";} if($IDIOMA=='FR'){echo "SOUSCRIRE";} if($IDIOMA=='ES'){echo "SUSCRIBIR";} ?></button>
				<div class="notificacoes-aviso">
					<? if($IDIOMA=='EN'){ echo "* You'll only receive notifications of what you subscribe"; } ?>
					<? if($IDIOMA=='PT'){ echo "* Apenas receberá notificações do que subscrever"; } ?>
				    <? if($IDIOMA=='FR'){ echo "* Vous recevrez seulement des notifications de se vous avez souscrit"; } ?>
				    <? if($IDIOMA=='ES'){ echo "* Sólo recibirá notificaciones de lo que suscriba"; } ?>
				</div>
				<div class="notificacoes-alerta" id="alerta"></div>
			</div>	
	</section>
</div>
<!-- -->
<script>
function subscrever(){
	var email = $('#email').val();
	var ch1 = document.getElementById('check1').checked;
	if(ch1){ ch1=1; }else{ ch1=0; }
	var ch2 = document.getElementById('check2').checked;
	if(ch2){ ch2=1; }else{ ch2=0; }
	var ch3 = document.getElementById('check3').checked;
	if(ch3){ ch3=1; }else{ ch3=0; }
	var ch4 = document.getElementById('check4').checked;
	if(ch4){ ch4=1; }else{ ch4=0; }
	$.post("/subscrever/js_subscrever.php",{ ch1:ch1, ch2:ch2, ch3:ch3, ch4:ch4, email:email }) 
    .done(function( data ){
    	var jsonRetorna = $.parseJSON(data);
		if(jsonRetorna == 'TM') {
			<? if($IDIOMA=='EN'){ ?> $('#alerta').html('Successfully saved.'); <? } ?>
			<? if($IDIOMA=='PT'){ ?> $('#alerta').html('Guardado com sucesso.'); <? } ?>
		    <? if($IDIOMA=='FR'){ ?> $('#alerta').html('Enregistré avec succès.'); <? } ?>
		    <? if($IDIOMA=='ES'){ ?> $('#alerta').html('Guardado con éxito.'); <? } ?>
			setTimeout(function(){
				$('#alerta').html('');
				$('#email').val('');
				esconder('NOTIFICACOES');
			}, 3000);
		}else{
			$('#alerta').html(jsonRetorna);
		}
    });
}
</script>