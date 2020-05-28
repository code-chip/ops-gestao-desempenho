<?php 
$menuAtivo = 'configuracoes';

require('menu.php');

if ($_SESSION["permissao"] == 1) {
	echo "<script>alert('Usuário sem permissão')</script>";

	header("Refresh:1;url=home.php");
} else {
	if (isset($_POST['inserirPenalidade']) != null) {
		
			mysqli_query($phpmyadmin, "INSERT INTO PENALIDADE_TIPO (TIPO, PENALIDADE, SITUACAO) VALUES (" . trim($_POST['tipo']) . ", " . trim($_POST['penalidade']) . ", '" . trim($_POST['situacao']) . "');");
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
	<script type="text/javascript">
		function check() {
			var inputs = document.getElementsByClassName('required');
			
			for (var x = 0 ; x < inputs.length; x++) {
				if(!inputs[x].value){
					alert('Preencha todos os campos * obrigatórios');
					return false;
				}
			}
		}
	</script>
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
								<input type="text" class="input required" name="tipo" placeholder="Atraso" maxlength="20" onkeypress="addLoadField('tipo')" onkeyup="rmvLoadField('tipo')" onblur="checkAdress(form1.tipo, 'msgtipoOk','msgtipoNok')" id="inputtipo" autofocus>
								<span class="icon is-small is-left">
							   		<i class="fas fa-book-reader"></i>
							   	</span>
								<div id="msgtipoNok" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">O tipo da penalidade é obrigatório</p>		    	
							   	</div>
							   	<div id="msgtipoOk" style="display:none;">
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
								<input type="text" class="input required maskPeso" name="penalidade" placeholder="2%" maxlength="2" onkeypress="addLoadField('penalidade')" onkeyup="rmvLoadField('penalidade')" onblur="checkAdress(form1.penalidade, 'msgpenalidadeOk','msgpenalidadeNok')" id="inputpenalidade" autofocus>
								<span class="icon is-small is-left">
							   		<i class="fas fa-angle-double-down"></i>
							   	</span>
								<div id="msgpenalidadeNok" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">O valor da penalidade é obrigatório</p>		
							   	</div>
							   	<div id="msgpenalidadeOk" style="display:none;">
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
								<button name="inserirPenalidade" type="submit" class="button is-primary" value="Filtrar">Inserir</button>
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