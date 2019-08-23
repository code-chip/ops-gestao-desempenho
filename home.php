<?php 
session_start();
include('login-check.php');
$menuInicio="is-active";
include('menu.php');
header('Content-Type: text/html; charset=UTF-8');
$n=rand(1,23);
$img="img/data-science".$n.".jpg";
//print_r($_SESSION);exit();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho</title>
	<link rel="shortcut icon" href="img\favicon_codechip.ico"/>
	<link rel="stylesheet" href="css/login.css" />
	<!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">-->
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
<body>
	<div class="hero is-fullheight is-primary has-background">
	  	<img alt="Fill Murray" class="hero-background is-transparent" src="<?php echo $img;?>" />
	  	<div class="hero-body">
	    	<div class="container">
		     	<h1 class="title">
		        	Bem vindo
		      	</h1>
		      	<h3 class="subtitle">
		        	<?php echo $_SESSION["nameUser"]; ?>
		      	</h3>
	    	</div>
	  	</div>
	</div>
</body>
</html>