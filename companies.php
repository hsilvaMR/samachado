<? ob_start(); ?>
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
<? $sep='companies';
include '_header.php';?>
<article class="companies-fundo companies-margens">
	<section class="companies-conteudo">
		<div class="companies-filtro">
			<?
			$url_completo = $_SERVER['REQUEST_URI'];
			$url_partes = explode("/", $url_completo);
			$id_linha = urldecode($url_partes[2]);
			$id_linha = filter_var($id_linha, FILTER_VALIDATE_INT);
			$existe=mysqli_num_rows(mysqli_query($lnk, "SELECT * FROM world WHERE online=1 AND id='$id_linha'"));
			if(!$existe){ header('Location: /world'); }
			$query = mysqli_query($lnk, "SELECT * FROM company WHERE online=1 AND id_world='$id_linha'");
			$quantidade=mysqli_num_rows($query);
	  		if($quantidade==1){
	  			$linha = mysqli_fetch_array($query);
	  			$id=$linha["id"];
	  			$nome=$linha["nome"];
				$url_nome = str_replace(" ", "-", $nome);
				header("Location: /company/$id/$url_nome");
	  		}
			?>
			<!--<div class="world-circ"></div>
			<div class="companies-notificacoes"><? echo $nomeUp; ?></div>-->
			<div class="companies-notificacoes">
				<select id="res_PAIS">
					<?
                    $query = mysqli_query($lnk,"SELECT * FROM world WHERE online=1");
					while($linha = mysqli_fetch_array($query))
					{
						$id = $linha["id"];
						if($IDIOMA=='EN'){$nome = $linha["nome_en"];}
						if($IDIOMA=='PT'){$nome = $linha["nome"];}
						if($IDIOMA=='FR'){$nome = $linha["nome_fr"];}
						if($IDIOMA=='ES'){$nome = $linha["nome_es"];}
						$nomeUp = strtoupper($nome);
						$nomeUp = str_replace("ç", "Ç", $nomeUp);
						$nomeUp = str_replace("á", "Á", $nomeUp);
						$nomeUp = str_replace("à", "À", $nomeUp);
						$url_nome = str_replace(" ", "-", $nome); ?>
                        <option value="<? echo $id.'/'.$url_nome; ?>" <? if($id==$id_linha){echo "selected";}?>><? echo $nomeUp; ?></option>
                    <?}?>
				</select>
				<select id="width_tmp_select" class="none"><option id="width_tmp_option"></option></select>
			</div>
			<!--<a href="/companies/<? echo $id_linha.'/'.$url_nome; ?>"><div class="companies-all"><? if($IDIOMA=='EN'){echo "VIEW ALL";} if($IDIOMA=='PT'){echo "VER TUDO";} if($IDIOMA=='FR'){echo "VOIR TOUT";} if($IDIOMA=='ES'){echo "VER TODO";} ?></div></a>-->
		</div>
		<div class="companies-scroll nano">
			<div class="nano-content">
				<?
				$query=mysqli_query($lnk, "SELECT * FROM company WHERE online=1 AND id_world='$id_linha'");
	  			while ($linha=mysqli_fetch_array($query)){
					$id=$linha["id"];
					$id_category=$linha["id_category"];
					$nome=$linha["nome"];
					$url_nome = str_replace(" ", "-", $nome);
					$img=$linha["logo"];
					$linha2=mysqli_fetch_array(mysqli_query($lnk, "SELECT * FROM category WHERE id='$id_category'"));
					if($IDIOMA=='EN'){ $category=$linha2["nome_en"]; }
					if($IDIOMA=='PT'){ $category=$linha2["nome"]; }
					if($IDIOMA=='FR'){ $category=$linha2["nome_fr"]; }
					if($IDIOMA=='ES'){ $category=$linha2["nome_es"]; }
					?>
		            <div class="companies-ficha">
		            	<div class="companies-foto" style="background-image:url(<? echo $img; ?>);"></div>
		            	<div class="companies-data"><b><? echo $category; ?></b></div>
		            	<div class="companies-titulo"><? echo $nome; ?></div>
		            	<div class="companies-butao" onclick="window.location.replace('/company/<? echo $id.'/'.$url_nome;?>');"><? if($IDIOMA=='EN'){echo "view";} if($IDIOMA=='PT'){echo "ver";} if($IDIOMA=='FR'){echo "voir";} if($IDIOMA=='ES'){echo "ver";} ?></div>
		            </div>
		            <?
		        }?>
		    </div>
		</div>
	</section>
</article>
<script>
$(document).ready(function() {
	//$('select').prop('selectedIndex', 0);

	$("#width_tmp_option").html($('#res_PAIS option:selected').text()); 
	$('#res_PAIS').width($("#width_tmp_select").width());

	$('#res_PAIS').change(function(){
		$("#width_tmp_option").html($('#res_PAIS option:selected').text()); 
		$(this).width($("#width_tmp_select").width());

		var pais = $('#res_PAIS').val();
		window.location.replace("/companies/"+pais);
	});
});
</script>
</body>
</html>