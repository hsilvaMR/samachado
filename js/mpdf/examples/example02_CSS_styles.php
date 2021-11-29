<?php



$html = '
<style>
		body { font-family: freesans, sans-serif; font-size: 11pt;  }
		p { 	text-align: justify; margin-bottom: 4pt;  margin-top:0pt; }

		hr {	width: 70%; height: 1px; 
			text-align: center; color: #999999; 
			margin-top: 8pt; margin-bottom: 8pt; }

		a {	color: #000066; font-style: normal; text-decoration: underline; 
			font-weight: normal; }

		pre { font-family: DejaVuSansMono, monospaced; font-size: 9pt; margin-top: 5pt; margin-bottom: 5pt; }

		h1 {	font-weight: normal; font-size: 26pt; color: #000066; 
			 margin-top: 18pt; margin-bottom: 6pt; 
			border-top: 0.075cm solid #000000; border-bottom: 0.075cm solid #000000; 
			text-align: ; page-break-after:avoid; }
		h2 {	font-weight: bold; font-size: 12pt; color: #000066; 
			 margin-top: 6pt; margin-bottom: 6pt; 
			border-top: 0.07cm solid #000000; border-bottom: 0.07cm solid #000000; 
			text-align: ;  text-transform: uppercase; page-break-after:avoid; }
		h3 {	font-weight: normal; font-size: 26pt; color: #000000; 
			 margin-top: 0pt; margin-bottom: 6pt; 
			border-top: 0; border-bottom: 0; 
			text-align: ; page-break-after:avoid; }
		h4 {	font-weight: ; font-size: 13pt; color: #9f2b1e; 
			font-family: freesans, sans-serif; margin-top: 10pt; margin-bottom: 7pt; 
			font-variant: small-caps;
			text-align: ;  margin-collapse:collapse; page-break-after:avoid; }
		h5 {	font-weight: bold; font-style:italic; ; font-size: 11pt; color: #000044; 
			font-family: freesans, sans-serif; margin-top: 8pt; margin-bottom: 4pt; 
			text-align: ;  page-break-after:avoid; }
		h6 {	font-weight: bold; font-size: 9.5pt; color: #333333; 
			font-family: freesans, sans-serif; margin-top: 6pt; margin-bottom: ; 
			text-align: ;  page-break-after:avoid; }


		.breadcrumb {
			text-align: right; font-size: 8pt; font-family: DejaVuSerifCondensed, serif; color: #666666;
			font-weight: bold; font-style: normal; margin-bottom: 6pt; }

		.infobox { margin-top:10pt; background-color:#DDDDBB; text-align:center; border:1px solid #880000; }

		.big { font-size: 1.5em; }
		.red { color: #880000; }
		.slanted { font-style: italic; }



</style>
<html>
<body>
<h1>mPDF</h1>
<h2>Basic Example Using CSS Styles</h2>
<p class="breadcrumb">Chapter &raquo; Topic</p>
<h3>Heading 3</h3>
<h4>Heading 4</h4>
<h5>Heading 5</h5>
<p style="font-kerning: on">Nulla felis erat, imperdiet eu, ullamcorper non, nonummy quis, elit. Suspendisse potenti. Ut a eros at ligula vehicula pretium. Maecenas feugiat pede vel risus. Nulla et lectus. Fusce eleifend neque sit amet erat. Integer consectetuer nulla non orci. Morbi feugiat pulvinar dolor. Cras odio. Donec mattis, nisi id euismod auctor, neque metus pellentesque risus, at eleifend lacus sapien et risus. Phasellus metus. Phasellus feugiat, lectus ac aliquam molestie, leo lacus tincidunt turpis, vel aliquam quam odio et sapien. Mauris ante pede, auctor ac, suscipit quis, malesuada sed, nulla. Integer sit amet odio sit amet lectus luctus euismod. Donec et nulla. Sed quis orci. </p>
<h4>Heading using Small-Caps</h4>
<p>Proin aliquet lorem id felis. Curabitur vel libero at mauris nonummy tincidunt. Donec imperdiet. Vestibulum sem sem, lacinia vel, molestie et, laoreet eget, urna. Curabitur viverra faucibus pede. Morbi lobortis. Donec dapibus. Donec tempus. Ut arcu enim, rhoncus ac, venenatis eu, porttitor mollis, dui. Sed vitae risus. In elementum sem placerat dui. Nam tristique eros in nisl. Nulla cursus sapien non quam porta porttitor. Quisque dictum ipsum ornare tortor. Fusce ornare tempus enim. </p>
</body>
</html>';


//==============================================================
//==============================================================
//==============================================================

include("../mpdf.php");

$mpdf=new mPDF(); 



// LOAD a stylesheet

// The parameter 1 tells that this is css/style only and no body/html/text

$mpdf->WriteHTML($html);

$mpdf->Output();

exit;
//==============================================================
//==============================================================
//==============================================================

?>