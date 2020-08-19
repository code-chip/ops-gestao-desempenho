<?php 
$menuAtivo = 'feedback';
require('menu.php');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<script type="text/javascript" src="js/myjs.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<style type="text/css" src="css/personal.css"></style>
	<title>Gestão de Desempenho - Solicitar Feedback</title>
</head>
<body>
	<section class="section">
	<div class="container">
	   	<form action="feedback-request.php" method="POST" onsubmit="return check()">
	   		<div class="field">
				<label class="label is-size-7-touch">Setor*</label>
				<div class="control has-icons-left">
					<div class="select is-fullwidth">
						<select name="setor" id="setor" class="required">
							<option value="">Selecione</option><?php
							$cnx = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo' ORDER BY NOME");
							while($reSetor = mysqli_fetch_assoc($cnx)) {
								echo '<option value="'.$reSetor['ID'].'">'.$reSetor['NOME'].'</option>';
							}?>
						</select>
						<span class="icon is-small is-left">
							<i class="fas fa-door-open"></i>
						</span>	
					</div>
				</div>
			</div>
			<div class="field">
				<label class="label is-size-7-touch">Colaborador*</label>
				<div class="control has-icons-left">
					<div class="select is-fullwidth">
						<select name="colaborador" id="usuario" class="required">
							<option selected="selected" value="Todos">Selecione</option>
						</select>
						<span class="icon is-small is-left">
							<i class="fas fa-user-circle"></i>
						</span>	
					</div>
				</div>					
			</div>			
			<div class="field">
				<label class="label is-size-7-touch">Mensagem*</label>
				<div class="control">
					<textarea name="mensagem" type="text" class="textarea required" placeholder="Por favor, me envie um feedback!" maxlength="200"></textarea>
				</div>
			</div>
			<div class="field-body">	
				<div class="control">
					<button name="inserirSolicitacao" type="submit" class="button is-primary" value="Filtrar">Enviar solicitação</button>
				</div>							
			</div>				
	     </form>
	</div>
	</section>	     
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
</body>
</html>
<?php 

if (isset($_POST["inserirSolicitacao"]) != null) {
	$cnx = mysqli_query($phpmyadmin, "INSERT INTO SOLICITACAO(REMETENTE_ID, DESTINATARIO_ID, MENSAGEM, REGISTRO, SITUACAO) VALUES(".$_SESSION["userId"].",".$_POST['colaborador'].",'".$_POST['mensagem']."','".date('Y-m-d')."','Enviado');");
		
	$erro = mysqli_error($phpmyadmin);
		
	if ($erro == null) {
		echo "<script>alert('Solicitação enviada com sucesso!!')</script>";	
	} else {
		echo "<script> alert('Erro ao enviar: " . $erro . "')</script>";
	}
}