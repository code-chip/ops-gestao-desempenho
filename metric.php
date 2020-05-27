<?php

$menuAtivo="configuracoes";

include('menu.php');

if($_SESSION["permissao"]==1){
	echo "<script>alert('Usuário sem permissão'); window.location.href='home.php';</script>";
}

$_SESSION["filter"] = array();

array_push($_SESSION["filter"], trim($_GET['descricao']), trim($_GET['link'])); 

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
		<button class="button is-white is-primary is-outlined mw12" value="goal-company-insert.php" onclick="loadPage(this.value)">Inserir Meta</button>
		<button class="button is-white is-primary is-outlined mw12" value="goal-company-query.php, Consultar Meta" onclick="redirect(this.value)">Consultar Meta</button>
		<button class="button is-white is-primary is-outlined mw12" value="goal-company-update.php, Atualizar Meta" onclick="redirect(this.value)">Atualizar Meta</button>
		<?php if($_SESSION["permissao"]!=1):?>
		<button class="button is-white is-primary is-outlined mw12" value="goal-company-remove.php, Remover Meta" onclick="redirect(this.value)">Remover Meta</button><?php endif;?>			
	</div>
</div>
<br/>
<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<button class="button is-white is-primary is-outlined mw12" value="goal-weight-insert.php" onclick="loadPage(this.value)">Inserir Peso</button>
		<button class="button is-white is-primary is-outlined mw12" value="goal-weight-query.php, Consultar Peso" onclick="redirect(this.value)">Consultar Peso</button>
		<button class="button is-white is-primary is-outlined mw12" value="goal-weight-update.php, Atualizar Peso" onclick="redirect(this.value)">Atualizar Peso</button>
		<?php if($_SESSION["permissao"]!=1):?>
		<button class="button is-white is-primary is-outlined mw12" value="goal-weight-remove.php, Remover Peso" onclick="redirect(this.value)">Remover Peso</button><?php endif;?>			
	</div>
</div><br/>
<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<button class="button is-white is-primary is-outlined mw12" value="penalty-type-insert.php" onclick="loadPage(this.value)">Inserir Penalidade</button>
		<button class="button is-white is-primary is-outlined mw12" value="penalty-type-query.php, Consultar Penalidade" onclick="redirect(this.value)">Consultar Penalidade</button>
		<button class="button is-white is-primary is-outlined mw12" value="penalty-type-update.php, Atualizar Penalidade" onclick="redirect(this.value)">Atualizar Penalidade</button>
		<?php if($_SESSION["permissao"]!=1):?>
		<button class="button is-white is-primary is-outlined mw12" value="penalty-type-remove.php, Remover Penalidade" onclick="redirect(this.value)">Remover Penalidade</button><?php endif;?>			
	</div>
</div><br/>
</section>
</div>
<script type="text/javascript">
	function redirect(valor) {
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
			xmlhttp.open("GET", "metric.php?link="+valor[0]+"&descricao="+valor[1] , true);	    
			xmlhttp.send(valor[0]);		   	
		}
		setTimeout(function(){
		  	window.location.replace('query-filter.php');
		  },500);
	}
	function loadPage(page){
		window.location.replace(''+page);
	}
</script>
</body>
</html>
