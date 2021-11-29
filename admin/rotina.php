<?php
include('../_connect.php');
session_start();
$nome_admin = 'António Machado';
$email_admin = 'afmachado@mredis.com';
$hoje=date('Y-m-d');
$hora=date('H:i');

$query = mysqli_query($lnk,"SELECT * FROM tarefa WHERE data!='0000-00-00'");
while($linha = mysqli_fetch_array($query)){
	$id_tarefa = $linha["id"];
	$id_manda = $linha["id_manda"];
	$id_faz = $linha["id_faz"];
	$id_processo = $linha["id_processo"];
	$id_etapa = $linha["id_etapa"];
	$data = $linha["data"];

	$linha_manda = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id_manda'"));
	$nome_manda = $linha_manda['nome'];
	$email_manda = $linha_manda['email'];

	$linha_faz = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id_faz'"));
	$nome_faz = $linha_faz['nome'];
	$email_faz = $linha_faz['email'];

	$linha_processo = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM processo WHERE id='$id_processo'"));
	$referencia = $linha_processo['referencia'];
	$processo = $linha_processo['processo'];

	$linha_etapa = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM etapa WHERE id='$id_etapa'"));
	$etapa = $linha_etapa['descricao'];
	$dias = $linha_etapa['dias'];

	$prazo1 = $dias;
	$aviso1 = date('Y-m-d', strtotime("+".$prazo1." days",strtotime($data)));
	$prazo2 = $dias+$prazo1;
	$aviso2 = date('Y-m-d', strtotime("+".$prazo2." days",strtotime($data)));
	$prazo3 = $dias+$prazo2;
	$aviso3 = date('Y-m-d', strtotime("+".$prazo3." days",strtotime($data)));
	//$data21 = date('Y-m-d', strtotime("+21 days",strtotime($data)));
	if($hoje==$aviso1 || $hoje==$aviso2 || $hoje==$aviso3){
		if($hoje==$aviso1){$prazo=$prazo1;}
		if($hoje==$aviso2){$prazo=$prazo2;}
		if($hoje==$aviso3){$prazo=$prazo3;}

		$paraEmail = $email_faz;
		$paraNome = $nome_faz;
		$para = $nome_faz." <".$email_faz.">";
		$De = $nome_manda." <".$email_manda.">";

		if($hoje==$aviso3){ $Cc=$nome_admin." <".$email_admin.">"; $respPara=$nome_admin." <".$email_admin.">"; }

		$assunto = "Plataforma Online Sá Machado";
		$mensagem = '
			<html>
			<head>
			<title>'.$assunto.'</title>
			<style>*{font-size:14px;}</style>
			</head>
			<body>
			<p>Olá '.$nome_faz.', está <b>atrasado '.$prazo.' dias na realização da sua tarefa</b>.</p>
			<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
			<p>Na plataforma tens informações sobre as tarefa a realizares bem como um chat para te ajudar, no caso de teres dúvidas, e registo de todas as tuas interações.</p>
			<p>Cada vez que tiveres uma nova tarefa, receberás um email com essa informação!</p>
			<p>Melhores Cumprimentos</p>
			<p>'.$nome_manda.'</p>
			<br><hr>
			</body>
			</html>
		';
		include('funcao/email.php');
		$registo="Email enviado a ".$nome_faz." ( ".$email_faz." ) avisando que já passaram ".$prazo." dias";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES ('$id_manda','$id_faz','$id_processo','$id_etapa','$registo','$hoje','$hora')");
	}
}

$query2 = mysqli_query($lnk,"SELECT * FROM processo");
while($linha2 = mysqli_fetch_array($query2)){
	$id_processo = $linha2["id"];
	$id_etapa = $linha2["id_etapa"];
	$id_ficha = $linha2["ficha"];
	
	if($id_etapa && $id_ficha){mysqli_query($lnk,"UPDATE processo SET id_etapa='0' WHERE id='$id_processo'");}
	if(!$id_etapa && !$id_ficha){mysqli_query($lnk,"UPDATE processo SET id_etapa='1' WHERE id='$id_processo'");$id_etapa=1;}
	
	if(!$id_ficha){
		if(!mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM tarefa WHERE id_etapa='$id_etapa' AND id_processo='$id_processo'"))){
			if($id_etapa==3 || $id_etapa==6){
				$registo="Atribuição da etapa a António Machado";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES (1,2,'$id_processo','$id_etapa','$registo','$hoje','$hora')");
				mysqli_query($lnk, "INSERT INTO tarefa(id_manda,id_faz,id_etapa,id_processo,data) VALUES (1,2,'$id_etapa','$id_processo','$hoje')");
			}else{
				$linha_responsavel = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM processo WHERE id='$id_processo'"));
				$id_responsavel = $linha_responsavel['id_responsavel'];
				$registo="Atribuição da etapa ao responsável";
				mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_processo,id_etapa,registo,data,hora) VALUES (1,'$id_responsavel','$id_processo','$id_etapa','$registo','$hoje','$hora')");
				mysqli_query($lnk, "INSERT INTO tarefa(id_manda,id_faz,id_etapa,id_processo,data) VALUES (1,'$id_responsavel','$id_etapa','$id_processo','$hoje')");	
			}
		}
	}
}

$query6 = mysqli_query($lnk,"SELECT * FROM user WHERE bloqueado='0'");
while($linha6 = mysqli_fetch_array($query6)){
	$id_util = $linha6["id"];
	$nome_util = $linha6['nome'];
	$email_util = $linha6['email'];

	$query7=mysqli_query($lnk,"SELECT * FROM chat WHERE lido NOT LIKE '%[$id_util]%' AND id_recetor IN('$id_util','0') ORDER BY id DESC");
	$numero=mysqli_num_rows($query7);
	if($numero){
		$linha7 = mysqli_fetch_array($query7);
		$id_emissor_chat = $linha7["id_emissor"];
		$data_chat = $linha7["data"];

		$avisoP = date('Y-m-d', strtotime("+1 days",strtotime($data_chat)));
		$avisoS = date('Y-m-d', strtotime("+3 days",strtotime($data_chat)));
		$avisoT = date('Y-m-d', strtotime("+7 days",strtotime($data_chat)));
		$avisoQ = date('Y-m-d', strtotime("+15 days",strtotime($data_chat)));
		if($hoje==$avisoP || $hoje==$avisoS || $hoje==$avisoT || $hoje==$avisoQ){
			$linha_emite = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id_emissor_chat'"));
			$nome_emite = $linha_emite['nome'];
			$email_emite = $linha_emite['email'];

			$paraNome = $nome_util;
			$paraEmail = $email_util;
			$para = $nome_util." <".$email_util.">";
			$De = $nome_emite." <".$email_emite.">";

			if($numero==1){$novas="1 nova mensagem";}else{$novas="$numero novas mensagens";}

			$assunto = "Plataforma Online Sá Machado";
			$mensagem = '
				<html>
				<head>
				<title>'.$assunto.'</title>
				<style>*{font-size:14px;}</style>
				</head>
				<body>
				<p>Olá '.$nome_util.', tem '.$novas.'.</p>
				<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
				<p>Na plataforma tens informações sobre as tarefa a realizares bem como um chat para te ajudar, no caso de teres dúvidas, e registo de todas as tuas interações.</p>
				<p>Cada vez que tiveres uma nova tarefa, receberás um email com essa informação!</p>
				<p>Melhores Cumprimentos</p>
				<p>'.$nome_emite.'</p>
				<br><hr>
				</body>
				</html>
			';
			include('funcao/email.php');
			$registo="Email enviado a ".$nome_util." ( ".$email_util." ) avisando que tem ".$novas;
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,registo,data,hora) VALUES ('$id_emissor_chat','$id_util','$registo','$hoje','$hora')");
		}
	}
}

$query4 = mysqli_query($lnk,"SELECT * FROM trabalho WHERE data!='0000-00-00'");
while($linha4 = mysqli_fetch_array($query4)){
	$id_tarefa = $linha4["id"];
	$id_emissor = $linha4["id_emissor"];
	$id_recetor = $linha4["id_recetor"];
	$id_noticia = $linha4["id_noticia"];
	$id_fase = $linha4["id_fase"];
	$data = $linha4["data"];

	$linha_manda = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id_emissor'"));
	$nome_manda = $linha_manda['nome'];
	$email_manda = $linha_manda['email'];

	$linha_faz = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id='$id_recetor'"));
	$nome_faz = $linha_faz['nome'];
	$email_faz = $linha_faz['email'];

	$linha_processo = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM noticia WHERE id='$id_noticia'"));
	$processo = $linha_processo['nome'];

	$linha_etapa = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM fase WHERE id='$id_fase'"));
	$dias = $linha_etapa['dias'];

	$prazo1 = $dias;
	$aviso1 = date('Y-m-d', strtotime("+".$prazo1." days",strtotime($data)));
	$prazo2 = $dias+$prazo1;
	$aviso2 = date('Y-m-d', strtotime("+".$prazo2." days",strtotime($data)));
	$prazo3 = $dias+$prazo2;
	$aviso3 = date('Y-m-d', strtotime("+".$prazo3." days",strtotime($data)));
	//$data21 = date('Y-m-d', strtotime("+21 days",strtotime($data)));
	if($hoje==$aviso1 || $hoje==$aviso2 || $hoje==$aviso3){
		if($hoje==$aviso1){$prazo=$prazo1;}
		if($hoje==$aviso2){$prazo=$prazo2;}
		if($hoje==$aviso3){$prazo=$prazo3;}

		$paraEmail = $email_faz;
		$paraNome = $nome_faz;
		$para = $nome_faz." <".$email_faz.">";
		$De = $nome_manda." <".$email_manda.">";

		if($hoje==$aviso3){ $Cc=$nome_admin." <".$email_admin.">"; $respPara=$nome_admin." <".$email_admin.">"; }

		$assunto = "Plataforma Online Sá Machado";
		$mensagem = '
			<html>
			<head>
			<title>'.$assunto.'</title>
			<style>*{font-size:14px;}</style>
			</head>
			<body>
			<p>Olá '.$nome_faz.', está <b>atrasado '.$prazo.' dias na realização da sua tarefa</b>.</p>
			<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
			<p>Na plataforma tens informações sobre as tarefa a realizares bem como um chat para te ajudar, no caso de teres dúvidas, e registo de todas as tuas interações.</p>
			<p>Cada vez que tiveres uma nova tarefa, receberás um email com essa informação!</p>
			<p>Melhores Cumprimentos</p>
			<p>'.$nome_manda.'</p>
			<br><hr>
			</body>
			</html>
		';
		include('funcao/email.php');
		$registo="Email enviado a ".$nome_faz." ( ".$email_faz." ) avisando que já passaram ".$prazo." dias";
		mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_emissor','$id_recetor','$id_noticia','$id_fase','$registo','$hoje','$hora')");
	}
}

$query5 = mysqli_query($lnk,"SELECT * FROM noticia WHERE id_fase!=0");
while($linha5 = mysqli_fetch_array($query5)){
	$id_noticia = $linha5["id"];
	$id_fase = $linha5["id_fase"];
	$id_responsavel = $linha5["id_user"];
	
	$num6 = mysqli_num_rows(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id_fase='$id_fase' AND id_noticia='$id_noticia'"));
	if($num6){
		$linha6 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM trabalho WHERE id_fase='$id_fase' AND id_noticia='$id_noticia'"));
		$id_trabalho = $linha6["id"];
		$data = $linha6["data"];
		if($data=='0000-00-00'){ mysqli_query($lnk,"UPDATE trabalho SET data='$hoje' WHERE id='$id_trabalho'"); }
	}else{
		for ($i = $id_fase; $i <= 6; $i++) {
			$linha7 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM registo WHERE id_noticia='$id_noticia' AND id_fase='$i' ORDER BY id DESC"));
			$id_emissor_ant = $linha7['id_admin'];
			$id_recetor_ant = $linha7['id_user'];

			$linha8 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_emissor_ant'"));
			$nome_emi = $linha8['nome'];
			$email_emi = $linha8['email'];

			$linha9 = mysqli_fetch_array(mysqli_query($lnk,"SELECT * FROM user WHERE id = '$id_recetor_ant'"));
			$nome_rec = $linha9['nome'];
			$email_rec = $linha9['email'];
			$registo="Atribuição da fase ao utilizador ".$nome_rec." ( #".$id_recetor_ant." )";
			mysqli_query($lnk, "INSERT INTO registo(id_admin,id_user,id_noticia,id_fase,registo,data,hora) VALUES ('$id_user','$id_recetor_ant','$id_noticia','$i','$registo','$hoje','$hora')");
			
			if($i==$id_fase){
				mysqli_query($lnk, "INSERT INTO trabalho(id_emissor,id_recetor,id_noticia,id_fase,data) VALUES ('$id_user','$id_recetor_ant','$id_noticia','$i','$hoje')");

				$paraEmail = $email_rec;
				$paraNome = $nome_rec;
				$para = $nome_rec." <".$email_rec.">";
				$De = $nome_emi." <".$email_emi.">";
				$assunto = "Plataforma Online Sá Machado";
				$mensagem = '
				<html>
				<head>
				 <title>'.$assunto.'</title>
				 <style>*{font-size:14px;}</style>
				</head>
				<body>
				<p>Olá '.$nome_rec.', tem uma <b>nova tarefa</b>.</p>
				<p>Pode aceder à plataforma em <a href="http://www.samachado.com/admin">www.samachado.com/admin</a>.</p>
				<p>Na plataforma tens informações sobre a tarefa a realizares bem como um chat para te ajudar, no caso de teres dúvidas.</p>
				<p>Todas as tuas interações são guardadas e apresentadas no histórico!</p>
				<p>Melhores Cumprimentos</p>
				<p>'.$nome_emi.'</p>
				<br><hr>
				</body>
				</html>
				';
				include('funcao/email.php');
			}
			else{mysqli_query($lnk, "INSERT INTO trabalho(id_emissor,id_recetor,id_noticia,id_fase) VALUES ('$id_user','$id_recetor_ant','$id_noticia','$i')");}
		}
	}
}
?>