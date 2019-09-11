<?php 
session_start();
include('login-check.php');
$menuConfiguracoes="is-active";
include('menu.php');
$opcao=trim($_POST['opcao']);
$nome=trim($_POST['nome']);
$situacao=trim($_POST['situacao']);

if(isset($_POST["inserirOpcao"])!=null){
	if($opcao!="" && $nome!=""){
		$checkOpcao="SELECT NOME FROM ".$opcao." WHERE NOME='".$nome."';";
		$cnx= mysqli_query($phpmyadmin, $checkOpcao);
		if(mysqli_num_rows($cnx)==0){
			$inserirOpcao="INSERT INTO ".$opcao."(NOME, SITUACAO) VALUES('".$nome."','".$situacao."');";
			$cnx= mysqli_query($phpmyadmin, $inserirOpcao);
			if(mysqli_error($phpmyadmin)==null){
				echo "<script>alert('Opção cadastrada com sucesso!!')</script>";
			}
			else{
				$erro=mysqli_error($phpmyadmin);
				echo "<script>alert('Erro ".$erro."!!')</script>";
			}
		}
		else{
			echo "<script>alert('Já existe este nome cadastrado nesta opção!!')</script>";
		}	
	}
	else if($nome==""){
		echo "<script>alert('Preencher o campo nome é obrigatório!!')</script>";
	}
	else{
		echo "<script>alert('Selecionar a opção é obrigatório!!')</script>";
	}	
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Inserir Opção</title>
	<link rel="stylesheet" href="css/login.css" />
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
<body>
	<section class="section">
	  	<div class="container">
	   		<form action="option-insert.php" method="POST">
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
										<option value="SETOR">Setor</option>
										<option value="TURNO">Turno</option>										
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
									<select name="situacao">
										<option selected="selected" value="Ativo">Ativo</option>
										<option value="Inativo">Inativo</option>																			
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
									<button name="inserirOpcao" type="submit" class="button is-primary" value="Filtrar">Inserir</button>
								</div>
							</div>
						</div>
					</div>
				</div>		
	     	</form>
	   	</div>
	</section>	 	
</body>
</html>