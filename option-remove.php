<?php 

$menuAtivo = 'configuracoes';
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
	<title>Gestão de Desempenho - Remover Opção</title>
	<link rel="stylesheet" href="css/login.css" />
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	<script type="text/javascript" src="js/myjs.js"></script>
	<link rel="stylesheet" type="text/css" href="/css/personal.css">
    <style type="text/css">
    	.w24-2{
    		width:24.2em;
    	}
    </style>
</head>
<body>
	<section class="section">
	  	<div class="container">
	  	<?php if(isset($_POST["queryOption"]) == null) :{?>
	   		<form id="form1" action="option-remove.php" method="POST">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Nome*</label>
					</div>
					<div class="field-body">
						<div class="field">							
							<div class="control w24-2">
								<input type="text" class="input required" name="name">
							</div>
						</div>
					</div>
				</div>	
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Opção*</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control">
								<div class="select">
									<select name="option" class="w24-2 required">
										<option selected="selected" value="">Selecione</option>
										<option value="ATIVIDADE">Atividade</option>
										<option value="CARGO">Cargo</option>
										<option value="GESTOR">Gestor</option>
										<option value="PERMISSAO">Permissao</option>
										<option value="PRESENCA">Presença</option>
										<option value="SETOR">Setor</option>
										<option value="TURNO">Turno</option>										
									</select>	
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
									<button name="queryOption" type="submit" class="button is-primary btn128" value="Filtrar">Consultar</button>
								</div>
								<div class="control">
									<button name="voltar" type="submit" class="button is-primary btn128">Voltar</button>
								</div>
								<div class="control">
									<a href="register.php" class="button is-primary btn128">Cancelar</a>
								</div>
							</div>
						</div>
					</div>
				</div>		
	     	</form>
	     <?php } endif;

		if(isset($_POST["queryOption"]) != null) {
			$cnx = mysqli_query($phpmyadmin, "SELECT * FROM ".$_POST['option']." WHERE NOME LIKE '".$_POST['name']."%' LIMIT 1;");
			
			if (mysqli_num_rows($cnx) == 1) {
				$dado = $cnx->fetch_array();
				$_SESSION["idUpOpcao"] = $dado["ID"];
			
			?>
			<form id="form2" action="option-remove.php" method="POST">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Nome:</label>
					</div>
					<div class="field-body">
						<div class="field">							
							<div class="control w24-2">
								<input type="text" class="input" name="upNome" value="<?php echo $dado["NOME"]?>">
							</div>
						</div>
					</div>
				</div>	
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Opção:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control">
								<div class="select">
									<select name="upOpcao" class="w24-2">
										<option selected="selected" value="<?php echo $_POST['option'];?>"><?php echo mb_convert_case($_POST['option'], MB_CASE_TITLE, 'UTF-8');?></option>
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>				
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Status:</label>
					</div>
					<div class="field-body">
						<div class="field">							
							<div class="control">
								<div class="select">
									<select name="upSituacao" class="w24-2"><?php 
										echo "<option selected='selected' value=" . $dado["SITUACAO"] . ">" . $dado["SITUACAO"] . "</option>";
										if ($dado["SITUACAO"] == "Ativo") {
											echo "<option value='Inativo'>Inativo</option>";	
										} else { 
											echo "<option value='Ativo'>Ativo</option>";
										}
										?>																			
									</select>	
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
									<button name="removeOption" type="submit" class="button is-primary btn128" value="Remover">Remover</button>
								</div>
								<div class="control">
									<button name="back" type="submit" class="button is-primary btn128">Voltar</button>
								</div>
								<div class="control">
									<a href="register.php" class="button is-primary btn128" >Cancelar</a>
								</div>
							</div>
						</div>
					</div>
				</div>		
	     	</form>
			<?php			
			}
			else{			
				echo "<script>alert('Nenhum resultado encontrado!!'); window.location.href ='option-remove.php'</script>";
			}	
		}

		?>  	
	   	</div>	
	</section>	 	
</body>
</html>
<?php

if (isset($_POST["removeOption"]) == "Remover") {
	$cnx = mysqli_query($phpmyadmin, "DELETE FROM  ".$_POST['upOpcao']." WHERE ID=".$_SESSION["idUpOpcao"]);
	
	if (mysqli_error($phpmyadmin) == null) {
		echo "<script>alert('Opção removida com sucesso!!')</script>";
		$_SESSION["idUpOpcao"] = null;	
	} else {
		echo mysqli_error($phpmyadmin);
	}
}

?>			