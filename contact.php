<?php 
session_start();
include('login-check.php');
$menuConfiguracoes="is-active";
include('menu.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Reportar Bug</title>
	<link rel="shortcut icon" href="img\favicon_codechip.ico"/>
	<link rel="stylesheet" href="css/login.css" />
	<!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">-->
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
<body>
	<div>	
	<section class="section">
		<div class="container">
			<h3 class="title">Reportar Bug</h3>
		<hr>
	<main>
	<form id="form1" action="contact.php" method="POST">
		<!-- Horizontal form -->
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Nome</label>
					</div>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<input type="text" class="input" id="textInput" placeholder="Ana Clara">
							</div>
						</div>
					</div>
					<div class="field-label is-normal">
						<label class="label">Email</label>
					</div>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<input type="text" class="input" id="textInput" placeholder="anaclara@gmail.com">
							</div>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Módulo</label>
					</div>
					<div class="field-body">
						<div class="field">							
							<div class="control">
								<div class="select">
									<select name="situacao">
								<option selected="selected" value="Ativo">Dashboard</option>	
								<option value="Férias">Meta</option>
								<option value="Licença">Desempenho</option>
								<option value="Desligado">Relatório</option>
								<option value="Desligado">Configurações</option>
							</select>	
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Mensagem</label>
					</div>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<textarea class="textarea" placeholder="Relate o problema apresentado..."></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label">						
					</div>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<button type="submit" class="button is-primary">Enviar</button>
							</div>
						</div>
					</div>
				</div>		
		<!---->				
		</form>
	</main>	
</div>
</section>
</div>
</body>
</html>