<?php
ob_start();

//error_reporting(E_ERROR);
ini_set('display_errors', '1');

$html = ob_get_clean();
$html = utf8_decode($html);

include('_connect.php');

$url_completo = $_SERVER['REQUEST_URI'];
$url_partes = explode("/", $url_completo);
$id_linha = urldecode($url_partes[2]);
$id_linha = filter_var($id_linha, FILTER_VALIDATE_INT);
$tabela = urldecode($url_partes[3]);
if (!$tabela) {
	$tabela = 'ficha';
}
$existe = mysqli_num_rows(mysqli_query($lnk, "SELECT * FROM $tabela WHERE id='$id_linha'"));
if ($existe) {
	extract(mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM $tabela WHERE id='$id_linha'")));

	$linha = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM categoria WHERE id='$id_categoria'"));
	$categoria_en = $linha["nome_en"];
	$categoria_pt = $linha["nome"];
	$categoria_fr = $linha["nome_fr"];
	$categoria_es = $linha["nome_es"];
	if ($area && is_numeric($area)) {
		$area = number_format($area, 0, '.', ' ') . " m&sup2;";
	} else {
		$area = "-";
	}
	if (!$prazo || !is_numeric($prazo)) {
		$prazo = "-";
	}

	$mesI = substr($inicio, 5, 2);
	$anoI = substr($inicio, 0, 4);
	$mesF = substr($fim, 5, 2);
	$anoF = substr($fim, 0, 4);
	switch ($mesI) {
		case "01":
			$mesI_en = 'Jan';
			$mesI_pt = 'Jan';
			$mesI_fr = 'Jan';
			$mesI_es = 'Ene';
			break;
		case "02":
			$mesI_en = 'Feb';
			$mesI_pt = 'Fev';
			$mesI_fr = 'Fév';
			$mesI_es = 'Feb';
			break;
		case "03":
			$mesI_en = 'Mar';
			$mesI_pt = 'Mar';
			$mesI_fr = 'Mar';
			$mesI_es = 'Mar';
			break;
		case "04":
			$mesI_en = 'Apr';
			$mesI_pt = 'Abr';
			$mesI_fr = 'Avr';
			$mesI_es = 'Abr';
			break;
		case "05":
			$mesI_en = 'May';
			$mesI_pt = 'Mai';
			$mesI_fr = 'Mai';
			$mesI_es = 'May';
			break;
		case "06":
			$mesI_en = 'Jun';
			$mesI_pt = 'Jun';
			$mesI_fr = 'Jui';
			$mesI_es = 'Jun';
			break;
		case "07":
			$mesI_en = 'Jul';
			$mesI_pt = 'Jul';
			$mesI_fr = 'Juil';
			$mesI_es = 'Jul';
			break;
		case "08":
			$mesI_en = 'Aug';
			$mesI_pt = 'Ago';
			$mesI_fr = 'Aoû';
			$mesI_es = 'Ago';
			break;
		case "09":
			$mesI_en = 'Sep';
			$mesI_pt = 'Set';
			$mesI_fr = 'Sep';
			$mesI_es = 'Sep';
			break;
		case "10":
			$mesI_en = 'Oct';
			$mesI_pt = 'Out';
			$mesI_fr = 'Oct';
			$mesI_es = 'Oct';
			break;
		case "11":
			$mesI_en = 'Nov';
			$mesI_pt = 'Nov';
			$mesI_fr = 'Nov';
			$mesI_es = 'Nov';
			break;
		case "12":
			$mesI_en = 'Dec';
			$mesI_pt = 'Dez';
			$mesI_fr = 'Déc';
			$mesI_es = 'Dic';
			break;
	}
	switch ($mesF) {
		case "01":
			$mesF_en = 'Jan';
			$mesF_pt = 'Jan';
			$mesF_fr = 'Jan';
			$mesF_es = 'Ene';
			break;
		case "02":
			$mesF_en = 'Feb';
			$mesF_pt = 'Fev';
			$mesF_fr = 'Fév';
			$mesF_es = 'Feb';
			break;
		case "03":
			$mesF_en = 'Mar';
			$mesF_pt = 'Mar';
			$mesF_fr = 'Mar';
			$mesF_es = 'Mar';
			break;
		case "04":
			$mesF_en = 'Apr';
			$mesF_pt = 'Abr';
			$mesF_fr = 'Avr';
			$mesF_es = 'Abr';
			break;
		case "05":
			$mesF_en = 'May';
			$mesF_pt = 'Mai';
			$mesF_fr = 'Mai';
			$mesF_es = 'May';
			break;
		case "06":
			$mesF_en = 'Jun';
			$mesF_pt = 'Jun';
			$mesF_fr = 'Jui';
			$mesF_es = 'Jun';
			break;
		case "07":
			$mesF_en = 'Jul';
			$mesF_pt = 'Jul';
			$mesF_fr = 'Juil';
			$mesF_es = 'Jul';
			break;
		case "08":
			$mesF_en = 'Aug';
			$mesF_pt = 'Ago';
			$mesF_fr = 'Aoû';
			$mesF_es = 'Ago';
			break;
		case "09":
			$mesF_en = 'Sep';
			$mesF_pt = 'Set';
			$mesF_fr = 'Sep';
			$mesF_es = 'Sep';
			break;
		case "10":
			$mesF_en = 'Oct';
			$mesF_pt = 'Out';
			$mesF_fr = 'Oct';
			$mesF_es = 'Oct';
			break;
		case "11":
			$mesF_en = 'Nov';
			$mesF_pt = 'Nov';
			$mesF_fr = 'Nov';
			$mesF_es = 'Nov';
			break;
		case "12":
			$mesF_en = 'Dec';
			$mesF_pt = 'Dez';
			$mesF_fr = 'Déc';
			$mesF_es = 'Dic';
			break;
	}
	if ($fim != '0000-00-00') {
		$data = '<br><br>' . $anoF . '/' . $mesF;
	}

	if (!$subpiso || !is_numeric($subpiso)) {
		$subpiso = "-";
	}
	if (!$piso || !is_numeric($piso)) {
		$piso = "-";
	}
	$linha2 = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM moeda WHERE id='$id_moeda'"));
	$moeda = $linha2['codigo'];
	if ($oculto) {
		$valor = "NA";
	} else {
		if ($valor && is_numeric($valor)) {
			$valor = number_format($valor, 2, ',', ' ') . ' ' . $moeda;
		} else {
			$valor = "NA";
		}
	}

	$letra_escura = '';
	$logo = 'http://www.samachado.com/img/icons/logo.svg';
	if ($escuro) {
		$letra_escura = 'color:#555;';
		$logo = 'http://www.samachado.com/img/icons/logo-escuro.svg';
	}

	$linha3 = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM estado WHERE id='$id_estado'"));
	$estado_en = $linha3["nome_en"];
	$estado_pt = $linha3["nome"];
	$estado_fr = $linha3["nome_fr"];
	$estado_es = $linha3["nome_es"];

	$linha4 = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM pais WHERE id='$id_pais'"));
	$pais_en = $linha4["nome_en"];
	$pais_pt = $linha4["nome_pt"];
	$pais_fr = $linha4["nome_fr"];
	$pais_es = $linha4["nome_es"];

	if ($tabela == 'processo') {
		//FRENTE
		$queryV = mysqli_query($lnk, "SELECT * FROM galeria WHERE id_processo='$id_linha' AND tipo='vertical' ORDER BY ordem ASC");
		$linhaV = mysqli_fetch_array($queryV);
		$frente = $linhaV['img'];
		//TRAS
		$linhaV = mysqli_fetch_array($queryV);
		$tras = $linhaV['img'];
		//IMG1
		$queryH = mysqli_query($lnk, "SELECT * FROM galeria WHERE id_processo='$id_linha' AND tipo='horizontal' ORDER BY ordem ASC");
		$linhaH = mysqli_fetch_array($queryH);
		$img1 = $linhaH['img'];
		//IMG2
		$linhaH = mysqli_fetch_array($queryH);
		$img2 = $linhaH['img'];
		//IMG3
		$linhaH = mysqli_fetch_array($queryH);
		$img3 = $linhaH['img'];
		//IMG4
		$linhaH = mysqli_fetch_array($queryH);
		$img4 = $linhaH['img'];
	}

	if ($nome != $nome_en || $nome_en != $nome_fr || $nome_fr != $nome_es) {
		$nome3 = ' <span style="font-size:9px;"><br>' . $nome . ' | ' . $nome_fr . ' | ' . $nome_es . '</span>';
	}
	if ($pais_pt != $pais_en || $pais_en != $pais_fr || $pais_fr != $pais_es) {
		$pais3 = ' <span style="font-size:8px;">' . $pais_pt . ' | ' . $pais_fr . ' | ' . $pais_es . '</span>';
	}
	if ($dono != $dono_en || $dono_en != $dono_fr || $dono_fr != $dono_es) {
		$dono3 = '<br><b>' . $dono . '</b><br><b>' . $dono_fr . '</b><br><b>' . $dono_es . '</b>';
	}

	$html .= '
	<!doctype html> 
	<html> 
		<head>
			<style>
				body{width:100%; height:100%;padding:0;margin:0;font-family:"Myriad Pro Regular",Arial,sans-serif;color:#fff;}
				.ficha{text-align:left;vertical-align:middle;font-size:18px;padding-bottom:10px;}
				.titulo{vertical-align:bottom;font-size:36px;text-transform:uppercase;}
				.morada{vertical-align:top;font-size:12px;text-transform:uppercase;}
				.logo{text-align:right;vertical-align:top;}
				.quadrado{width:25%;text-align:center;vertical-align:middle;font-size:11px;height:180px;background:rgba(0,0,0,0.3);}
				.retangulo{width:50%;text-align:center;vertical-align:middle;background-size:auto 100%;background-repeat:no-repeat;background-position:center;}
				.descricao{text-align:justify;font-size:10px;}
			</style>
		</head> 
		<body>
			<div style="width:100%;height:100%;padding:40px 25px;background:#ddd url(' . $frente . ')no-repeat center;background-size:100% 100%;">

				<table style="width:100%;padding:10px;' . $letra_escura . '">
				  <tr>
				    <td class="ficha"> TECHNICAL OVERVIEW <span style="font-size:8px;">FICHA DE OBRA | PRÉSENTATION TECHNIQUE | DESCRIPCIÓN TÉCNICA</span></td>
				    <td class="logo" rowspan="3"><img src="' . $logo . '" height="30px" style="margin-top:-12px;"></td>
				  </tr>
				  <tr>
				    <td class="titulo">' . $nome_en . $nome3 . '</td>
				  </tr>
				  <tr>
				    <td class="morada">' . $morada . ' - ' . $pais_en . $pais3 . '</td>
				  </tr>
				</table>

				<table style="width:100%;margin-top:20px;border-spacing:10px;">
				  <tr>
				    <td class="quadrado">Owner<br>Proprietário<br>Maitre d′ouvrage<br>Dueño de obra<br><br><b>' . $dono_en . '</b>' . $dono3 . '</td>
				    <td class="quadrado">Category<br>Categoria<br>Catégorie<br>Categoría<br><br><br><b>' . $categoria_en . '</b><br><b>' . $categoria_pt . '</b><br><b>' . $categoria_fr . '</b><br><b>' . $categoria_es . '</b></td>
				    <td class="quadrado">Construction area<br>Área de construção<br>Surface de construction<br>Área del construcción<br><br><b>' . $area . '</b></td>
				    <td class="quadrado">Construction time (months)<br>Prazo de construção (meses)<br>Temps de construction (mois)<br>Plazo de construcción (meses)<br><br><b>' . $prazo . '</b></td>
				  </tr>
				  <tr>
				    <td class="quadrado">Floors underground<br>Pisos abaixo do solo<br>Étages en sous-sol<br>Pisos por debajo del solo<br><br><b>' . $subpiso . '</b></td>
				    <td class="quadrado">Floors above the ground<br>Pisos acima do solo<br>Étages dessus du sol<br>Pisos sobre el solo<br><br><b>' . $piso . '</b></td>
				    <td class="quadrado">Value<br>Valor<br>Valeur<br>Valor<br><br><b>' . $valor . '</b></td>
				    <td class="quadrado">Stage of the work<br>Estado da obra<br>L′état de l′ouvrage<br>Estado de la obra<br><br><b>' . $estado_en . '</b><br><b>' . $estado_pt . '</b><br><b>' . $estado_fr . '</b><br><b>' . $estado_es . $data . '</b></td>
				  </tr>
				</table>

			</div>
			<div  style="width:100%;height:100%;padding:0 20px;background:#ddd url(' . $tras . ')no-repeat center;background-size:100% 100%;">

				<table style="width:100%;height:auto;padding:10px;border-spacing:30px;background:rgba(0,0,0,0.7);">
				  <tr>
				    <td class="retangulo"><img src="' . $img1 . '" width="350px"></td>
				    <td class="retangulo"><img src="' . $img2 . '" width="350px"></td>
				  </tr>
				  <tr>
				    <td class="retangulo"><img src="' . $img3 . '" width="350px"></td>
				    <td class="retangulo"><img src="' . $img4 . '" width="350px"></td>
				  </tr>
				  <tr>
				    <td class="descricao" colspan="2">' . $descricao_en . '<br><br>' . $descricao . '<br><br>' . $descricao_fr . '<br><br>' . $descricao_es . '</td>
				  </tr>
				</table>

			</div>
			<div style="clear:both"></div>
		</body> 
	</html>';

	$pdf_nome = str_replace(" ", "-", $nome_en);


	require_once('js/vendor/autoload.php');
	$mpdf = new \Mpdf\Mpdf();


	// define('MPDF_PATH', 'js/mpdf/');
	// include(MPDF_PATH . 'mpdf.php');
	// $mpdf = new mPDF();

	$mpdf->allow_charset_conversion = true;
	$mpdf->charset_in = 'UTF-8';

	$mpdf->WriteHTML($html);

	$mpdf->Output("$pdf_nome.pdf", 'D'); //D-Download I-Imprimir

	/*
	$mpdf->bMargin=0;
	$mpdf->tMargin=0;
	$mpdf->lMargin=0;
	$mpdf->rMargin=0;
*/

	//$mpdf->Output();
	exit();
}
