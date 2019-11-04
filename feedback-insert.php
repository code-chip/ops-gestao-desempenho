<?php 
$menuFeedback="is-active";
include('menu.php');
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
	<title>Gestão de Desempenho - Inserir Feedback</title>
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
						<label class="label">Setor:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="setor" id="setor">
									<option value="">Selecione</option>
									<?php $query = "SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo' ORDER BY NOME";
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
						<label class="label">Colaborador:</label>
					</div>
					<div class="field-body">
						<div class="field is-grouped" style="max-width:17em;">							
							<div class="control">
								<div class="select">
									<span class="carregando">Aguarde, carregando...</span>
									<select name="usuario" id="usuario">
										<option selected="selected" value="Todos">Selecione</option>
									</select>	
								</div>
							</div>
						</div>
					</div>					
				</div>
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Profissional:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="profissional" id="profissional">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Comportamental:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="comportamental" id="comportamental">
										<option value="">1</option>
										<option value="">2</option>
										<option value="">3</option>
										<option value="">4</option>
										<option value="">5</option>
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Desempenho:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="desempenho" id="desempenho">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>	
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Tipo:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="tipo">
										<option value="Positivo">Positivo</option>
										<option value="Construtivo">Construtivo</option>
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>				
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Feedback:</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:17em;">							
							<div class="control">
								<textarea name="feedback" class="textarea" maxlenght="200"></textarea>
							</div>						
						</div>
					</div>
				</div>
				
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Exibição:</label>
					</div>
					<div class="field-body">
						<div class="field is-grouped" style="max-width:17em;">							
							<div class="control">
								<div class="select is-size-7-touch">
									<select name="exibicao">
										<option value="">Rementente</option>
										<option value="">Anônimo</option>
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
							$('#usuario').html('<option value="">Selecione</option>');
						}
					});
				});
			</script>
	   	</div>
	</section>	 	
</body>
</html>