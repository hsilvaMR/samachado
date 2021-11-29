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
$botao = $_POST["botao"];
$linha = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id='$id'"));
$id_emissor = $linha['id_emissor'];
$id_recetor = $linha['id_recetor'];
$id_fase = $linha['id_fase'];
$id_noticia = $linha['id_noticia'];

$linha2 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM noticia WHERE id='$id_noticia'"));
$nome = $linha2['nome'];

$aviso = '';
if($id){
	//ETAPA 1
	if($id_fase=='1'){
		$id_tipo = $_POST["id_tipo"];
		$titulo = text_variable($_POST["titulo"]);
		$noticia = text_variable($_POST["noticia"]);
		$criacao = $_POST["criacao"];
		$publicacao = $_POST["publicacao"];
		//$str = strlen($descricao);

		$registo="Atualização da notícia ".$nome." ( #".$id_noticia." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id_noticia','$id_fase','$registo','$data','$hora')");
		mysqli_query($lnk,"UPDATE noticia SET id_tipo='$id_tipo',nome='$titulo',texto='$noticia',criacao='$criacao',publicacao='$publicacao' WHERE id='$id_noticia'");

		if($_FILES['imagem']['name'][0]){
			$contar = count($_FILES['imagem']['name']);
			for($i=0; $i<$contar; $i++){
				$arquivo_tmp = $_FILES['imagem']['tmp_name'][$i];
				$arquivo_name = $_FILES['imagem']['name'][$i];
				$extensao = strrchr($arquivo_name, '.');
				$extensao = strtolower($extensao);
				if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
					$novoNome = $id_noticia."000";
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
					
					mysqli_query($lnk,"INSERT INTO imagem(id_noticia,img) VALUES ('$id_noticia','$nome_imagem')");

					/*if(@move_uploaded_file($arquivo_tmp, $destino)){
						$capaExiste=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM projeto_gal WHERE id_projeto='$id_noticia' AND capa='1'"));
						if($capaExiste){ $capa=0; }else{ $capa=1; }
						mysqli_query($lnk,"INSERT INTO projeto_gal(id_projeto,img,capa,online) VALUES ('$id_noticia','$nome_imagem','$capa','1')");
					}*/
				}
			}
			$registo="Atualização da notícia ".$nome." ( #".$id_noticia." ) com ".$contar." imagens";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id_noticia','$id_fase','$registo','$data','$hora')");
		}
		if($botao=='guardar'){$aviso='TF';}
		if($botao=='enviar'){
			/*$completa=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id='$id_noticia' AND nome!='' AND texto!='' AND criacao!='0000-00-00' AND publicacao!='0000-00-00'"));
			$imagens=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM imagem WHERE id_noticia='$id_noticia'"));
			if(!$completa){$aviso = 'Todos os campos são de preenchimento obrigatório.';}
			//if($str<400 && !$aviso){$aviso = 'Escreva uma descrição mais alongada da obra.';}
			if(!$imagens && !$aviso){$aviso = 'Carregue no mínimo uma imagem.';}*/
			if(!$aviso){
				$registo="Fase 1 concluída da notícia ".$nome." ( #".$id_noticia." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id_noticia','$id_fase','$registo','$data','$hora')");
				
				$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id_noticia='$id_noticia' AND id_fase=2"));
				$id_tarefa_pro = $linha3['id'];
				$id_faz_pro = $linha3['id_recetor'];

				$registo="Início da fase 2 da notícia ".$nome." ( #".$id_noticia." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_faz_pro','$id_noticia',2,'$registo','$data','$hora')");
		
				$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_pro'"));
				$nome_util = $linha4['nome'];
				$email_util = $linha4['email'];

				mysqli_query($lnk,"UPDATE noticia SET id_fase=2 WHERE id='$id_noticia'");
				mysqli_query($lnk,"UPDATE trabalho SET data='$data' WHERE id='$id_tarefa_pro'");
				mysqli_query($lnk, "DELETE FROM trabalho WHERE id='$id'");
				
				$para = $nome_util." <".$email_util.">";
				$paraNome = $nome_util;
				$paraEmail = $email_util;
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
	if($id_fase=='2'){
		$id_tipo = $_POST["id_tipo"];
		$titulo = text_variable($_POST["titulo"]);
		$noticia = text_variable($_POST["noticia"]);
		$criacao = $_POST["criacao"];
		$publicacao = $_POST["publicacao"];

		$registo="Atualização da noticia ".$nome." ( #".$id_noticia." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id_noticia','$id_fase','$registo','$data','$hora')");
		mysqli_query($lnk,"UPDATE noticia SET id_tipo='$id_tipo',nome='$titulo',texto='$noticia',criacao='$criacao',publicacao='$publicacao' WHERE id='$id_noticia'");

		if($_FILES['imagem']['name'][0]){
			$contar = count($_FILES['imagem']['name']);
			for($i=0; $i<$contar; $i++){
				$arquivo_tmp = $_FILES['imagem']['tmp_name'][$i];
				$arquivo_name = $_FILES['imagem']['name'][$i];
				$extensao = strrchr($arquivo_name, '.');
				$extensao = strtolower($extensao);
				if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
					$novoNome = $id_noticia."000";
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
					mysqli_query($lnk,"INSERT INTO imagem(id_noticia,img) VALUES ('$id_noticia','$nome_imagem')");
				}
			}
			$registo="Atualização da notícia ".$nome." ( #".$id_noticia." ) com ".$contar." imagens";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id_noticia','$id_fase','$registo','$data','$hora')");
		}
		if($botao=='guardar'){$aviso='TF';}
		if($botao=='reprovar'){
			$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM registo WHERE id_noticia='$id_noticia' AND id_fase=1 ORDER BY id DESC"));
			$id_faz_ant = $linha3['id_user'];

			mysqli_query($lnk, "INSERT INTO trabalho(id_emissor,id_recetor,id_noticia,id_fase,data) VALUES ('$id_user','$id_faz_ant','$id_noticia',1,'$data')");
			$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_ant'"));
			$nome_ant = $linha4['nome'];
			$email_ant = $linha4['email'];
			$registo="Reprovação da 1ª etapa realizada por ".$nome_ant." ( #".$id_faz_ant." )";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_faz_ant','$id_noticia',1,'$registo','$data','$hora')");
			
			mysqli_query($lnk,"UPDATE noticia SET id_fase=1 WHERE id='$id_noticia'");
			mysqli_query($lnk,"UPDATE trabalho SET data='0000-00-00' WHERE id='$id'");
			
			$nota = $_POST["nota"];
			//if($nota){mysqli_query($lnk, "INSERT INTO chat(id_emissor,id_recetor,mensagem,data,hora) VALUES ('$id_user','$id_faz_ant','$nota','$data','$hora')");}

			$para = $nome_ant." <".$email_ant.">";
			$paraNome = $nome_ant;
			$paraEmail = $email_ant;
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
			/*$completa=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id='$id_noticia' AND nome!='' AND texto!='' AND criacao!='0000-00-00' AND publicacao!='0000-00-00'"));
			$imagens=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM imagem WHERE id_noticia='$id_noticia'"));
			if(!$completa){$aviso = 'Todos os campos são de preenchimento obrigatório.';}
			//if($str<400 && !$aviso){$aviso = 'Escreva uma descrição mais alongada da obra.';}
			if(!$imagens && !$aviso){$aviso = 'Carregue no mínimo uma imagem.';}*/
			if(!$aviso){
				$registo="Fase 2 concluída da notícia ".$nome." ( #".$id_noticia." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id_noticia','$id_fase','$registo','$data','$hora')");
				
				$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id_noticia='$id_noticia' AND id_fase=3 ORDER BY id DESC"));
				$id_tarefa_pro = $linha3['id'];
				$id_faz_pro = $linha3['id_recetor'];

				$registo="Início da fase 3 da notícia ".$nome." ( #".$id_noticia." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_faz_pro','$id_noticia',3,'$registo','$data','$hora')");
		
				$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_pro'"));
				$nome_util = $linha4['nome'];
				$email_util = $linha4['email'];

				mysqli_query($lnk,"UPDATE noticia SET id_fase=3 WHERE id='$id_noticia'");
				mysqli_query($lnk,"UPDATE trabalho SET data='$data' WHERE id='$id_tarefa_pro'");
				mysqli_query($lnk, "DELETE FROM trabalho WHERE id='$id'");
				
				$para = $nome_util." <".$email_util.">";
				$paraNome = $nome_util;
				$paraEmail = $email_util;
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
	if($id_fase=='3'){
		$titulo = text_variable($_POST["titulo"]);
		$noticia = text_variable($_POST["noticia"]);

		$registo="Atualização da notícia ".$nome." ( #".$id_noticia." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id_noticia','$id_fase','$registo','$data','$hora')");
		mysqli_query($lnk,"UPDATE noticia SET nome='$titulo',texto='$noticia' WHERE id='$id_noticia'");

		if($botao=='guardar'){$aviso='TF';}
		if($botao=='reprovar'){
			$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM registo WHERE id_noticia='$id_noticia' AND id_fase=2 ORDER BY id DESC"));
			$id_faz_ant = $linha3['id_user'];

			mysqli_query($lnk, "INSERT INTO trabalho(id_emissor,id_recetor,id_noticia,id_fase,data) VALUES ('$id_user','$id_faz_ant','$id_noticia',2,'$data')");
			$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_ant'"));
			$nome_ant = $linha4['nome'];
			$email_ant = $linha4['email'];
			$registo="Reprovação da 2ª fase realizada por ".$nome_ant." ( #".$id_faz_ant." )";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_faz_ant','$id_noticia',2,'$registo','$data','$hora')");
			
			mysqli_query($lnk,"UPDATE noticia SET id_fase=2 WHERE id='$id_noticia'");
			mysqli_query($lnk,"UPDATE trabalho SET data='0000-00-00' WHERE id='$id'");
			
			$nota = $_POST["nota"];
			//if($nota){mysqli_query($lnk, "INSERT INTO chat(id_emissor,id_recetor,mensagem,data,hora) VALUES ('$id_user','$id_faz_ant','$nota','$data','$hora')");}

			$para = $nome_ant." <".$email_ant.">";
			$paraNome = $nome_ant;
			$paraEmail = $email_ant;
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
			/*$completa=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id='$id_noticia' AND nome!='' AND texto!=''"));
			if(!$completa){$aviso = 'Todos os campos são de preenchimento obrigatório.';}*/
			if(!$aviso){
				$registo="Fase 3 concluída da notícia ".$nome." ( #".$id_noticia." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id_noticia','$id_fase','$registo','$data','$hora')");
				
				$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id_noticia='$id_noticia' AND id_fase=4 ORDER BY id DESC"));
				$id_tarefa_pro = $linha3['id'];
				$id_faz_pro = $linha3['id_recetor'];

				$registo="Início da fase 4 da notícia ".$nome." ( #".$id_noticia." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_faz_pro','$id_noticia',4,'$registo','$data','$hora')");
		
				$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_pro'"));
				$nome_util = $linha4['nome'];
				$email_util = $linha4['email'];

				mysqli_query($lnk,"UPDATE noticia SET id_fase=4 WHERE id='$id_noticia'");
				mysqli_query($lnk,"UPDATE trabalho SET data='$data' WHERE id='$id_tarefa_pro'");
				mysqli_query($lnk, "DELETE FROM trabalho WHERE id='$id'");
				
				$para = $nome_util." <".$email_util.">";
				$paraNome = $nome_util;
				$paraEmail = $email_util;
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
	if($id_fase=='4'){
		$titulo_en = text_variable($_POST["titulo_en"]);
		$noticia_en = text_variable($_POST["noticia_en"]);
		$titulo_fr = text_variable($_POST["titulo_fr"]);
		$noticia_fr = text_variable($_POST["noticia_fr"]);
		$titulo_es = text_variable($_POST["titulo_es"]);
		$noticia_es = text_variable($_POST["noticia_es"]);

		$registo="Atualização das traduções da notícia ".$nome." ( #".$id_noticia." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id_noticia','$id_fase','$registo','$data','$hora')");
		mysqli_query($lnk,"UPDATE noticia SET nome_en='$titulo_en',nome_fr='$titulo_fr',nome_es='$titulo_es',texto_en='$noticia_en',texto_fr='$noticia_fr',texto_es='$noticia_es' WHERE id='$id_noticia'");

		if($botao=='guardar'){$aviso='TF';}
		if($botao=='enviar'){
			//$completa=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id='$id_noticia' AND nome_en!='' AND nome_fr!='' AND nome_es!='0' AND texto_en!='' AND texto_fr!='' AND texto_es!=''"));
			//if(!$completa){$aviso = 'Preencha todos os campos. Faltam traduções.';}
			if(!$aviso){
				$registo="Fase 4 concluída da notícia ".$nome." ( #".$id_noticia." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id_noticia','$id_fase','$registo','$data','$hora')");
				
				$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id_noticia='$id_noticia' AND id_fase=5 ORDER BY id DESC"));
				$id_tarefa_pro = $linha3['id'];
				$id_faz_pro = $linha3['id_recetor'];

				$registo="Início da fase 5 da notícia ".$nome." ( #".$id_noticia." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_faz_pro','$id_noticia',5,'$registo','$data','$hora')");
		
				$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_pro'"));
				$nome_util = $linha4['nome'];
				$email_util = $linha4['email'];

				mysqli_query($lnk,"UPDATE noticia SET id_fase=5 WHERE id='$id_noticia'");
				mysqli_query($lnk,"UPDATE trabalho SET data='$data' WHERE id='$id_tarefa_pro'");
				mysqli_query($lnk, "DELETE FROM trabalho WHERE id='$id'");
				
				$para = $nome_util." <".$email_util.">";
				$paraNome = $nome_util;
				$paraEmail = $email_util;
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
	if($id_fase=='5'){
		$titulo_en = text_variable($_POST["titulo_en"]);
		$noticia_en = text_variable($_POST["noticia_en"]);
		$titulo_fr = text_variable($_POST["titulo_fr"]);
		$noticia_fr = text_variable($_POST["noticia_fr"]);
		$titulo_es = text_variable($_POST["titulo_es"]);
		$noticia_es = text_variable($_POST["noticia_es"]);

		$registo="Atualização das traduções da notícia ".$nome." ( #".$id_noticia." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id_noticia','$id_fase','$registo','$data','$hora')");
		mysqli_query($lnk,"UPDATE noticia SET nome_en='$titulo_en',nome_fr='$titulo_fr',nome_es='$titulo_es',texto_en='$noticia_en',texto_fr='$noticia_fr',texto_es='$noticia_es' WHERE id='$id_noticia'");

		if($botao=='guardar'){$aviso='TF';}
		if($botao=='reprovar'){
			$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM registo WHERE id_noticia='$id_noticia' AND id_fase=4 ORDER BY id DESC"));
			$id_faz_ant = $linha3['id_user'];

			mysqli_query($lnk, "INSERT INTO trabalho(id_emissor,id_recetor,id_noticia,id_fase,data) VALUES ('$id_user','$id_faz_ant','$id_noticia',4,'$data')");
			$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_ant'"));
			$nome_ant = $linha4['nome'];
			$email_ant = $linha4['email'];
			$registo="Reprovação da 4ª fase realizada por ".$nome_ant."( #".$id_faz_ant." )";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_faz_ant','$id_noticia',4,'$registo','$data','$hora')");
			
			mysqli_query($lnk,"UPDATE noticia SET id_fase=4 WHERE id='$id_noticia'");
			mysqli_query($lnk,"UPDATE trabalho SET data='0000-00-00' WHERE id='$id'");
			
			$nota = $_POST["nota"];
			//if($nota){mysqli_query($lnk, "INSERT INTO chat(id_emissor,id_recetor,mensagem,data,hora) VALUES ('$id_user','$id_faz_ant','$nota','$data','$hora')");}

			$para = $nome_ant." <".$email_ant.">";
			$paraNome = $nome_ant;
			$paraEmail = $email_ant;
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
			/*$completa=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id='$id_noticia' AND nome_en!='' AND nome_fr!='' AND nome_es!='' AND texto_en!='' AND texto_fr!='' AND texto_es!=''"));
			if(!$completa){$aviso = 'Todos os campos são de preenchimento obrigatório.';}*/
			if(!$aviso){
				$registo="Fase 5 concluída da notícia ".$nome." ( #".$id_noticia." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id_noticia',5,'$registo','$data','$hora')");
				
				$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id_noticia='$id_noticia' AND id_fase=6 ORDER BY id DESC"));
				$id_tarefa_pro = $linha3['id'];
				$id_faz_pro = $linha3['id_recetor'];

				$registo="Início da fase 6 da notícia ".$nome." ( #".$id_noticia." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_faz_pro','$id_noticia',6,'$registo','$data','$hora')");
		
				$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_pro'"));
				$nome_util = $linha4['nome'];
				$email_util = $linha4['email'];

				mysqli_query($lnk,"UPDATE noticia SET id_fase=6 WHERE id='$id_noticia'");
				mysqli_query($lnk,"UPDATE trabalho SET data='$data' WHERE id='$id_tarefa_pro'");
				mysqli_query($lnk, "DELETE FROM trabalho WHERE id='$id'");
				
				$para = $nome_util." <".$email_util.">";
				$paraNome = $nome_util;
				$paraEmail = $email_util;
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
	if($id_fase=='6'){
		$id_tipo = $_POST["id_tipo"];
		$titulo = text_variable($_POST["titulo"]);
		$noticia = text_variable($_POST["noticia"]);
		$criacao = $_POST["criacao"];
		$publicacao = $_POST["publicacao"];
		$titulo_en = text_variable($_POST["titulo_en"]);
		$noticia_en = text_variable($_POST["noticia_en"]);
		$titulo_fr = text_variable($_POST["titulo_fr"]);
		$noticia_fr = text_variable($_POST["noticia_fr"]);
		$titulo_es = text_variable($_POST["titulo_es"]);
		$noticia_es = text_variable($_POST["noticia_es"]);

		$registo="Atualização da notícia ".$nome." ( #".$id_noticia." )";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id_noticia','$id_fase','$registo','$data','$hora')");
		mysqli_query($lnk,"UPDATE noticia SET nome='$titulo',nome_en='$titulo_en',nome_fr='$titulo_fr',nome_es='$titulo_es',texto='$noticia',texto_en='$noticia_en',texto_fr='$noticia_fr',texto_es='$noticia_es',id_tipo='$id_tipo',criacao='$criacao',publicacao='$publicacao' WHERE id='$id_noticia'");

		if($_FILES['imagem']['name'][0]){
			$contar = count($_FILES['imagem']['name']);
			for($i=0; $i<$contar; $i++){
				$arquivo_tmp = $_FILES['imagem']['tmp_name'][$i];
				$arquivo_name = $_FILES['imagem']['name'][$i];
				$extensao = strrchr($arquivo_name, '.');
				$extensao = strtolower($extensao);
				if(strstr('.jpg;.jpeg;.png;.gif', $extensao)){
					$novoNome = $id_noticia."000";
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
					mysqli_query($lnk,"INSERT INTO imagem(id_noticia,img) VALUES ('$id_noticia','$nome_imagem')");
				}
			}
			$registo="Atualização da notícia ".$nome."( #".$id_noticia." ) com ".$contar." imagens";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id_noticia','$id_fase','$registo','$data','$hora')");
		}
		if($botao=='guardar'){$aviso='TF';}
		if($botao=='reprovar'){
			$id_etapa_rep = $_POST["id_etapa_rep"];

			for ($i = $id_etapa_rep; $i <= 5; $i++) {
				$linha3 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM registo WHERE id_noticia='$id_noticia' AND id_fase='$i' ORDER BY id DESC"));
				$id_faz_ant = $linha3['id_user'];

				if($i==$id_etapa_rep){mysqli_query($lnk, "INSERT INTO trabalho(id_emissor,id_recetor,id_noticia,id_fase,data) VALUES ('$id_user','$id_faz_ant','$id_noticia','$i','$data')");}
				else{mysqli_query($lnk, "INSERT INTO trabalho(id_emissor,id_recetor,id_noticia,id_fase) VALUES ('$id_user','$id_faz_ant','$id_noticia','$i')");}
				$linha4 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_faz_ant'"));
				$nome_ant = $linha4['nome'];
				$email_ant = $linha4['email'];
				$registo="Reprovação da $iª fase realizada por ".$nome_ant." ( #".$id_faz_ant." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_faz_ant','$id_noticia','$i','$registo','$data','$hora')");
				if($i==$id_etapa_rep){
					$nome_ant_eta=$nome_ant;
					$email_ant_eta=$email_ant;
				}

			}
			mysqli_query($lnk,"UPDATE noticia SET id_fase='$id_etapa_rep' WHERE id='$id_noticia'");
			mysqli_query($lnk,"UPDATE trabalho SET data='0000-00-00' WHERE id='$id'");
			$nota = $_POST["nota"];
			//if($nota){mysqli_query($lnk, "INSERT INTO chat(id_emissor,id_recetor,mensagem,data,hora) VALUES ('$id_user','$id_faz_ant','$nota','$data','$hora')");}

			$para = $nome_ant_eta." <".$email_ant_eta.">";
			$paraNome = $nome_ant_eta;
			$paraEmail = $email_ant_eta;
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
			/*$completa=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM noticia WHERE id='$id_noticia' AND nome_en!='' AND nome_fr!='' AND nome_es!='' AND texto_en!='' AND texto_fr!='' AND texto_es!='' AND nome!='' AND texto!='' AND criacao!='0000-00-00' AND publicacao!='0000-00-00'"));
			$imagens=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM imagem WHERE id_noticia='$id_noticia'"));
			if(!$completa){$aviso = 'Todos os campos são de preenchimento obrigatório.';}
			//if($str<400 && !$aviso){$aviso = 'Escreva uma descrição mais alongada da obra.';}
			if(!$imagens && !$aviso){$aviso = 'Carregue no mínimo uma imagem.';}*/
			if(!$aviso){
				$registo="Lançamento da notícia ".$nome." ( #".$id_noticia." )";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_user','$id_noticia','$id_fase','$registo','$data','$hora')");

				mysqli_query($lnk,"UPDATE noticia SET id_fase=0,online=1 WHERE id='$id_noticia'");
				mysqli_query($lnk, "DELETE FROM trabalho WHERE id_noticia='$id_noticia'");
				$aviso=$id_noticia;
			}
		}
	}
	//FIM DE ETAPAS
}
echo $aviso;
?>