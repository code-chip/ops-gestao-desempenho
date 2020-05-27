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
	<title>Gestão de Desempenho - Inserir Meta Empresa</title>
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script><!--biblioteca de icones-->
	<script type="text/javascript" src="js/myjs.js"></script>
</head>
<body>
	<section class="section">
	  	<div class="container">
	   		<form enctype="multipart/form-data" action="goal-company-insert.php" method="POST" id="form1" onsubmit="return checkFormGoalCompany(form1)">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Meta*</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left has-icons-right" id="meta">
								<input type="text" class="input required maskMetaEmpresa" name="meta" placeholder="823900" maxlength="20" onkeypress="addLoadField('meta')" onkeyup="rmvLoadField('meta')" onblur="checkAdress(form1.meta, 'msgMetaOk','msgMetaNok')" id="inputMeta" autofocus>
								<span class="icon is-small is-left">
							   		<i class="fas fa-bullseye"></i>
							   	</span>
								<div id="msgMetaNok" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">O valor da meta é obrigatório</p>		    	
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
						<label class="label">Alcançado*</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left has-icons-right" id="alcancado">
								<input type="text" class="input required maskMetaEmpresa" name="alcancado" placeholder="0" maxlength="20" onkeypress="addLoadField('alcancado')" onkeyup="rmvLoadField('alcancado')" onblur="checkAdress(form1.alcancado, 'msgAlcancadoOk','msgAlcancadoNok')" id="inputAlcancado" autofocus>
								<span class="icon is-small is-left">
							   		<i class="fas fa-bullseye"></i>
							   	</span>
								<div id="msgAlcancadoNok" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">O valor do alcançado é obrigatório, pode ser zero</p>		
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
						<label class="label">Data inicio*</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left has-icons-right" id="dataInicio">
								<input type="text" class="input required maskDataInicio" name="dataInicio" placeholder="2019-11-21" maxlength="10" onkeypress="addLoadField('dataInicio')" onkeyup="rmvLoadField('dataInicio')" onblur="checkAdress(form1.dataInicio, 'msgDataInicioOk','msgDataInicioNok')" id="inputName">
								<span class="icon is-small is-left">
							   		<i class="fas fa-calendar-alt"></i>
							   	</span>
								<div id="msgDataInicioNok" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">O data início da meta empresa é obrigatório</p>		    	
							   	</div>
							   	<div id="msgDataInicioOk" style="display:none;">
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
						<label class="label">Data fim*</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left has-icons-right" id="dataFim">
								<input type="text" class="input required maskDataFim" name="dataFim" placeholder="2019-12-20" maxlength="10" onkeypress="addLoadField('dataFim')" onkeyup="rmvLoadField('dataFim')" onblur="checkAdress(form1.dataFim, 'msgDataFimOk','msgDataFimNok')" id="inputDataFim">
								<span class="icon is-small is-left">
							   		<i class="fas fa-calendar-alt"></i>
							   	</span>
								<div id="msgDataFimNok" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">O data fim da meta empresa é obrigatório</p>		    	
							   	</div>
							   	<div id="msgDataFimOk" style="display:none;">
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