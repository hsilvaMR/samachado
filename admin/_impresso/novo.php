<?php
include('../../_connect.php');
//include('../funcao/upload_img.php');
include('../funcao/clear_variable.php');
session_start();

$id = $_POST["id"];
$referencia = text_variable($_POST["referencia"]);
$titulo = text_variable($_POST["titulo"]);

if($id || $referencia || $titulo){
	if($id){
		mysqli_query($lnk,"UPDATE impressos SET referencia='$referencia',titulo='$titulo' WHERE id='$id'");
	}
	else{
		mysqli_query($lnk, "INSERT INTO impressos(referencia,titulo) VALUES ('$referencia','$titulo')");
		$id = mysqli_insert_id($lnk);
	}

	if($_FILES['ficheiro']['name']){
		$arquivo_tmp = $_FILES['ficheiro']['tmp_name'];
		$arquivo_name = $_FILES['ficheiro']['name'];
		$arquivo_name = strtolower($arquivo_name);

		$i=2;
		$nomeExiste = 'sim';
		$verificacao="/doc/".$arquivo_name;
		while($nomeExiste=='sim'){
			$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM impressos WHERE ficheiro='$verificacao' AND id!='$id'"));
			if($numero){$verificacao="/doc/".$i.'-'.$arquivo_name; $i++;}
			else{$nomeExiste='nao'; $novoNome=$verificacao;}
		}
		$destino = '../..'.$novoNome;

		# apagar ficheiro antigo
		$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM impressos WHERE id='$id'"));
		$ficheiro = $linha['ficheiro'];
		if($ficheiro && file_exists('../..'.$ficheiro)){ unlink('../..'.$ficheiro); }

		if(@move_uploaded_file($arquivo_tmp, $destino)){mysqli_query($lnk,"UPDATE impressos SET ficheiro='$novoNome' WHERE id='$id'");}
		
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