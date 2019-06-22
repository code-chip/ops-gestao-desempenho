<?php
session_start();
include('conexao.php');
//require_once('js/loader.js');
include('verifica_login.php');
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
	<title>Gestão de Desempenho - Cadastro</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>    
</head>
<body>
<div class="field has-addons has-addons-centered">
	<section class="section">
	<main>
		<div class="field">
			<div class="control">
				<a href="user-insert.php" class="button is-large is-primary is-inverted is-outlined is-fullwidth">Inserir Usuário</a>
			</div>
		</div>
		<div class="field">
			<div class="control">
				<a href="user-insert.php" class="button is-large is-primary is-inverted is-outlined is-fullwidth">Consultar Usuário</a>
			</div>
		</div>
		<div class="field">
			<div class="control">		
				<a href="user-insert.php" class="button is-large is-primary is-inverted is-outlined is-fullwidth">Atualizar Usuário</a>
			</div>
		</div>
		<div class="field">
			<div class="control">		
				<a href="user-insert.php" class="button is-large is-primary is-inverted is-outlined is-fullwidth">Remover Usuário</a>
			</div>	
		</div>			
	</main>	
</div>
</section>
</div>
</body>
</html>
