<?php 
$menuFeedback="is-active";
include('menu.php');
$colaborador=trim($_POST['colaborador']);
$profissional=trim($_POST['profissional']);
$comportamental=trim($_POST['comportamental']);
$desempenho=trim($_POST['desempenho']);
$tipo=trim($_POST['tipo']);
$feedback=trim($_POST['feedback']);
$exibicao=trim($_POST['exibicao']);
if(isset($_POST["inserirFeedback"])!=null){
	if($colaborador!="" && $feedback!=""){
		$inserirFeedback="INSERT INTO FEEDBACK(REMETENTE_ID, DESTINATARIO_ID, FEEDBACK, COMPORTAMENTAL, PROFISSIONAL, DESEMPENHO, SITUACAO, LIDO, EXIBICAO) VALUES(".$SESSION_["userId"].",".$colaborador.",'".$feedback."',".$comportamental.",".$profissional.",".$desempenho.",'Enviado',0,".$exibicao.";";			
			$cnx= mysqli_query($phpmyadmin, $inserirFeedback);
		$erro=mysqli_error($phpmyadmin);
		if($erro==null){
			echo "<script>alert('Feedback enviado com sucesso!!')</script>";	
		}
		else{
			?><script>var erro="<?php echo $erro;?>";  alert('Erro ao enviar: '+erro)</script><?php
		}
	}
	else if($colaborador==""){
		echo "<script>alert('Selecionar o campo Colaborador é obrigatório!!')</script>";
	}
	else{
		echo "<script>alert('Preencher do feedback é obrigatório!!')</script>";
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
								<button name="inserirFeedback" type="submit" class="button is-primary" value="Filtrar">Inserir</button>
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
								var options = '<option value="Todos">Selecione</option>';	
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