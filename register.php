<?php
session_start();
$menuConfiguracoes="is-active";
include('menu.php');
//<!--- DECLARAÇÃO DAS VARIAVEIS -->
$turno = trim($_REQUEST['turno']);
$nome = trim($_REQUEST['nome']);
$efetivacao = trim($_REQUEST['efetivacao']);
$situacao = trim($_REQUEST['situacao']);
$contador = 0;
$totalAlcancado=0;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão Desempenho - Cadastro</title>
</head>
<body>
<section class="section">
<div class="field has-addons has-addons-centered">
	<div class="buttons">
		<?php if($_SESSION["permissao"]!=1):?><a href="user-insert.php"><span class="button is-media is-primary is-outlined mw12">Inserir Usuário</span></a>&nbsp&nbsp&nbsp<?php endif;?>		
		<a href="user-query.php"><span class="button is-media is-primary is-outlined mw12">Consultar Usuário</span></a>&nbsp&nbsp&nbsp
		<a href="user-update.php"><span class="button is-media is-primary is-outlined mw12">Atualizar Usuário</span></a>&nbsp&nbsp&nbsp			
		<?php if($_SESSION["permissao"]>2):?><a href="user-remove.php"><span class="button is-media is-primary is-outlined mw12">Remover Usuário</span></a>&nbsp&nbsp&nbsp<?php endif;?>		
	</div>	
</div>
<?php if($_SESSION["permissao"]!=1):?>
<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<a href="profession-insert.php"><span class="button is-media is-primary is-outlined mw12">Inserir Cargo</span></a>&nbsp&nbsp&nbsp
		<a href="profession-query.php"><span class="button is-media is-primary is-outlined mw12">Consultar Cargo</span></a>&nbsp&nbsp&nbsp
		<a href="profession-update.php"><span class="button is-media is-primary is-outlined mw12">Atualizar Cargo</span></a>&nbsp&nbsp&nbsp
		<a href="profession-remove.php"><span class="button is-media is-primary is-outlined mw12">Remover Cargo</span></a>&nbsp&nbsp&nbsp		
	</div>	
</div>
<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<a href="shift-insert.php"><span class="button is-media is-primary is-outlined mw12">Inserir Turno</span></a>&nbsp&nbsp&nbsp
		<a href="shift-query.php"><span class="button is-media is-primary is-outlined mw12">Consultar Turno</span></a>&nbsp&nbsp&nbsp
		<a href="shift-update.php"><span class="button is-media is-primary is-outlined mw12">Atualizar Turno</span></a>&nbsp&nbsp&nbsp
		<a href="shift-remove.php"><span class="button is-media is-primary is-outlined mw12">Remover Turno</span></a>&nbsp&nbsp&nbsp		
	</div>	
</div>
<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<a href="manager-insert.php"><span class="button is-media is-primary is-outlined mw12">Inserir Gestor</a>&nbsp&nbsp&nbsp
		<a href="manager-query.php"><span class="button is-media is-primary is-outlined mw12">Consultar Gestor</span></a>&nbsp&nbsp&nbsp
		<a href="manager-update.php"><span class="button is-media is-primary is-outlined mw12">Atualizar Gestor</span></a>&nbsp&nbsp&nbsp
		<a href="manager-remove.php"><span class="button is-media is-primary is-outlined mw12">Remover Gestor</span></a>&nbsp&nbsp&nbsp		
	</div>	
</div>
<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<a href="sector-insert.php"><span class="button is-media is-primary is-outlined mw12">Inserir Setor</span></a>&nbsp&nbsp&nbsp
		<a href="sector-query.php"><span class="button is-media is-primary is-outlined mw12">Consultar Setor</span></a>&nbsp&nbsp&nbsp
		<a href="sector-update.php"><span class="button is-media is-primary is-outlined mw12">Atualizar Setor</span></a>&nbsp&nbsp&nbsp
		<a href="sector-remove.php"><span class="button is-media is-primary is-outlined mw12">Remover Setor</span></a>&nbsp&nbsp&nbsp		
	</div>	
</div>
<div class="field has-addons has-addons-centered">
	<div class="buttons">								
		<a href="permission-insert.php"><span class="button is-media is-primary is-outlined mw12">Inserir Permissão</span></a>&nbsp&nbsp&nbsp
		<a href="permission-query.php"><span class="button is-media is-primary is-outlined mw12">Consultar Permissão</span></a>&nbsp&nbsp&nbsp
		<a href="permission-update.php"><span class="button is-media is-primary is-outlined mw12">Atualizar Permissão</span></a>&nbsp&nbsp&nbsp
		<a href="permission-remove.php"><span class="button is-media is-primary is-outlined mw12">Remover Permissão</span></a>&nbsp&nbsp&nbsp		
	</div>	
</div>
<?php endif;?>

</section>
</div>
</body>
</html>
