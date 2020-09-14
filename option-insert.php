<?php

$menuAtivo = 'configuracoes';
require('menu.php');

if ($_SESSION['permissao'] == 1) {
	echo "<script>alert('Usuário sem permissão'); window.location.href='register.php'</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<script type="text/javascript" src="js/myjs.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<title>Gestão de Desempenho - Inserir Opção</title>
</head>
<body>
	<section class="section">
	  	<div class="container">
	   		<form action="option-insert.php" method="POST" onsubmit="return check()">
	    		<div class="field">
					<label class="label is-size-7-touch">Nome*</label>
					<div class="control has-icons-left">
						<input type="text" class="input required" name="nome" autofocus>
						<span class="icon is-small is-left">
						  	<i class="fas fa-search"></i>
						</span>
					</div>
				</div>	
				<div class="field">
					<label class="label is-size-7-touch">Opção*</label>
					<div class="control has-icons-left">
						<div class="select is-fullwidth">
							<select name="opcao" class="required">
								<option selected="selected" value="">Selecione</option>
								<option value="ATIVIDADE">Atividade</option>
								<option value="CARGO">Cargo</option>
								<option value="PERMISSAO">Permissao</option>
								<option value="PRESENCA">Presença</option>
								<option value="SETOR">Setor</option>
								<option value="TURNO">Turno</option>
							</select>
							<span class="icon is-small is-left">
								<i class="fas fa-align-center"></i>
							</span>	
						</div>
					</div>
				</div>				
				<div class="field">
					<label class="label is-size-7-touch">Status*</label>
					<div class="control has-icons-left">
						<div class="select is-fullwidth">
							<select name="situacao">
								<option selected="selected" value="Ativo">Ativo</option>
								<option value="Inativo">Inativo</option>																			
							</select>
							<span class="icon is-small is-left">
								<i class="fas fa-sort"></i>
							</span>	
						</div>
					</div>
				</div>				
				<div class="field">
					<div class="field-body">
						<div class="field is-grouped">
							<div class="control">
								<button name="insertOption" type="submit" class="button is-primary btn128" value="Filtrar">Inserir</button>
							</div>
							<div class="control">
								<button name="clear" type="reset" class="button is-primary btn128">Limpar</button>
							</div>
							<div class="control">
								<a href="register.php" class="button is-primary btn128">Cancelar</a>
							</div>
						</div>
					</div>
				</div>		
	     	</form>
	   	</div>
	</section>	 	
</body>
</html>
<?php 

if (isset($_POST["insertOption"]) != null) {
	
	$cnx = mysqli_query($phpmyadmin, "SELECT NOME FROM " . $_POST['opcao'] . " WHERE NOME='" . $_POST['nome'] . "';");
	
	if (mysqli_num_rows($cnx) == 0) {
		
		$cnx = mysqli_query($phpmyadmin, "INSERT INTO " . $_POST['opcao'] . "(NOME, SITUACAO) VALUES('" . $_POST['nome'] . "','" . $_POST['situacao'] . "');");
		
		if (mysqli_error($phpmyadmin) == null) {
			echo "<script>alert('Opção cadastrada com sucesso!!')</script>";
		} else {
			$erro = mysqli_error($phpmyadmin);
			echo "<script>alert('Erro " . $erro . "!!')</script>";
		}
	} else {
		echo "<script>alert('Já existe este nome cadastrado nesta opção!!')</script>";
	}	
}
?>