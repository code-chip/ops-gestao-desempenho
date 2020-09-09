<?php

$menuAtivo = 'configuracoes';
require('menu.php');

$_SESSION["filter"] = array();

array_push($_SESSION['filter'], trim($_GET['descricao']), trim($_GET['link'])); 

?>
<!DOCTYPE html>
<html>
<head>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/myjs.js"></script>
	<title>Gestão Desempenho - Cadastro</title>
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
		.spc{
			margin-right: 10px;
		}
		@media (max-width: 880px){
			.mw12{
				min-width:24em;
			}
		}
		@media (max-width: 860px){
			.mw12{
				min-width:20em;
			}
		}
		@media (max-width: 720px){
			.mw12{
				min-width:19em;
			}
		}
		@media (max-width: 660px){
			.mw12{
				min-width:18.1em;
			}
		}
		@media (max-width: 650px){
			.mw12{
				min-width:17em;
			}
		}
		@media (max-width: 640px){
			.mw12{
				min-width:14em;
			}
		}
		@media (max-width: 550px){
			.mw12{
				min-width: 100%;
			}
		}
	</style>
</head>
<body>
<div class="hero is-fullheight is-primary has-background field has-addons">
<img alt="Fill Murray" class="hero-background is-transparent" src="img/wallpaper/data-science8-min-black.jpg" />
<div class="hero-background">
	<section class="section">
	<div class="field has-addons has-addons-centered">
		<div class="buttons">
			<?php if ($_SESSION["permissao"] != 1) { ?>
			<a href="user-insert.php" class="button is-media is-primary is-outlined mw12">Inserir Usuário</a>
			<?php } ?>		
			<a href="user-query.php" class="button is-media is-primary is-outlined mw12">Consultar Usuário</a>
			<a href="user-update.php" class="button is-media is-primary is-outlined mw12">Atualizar Usuário</a>			
			<?php if ($_SESSION["permissao"] == 4) { ?>
			<a href="user-remove.php" class="button is-media is-primary is-outlined mw12">Remover Usuário</a>
			<?php } ?>		
		</div>	
	</div>
	<br/>
	<div class="field has-addons has-addons-centered">
		<div class="buttons">								
			<button class="button is-white is-primary is-outlined mw12" value="adress-insert.php, Inserir Endereço" onclick="actionAdress(this.value)">Inserir Endereço</button>
			<button class="button is-white is-primary is-outlined mw12" value="adress-query.php, Consultar Endereço" onclick="actionAdress(this.value)">Consultar Endereço</button>
			<button class="button is-white is-primary is-outlined mw12" value="adress-update.php, Atualizar Endereço" onclick="actionAdress(this.value)">Atualizar Endereço</button>
			<?php if ($_SESSION["permissao"] != 1) { ?>
			<button class="button is-white is-primary is-outlined mw12" value="adress-remove.php, Remover Endereço" onclick="actionAdress(this.value)">Remover Endereço</button>
			<?php } ?>			
		</div>	
	</div>
	<br/>
	<?php if ($_SESSION["permissao"] != 1) { ?>	
	<div class="field has-addons has-addons-centered">
		<div class="buttons">								
			<a href="option-insert.php" class="button is-white is-primary is-outlined mw12">Inserir Opção</a>
			<a href="option-query.php" class="button is-media is-primary is-outlined mw12">Consultar Opção</a>
			<a href="option-update.php" class="button is-media is-primary is-outlined mw12">Atualizar Opção</a>
			<a href="option-remove.php" class="button is-media is-primary is-outlined mw12">Remover Opção</a>		
		</div>	
	</div>
	<br/>
	<div class="field has-addons has-addons-centered">
		<div class="buttons">								
			<a href="user-list.php" class="button is-media is-primary is-outlined mw12">Listar Usuários</a>
			<a href="option-list.php" class="button is-media is-primary is-outlined mw12">Listar Opções</a>
			<a href="goal-list.php" class="button is-media is-primary is-outlined mw12">Listar Metas</a>
			<a href="user-list-off.php" class="button is-media is-primary is-outlined mw12">Listar Desligados</a>		
		</div>	
	</div>
	<br/>
	<div class="field has-addons has-addons-centered">
		<div class="buttons">								
			<a href="question-insert.php" class="button is-media is-primary is-outlined mw12">Inserir Pergunta</a>
			<a href="question-query.php" class="button is-media is-primary is-outlined mw12">Consultar Pergunta</a>
			<a href="question-update.php" class="button is-media is-primary is-outlined mw12">Atualizar Pergunta</a>
			<a href="question-remove.php" class="button is-media is-primary is-outlined mw12">Remover Pergunta</a>		
		</div>	
	</div>
	<br/>
	<div class="field has-addons has-addons-centered">
		<div class="buttons">								
			<a href="menu-insert.php" class="button is-media is-primary is-outlined mw12">Inserir Menu</a>
			<a href="menu-query.php" class="button is-media is-primary is-outlined mw12">Consultar Menu</a>
			<a href="menu-update.php" class="button is-media is-primary is-outlined mw12">Atualizar Menu</a>
			<a href="menu-remove.php" class="button is-media is-primary is-outlined mw12">Remover Menu</a>		
		</div>	
	</div>
	<br/>
	<div class="field has-addons has-addons-centered">
		<div class="buttons">								
			<a href="wait.php" class="button is-media is-primary is-outlined mw12">Inserir Mensagem</a>
			<a href="wait.php" class="button is-media is-primary is-outlined mw12">Consultar Mensagem</a>
			<a href="wait.php" class="button is-media is-primary is-outlined mw12">Atualizar Mensagem</a>
			<a href="wait.php" class="button is-media is-primary is-outlined mw12">Remover Mensagem</a>		
		</div>	
	</div>
	<br/>
	<?php if ($_SESSION["permissao"] == 4 || $_SESSION["cargo"] == 12) { ?>	
	<div class="field has-addons has-addons-centered">
		<div class="buttons">								
			<a href="coupon-insert.php" class="button is-media is-primary is-outlined mw12">Inserir Cupom</a>
			<a href="coupon-list.php" class="button is-media is-primary is-outlined mw12">Listar Cupom</a>			
		</div>	
	</div>
	<?php 

	} 

	} ?>
	</section>
</div>
</div>	
<script type="text/javascript">
	function actionAdress(valor) {
		valor = valor.split(',',2);
		if (valor.length == 0) {
		   	document.getElementById("txtHint").innerHTML = "";
		   	
		   	return;
		} else {
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
