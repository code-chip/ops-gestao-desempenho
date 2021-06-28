<?php 

$menuAtivo = 'configuracoes';
require('menu.php');

if ($_SESSION["permissao"] == 1) {
	echo "<script>alert('Usuário sem permissão'); window.location.href='home.php'; </script>";
} 

?><!DOCTYPE html>
<html>
<head>
	<empresa charset="UTF-8">	
	<empresa name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Consultar Peso da Meta</title>
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
	  		<?php if (isset($_POST['consultar']) == null && isset($_POST['atualizarPeso']) == null) : ?>
	  		<form enctype="multipart/form-data" action="goal-weight-query.php" method="POST" id="form1">
	  		<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Ano/Mês:</label>
				</div>
				<div class="field-body">
					<div class="field" style="max-width:17em;">							
						<div class="control has-icons-left">
							<div class="select">
								<select name="anoMes" style="width:15.9em;"><?php								
								$con = mysqli_query($phpmyadmin , "SELECT ANO_MES FROM META_PESO ORDER BY ANO_MES DESC LIMIT 12;");
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
				$cx = mysqli_query($phpmyadmin , "SELECT * FROM META_PESO WHERE ANO_MES ='" . trim($_POST['anoMes']) . "';");
				$weight = $cx->fetch_array();

	  		?></form>	
	   		<form enctype="multipart/form-data" action="goal-weight-query.php" method="POST" id="form2" onsubmit="return check()">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Empresa*</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left has-icons-right" id="empresa">
								<input type="text" class="input required maskPeso" name="empresa" placeholder="30%" maxlength="2" value="<?php echo $weight["EMPRESA"]; ?>" disabled>
								<span class="icon is-small is-left">
							   		<i class="fas fa-balance-scale"></i>
							   	</span>
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
								<input type="text" class="input required maskPeso" name="funcionario" placeholder="70%" maxlength="2" value="<?php echo $weight["OPERADOR"]; ?>" disabled>
								<span class="icon is-small is-left">
							   		<i class="fas fa-weight-hanging"></i>
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
								<input type="text" class="input required maskAnoMes" name="anoMes" placeholder="2020-06" maxlength="7" value="<?php echo $weight["ANO_MES"]; ?>" disabled>
								<span class="icon is-small is-left">
							   		<i class="fas fa-calendar-alt"></i>
							   	</span>
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
									<select name="situacao" style="width:24.2em;" disabled><?php
										if($weight["SITUACAO"] == 's' ) { 
											echo "<option selected='selected' value='s'>Ativo</option>";
											echo "<option value='n'>Inativo</option>";
										} else {
											echo "<option selected='selected' value='n'>Inativo</option>";
											echo "<option value='s'>Ativo</option>";
										}																			
									?></select>	
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
								<a href="goal-weight-query.php" class="button is-primary is-size-7-touch">Voltar</a>
							</div>
							<div class="control">
								<a href="metric.php" class="button is-primary is-size-7-touch">Cancelar</a>
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