<!-- GOOGLE ANALYTICS -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-105609367-1', 'auto');
  ga('send', 'pageview');
</script>

<?php
$IDIOMA = $_COOKIE["IDIOMA"];
if(!$IDIOMA) {
	$IDIOMA = 'PT';
	echo "<script>setTimeout(function(){ createCookie('IDIOMA','$IDIOMA','168'); },300);</script>";
}
?>
<div class="header-absoluto">
	<section class="DN768">
		<header>
			<div class="header-ico-menu" onclick="verMenu();"></div>
		</header>
	</section>
	<!-- MENU -->
	<div id="MENU" class="header-modal-menu DN768">
		<div class="header-ico-close" onclick="fecharMenu();">X</div>
		<div class="clear"></div>
		<p><a href="/" class="<?if($sep=='who') echo 'header-sublinhado';?>"><? if($IDIOMA=='EN'){echo "PROFILE";} if($IDIOMA=='PT'){echo "PERFIL";} if($IDIOMA=='FR'){echo "PROFIL";} if($IDIOMA=='ES'){echo "PERFIL";} ?></a></p>
			<a href="/aboutus"><p><? if($IDIOMA=='EN'){echo "ABOUT US";} if($IDIOMA=='PT'){echo "SOBRE NÓS";} if($IDIOMA=='FR'){echo "À PROPOS DE NOUS";} if($IDIOMA=='ES'){echo "SOBRE NOSOTROS";} ?></p></a>
		    <a href="/vision"><p><? if($IDIOMA=='EN'){echo "VISION";} if($IDIOMA=='PT'){echo "VISÃO";} if($IDIOMA=='FR'){echo "VISION";} if($IDIOMA=='ES'){echo "VISIÓN";} ?></p></a>
		    <a href="/skills"><p><? if($IDIOMA=='EN'){echo "SKILLS";} if($IDIOMA=='PT'){echo "COMPETÊNCIAS";} if($IDIOMA=='FR'){echo "COMPÉTENCES";} if($IDIOMA=='ES'){echo "COMPETENCIAS";} ?></p></a>
		<p><a href="/portfolio" class="<?if($sep=='portfolio') echo 'header-sublinhado';?>"><? if($IDIOMA=='EN'){echo "PORTFOLIO";} if($IDIOMA=='PT'){echo "PORTFÓLIO";} if($IDIOMA=='FR'){echo "PORTEFEUILLE";} if($IDIOMA=='ES'){echo "PORTAFOLIO";} ?></a></p>
			<a href="/portfolio"><p><? if($IDIOMA=='EN'){echo "PROJECTS";} if($IDIOMA=='PT'){echo "OBRAS";} if($IDIOMA=='FR'){echo "PROJETS";} if($IDIOMA=='ES'){echo "OBRAS";} ?></p></a>
			<a href="/apresentacao/Sa-machado.pdf" download><p><? if($IDIOMA=='EN'){echo "PRESENTATION";} if($IDIOMA=='PT'){echo "APRESENTAÇÃO";} if($IDIOMA=='FR'){echo "PRÉSENTATION";} if($IDIOMA=='ES'){echo "PRESENTACIÓN";} ?></p></a>
		<p><a href="/news" class="<?if($sep=='news') echo 'header-sublinhado';?>"><? if($IDIOMA=='EN'){echo "COMMUNICATION";} if($IDIOMA=='PT'){echo "COMUNICAÇÃO";} if($IDIOMA=='FR'){echo "COMMUNICATION";} if($IDIOMA=='ES'){echo "COMUNICACIÓN";} ?></a></p>
			<a href="/news"><p><? if($IDIOMA=='EN'){echo "NEWS";} if($IDIOMA=='PT'){echo "NOTÍCIAS";} if($IDIOMA=='FR'){echo "NOUVELLES";} if($IDIOMA=='ES'){echo "NOTICIAS";} ?></p></a>
			<? $linha=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tipo WHERE id=1"));
			$id_tipo_esp=$linha["id"];
			if($IDIOMA=='EN'){ $tipo=$linha["nome_en"]; }
			if($IDIOMA=='PT'){ $tipo=$linha["nome"]; }
			if($IDIOMA=='FR'){ $tipo=$linha["nome_fr"]; }
			if($IDIOMA=='ES'){ $tipo=$linha["nome_es"]; } ?>
			<a href="/news/<? echo $id_tipo_esp;?>" class="textu"><p><? echo $tipo; ?></p></a>			
		<p><a href="/contacts" class="<?if($sep=='contacts') echo 'header-sublinhado';?>"><? if($IDIOMA=='EN'){echo "CONTACTS";} if($IDIOMA=='PT'){echo "CONTACTOS";} if($IDIOMA=='FR'){echo "CONTACTS";} if($IDIOMA=='ES'){echo "CONTACTOS";} ?></a></p>
		<p><a href="https://www.linkedin.com/company/3490890" target="_bank">LINKED IN</a></p>
		<p><a><? if($IDIOMA=='EN'){echo "LANGUAGE";} if($IDIOMA=='PT'){echo "IDIOMA";} if($IDIOMA=='FR'){echo "LANGUE";} if($IDIOMA=='ES'){echo "IDIOMA";} ?></a></p>
		<? if($IDIOMA!='EN'){?><p onClick="trocarIdioma('EN');">ENGLISH</p><? } ?>
		<? if($IDIOMA!='PT'){?><p onClick="trocarIdioma('PT');">PORTUGUÊS</p><? } ?>
	    <? if($IDIOMA!='FR'){?><p onClick="trocarIdioma('FR');">FRANÇAIS</p><? } ?>
	    <? if($IDIOMA!='ES'){?><p onClick="trocarIdioma('ES');">ESPAÑOLA</p><? } ?>
	</div>
	<script>
	function verMenu(){
		$("#MENU").css('display','block');
		$("#MENU").animate({opacity:"1"}, 250);
	}
	function fecharMenu(){
		$("#MENU").animate({opacity:"0"},300);
		setTimeout(function(){ $("#MENU").css('display','none'); }, 350);
	}
	</script>
	<section class="DB768">
		<header>
			<div class="header-icons">
				<a href="/contacts"><div class="header-local"></div></a>
				<a href="https://www.linkedin.com/company/3490890" target="_bank"><div class="header-linked"></div></a>
				<div class="header-idioma" onclick="verIdioma();" onmouseover="verIdioma(); mcancelIdioma();" onmouseout="mclosetIdioma();"></div>
			</div>
			<div class="header-menu">
				<a href="/"><div class="header-separ <?if($sep=='who') echo 'header-sublinhado';?>" onmouseover="verCasa(); mcancelCasa();" onmouseout="mclosetCasa();"><? if($IDIOMA=='EN'){echo "PROFILE";} if($IDIOMA=='PT'){echo "PERFIL";} if($IDIOMA=='FR'){echo "PROFIL";} if($IDIOMA=='ES'){echo "PERFIL";} ?></div></a>
				<a href="/portfolio"><div class="header-separ <?if($sep=='portfolio') echo 'header-sublinhado';?>" onmouseover="verPortfolio(); mcancelPortfolio();" onmouseout="mclosetPortfolio();"><? if($IDIOMA=='EN'){echo "PORTFOLIO";} if($IDIOMA=='PT'){echo "PORTFÓLIO";} if($IDIOMA=='FR'){echo "PORTEFEUILLE";} if($IDIOMA=='ES'){echo "PORTAFOLIO";} ?></div></a>
				<a href="/news"><div class="header-separ <?if($sep=='news') echo 'header-sublinhado';?>" onmouseover="verNoticias(); mcancelNoticias();" onmouseout="mclosetNoticias();"><? if($IDIOMA=='EN'){echo "COMMUNICATION";} if($IDIOMA=='PT'){echo "COMUNICAÇÃO";} if($IDIOMA=='FR'){echo "COMMUNICATION";} if($IDIOMA=='ES'){echo "COMUNICACIÓN";} ?></div></a>
			</div>
			<div class="clear"></div>
			<!-- IDIOMA -->
			<div id="IDIOMA" class="header-modal-idioma" onmouseover="mcancelIdioma()" onmouseout="mclosetIdioma()">
				<? if($IDIOMA!='EN'){?><p onClick="trocarIdioma('EN');">EN</p><? } ?>
				<? if($IDIOMA!='PT'){?><p onClick="trocarIdioma('PT');">PT</p><? } ?>
			    <? if($IDIOMA!='FR'){?><p onClick="trocarIdioma('FR');">FR</p><? } ?>
			    <? if($IDIOMA!='ES'){?><p onClick="trocarIdioma('ES');">ES</p><? } ?>
			</div>
			<!-- CASA -->
			<div id="CASA" class="header-modal-casa-<? if($IDIOMA=='EN'){echo "en";} if($IDIOMA=='PT'){echo "pt";} if($IDIOMA=='FR'){echo "fr";} if($IDIOMA=='ES'){echo "es";} ?>" onmouseover="mcancelCasa()" onmouseout="mclosetCasa()">
			    <a href="/aboutus"><p><? if($IDIOMA=='EN'){echo "ABOUT US";} if($IDIOMA=='PT'){echo "SOBRE NÓS";} if($IDIOMA=='FR'){echo "À PROPOS DE NOUS";} if($IDIOMA=='ES'){echo "SOBRE NOSOTROS";} ?></p></a>
			    <a href="/vision"><p><? if($IDIOMA=='EN'){echo "VISION";} if($IDIOMA=='PT'){echo "VISÃO";} if($IDIOMA=='FR'){echo "VISION";} if($IDIOMA=='ES'){echo "VISIÓN";} ?></p></a>
			    <a href="/skills"><p><? if($IDIOMA=='EN'){echo "SKILLS";} if($IDIOMA=='PT'){echo "COMPETÊNCIAS";} if($IDIOMA=='FR'){echo "COMPÉTENCES";} if($IDIOMA=='ES'){echo "COMPETENCIAS";} ?></p></a>
			</div>
			<!-- PORTFOLIO -->
			<div id="PORTFOLIO" class="header-modal-portfolio-<? if($IDIOMA=='EN'){echo "en";} if($IDIOMA=='PT'){echo "pt";} if($IDIOMA=='FR'){echo "fr";} if($IDIOMA=='ES'){echo "es";} ?>" onmouseover="mcancelPortfolio()" onmouseout="mclosetPortfolio()">
			    <a href="/portfolio"><p><? if($IDIOMA=='EN'){echo "PROJECTS";} if($IDIOMA=='PT'){echo "OBRAS";} if($IDIOMA=='FR'){echo "PROJETS";} if($IDIOMA=='ES'){echo "OBRAS";} ?></p></a>
			    <a href="/apresentacao/Sa-machado.pdf" download><p><? if($IDIOMA=='EN'){echo "PRESENTATION";} if($IDIOMA=='PT'){echo "APRESENTAÇÃO";} if($IDIOMA=='FR'){echo "PRÉSENTATION";} if($IDIOMA=='ES'){echo "PRESENTACIÓN";} ?></p></a>
			</div>
			<!-- NOTICIAS -->
			<div id="NOTICIAS" class="header-modal-noticias-<? if($IDIOMA=='EN'){echo "en";} if($IDIOMA=='PT'){echo "pt";} if($IDIOMA=='FR'){echo "fr";} if($IDIOMA=='ES'){echo "es";} ?>" onmouseover="mcancelNoticias()" onmouseout="mclosetNoticias()">
			    <a href="/news"><p><? if($IDIOMA=='EN'){echo "NEWS";} if($IDIOMA=='PT'){echo "NOTÍCIAS";} if($IDIOMA=='FR'){echo "NOUVELLES";} if($IDIOMA=='ES'){echo "NOTICIAS";} ?></p></a>
				<? $linha=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tipo WHERE id=1"));
				$id_tipo_esp=$linha["id"];
				if($IDIOMA=='EN'){ $tipo=$linha["nome_en"]; }
				if($IDIOMA=='PT'){ $tipo=$linha["nome"]; }
				if($IDIOMA=='FR'){ $tipo=$linha["nome_fr"]; }
				if($IDIOMA=='ES'){ $tipo=$linha["nome_es"]; } ?>
				<a href="/news/<? echo $id_tipo_esp;?>" class="textu"><p><? echo $tipo; ?></p></a>
			</div>
		</header>
	</section>

	<script>
	function verIdioma(){
		$("#IDIOMA").css('display','block');
		$("#IDIOMA").animate({opacity:"1"}, 250);
	}
	function mcloseIdioma(){
		$("#IDIOMA").animate({opacity:"0"},300);
		setTimeout(function(){ $("#IDIOMA").css('display','none'); }, 350);
	}
	var timeoutIdioma = 400;
	var closetimerIdioma = 0;
	function mclosetIdioma(){ closetimerIdioma = window.setTimeout(mcloseIdioma, timeoutIdioma); }
	function mcancelIdioma(){ if(closetimerIdioma) {window.clearTimeout(closetimerIdioma); closetimerIdioma = null;} }

	function verCasa(){
		$("#CASA").css('display','block');
		$("#CASA").animate({opacity:"1"}, 250);	
	}
	function mcloseCasa(){
		$("#CASA").animate({opacity:"0"},300);
		setTimeout(function(){ $("#CASA").css('display','none'); }, 350);
	}
	var timeoutCasa = 400;
	var closetimerCasa = 0;
	function mclosetCasa(){ closetimerCasa = window.setTimeout(mcloseCasa, timeoutCasa); }
	function mcancelCasa(){ if(closetimerCasa) {window.clearTimeout(closetimerCasa); closetimerCasa = null;} }

	function verPortfolio(){
		$("#PORTFOLIO").css('display','block');
		$("#PORTFOLIO").animate({opacity:"1"}, 250);	
	}
	function mclosePortfolio(){
		$("#PORTFOLIO").animate({opacity:"0"},300);
		setTimeout(function(){ $("#PORTFOLIO").css('display','none'); }, 350);
	}
	var timeoutPortfolio = 400;
	var closetimerPortfolio = 0;
	function mclosetPortfolio(){ closetimerPortfolio = window.setTimeout(mclosePortfolio, timeoutPortfolio); }
	function mcancelPortfolio(){ if(closetimerPortfolio) {window.clearTimeout(closetimerPortfolio); closetimerPortfolio = null;} }

	function verNoticias(){
		$("#NOTICIAS").css('display','block');
		$("#NOTICIAS").animate({opacity:"1"}, 250);	
	}
	function mcloseNoticias(){
		$("#NOTICIAS").animate({opacity:"0"},300);
		setTimeout(function(){ $("#NOTICIAS").css('display','none'); }, 350);
	}
	var timeoutNoticias = 400;
	var closetimerNoticias = 0;
	function mclosetNoticias(){ closetimerNoticias = window.setTimeout(mcloseNoticias, timeoutNoticias); }
	function mcancelNoticias(){ if(closetimerNoticias) {window.clearTimeout(closetimerNoticias); closetimerNoticias = null;} }
	</script>
</div>
<script>
function trocarIdioma(lingua){
	createCookie('IDIOMA',lingua,'168');
	window.location.reload();
}
</script>

<?php 
//if($_SERVER["REMOTE_ADDR"]=='188.250.83.113'){
	//if(date('Y-m-d')<='2019-03-17'){ include('_death.php'); }
//}
?>