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
<? include('_connect.php'); ?>

<? // Idioma
$IDIOMA=$_COOKIE["IDIOMA"];
if(!$IDIOMA){$IDIOMA='PT';}

// Facebook
$url_completo = $_SERVER['REQUEST_URI'];
$url_partes = explode("/", $url_completo);
$id = urldecode($url_partes[2]);

$pieces = explode("?", $id);
$id = filter_var($pieces[0], FILTER_VALIDATE_INT);

$linha=mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM noticia WHERE id='$id'"));
$id_tipo=$linha["id_tipo"];
if($IDIOMA=='EN'){ $nome=$linha["nome_en"]; $texto=$linha["texto_en"]; }
if($IDIOMA=='PT'){ $nome=$linha["nome"]; $texto=$linha["texto"]; }
if($IDIOMA=='FR'){ $nome=$linha["nome_fr"]; $texto=$linha["texto_fr"]; }
if($IDIOMA=='ES'){ $nome=$linha["nome_es"]; $texto=$linha["texto_es"]; }
$url_nome = str_replace(" ", "-", $nome);

$linha2=mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM imagem WHERE id_noticia='$id' ORDER BY ordem ASC"));
$img=$linha2["img"];

$destino="/new/$id_tipo/$id/$url_nome";
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
<?php echo "<script>window.location.replace('$destino');</script>"; ?>
<?php //header("Location: $destino"); ?>
</body>
</html>