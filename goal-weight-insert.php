<?php 
$menuAtivo="configuracoes";
require('menu.php');

if ($_SESSION["permissao"] == 1) {
	echo "<script>alert('Usuário sem permissão')</script>";
	header("Refresh:1;url=home.php");
}
else {
	if (isset($_POST["inserirMeta"]) != null) {
		
		$desempenho = (trim($_POST['alcancado']) / trim($_POST['meta'])) * 100;
		$desempenho = round($desempenho, 2);
		
		$checkDuplic = mysqli_query($phpmyadmin, "SELECT ID FROM META_EMPRESA WHERE INICIO = '" . trim($_POST['dataInicio']) . "' AND FIM = '" . trim($_POST['dataFim']) . "' ");

		$cd = $checkDuplic->fetch_array();

		if (mysqli_num_rows($checkDuplic) == 0) {

			mysqli_query($phpmyadmin, "INSERT INTO META_EMPRESA (META, ALCANCADO, DESEMPENHO, INICIO, FIM, REGISTRO) VALUES (" . trim($_POST['meta']) . ", " . trim($_POST['alcancado']) . ", " . $desempenho . ", '" . trim($_POST['dataInicio']) . "', '" . trim($_POST['dataFim']) . "', '" . date('Y-m-d') . "');");
			$erro = mysqli_error($phpmyadmin);
			
			if ($erro == "" && $erro == null) {
				echo "<script>alert('Meta Empresa cadastrada com sucesso!'); window.location.href='metric.php';</script>";
			} else {
				echo $erro;
				echo "<script>alert('Erro ao inserir Meta Empresa!');</script>";
			}
		} else {
			echo "<script>alert('Já existe Meta Empresa cadastrada nesta Data Início e Fim.'); window.location.href='goal-company-insert.php';</script>";
		}
	}
	
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Inserir Peso</title>
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
							<div class="control has-icons-left has-icons-right" id="meta">
								<input type="text" class="input required numero" name="meta" placeholder="30" maxlength="2" onkeypress="addLoadField('meta')" onkeyup="rmvLoadField('meta')" onblur="checkAdress(form1.meta, 'msgMetaOk','msgMetaNok')" id="inputMeta" autofocus>
								<span class="icon is-small is-left">
							   		<i class="fas fa-balance-scale"></i>
							   	</span>
								<div id="msgMetaNok" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">O peso da meta empresa é obrigatório</p>		    	
							   	</div>
							   	<div id="msgMetaOk" style="display:none;">
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
							<div class="control has-icons-left has-icons-right" id="alcancado">
								<input type="text" class="input required numero" name="alcancado" placeholder="70" maxlength="2" onkeypress="addLoadField('alcancado')" onkeyup="rmvLoadField('alcancado')" onblur="checkAdress(form1.alcancado, 'msgAlcancadoOk','msgAlcancadoNok')" id="inputAlcancado" autofocus>
								<span class="icon is-small is-left">
							   		<i class="fas fa-weight-hanging"></i>
							   	</span>
								<div id="msgAlcancadoNok" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">O peso da meta funcionário é obrigatório</p>		
							   	</div>
							   	<div id="msgAlcancadoOk" style="display:none;">
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
								<button name="inserirMeta" type="submit" class="button is-primary" value="Filtrar">Inserir</button>
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