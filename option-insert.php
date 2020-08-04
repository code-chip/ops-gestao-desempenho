<?php 
$menuConfiguracoes="is-active";
include('menu.php');
if($_SESSION["permissao"]==1){
	echo "<script>alert('Usuário sem permissão')</script>";
	header("Refresh:1;url=home.php");
}
else{
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
	   		<form action="option-insert.php" method="POST">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Nome:</label>
					</div>
					<div class="field-body">
						<div class="field">							
							<div class="control w24-2">
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
							<div class="control">
								<div class="select">
									<select name="opcao" class="w24-2">
										<option selected="selected" value="">Selecione</option>
										<option value="ATIVIDADE">Atividade</option>
										<option value="CARGO">Cargo</option>
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
					<div class="field-label is-normal">
						<label class="label">Status:</label>
					</div>
					<div class="field-body">
						<div class="field">							
							<div class="control">
								<div class="select">
									<select name="situacao" class="w24-2">
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
							<div class="field is-grouped">
								<div class="control">
									<button name="inserirOpcao" type="submit" class="button is-primary btn128" value="Filtrar">Inserir</button>
								</div>
								<div class="control">
									<a href="register.php" class="button is-primary btn128">Cancelar</a>
								</div>
							</div>
						</div>
					</div>
				</div>		
	     	</form>
	   	</div>
	</section>	 	
</body>
</html><?php }//ELSE - caso o usuário tenha permissão.?>