<?php
$menuAtivo="configuracoes";
include('menu.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão Desempenho - Métricas de Desempenho</title>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/myjs.js"></script>
	<style type="text/css">
		.hero.is-success {
			background: #0000;
		}
		.hero .nav, .hero.is-success .nav {
		  	-webkit-box-shadow: none;
		  	box-shadow: none;
		}
		.hero.has-background {
			position: relative;
			/*overflow: hidden;*/
		}
		.hero-background {
			position: absolute;
			object-fit: cover;
			object-position: center center;
			width: 100%;
			height: 100%;
		}
		.hero-background.is-transparent{
		    opacity: 0.7;
		    height: 100%;
		}
	</style>
</head>
<body>
<div class="hero is-fullheight is-primary has-background field has-addons">
	 <img alt="Fill Murray" class="hero-background is-transparent" src="img/wallpaper/data-science19-min.jpg" />
	 <div class="hero-background capas capas2">
<section class="section">
<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<a href="-insert.php"><span class="button is-white is-primary is-outlined mw12">Inserir Vendas</span></a>&nbsp&nbsp&nbsp
		<a href="-query.php"><span class="button is-media is-primary is-outlined mw12">Consultar Vendas</span></a>&nbsp&nbsp&nbsp
		<a href="-update.php"><span class="button is-media is-primary is-outlined mw12">Atualizar Vendas</span></a>&nbsp&nbsp&nbsp
		<a href="-remove.php"><span class="button is-media is-primary is-outlined mw12">Remover Vendas</span></a>&nbsp&nbsp&nbsp		
	</div>	
</div>
<br/>
<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<a href="-insert.php"><span class="button is-media is-primary is-outlined mw12">Inserir Peso</a>&nbsp&nbsp&nbsp
		<a href="-query.php"><span class="button is-media is-primary is-outlined mw12">Consultar Peso</span></a>&nbsp&nbsp&nbsp
		<a href="-update.php"><span class="button is-media is-primary is-outlined mw12">Atualizar Peso</span></a>&nbsp&nbsp&nbsp
		<a href="-remove.php"><span class="button is-media is-primary is-outlined mw12">Remover Peso</span></a>&nbsp&nbsp&nbsp		
	</div>	
</div><br/>
<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<a href="-insert.php"><span class="button is-media is-primary is-outlined mw12">Inserir Penalidade</span></a>&nbsp&nbsp&nbsp
		<a href="-query.php"><span class="button is-media is-primary is-outlined mw12">Consultar Penalidade</span></a>&nbsp&nbsp&nbsp
		<a href="-update.php"><span class="button is-media is-primary is-outlined mw12">Atualizar Penalidade</span></a>&nbsp&nbsp&nbsp
		<a href="-remove.php"><span class="button is-media is-primary is-outlined mw12">Remover Penalidade</span></a>&nbsp&nbsp&nbsp		
	</div>	
</div><br/>
<!--<br/>
<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<a href="wait.php"><span class="button is-media is-primary is-outlined mw12">Inserir Permissão</span></a>&nbsp&nbsp&nbsp
		<a href="wait.php"><span class="button is-media is-primary is-outlined mw12">Consultar Permissão</span></a>&nbsp&nbsp&nbsp
		<a href="wait.php"><span class="button is-media is-primary is-outlined mw12">Atualizar Permissão</span></a>&nbsp&nbsp&nbsp
		<a href="wait.php"><span class="button is-media is-primary is-outlined mw12">Remover Permissão</span></a>&nbsp&nbsp&nbsp		
	</div>	
</div>-->
</section>
</div>
</body>
</html>
