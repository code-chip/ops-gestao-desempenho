<?php 
session_start();
include('verifica_login.php');
header('Content-Type: text/html; charset=UTF-8');
//print_r($_SESSION);exit();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Sistema Logístico</title>
	<link rel="shortcut icon" href="img\favicon_codechip.ico"/>
	<link rel="stylesheet" href="css/personal.css" />
	<!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">-->
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
<body>
	<nav class="navbar is-primary">
		<div class="container">
			<div class="navbar-brand">
				<a class="navbar-item" href="#" style="font-weight:bold;">FastLog</a>
				<span class="navbar-burger burger" data-target="navMenu">
					<span></span>
					<span></span>
					<span></span>
				</span>	
			</div>
			<div id="navMenu" class="navbar-menu">
				<div class="navbar-end">
					<a href="#" class="navbar-item is-active">Início</a>
					<a href="processamento.php" class="navbar-item">Desempenho</a>
					<a href="#" class="navbar-item">Relatórios/a>
					<!--<a href="#" class="navbar-item">Configuraçoes</a>-->
					<div class="navbar-item has-dropdown is-hoverable">
			        <a class="navbar-link">Configurações</a>
			        <div class="navbar-dropdown">
			          <a class="navbar-item">About</a>
			          <a class="navbar-item">Jobs</a>
			          <a class="navbar-item">Contact</a>
			          <hr class="navbar-divider">
			          <a class="navbar-item">Report an issue</a>
			        </div>
			      </div>

					<a href="logout.php" class="navbar-item">Sair</a>
				</div>
			</div>
		</div>
	</nav>
	<script type="text/javascript">
		(function(){
			var burger = document.querySelector('.burger');
			var nav = document.querySelector('#'+burger.dataset.target);

			burger.addEventListener('click', function(){
				burger.classList.toggle('is-active');
				nav.classList.toggle('is-active');
			});
		})();
	</script>
</body>	