<?php
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
</head>

<body>
<? $sep='news';
include '_header.php';?>
<article class="news-fundo news-margens">
	<section class="news2-conteudo">
		<div class="news2-filtro">
			<?
			$url_completo = $_SERVER['REQUEST_URI'];
			$url_partes = explode("/", $url_completo);
			$id_tipo = urldecode($url_partes[2]);
			$id_tipo = filter_var($id_tipo, FILTER_VALIDATE_INT);
			?>
			<div class="news-notificacoes" onclick="mostrar('NOTIFICACOES');"><? if($IDIOMA=='EN'){echo "NOTIFICATIONS";} if($IDIOMA=='PT'){echo "NOTIFICAÇÕES";} if($IDIOMA=='FR'){echo "NOTIFICATIONS";} if($IDIOMA=='ES'){echo "NOTIFICACIONES";} ?></div>
			<!--<a href="/apresentacao/Sa-machado.pdf" download><div class="news-apresentacao"><? if($IDIOMA=='EN'){echo "PRESENTATION";} if($IDIOMA=='PT'){echo "APRESENTAÇÃO";} if($IDIOMA=='FR'){echo "PRÉSENTATION";} if($IDIOMA=='ES'){echo "PRESENTACIÓN";} ?></div></a>-->
			<div class="clear DN768"></div>
			<a href="/news"><div class="news-all"><? if($IDIOMA=='EN'){echo "VIEW ALL";} if($IDIOMA=='PT'){echo "VER TUDO";} if($IDIOMA=='FR'){echo "VOIR TOUT";} if($IDIOMA=='ES'){echo "VER TODO";} ?></div></a>
			<? $linha=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tipo WHERE id=1"));
			$id_tipo_esp=$linha["id"];
			if($IDIOMA=='EN'){ $tipo=$linha["nome_en"]; }
			if($IDIOMA=='PT'){ $tipo=$linha["nome"]; }
			if($IDIOMA=='FR'){ $tipo=$linha["nome_fr"]; }
			if($IDIOMA=='ES'){ $tipo=$linha["nome_es"]; } ?>
			<a href="/news/<? echo $id_tipo_esp;?>"><div class="news-tipo"><? echo $tipo; ?></div></a>
		</div>
		<div class="news2-scroll nano">
			<div class="nano-content">
				<?
				if($IDIOMA=='EN'){ $restricao="AND nome_en!='' AND texto_en!=''"; }
				if($IDIOMA=='PT'){ $restricao="AND nome!='' AND texto!=''"; }
				if($IDIOMA=='FR'){ $restricao="AND nome_fr!='' AND texto_fr!=''"; }
				if($IDIOMA=='ES'){ $restricao="AND nome_es!='' AND texto_es!=''"; }
				if($id_tipo){ $restricao.=" AND id_tipo='$id_tipo'"; }
				$query=mysqli_query($lnk, "SELECT * FROM noticia WHERE online=1 $restricao ORDER BY destaque DESC, publicacao DESC");
	  			while ($linha=mysqli_fetch_array($query)){
					$id=$linha["id"];

					if($IDIOMA=='EN'){ $nome=$linha["nome_en"]; $texto=$linha["texto_en"]; }
					if($IDIOMA=='PT'){ $nome=$linha["nome"]; $texto=$linha["texto"]; }
					if($IDIOMA=='FR'){ $nome=$linha["nome_fr"]; $texto=$linha["texto_fr"]; }
					if($IDIOMA=='ES'){ $nome=$linha["nome_es"]; $texto=$linha["texto_es"]; }

					$url_nome = preg_replace(array("/( )/","/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/","/(&)/"),explode(" ","- a A e E i I o O u U n N c C e"),$nome);
    				
					$data=$linha["publicacao"];
					$dia=substr($data, 8, 2);
					$mes=substr($data, 5, 2);
					$ano=substr($data, 0, 4);
					if($IDIOMA=='EN'){
						switch ($mes){
					        case "01":  $mes = January;    break;
					        case "02":  $mes = February;   break;
					        case "03":  $mes = March;      break;
					        case "04":  $mes = April;      break;
					        case "05":  $mes = May;        break;
					        case "06":  $mes = June;       break;
					        case "07":  $mes = July;       break;
					        case "08":  $mes = August;     break;
					        case "09":  $mes = September;  break;
					        case "10":  $mes = October;    break;
					        case "11":  $mes = November;   break;
					        case "12":  $mes = December;   break; 
						}
					}
					if($IDIOMA=='PT'){
						switch ($mes){
					        case "01":  $mes = Janeiro;    break;
					        case "02":  $mes = Fevereiro;  break;
					        case "03":  $mes = Março;      break;
					        case "04":  $mes = Abril;      break;
					        case "05":  $mes = Maio;       break;
					        case "06":  $mes = Junho;      break;
					        case "07":  $mes = Julho;      break;
					        case "08":  $mes = Agosto;     break;
					        case "09":  $mes = Setembro;   break;
					        case "10":  $mes = Outubro;    break;
					        case "11":  $mes = Novembro;   break;
					        case "12":  $mes = Dezembro;   break; 
						}
					}
					if($IDIOMA=='FR'){
						switch ($mes){
					        case "01":  $mes = Janvier;    break;
					        case "02":  $mes = Février;    break;
					        case "03":  $mes = Mars;       break;
					        case "04":  $mes = Avril;      break;
					        case "05":  $mes = Mai;        break;
					        case "06":  $mes = Juin;       break;
					        case "07":  $mes = Juillet;    break;
					        case "08":  $mes = Août;       break;
					        case "09":  $mes = Septembre;  break;
					        case "10":  $mes = Octobre;    break;
					        case "11":  $mes = Novembre;   break;
					        case "12":  $mes = Décembre;   break; 
						}
					}
					if($IDIOMA=='ES'){
						switch ($mes){
					        case "01":  $mes = Enero;      break;
					        case "02":  $mes = Febrero;    break;
					        case "03":  $mes = Marzo;      break;
					        case "04":  $mes = Abril;      break;
					        case "05":  $mes = Mayo;       break;
					        case "06":  $mes = Junio;      break;
					        case "07":  $mes = Julio;      break;
					        case "08":  $mes = Agosto;     break;
					        case "09":  $mes = Septiembre; break;
					        case "10":  $mes = Octubre;    break;
					        case "11":  $mes = Noviembre;  break;
					        case "12":  $mes = Diciembre;  break; 
						}
					}
					$linha2=mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM imagem WHERE id_noticia='$id' ORDER BY ordem ASC"));
					$img=$linha2["img"]; ?>
		            <div class="news2-ficha">
		            	<div class="news2-foto" style="background-image:url(<? echo $img; ?>);"></div>
		            	<div class="news2-data"><b><? if($data!='0000-00-00'){ echo $dia." ".$mes." ".$ano; } ?></b></div>
		            	<div class="news2-titulo"><? echo $nome; ?></div>
		            	<div class="news2-butao" onclick="window.location.replace('/new/<? if($id_tipo){echo $id_tipo.'/';}else{echo '0/';} echo $id.'/'.$url_nome;?>');"><? if($IDIOMA=='EN'){echo "view";} if($IDIOMA=='PT'){echo "ver";} if($IDIOMA=='FR'){echo "voir";} if($IDIOMA=='ES'){echo "ver";} ?></div>
		            </div>
		            <?
		        }?>
		    </div>
		</div>
	</section>
</article>
<? include '_notifications.php';?>
</body>
</html>