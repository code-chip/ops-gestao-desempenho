<?php 
$menuAtivo="Feedback";
include('menu.php');
$colaborador=trim($_POST['colaborador']);
$mensagem=trim($_POST['mensagem']);
if(isset($_POST["inserirSolicitacao"])!=null){
	if($colaborador!="" && $mensagem!=""){
		$inserirSoli="INSERT INTO SOLICITACAO(REMETENTE_ID, DESTINATARIO_ID, MENSAGEM, REGISTRO, SITUACAO) VALUES(".$_SESSION["userId"].",".$colaborador.",'".$mensagem."','".date('Y-m-d')."','Enviado');";			
			$cnx= mysqli_query($phpmyadmin, $inserirSoli);
		$erro=mysqli_error($phpmyadmin);
		if($erro==null){
			echo "<script>alert('Solicitação enviada com sucesso!!')</script>";	
		}
		else{
			?><script>var erro="<?php echo $erro;?>";  alert('Erro ao enviar: '+erro)</script><?php
		}
	}
	else if($colaborador==""){
		echo "<script>alert('Selecionar o campo Colaborador é obrigatório!!')</script>";
	}
	else{
		echo "<script>alert('Preencher a mensagem é obrigatório!!')</script>";
	}	
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Solicitar Feedback</title>
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
	   		<form action="feedback-request.php" method="POST">
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
									<select name="colaborador" id="usuario">
										<option selected="selected" value="Todos">Selecione</option>
									</select>	
								</div>
							</div>
						</div>
					</div>					
				</div>			
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Mensagem:</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:17em;">							
							<div class="control">
								<textarea name="mensagem" class="textarea" maxlenght="200" placeholder="Me envie um feedback!"></textarea>
							</div>
							<div class="control">
								<button name="inserirSolicitacao" type="submit" class="button is-primary" value="Filtrar">Enviar solicitação</button>
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