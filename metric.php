<?php
$menuAtivo="configuracoes";
include('menu.php');
$_SESSION["filter"]=array();
array_push($_SESSION["filter"], trim($_GET['descricao']), trim($_GET['link'])); 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão Desempenho - Configurações Métricas</title>
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
	 <img alt="Fill Murray" class="hero-background is-transparent" src="img/wallpaper/data-science8-min-black.jpg" />
	 <div class="hero-background capas capas2">
<section class="section">
<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<a href="-insert.php"><span class="button is-white is-primary is-outlined mw12">Inserir Meta</span></a>&nbsp&nbsp&nbsp
		<a href="-query.php"><span class="button is-media is-primary is-outlined mw12">Consultar Meta</span></a>&nbsp&nbsp&nbsp
		<a href="-update.php"><span class="button is-media is-primary is-outlined mw12">Atualizar Meta</span></a>&nbsp&nbsp&nbsp
		<a href="-remove.php"><span class="button is-media is-primary is-outlined mw12">Remover Meta</span></a>&nbsp&nbsp&nbsp		
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
<script type="text/javascript">
	function actionAdress(valor) {
		valor= valor.split(',',2);
		if (valor.length == 0) {
		   	document.getElementById("txtHint").innerHTML = "";
		   	return;
		}
		else{
		   	var xmlhttp = new XMLHttpRequest();
		   	xmlhttp.onreadystatechange = function() {
			   	if (this.readyState == 4 && this.status == 200) {
			       	document.getElementById("txtHint").innerHTML = this.responseText;
			   	}
			};		    
			xmlhttp.open("GET", "register.php?link="+valor[0]+"&descricao="+valor[1] , true);	    
			xmlhttp.send(valor[0]);		   	
		}
		setTimeout(function(){
		  	window.location.replace('user-query-filter.php');
		  },500);
	}
</script>
</body>
</html>
