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
<!-- SLIDE -->
<link rel="stylesheet" href="/js/swiper/swiper.css" type="text/css">

<script type="text/javascript" src="/js/swiper/swiper.js"></script>

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
$id = urldecode($url_partes[3]);
$id = filter_var($id, FILTER_VALIDATE_INT);

$id_tipo = urldecode($url_partes[2]);
$id_tipo = filter_var($id_tipo, FILTER_VALIDATE_INT);

echo $id_tipo;

$linha=mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM noticia WHERE id='$id'"));
$id_tipo=$linha["id_tipo"];
if($IDIOMA=='EN'){ $nome=$linha["nome_en"]; $texto=$linha["texto_en"]; }
if($IDIOMA=='PT'){ $nome=$linha["nome"]; $texto=$linha["texto"]; }
if($IDIOMA=='FR'){ $nome=$linha["nome_fr"]; $texto=$linha["texto_fr"]; }
if($IDIOMA=='ES'){ $nome=$linha["nome_es"]; $texto=$linha["texto_es"]; }
$url_nome = str_replace(" ", "-", $nome);

$linha2=mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM imagem WHERE id_noticia='$id' ORDER BY ordem ASC"));
$img=$linha2["img"];
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
<? $sep='news';
include '_header.php';?>
<article class="news-fundo news-margens">
	<section class="news-conteudo">
		<div class="news-filtro">
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
		<div class="news-scroll">
			<div id="swiper-new" class="swiper-container">
	    		<div class="swiper-wrapper">
				<?
				$url_completo = $_SERVER['REQUEST_URI'];
				$url_partes = explode("/", $url_completo);
				$id_tipo = urldecode($url_partes[2]);
				$id_tipo = filter_var($id_tipo, FILTER_VALIDATE_INT);
				$id_linha = urldecode($url_partes[3]);
				$id_linha = filter_var($id_linha, FILTER_VALIDATE_INT);
				$slide_inicial = 0;
				$i=0;

				if($IDIOMA=='EN'){ $restricao="AND nome_en!='' AND texto_en!=''"; }
				if($IDIOMA=='PT'){ $restricao="AND nome!='' AND texto!=''"; }
				if($IDIOMA=='FR'){ $restricao="AND nome_fr!='' AND texto_fr!=''"; }
				if($IDIOMA=='ES'){ $restricao="AND nome_es!='' AND texto_es!=''"; }
				if($id_tipo){ $restricao.=" AND id_tipo='$id_tipo'"; }
				$hoje = date('Y-m-d');
				
				$query=mysqli_query($lnk, "SELECT * FROM noticia WHERE online=1 AND publicacao<='$hoje' $restricao ORDER BY destaque DESC, publicacao DESC");
	  			while ($linha=mysqli_fetch_array($query)){
					$id_tipo_oferta=$linha["id_tipo"];
					$id=$linha["id"];
					if($id==$id_linha){$slide_inicial = $i;}
					//$destaque=$linha["destaque"];
					//if($destaque && !$slide_inicial){$slide_inicial = $i;}

					if($IDIOMA=='EN'){ $nome=$linha["nome_en"]; $texto=$linha["texto_en"]; }
					if($IDIOMA=='PT'){ $nome=$linha["nome"]; $texto=$linha["texto"]; }
					if($IDIOMA=='FR'){ $nome=$linha["nome_fr"]; $texto=$linha["texto_fr"]; }
					if($IDIOMA=='ES'){ $nome=$linha["nome_es"]; $texto=$linha["texto_es"]; }

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
					$img=$linha2["img"];
					$i++;

    				$url_nome = preg_replace(array("/( )/","/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/","/(&)/"),explode(" ","- a A e E i I o O u U n N c C e"),$nome);
    				$url_nome = str_replace("|", "-", $url_nome);
    				$mailto_nome = str_replace("&", "e", $nome);
    				$mailto_texto = str_replace("&", "e", $texto);
    				$twitter_nome = str_replace("|", "-", $nome);
					$destino="/new/$id_tipo/$id/$url_nome";
					?>
					<div class="swiper-slide">
						<? if($id_tipo == 0){?>
							<div class="news-esquerda">

							
								<div class="slideshow-container">
									<?
									$count = 0;
									
									$linha_imagem=mysqli_query($lnk, "SELECT * FROM imagem WHERE id_noticia='$id' ORDER BY ordem ASC");
									while($linha_new = mysqli_fetch_array($linha_imagem))
									{	
										$display_none = 'display:block;';
										if ($count != 0){ $display_none = 'display:none;';}
									
										echo '<div id="imagem_'.$id.'_'.$count.'" class="mySlides fade" style="background-image:url('.$linha_new['img'].');background-repeat: no-repeat;background-position:center;'.$display_none.'"></div>';
										
										$count++;
									} ?>
									
								</div>
							

								<div style="text-align:center;margin:10px 0px 20px 0px;">
								
								  	<? for ($aux_img=0; $aux_img < $count; $aux_img++) { 

											$color = '#bbb';
											if ($aux_img == 0){ $color = 'background-color:#717171';}

											echo '<span style="'.$color.'" id="dot_'.$id.'_'.$aux_img.'" class="dot" onclick="currentSlide('.$aux_img.','.$id.','.$count.')" 
											></span>';
										}
									?>
								</div>
							
							</div>
						<?}
						else{?>
							<div class="news-esquerda" style="background-image:url(<? echo $img; ?>);"></div>
						<?}?>
						
			            <div class="news-direita">
			            	<div class="nano">
				            	<div class="nano-content">
					            	<? if($data!='0000-00-00'){?><div class="news-data"><b><? echo $dia." ".$mes." ".$ano; ?></b></div><? } ?>
					            	<div class="news-partilha">
					            		<a onClick="window.open('http://www.facebook.com/share.php?u=http://www.sa-machado.com/facebook/<? echo $id;?>','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)"></a>
										<a href="https://twitter.com/intent/tweet?original_referer=http://www.sa-machado.com&text=<? echo $twitter_nome;?>&url=http://www.sa-machado.com<? echo $destino;?>&hashtags=SaMachado" target="_bank"></a>
										<a href="mailto:?subject=Sá Machado&body=<? echo $mailto_nome; ?>%0D%0A%0D%0A<? echo $mailto_texto; ?>%0D%0Ahttp://www.sa-machado.com<? echo $destino;?>"></a>
									</div>
									<div class="clear"></div>
					            	<div class="news-titulo"><? echo $nome; ?></div>
					            	<div class="news-texto"><? echo nl2br($texto); ?></div>

					            	

					            	<? if($id_tipo_oferta==1){?><br><a href="mailto:rhumanos@sa-machado.com?subject=<? echo $nome; ?>"><div class="news-botao"><? if($IDIOMA=='EN'){echo "APPLY";} if($IDIOMA=='PT'){echo "CANDIDATAR-SE";} if($IDIOMA=='FR'){echo "APPLIQUER";} if($IDIOMA=='ES'){echo "APLICAR";} ?></div></a><?}?>
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

<style>

/*.mySlides {display: none}*/
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
  height: calc(100% - 30px);
}


/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active, .dot:hover {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

</style>

<? include '_notifications.php';?>
<script>
var swiper = new Swiper('#swiper-new', {
    slidesPerView: 1,
    spaceBetween: 80,
    keyboardControl: true,
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev',
	loop: false,
	initialSlide: '<? echo $slide_inicial;?>',
});

</script>

<script>
	function currentSlide(i,id,count){

		for ($aux=0; $aux < count; $aux++) { 
			$('#imagem_'+id+'_'+$aux).css('display','none');
			$('#dot_'+id+'_'+$aux).css('background-color','#bbb');
		}

		$('#imagem_'+id+'_'+i).css('display','block');
		$('#dot_'+id+'_'+i).css('background-color','#717171');
	}
</script>

</body>
</html>