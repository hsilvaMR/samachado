<!-- Death -->
<!--<div id="DEATH" class="news-size-small" < ?php if(isset($_COOKIE['NEWSLETTERFULL']) && !isset($_COOKIE['DEATH'])) echo 'style="visibility:visible;"';?>>-->
<div id="DEATH" class="death <?php if(isset($_COOKIE['DEATH'])) echo 'none';?>" onclick="mostrar('DEATHFULL');esconder('DEATH');"></div>

<div id="DEATHFULL" class="death-modal">
  <section class="death-size">
	<span class="death-close" onClick="fecharDeath();">X</span>
	<div class="death-body">
	  <div class="death-cross"></div>
	  <? if($IDIOMA=='EN'){ echo "It's with great sorrow that we inform the passing of<br>António Augusto de Sá Machado,<br>former partner and administrator of this company."; } ?>
	  <? if($IDIOMA=='PT'){ echo "É com sentido pesar que reportamos o falecimento de<br>António Augusto de Sá Machado,<br>ex-sócio e administrador desta empresa."; } ?>
	  <? if($IDIOMA=='FR'){ echo "C'est avec regret que nous vous informons que l'ex administrateur de cette société,<br>António Augusto de Sá Machado,<br>est décédé."; } ?>
	  <? if($IDIOMA=='ES'){ echo "Con pesar reportamos el fallecimiento de<br>António Augusto de Sá Machado,<br>ex socio y administrador de nuestra empresa."; } ?>
	  <br><br>23/07/1943 - 25/03/2020
	</div>	
  </section>
</div>
<script>
function fecharDeath(){
	esconder('DEATHFULL');
	createCookie('DEATH','TM',1);
}
function esconderDeath(){
	mostrar('DEATH');
	esconder('DEATHFULL');
}
</script>