<?php

$menuAtivo = 'configuracoes';
require('menu.php');

if ($_SESSION["permissao"] == 1) {
	echo "<script>alert('Usuário sem permissão'); window.location.href='home.php'; </script>";
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
	<style type="text/css">
		.button{ width: 121px; }
	</style>
</head>
<body>
	<section class="section">
	  	<div class="container">
	  		<?php if (isset($_POST['consultar']) == null && isset($_POST['atualizarMeta']) == null) : ?>
	  		<form enctype="multipart/form-data" action="goal-company-update.php" method="POST" id="form1">
	  		<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Ano/Mês:</label>
				</div>
				<div class="field-body">
					<div class="field" >							
						<div class="control has-icons-left">
							<div class="select">
								<select name="anoMes" style="width:15.9em;"><?php								
								$con = mysqli_query($phpmyadmin , "SELECT ANO_MES FROM META_EMPRESA ORDER BY ANO_MES DESC LIMIT 12;");
								while($am = $con->fetch_array()){
									echo "<option value=" . $am["ANO_MES"] . ">" . $am["ANO_MES"] . "</option>";
								} ?>	
								</select>
								<span class="icon is-small is-left">
									<i class="fas fa-calendar-alt"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label"></div>
					<div class="field-body">
						<div class="field is-grouped">
							<div class="control">
								<button name="consultar" type="submit" class="button is-primary" onClick="" value="Filtrar">Filtrar</button>
							</div>
							<div class="control">
								<a href="metric.php" class="button is-primary is-size-7-touch">Voltar</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endif; 

			if (isset($_POST['anoMes']) != null ) :
				$cx = mysqli_query($phpmyadmin , "SELECT * FROM META_EMPRESA WHERE ANO_MES ='" . trim($_POST['anoMes']) . "';");
				$weight = $cx->fetch_array();

	  		?>
	   		<form enctype="multipart/form-data" action="goal-company-insert.php" method="POST" id="form2" onsubmit="return check()">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Meta*</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left has-icons-right" id="meta">
								<input type="text" class="input required maskMetaEmpresa" name="meta" placeholder="823900" maxlength="20" onkeypress="addLoadField('meta')" onkeyup="rmvLoadField('meta')" onblur="checkAdress(form1.meta, 'msgOk1','msgNok1')" id="input1" autofocus>
								<span class="icon is-small is-left">
							   		<i class="fas fa-bullseye"></i>
							   	</span>
								<div id="msgNok1" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">O valor da Meta é obrigatório.</p>		    	
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
						<label class="label">Alcançado*</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left has-icons-right" id="alcancado">
								<input type="text" class="input required maskMetaEmpresa" name="alcancado" placeholder="0" maxlength="20" onkeypress="addLoadField('alcancado')" onkeyup="rmvLoadField('alcancado')" onblur="checkAdress(form1.alcancado, 'msgOk2','msgNok2')" id="input2" autofocus>
								<span class="icon is-small is-left">
							   		<i class="fas fa-bullseye"></i>
							   	</span>
								<div id="msgNok2" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">O valor do Alcançado é obrigatório, pode ser zero.</p>		
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
						<label class="label">Ano/Mês*</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left has-icons-right" id="anoMes">
								<input type="text" class="input required maskAnoMes" name="anoMes" placeholder="2020-06" maxlength="7" onkeypress="addLoadField('anoMes')" onkeyup="rmvLoadField('anoMes')" onblur="checkAdress(form1.anoMes, 'msgOk3','msgNok3')" id="input3">
								<span class="icon is-small is-left">
							   		<i class="fas fa-calendar-alt"></i>
							   	</span>
								<div id="msgNok3" style="display:none;">
						    	<span class="icon is-small is-right">
						      		<i class="fas fa-fw"></i>
						    	</span>
						    	<p class="help is-danger">Ano/Mês da meta empresa é obrigatório.</p>		    	
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
					</div>
					<div class="field-body">
						<div class="field is-grouped">							
							<div class="control">
								<button name="inserirMeta" type="submit" class="button is-primary" value="Filtrar">Inserir</button>
							</div>
							<div class="control">
								<button name="limpar" type="reset" class="button is-primary" value="Filtrar" onclick="clearForm()">Limpar</button>
							</div>
							<div class="control">
								<a href="metric.php" class="button is-primary">Cancelar</a>
							</div>						
						</div>
					</div>
				</div>
	     	</form>
	     	<?php endif; ?>
	   	</div>	   	
	</section>
</body>
</html>
<?php

	if (isset($_POST["inserirMeta"]) != null) {
		
		$desempenho = round((trim($_POST['alcancado']) / trim($_POST['meta'])) * 100, 2);
		
		$checkDuplic = mysqli_query($phpmyadmin, "SELECT ID FROM META_EMPRESA WHERE ANO_MES = '" . trim($_POST['anoMes']) . "';");

		$cd = $checkDuplic->fetch_array();

		if (mysqli_num_rows($checkDuplic) == 0) {

			mysqli_query($phpmyadmin, "INSERT INTO META_EMPRESA (META, ALCANCADO, DESEMPENHO, ANO_MES, REGISTRO) VALUES (" . trim($_POST['meta']) . ", " . trim($_POST['alcancado']) . ", " . $desempenho . ", '" . trim($_POST['anoMes']) . "', '" . date('Y-m-d') . "');");
			$erro = mysqli_error($phpmyadmin);
			
			if ($erro == "" && $erro == null) {
				echo "<script>alert('Meta Empresa cadastrada com sucesso!'); window.location.href='metric.php';</script>";
			} else {
				echo $erro;
				echo "<script>alert('Erro ao inserir Meta Empresa!');</script>";
			}
		} else {
			echo "<script>alert('Já existe Meta Empresa cadastrada neste Ano e Mês.'); window.location.href='goal-company-insert.php';</script>";
		}
	}
	
?>