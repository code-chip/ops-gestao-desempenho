<?php 

$menuAtivo ='configuracoes';
require('menu.php');

if ($_SESSION["permissao"] == 1) {
	echo "<script>alert('Usuário sem permissão'); window.location.href='register.php'; </script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<script type="text/javascript" src="js/myjs.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<title>Gestão de Desempenho - Atualizar Opção</title>
</head>
<body>
	<section class="section">
	<div class="container">
	<?php if (isset($_POST["queryOption"]) == null) { ?>
	   		<form id="form1" action="option-update.php" method="POST" onsubmit="return check()">
	    		<div class="field">
					<label class="label is-size-7-touch">Nome*</label>
					<div class="control has-icons-left">
						<input type="text" class="input required" name="name" autofocus>
						<span class="icon is-small is-left">
						  	<i class="fas fa-search"></i>
						</span>
					</div>
				</div>	
				<div class="field">
					<label class="label is-size-7-touch">Opção*</label>
					<div class="control has-icons-left">
						<div class="select is-fullwidth">
							<select name="option" class="required">
								<option selected="selected" value="">Selecione</option>
								<option value="ATIVIDADE">Atividade</option>
								<option value="CARGO">Cargo</option>
								<option value="PERMISSAO">Permissao</option>
								<option value="PRESENCA">Presença</option>
								<option value="SETOR">Setor</option>
								<option value="TURNO">Turno</option>
							</select>
							<span class="icon is-small is-left">
								<i class="fas fa-align-center"></i>
							</span>	
						</div>
					</div>
				</div>		
				<div class="field"></div>
					<div class="field-body">
						<div class="field is-grouped">
							<div class="control">
								<button name="queryOption" type="submit" class="button is-primary btn128" value="Filtrar">Pesquisar</button>
							</div>
							<div class="control">
								<button name="clear" type="reset" class="button is-primary btn128">Limpar</button>
							</div>
							<div class="control">
								<a href="register.php" class="button is-primary btn128">Cancelar</a>
							</div>
						</div>
					</div>
				</div>		
	     	</form>
	<?php } 

	if (isset($_POST["queryOption"]) != null) {
		$cnx = mysqli_query($phpmyadmin, "SELECT * FROM " . $_POST['option'] . " WHERE NOME LIKE '" . $_POST['name'] . "%' LIMIT 1;");
		
		if (mysqli_num_rows($cnx) == 1) { 
			$dado = $cnx->fetch_array();
			$_SESSION["idUpOption"] = $dado["ID"];
			
			?>
			<form id="form2" action="option-update.php" method="POST" onsubmit="return check()">
	    		<div class="field">
					<label class="label is-size-7-touch">Nome*</label>
					<div class="control">
						<input type="text" class="input" name="upName" value="<?php echo $dado["NOME"]?>">
					</div>
				</div>	
				<div class="field">
					<label class="label is-size-7-touch">Opção*</label>
					<div class="control has-icons-left">
						<div class="select is-fullwidth">
							<select name="upOption" class="w24-2">
								<option selected="selected" value="<?php echo $_POST['option']?>"><?php echo mb_convert_case($_POST['option'], MB_CASE_TITLE, 'UTF-8');?></option>
								<span class="icon is-small is-left">
									<i class="fas fa-align-center"></i>
								</span>
							</select>	
						</div>
					</div>
				</div>				
				<div class="field">
					<label class="label is-size-7-touch">Status*</label>
					<div class="control has-icons-left">
						<div class="select is-fullwidth">
							<select name="upSituation"><?php 
								echo "<option selected='selected' value=" . $dado["SITUACAO"] . ">" . $dado["SITUACAO"] . "</option>";
								if ($dado["SITUACAO"] == "Ativo") {
									echo "<option value='Inativo'>Inativo</option>";	
								} else { 
									echo "<option value='Ativo'>Ativo</option>";
								}
								?>																			
							</select>
							<span class="icon is-small is-left">
								<i class="fas fa-sort"></i>
							</span>	
						</div>
					</div>
				</div>				
				<div class="field">
					<div class="field-body">
						<div class="field is-grouped">
							<div class="control">	
								<button name="updateOption" type="submit" class="button is-primary btn128" value="Update">Atualizar</button>
							</div>
							<div class="control">
								<a href="register.php" class="button is-primary btn128">Voltar</a>
							</div>
							<div class="control">	
								<button name="updateOption" type="submit" class="button is-primary btn128">Cancelar</button>
							</div>
						</div>
					</div>
				</div>		
	     	</form>
			<?php			
		} else {			
			echo "<script>alert('Nenhum resultado encontrado!!'); window.location.href ='option-update.php'</script>";
		}	
	}
	
	?>  	
	   	</div>	
	</section>	 	
</body>
</html>
<?php

if (isset($_POST["updateOption"]) == "Update") {	
	$cnx = mysqli_query($phpmyadmin, "UPDATE " . $_POST['upOption'] . " SET NOME='" . $_POST['upName'] . "', SITUACAO='" . $_POST["upSituation"] . "' WHERE ID=".$_SESSION["idUpOption"]);
	
	if (mysqli_error($phpmyadmin) == null) {
		echo "<script>alert('Opção atualizada com sucesso!!')</script>";	
	} else {
		echo mysqli_error($phpmyadmin);
	}
}

?>			