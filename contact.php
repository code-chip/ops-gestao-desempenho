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
	<form id="form1" action="user-insert.php" method="POST">
		<div class="field is-grouped">
		<div class="field">
			<label class="label" for="textInput">Nome</label>
				<div class="control">
					<input name="nome" type="text" class="input" id="textInput" placeholder="Ana Clara" maxlength="60">
				</div>			
		</div>		
		<div class="field">
		  	<label class="label">Email</label>
		  	<div class="control has-icons-left has-icons-right">
		    	<input name="email" class="input is-danger" type="text" placeholder="anaclara@gmail.com" value="" onblur="validacaoEmail(form1.email)"  maxlength="60" size='65'>
		    	<span class="icon is-small is-left">
		      		<i class="fas fa-envelope"></i>
		    	</span>
		    	<span class="icon is-small is-right">
		      		<i class="fas fa-exclamation-triangle"></i>
		    	</span>		    	
		    	<div id="msgemail"></div>
		  	</div>
		  	<p class="help is-danger">E-mail inválido</p>
		</div>
	</div>
			<div class="field-label"><!--DIVISÃO SITUAÇÃO-->
				<label class="label">Módulo</label>
			</div>
			<div class="field-body">
				<div class="field is-grouped">							
					<div class="control">
						<div class="select">
							<select name="situacao">
								<option selected="selected" value="Ativo">Dashboard</option>	
								<option value="Férias">meta</option>
								<option value="Licença">Desempenho</option>
								<option value="Desligado">Relatórios</option>
								<option value="Desligado">Configurações</option>
							</select>	
						</div>
					</div>					
				</div>						
			</div>
		</div><!--FINAL DIVISÃO EM HORIZONTAL 2-->	
		<!---->					
		<div class="field">
			<label class="label" for="observacao">Observação</label>
				<div class="control">
					<input name="observacao" type="text" class="input" id="textInput" placeholder="Exemplo: funcionário terceirizado da empresa MWService..." maxlength="60">
				</div>			
		</div>
		<div class="field-body">
			<div class="field is-grouped">											
				<div class="control">
					<a href="register.php" class="button is-primary">Voltar</a>										
				</div>
				<div class="control">
					<a href="user-insert.php"><input name="limpar" type="submit" class="button is-primary" value="Limpar"/></a>
				</div>
				<div class="control">
					<input name="cadastrar" type="submit" class="button is-primary" value="Cadastrar"/>
				</div>					
			</div>
		</div>							
		</form>
	</main>	
</div>
</section>
</div>
</body>
</html>