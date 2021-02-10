<?php 

$menuAtivo = 'inicio';
require_once('menu.php');

$n = rand(1,25);
$img = "img/wallpaper/data-science".$n."-min.jpg";

list($nome, $sobrenome) = explode(' ', $_SESSION["nameUser"], 2);

$cnx = mysqli_query($phpmyadmin, "SELECT DATE_FORMAT(DATA_HORA, '%Y-%m-%d %H:%i'), TIMESTAMPDIFF(DAY,DATA_HORA,'".date('Y-m-d')."') AS DAYS, (SELECT COUNT(1) FROM FEEDBACK WHERE DESTINATARIO_ID=".$_SESSION["userId"]." AND SITUACAO='Aprovado') AS FEEDBACK, (SELECT COUNT(1) FROM SOLICITACAO WHERE DESTINATARIO_ID=".$_SESSION["userId"]." AND SITUACAO='Enviado') AS SOLICITACAO, 
(SELECT COUNT(1) FROM FEEDBACK WHERE SITUACAO='Enviado') AS WAIT, (SELECT MAX(ACESSO_TOTAL) FROM ACESSO WHERE USUARIO_ID=".$_SESSION["userId"].") AS ACESSOS
FROM ACESSO_HISTORICO WHERE USUARIO_ID =".$_SESSION["userId"]." GROUP BY 1 ORDER BY 1 DESC LIMIT 1,1;");

$feed = $cnx->fetch_array();

if ($_SESSION['permissao'] > 1 && $feed['WAIT'] > 0) {
	echo "<script>alert('".$nome.", existe Feedback aguardando a sua aprovação.')</script>";
}

if ($feed["FEEDBACK"] > 0) {
	echo "<script>alert('".$feed["FEEDBACK"]." Feedback(s) recebido(s). Leia clicando no item Consultar do menu Feedback'); </script>";
}

if ($feed["SOLICITACAO"] > 0) {
	echo "<script>alert('".$feed["SOLICITACAO"]." Solicitação de Feedback recebida. Leia clicando no item Consultar do menu Feedback.');</script>";
} else if ($feed["SOLICITACAO"] > 1) { 
	echo "alert('".$feed["SOLICITACAO"]." Solicitações de Feedback recebida. Leia clicando no item Consultar do menu Feedback.'); </script>";
}

if ($_SESSION['$messageRead'] == 0) {
	$salute = "Bem vindo";
	$_SESSION['$messageRead'] = 1;		        	
} else if ($_SESSION['$messageRead'] == 1 && date('H', time()) >= "6" && date('H', time()) <= "11") {		        		
	$salute = "Bom dia";
	$_SESSION['$messageRead'] = 2;
} else if ($_SESSION['$messageRead'] == 1 && date('H', time()) >= "12" && date('H', time()) <= "17") {		        		
	$salute = "Boa tarde";
	$_SESSION['$messageRead'] = 2;
} else if ($_SESSION['$messageRead'] == 1 && date('H', time()) >= "18" && date('H', time()) <= "23") {		        		
	$salute = "Boa noite";
	$_SESSION['$messageRead'] = 2;
} else if ($_SESSION['$messageRead'] == 1 && date('H', time()) >= "00" && date('H', time()) <= "05") {		        		
	$salute = "Boa madrugada";
	$_SESSION['$messageRead'] = 2;
} else {
	$salute = "Olá";
}

if ($feed["ACESSOS"] == 1) {
	$msg = $nome.", notamos que este é o seu primeiro acesso, espero que goste das novidades.";
} else if ($feed["DAYS"] > 2 && $feed["DAYS"] < 6) {
	$msg = "Seu último acesso foi há mais de ".$feed["DAYS"]." dias, verifique as novas informações lançadas ".$nome."!!";
} else if ($feed["DAYS"] > 5 && $feed["DAYS"] < 8) { 
	$msg = $nome.", notamos sua ausência de uma semana, acompanhe o lançamento diário de suas metas.";
} else if ($feed["DAYS"] > 8) { 
	$msg = $nome.", há " . $feed["DAYS"] . " dias não fez login no sistema, fique atento ao lançamento das metas.";
} else {
	$msg = $nome;
}		     

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<link rel="shortcut icon" href="img\favicon_codechip.ico"/>
	<link rel="stylesheet" href="css/login.css" />
	<link rel="stylesheet" href="css/animate.css" />	
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<title>Gestão de Desempenho</title>
</head>
<body>
	<div class="hero is-fullheight is-primary has-background">
	  	<img alt="Fill Murray" class="hero-background is-transparent" src="<?php echo $img;?>" />
	  	<div class="hero-body">
	    	<div class="container">
		     	<h1 class="title animated bounceInDown"><?php echo $salute; ?></h1>
		      	<h3 class="subtitle animated bounceInRight"><?php echo $msg; ?></h3>
	    	</div>
	  	</div>
	</div>
</body>
</html>