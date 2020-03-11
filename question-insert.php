<?php 
$menuAtivo="Configurações";
include('menu.php');
if($_SESSION["permissao"]==1){
	echo "<script>alert('Usuário sem permissão')</script>";
	header("Refresh:1;url=home.php");
}
else{
$meta=trim($_POST['meta']);
$atividade=trim($_POST['atividade']);
$setor=trim($_POST['setor']);
$descricao=trim($_POST['descricao']);
$usuario=trim($_POST['usuario']);
$execucao=trim($_POST['execucao']);

if(isset($_POST["inserirMeta"])!=null){
	if($meta!="" && $descricao!="" && $execucao!=""){
		if($usuario=="Todos"){
			$listIds="SELECT ID FROM USUARIO WHERE SETOR_ID=".$setor." AND SITUACAO<>'Desligado';";
			$cnx= mysqli_query($phpmyadmin, $listIds);
			while ($idUsuario= $cnx->fetch_array()) {
				$inserirMeta="INSERT INTO META(META, ATIVIDADE_ID, SETOR_ID, DESCRICAO, USUARIO_ID, EXECUCAO, CADASTRO_EM, DESEMPENHO) VALUES(".$meta.",".$atividade.",".$setor.",'".$descricao."',".$idUsuario["ID"].",'".$execucao."','".date('Y-m-d')."',0);";
				$cx= mysqli_query($phpmyadmin, $inserirMeta);
			}
		}
		else{
			$inserirMeta="INSERT INTO META(META, ATIVIDADE_ID, SETOR_ID, DESCRICAO, USUARIO_ID, EXECUCAO, CADASTRO_EM, DESEMPENHO) VALUES(".$meta.",".$atividade.",".$setor.",'".$descricao."',".$usuario.",'".$execucao."','".date('Y-m-d')."',0);";			
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
	<title>Gestão de Desempenho - Inserir Pergunta</title>
</head>
<body>
	<section class="section">
	  	<div class="container">
	   		<form action="question-insert.php" method="POST">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">tipo:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="tipo">
									<?php $gdDestino="SELECT ID, TIPO FROM AVAL_TIPO WHERE SITUACAO='Ativo' ORDER BY ID";
									$con = mysqli_query($phpmyadmin , $gdDestino); $x=0; 
									while($destino = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x] = $destino["ID"]; ?>"><?php echo $vtNome[$x] = $destino["TIPO"]; ?></option>
									<?php $x;} endwhile;?>
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Classificação:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="Classificacao">
									<?php $gdTipo="SELECT ID, CLASSIFICACAO FROM AVAL_TIPO_PERGUNTA WHERE SITUACAO='Ativo' ORDER BY ID";
									$con = mysqli_query($phpmyadmin , $gdTipo); $x=0; 
									while($tipo = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x] = $tipo["ID"]; ?>"><?php echo $vtNome[$x] = $tipo["CLASSIFICACAO"]; ?></option>
									<?php $x;} endwhile;?>
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Resposta:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="atividade">									
									<option value="checkbox">Por checkbox</option>
									<option value="comentario">Por comentário</option>
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Cargo:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="cargo" id="cargo">
									<option value="">Selecione</option>
									<?php $query = "SELECT ID, NOME FROM CARGO WHERE SITUACAO='Ativo' ORDER BY NOME";
										$cnx = mysqli_query($phpmyadmin, $query);
										while($reCargo = mysqli_fetch_assoc($cnx)) {
											echo '<option value="'.$reCargo['ID'].'">'.$reCargo['NOME'].'</option>';
										}?>
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Pergunta:</label>
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
						<label class="label">Situação:</label>
					</div>
					<div class="field-body">
						<div class="field is-grouped" style="max-width:17em;">							
							<div class="control">
								<div class="select">
									<select name="usuario" id="usuario">
										<option selected="selected" value="Todos">Ativo</option>
										<option value="Todos">Inativo</option>
									</select>	
								</div>
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
</html><?php }//ELSE - caso o usuário tenha permissão.