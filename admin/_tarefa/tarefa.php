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
$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tarefa WHERE id='$id'"));
$id_manda = $linha['id_manda'];
$id_faz = $linha['id_faz'];
$id_etapa = $linha['id_etapa'];
$id_processo = $linha['id_processo'];

$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM processo WHERE id='$id_processo'"));
$referencia = $linha2['referencia'];
$processo = $linha2['processo'];
$ficha = $linha2['ficha'];

$aviso = '';
if(!$ficha){
	$botao = $_POST["botao"];
	//ETAPA 1
	if($id_etapa=='1'){
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
		$str = strlen($descricao);

		$registo="Atualização da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo','$id_etapa','$registo','$data','$hora')");
		mysqli_query($lnk,"UPDATE processo SET nome='$nome',escuro='$escuro',dono='$dono',id_categoria='$id_categoria',area='$area',prazo='$prazo',subpiso='$subpiso',piso='$piso',inicio='$inicio',fim='$fim',id_estado='$id_estado',valor='$valor',oculto='$oculto',id_moeda='$id_moeda',morada='$morada',latitude='$latitude',longitude='$longitude',id_pais='$id_pais',descricao='$descricao' WHERE id='$id_processo'");

		if($_FILES['imagem']['name'][0]){
			$contar = count($_FILES['imagem']['name']);
			for($i=0; $i<$contar; $i++){
				$arquivo_tmp = $_FILES['imagem']['tmp_name'][$i];
				$arquivo_name = $_FILES['imagem']['name'][$i];
				$extensao = strrchr($arquivo_name, '.');
				$extensao = strtolower($extensao);
				if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
					$novoNome = $id_processo."000";
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
					
					$capaExiste=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id_processo' AND capa='1'"));
					if($capaExiste){ $capa=0; }else{ $capa=1; }
					list($width, $height) = getimagesize($destino);
				    if($width>=$height){ $tipo='horizontal'; }else{ $tipo='vertical'; }
					mysqli_query($lnk,"INSERT INTO galeria(id_processo,img,capa,tipo) VALUES ('$id_processo','$nome_imagem','$capa','$tipo')");

					/*if(@move_uploaded_file($arquivo_tmp, $destino)){
						$capaExiste=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM projeto_gal WHERE id_projeto='$id_processo' AND capa='1'"));
						if($capaExiste){ $capa=0; }else{ $capa=1; }
						mysqli_query($lnk,"INSERT INTO projeto_gal(id_projeto,img,capa,online) VALUES ('$id_processo','$nome_imagem','$capa','1')");
					}*/
				}
			}
			$registo="Atualização da ficha de obra ".$referencia." - ".$processo."( #".$id_processo." ) com ".$contar." fotografias";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo','$id_etapa','$registo','$data','$hora')");
		}
		if($botao=='guardar'){$aviso='TF';}
		if($botao=='enviar'){
			/*$completa=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE id='$id_processo' AND nome!='' AND dono!='' AND area!='' AND prazo!='0' AND piso!='' AND
				subpiso!='' AND inicio!='0000-00-00' AND fim!='0000-00-00' AND (valor!='' OR oculto='1') AND descricao!='' AND morada!=''"));
			$verticais=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id_processo' AND tipo='vertical'"));
			$horizontais=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id_processo' AND tipo='horizontal'"));
			if(!$completa){$aviso = 'Todos os campos são de preenchimento obrigatório.';}
			if($str<400 && !$aviso){$aviso = 'Escreva uma descrição mais alongada da obra.';}
			if($verticais<3 && !$aviso){$aviso = 'Carregue mais fotos verticais.';}
			if($horizontais<6 && !$aviso){$aviso = 'Carregue mais fotos horizontais.';}*/
			if(!$aviso){
				$registo="Etapa 1 concluída da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo',1,'$registo','$data','$hora')");
				
				$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tarefa WHERE id_processo='$id_processo' AND id_etapa=2"));
				$id_tarefa_pro = $linha3['id'];
				$id_faz_pro = $linha3['id_faz'];

				$registo="Início da etapa 2 da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_faz_pro','$id_processo',2,'$registo','$data','$hora')");
		
				$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_pro'"));
				$nome_util = $linha4['nome'];
				$email_util = $linha4['email'];

				mysqli_query($lnk,"UPDATE processo SET id_etapa=2 WHERE id='$id_processo'");
				mysqli_query($lnk,"UPDATE tarefa SET data='$data' WHERE id='$id_tarefa_pro'");
				mysqli_query($lnk, "DELETE FROM tarefa WHERE id='$id'");
				
				$para = $nome_util." <".$email_util.">";
				$paraEmail = $email_util;
				$paraNome = $nome_util;
				$De = $nome_user." <".$email_user.">";
				$assunto = "Plataforma Online Sá Machado";
				$mensagem = '
				<html>
				<head>
				 <title>'.$assunto.'</title>
				 <style>*{font-size:14px;}</style>
				</head>
				<body>
				<p>Olá '.$nome_util.', tem uma <b>nova tarefa</b>.</p>
				<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
				<p>Na plataforma tens informações sobre a tarefa a realizares bem como um chat para te ajudar, no caso de teres dúvidas.</p>
				<p>Todas as tuas interações são guardadas e apresentadas no histórico!</p>
				<p>Melhores Cumprimentos</p>
				<p>'.$nome_user.'</p>
				<br><hr>
				</body>
				</html>
				';
				include('../funcao/email.php');
				$aviso='TM';
			}
		}
	}
	//ETAPA 2
	if($id_etapa=='2'){
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
		$str = strlen($descricao);

		$registo="Atualização da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo','$id_etapa','$registo','$data','$hora')");
		mysqli_query($lnk,"UPDATE processo SET nome='$nome',escuro='$escuro',dono='$dono',id_categoria='$id_categoria',area='$area',prazo='$prazo',subpiso='$subpiso',piso='$piso',inicio='$inicio',fim='$fim',id_estado='$id_estado',valor='$valor',oculto='$oculto',id_moeda='$id_moeda',morada='$morada',latitude='$latitude',longitude='$longitude',id_pais='$id_pais',descricao='$descricao' WHERE id='$id_processo'");

		if($_FILES['imagem']['name'][0]){
			$contar = count($_FILES['imagem']['name']);
			for($i=0; $i<$contar; $i++){
				$arquivo_tmp = $_FILES['imagem']['tmp_name'][$i];
				$arquivo_name = $_FILES['imagem']['name'][$i];
				$extensao = strrchr($arquivo_name, '.');
				$extensao = strtolower($extensao);
				if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
					$novoNome = $id_processo."000";
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
					
					$capaExiste=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id_processo' AND capa='1'"));
					if($capaExiste){ $capa=0; }else{ $capa=1; }
					list($width, $height) = getimagesize($destino);
				    if($width>=$height){ $tipo='horizontal'; }else{ $tipo='vertical'; }
					mysqli_query($lnk,"INSERT INTO galeria(id_processo,img,capa,tipo) VALUES ('$id_processo','$nome_imagem','$capa','$tipo')");

					/*if(@move_uploaded_file($arquivo_tmp, $destino)){
						$capaExiste=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM projeto_gal WHERE id_projeto='$id_processo' AND capa='1'"));
						if($capaExiste){ $capa=0; }else{ $capa=1; }
						mysqli_query($lnk,"INSERT INTO projeto_gal(id_projeto,img,capa,online) VALUES ('$id_processo','$nome_imagem','$capa','1')");
					}*/
				}
			}
			$registo="Atualização da ficha de obra ".$referencia." - ".$processo."( #".$id_processo." ) com ".$contar." fotografias";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo','$id_etapa','$registo','$data','$hora')");
		}
		if($botao=='guardar'){$aviso='TF';}
		if($botao=='reprovar'){
			$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM registo WHERE id_processo='$id_processo' AND id_etapa=1 ORDER BY id DESC"));
			$id_faz_ant = $linha3['id_user'];

			mysqli_query($lnk, "INSERT INTO tarefa(id_manda,id_faz,id_etapa,id_processo,data) VALUES ('$id_user','$id_faz_ant',1,'$id_processo','$data')");
			$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_ant'"));
			$nome_ant = $linha4['nome'];
			$email_ant = $linha4['email'];
			$registo="Reprovação da 1ª etapa realizada por ".$nome_ant."( #".$id_faz_ant." )";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_faz_ant','$id_processo',1,'$registo','$data','$hora')");
			
			mysqli_query($lnk,"UPDATE processo SET id_etapa=1 WHERE id='$id_processo'");
			mysqli_query($lnk,"UPDATE tarefa SET data='0000-00-00' WHERE id='$id'");
			
			$nota = $_POST["nota"];
			//if($nota){mysqli_query($lnk, "INSERT INTO chat(id_emissor,id_recetor,mensagem,data,hora) VALUES ('$id_user','$id_faz_ant','$nota','$data','$hora')");}

			$para = $nome_ant." <".$email_ant.">";
			$paraEmail = $email_ant;
			$paraNome = $nome_ant;
			$De = $nome_user." <".$email_user.">";
			$assunto = "Plataforma Online Sá Machado";
			$mensagem = '
			<html>
			<head>
			 <title>'.$assunto.'</title>
			 <style>*{font-size:14px;}</style>
			</head>
			<body>
			<p>Olá '.$nome_ant.', a sua tarefa foi <b>reprovada</b>.</p>
			<p><b>"'.$nota.'"</b></p><br>
			<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
			<p>Na plataforma tens informações sobre a tarefa a realizares bem como um chat para te ajudar, no caso de teres dúvidas.</p>
			<p>Todas as tuas interações são guardadas e apresentadas no histórico!</p>
			<p>Melhores Cumprimentos</p>
			<p>'.$nome_user.'</p>
			<br><hr>
			</body>
			</html>
			';
			include('../funcao/email.php');
			$aviso='TC';

		}
		if($botao=='enviar'){
			/*$completa=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE id='$id_processo' AND nome!='' AND dono!='' AND area!='' AND prazo!='0' AND piso!='' AND 
				subpiso!='' AND inicio!='0000-00-00' AND fim!='0000-00-00' AND (valor!='' OR oculto='1') AND descricao!='' AND morada!=''"));
			$verticais=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id_processo' AND tipo='vertical'"));
			$horizontais=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id_processo' AND tipo='horizontal'"));
			if(!$completa){$aviso = 'Todos os campos são de preenchimento obrigatório.';}
			if($str<400 && !$aviso){$aviso = 'Escreva uma descrição mais alongada da obra.';}
			if($verticais<3 && !$aviso){$aviso = 'Carregue mais fotos verticais.';}
			if($horizontais<6 && !$aviso){$aviso = 'Carregue mais fotos horizontais.';}*/
			if(!$aviso){
				$registo="Etapa 2 concluída da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo',2,'$registo','$data','$hora')");
				
				$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tarefa WHERE id_processo='$id_processo' AND id_etapa=3 ORDER BY id DESC"));
				$id_tarefa_pro = $linha3['id'];
				$id_faz_pro = $linha3['id_faz'];

				$registo="Início da etapa 3 da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_faz_pro','$id_processo',3,'$registo','$data','$hora')");
		
				$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_pro'"));
				$nome_util = $linha4['nome'];
				$email_util = $linha4['email'];

				mysqli_query($lnk,"UPDATE processo SET id_etapa=3 WHERE id='$id_processo'");
				mysqli_query($lnk,"UPDATE tarefa SET data='$data' WHERE id='$id_tarefa_pro'");
				mysqli_query($lnk, "DELETE FROM tarefa WHERE id='$id'");
				
				$para = $nome_util." <".$email_util.">";
				$paraEmail = $email_util;
				$paraNome = $nome_util;
				$De = $nome_user." <".$email_user.">";
				$assunto = "Plataforma Online Sá Machado";
				$mensagem = '
				<html>
				<head>
				 <title>'.$assunto.'</title>
				 <style>*{font-size:14px;}</style>
				</head>
				<body>
				<p>Olá '.$nome_util.', tem uma <b>nova tarefa</b>.</p>
				<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
				<p>Na plataforma tens informações sobre a tarefa a realizares bem como um chat para te ajudar, no caso de teres dúvidas.</p>
				<p>Todas as tuas interações são guardadas e apresentadas no histórico!</p>
				<p>Melhores Cumprimentos</p>
				<p>'.$nome_user.'</p>
				<br><hr>
				</body>
				</html>
				';
				include('../funcao/email.php');
				$aviso='TM';
			}
		}
	}
	//ETAPA 3
	if($id_etapa=='3'){
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
		$str = strlen($descricao);

		$registo="Atualização da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo','$id_etapa','$registo','$data','$hora')");
		mysqli_query($lnk,"UPDATE processo SET nome='$nome',escuro='$escuro',dono='$dono',id_categoria='$id_categoria',area='$area',prazo='$prazo',subpiso='$subpiso',piso='$piso',inicio='$inicio',fim='$fim',id_estado='$id_estado',valor='$valor',oculto='$oculto',id_moeda='$id_moeda',morada='$morada',latitude='$latitude',longitude='$longitude',id_pais='$id_pais',descricao='$descricao' WHERE id='$id_processo'");

		if($_FILES['imagem']['name'][0]){
			$contar = count($_FILES['imagem']['name']);
			for($i=0; $i<$contar; $i++){
				$arquivo_tmp = $_FILES['imagem']['tmp_name'][$i];
				$arquivo_name = $_FILES['imagem']['name'][$i];
				$extensao = strrchr($arquivo_name, '.');
				$extensao = strtolower($extensao);
				if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
					$novoNome = $id_processo."000";
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
					
					$capaExiste=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id_processo' AND capa='1'"));
					if($capaExiste){ $capa=0; }else{ $capa=1; }
					list($width, $height) = getimagesize($destino);
				    if($width>=$height){ $tipo='horizontal'; }else{ $tipo='vertical'; }
					mysqli_query($lnk,"INSERT INTO galeria(id_processo,img,capa,tipo) VALUES ('$id_processo','$nome_imagem','$capa','$tipo')");

					/*if(@move_uploaded_file($arquivo_tmp, $destino)){
						$capaExiste=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM projeto_gal WHERE id_projeto='$id_processo' AND capa='1'"));
						if($capaExiste){ $capa=0; }else{ $capa=1; }
						mysqli_query($lnk,"INSERT INTO projeto_gal(id_projeto,img,capa,online) VALUES ('$id_processo','$nome_imagem','$capa','1')");
					}*/
				}
			}
			$registo="Atualização da ficha de obra ".$referencia." - ".$processo."( #".$id_processo." ) com ".$contar." fotografias";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo','$id_etapa','$registo','$data','$hora')");
		}
		if($botao=='guardar'){$aviso='TF';}
		if($botao=='reprovar'){
			$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM registo WHERE id_processo='$id_processo' AND id_etapa=2 ORDER BY id DESC"));
			$id_faz_ant = $linha3['id_user'];

			mysqli_query($lnk, "INSERT INTO tarefa(id_manda,id_faz,id_etapa,id_processo,data) VALUES ('$id_user','$id_faz_ant',2,'$id_processo','$data')");
			$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_ant'"));
			$nome_ant = $linha4['nome'];
			$email_ant = $linha4['email'];
			$registo="Reprovação da 2ª etapa realizada por ".$nome_ant."( #".$id_faz_ant." )";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_faz_ant','$id_processo',2,'$registo','$data','$hora')");
			
			mysqli_query($lnk,"UPDATE processo SET id_etapa=2 WHERE id='$id_processo'");
			mysqli_query($lnk,"UPDATE tarefa SET data='0000-00-00' WHERE id='$id'");
			
			$nota = $_POST["nota"];
			//if($nota){mysqli_query($lnk, "INSERT INTO chat(id_emissor,id_recetor,mensagem,data,hora) VALUES ('$id_user','$id_faz_ant','$nota','$data','$hora')");}

			$para = $nome_ant." <".$email_ant.">";
			$paraEmail = $email_ant;
			$paraNome = $nome_ant;
			$De = $nome_user." <".$email_user.">";
			$assunto = "Plataforma Online Sá Machado";
			$mensagem = '
			<html>
			<head>
			 <title>'.$assunto.'</title>
			 <style>*{font-size:14px;}</style>
			</head>
			<body>
			<p>Olá '.$nome_ant.', a sua tarefa foi <b>reprovada</b>.</p>
			<p><b>"'.$nota.'"</b></p><br>
			<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
			<p>Na plataforma tens informações sobre a tarefa a realizares bem como um chat para te ajudar, no caso de teres dúvidas.</p>
			<p>Todas as tuas interações são guardadas e apresentadas no histórico!</p>
			<p>Melhores Cumprimentos</p>
			<p>'.$nome_user.'</p>
			<br><hr>
			</body>
			</html>
			';
			include('../funcao/email.php');
			$aviso='TC';
		}
		if($botao=='enviar'){
			/*$completa=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE id='$id_processo' AND nome!='' AND dono!='' AND area!='' AND prazo!='0' AND piso!='' AND 
				subpiso!='' AND inicio!='0000-00-00' AND fim!='0000-00-00' AND (valor!='' OR oculto='1') AND descricao!='' AND morada!=''"));
			$verticais=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id_processo' AND tipo='vertical'"));
			$horizontais=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id_processo' AND tipo='horizontal'"));
			if(!$completa){$aviso = 'Todos os campos são de preenchimento obrigatório.';}
			if($str<400 && !$aviso){$aviso = 'Escreva uma descrição mais alongada da obra.';}
			if($verticais<3 && !$aviso){$aviso = 'Carregue mais fotos verticais.';}
			if($horizontais<6 && !$aviso){$aviso = 'Carregue mais fotos horizontais.';}*/
			if(!$aviso){
				$registo="Etapa 3 concluída da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo',3,'$registo','$data','$hora')");
				
				$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tarefa WHERE id_processo='$id_processo' AND id_etapa=4 ORDER BY id DESC"));
				$id_tarefa_pro = $linha3['id'];
				$id_faz_pro = $linha3['id_faz'];

				$registo="Início da etapa 4 da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_faz_pro','$id_processo',4,'$registo','$data','$hora')");
		
				$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_pro'"));
				$nome_util = $linha4['nome'];
				$email_util = $linha4['email'];

				mysqli_query($lnk,"UPDATE processo SET id_etapa=4 WHERE id='$id_processo'");
				mysqli_query($lnk,"UPDATE tarefa SET data='$data' WHERE id='$id_tarefa_pro'");
				mysqli_query($lnk, "DELETE FROM tarefa WHERE id='$id'");
				
				$para = $nome_util." <".$email_util.">";
				$paraEmail = $email_util;
				$paraNome = $nome_util;
				$De = $nome_user." <".$email_user.">";
				$assunto = "Plataforma Online Sá Machado";
				$mensagem = '
				<html>
				<head>
				 <title>'.$assunto.'</title>
				 <style>*{font-size:14px;}</style>
				</head>
				<body>
				<p>Olá '.$nome_util.', tem uma <b>nova tarefa</b>.</p>
				<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
				<p>Na plataforma tens informações sobre a tarefa a realizares bem como um chat para te ajudar, no caso de teres dúvidas.</p>
				<p>Todas as tuas interações são guardadas e apresentadas no histórico!</p>
				<p>Melhores Cumprimentos</p>
				<p>'.$nome_user.'</p>
				<br><hr>
				</body>
				</html>
				';
				include('../funcao/email.php');
				$aviso='TM';
			}
		}
	}
	//ETAPA 4
	if($id_etapa=='4'){
		$nome_en = text_variable($_POST["nome_en"]);
		$nome_fr = text_variable($_POST["nome_fr"]);
		$nome_es = text_variable($_POST["nome_es"]);
		$dono_en = text_variable($_POST["dono_en"]);
		$dono_fr = text_variable($_POST["dono_fr"]);
		$dono_es = text_variable($_POST["dono_es"]);
		$descricao_en = text_variable($_POST["descricao_en"]);
		$descricao_fr = text_variable($_POST["descricao_fr"]);
		$descricao_es = text_variable($_POST["descricao_es"]);

		$registo="Atualização das traduções da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo','$id_etapa','$registo','$data','$hora')");
		mysqli_query($lnk,"UPDATE processo SET nome_en='$nome_en',nome_fr='$nome_fr',nome_es='$nome_es',dono_en='$dono_en',dono_fr='$dono_fr',dono_es='$dono_es',
			descricao_en='$descricao_en',descricao_fr='$descricao_fr',descricao_es='$descricao_es' WHERE id='$id_processo'");

		if($botao=='guardar'){$aviso='TF';}
		if($botao=='enviar'){
			/*$completa=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE id='$id_processo' AND nome_en!='' AND nome_fr!='' AND nome_es!='' AND dono_en!='' AND dono_fr!='' AND dono_es!='' AND descricao_en!='' AND descricao_fr!='' AND descricao_es!=''"));
			if(!$completa){$aviso = 'Preencha todos os campos. Faltam traduções.';}*/
			if(!$aviso){
				$registo="Etapa 4 concluída da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo',4,'$registo','$data','$hora')");
				
				$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tarefa WHERE id_processo='$id_processo' AND id_etapa=5 ORDER BY id DESC"));
				$id_tarefa_pro = $linha3['id'];
				$id_faz_pro = $linha3['id_faz'];

				$registo="Início da etapa 5 da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_faz_pro','$id_processo',5,'$registo','$data','$hora')");
		
				$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_pro'"));
				$nome_util = $linha4['nome'];
				$email_util = $linha4['email'];

				mysqli_query($lnk,"UPDATE processo SET id_etapa=5 WHERE id='$id_processo'");
				mysqli_query($lnk,"UPDATE tarefa SET data='$data' WHERE id='$id_tarefa_pro'");
				mysqli_query($lnk, "DELETE FROM tarefa WHERE id='$id'");
				
				$para = $nome_util." <".$email_util.">";
				$paraEmail = $email_util;
				$paraNome = $nome_util;
				$De = $nome_user." <".$email_user.">";
				$assunto = "Plataforma Online Sá Machado";
				$mensagem = '
				<html>
				<head>
				 <title>'.$assunto.'</title>
				 <style>*{font-size:14px;}</style>
				</head>
				<body>
				<p>Olá '.$nome_util.', tem uma <b>nova tarefa</b>.</p>
				<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
				<p>Na plataforma tens informações sobre a tarefa a realizares bem como um chat para te ajudar, no caso de teres dúvidas.</p>
				<p>Todas as tuas interações são guardadas e apresentadas no histórico!</p>
				<p>Melhores Cumprimentos</p>
				<p>'.$nome_user.'</p>
				<br><hr>
				</body>
				</html>
				';
				include('../funcao/email.php');
				$aviso='TM';
			}
		}
	}
	//ETAPA 5
	if($id_etapa=='5'){
		$nome_en = text_variable($_POST["nome_en"]);
		$nome_fr = text_variable($_POST["nome_fr"]);
		$nome_es = text_variable($_POST["nome_es"]);
		$dono_en = text_variable($_POST["dono_en"]);
		$dono_fr = text_variable($_POST["dono_fr"]);
		$dono_es = text_variable($_POST["dono_es"]);
		$descricao_en = text_variable($_POST["descricao_en"]);
		$descricao_fr = text_variable($_POST["descricao_fr"]);
		$descricao_es = text_variable($_POST["descricao_es"]);

		$registo="Atualização das traduções da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo','$id_etapa','$registo','$data','$hora')");
		mysqli_query($lnk,"UPDATE processo SET nome_en='$nome_en',nome_fr='$nome_fr',nome_es='$nome_es',dono_en='$dono_en',dono_fr='$dono_fr',dono_es='$dono_es',
			descricao_en='$descricao_en',descricao_fr='$descricao_fr',descricao_es='$descricao_es' WHERE id='$id_processo'");

		if($botao=='guardar'){$aviso='TF';}
		if($botao=='reprovar'){
			$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM registo WHERE id_processo='$id_processo' AND id_etapa=4 ORDER BY id DESC"));
			$id_faz_ant = $linha3['id_user'];

			mysqli_query($lnk, "INSERT INTO tarefa(id_manda,id_faz,id_etapa,id_processo,data) VALUES ('$id_user','$id_faz_ant',4,'$id_processo','$data')");
			$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_ant'"));
			$nome_ant = $linha4['nome'];
			$email_ant = $linha4['email'];
			$registo="Reprovação da 4ª etapa realizada por ".$nome_ant."( #".$id_faz_ant." )";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_faz_ant','$id_processo',4,'$registo','$data','$hora')");
			
			mysqli_query($lnk,"UPDATE processo SET id_etapa=4 WHERE id='$id_processo'");
			mysqli_query($lnk,"UPDATE tarefa SET data='0000-00-00' WHERE id='$id'");
			
			$nota = $_POST["nota"];
			//if($nota){mysqli_query($lnk, "INSERT INTO chat(id_emissor,id_recetor,mensagem,data,hora) VALUES ('$id_user','$id_faz_ant','$nota','$data','$hora')");}

			$para = $nome_ant." <".$email_ant.">";
			$paraEmail = $email_ant;
			$paraNome = $nome_ant;
			$De = $nome_user." <".$email_user.">";
			$assunto = "Plataforma Online Sá Machado";
			$mensagem = '
			<html>
			<head>
			 <title>'.$assunto.'</title>
			 <style>*{font-size:14px;}</style>
			</head>
			<body>
			<p>Olá '.$nome_ant.', a sua tarefa foi <b>reprovada</b>.</p>
			<p><b>"'.$nota.'"</b></p><br>
			<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
			<p>Na plataforma tens informações sobre a tarefa a realizares bem como um chat para te ajudar, no caso de teres dúvidas.</p>
			<p>Todas as tuas interações são guardadas e apresentadas no histórico!</p>
			<p>Melhores Cumprimentos</p>
			<p>'.$nome_user.'</p>
			<br><hr>
			</body>
			</html>
			';
			include('../funcao/email.php');
			$aviso='TC';
		}
		if($botao=='enviar'){
			/*$completa=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE id='$id_processo' AND nome_en!='' AND nome_fr!='' AND nome_es!='' AND dono_en!='' AND dono_fr!='' AND dono_es!='' AND descricao_en!='' AND descricao_fr!='' AND descricao_es!=''"));
			if(!$completa){$aviso = 'Todos os campos são de preenchimento obrigatório.';}*/
			if(!$aviso){
				$registo="Etapa 5 concluída da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo',5,'$registo','$data','$hora')");
				
				$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM tarefa WHERE id_processo='$id_processo' AND id_etapa=6 ORDER BY id DESC"));
				$id_tarefa_pro = $linha3['id'];
				$id_faz_pro = $linha3['id_faz'];

				$registo="Início da etapa 6 da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_faz_pro','$id_processo',6,'$registo','$data','$hora')");
		
				$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_pro'"));
				$nome_util = $linha4['nome'];
				$email_util = $linha4['email'];

				mysqli_query($lnk,"UPDATE processo SET id_etapa=6 WHERE id='$id_processo'");
				mysqli_query($lnk,"UPDATE tarefa SET data='$data' WHERE id='$id_tarefa_pro'");
				mysqli_query($lnk, "DELETE FROM tarefa WHERE id='$id'");
				
				$para = $nome_util." <".$email_util.">";
				$paraEmail = $email_util;
				$paraNome = $nome_util;
				$De = $nome_user." <".$email_user.">";
				$assunto = "Plataforma Online Sá Machado";
				$mensagem = '
				<html>
				<head>
				 <title>'.$assunto.'</title>
				 <style>*{font-size:14px;}</style>
				</head>
				<body>
				<p>Olá '.$nome_util.', tem uma <b>nova tarefa</b>.</p>
				<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
				<p>Na plataforma tens informações sobre a tarefa a realizares bem como um chat para te ajudar, no caso de teres dúvidas.</p>
				<p>Todas as tuas interações são guardadas e apresentadas no histórico!</p>
				<p>Melhores Cumprimentos</p>
				<p>'.$nome_user.'</p>
				<br><hr>
				</body>
				</html>
				';
				include('../funcao/email.php');
				$aviso='TM';
			}
		}
	}
	//ETAPA 6 - ÚLTIMA
	if($id_etapa=='6'){
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
		$str = strlen($descricao);
		$nome_en = text_variable($_POST["nome_en"]);
		$nome_fr = text_variable($_POST["nome_fr"]);
		$nome_es = text_variable($_POST["nome_es"]);
		$dono_en = text_variable($_POST["dono_en"]);
		$dono_fr = text_variable($_POST["dono_fr"]);
		$dono_es = text_variable($_POST["dono_es"]);
		$descricao_en = text_variable($_POST["descricao_en"]);
		$descricao_fr = text_variable($_POST["descricao_fr"]);
		$descricao_es = text_variable($_POST["descricao_es"]);

		$registo="Atualização da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo','$id_etapa','$registo','$data','$hora')");
		mysqli_query($lnk,"UPDATE processo SET nome='$nome',nome_en='$nome_en',nome_fr='$nome_fr',nome_es='$nome_es',escuro='$escuro',dono='$dono',dono_en='$dono_en',dono_fr='$dono_fr',dono_es='$dono_es',id_categoria='$id_categoria',area='$area',prazo='$prazo',subpiso='$subpiso',piso='$piso',inicio='$inicio',fim='$fim',id_estado='$id_estado',valor='$valor',oculto='$oculto',id_moeda='$id_moeda',morada='$morada',latitude='$latitude',longitude='$longitude',id_pais='$id_pais',descricao='$descricao',descricao_en='$descricao_en',descricao_fr='$descricao_fr',descricao_es='$descricao_es' WHERE id='$id_processo'");

		if($_FILES['imagem']['name'][0]){
			$contar = count($_FILES['imagem']['name']);
			for($i=0; $i<$contar; $i++){
				$arquivo_tmp = $_FILES['imagem']['tmp_name'][$i];
				$arquivo_name = $_FILES['imagem']['name'][$i];
				$extensao = strrchr($arquivo_name, '.');
				$extensao = strtolower($extensao);
				if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
					$novoNome = $id_processo."000";
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
					
					$capaExiste=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id_processo' AND capa='1'"));
					if($capaExiste){ $capa=0; }else{ $capa=1; }
					list($width, $height) = getimagesize($destino);
				    if($width>=$height){ $tipo='horizontal'; }else{ $tipo='vertical'; }
					mysqli_query($lnk,"INSERT INTO galeria(id_processo,img,capa,tipo) VALUES ('$id_processo','$nome_imagem','$capa','$tipo')");

					/*if(@move_uploaded_file($arquivo_tmp, $destino)){
						$capaExiste=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM projeto_gal WHERE id_projeto='$id_processo' AND capa='1'"));
						if($capaExiste){ $capa=0; }else{ $capa=1; }
						mysqli_query($lnk,"INSERT INTO projeto_gal(id_projeto,img,capa,online) VALUES ('$id_processo','$nome_imagem','$capa','1')");
					}*/
				}
			}
			$registo="Atualização da ficha de obra ".$referencia." - ".$processo."( #".$id_processo." ) com ".$contar." fotografias";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo','$id_etapa','$registo','$data','$hora')");
		}
		if($botao=='guardar'){$aviso='TF';}
		if($botao=='reprovar'){
			$id_etapa_rep = $_POST["id_etapa_rep"];

			for ($i = $id_etapa_rep; $i <= 5; $i++) {
				$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM registo WHERE id_processo='$id_processo' AND id_etapa='$i' ORDER BY id DESC"));
				$id_faz_ant = $linha3['id_user'];

				if($i==$id_etapa_rep){mysqli_query($lnk, "INSERT INTO tarefa(id_manda,id_faz,id_etapa,id_processo,data) VALUES ('$id_user','$id_faz_ant','$i','$id_processo','$data')");}
				else{mysqli_query($lnk, "INSERT INTO tarefa(id_manda,id_faz,id_etapa,id_processo) VALUES ('$id_user','$id_faz_ant','$i','$id_processo')");}
				$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_ant'"));
				$nome_ant = $linha4['nome'];
				$email_ant = $linha4['email'];
				$registo="Reprovação da $iª etapa realizada por ".$nome_ant."( #".$id_faz_ant." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_faz_ant','$id_processo','$i','$registo','$data','$hora')");
				if($i==$id_etapa_rep){
					$nome_ant_eta=$nome_ant;
					$email_ant_eta=$email_ant;
				}

			}
			mysqli_query($lnk,"UPDATE processo SET id_etapa='$id_etapa_rep' WHERE id='$id_processo'");
			mysqli_query($lnk,"UPDATE tarefa SET data='0000-00-00' WHERE id='$id'");
			$nota = $_POST["nota"];
			//if($nota){mysqli_query($lnk, "INSERT INTO chat(id_emissor,id_recetor,mensagem,data,hora) VALUES ('$id_user','$id_faz_ant','$nota','$data','$hora')");}

			$para = $nome_ant_eta." <".$email_ant_eta.">";
			$paraEmail = $email_ant_eta;
			$paraNome = $nome_ant_eta;
			$De = $nome_user." <".$email_user.">";
			$assunto = "Plataforma Online Sá Machado";
			$mensagem = '
			<html>
			<head>
			 <title>'.$assunto.'</title>
			 <style>*{font-size:14px;}</style>
			</head>
			<body>
			<p>Olá '.$nome_ant.', a sua tarefa foi <b>reprovada</b>.</p>
			<p><b>"'.$nota.'"</b></p><br>
			<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
			<p>Na plataforma tens informações sobre a tarefa a realizares bem como um chat para te ajudar, no caso de teres dúvidas.</p>
			<p>Todas as tuas interações são guardadas e apresentadas no histórico!</p>
			<p>Melhores Cumprimentos</p>
			<p>'.$nome_user.'</p>
			<br><hr>
			</body>
			</html>
			';
			include('../funcao/email.php');
			$aviso='TC';
		}
		if($botao=='enviar'){
			/*$completa=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM processo WHERE id='$id_processo' AND nome!='' AND nome_en!='' AND nome_fr!='' AND nome_es!='' AND dono!='' AND 
				dono_en!='' AND dono_fr!='' AND dono_es!='' AND area!='' AND prazo!='0' AND inicio!='0000-00-00' AND fim!='0000-00-00' AND (valor!='' OR oculto='1') AND descricao!='' AND 
				descricao_en!='' AND descricao_fr!='' AND descricao_es!='' AND morada!=''"));
			$verticais=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id_processo' AND tipo='vertical'"));
			$horizontais=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id_processo' AND tipo='horizontal'"));
			if(!$completa){$aviso = 'Todos os campos são de preenchimento obrigatório.';}
			if($str<200 && !$aviso){$aviso = 'Escreva uma descrição mais alongada da obra.';}
			if($verticais<2 && !$aviso){$aviso = 'Carregue mais fotos verticais.';}
			if($horizontais<4 && !$aviso){$aviso = 'Carregue mais fotos horizontais.';}*/
			if(!$aviso){
				$registo="Finalização da ficha de obra ".$referencia." - ".$processo." ( #".$id_processo." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo',6,'$registo','$data','$hora')");

				mysqli_query($lnk, "INSERT INTO ficha(processo,referencia,nome,nome_en,nome_fr,nome_es,escuro,dono,dono_en,dono_fr,dono_es,id_categoria,area,prazo,subpiso,piso,inicio,fim,id_estado,valor,oculto,id_moeda,morada,latitude,longitude,id_pais,descricao,descricao_en,descricao_fr,descricao_es) VALUES 
					('$id_processo','$referencia','$nome','$nome_en','$nome_fr','$nome_es','$escuro','$dono','$dono_en','$dono_fr','$dono_es','$id_categoria','$area','$prazo','$subpiso','$piso','$inicio','$fim','$id_estado','$valor','$oculto','$id_moeda','$morada','$latitude','$longitude','$id_pais','$descricao','$descricao_en','$descricao_fr','$descricao_es')");
				$id_novo = mysqli_insert_id($lnk);

				//IMAGENS
				$nomeZeros = $id_novo;
				if(strlen($nomeZeros)==3){$nomeZeros = "0".$nomeZeros;}
				if(strlen($nomeZeros)==2){$nomeZeros = "00".$nomeZeros;}
				if(strlen($nomeZeros)==1){$nomeZeros = "000".$nomeZeros;}
				//CAPA
				$linhaC = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id_processo' ORDER BY capa DESC"));
				$img = $linhaC['img'];
				$origem = '../..'.$img;
				$extensao = strrchr($img, '.');
				$novoNome = $nomeZeros."00".$extensao;
				$destino = '../../img/fichas/'.$novoNome;
				$nome_imagem = '/img/fichas/'.$novoNome;
				//$nome_imagem = '/admin/galeria/'.$novoNome;
				upload_small($origem, $destino, $extensao);
				mysqli_query($lnk,"UPDATE ficha SET capa='$nome_imagem' WHERE id='$id_novo'");
				//FRENTE
				$queryV = mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id_processo' AND tipo='vertical' ORDER BY ordem ASC");
				$linhaV = mysqli_fetch_array($queryV);
				$img = $linhaV['img'];
				$origem = '../..'.$img;
				$extensao = strrchr($img, '.');
				$novoNome = $nomeZeros."01".$extensao;
				$destino = '../../img/fichas/'.$novoNome;
				$nome_imagem = '/img/fichas/'.$novoNome;
				upload_full($origem, $destino, $extensao);
				mysqli_query($lnk,"UPDATE ficha SET frente='$nome_imagem' WHERE id='$id_novo'");
				//TRAS
				$linhaV = mysqli_fetch_array($queryV);
				$img = $linhaV['img'];
				$origem = '../..'.$img;
				$extensao = strrchr($img, '.');
				$novoNome = $nomeZeros."02".$extensao;
				$destino = '../../img/fichas/'.$novoNome;
				$nome_imagem = '/img/fichas/'.$novoNome;
				upload_full($origem, $destino, $extensao);
				mysqli_query($lnk,"UPDATE ficha SET tras='$nome_imagem' WHERE id='$id_novo'");
				//IMG1
				$queryH = mysqli_query($lnk,"SELECT * FROM galeria WHERE id_processo='$id_processo' AND tipo='horizontal' ORDER BY ordem ASC");
				$linhaH = mysqli_fetch_array($queryH);
				$img = $linhaH['img'];
				$origem = '../..'.$img;
				$extensao = strrchr($img, '.');
				$novoNome = $nomeZeros."03".$extensao;
				$destino = '../../img/fichas/'.$novoNome;
				$nome_imagem = '/img/fichas/'.$novoNome;
				upload_small($origem, $destino, $extensao);
				mysqli_query($lnk,"UPDATE ficha SET img1='$nome_imagem' WHERE id='$id_novo'");
				//IMG2
				$linhaH = mysqli_fetch_array($queryH);
				$img = $linhaH['img'];
				$origem = '../..'.$img;
				$extensao = strrchr($img, '.');
				$novoNome = $nomeZeros."04".$extensao;
				$destino = '../../img/fichas/'.$novoNome;
				$nome_imagem = '/img/fichas/'.$novoNome;
				upload_small($origem, $destino, $extensao);
				mysqli_query($lnk,"UPDATE ficha SET img2='$nome_imagem' WHERE id='$id_novo'");
				//IMG3
				$linhaH = mysqli_fetch_array($queryH);
				$img = $linhaH['img'];
				$origem = '../..'.$img;
				$extensao = strrchr($img, '.');
				$novoNome = $nomeZeros."05".$extensao;
				$destino = '../../img/fichas/'.$novoNome;
				$nome_imagem = '/img/fichas/'.$novoNome;
				upload_small($origem, $destino, $extensao);
				mysqli_query($lnk,"UPDATE ficha SET img3='$nome_imagem' WHERE id='$id_novo'");
				//IMG4
				$linhaH = mysqli_fetch_array($queryH);
				$img = $linhaH['img'];
				$origem = '../..'.$img;
				$extensao = strrchr($img, '.');
				$novoNome = $nomeZeros."06".$extensao;
				$destino = '../../img/fichas/'.$novoNome;
				$nome_imagem = '/img/fichas/'.$novoNome;
				upload_small($origem, $destino, $extensao);
				mysqli_query($lnk,"UPDATE ficha SET img4='$nome_imagem' WHERE id='$id_novo'");
				//FIM IMAGENS

				$registo="Lançamento da ficha de obra ".$referencia." - ".$processo." ( #".$id_novo." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_user','$id_user','$id_processo',6,'$registo','$data','$hora')");

				mysqli_query($lnk,"UPDATE processo SET id_etapa=0,ficha='$id_novo' WHERE id='$id_processo'");
				mysqli_query($lnk, "DELETE FROM tarefa WHERE id='$id'");

				mysqli_query($lnk,"UPDATE ficha SET online=1 WHERE id='$id_novo'");
				$aviso=$id_novo;
			}
		}
	}
	//FIM DE ETAPAS
}
echo $aviso;
?>