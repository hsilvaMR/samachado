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
$referencia = text_variable($_POST["referencia"]);
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
$online = isset($_POST["online"]) ? $_POST["online"] : '';
$bloquear = isset($_POST["bloquear"]) ? $_POST["bloquear"] : '';
$obs = text_variable($_POST["obs"]);
//echo "$id \n $nome \n $img";

if($id || $nome || $dono || $area || $prazo || $subpiso || $piso || $valor || $morada || $descricao){
	if($id){
		mysqli_query($lnk,"UPDATE ficha SET referencia='$referencia',nome='$nome',nome_en='$nome_en',nome_fr='$nome_fr',nome_es='$nome_es',escuro='$escuro',dono='$dono',dono_en='$dono_en',dono_fr='$dono_fr',dono_es='$dono_es',id_categoria='$id_categoria',area='$area',prazo='$prazo',subpiso='$subpiso',piso='$piso',inicio='$inicio',fim='$fim',id_estado='$id_estado',valor='$valor',oculto='$oculto',id_moeda='$id_moeda',morada='$morada',latitude='$latitude',longitude='$longitude',id_pais='$id_pais',descricao='$descricao',descricao_en='$descricao_en',descricao_fr='$descricao_fr',descricao_es='$descricao_es',online='$online',bloquear='$bloquear',obs='$obs' WHERE id='$id'");

		$registo="Atualização da ficha ".$nome." ( #".$id." ) no portfólio";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");
	}
	else{
		mysqli_query($lnk, "INSERT INTO ficha(referencia,nome,nome_en,nome_fr,nome_es,escuro,dono,dono_en,dono_fr,dono_es,id_categoria,area,prazo,subpiso,piso,inicio,fim,id_estado,valor,oculto,id_moeda,morada,latitude,longitude,id_pais,descricao,descricao_en,descricao_fr,descricao_es,online,bloquear,obs) VALUES 
			('$referencia','$nome','$nome_en','$nome_fr','$nome_es','$escuro','$dono','$dono_en','$dono_fr','$dono_es','$id_categoria','$area','$prazo','$subpiso','$piso','$inicio','$fim','$id_estado','$valor','$oculto','$id_moeda','$morada','$latitude','$longitude','$id_pais','$descricao','$descricao_en','$descricao_fr','$descricao_es','$online','$bloquear','$obs')");
		$id = mysqli_insert_id($lnk);

		$registo="Criação da ficha ".$nome." ( #".$id." ) no portfólio";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");
	}

	if($_FILES['capa']['name']){
		$arquivo_tmp = $_FILES['capa']['tmp_name'];
		$arquivo_name = $_FILES['capa']['name'];
		$extensao = strrchr($arquivo_name, '.');
		$extensao = strtolower($extensao);
		if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
			# apagar antiga
			$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE id = '$id'"));
			$img = $linha['capa'];
			if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }

			$novoNome = $id;
			if(strlen($novoNome)==3){$novoNome = "0".$novoNome;}
			if(strlen($novoNome)==2){$novoNome = "00".$novoNome;}
			if(strlen($novoNome)==1){$novoNome = "000".$novoNome;}
			$novoNome = $novoNome."00".$extensao;

			$destino = '../../img/fichas/'.$novoNome;
			$nome_imagem = '/img/fichas/'.$novoNome;

			upload_small($arquivo_tmp, $destino, $extensao);
			mysqli_query($lnk,"UPDATE ficha SET capa='$nome_imagem' WHERE id='$id'");

			$registo="Actualização da foto de capa da ficha ".$nome." ( #".$id." ) no portfólio";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");

			//if(@move_uploaded_file($arquivo_tmp, $destino)){mysqli_query($lnk,"UPDATE ficha SET tras='$nome_imagem' WHERE id='$id'");}
			$nome_doc = "/admin/doc/".$novoNome;
			$destino_doc = '../..'.$nome_doc;
			if(@move_uploaded_file($arquivo_tmp, $destino_doc)){
				mysqli_query($lnk,"INSERT INTO documentos(id_ficha,nome,documento,tipo) VALUES ('$id','$arquivo_name','$nome_doc','imagem')");
			}
		}
	}
	if($_FILES['frente']['name']){
		$arquivo_tmp = $_FILES['frente']['tmp_name'];
		$arquivo_name = $_FILES['frente']['name'];
		$extensao = strrchr($arquivo_name, '.');
		$extensao = strtolower($extensao);
		if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
			# apagar antiga
			$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE id = '$id'"));
			$img = $linha['frente'];
			if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }

			$novoNome = $id;
			if(strlen($novoNome)==3){$novoNome = "0".$novoNome;}
			if(strlen($novoNome)==2){$novoNome = "00".$novoNome;}
			if(strlen($novoNome)==1){$novoNome = "000".$novoNome;}
		
			$novoNome = $novoNome."01".$extensao;
			$destino = '../../img/fichas/'.$novoNome;
			$nome_imagem = '/img/fichas/'.$novoNome;

			upload_full($arquivo_tmp, $destino, $extensao);
			mysqli_query($lnk,"UPDATE ficha SET frente='$nome_imagem' WHERE id='$id'");

			$registo="Actualização da foto da frente da ficha ".$nome." ( #".$id." ) no portfólio";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");

			//if(@move_uploaded_file($arquivo_tmp, $destino)){mysqli_query($lnk,"UPDATE ficha SET tras='$nome_imagem' WHERE id='$id'");}
			$nome_doc = "/admin/doc/".$novoNome;
			$destino_doc = '../..'.$nome_doc;
			if(@move_uploaded_file($arquivo_tmp, $destino_doc)){
				mysqli_query($lnk,"INSERT INTO documentos(id_ficha,nome,documento,tipo) VALUES ('$id','$arquivo_name','$nome_doc','imagem')");
			}
		}
	}
	if($_FILES['tras']['name']){
		$arquivo_tmp = $_FILES['tras']['tmp_name'];
		$arquivo_name = $_FILES['tras']['name'];
		$extensao = strrchr($arquivo_name, '.');
		$extensao = strtolower($extensao);
		if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
			# apagar antiga
			$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE id = '$id'"));
			$img = $linha['tras'];
			if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }

			$novoNome = $id;
			if(strlen($novoNome)==3){$novoNome = "0".$novoNome;}
			if(strlen($novoNome)==2){$novoNome = "00".$novoNome;}
			if(strlen($novoNome)==1){$novoNome = "000".$novoNome;}
		
			$novoNome = $novoNome."02".$extensao;
			$destino = '../../img/fichas/'.$novoNome;
			$nome_imagem = '/img/fichas/'.$novoNome;

			upload_full($arquivo_tmp, $destino, $extensao);
			mysqli_query($lnk,"UPDATE ficha SET tras='$nome_imagem' WHERE id='$id'");

			$registo="Actualização de foto de trás da ficha ".$nome." ( #".$id." ) no portfólio";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");

			//if(@move_uploaded_file($arquivo_tmp, $destino)){mysqli_query($lnk,"UPDATE ficha SET tras='$nome_imagem' WHERE id='$id'");}
			$nome_doc = "/admin/doc/".$novoNome;
			$destino_doc = '../..'.$nome_doc;
			if(@move_uploaded_file($arquivo_tmp, $destino_doc)){
				mysqli_query($lnk,"INSERT INTO documentos(id_ficha,nome,documento,tipo) VALUES ('$id','$arquivo_name','$nome_doc','imagem')");
			}
		}
	}
	if($_FILES['img1']['name']){
		$arquivo_tmp = $_FILES['img1']['tmp_name'];
		$arquivo_name = $_FILES['img1']['name'];
		$extensao = strrchr($arquivo_name, '.');
		$extensao = strtolower($extensao);
		if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
			# apagar antiga
			$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE id = '$id'"));
			$img = $linha['img1'];
			if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }

			$novoNome = $id;
			if(strlen($novoNome)==3){$novoNome = "0".$novoNome;}
			if(strlen($novoNome)==2){$novoNome = "00".$novoNome;}
			if(strlen($novoNome)==1){$novoNome = "000".$novoNome;}
		
			$novoNome = $novoNome."03".$extensao;
			$destino = '../../img/fichas/'.$novoNome;
			$nome_imagem = '/img/fichas/'.$novoNome;
			
			upload_small($arquivo_tmp, $destino, $extensao);
			mysqli_query($lnk,"UPDATE ficha SET img1='$nome_imagem' WHERE id='$id'");

			$registo="Actualização da foto 1 da ficha ".$nome." ( #".$id." ) no portfólio";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");

			//if(@move_uploaded_file($arquivo_tmp, $destino)){mysqli_query($lnk,"UPDATE ficha SET tras='$nome_imagem' WHERE id='$id'");}
			$nome_doc = "/admin/doc/".$novoNome;
			$destino_doc = '../..'.$nome_doc;
			if(@move_uploaded_file($arquivo_tmp, $destino_doc)){
				mysqli_query($lnk,"INSERT INTO documentos(id_ficha,nome,documento,tipo) VALUES ('$id','$arquivo_name','$nome_doc','imagem')");
			}
		}
	}
	if($_FILES['img2']['name']){
		$arquivo_tmp = $_FILES['img2']['tmp_name'];
		$arquivo_name = $_FILES['img2']['name'];
		$extensao = strrchr($arquivo_name, '.');
		$extensao = strtolower($extensao);
		if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
			# apagar antiga
			$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE id = '$id'"));
			$img = $linha['img2'];
			if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }

			$novoNome = $id;
			if(strlen($novoNome)==3){$novoNome = "0".$novoNome;}
			if(strlen($novoNome)==2){$novoNome = "00".$novoNome;}
			if(strlen($novoNome)==1){$novoNome = "000".$novoNome;}
		
			$novoNome = $novoNome."04".$extensao;
			$destino = '../../img/fichas/'.$novoNome;
			$nome_imagem = '/img/fichas/'.$novoNome;

			upload_small($arquivo_tmp, $destino, $extensao);
			mysqli_query($lnk,"UPDATE ficha SET img2='$nome_imagem' WHERE id='$id'");

			$registo="Actualização da foto 2 da ficha ".$nome." ( #".$id." ) no portfólio";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");

			//if(@move_uploaded_file($arquivo_tmp, $destino)){mysqli_query($lnk,"UPDATE ficha SET tras='$nome_imagem' WHERE id='$id'");}
			$nome_doc = "/admin/doc/".$novoNome;
			$destino_doc = '../..'.$nome_doc;
			if(@move_uploaded_file($arquivo_tmp, $destino_doc)){
				mysqli_query($lnk,"INSERT INTO documentos(id_ficha,nome,documento,tipo) VALUES ('$id','$arquivo_name','$nome_doc','imagem')");
			}
		}
	}
	if($_FILES['img3']['name']){
		$arquivo_tmp = $_FILES['img3']['tmp_name'];
		$arquivo_name = $_FILES['img3']['name'];
		$extensao = strrchr($arquivo_name, '.');
		$extensao = strtolower($extensao);
		if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
			# apagar antiga
			$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE id = '$id'"));
			$img = $linha['img3'];
			if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }

			$novoNome = $id;
			if(strlen($novoNome)==3){$novoNome = "0".$novoNome;}
			if(strlen($novoNome)==2){$novoNome = "00".$novoNome;}
			if(strlen($novoNome)==1){$novoNome = "000".$novoNome;}
		
			$novoNome = $novoNome."05".$extensao;
			$destino = '../../img/fichas/'.$novoNome;
			$nome_imagem = '/img/fichas/'.$novoNome;

			upload_small($arquivo_tmp, $destino, $extensao);
			mysqli_query($lnk,"UPDATE ficha SET img3='$nome_imagem' WHERE id='$id'");

			$registo="Actualização da foto 3 da ficha ".$nome." ( #".$id." ) no portfólio";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");

			//if(@move_uploaded_file($arquivo_tmp, $destino)){mysqli_query($lnk,"UPDATE ficha SET tras='$nome_imagem' WHERE id='$id'");}
			$nome_doc = "/admin/doc/".$novoNome;
			$destino_doc = '../..'.$nome_doc;
			if(@move_uploaded_file($arquivo_tmp, $destino_doc)){
				mysqli_query($lnk,"INSERT INTO documentos(id_ficha,nome,documento,tipo) VALUES ('$id','$arquivo_name','$nome_doc','imagem')");
			}
		}
	}
	if($_FILES['img4']['name']){
		$arquivo_tmp = $_FILES['img4']['tmp_name'];
		$arquivo_name = $_FILES['img4']['name'];
		$extensao = strrchr($arquivo_name, '.');
		$extensao = strtolower($extensao);
		if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
			# apagar antiga
			$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE id = '$id'"));
			$img = $linha['img4'];
			if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }

			$novoNome = $id;
			if(strlen($novoNome)==3){$novoNome = "0".$novoNome;}
			if(strlen($novoNome)==2){$novoNome = "00".$novoNome;}
			if(strlen($novoNome)==1){$novoNome = "000".$novoNome;}
		
			$novoNome = $novoNome."06".$extensao;
			$destino = '../../img/fichas/'.$novoNome;
			$nome_imagem = '/img/fichas/'.$novoNome;
			
			upload_small($arquivo_tmp, $destino, $extensao);
			mysqli_query($lnk,"UPDATE ficha SET img4='$nome_imagem' WHERE id='$id'");

			$registo="Actualização da foto 4 da ficha ".$nome." ( #".$id." ) no portfólio";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");
			
			//if(@move_uploaded_file($arquivo_tmp, $destino)){mysqli_query($lnk,"UPDATE ficha SET tras='$nome_imagem' WHERE id='$id'");}
			$nome_doc = "/admin/doc/".$novoNome;
			$destino_doc = '../..'.$nome_doc;
			if(@move_uploaded_file($arquivo_tmp, $destino_doc)){
				mysqli_query($lnk,"INSERT INTO documentos(id_ficha,nome,documento,tipo) VALUES ('$id','$arquivo_name','$nome_doc','imagem')");
			}
		}
	}

	/*if($_FILES['imagem']['name'][0]){
		$contar = count($_FILES['imagem']['name']);
		for($i=0; $i<$contar; $i++){
			$arquivo_tmp = $_FILES['imagem']['tmp_name'][$i];
			$arquivo_name = $_FILES['imagem']['name'][$i];
			$extensao = strrchr($arquivo_name, '.');
			$extensao = strtolower($extensao);
			if(strstr('.jpg;.jpeg;.png', $extensao)){
				if(strlen($novoNome)==3){$novoNome = "0".$novoNome;}
				if(strlen($novoNome)==2){$novoNome = "00".$novoNome;}
				if(strlen($novoNome)==1){$novoNome = "000".$novoNome;}
				$novoNome = $novoNome."00";
				$nomeExiste = 'sim';
				while($nomeExiste=='sim'){
					$novoNome++;
					$verificacao = "/img/fichas/".$novoNome.$extensao;
					$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM galeria WHERE img='$verificacao'"));
					if(!$numero){$nomeExiste='nao';}
				}
				$novoNome = $novoNome.$extensao;
				$destino = '../../img/fichas/'.$novoNome;
				$nome_imagem = '/img/fichas/'.$novoNome;
				if(@move_uploaded_file($arquivo_tmp, $destino)){
					mysqli_query($lnk,"INSERT INTO galeria(id_ficha,img) VALUES ('$id','$nome_imagem')");
				}
			}
		}
	}*/
}
echo $id;
?>