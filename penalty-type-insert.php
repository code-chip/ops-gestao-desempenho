<?php

$menuAtivo = 'configuracoes';
require('menu.php');

if ($_SESSION["permissao"] == 1) {
	echo "<script>alert('Usuário sem permissão'); window.location.href='home.php'; </script>";
} else {
	if (isset($_POST['inserirPenalidade']) != null) {
		
			mysqli_query($phpmyadmin, "INSERT INTO PENALIDADE_TIPO (TIPO, PENALIDADE, DESCRICAO, SITUACAO) VALUES ('" . trim($_POST['tipo']) . "', " . trim($_POST['penalidade']) . ", '" . trim($_POST['descricao']) . "', '" . trim($_POST['situacao']) . "');");
			$erro = mysqli_error($phpmyadmin);
			
			if ($erro == "" && $erro == null) {
				echo "<script>alert('Penalidade cadastrada com sucesso!'); window.location.href='metric.php';</script>";
			} else {
				echo $erro;
				echo "<script>alert('Erro ao inserir Peso!');</script>";
			}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<tipo charset="UTF-8">	
	<tipo name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Inserir Tipo de Penalidade</title>
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script><!--biblioteca de icones-->
	<script type="text/javascript" src="js/myjs.js"></script>
	<style type="text/css">
		.button{ width: 121px; }
	</style>
</head>
<body>
	<section class="section">
	  	<div class="container">
	   		<form enctype="multipart/form-data" action="penalty-type-insert.php" method="POST" id="form1" onsubmit="return check()">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Tipo*</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left has-icons-right" id="tipo">
								<input type="text" class="input required" name="tipo" placeholder="Atraso" maxlength="20" onkeypress="addLoadField('tipo')" onkeyup="rmvLoadField('tipo')" onblur="checkAdress(form1.tipo, 'msgOk1','msgNok1')" id="input1" autofocus>
								<span class="icon is-small is-left">
							   		<i class="fas fa-book-reader"></i>
							   	</span>
								<div id="msgNok1" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">O tipo da penalidade é obrigatório</p>		    	
							   	</div>
							   	<div id="msgOk1" style="display:none;">
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
						<label class="label">Penalidade*</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left has-icons-right" id="penalidade">
								<input type="text" class="input required maskPeso" name="penalidade" placeholder="2%" maxlength="2" onkeypress="addLoadField('penalidade')" onkeyup="rmvLoadField('penalidade')" onblur="checkAdress(form1.penalidade, 'msgOk2','msgNok2')" id="input2">
								<span class="icon is-small is-left">
							   		<i class="fas fa-angle-double-down"></i>
							   	</span>
								<div id="msgNok2" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">O valor da penalidade é obrigatório</p>		
							   	</div>
							   	<div id="msgOk2" style="display:none;">
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
						<label class="label">Descrição*</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-right">
								<textarea name="descricao" class="textarea required" placeholder="Para cada atraso, será descontado 2% do desempenho final do funcionário." maxlenght="200" onkeypress="addLoadField('descricao')" onkeyup="rmvLoadField('descricao')" onblur="checkAdress(form1.descricao, 'msgOk3','msgNok3')" id="input3"></textarea>
								<div id="msgNok3" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">A descrição é obrigatória</p>		
							   	</div>
							   	<div id="msgOk3" style="display:none;">
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
								<button name="inserirPenalidade" type="submit" class="button is-primary" value="inserir">Inserir</button>
							</div>
							<div class="control">
								<button name="limpar" type="reset" class="button is-primary" onclick="clearForm()">Limpar</button>
							</div>
							<div class="control">
								<a href="metric.php" class="button is-primary">Cancelar</a>
							</div>						
						</div>
					</div>
				</div>
	     	</form>
	   	</div>	   	
	</section>
</body>
</html>