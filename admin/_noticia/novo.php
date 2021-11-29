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
$id_tipo = $_POST["id_tipo"];
$criacao = date('Y-m-d');
$publicacao = $_POST["publicacao"];
$titulo = text_variable($_POST["titulo"]);
$noticia = text_variable($_POST["noticia"]);
$titulo_en = text_variable($_POST["titulo_en"]);
$noticia_en = text_variable($_POST["noticia_en"]);
$titulo_fr = text_variable($_POST["titulo_fr"]);
$noticia_fr = text_variable($_POST["noticia_fr"]);
$titulo_es = text_variable($_POST["titulo_es"]);
$noticia_es = text_variable($_POST["noticia_es"]);

//echo "$id \n $titulo \n $img";

if($id || $titulo || $noticia || $titulo_en){
	if($id){
		$registo="Atualização da notícia ".$titulo." ( #".$id." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,registo,data,hora) VALUES ('$id_user','$id_user','$id','$registo','$data','$hora')");

		mysqli_query($lnk,"UPDATE noticia SET id_tipo='$id_tipo',nome='$titulo',nome_en='$titulo_en',nome_fr='$titulo_fr',nome_es='$titulo_es',
			texto='$noticia',texto_en='$noticia_en',texto_fr='$noticia_fr',texto_es='$noticia_es',publicacao='$publicacao' WHERE id='$id'");
	}
	else{
		mysqli_query($lnk, "INSERT INTO noticia(id_user,id_tipo,nome,nome_en,nome_fr,nome_es,texto,texto_en,texto_fr,texto_es,criacao,publicacao) 
			VALUES ('$id_user','$id_tipo','$titulo','$titulo_en','$titulo_fr','$titulo_es','$noticia','$noticia_en','$noticia_fr','$noticia_es','$criacao','$publicacao')");
		$id = mysqli_insert_id($lnk);

		//$registo="Criação da notícia ".$titulo." ( #".$id." )";
		//mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,registo,data,hora) VALUES ('$id_user','$id_user','$id','$registo','$data','$hora')");
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
					$nome_imagem = "/img/noticias/".$novoNome.$extensao;

					$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM imagem WHERE img='$nome_imagem'"));
					if(!$numero){$nomeExiste='nao';}
				}
				$destino = '../..'.$nome_imagem;
				upload_big($arquivo_tmp, $destino, $extensao);

				mysqli_query($lnk,"INSERT INTO imagem(id_noticia,img) VALUES ('$id','$nome_imagem')");
				/*if(@move_uploaded_file($arquivo_tmp, $destino)){
					$capaExiste=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM projeto_gal WHERE id_projeto='$id' AND capa='1'"));
					if($capaExiste){ $capa=0; }else{ $capa=1; }
					mysqli_query($lnk,"INSERT INTO projeto_gal(id_projeto,img,capa,online) VALUES ('$id','$nome_imagem','$capa','1')");
				}*/
			}
		}
		$registo="Atualização da notícia ".$titulo." ( #".$id." ) com ".$contar." imagens";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,registo,data,hora) VALUES ('$id_user','$id_user','$id','$registo','$data','$hora')");
	}
}
echo $id;
?>