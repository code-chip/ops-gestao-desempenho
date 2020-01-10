<?php 
$menuMeta="is-active";
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
	<title>Gestão de Desempenho - Inserir Meta</title>
	<style type="text/css">
		.carregando{
		color:#ff0000;
		display:none;
		}
	</style>
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
									<select name="setor" id="setor">
									<option value="">Selecione</option>
									<?php $query = "SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo' AND ID NOT IN(1,2,6,7) ORDER BY NOME";
										$cnx = mysqli_query($phpmyadmin, $query);
										while($reSetor = mysqli_fetch_assoc($cnx)) {
											echo '<option value="'.$reSetor['ID'].'">'.$reSetor['NOME'].'</option>';
										}?>
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
									<span class="carregando">Aguarde, carregando...</span>
									<select name="usuario" id="usuario">
										<option selected="selected" value="Todos">Todos do Setor</option>
									</select>	
								</div>
							</div>
						</div>
					</div>					
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Execução:</label>
					</div>
					<div class="field-body">
						<div class="field is-grouped" style="max-width:17em;">							
							<div class="control">
								<input style="max-width:12.5em;" class="input registro" type="text" name="execucao" value="<?php echo date('Y-m-d',strtotime('+1 day'))?>">
							</div>
							<div class="control">
								<button name="inserirMeta" type="submit" class="button is-primary" value="Filtrar">Inserir</button>
							</div>						
						</div>
					</div>					
				</div>
	     	</form>
	     	<script type="text/javascript" scr="https://www.google.com/jsapi"></script>
	     	<script type="text/javascript">
	     		google.loader("jquery", "1.4.2");
	     	</script>
	     	<script type="text/javascript">
				$(function(){
					$('#setor').change(function(){
						if( $(this).val() ) {
							$('#usuario').hide();
							$('.carregando').show();
							$.getJSON('loading-users.php?search=',{setor: $(this).val(), ajax: 'true'}, function(j){
								var options = '<option value="Todos">Todos do Setor</option>';	
								for (var i = 0; i < j.length; i++) {
									options += '<option value="' + j[i].id + '">' + j[i].nome_usuario + '</option>';
								}	
								$('#usuario').html(options).show();
								$('.carregando').hide();
							});
						} else {
							$('#usuario').html('<option value="">Todos do Setor</option>');
						}
					});
				});
			</script>
	   	</div>
	</section>	 	
</body>
</html><?php }//ELSE - caso o usuário tenha permissão.