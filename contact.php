<?php 
$menuConfiguracoes="is-active";
include('menu.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Reportar Bug</title>
</head>
<body>
	<div>	
	<section class="section">
		<div class="container">
			<h3 class="title">Reportar Bug</h3>
		<hr>
	<main>
	<form id="form1" action="contact.php" method="POST">
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
				<label class="label">E-mail</label>
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
			<div class="field-label is-normal">
				<label class="label">Prioridade</label>
			</div>
			<div class="field-body">
				<div class="field">							
					<div class="control">
						<div class="select">
							<select name="situacao">
								<option selected="selected" value="Ativo">Baixa</option>	
								<option value="Férias">Normal</option>
								<option value="Licença">Alta</option>
								<option value="Desligado">Urgente</option>
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
		</form>
	</main>
</div>
</section>
</div>
</body>
</html>