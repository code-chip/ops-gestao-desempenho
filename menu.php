<?php 
session_start();
include('login-check.php');
include('connection.php');
header('Content-Type: text/html; charset=UTF-8');
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//print_r($_SESSION);exit();
//$menuInicio="is-active";
$menuInicio;
$menuDesempenho;
$menuRelatorio;
$menuConfiguracoes;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<link rel="shortcut icon" href="img\favicon_codechip.ico"/>
	<link rel="stylesheet" href="css/personal.css" />
	<link rel="stylesheet" href="css/hover.css" />
	<!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">-->
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<script src="//code.jquery.com/jquery-2.1.4.min.js"></script>    
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/jquery.mask.min.js"></script>
    <script language="javascript">
	    $(document).ready(function () {	    	
	        $('.registro').mask('9999-99-99');
	        $('.desempenho').mask('9999');
	        $('.numero').mask('9999');	       
	        return false;
	    });
	    function msg(){
	    	alert('Funcionalidade em desenvolvimento!!');
	    }
    </script>
    <style type="text/css">
	.table__wrapper {
  		overflow-x: auto;
	}
	.scrollWrapper {
		display:table;
  		width: 100%;
  		overflow-x: auto;  		
	}
	.mw12{
		min-width:12em;
	}
	.ocultaColunaId{
		position: absolute; 
		visibility: hidden; 
		margin-left: -25px;  
		max-width:0em;
	}
</style>
</head>
<body>
	<header>
	<nav class="navbar is-primary">
		<div class="container">
			<div class="navbar-brand">
				<a class="navbar-item hvr-curl-top-right" href="https://evino.com.br" target="_blank" style="font-weight:bold;">(evino)</a>
				<span class="navbar-burger burger" data-target="navMenu">
					<span></span>
					<span></span>
					<span></span>
				</span>	
			</div>
			<div id="navMenu" class="navbar-menu">
				<div class="navbar-end">
					<a href="home.php" class="navbar-item <?php echo $menuInicio?> hvr-grow">Início</a>
					<a href="dashboard.php" class="navbar-item <?php echo $menuDashboard?> hvr-grow">Dashboard</a>
					<div href="#" class="navbar-item has-dropdown is-hoverable">
						<a class="navbar-link <?php echo $menuMeta?> hvr-grow">Meta</a>					
						<div class="navbar-dropdown">
							<a href="#" class="navbar-item hvr-grow" onclick="msg();">Consultar</a>
							<?php if($_SESSION["permissao"]!=1):{?>
							<a href="#" class="navbar-item hvr-grow" onclick="msg();">Inserir</a>
							<a href="#" class="navbar-item hvr-grow" onclick="msg();">Atualizar</a>
							<?php if($_SESSION["permissao"]>2):{?><a href="#" class="navbar-item hvr-grow" onclick="msg();">Remover</a><?php }endif;?>
							<?php }endif;?>
						</div>
					</div>
					<?php if($_SESSION["permissao"]!=1):{?><div href="#" class="navbar-item has-dropdown is-hoverable">
						<a class="navbar-link <?php echo $menuDesempenho?> hvr-grow">Desempenho</a>					
						<div class="navbar-dropdown">
							<a href="report-query.php" class="navbar-item hvr-grow">Consultar</a>
							<a href="report-insert.php" class="navbar-item hvr-grow">Inserir</a>
							<a href="report-update.php" class="navbar-item hvr-grow">Atualizar</a>
							<?php if($_SESSION["permissao"]>2):{?><a href="report-remove.php" class="navbar-item hvr-grow">Remover</a><?php }endif;?>
						</div>
					</div><?php }endif;?>
					<div href="#" class="navbar-item has-dropdown is-hoverable">
						<a href="#" class="navbar-link <?php echo $menuRelatorio?> hvr-grow">Relatórios</a>					
						<div class="navbar-dropdown">
							<?php if($_SESSION["permissao"]!=1):?><a href="report.php" class="navbar-item hvr-grow">Gestão</a><?php endif;?>
							<a href="report-private.php" class="navbar-item hvr-grow">Individual</a>							
						</div>
					</div>
				<div class="navbar-item has-dropdown is-hoverable">
			     	<a class="navbar-link <?php echo $menuConfiguracoes?> hvr-grow">Configurações</a>
			        <div class="navbar-dropdown">
				        <a href="register.php" class="navbar-item hvr-grow">Cadastro</a>
				        <?php if($_SESSION["permissao"]!=1):?><a class="navbar-item hvr-grow">Permissões</a><?php endif;?>
				        <a class="navbar-item hvr-grow">Tema</a>
				        <hr class="navbar-divider hvr-grow">
				        <a class="navbar-item hvr-grow">Reportar bug</a>
			        </div>
			    </div>
				<a href="logout.php" class="navbar-item hvr-grow">Sair</a>
				</div>
			</div>
		</div>
	</nav>
	</header>
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