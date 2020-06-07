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
	<title>Gestão de Desempenho - Consultar Meta Empresa</title>
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
	  		<?php if (isset($_POST['consultar']) == null && isset($_POST['consultarMeta']) == null) : ?>
	  		<form enctype="multipart/form-data" action="goal-company-query.php" method="POST" id="form1">
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
				$company = $cx->fetch_array();

	  		?>
	   		<form enctype="multipart/form-data" action="goal-company-query.php" method="POST" id="form2" onsubmit="return check()">
	   			<input type="input" name="id" value="<?php echo $company["ID"]; ?>" hidden>
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Meta*</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left has-icons-right" id="meta">
								<input type="text" class="input required maskMetaEmpresa" value="<?php echo $company["META"]; ?>" disabled>
								<span class="icon is-small is-left">
							   		<i class="fas fa-bullseye"></i>
							   	</span>
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
								<input type="text" class="input required maskMetaEmpresa" value="<?php echo $company["ALCANCADO"]; ?>" disabled>
								<span class="icon is-small is-left">
							   		<i class="fas fa-bullseye"></i>
							   	</span>
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
								<input type="text" class="input required maskAnoMes" value="<?php echo $company["ANO_MES"]; ?>" disabled>
								<span class="icon is-small is-left">
							   		<i class="fas fa-calendar-alt"></i>
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
								<a href="goal-company-query.php" class="button is-primary">Voltar</a>
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