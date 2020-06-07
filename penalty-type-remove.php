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
	<tipo charset="UTF-8">	
	<tipo name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Remover Tipo de Penalidade</title>
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
	  		<?php if (isset($_POST['consultar']) == null && isset($_POST['removerPenalidade']) == null) : ?>
	  		<form enctype="multipart/form-data" action="penalty-type-remove.php" method="POST" id="form1">
	  		<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Tipo:</label>
				</div>
				<div class="field-body">
					<div class="field" >							
						<div class="control has-icons-left">
							<div class="select">
								<select name="penalidade" style="width:15.9em;"><?php								
								$con = mysqli_query($phpmyadmin , "SELECT ID, TIPO FROM PENALIDADE_TIPO ORDER BY TIPO;");
								while($am = $con->fetch_array()){
									echo "<option value=" . $am["ID"] . ">" . $am["TIPO"] . "</option>";
								} ?>	
								</select>
								<span class="icon is-small is-left">
									<i class="fas fa-book-reader"></i>
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

			if (isset($_POST['penalidade']) != null ) :
				$cx = mysqli_query($phpmyadmin , "SELECT * FROM PENALIDADE_TIPO WHERE ID =" . trim($_POST['penalidade']));
				$penalty = $cx->fetch_array();

	  		?>
	   		<form enctype="multipart/form-data" action="penalty-type-remove.php" method="POST" id="form2" onsubmit="return check()">
	   			<input type="input" name="id" value="<?php echo $penalty["ID"]; ?>" hidden>
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Tipo*</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:24.2em;">							
							<div class="control has-icons-left has-icons-right" id="tipo">
								<input type="text" class="input required" name="tipo" value="<?php echo $penalty["TIPO"]; ?>" disabled>
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
								<input type="text" class="input required maskPeso" name="penalidade" value="<?php echo $penalty["PENALIDADE"]; ?>" disabled>
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
								<textarea name="descricao" class="textarea required" disabled><?php echo $penalty["DESCRICAO"]; ?></textarea>
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
									<select name="situacao" style="width:24.2em;" disabled><?php
										if($penalty["SITUACAO"] == 's' ) { 
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
								<button name="removerPenalidade" type="submit" class="button is-primary" value="inserir">Remover</button>
							</div>
							<div class="control">
								<a href="penalty-type-remove.php" class="button is-primary">Voltar</a>
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

if (isset($_POST['removerPenalidade']) != null) {
		
	mysqli_query($phpmyadmin, "DELETE FROM PENALIDADE_TIPO WHERE ID= " . trim($_POST['id']));
	$erro = mysqli_error($phpmyadmin);
			
	if ($erro == "" && $erro == null) {
		echo "<script>alert('Penalidade removida com sucesso!'); window.location.href='metric.php'; </script>";
	} else {
		echo $erro;
		echo "<script>alert('Erro ao remover Penalidade, tente novamente!'); window.location.href='penalty-type-remove.php'; </script>";
	}

}

?>