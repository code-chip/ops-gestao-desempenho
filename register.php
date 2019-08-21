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
<body>
<div class="field has-addons has-addons-centered">
	<section class="section">
	<main>
		<?php if($_SESSION["permissao"]!=1):?><div class="field">
			<div class="control">
				<a href="user-insert.php" class="button is-large is-primary is-outlined is-fullwidth">Inserir Usuário</a>
			</div>
		</div><?php endif;?>
		<div class="field">
			<div class="control">
				<a href="user-insert.php" class="button is-large is-primary is-outlined is-fullwidth">Consultar Usuário</a>
			</div>
		</div>
		<div class="field">
			<div class="control">		
				<a href="user-query.php" class="button is-large is-primary is-outlined is-fullwidth">Atualizar Usuário</a>
			</div>
		<?php if($_SESSION["permissao"]!=1):?></div>
		<div class="field">
			<div class="control">		
				<a href="user-insert.php" class="button is-large is-primary is-outlined is-fullwidth">Remover Usuário</a>
			</div>	
		</div><?php endif;?>			
	</main>	
</div>
</section>
</div>
</body>
</html>
