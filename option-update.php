<?php 
$menuConfiguracao="is-active";
include('menu.php');
$opcao=trim($_POST['opcao']);
$nome=trim($_POST['nome']);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Atualizar Opção</title>
	<link rel="stylesheet" href="css/login.css" />
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
<body>
	<section class="section">
	  	<div class="container">
	  		<?php if(isset($_POST["consultarOpcao"])==null):{?>
	   		<form id="form1" action="option-update.php" method="POST">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Nome:</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:17em;">							
							<div class="control">
								<input type="text" class="input" name="nome">
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
							<div class="control" style="max-width:17em;">
								<div class="select">
									<select name="opcao">
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
							<div class="field">
								<div class="control">
									<button name="voltar" class="button is-primary" value="Voltar"><a href="register.php">Voltar</a></button>
									<button name="consultarOpcao" type="submit" class="button is-primary" value="Filtrar">Consultar</button>
								</div>
							</div>
						</div>
					</div>
				</div>		
	     	</form>
	     <?php }endif;?>
<?php if(isset($_POST["consultarOpcao"])!=null){
	if($opcao!="" && $nome!=""){
		$consulta="SELECT * FROM ".$opcao." WHERE NOME LIKE '".$nome."%' LIMIT 1;";
		$cnx= mysqli_query($phpmyadmin, $consulta);
		if(mysqli_num_rows($cnx)==1){
			$dado= $cnx->fetch_array();
			$_SESSION["idUpOpcao"]=$dado["ID"];
			?>
			<form id="form2" action="option-update.php" method="POST">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Nome:</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:17em;">							
							<div class="control">
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
							<div class="control" style="max-width:17em;">
								<div class="select">
									<select name="upOpcao">
										<option selected="selected" value="<?php echo $opcao?>"><?php echo mb_convert_case($opcao, MB_CASE_TITLE, 'UTF-8');?></option>
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
						<div class="field" style="max-width:17em;">							
							<div class="control">
								<div class="select">
									<select name="upSituacao">
										<option selected="selected" value="<?php echo $dado["SITUACAO"]?>"><?php echo $dado["SITUACAO"]?></option>
										<?php if($dado["SITUACAO"]=="Ativo"):?>
										<option value="Inativo">Inativo</option>
										<?php endif; if($dado["SITUACAO"]=="Inativo"):?>
										<option value="Ativo">Ativo</option>
										<?php endif;?>																			
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
									<button name="voltar" class="button is-primary" value="Voltar">Voltar</button>
								</div>
								<div class="control">	
									<button name="inserirOpcao" type="submit" class="button is-primary" value="Filtrar">Atualizar</button>
								</div>
							</div>
						</div>
					</div>
				</div>		
	     	</form>
			<?php			
		}
		else{			
			?><script>alert('Nenhum resultado encontrado!!')
			window.location.href ="option-update.php"</script><?php
		}	
	}
	else if($nome==""){
		?><script>alert('Preencher o campo nome é obrigatório!!')
			window.location.href ="option-update.php"</script><?php
	}
	else{
		?><script>alert('Selecionar a opção é obrigatório!!')
			window.location.href ="option-update.php"</script><?php
	}		
}
?>  	
	   	</div>	
	</section>	 	
</body>
</html>
<?php 
if(isset($_POST["inserirOpcao"])=="Filtrar"){	
	$upOpcao=trim($_POST['upOpcao']);
	$upNome=trim($_POST['upNome']);
	$upSituacao=trim($_POST["upSituacao"]);
	$updateOpcao="UPDATE ".$upOpcao." SET NOME='".$upNome."', SITUACAO='".$upSituacao."' WHERE ID=".$_SESSION["idUpOpcao"];
	$cnx=mysqli_query($phpmyadmin, $updateOpcao);
	if(mysqli_error($phpmyadmin)==null){
		echo "<script>alert('Opção atualizada com sucesso!!')</script>";	
	}
	else{
		echo mysqli_error($phpmyadmin);
	}
}
?>			