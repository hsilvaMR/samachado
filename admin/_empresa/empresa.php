<?php
include('../../_connect.php');
include('../funcao/upload_img.php');
include('../funcao/clear_variable.php');
session_start();

$id_world = $_POST["id_world"];
$id = $_POST["id"];
$nome = text_variable($_POST["nome"]);
$texto = text_variable($_POST["texto"]);
$texto_en = text_variable($_POST["texto_en"]);
$texto_fr = text_variable($_POST["texto_fr"]);
$texto_es = text_variable($_POST["texto_es"]);
$id_category = $_POST["id_category"];

//echo "$id \n $nome";

if($id_world || $nome){
	if($id){
		mysqli_query($lnk,"UPDATE company SET id_category='$id_category',nome='$nome',texto='$texto',texto_en='$texto_en',texto_fr='$texto_fr',texto_es='$texto_es' WHERE id='$id'");
	}
	else{
		mysqli_query($lnk, "INSERT INTO company(id_world,id_category,nome,texto,texto_en,texto_fr,texto_es) VALUES ('$id_world','$id_category','$nome','$texto','$texto_en','$texto_fr','$texto_es')");
		$id = mysqli_insert_id($lnk);
	}
	if($_FILES['imagem']['name']){
		$arquivo_tmp = $_FILES['imagem']['tmp_name'];
		$arquivo_name = $_FILES['imagem']['name'];
		$extensao = strrchr($arquivo_name, '.');
		$extensao = strtolower($extensao);
		if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
			# apagar antiga
			$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM company WHERE id = '$id'"));
			$img = $linha['logo'];
			if($img && file_exists('../..'.$img)){ unlink('../..'.$img); }

			$novoNome = $id;
			if(strlen($novoNome)==3){$novoNome = "0".$novoNome;}
			if(strlen($novoNome)==2){$novoNome = "00".$novoNome;}
			if(strlen($novoNome)==1){$novoNome = "000".$novoNome;}
			$novoNome = $novoNome.$extensao;

			$destino = '../../img/logos/'.$novoNome;
			$nome_imagem = '/img/logos/'.$novoNome;

			upload_big($arquivo_tmp, $destino, $extensao);
			mysqli_query($lnk,"UPDATE company SET logo='$nome_imagem' WHERE id='$id'");

			//if(@move_uploaded_file($arquivo_tmp, $destino)){mysqli_query($lnk,"UPDATE menu SET img='$nome_imagem' WHERE id='$id'");}
		}
	}
}
echo $id_world.'/'.$id;
?>