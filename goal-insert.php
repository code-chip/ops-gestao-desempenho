<?php 
$menuConfiguracoes="is-active";
include('menu.php');
$opcao=trim($_POST['opcao']);
$nome=trim($_POST['nome']);
$situacao=trim($_POST['situacao']);

if(isset($_POST["inserirMeta"])!=null){
	if($opcao!="" && $nome!=""){
		$checkMeta="SELECT NOME FROM ".$opcao." WHERE NOME='".$nome."';";
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
	<title>Gestão de Desempenho - Inserir Meta</title>
	<link rel="stylesheet" href="css/login.css" />
	<link rel="stylesheet" href="css/bulma.min.css"/>
	<script defer scr="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
<body>
	<section class="section">
	  	<div class="container">
	  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	   		<form action="goal-insert.php" method="POST">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Meta:</label>
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
						<label class="label">Atividade:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="atividade[]">
									<?php $gdAtividade="SELECT ID, NOME FROM ATIVIDADE WHERE SITUACAO='Ativo' AND ID NOT IN(1,2,3,4) ORDER BY NOME";
									$con = mysqli_query($phpmyadmin , $gdAtividade); $x=0; 
									while($atividade = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x] = $atividade["ID"]; ?>"><?php echo $vtNome[$x] = $atividade["NOME"]; ?></option>
									<?php $x;} endwhile;?>
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Descrição:</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:17em;">							
							<div class="control">
								<textarea class="textarea"></textarea>
							</div>						
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Colaborador:</label>
					</div>
					<div class="field-body">
						<div class="field is-grouped" style="max-width:17em;">							
							<div class="control">
								<div class="select">
									<select name="situacao">
										<option selected="selected" value="Ativo">Todos</option>
										<?php $gdAtividade="SELECT ID, NOME FROM USUARIO WHERE SETOR_ID IN(3,4,5,8) AND SITUACAO<>'Desligado' ORDER BY NOME;";
									$con = mysqli_query($phpmyadmin , $gdAtividade); $x=0; 
									while($atividade = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x] = $atividade["ID"]; ?>"><?php echo $vtNome[$x] = $atividade["NOME"]; ?></option>
									<?php $x;} endwhile;?>																		
									</select>	
								</div>
							</div>
						</div>
					</div>					
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Expiração:</label>
					</div>
					<div class="field-body">
						<div class="field is-grouped" style="max-width:17em;">							
							<div class="control">
								<input style="max-width:12.5em;" class="input registro" type="text" name="expiracao" value="<?php echo date('Y-m-d',strtotime('-1 day'))?>">
							</div>
							<div class="control">
									<button name="inserirMeta" type="submit" class="button is-primary" value="Filtrar">Inserir</button>
								</div>						
						</div>
					</div>					
				</div>
	     	</form>
	   	</div>
	</section>	 	
</body>
</html>