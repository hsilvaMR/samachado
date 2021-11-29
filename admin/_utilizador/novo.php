<?php
include('../../_connect.php');
include('../funcao/clear_variable.php');
session_start();
$id_user = $_SESSION['id_user'];
$linha_user = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_user'"));
$nome_user = $linha_user['nome'];
$email_user = $linha_user['email'];
$data=date('Y-m-d');
$hora=date('H:i');

$id = $_POST["id"];
$nome = text_variable($_POST["nome"]);
$email = text_variable($_POST["email"]);
$password = $_POST["password"];
$str = strlen($password);

$tipo = $_POST["tipo"];

$enviarEmail = '';

if($nome && $email && ($str>5)){
	if($id){
		$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user WHERE email='$email' AND id!='$id'"));
		if($numero){ $aviso='TF'; }
		else{
			$num=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user WHERE email='$email' AND id='$id'"));
			if(!$num){ $enviarEmail='SIM'; }

			$registo="Atualização do utilizador";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id','$registo','$data','$hora')");
			
			mysqli_query($lnk,"UPDATE user SET nome='$nome',email='$email',password='$password',tipo='$tipo' WHERE id='$id'");
			$aviso=$id;
		}
	}
	else{
		$numero=mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM user WHERE email='$email'"));
		if($numero){ $aviso='TF'; }
		else{
			mysqli_query($lnk, "INSERT INTO user(nome,email,password,tipo) VALUES ('$nome','$email','$password','$tipo')");
			$id_novo = mysqli_insert_id($lnk);

			$registo="Criação de novo utilizador ".$nome." ( #".$id_novo." )";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_user','$id_novo','$registo','$data','$hora')");

			$enviarEmail='SIM';
			$aviso=$id_novo;
		}
	}
	if($enviarEmail){
		if($tipo=='head'){$explicacao='
			<p><b>Na plataforma tem acesso a 7 separadores:</b>
			<br>Painel - No painel tem acesso rápido às novas tarefas e mensagens novas.
			<br>Fichas - Aqui pode iniciar um novo processo para a criação de uma nova ficha de obra, tem também acesso a todas as fichas que tenha criado.
			<br>Tarefas - Aqui tem acesso às suas tarefas bem como a todas as tarefas pendentes relativas às suas fichas de obra. 
				Caso tenha a necessidade de alterar o utilizador responsável por alguma tarefa, pode fazer isso carregando em editar na respectiva tarefa.
			<br>Utilizadores - Pode e deve criar aqui todos os utilizadores necessarios para o processo de criação de uma nova ficha de obra.
				Apenas os utilizadores aqui existentes aparecem para serem selecionados quando se inicia uma nova ficha de obra.
			<br>Chat - Pode falar com qualquer pessoa existente na plataforma, se selecionar um utlizador a mensagem será privada, caso contrário todos os utilizadores terão acesso à mensagem.
			<br>Histórico - Todas as interações dos utilizadores são guardadas no histórico.
			<br>Password - Aqui pode alterar a sua password.</p>';
		}
		else{$explicacao='
			<p><b>Na plataforma tem acesso a 5 separadores:</b>
			<br>Painel - No painel tem acesso rápido às novas tarefas e mensagens novas.
			<br>Tarefas - Aqui tem acesso às suas tarefas bem como a todas as tarefas pendentes relativas às suas fichas de obra. 
				Caso tenha a necessidade de alterar o utilizador responsável por alguma tarefa, pode fazer isso carregando em editar na respectiva tarefa.
			<br>Chat - Pode falar com qualquer pessoa existente na plataforma, se selecionar um utlizador a mensagem será privada, caso contrário todos os utilizadores terão acesso à mensagem.
			<br>Histórico - Todas as interações dos utilizadores são guardadas no histórico.
			<br>Password - Aqui pode alterar a sua password.</p>';
		}

		$para = $nome." <".$email.">";
		$paraEmail = $email;
		$paraNome = $nome;
		$De = $nome_user." <".$email_user.">";
		//$De = "Admin <tmendes@mredis.com>";
		$assunto = "Plataforma Online Sá Machado";
		$mensagem = '
		<html>
		<head>
		 <title>'.$assunto.'</title>
		 <style>*{font-size:14px;}</style>
		</head>
		<body>
		<p>Olá '.$nome.', bem-vindo à plataforma online da Sá Machado para o processo de criação de fichas de obra.
		<br>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
		<table height="60">
			<tr>
				<th colspan="2" align="left">Dados de Login</th>
			</tr>
			<tr>
				<td>Email: </td><td>'.$email.'</td>
			</tr>
			<tr>
				<td>Password: </td><td>'.$password.'</td>
			</tr>
		</table>
		'.$explicacao.'
		<p>Para uma explicação mais detalhada tem aqui o <a href="http://www.samachado.com/admin/_tutorial/Tutorial.pdf">tutorial</a>.</p>
		<p>Melhores Cumprimentos
		<br>'.$nome_user.'</p>
		<br><hr>
		
		</body>
		</html>
		';
		include('../funcao/email.php');
	}
}else{ $aviso='TC';}
echo $aviso;
?>