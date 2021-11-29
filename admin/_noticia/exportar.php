<?php
include('../../_connect.php');

//inicio+fim+id_categoria+id_estado+id_pais+id_online+check1+...+check26
$url = $_SERVER['REQUEST_URI'];
$urlPartes = explode("/", $url);
$inicio = urldecode($urlPartes[4]);
$fim = urldecode($urlPartes[5]);
$id_tipo = urldecode($urlPartes[6]);
$online = urldecode($urlPartes[7]);
$check1 = urldecode($urlPartes[8]);
$check2 = urldecode($urlPartes[9]);
$check3 = urldecode($urlPartes[10]);
$check4 = urldecode($urlPartes[11]);
$check5 = urldecode($urlPartes[12]);
$check6 = urldecode($urlPartes[13]);
$check7 = urldecode($urlPartes[14]);
$check8 = urldecode($urlPartes[15]);
$check9 = urldecode($urlPartes[16]);
$check10 = urldecode($urlPartes[17]);
$check11 = urldecode($urlPartes[18]);
$check12 = urldecode($urlPartes[19]);
$check13 = urldecode($urlPartes[20]);

$restricao = " id_fase='0' ";
if($inicio){$restricao .= " AND criacao>='$inicio' AND publicacao>='$inicio'";}
if($fim){$restricao .= " AND criacao<='$fim' AND publicacao<='$fim'";}
if($id_tipo){$restricao .= " AND id_tipo='$id_tipo' ";}
if($online!=2){$restricao .= " AND online='$online' ";}

$output = '';
$sql = "SELECT * FROM noticia WHERE $restricao";
$result = mysqli_query($lnk, $sql);
if(mysqli_num_rows($result) > 0)
{
	$output .= '
		<table class="table" bordered="1">
		  <tr>
	';

	if($check1){$output .= "<th><b>T&iacute;tulo (PT)</b></th>";}
	if($check2){$output .= "<th><b>T&iacute;tulo (EN)</b></th>";}
	if($check3){$output .= "<th><b>T&iacute;tulo (FR)</b></th>";}
	if($check4){$output .= "<th><b>T&iacute;tulo (ES)</b></th>";}
	if($check5){$output .= "<th><b>Texto (PT)</b></th>";}
	if($check6){$output .= "<th><b>Texto (EN)</b></th>";}
	if($check7){$output .= "<th><b>Texto (FR)</b></th>";}
	if($check8){$output .= "<th><b>Texto (ES)</b></th>";}
	if($check9){$output .= "<th><b>Tipo</b></th>";}
	if($check10){$output .= "<th><b>Cria&ccedil;&atilde;o</b></th>";}
	if($check11){$output .= "<th><b>Publica&ccedil;&atilde;o</b></th>";}
	if($check12){$output .= "<th><b>Fotografia</b></th>";}
	if($check13){$output .= "<th><b>Online</b></th>";}

    $output .= '
          </tr>
    ';

   while($row = mysqli_fetch_array($result))
   {
   		$output .= '
			  <tr>
		';

		//$retorno_nome = mb_convert_encoding($row['nome'], 'UTF-16LE', 'UTF-8');
		if($check1){$output .= '<td>'.mb_convert_encoding($row['nome'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check2){$output .= '<td>'.mb_convert_encoding($row['nome_en'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check3){$output .= '<td>'.mb_convert_encoding($row['nome_fr'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check4){$output .= '<td>'.mb_convert_encoding($row['nome_es'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check5){$output .= '<td>'.mb_convert_encoding($row['texto'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check6){$output .= '<td>'.mb_convert_encoding($row['texto_en'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check7){$output .= '<td>'.mb_convert_encoding($row['texto_fr'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check8){$output .= '<td>'.mb_convert_encoding($row['texto_es'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check9){
		    $linha_tipo = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tipo WHERE id='".$row['id_tipo']."'"));
			$output .= '<td>'.mb_convert_encoding($linha_tipo['nome'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check10){$output .= '<td>'.$row["criacao"].'</td>';}
		if($check11){$output .= '<td>'.$row["publicacao"].'</td>';}
		if($check12){
			$linha_img = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM imagem WHERE id_noticia='".$row['id']."'"));
			$output .= '<td>http://www.samachado.com'.$linha_img["img"].'</td>';}
		if($check13){if($row["online"]) { $output .= '<td>Sim</td>'; }else{ $output .= '<td>N&atilde;o</td>'; }}

	    $output .= '
	          </tr>
	    ';
   }
   $output .= '</table>';
   //header("Content-Type: application/vnd.ms-excel");
   header("Content-Type: application/xls");
   header("Content-Disposition: attachment; filename=Noticias.xls");
   header("Pragma: no-cache");
   header("Expires: 0");
   echo $output;
}else{ header('Location: /admin/noticias');}
?>