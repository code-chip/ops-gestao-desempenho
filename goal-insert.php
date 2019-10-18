<?php 
$menuMeta="is-active";
include('menu.php');
$meta=trim($_POST['meta']);
$atividade=trim($_POST['atividade']);
$setor=trim($_POST['setor']);
$descricao=trim($_POST['descricao']);
$usuario=trim($_POST['usuario']);
$expiracao=trim($_POST['expiracao']);

if(isset($_POST["inserirMeta"])!=null){
	if($meta!="" && $descricao!="" && $expiracao!=""){
		if($usuario=="Todos"){
			$listIds="SELECT ID FROM USUARIO WHERE SETOR_ID=".$setor.";";
			$cnx= mysqli_query($phpmyadmin, $listIds);
			while ($idUsuario= $cnx->fetch_array()) {
				$inserirMeta="INSERT INTO META(META, ATIVIDADE_ID, SETOR_ID, DESCRICAO, USUARIO_ID, EXPIRACAO, CADASTRO_EM, DESEMPENHO) VALUES(".$meta.",".$atividade.",".$setor.",'".$descricao."',".$idUsuario["ID"].",'".$expiracao."','".date('Y-m-d')."',0);";
				$cx= mysqli_query($phpmyadmin, $inserirMeta);
			}			
		}
		else{
			$inserirMeta="INSERT INTO META(META, ATIVIDADE_ID, SETOR_ID, DESCRICAO, USUARIO_ID, EXPIRACAO, CADASTRO_EM, DESEMPENHO) VALUES(".$meta.",".$atividade.",".$setor.",'".$descricao."',".$usuario.",'".$expiracao."','".date('Y-m-d')."',0);";			
			$cnx= mysqli_query($phpmyadmin, $inserirMeta);
			echo "<script>alert('Meta's cadastrada com sucesso!!')</script>";
		}
		$erro=mysqli_error($phpmyadmin);
		if($erro==null){
			echo "<script>alert('Meta cadastrada com sucesso!!')</script>";	
		}
		else{
			?><script>var erro="<?php echo $erro;?>";  alert('Erro ao cadastrar: '+erro)</script><?php
		}
	}
	else if($meta==""){
		echo "<script>alert('Preencher o campo Meta é obrigatório!!')</script>";
	}
	else if($descricao==""){
		echo "<script>alert('Preencher o campo Descricao é obrigatório!!')</script>";
	}
	else{
		echo "<script>alert('Preencher o campo Expiração é obrigatório!!')</script>";
	}	
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Inserir Meta</title>
</head>
<body>
	<section class="section">
	  	<div class="container">
	   		<form action="goal-insert.php" method="POST">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Meta:</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:17em;">							
							<div class="control">
								<input type="text" class="input desempenho" name="meta">
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
									<select name="atividade">
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
						<label class="label">Setor:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="setor">
									<?php $gdSetor="SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo' AND ID NOT IN(1,2,6,7) ORDER BY NOME";
									$con = mysqli_query($phpmyadmin , $gdSetor); $x=0; 
									while($setor = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x] = $setor["ID"]; ?>"><?php echo $vtNome[$x] = $setor["NOME"]; ?></option>
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
								<textarea name="descricao" class="textarea" maxlenght="200"></textarea>
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
									<select name="usuario">
										<option selected="selected" value="Todos">Todos do Setor</option>
										<?php $gdUsuario="SELECT ID, NOME FROM USUARIO WHERE SETOR_ID IN(3,4,5,8) AND SITUACAO<>'Desligado' ORDER BY NOME;";
									$con = mysqli_query($phpmyadmin , $gdUsuario); $x=0; 
									while($usuario = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x] = $usuario["ID"]; ?>"><?php echo $vtNome[$x] = $usuario["NOME"]; ?></option>
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
								<input style="max-width:12.5em;" class="input registro" type="text" name="expiracao" value="<?php echo date('Y-m-d',strtotime('+1 day'))?>">
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