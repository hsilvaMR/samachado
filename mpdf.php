<?php
ob_start();

//error_reporting(E_ERROR);
ini_set('display_errors', '1');

$html = ob_get_clean();
$html = utf8_decode($html);

include('_connect.php');

$url_completo = $_SERVER['REQUEST_URI'];
$url_partes = explode("/", $url_completo);
$IDIOMA = urldecode($url_partes[2]);
$id_linha = urldecode($url_partes[3]);
$id_linhaF = filter_var($id_linha, FILTER_VALIDATE_INT);
//$tabela = urldecode($url_partes[4]);

$tabela = "";

if (urldecode($url_partes[4]) != "") {

	$tabela = urldecode($url_partes[4]);
} else {

	$tabela = 'ficha';
}
// if ($tabela == '') {
// 	$tabela = 'ficha';
// }

// $existe = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM $tabela WHERE id='$id_linha'")); or mysqli_error($link));

// $Resultado_mysqli = mysqli_query($lnk, "SELECT * FROM $tabela WHERE id='$id_linha'");

$Resultado_mysqli = mysqli_query($lnk, "SELECT * FROM $tabela WHERE id='$id_linhaF'");
$existe = mysqli_fetch_array($Resultado_mysqli);

if ($existe) {
	extract(mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM $tabela WHERE id='$id_linhaF'")));

	$linha = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM categoria WHERE id='$id_categoria'"));
	if ($IDIOMA == 'EN') {
		$categoria = $linha["nome_en"];
	}
	if ($IDIOMA == 'PT') {
		$categoria = $linha["nome"];
	}
	if ($IDIOMA == 'FR') {
		$categoria = $linha["nome_fr"];
	}
	if ($IDIOMA == 'ES') {
		$categoria = $linha["nome_es"];
	}
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

	if ($IDIOMA == 'EN') {
		switch ($mesI) {
			case "01":
				$mesI = Jan;
				break;
			case "02":
				$mesI = Feb;
				break;
			case "03":
				$mesI = Mar;
				break;
			case "04":
				$mesI = Apr;
				break;
			case "05":
				$mesI = May;
				break;
			case "06":
				$mesI = Jun;
				break;
			case "07":
				$mesI = Jul;
				break;
			case "08":
				$mesI = Aug;
				break;
			case "09":
				$mesI = Sep;
				break;
			case "10":
				$mesI = Oct;
				break;
			case "11":
				$mesI = Nov;
				break;
			case "12":
				$mesI = Dec;
				break;
		}
		switch ($mesF) {
			case "01":
				$mesF = Jan;
				break;
			case "02":
				$mesF = Feb;
				break;
			case "03":
				$mesF = Mar;
				break;
			case "04":
				$mesF = Apr;
				break;
			case "05":
				$mesF = May;
				break;
			case "06":
				$mesF = Jun;
				break;
			case "07":
				$mesF = Jul;
				break;
			case "08":
				$mesF = Aug;
				break;
			case "09":
				$mesF = Sep;
				break;
			case "10":
				$mesF = Oct;
				break;
			case "11":
				$mesF = Nov;
				break;
			case "12":
				$mesF = Dec;
				break;
		}
	}
	if ($IDIOMA == 'PT') {
		switch ($mesI) {
			case "01":
				$mesI = 'Jan';
				break;
			case "02":
				$mesI = 'Fev';
				break;
			case "03":
				$mesI = 'Mar';
				break;
			case "04":
				$mesI = 'Abr';
				break;
			case "05":
				$mesI = 'Mai';
				break;
			case "06":
				$mesI = 'Jun';
				break;
			case "07":
				$mesI = 'Jul';
				break;
			case "08":
				$mesI = 'Ago';
				break;
			case "09":
				$mesI = 'Set';
				break;
			case "10":
				$mesI = 'Out';
				break;
			case "11":
				$mesI = 'Nov';
				break;
			case "12":
				$mesI = 'Dez';
				break;
		}
		switch ($mesF) {
			case "01":
				$mesF = 'Jan';
				break;
			case "02":
				$mesF = 'Fev';
				break;
			case "03":
				$mesF = 'Mar';
				break;
			case "04":
				$mesF = 'Abr';
				break;
			case "05":
				$mesF = 'Mai';
				break;
			case "06":
				$mesF = 'Jun';
				break;
			case "07":
				$mesF = 'Jul';
				break;
			case "08":
				$mesF = 'Ago';
				break;
			case "09":
				$mesF = 'Set';
				break;
			case "10":
				$mesF = 'Out';
				break;
			case "11":
				$mesF = 'Nov';
				break;
			case "12":
				$mesF = 'Dez';
				break;
		}
	}
	if ($IDIOMA == 'FR') {
		switch ($mesI) {
			case "01":
				$mesI = Jan;
				break;
			case "02":
				$mesI = Fév;
				break;
			case "03":
				$mesI = Mar;
				break;
			case "04":
				$mesI = Avr;
				break;
			case "05":
				$mesI = Mai;
				break;
			case "06":
				$mesI = Jui;
				break;
			case "07":
				$mesI = Juil;
				break;
			case "08":
				$mesI = Aoû;
				break;
			case "09":
				$mesI = Sep;
				break;
			case "10":
				$mesI = Oct;
				break;
			case "11":
				$mesI = Nov;
				break;
			case "12":
				$mesI = Déc;
				break;
		}
		switch ($mesF) {
			case "01":
				$mesF = Jan;
				break;
			case "02":
				$mesF = Fév;
				break;
			case "03":
				$mesF = Mar;
				break;
			case "04":
				$mesF = Avr;
				break;
			case "05":
				$mesF = Mai;
				break;
			case "06":
				$mesF = Jui;
				break;
			case "07":
				$mesF = Juil;
				break;
			case "08":
				$mesF = Aoû;
				break;
			case "09":
				$mesF = Sep;
				break;
			case "10":
				$mesF = Oct;
				break;
			case "11":
				$mesF = Nov;
				break;
			case "12":
				$mesF = Déc;
				break;
		}
	}
	if ($IDIOMA == 'ES') {
		switch ($mesI) {
			case "01":
				$mesI = Ene;
				break;
			case "02":
				$mesI = Feb;
				break;
			case "03":
				$mesI = Mar;
				break;
			case "04":
				$mesI = Abr;
				break;
			case "05":
				$mesI = May;
				break;
			case "06":
				$mesI = Jun;
				break;
			case "07":
				$mesI = Jul;
				break;
			case "08":
				$mesI = Ago;
				break;
			case "09":
				$mesI = Sep;
				break;
			case "10":
				$mesI = Oct;
				break;
			case "11":
				$mesI = Nov;
				break;
			case "12":
				$mesI = Dic;
				break;
		}
		switch ($mesF) {
			case "01":
				$mesF = Ene;
				break;
			case "02":
				$mesF = Feb;
				break;
			case "03":
				$mesF = Mar;
				break;
			case "04":
				$mesF = Abr;
				break;
			case "05":
				$mesF = May;
				break;
			case "06":
				$mesF = Jun;
				break;
			case "07":
				$mesF = Jul;
				break;
			case "08":
				$mesF = Ago;
				break;
			case "09":
				$mesF = Sep;
				break;
			case "10":
				$mesF = Oct;
				break;
			case "11":
				$mesF = Nov;
				break;
			case "12":
				$mesF = Dic;
				break;
		}
	}
	if ($fim != '0000-00-00') {
		$data = '<br><br>' . $mesF . ' ' . $anoF;
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
	if ($IDIOMA == 'EN') {
		$estado = $linha3["nome_en"];
	}
	if ($IDIOMA == 'PT') {
		$estado = $linha3["nome"];
	}
	if ($IDIOMA == 'FR') {
		$estado = $linha3["nome_fr"];
	}
	if ($IDIOMA == 'ES') {
		$estado = $linha3["nome_es"];
	}

	$linha4 = mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM pais WHERE id='$id_pais'"));
	if ($IDIOMA == 'EN') {
		$pais = $linha4["nome_en"];
	}
	if ($IDIOMA == 'PT') {
		$pais = $linha4["nome_pt"];
	}
	if ($IDIOMA == 'FR') {
		$pais = $linha4["nome_fr"];
	}
	if ($IDIOMA == 'ES') {
		$pais = $linha4["nome_es"];
	}

	if ($IDIOMA == 'PT') {
		$label1 = "FICHA DE OBRA";
		$label2 = "Proprietário";
		$label3 = "Categoria";
		$label4 = "Área de construção";
		$label5 = "Prazo de construção";
		$label51 = "meses";

		$label6 = "Pisos abaixo do solo";
		$label7 = "Pisos acima do solo";
		$label8 = "Valor";
		$label9 = "Estado da obra";
	}
	if ($IDIOMA == 'EN') {
		$label1 = "TECHNICAL OVERVIEW";
		$label2 = "Owner";
		$label3 = "Category";
		$label4 = "Construction area";
		$label5 = "Construction time";
		$label51 = "months";

		$label6 = "Floors underground";
		$label7 = "Floors above the ground";
		$label8 = "Value";
		$label9 = "Stage of the work";
		$nome = $nome_en;
		$dono = $dono_en;
		$descricao = $descricao_en;
	}
	if ($IDIOMA == 'FR') {
		$label1 = "PRÉSENTATION TECHNIQUE";
		$label2 = "Maitre d'ouvrage";
		$label3 = "Catégorie";
		$label4 = "Surface de construction";
		$label5 = "Temps de construction";
		$label51 = "mois";

		$label6 = "Étages en sous-sol";
		$label7 = "Étages dessus du sol";
		$label8 = "Valeur";
		$label9 = "L'état de l'ouvrage";
		$nome = $nome_fr;
		$dono = $dono_fr;
		$descricao = $descricao_fr;
	}
	if ($IDIOMA == 'ES') {
		$label1 = "DESCRIPCIÓN TÉCNICA";
		$label2 = "Dueño de obra";
		$label3 = "Categoría";
		$label4 = "Área del construcción";
		$label5 = "Plazo de construcción";
		$label51 = "meses";

		$label6 = "Pisos por debajo del solo";
		$label7 = "Pisos sobre el solo";
		$label8 = "Valor";
		$label9 = "Estado de la obra";
		$nome = $nome_es;
		$dono = $dono_es;
		$descricao = $descricao_es;
	}

	if ($prazo != "-") {
		$prazo = $prazo . " " . $label51;
	}

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
				.quadrado{width:25%;text-align:center;vertical-align:middle;font-size:12px;height:180px;background:rgba(0,0,0,0.3);}
				.retangulo{width:50%;text-align:center;vertical-align:middle;background-size:auto 100%;background-repeat:no-repeat;background-position:center;}
				.descricao{text-align:justify;font-size:12px;}
			</style>
		</head> 
		<body>
			<div style="width:100%;height:100%;padding:40px 25px;background:#bbb url(' . $frente . ')no-repeat center;background-size:100% 100%;">

				<table style="width:100%;padding:10px;' . $letra_escura . '">
				  <tr>
				    <td class="ficha">' . $label1 . '</td>
				    <td class="logo" rowspan="3"><img src="' . $logo . '" height="30px" style="margin-top:-12px;"></td>
				  </tr>
				  <tr>
				    <td class="titulo">' . $nome . '</td>
				  </tr>
				  <tr>
				    <td class="morada">' . $morada . ' - ' . $pais . '</td>
				  </tr>
				</table>

				<table style="width:100%;margin-top:20px;border-spacing:10px;">
				  <tr>
				    <td class="quadrado">' . $label2 . '<br><br><b>' . $dono . '</b></td>
				    <td class="quadrado">' . $label3 . '<br><br><b>' . $categoria . '</b></td>
				    <td class="quadrado">' . $label4 . '<br><br><b>' . $area . '</b></td>
				    <td class="quadrado">' . $label5 . '<br><br><b>' . $prazo . '</b></td>
				  </tr>
				  <tr>
				    <td class="quadrado">' . $label6 . '<br><br><b>' . $subpiso . '</b></td>
				    <td class="quadrado">' . $label7 . '<br><br><b>' . $piso . '</b></td>
				    <td class="quadrado">' . $label8 . '<br><br><b>' . $valor . '</b></td>
				    <td class="quadrado">' . $label9 . '<br><br><b>' . $estado . $data . '</b></td>
				  </tr>
				</table>

			</div>
			<div  style="width:100%;height:100%;padding:0 20px;background:#bbb url(' . $tras . ')no-repeat center;background-size:100% 100%;">

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
				    <td class="descricao" colspan="2">' . nl2br($descricao) . '</td>
				  </tr>
				</table>

			</div>
			<div style="clear:both"></div>
		</body> 
	</html>';

	$pdf_nome = str_replace(" ", "-", $nome);

	require_once('js/vendor/autoload.php');
	$mpdf = new \Mpdf\Mpdf();

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
