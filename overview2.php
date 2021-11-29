<?php
ob_start();
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

<? // Idioma
$IDIOMA=$_COOKIE["IDIOMA"];
if(!$IDIOMA){$IDIOMA='PT';}

// Facebook
$url_completo = $_SERVER['REQUEST_URI'];
$url_partes = explode("/", $url_completo);
$id = urldecode($url_partes[2]);
$id = filter_var($id, FILTER_VALIDATE_INT);

$linha=mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM ficha WHERE id='$id'"));
if($IDIOMA=='EN'){ $nome=$linha["nome_en"]; $texto=$linha["descricao_en"]; }
if($IDIOMA=='PT'){ $nome=$linha["nome"]; $texto=$linha["descricao"]; }
if($IDIOMA=='FR'){ $nome=$linha["nome_fr"]; $texto=$linha["descricao_fr"]; }
if($IDIOMA=='ES'){ $nome=$linha["nome_es"]; $texto=$linha["descricao_es"]; }
$img=$linha["capa"];
?>

<meta property="og:title" content="<? echo $nome?>"/>
<meta property="og:type" content="website" />
<meta property="og:url" content="http://www.sa-machado.com<? echo $url_completo;?>"/>
<meta property="og:image" content="http://www.sa-machado.com<? echo $img;?>"/>
<meta property="og:site_name" content="Sá Machado"/>
<meta property="og:description" content="<? echo $texto?>"/>
<meta property="fb:app_id" content="1481969851815376"/>

<link rel="canonical" href="http://www.sa-machado.com<? echo $url_completo;?>" />
<script>
  $(document).ready(function(){ $.post('https://graph.facebook.com',{id:'http://www.sa-machado.com<? echo $url_completo;?>',scrape:true},function(response){console.log(response);});});
</script>
</head>

<body>
<? $sep='portfolio';
include '_header.php';?>
<article class="portfolio-fundo portfolio-margens">
	<section class="portfolio-conteudo">
		<?
		$url_completo = $_SERVER['REQUEST_URI'];
		$url_partes = explode("/", $url_completo);
		$id_linha = urldecode($url_partes[2]);
		$id_linha = filter_var($id_linha, FILTER_VALIDATE_INT);
		if($IDIOMA=='EN'){ $existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha WHERE id='$id_linha' AND online=1 AND nome_en!=''")); }
		if($IDIOMA=='PT'){ $existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha WHERE id='$id_linha' AND online=1 AND nome!=''")); }
		if($IDIOMA=='FR'){ $existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha WHERE id='$id_linha' AND online=1 AND nome_fr!=''")); }
		if($IDIOMA=='ES'){ $existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha WHERE id='$id_linha' AND online=1 AND nome_es!=''")); }
		if($existe){extract(mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE id='$id_linha'")));}
		else{ header('Location: /portfolio'); }
		?>
		<div class="portfolio-filtro">
			<a href="/portfolio"><div class="overview-voltar"><? if($IDIOMA=='EN'){echo "PORTFOLIO";} if($IDIOMA=='PT'){echo "PORTFÓLIO";} if($IDIOMA=='FR'){echo "PORTEFEUILLE";} if($IDIOMA=='ES'){echo "PORTAFOLIO";} ?></div></a>
			<div class="overview-seguinte" onClick="paginar(2);"></div>
			<div class="overview-anterior" onClick="paginar(1);"></div>
			<!--<a href="/mpdf/<? echo $id_linha;?>">--><div class="overview-download" onclick="mostrar('DOWNLOADS');"></div><!--</a>-->
		</div>
		<div class="portfolio-scroll nano">
			<div class="nano-content">
				<div class="overview-ficha">
					<div id="PAG1" class="overview-frente" style="background-image:url(<? echo $frente; ?>);">
						<div class="overview-cabecalho">
							<div class="overview-direita"></div>
							<div class="overview-esquerda">
								<div class="overview-pretitulo"><? if($IDIOMA=='EN'){echo "TECHNICAL OVERVIEW";} if($IDIOMA=='PT'){echo "FICHA DE OBRA";} if($IDIOMA=='FR'){echo "PRÉSENTATION TECHNIQUE";} if($IDIOMA=='ES'){echo "DESCRIPCIÓN TÉCNICA";} ?></div>
								<div class="overview-titulo"><h1><? if($IDIOMA=='EN'){echo $nome_en;} if($IDIOMA=='PT'){echo $nome;} if($IDIOMA=='FR'){echo $nome_fr;} if($IDIOMA=='ES'){echo $nome_es;} ?></h1></div>
								<? $linha=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM pais WHERE id='$id_pais'"));
								if($IDIOMA=='EN'){ $pais=$linha["nome_en"]; }
								if($IDIOMA=='PT'){ $pais=$linha["nome_pt"]; }
								if($IDIOMA=='FR'){ $pais=$linha["nome_fr"]; }
								if($IDIOMA=='ES'){ $pais=$linha["nome_es"]; } ?>
								<div class="overview-morada"><? echo $morada.' - '.$pais; ?></div>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
						<div class="overview-quadrado">
							<div class="overview-fundo">
								<div class="overview-descricao"><? if($IDIOMA=='EN'){echo "Owner";} if($IDIOMA=='PT'){echo "Proprietário";} if($IDIOMA=='FR'){echo "Maitre d'ouvrage";} if($IDIOMA=='ES'){echo "Dueño de obra";} ?></div>
								<div class="overview-caracteristica"><? if($IDIOMA=='EN'){echo $dono_en;} if($IDIOMA=='PT'){echo $dono;} if($IDIOMA=='FR'){echo $dono_fr;} if($IDIOMA=='ES'){echo $dono_es;} ?></div>
							</div>
						</div>
						<div class="overview-quadrado">
							<div class="overview-fundo">
								<? $linha=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM categoria WHERE id='$id_categoria'"));
								if($IDIOMA=='EN'){ $categoria=$linha["nome_en"]; }
								if($IDIOMA=='PT'){ $categoria=$linha["nome"]; }
								if($IDIOMA=='FR'){ $categoria=$linha["nome_fr"]; }
								if($IDIOMA=='ES'){ $categoria=$linha["nome_es"]; } ?>
								<div class="overview-descricao"><? if($IDIOMA=='EN'){echo "Category";} if($IDIOMA=='PT'){echo "Categoria";} if($IDIOMA=='FR'){echo "Catégorie";} if($IDIOMA=='ES'){echo "Categoría";} ?></div>
								<div class="overview-caracteristica"><? echo $categoria; ?></div>
							</div>
						</div>
						<div class="overview-quadrado">
							<div class="overview-fundo">
								<? if($area && is_numeric($area)){$area=number_format($area, 0, '.', ' ')." m&sup2;";}else{$area="-";} ?>
								<div class="overview-descricao"><? if($IDIOMA=='EN'){echo "Construction area";} if($IDIOMA=='PT'){echo "Área de construção";} if($IDIOMA=='FR'){echo "Surface de construction";} if($IDIOMA=='ES'){echo "Área del construcción";} ?></div>
								<div class="overview-caracteristica"><? echo $area;?></div>
							</div>
						</div>
						<div class="overview-quadrado">
							<div class="overview-fundo">
								<? if(!$prazo || !is_numeric($prazo)){$prazo="-";} ?>
								<div class="overview-descricao"><? if($IDIOMA=='EN'){echo "Construction time (months)";} if($IDIOMA=='PT'){echo "Prazo de construção (meses)";} if($IDIOMA=='FR'){echo "Temps de construction (mois)";} if($IDIOMA=='ES'){echo "Tiempo de construcción (meses)";} ?></div>
								<div class="overview-caracteristica"><? echo $prazo; ?></div>
								<?
								$mesI=substr($inicio, 5, 2);
								$anoI=substr($inicio, 0, 4);
								$mesF=substr($fim, 5, 2);
								$anoF=substr($fim, 0, 4);

								if($IDIOMA=='EN'){ 
									switch($mesI){ case "01":$mesI=Jan;break; case "02":$mesI=Feb;break; case "03":$mesI=Mar;break; case "04":$mesI=Apr;break; case "05":$mesI=May;break; case "06":$mesI=Jun;break; 
										case "07":$mesI=Jul;break; case "08":$mesI=Aug;break; case "09":$mesI=Sep;break; case "10":$mesI=Oct;break; case "11":$mesI=Nov;break; case "12":$mesI=Dec;break; }
									switch($mesF){ case "01":$mesF=Jan;break; case "02":$mesF=Feb;break; case "03":$mesF=Mar;break; case "04":$mesF=Apr;break; case "05":$mesF=May;break; case "06":$mesF=Jun;break; 
										case "07":$mesF=Jul;break; case "08":$mesF=Aug;break; case "09":$mesF=Sep;break; case "10":$mesF=Oct;break; case "11":$mesF=Nov;break; case "12":$mesF=Dec;break; }
								}
								if($IDIOMA=='PT'){ 
									switch($mesI){ case "01":$mesI=Jan;break; case "02":$mesI=Fev;break; case "03":$mesI=Mar;break; case "04":$mesI=Abr;break; case "05":$mesI=Mai;break; case "06":$mesI=Jun;break; 
										case "07":$mesI=Jul;break; case "08":$mesI=Ago;break; case "09":$mesI=Set;break; case "10":$mesI=Out;break; case "11":$mesI=Nov;break; case "12":$mesI=Dez;break; }
									switch($mesF){ case "01":$mesF=Jan;break; case "02":$mesF=Fev;break; case "03":$mesF=Mar;break; case "04":$mesF=Abr;break; case "05":$mesF=Mai;break; case "06":$mesF=Jun;break; 
										case "07":$mesF=Jul;break; case "08":$mesF=Ago;break; case "09":$mesF=Set;break; case "10":$mesF=Out;break; case "11":$mesF=Nov;break; case "12":$mesF=Dez;break; }
								}
								if($IDIOMA=='FR'){ 
									switch($mesI){ case "01":$mesI=Jan;break; case "02":$mesI=Fév;break; case "03":$mesI=Mar;break; case "04":$mesI=Avr;break; case "05":$mesI=Mai;break; case "06":$mesI=Jui;break; 
										case "07":$mesI=Juil;break; case "08":$mesI=Aoû;break; case "09":$mesI=Sep;break; case "10":$mesI=Oct;break; case "11":$mesI=Nov;break; case "12":$mesI=Déc;break; }
									switch($mesF){ case "01":$mesF=Jan;break; case "02":$mesF=Fév;break; case "03":$mesF=Mar;break; case "04":$mesF=Avr;break; case "05":$mesF=Mai;break; case "06":$mesF=Jui;break; 
										case "07":$mesF=Juil;break; case "08":$mesF=Aoû;break; case "09":$mesF=Sep;break; case "10":$mesF=Oct;break; case "11":$mesF=Nov;break; case "12":$mesF=Déc;break; }
								}
								if($IDIOMA=='ES'){ 
									switch($mesI){ case "01":$mesI=Ene;break; case "02":$mesI=Feb;break; case "03":$mesI=Mar;break; case "04":$mesI=Abr;break; case "05":$mesI=May;break; case "06":$mesI=Jun;break; 
										case "07":$mesI=Jul;break; case "08":$mesI=Ago;break; case "09":$mesI=Sep;break; case "10":$mesI=Oct;break; case "11":$mesI=Nov;break; case "12":$mesI=Dic;break; }
									switch($mesF){ case "01":$mesF=Ene;break; case "02":$mesF=Feb;break; case "03":$mesF=Mar;break; case "04":$mesF=Abr;break; case "05":$mesF=May;break; case "06":$mesF=Jun;break; 
										case "07":$mesF=Jul;break; case "08":$mesF=Ago;break; case "09":$mesF=Sep;break; case "10":$mesF=Oct;break; case "11":$mesF=Nov;break; case "12":$mesF=Dic;break; }
								} ?>
								<? if($inicio!='0000-00-00' && $fim!='0000-00-00'){?><div class="overview-data"><? echo $mesI.' '.$anoI.' - '.$mesF.' '.$anoF; ?></div><? } ?>
							</div>
						</div>
						<div class="overview-quadrado">
							<div class="overview-fundo">
								<? if(!$subpiso || !is_numeric($subpiso)){$subpiso="-";} ?>
								<div class="overview-descricao"><? if($IDIOMA=='EN'){echo "Floors underground";} if($IDIOMA=='PT'){echo "Pisos abaixo do solo";} if($IDIOMA=='FR'){echo "Étages en sous-sol";} if($IDIOMA=='ES'){echo "Pisos por debajo del solo";} ?></div>
								<div class="overview-caracteristica"><? echo $subpiso; ?></div>
							</div>
						</div>
						<div class="overview-quadrado">
							<div class="overview-fundo">
								<? if(!$piso || !is_numeric($piso)){$piso="-";} ?>
								<div class="overview-descricao"><? if($IDIOMA=='EN'){echo "Floors above the ground";} if($IDIOMA=='PT'){echo "Pisos acima do solo";} if($IDIOMA=='FR'){echo "Étages dessus du sol";} if($IDIOMA=='ES'){echo "Pisos sobre el solo";} ?></div>
								<div class="overview-caracteristica"><? echo $piso; ?></div>
							</div>
						</div>
						<div class="overview-quadrado">
							<div class="overview-fundo">
								<? $linha2=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM moeda WHERE id='$id_moeda'"));
								$moeda=$linha2['codigo'];
								if($oculto){$valor="NA";}else{if($valor && is_numeric($valor)){$valor=number_format($valor, 2, ',', ' ').' '.$moeda;}else{$valor="NA";}} ?>
								<div class="overview-descricao"><? if($IDIOMA=='EN'){echo "Value";} if($IDIOMA=='PT'){echo "Valor";} if($IDIOMA=='FR'){echo "Valeur";} if($IDIOMA=='ES'){echo "Valor";} ?></div>
								<div class="overview-caracteristica"><? echo $valor; ?></div>
							</div>
						</div>
						<div class="overview-quadrado">
							<div class="overview-fundo">
								<? $linha3=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM estado WHERE id='$id_estado'"));
								if($IDIOMA=='EN'){ $estado=$linha3["nome_en"]; }
								if($IDIOMA=='PT'){ $estado=$linha3["nome"]; }
								if($IDIOMA=='FR'){ $estado=$linha3["nome_fr"]; }
								if($IDIOMA=='ES'){ $estado=$linha3["nome_es"]; } ?>
								<div class="overview-descricao"><? if($IDIOMA=='EN'){echo "Stage of the work";} if($IDIOMA=='PT'){echo "Estado da obra";} if($IDIOMA=='FR'){echo "L'état de l'ouvrage";} if($IDIOMA=='ES'){echo "Estado de la obra";} ?></div>
								<div class="overview-caracteristica"><? echo $estado; ?></div>
							</div>
						</div>

						<div class="overview-ps" onClick="paginar(2);"></div>
						<div class="clear"></div>
					</div>
					<div id="PAG2" class="overview-tras" style="background-image:url(<? echo $tras; ?>);">
						<div class="overview-sombra">
							<? if($img1){ ?><div class="overview-retangulo"><div class="overview-foto" style="background-image:url(<? echo $img1; ?>);"></div></div><? } 
							if($img2){ ?><div class="overview-retangulo"><div class="overview-foto" style="background-image:url(<? echo $img2; ?>);"></div></div><? } 
							if($img3){ ?><div class="overview-retangulo"><div class="overview-foto" style="background-image:url(<? echo $img3; ?>);"></div></div><? } 
							if($img4){ ?><div class="overview-retangulo"><div class="overview-foto" style="background-image:url(<? echo $img4; ?>);"></div></div><? } ?>
							<div class="clear"></div>
							<div class="overview-resumo"><? if($IDIOMA=='EN'){echo $descricao_en;} if($IDIOMA=='PT'){echo $descricao;} if($IDIOMA=='FR'){echo $descricao_fr;} if($IDIOMA=='ES'){echo $descricao_es;} ?></div>
						</div>
						<div class="overview-pa" onClick="paginar(1);"></div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</section>
</article>
<!-- MODALS -->
<div id="DOWNLOADS" class="notificacoes-modal">
	<section class="notificacoes-size">
		<span class="notificacoes-close" onClick="esconder('DOWNLOADS');">X</span>
		<div class="clear"></div>
			<div class="notificacoes-body">
				<div class="notificacoes-titulo">
					<? if($IDIOMA=='EN'){ echo "Select the language"; } ?>
					<? if($IDIOMA=='PT'){ echo "Selecione a língua"; } ?>
				    <? if($IDIOMA=='FR'){ echo "Sélectionnez la langue"; } ?>
				    <? if($IDIOMA=='ES'){ echo "Seleccione el idioma"; } ?>
				</div>
				<div class="notificacoes-categorias">
					<!-- esq/dir/cen -->
					<? $existe_en = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha WHERE id='$id_linha' AND nome_en!=''"));
					if($existe_en){?><a href="/mpdf/EN/<? echo $id_linha;?>"><div class="notificacoes-cat-cen">English</div></a><?}?>
					<? $existe_pt = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha WHERE id='$id_linha' AND nome!=''"));
					if($existe_pt){?><a href="/mpdf/PT/<? echo $id_linha;?>"><div class="notificacoes-cat-cen">Português</div></a><?}?>
					<? $existe_fr = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha WHERE id='$id_linha' AND nome_fr!=''"));
					if($existe_fr){?><a href="/mpdf/FR/<? echo $id_linha;?>"><div class="notificacoes-cat-cen">Français</div></a><?}?>
					<? $existe_es = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM ficha WHERE id='$id_linha' AND nome_es!=''"));
					if($existe_es){?><a href="/mpdf/ES/<? echo $id_linha;?>"><div class="notificacoes-cat-cen">Español</div></a><?}?>
					<a href="/mpdf4l/<? echo $id_linha;?>"><div class="notificacoes-cat-cen">
						<? if($IDIOMA=='EN'){echo "All";} if($IDIOMA=='PT'){echo "Todas";} if($IDIOMA=='FR'){echo "Tous";} if($IDIOMA=='ES'){echo "Todos";} ?>
					</div></a>
				</div>
				<div class="clear"></div>
			</div>	
	</section>
</div>
<!-- -->
<script>
function paginar(pag){
	if(pag==1){
		$('.nano-content').animate({ scrollTop:0}, 0);
		$('#PAG1').css("display","block");
		$('#PAG2').css("display","none");
	}else{
		$('.nano-content').animate({ scrollTop:0}, 0);
		$('#PAG1').css("display","none");
		$('#PAG2').css("display","block");
	}
}
</script>
</body>
</html>