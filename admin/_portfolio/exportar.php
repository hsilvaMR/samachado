<?php
include('../../_connect.php');

//inicio+fim+id_categoria+id_estado+id_pais+id_online+check1+...+check26
$url = $_SERVER['REQUEST_URI'];
$urlPartes = explode("/", $url);
$inicio = urldecode($urlPartes[4]);
$fim = urldecode($urlPartes[5]);
$id_categoria = urldecode($urlPartes[6]);
$id_estado = urldecode($urlPartes[7]);
$id_pais = urldecode($urlPartes[8]);
$online = urldecode($urlPartes[9]);
$check1 = urldecode($urlPartes[10]);
$check2 = urldecode($urlPartes[11]);
$check3 = urldecode($urlPartes[12]);
$check4 = urldecode($urlPartes[13]);
$check5 = urldecode($urlPartes[14]);
$check6 = urldecode($urlPartes[15]);
$check7 = urldecode($urlPartes[16]);
$check8 = urldecode($urlPartes[17]);
$check9 = urldecode($urlPartes[18]);
$check10 = urldecode($urlPartes[19]);
$check11 = urldecode($urlPartes[20]);
$check12 = urldecode($urlPartes[21]);
$check13 = urldecode($urlPartes[22]);
$check14 = urldecode($urlPartes[23]);
$check15 = urldecode($urlPartes[24]);
$check16 = urldecode($urlPartes[25]);
$check17 = urldecode($urlPartes[26]);
$check18 = urldecode($urlPartes[27]);
$check19 = urldecode($urlPartes[28]);
$check20 = urldecode($urlPartes[29]);
$check21 = urldecode($urlPartes[30]);
$check22 = urldecode($urlPartes[31]);
$check23 = urldecode($urlPartes[32]);
$check24 = urldecode($urlPartes[33]);
$check25 = urldecode($urlPartes[34]);
$check26 = urldecode($urlPartes[35]);

$restricao = " id!='' ";
if($inicio){$restricao .= " AND inicio>='$inicio' ";}
if($fim){$restricao .= " AND fim<='$fim' ";}
if($id_categoria){$restricao .= " AND id_categoria='$id_categoria' ";}
if($id_estado){$restricao .= " AND id_estado='$id_estado' ";}
if($id_pais){$restricao .= " AND id_pais='$id_pais' ";}
if($online!=2){$restricao .= " AND online='$online' ";}

$output = '';
$sql = "SELECT * FROM ficha WHERE $restricao";
$result = mysqli_query($lnk, $sql);
if(mysqli_num_rows($result) > 0)
{
	$output .= '
		<table class="table" bordered="1">
		  <tr>
	';

	if($check1){$output .= "<th><b>Refer&ecirc;ncia</b></th>";}
	if($check2){$output .= "<th><b>Nome (PT)</b></th>";}
	if($check3){$output .= "<th><b>Nome (EN)</b></th>";}
	if($check4){$output .= "<th><b>Nome (FR)</b></th>";}
	if($check5){$output .= "<th><b>Nome (ES)</b></th>";}
	if($check6){$output .= "<th><b>Dono (PT)</b></th>";}
	if($check7){$output .= "<th><b>Dono (EN)</b></th>";}
	if($check8){$output .= "<th><b>Dono (FR)</b></th>";}
	if($check9){$output .= "<th><b>Dono (ES)</b></th>";}
	if($check10){$output .= "<th><b>Texto (PT)</b></th>";}
	if($check11){$output .= "<th><b>Texto (EN)</b></th>";}
	if($check12){$output .= "<th><b>Texto (FR)</b></th>";}
	if($check13){$output .= "<th><b>Texto (ES)</b></th>";}
	if($check14){$output .= "<th><b>&Aacute;rea</b></th>";}
	if($check15){$output .= "<th><b>Prazo</b></th>";}
	if($check16){$output .= "<th><b>Pisos</b></th>";}
	if($check17){$output .= "<th><b>Pisos subterr&acirc;neos</b></th>";}
	if($check18){$output .= "<th><b>Valor</b></th>";}
	if($check19){$output .= "<th><b>Inicio</b></th>";}
	if($check20){$output .= "<th><b>Fim</b></th>";}
	if($check21){$output .= "<th><b>Estado</b></th>";}
	if($check22){$output .= "<th><b>Categoria</b></th>";}
	if($check23){$output .= "<th><b>Morada</b></th>";}
	if($check24){$output .= "<th><b>Pa&iacute;s</b></th>";}
	if($check25){$output .= "<th><b>Capa</b></th>";
				 $output .= "<th><b>Fundo 1</b></th>";
				 $output .= "<th><b>Fundo 2</b></th>";
				 $output .= "<th><b>Foto 1</b></th>";
				 $output .= "<th><b>Foto 2</b></th>";
				 $output .= "<th><b>Foto 3</b></th>";
				 $output .= "<th><b>Foto 4</b></th>";}
	if($check26){$output .= "<th><b>Online</b></th>";}

    $output .= '
          </tr>
    ';

   while($row = mysqli_fetch_array($result))
   {
   		$output .= '
			  <tr>
		';

		//$retorno_nome = mb_convert_encoding($row['nome'], 'UTF-16LE', 'UTF-8');
		if($check1){$output .= '<td>'.$row['referencia'].'</td>';}
		if($check2){$output .= '<td>'.mb_convert_encoding($row['nome'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check3){$output .= '<td>'.mb_convert_encoding($row['nome_en'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check4){$output .= '<td>'.mb_convert_encoding($row['nome_fr'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check5){$output .= '<td>'.mb_convert_encoding($row['nome_es'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check6){$output .= '<td>'.mb_convert_encoding($row['dono'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check7){$output .= '<td>'.mb_convert_encoding($row['dono_en'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check8){$output .= '<td>'.mb_convert_encoding($row['dono_fr'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check9){$output .= '<td>'.mb_convert_encoding($row['dono_es'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check10){$output .= '<td>'.mb_convert_encoding($row['descricao'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check11){$output .= '<td>'.mb_convert_encoding($row['descricao_en'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check12){$output .= '<td>'.mb_convert_encoding($row['descricao_fr'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check13){$output .= '<td>'.mb_convert_encoding($row['descricao_es'], 'UTF-16LE', 'UTF-8').'</td>';}

		if($check14){$output .= '<td>'.str_replace(".", ",", $row['area']).'</td>';}
		if($check15){$output .= '<td>'.$row['prazo'].'</td>';}
		if($check16){$output .= '<td>'.$row['piso'].'</td>';}
		if($check17){$output .= '<td>'.$row['subpiso'].'</td>';}
		if($check18){
		    $linha_moeda = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM moeda WHERE id='".$row['id_moeda']."'"));
			$output .= '<td>'.$linha_moeda['codigo'].' '.str_replace(".", ",", $row['valor']).'</td>';}
		if($check19){$output .= '<td>'.$row["inicio"].'</td>';}
		if($check20){$output .= '<td>'.$row["fim"].'</td>';}
		if($check21){
			$linha_estado = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM estado WHERE id='".$row['id_estado']."'"));
			$output .= '<td>'.mb_convert_encoding($linha_estado['nome'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check22){
			$linha_categoria = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM categoria WHERE id='".$row['id_categoria']."'"));
			$output .= '<td>'.mb_convert_encoding($linha_categoria['nome'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check23){$output .= '<td>'.mb_convert_encoding($row['morada'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check24){
			$linha_pais = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM pais WHERE id='".$row['id_pais']."'"));
			$output .= '<td>'.mb_convert_encoding($linha_pais['nome_pt'], 'UTF-16LE', 'UTF-8').'</td>';}
		if($check25){
			$output .= '<td>http://www.samachado.com'.$row['capa'].'</td>';
			$output .= '<td>http://www.samachado.com'.$row['frente'].'</td>';
			$output .= '<td>http://www.samachado.com'.$row['tras'].'</td>';
			$output .= '<td>http://www.samachado.com'.$row['img1'].'</td>';
			$output .= '<td>http://www.samachado.com'.$row['img2'].'</td>';
			$output .= '<td>http://www.samachado.com'.$row['img3'].'</td>';
			$output .= '<td>http://www.samachado.com'.$row['img4'].'</td>';}
		if($check26){if($row["online"]) { $output .= '<td>Sim</td>'; }else{ $output .= '<td>N&atilde;o</td>'; }}

	    $output .= '
	          </tr>
	    ';
   }
   $output .= '</table>';
   //header("Content-Type: application/vnd.ms-excel");
   header("Content-Type: application/xls");
   header("Content-Disposition: attachment; filename=Fichas_de_Obra.xls");
   header("Pragma: no-cache");
   header("Expires: 0");
   echo $output;
}else{ header('Location: /admin/portfolios');}
?>