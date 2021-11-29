<?php
include('../../_connect.php');
include('../funcao/upload_img.php');
include('../funcao/clear_variable.php');
session_start();
$id_user = $_SESSION['id_user'];
$linha_user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_user'"));
$nome_user = $linha_user['nome'];
$email_user = $linha_user['email'];
$data=date('Y-m-d');
$hora=date('H:i');

$id = $_POST["id"];
$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM processo WHERE id='$id'"));
$id_processo = $linha['id'];
$id_etapa = $linha['id_etapa'];
$ficha = $linha['ficha'];
if(!$ficha){
	$referencia = text_variable($_POST["referencia"]);
	$processo = text_variable($_POST["processo"]);
	$nome = text_variable($_POST["nome"]);
	$escuro = isset($_POST["escuro"]) ? $_POST["escuro"] : '';
	$dono = text_variable($_POST["dono"]);
	$id_categoria = $_POST["id_categoria"];
	$area = str_replace(",", ".", trim($_POST["area"]));
	$prazo = $_POST["prazo"];
	$subpiso = trim($_POST["subpiso"]);
	$piso = trim($_POST["piso"]);
	$inicio = $_POST["inicio"];
	$fim = $_POST["fim"];
	$id_estado = $_POST["id_estado"];
	$oculto = isset($_POST["oculto"]) ? $_POST["oculto"] : '';
	$valor = str_replace(",", ".", trim($_POST["valor"]));
	$id_moeda = $_POST["id_moeda"];
	$morada = text_variable($_POST["morada"]);
	$latitude = text_variable($_POST["latitude"]);
	$longitude = text_variable($_POST["longitude"]);
	$id_pais = $_POST["id_pais"];
	$descricao = text_variable($_POST["descricao"]);
	$nome_en = text_variable($_POST["nome_en"]);
	$nome_fr = text_variable($_POST["nome_fr"]);
	$nome_es = text_variable($_POST["nome_es"]);
	$dono_en = text_variable($_POST["dono_en"]);
	$dono_fr = text_variable($_POST["dono_fr"]);
	$dono_es = text_variable($_POST["dono_es"]);
	$descricao_en = text_variable($_POST["descricao_en"]);
	$descricao_fr = text_variable($_POST["descricao_fr"]);
	$descricao_es = text_variable($_POST["descricao_es"]);
	
	//echo "$id \n $nome \n $img";

	if($id || $referencia || $processo || $nome || $dono || $area || $prazo || $subpiso || $piso || $valor || $morada || $descricao){
		if($id){
			$registo="Atualização da ficha de obra ".$referencia." - ".$processo." ( #".$id." )";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo','$id_etapa','$registo','$data','$hora')");
			mysqli_query($lnk,"UPDATE processo SET referencia='$referencia',processo='$processo',nome='$nome',nome_en='$nome_en',nome_fr='$nome_fr',nome_es='$nome_es',escuro='$escuro',dono='$dono',dono_en='$dono_en',dono_fr='$dono_fr',dono_es='$dono_es',id_categoria='$id_categoria',area='$area',prazo='$prazo',subpiso='$subpiso',piso='$piso',inicio='$inicio',fim='$fim',id_estado='$id_estado',valor='$valor',oculto='$oculto',id_moeda='$id_moeda',morada='$morada',latitude='$latitude',longitude='$longitude',id_pais='$id_pais',descricao='$descricao',descricao_en='$descricao_en',descricao_fr='$descricao_fr',descricao_es='$descricao_es' WHERE id='$id'");
		}
		else{
			mysqli_query($lnk, "INSERT INTO processo(referencia,processo,nome,nome_en,nome_fr,nome_es,escuro,dono,dono_en,dono_fr,dono_es,id_categoria,area,prazo,subpiso,piso,inicio,fim,id_estado,valor,oculto,id_moeda,morada,latitude,longitude,id_pais,descricao,descricao_en,descricao_fr,descricao_es) VALUES 
				('$referencia','$processo','$nome','$nome_en','$nome_fr','$nome_es','$escuro','$dono','$dono_en','$dono_fr','$dono_es','$id_categoria','$area','$prazo','$subpiso','$piso','$inicio','$fim','$id_estado','$valor','$oculto','$id_moeda','$morada','$latitude','$longitude','$id_pais','$descricao','$descricao_en','$descricao_fr','$descricao_es')");
			$id = mysqli_insert_id($lnk);
			$registo="Criação da ficha de obra ".$referencia." - ".$processo." ( #".$id." )";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id','1','$registo','$data','$hora')");
		}

		if($_FILES['imagem']['name'][0]){
			$contar = count($_FILES['imagem']['name']);
			for($i=0; $i<$contar; $i++){
				$arquivo_tmp = $_FILES['imagem']['tmp_name'][$i];
				$arquivo_name = $_FILES['imagem']['name'][$i];
				$extensao = strrchr($arquivo_name, '.');
				$extensao = strtolower($extensao);
				if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
					$novoNome = $id."000";
					$nomeExiste = 'sim';
					while($nomeExiste=='sim'){
						$novoNome++;
						if(strlen($novoNome)==6){$novoNome = "0".$novoNome;}
						if(strlen($novoNome)==5){$novoNome = "00".$novoNome;}
						if(strlen($novoNome)==4){$novoNome = "000".$novoNome;}
						$nome_imagem = "/admin/galeria/".$novoNome.$extensao;

						$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM galeria WHERE img='$nome_imagem'"));
						if(!$numero){$nomeExiste='nao';}
					}
					$destino = '../..'.$nome_imagem;
					upload_full($arquivo_tmp, $destino, $extensao);
					
					$capaExiste=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id' AND capa='1'"));
					if($capaExiste){ $capa=0; }else{ $capa=1; }
					list($width, $height) = getimagesize($destino);
				    if($width>$height){ $tipo='horizontal'; }else{ $tipo='vertical'; }
					mysqli_query($lnk,"INSERT INTO galeria(id_processo,img,capa,tipo) VALUES ('$id','$nome_imagem','$capa','$tipo')");

					/*if(@move_uploaded_file($arquivo_tmp, $destino)){
						$capaExiste=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM projeto_gal WHERE id_projeto='$id' AND capa='1'"));
						if($capaExiste){ $capa=0; }else{ $capa=1; }
						mysqli_query($lnk,"INSERT INTO projeto_gal(id_projeto,img,capa,online) VALUES ('$id','$nome_imagem','$capa','1')");
					}*/
				}
			}
			$registo="Atualização da ficha de obra ".$referencia." - ".$processo."( #".$id." ) com ".$contar." fotografias";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo','$id_etapa','$registo','$data','$hora')");
		}
	}
}
echo $id;
?>