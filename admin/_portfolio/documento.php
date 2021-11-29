<?php
include('../../_connect.php');
include('../funcao/upload_img.php');
session_start();
$id_user = $_SESSION['id_user'];
$linha_user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_user'"));
$nome_user = $linha_user['nome'];
$email_user = $linha_user['email'];
$data=date('Y-m-d');
$hora=date('H:i');

$id = $_POST["id"];
$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM ficha WHERE id='$id'"));
$id_ficha = $linha['id'];
$nome = $linha['nome'];
if($id_ficha){
	
	if($_FILES['documentos']['name'][0]){
		$contar = count($_FILES['documentos']['name']);
		for($i=0; $i<$contar; $i++){
			$arquivo_tmp = $_FILES['documentos']['tmp_name'][$i];
			$arquivo_name = $_FILES['documentos']['name'][$i];
			$extensao = strtolower(strrchr($arquivo_name, '.'));

			$tipo = '';
			if(strstr('.jpg;.jpeg;.png;.gif;.tiff;.svg', $extensao)){ $tipo='imagem'; }
			if(strstr('.php;.css;.html;.js', $extensao)){ $tipo='codigo'; }
			if(strstr('.mp4;.mov;.mkv;.avi', $extensao)){ $tipo='video'; }
			if(strstr('.mp3;.wav;.ogg', $extensao)){ $tipo='audio'; }
			if(strstr('.rar;.zip;.7zip', $extensao)){ $tipo='zip'; }
			if(strstr('.ppt;.pptx', $extensao)){ $tipo='powerpoint'; }
			if(strstr('.xls;.xlsx', $extensao)){ $tipo='excel'; }
			if(strstr('.doc;.docx;.odt', $extensao)){ $tipo='word'; }
			if(strstr('.pdf', $extensao)){ $tipo='pdf'; }
			if(strstr('.txt;.rtf', $extensao)){ $tipo='texto'; }

			$novoNome = $id_ficha."000";
			$nomeExiste = 'sim';
			while($nomeExiste=='sim'){
				$novoNome++;
				if(strlen($novoNome)==6){$novoNome = "0".$novoNome;}
				if(strlen($novoNome)==5){$novoNome = "00".$novoNome;}
				if(strlen($novoNome)==4){$novoNome = "000".$novoNome;}
				$nome_doc = "/admin/doc/".$novoNome.$extensao;

				$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM documentos WHERE documento='$nome_doc'"));
				if(!$numero){$nomeExiste='nao';}
			}

			$destino = '../..'.$nome_doc;
			if(@move_uploaded_file($arquivo_tmp, $destino)){
				mysqli_query($lnk,"INSERT INTO documentos(id_ficha,nome,documento,tipo) VALUES ('$id_ficha','$arquivo_name','$nome_doc','$tipo')");
			}
		}
		$registo="Adicionados ".$contar." documentos na ficha de obra ".$nome." ( #".$id." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_user','$registo','$data','$hora')");
	}
}
echo $id;
?>