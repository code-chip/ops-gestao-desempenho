<?php 
$menuAtivo = 'configuracoes';

require('menu.php');

if ($_SESSION["permissao"] == 1) {
	echo "<script>alert('Usuário sem permissão')</script>";
	header("Refresh:1;url=home.php");
} else {
	if (isset($_POST["inserirempresa"]) != null) {
		
		$checkDuplic = mysqli_query($phpmyadmin, "SELECT ID FROM META_PESO;");

		$cd = $checkDuplic->fetch_array();

		if (mysqli_num_rows($checkDuplic) == 0) {

			mysqli_query($phpmyadmin, "INSERT INTO META_PESO (EMPRESA, OPERADOR, SITUACAO) VALUES (" . trim($_POST['empresa']) . ", " . trim($_POST['funcionario']) . ", '" . trim($_POST['situacao']) . "');");
			$erro = mysqli_error($phpmyadmin);
			
			if ($erro == "" && $erro == null) {
				echo "<script>alert('Peso cadastrada com sucesso!'); window.location.href='metric.php';</script>";
			} else {
				echo $erro;
				echo "<script>alert('Erro ao inserir Peso!');</script>";
			}
		} else {
			echo "<script>alert('Já existe Peso cadastrado.'); window.location.href='metric.php';</script>";
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<empresa charset="UTF-8">	
	<empresa name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Inserir empresa</title>
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script><!--biblioteca de icones-->
	<script type="text/javascript" src="js/myjs.js"></script>
</head>
<body>
	<section class="section">
	  	<div class="container">
	   		<form enctype="multipart/form-data" action="goal-weight-insert.php" method="POST" id="form1" onsubmit="return checkFormGoalCompany(form1)">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Empresa*</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left has-icons-right" id="empresa">
								<input type="text" class="input required maskPeso" name="empresa" placeholder="30" maxlength="2" onkeypress="addLoadField('empresa')" onkeyup="rmvLoadField('empresa')" onblur="checkAdress(form1.empresa, 'msgempresaOk','msgempresaNok')" id="inputempresa" autofocus>
								<span class="icon is-small is-left">
							   		<i class="fas fa-balance-scale"></i>
							   	</span>
								<div id="msgempresaNok" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">O empresa da empresa empresa é obrigatório</p>		    	
							   	</div>
							   	<div id="msgempresaOk" style="display:none;">
							    	<span class="icon is-small is-right">
							      		<i class="fas fa-check"></i>
							    	</span>
							   	</div>
							</div>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Funcionário*</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left has-icons-right" id="funcionario">
								<input type="text" class="input required maskPeso" name="funcionario" placeholder="70" maxlength="2" onkeypress="addLoadField('funcionario')" onkeyup="rmvLoadField('funcionario')" onblur="checkAdress(form1.funcionario, 'msgfuncionarioOk','msgfuncionarioNok')" id="inputfuncionario" autofocus>
								<span class="icon is-small is-left">
							   		<i class="fas fa-weight-hanging"></i>
							   	</span>
								<div id="msgfuncionarioNok" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">O empresa da empresa funcionário é obrigatório</p>		
							   	</div>
							   	<div id="msgfuncionarioOk" style="display:none;">
							    	<span class="icon is-small is-right">
							      		<i class="fas fa-check"></i>
							    	</span>
							   	</div>
							</div>
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Situação*</label>
					</div>
					<div class="field-body">
						<div class="field is-grouped">							
							<div class="control has-icons-left">
								<div class="select">
									<select name="situacao" style="width:24.2em;">
										<option selected="selected" value="s">Ativo</option>
										<option value="n">Inativo</option>																			
									</select>	
								</div>
								<span class="icon is-small is-left">
									<i class="fas fa-sort"></i>
								</span>
							</div>
						</div>
					</div>
				</div>	
				<div class="field is-horizontal">
					<div class="field-label is-normal">
					</div>
					<div class="field-body">
						<div class="field is-grouped">							
							<div class="control">
								<button name="inserirempresa" type="submit" class="button is-primary" value="Filtrar">Inserir</button>
							</div>
							<div class="control">
								<button name="limpar" type="submit" class="button is-primary" value="Filtrar" onclick="addAgain()">Limpar</button>
							</div>
							<div class="control">
								<a href="metric.php" class="button is-primary">Voltar</a>
							</div>						
						</div>
					</div>
				</div>
	     	</form>
	   	</div>	   	
	</section>
</body>
</html>