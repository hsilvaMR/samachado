<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Sá Machado</title>
<? include '_head.php';?>
</head>

<body>
<article class="home-fundo">
	<? $sep='who'; include '_header.php';?>
	<div class="home-conteudo">
		<section>
			<img class="home-logo" src="/img/logo.svg" alt="logotipo sá machado">
			<?
			// 1 de Abril de 1933
			$hoje = date('Y');
			$data = date("m.d");
			if($data>=04.01){$ano = $hoje - 1933;}
			else{$ano = $hoje - 1934;}
			?>
			<h2><? if($IDIOMA=='EN'){echo "$ano years of knowledge";} if($IDIOMA=='PT'){echo "$ano anos de conhecimento";} if($IDIOMA=='FR'){echo "$ano ans de connaissances";} if($IDIOMA=='ES'){echo "$ano años de conocimiento";} ?></h2>
			<div class="home-frase"><a href="/contacts"><div class="home-circ"></div> <? if($IDIOMA=='EN'){echo "Around the world";} if($IDIOMA=='PT'){echo "À volta do mundo";} if($IDIOMA=='FR'){echo "Autour du monde";} if($IDIOMA=='ES'){echo "Alrededor del mundo";} ?></a></div>
			<!--world<div class="home-frase"><a href="/apresentacao/Sa-machado.pdf" download><? if($IDIOMA=='EN'){echo "Download presentation";} if($IDIOMA=='PT'){echo "Transferir apresentação";} if($IDIOMA=='FR'){echo "Télécharger la présentation";} if($IDIOMA=='ES'){echo "Descargar presentación";} ?></a></div>-->
			<div class="clear"></div>


		</section>
	</div>
	<a href="http://www.sa-machado.com/norte2020"><img style="position:absolute;bottom:0;right:15px;" class="norte-index" src="/img/logos/branco_2020.svg"></a>
</article>
<? //include '_death.php';?>
</body>
</html>