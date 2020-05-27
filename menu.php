<?php 
require('login-check.php');
require('connection.php');
header('Content-Type: text/html; charset=UTF-8');
ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
date_default_timezone_set('America/Sao_Paulo');
//print_r($_SESSION);exit();
$menuAtivo;
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
    <!--<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>-->
	<script type="text/javascript" src="js/jquery.mask.min.js"></script>
    <script language="javascript">
	    $(document).ready(function () {	    	
	        $('.registro').mask('9999-99-99');
	        $('.desempenho').mask('9999');
	        $('.numero').mask('9999');
	        $('.celular').mask('(999)99999-9999');
	        $('.maskCep').mask('99999-999');
	        $('.maskPlaca').mask('AAA-AAAA');
	        $('.maskDataInicio').mask('9999-99-21');
	        $('.maskDataFim').mask('9999-99-20');
	        $('.maskMetaEmpresa').mask('9999999999');	       
	        return false;
	    });
	    function msg(){
	    	alert('Funcionalidade em desenvolvimento!!');
	    }
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-156503826-3"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-156503826-3');
	</script>
</head>
<body>
	<header>
	<nav class="navbar is-primary">
		<div class="container">
			<div class="navbar-brand">
				<a class="navbar-item hvr-curl-top-right" href="https://evino.com.br" target="_blank" style="font-weight:bold;">( evino )</a>
				<span class="navbar-burger burger" data-target="navMenu">
					<span></span>
					<span></span>
					<span></span>
				</span>	
			</div>
			<div id="navMenu" class="navbar-menu">
				<div class="navbar-end">
					<?php 
					$loadMenu="SELECT ID, MENU, TAG, TARGET, LINK, SUBMENU FROM MENU WHERE ATIVO='s' and LIBERADO='s' AND PERMISSAO_ID=".$_SESSION["permissao"]." ORDER BY POSICAO";
					$cnx=mysqli_query($phpmyadmin, $loadMenu);					
					while ($menu=$cnx->fetch_array()): {
						if($menu["SUBMENU"]=="s"):{?>
							<div class="navbar-item has-dropdown is-hoverable">
								<a href="<?php echo $menu["LINK"]?>" target="<?php echo $menu["TARGET"]?>" class="navbar-link <?php if($menuAtivo==$menu["TAG"]){ echo "is-active"; }?> hvr-grow"><?php echo $menu["MENU"]?></a>
								<div class="navbar-dropdown"><?php 
									$loadItemMenu="SELECT ITEM, TARGET, LINK FROM MENU_ITEM WHERE ATIVO='s' and LIBERADO='s' AND MENU_ID=".$menu["ID"]." AND PERMISSAO_ID=".$_SESSION["permissao"]." ORDER BY POSICAO";
									$cnx2=mysqli_query($phpmyadmin, $loadItemMenu);
									while ($itemMenu= $cnx2->fetch_array()): {?>
										<a href="<?php echo $itemMenu["LINK"]?>" target="<?php echo $itemMenu["TARGET"]?>" class="navbar-item hvr-grow"><?php echo $itemMenu["ITEM"]?></a>	
									<?php }endwhile;
									?>
								</div>
							</div><?php
						}endif;		
						if($menu["SUBMENU"]=="n"):{?>
							<a href="<?php echo $menu["LINK"] ?>" target="<?php echo $menu["TARGET"]?>" class="navbar-item <?php if($menuAtivo==$menu["TAG"]){ echo "is-active"; }?> hvr-grow"><?php echo $menu["MENU"] ?></a><?php
						}endif;	
					}endwhile; #final while
					?>		
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
