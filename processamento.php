<?php 
session_start();
include('verifica_login.php');
header('Content-Type: text/html; charset=UTF-8');
//print_r($_SESSION);exit();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Sistema Logístico</title>
	<link rel="shortcut icon" href="img\favicon_codechip.ico"/>
	<link rel="stylesheet" href="css/personal.css" />
	<!--<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">-->
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
<body>
	<header>
		<nav class="navbar is-primary">
			<div class="container">
				<div class="navbar-brand">
					<a class="navbar-item" href="#" style="font-weight:bold;">FastLog</a>
					<span class="navbar-burger burger" data-target="navMenu">
						<span></span>
						<span></span>
						<span></span>
					</span>	
				</div>
				<div id="navMenu" class="navbar-menu">
					<div class="navbar-end">
						<a href="#" class="navbar-item">Início</a>
						<a href="#" class="navbar-item is-active">Processamento</a>
						<a href="#" class="navbar-item">Gerenciamento</a>
						<a href="#" class="navbar-item">Configuraçoes</a>
						<a href="logout.php" class="navbar-item">Sair</a>
					</div>
				</div>
			</div>
		</nav>
		<script type="text/javascript">
			(function(){
				var burger = document.querySelector('.burger');
				var nav = document.querySelector('#'+burger.dataset.target);

				burger.addEventListener('click', function(){
					burger.classList.toggle('is-active');
					nav.classList.toggle('is-active');
				});
			})();
		</script>
	</header>
	<section class="section">
		<div class="container">
			<h3 class="title">Processamento</h3>
			<hr>
			<main>
				<form>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">UMA</label>
					</div>
					<div class="field-body">
						<div class="field is-grouped">							
							<div class="control">
								<div class="select">
									<select>
										<option value=""></option>
										<option value="1">201900072</option>
										<option value="2">201900073</option>
										<option value="3">201900074</option>
										<option value="4">201900075</option>
									</select>	
								</div>
							</div>
						</div>
					</div>
					<!--SELEÇÃO ONDA-->
					<div class="field-label is-normal">
						<label class="label">Onda</label>
					</div>
					<div class="field-body">
						<div class="field is-grouped">							
							<div class="control">
								<div class="select">
									<select>
										<option value=""></option>
										<option value="1">62146</option>
										<option value="2">62147</option>
										<option value="3">62148</option>
										<option value="4">62149</option>
									</select>	
								</div>
							</div>
							<div class="control">
					<button type="submit" class="button is-primary">Processar</button>
					</div>
						</div>						
					</div>
					
					<div class="control">
						<input type="text" class="input" id="textInput" placeholder="Transportadora">
					</div>
				</div>
				</form>
				<div class="field is-horizontal">
				</div>
				<!--BIPAGEM DE NF E/daOU VOLUME-->
				<div class="field is-horizontal">
					<div class="field-label is-large">
						<label class="label">Barcode NF:</label>
					</div>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<input type="text" class="textarea is-large" id="textInput" placeholder="3456789">
							</div>
						</div>
					</div>				
					<div class="field-label is-large">
						<label class="label">Barcode Volume:</label>
					</div>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<input type="text" class="textarea is-large" id="textInput" style=".textarea{font:20px;}" placeholder="1739251900024600345678900010003">
							</div>
						</div>
					</div>
				</div>
				<!--FIM BIPAGEM DE NF E/OU VOLUME-->
				<table class='table is-striped is-fullwidth'>	
					<tr>
						<th>Nota Fiscal</th>
						<th>Bipados</th>
						<th>Total de Volumes</th>		
						<th>Onda</th>
						<th>Transportadora</th>							
						<th>UMAA</th>			
					</tr>
					<?php for( $i = 0; $i < 10; $i++ ) : ?>	
					<tr>
						<td><?php echo 3456602+$i?></td>
						<td>1</td>						
						<td>0001</td>				
						<td>63675</td>
						<td>CARRIERS</td>
						<td>201900072</td>								
					</tr>
					<?php endfor; ?>
				</table>
				<div class="field is-grouped is-grouped-multiline">
					<div class="control">
						<button type="submit" class="button">Fechar ONDA</button>
					</div>
					<div class="control">
						<button type="submit" class="button">Fechar UMA</button>
					</div>
					<div class="control">
						<button type="submit" class="button">Imprimir Espelho UMA</button>
					</div>
				</div>
				<!--AÇÕES DE TRATAMENTO-->
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">REABRIR UMA</label>
					</div>				
					<div class="field-body">
						<div class="field is-grouped">							
							<div class="control">
								<div class="select">
									<select>
										<option value=""></option>
										<option value="1">201900072</option>
										<option value="2">201900073</option>
										<option value="3">201900074</option>
										<option value="4">201900075</option>
									</select>	
								</div>
								<p class="help">Para dar continuidade no processamento de onda já encerrada, contate o Administrador do sistema.</p>
							</div>
						</div>
					</div>				
				<!-- Informações da onda em processamento -->				
					<div class="field-label is-normal">
						<label class="label">Total de Volumes Onda</label>
					</div>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<input type="text" class="input" id="textInput" placeholder="Text input">
							</div>
						</div>
					</div>
					<div class="field-label is-normal">
						<label class="label">Bipados na Onda</label>
					</div>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<input type="text" class="input is-large" id="textInput" placeholder="Text input">
							</div>
						</div>
					</div>
					<div class="field-label is-normal">
						<label class="label">Pendente</label>
					</div>
					<div class="field-body">
						<div class="field">
							<div class="control">
								<input type="text" class="input is-large" id="textInput" placeholder="Text input">
							</div>
						</div>
					</div>
				</div>							
			</main>
			</hr>
		<div><!--container-->
	</section>
</body>	