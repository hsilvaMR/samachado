<?
if(isset($_COOKIE["IDIOMA"])){$IDIOMA = $_COOKIE["IDIOMA"];}else{$IDIOMA = 'PT';}
$restricao='';$queryS='';$queryI='';$queryF='';$queryP='';$queryC=''; $pais=''; $nome=''; $descricao='';
if(isset($pesquisa)){
	if($IDIOMA=='EN'){ $queryS = "AND (nome_en LIKE '%$pesquisa%' OR dono_en LIKE '%$pesquisa%')"; }
	if($IDIOMA=='PT'){ $queryS = "AND (nome LIKE '%$pesquisa%' OR dono LIKE '%$pesquisa%')"; }
	if($IDIOMA=='FR'){ $queryS = "AND (nome_fr LIKE '%$pesquisa%' OR dono_fr LIKE '%$pesquisa%')"; }
	if($IDIOMA=='ES'){ $queryS = "AND (nome_es LIKE '%$pesquisa%' OR dono_es LIKE '%$pesquisa%')"; }
}
if(isset($inicio) && $inicio){ $inicioI=$inicio."-01-01";$inicioF=$inicio."-12-31"; $queryI="AND inicio >= '$inicioI' AND inicio < '$inicioF' AND inicio != '0000-00-00'"; }
if(isset($fim) && $fim){ if($fim==1){ $queryF = "AND id_estado = '1'"; }
						else{ $fimI=$fim."-01-01";  $fimF=$fim."-12-31"; $queryF="AND fim >= '$fimI' AND fim < '$fimF' AND fim != '0000-00-00'"; } }
if(isset($id_pais) && $id_pais){ $queryP = "AND id_pais = '$id_pais'"; }
if(isset($categoria) && $categoria){ $queryC = "AND id_categoria = '$categoria'"; }

if($IDIOMA=='EN'){ $restricao="AND nome_en!=''"; }
if($IDIOMA=='PT'){ $restricao="AND nome!=''"; }
if($IDIOMA=='FR'){ $restricao="AND nome_fr!=''"; }
if($IDIOMA=='ES'){ $restricao="AND nome_es!=''"; }

$i=0;
$query=mysqli_query($lnk,"SELECT * FROM ficha WHERE online=1 $restricao $queryS $queryI $queryF $queryP $queryC ORDER BY ordem ASC");
while($linha=mysqli_fetch_array($query))
{
	$id=$linha["id"];
	$id_pais=$linha["id_pais"];
	if($IDIOMA=='EN'){ $nome=$linha["nome_en"]; $descricao=$linha["descricao_en"]; }
	if($IDIOMA=='PT'){ $nome=$linha["nome"]; $descricao=$linha["descricao"]; }
	if($IDIOMA=='FR'){ $nome=$linha["nome_fr"]; $descricao=$linha["descricao_fr"]; }
	if($IDIOMA=='ES'){ $nome=$linha["nome_es"]; $descricao=$linha["descricao_es"]; }
	$url_nome = str_replace(" ", "-", $nome);

	$img=$linha["capa"];
	$linha2=mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM pais WHERE id='$id_pais'"));
	if($IDIOMA=='EN'){ $pais=$linha2["nome_en"]; }
	if($IDIOMA=='PT'){ $pais=$linha2["nome_pt"]; }
	if($IDIOMA=='FR'){ $pais=$linha2["nome_fr"]; }
	if($IDIOMA=='ES'){ $pais=$linha2["nome_es"]; }
	?>
    <div id="<? echo $id.'-'.$url_nome; ?>" class="portfolio-ficha">
    	<div class="portfolio-foto" style="background-image:url(<? echo $img; ?>);"><? if($linha["id_estado"]==1){?><div class="portfolio-icon"></div><? }?></div>
    	<div class="portfolio-pais"><b><? echo $pais; ?></b></div>
    	<div class="portfolio-tit-tex">
	    	<div class="portfolio-titulo"><? echo $nome; ?></div>
	    	<div class="portfolio-texto"><? echo $descricao; ?></div>
	    </div>
    	<div class="portfolio-butao" onclick="window.location.replace('/overview/<? echo $id.'/'.$url_nome;?>');">+ info<!--<? if($IDIOMA=='EN'){echo "more";} if($IDIOMA=='PT'){echo "mais";} if($IDIOMA=='FR'){echo "plus";} if($IDIOMA=='ES'){echo "más";} ?>--></div>
    </div>
    <?
    $i++;
}
if(!$i)
{
	?>
	<div class="portfolio-vazio"><? if($IDIOMA=='EN'){echo "No results!";} if($IDIOMA=='PT'){echo "Sem Resultados!";} if($IDIOMA=='FR'){echo "Aucun résultat!";} if($IDIOMA=='ES'){echo "No hay resultados!";} ?></div>
	<?
}?>