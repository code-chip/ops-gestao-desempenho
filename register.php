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
}
</style>
<?php
$menuConfiguracoes="is-active";
include('menu.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão Desempenho - Cadastro</title>
</head>
<body>
<div class="hero is-fullheight is-primary has-background field has-addons">
	 <img alt="Fill Murray" class="hero-background is-transparent" src="img/wallpaper/data-science8-min-black.jpg" />
	 <div class="hero-background capas capas2">
<section class="section">
<div class="field has-addons has-addons-centered">
	<div class="buttons">
		<?php if($_SESSION["permissao"]!=1):?><a href="user-insert.php"><span class="button is-media is-primary is-outlined mw12">Inserir Usuário</span></a>&nbsp&nbsp&nbsp<?php endif;?>		
		<a href="user-query.php"><span class="button is-media is-primary is-outlined mw12">Consultar Usuário</span></a>&nbsp&nbsp&nbsp
		<a href="user-update.php"><span class="button is-media is-primary is-outlined mw12">Atualizar Usuário</span></a>&nbsp&nbsp&nbsp			
		<?php if($_SESSION["permissao"]==4):?><a href="user-remove.php"><span class="button is-media is-primary is-outlined mw12">Remover Usuário</span></a>&nbsp&nbsp&nbsp<?php endif;?>		
	</div>	
</div>
<br/>
<?php if($_SESSION["permissao"]!=1):?>	
<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<a href="option-insert.php"><span class="button is-white is-primary is-outlined mw12">Inserir Opção</span></a>&nbsp&nbsp&nbsp
		<a href="option-query.php"><span class="button is-media is-primary is-outlined mw12">Consultar Opção</span></a>&nbsp&nbsp&nbsp
		<a href="option-update.php"><span class="button is-media is-primary is-outlined mw12">Atualizar Opção</span></a>&nbsp&nbsp&nbsp
		<a href="option-remove.php"><span class="button is-media is-primary is-outlined mw12">Remover Opção</span></a>&nbsp&nbsp&nbsp		
	</div>	
</div>
<br/>
<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<a href="user-list.php"><span class="button is-media is-primary is-outlined mw12">Listar Usuários</span></a>&nbsp&nbsp&nbsp
		<a href="option-list.php"><span class="button is-media is-primary is-outlined mw12">Listar Opções</span></a>&nbsp&nbsp&nbsp
		<a href="goal-list.php"><span class="button is-media is-primary is-outlined mw12">Listar Metas</span></a>&nbsp&nbsp&nbsp
		<a href="user-list-off.php"><span class="button is-media is-primary is-outlined mw12">Listar Desligados</span></a>&nbsp&nbsp&nbsp		
	</div>	
</div>
<br/>
<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<a href="question-insert.php"><span class="button is-media is-primary is-outlined mw12">Inserir Pergunta</a>&nbsp&nbsp&nbsp
		<a href="question-query.php"><span class="button is-media is-primary is-outlined mw12">Consultar Pergunta</span></a>&nbsp&nbsp&nbsp
		<a href="question-update.php"><span class="button is-media is-primary is-outlined mw12">Atualizar Pergunta</span></a>&nbsp&nbsp&nbsp
		<a href="question-remove.php"><span class="button is-media is-primary is-outlined mw12">Remover Pergunta</span></a>&nbsp&nbsp&nbsp		
	</div>	
</div>
<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<a href="wait.php"><span class="button is-media is-primary is-outlined mw12">Inserir Menu</span></a>&nbsp&nbsp&nbsp
		<a href="wait.php"><span class="button is-media is-primary is-outlined mw12">Consultar Menu</span></a>&nbsp&nbsp&nbsp
		<a href="wait.php"><span class="button is-media is-primary is-outlined mw12">Atualizar Menu</span></a>&nbsp&nbsp&nbsp
		<a href="wait.php"><span class="button is-media is-primary is-outlined mw12">Remover Menu</span></a>&nbsp&nbsp&nbsp		
	</div>	
</div>
<!--<br/>

<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<a href="wait.php"><span class="button is-media is-primary is-outlined mw12">Inserir Permissão</span></a>&nbsp&nbsp&nbsp
		<a href="wait.php"><span class="button is-media is-primary is-outlined mw12">Consultar Permissão</span></a>&nbsp&nbsp&nbsp
		<a href="wait.php"><span class="button is-media is-primary is-outlined mw12">Atualizar Permissão</span></a>&nbsp&nbsp&nbsp
		<a href="wait.php"><span class="button is-media is-primary is-outlined mw12">Remover Permissão</span></a>&nbsp&nbsp&nbsp		
	</div>	
</div>-->
<?php endif;?>
</section>
</div>
</body>
</html>
