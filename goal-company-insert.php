<?php 
$menuAtivo="configuracoes";
require('menu.php');

if($_SESSION["permissao"] == 1){
	echo "<script>alert('Usuário sem permissão')</script>";
	header("Refresh:1;url=home.php");
}
else {
	if (isset($_POST["inserirMeta"]) != null){
		
		$desempenho = (trim($_POST['alcancado']) / trim($_POST['meta'])) * 100;
		
		//echo "INSERT INTO META_EMPRESA (META, ALCANCADO, DESEMPENHO, INICIO, FIM, REGISTRO) VALUES (" . trim($_POST['meta']) . ", " . trim($_POST['alcancado']) . ", " . $desempenho . "," . trim($_POST['dataInicio']) . ", '" . trim($_POST['dataFim']) . "', '" . date('%Y-%m-%d') . "',)";

		mysqli_query($phpmyadmin, "INSERT INTO META_EMPRESA (META, ALCANCADO, DESEMPENHO, INICIO, FIM, REGISTRO) VALUES (" . trim($_POST['meta']) . ", " . trim($_POST['alcancado']) . ", " . $desempenho . "," . trim($_POST['dataInicio']) . ", '" . trim($_POST['dataFim']) . "', '" . date('Y-m-d') . "');");
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
								<input type="text" class="input required" name="meta" placeholder="823900" maxlength="20" onkeypress="addLoadField('meta')" onkeyup="rmvLoadField('meta')" onblur="checkAdress(form1.meta, 'msgMetaOk','msgMetaNok')" id="inputMeta" autofocus>
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
								<input type="text" class="input required" name="alcancado" placeholder="0" maxlength="20" onkeypress="addLoadField('alcancado')" onkeyup="rmvLoadField('alcancado')" onblur="checkAdress(form1.alcancado, 'msgAlcancadoOk','msgAlcancadoNok')" id="inputAlcancado" autofocus>
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
								<input type="text" class="input required registro" name="dataInicio" placeholder="2019-11-21" maxlength="10" onkeypress="addLoadField('dataInicio')" onkeyup="rmvLoadField('dataInicio')" onblur="checkAdress(form1.dataInicio, 'msgDataInicioOk','msgDataInicioNok')" id="inputName" autofocus>
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
								<input type="text" class="input required registro" name="dataFim" placeholder="2019-12-20" maxlength="10" onkeypress="addLoadField('dataFim')" onkeyup="rmvLoadField('dataFim')" onblur="checkAdress(form1.dataFim, 'msgDataFimOk','msgDataFimNok')" id="inputDataFim" autofocus>
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
				<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet"/>
				<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.theme.css" rel="stylesheet"/>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
				<div id="msgExcluir" style="display: none">Inserir outra Meta Empresa?</div>	
	     	</form>
	     	<script type="text/javascript">
	     		function checkFormGoalCompany(form1){
	     			var inputs = document.getElementsByClassName('required');
	     			
	     			for (var x = 0 ; x < inputs.length; x++) {
	     				if (!inputs[x].value) {
	     					alert('Por favor preencha todos os campos* obrigatórios.');
	     					
	     					return false;
	     				}
	     			}
	     			
	     			return true;
	     		}
	     		function addAgain(){
				  	var msgExcluir = $("#msgExcluir");
					msgExcluir.dialog({
						modal: true,
					  	buttons: {
					    	"Sim": function () {
					      		alert("Excluido com Sucesso");
					    	  	$(this).dialog('close');
					    	},
					    	"Não": function () {
					      		$(this).dialog('close');
					      	window.location.href='metric.php';
					    	}
					  	}
					});
				}
	     	</script>
	   	</div>	   	
	</section>
</body>
</html>