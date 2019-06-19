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
<div>
	<section class="section">
		<div class="container">
			<h3 class="title">Cadastro de Usuário</h3>
		<hr>
	<main>
		<a href="insert-user" class="button is-large is-primary is-inverted is-outlined">Cadastrar</a>
		<a href="insert-user" class="button is-large is-primary is-inverted is-outlined">Consultar</a>
		<a href="insert-user" class="button is-large is-primary is-inverted is-outlined">Atualizar</a>
		<a href="insert-user" class="button is-large is-primary is-inverted is-outlined">Remover</a>		
	</main>	
</div>
</section>
</div>


</body>
</html>
