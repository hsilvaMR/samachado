<!doctype html>
<html lang="pt-pt">
<head>
<meta charset="utf-8">
<title>Sá Machado</title>
<? include '_head.php';?>
</head>

<body>
<article class="vision-fundo">
	<? $sep='who'; include '_header.php';?>
	<div class="who-conteudo">
		<section>
			<h2><? if($IDIOMA=='EN'){echo "VISION";} if($IDIOMA=='PT'){echo "VISÃO";} if($IDIOMA=='FR'){echo "VISION";} if($IDIOMA=='ES'){echo "VISIÓN";} ?></h2>
			<? if($IDIOMA=='EN'){?> 
				<span>THIS IS HOW WE INTEND TO FACE THE FUTURE, WITH STRONG COMMITMENT AND QUALITY SO THAT WE STAND OUT FROM THE COMPETITION IN AN INCREASINGLY DEMANDING MARKET.</span>
				<p>The new requirements and challenges of construction and its evolution demand constant improvement and development of new methods and techniques enhancing the 
					training of human resources and technological developments. The knowledge acquired over the years, combined with new technology allows us to increase the 
					capacity to meet the needs and expectations of our clients.</p>
			<?} if($IDIOMA=='PT'){?>
				<span>É DESTA FORMA QUE PRETENDEMOS ENCARAR O FUTURO, COM FORTE EMPENHO E QUALIDADE PARA QUE NUM MERCADO CADA VEZ MAIS EXIGENTE, NOS POSSAMOS DESTACAR DA NOSSA CONCORRÊNCIA.</span>
				<p>As novas exigências e desafios da construção civil e a sua evolução implicam um constante aperfeiçoamento e desenvolvimento de novos métodos e técnicas valoriza a 
					formação dos Recursos Humanos e a evolução tecnológica. O saber adquirido ao longo dos anos, aliado às novas tecnologias permite aumentar a capacidade de satisfazer 
					as necessidades e expectativas dos nossos clientes.</p>
			<?} if($IDIOMA=='FR'){?>
				<span>C'EST DANS CETTE FORME LA QUE L'ON PRÉTEND AFFRONTER LE FUTURE, AVEC DE L'INVESTISSEMENT ET QUALITÉ POUR QUE DANS UN MARCHÉ DE PLUS EN PLUS EXIGENT ON PUISSE S'AVANCER DE NOTRE CONCURRENCE.</span>
				<p>Nos exigences et défies de notre construction civil et son évolution implique une constante perfection et développement de nos méthodes et techniques qui valorise 
					la formation des ressources humaines et sa évolution technologique. On sachant que au long des années, allié aux nouvelles technologies nous permet d'augmenter la 
					capacité de satisfaire les nécessité et les attentes de nos clients.</p>
			<?} if($IDIOMA=='ES'){?>
				<span>ASÍ PRETENDEMOS MIRAR HACIA AL FUTURO, CON FUERTE EMPEÑO Y CALIDAD, PARA QUE EN UN MERCADO CADA VEZ MÁS EXIGENTE, NOS PODAMOS DESTACAR DE NUESTRA COMPETENCIA.</span>
				<p>Las nuevas exigencias y retos de la construcción civil y su evolución implican un constante perfeccionamiento, y el desarrollo de nuevos métodos y técnicas valora 
					la formación de los recursos humanos y la evolución tecnológica. El saber adquirido a lo largo de los años, aliado a las nuevas tecnologías permiten aumentar la 
					capacidad de satisfacer las necesidades y expectativas de nuestros clientes.</p>
			<?} ?>
			<div class="clear"></div>
		</section>
	</div>
</article>
</body>
</html>