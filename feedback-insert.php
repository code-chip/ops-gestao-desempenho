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
	<title>Gestão de Desempenho - Inserir Feedback</title>
</head>
<body>
	<section class="section">
	<div class="container">
	   	<form action="feedback-insert.php" method="POST" onsubmit="return check()">
	   		<div class="field">
				<label class="label is-size-7-touch">Setor*</label>
				<div class="control has-icons-left">
					<div class="select is-fullwidth">
						<select name="sector" class="required" id="sector" autofocus>
							<option value="">Selecione</option><?php
							$cnx = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM SETOR WHERE SITUACAO='Ativo' ORDER BY NOME");
							while($reSetor = mysqli_fetch_assoc($cnx)) {
								echo '<option value="'.$reSetor['ID'].'">'.$reSetor['NOME'].'</option>';
							}
							?>
						</select>	
					</div>
					<span class="icon is-small is-left">
						<i class="fas fa-door-open"></i>
					</span>
				</div>						
			</div>
			<div class="field">
				<label class="label is-size-7-touch">Colaborador*</label>
				<div class="control has-icons-left">
					<div class="select is-fullwidth">
						<select name="recipient" id="recipient" class="required">
							<option selected="selected" value="Todos">Selecione</option>
						</select>
						<span class="icon is-small is-left">
							<i class="fas fa-user-circle"></i>
						</span>	
					</div>
				</div>
			</div>					
	    	<div class="field">
				<label class="label is-size-7-touch">Profissional*</label>
				<div class="control has-icons-left">
					<div class="select is-fullwidth">
						<select name="professional" id="professional">
						<?php $query = "SELECT ID, RESPOSTA FROM FEEDBACK_RESPOSTA WHERE SITUACAO = 's'";
							$cnx = mysqli_query($phpmyadmin, $query);
							while($resquet = mysqli_fetch_assoc($cnx)) {
								echo '<option value="'.$resquet['ID'].'">'.$resquet['RESPOSTA'].'</option>';
							}?>
						</select>
						<span class="icon is-small is-left">
							<i class="fas fa-chalkboard-teacher"></i>
						</span>	
					</div>
				</div>						
			</div>
			<div class="field">
				<label class="label is-size-7-touch">Comportamental*</label>
				<div class="control has-icons-left">
					<div class="select is-fullwidth">
						<select name="behavioral" id="behavioral"><?php 
							$cnx = mysqli_query($phpmyadmin, "SELECT ID, RESPOSTA FROM FEEDBACK_RESPOSTA WHERE SITUACAO = 's'");
							while($resquet = mysqli_fetch_assoc($cnx)) {
								echo '<option value="'.$resquet['ID'].'">'.$resquet['RESPOSTA'].'</option>';
							}?>
						</select>
						<span class="icon is-small is-left">
							<i class="fas fa-users"></i>
						</span>	
					</div>
				</div>						
			</div>
			<div class="field">
				<label class="label is-size-7-touch">Desempenho*</label>
				<div class="control has-icons-left">
					<div class="select is-fullwidth">
						<select name="performance" id="performance"><?php
							$cnx = mysqli_query($phpmyadmin, "SELECT ID, RESPOSTA FROM FEEDBACK_RESPOSTA WHERE SITUACAO = 's'");
							while($resquet = mysqli_fetch_assoc($cnx)) {
								echo '<option value="'.$resquet['ID'].'">'.$resquet['RESPOSTA'].'</option>';
							}?>
						</select>
						<span class="icon is-small is-left">
							<i class="fas fa-chart-line"></i>
						</span>	
					</div>
				</div>						
			</div>
			<div class="field">
				<label class="label is-size-7-touch">Tipo*</label>
				<div class="control has-icons-left">
					<div class="select is-fullwidth">
						<select name="type">
							<option value="Positivo">Positivo</option>
							<option value="Construtivo">Construtivo</option>
						</select>
						<span class="icon is-small is-left">
							<i class="fas fa-comment-alt"></i>
						</span>	
					</div>
				</div>						
			</div>
			<div class="field">
				<label class="label is-size-7-touch">Feedback*</label>
				<div class="control">
					<textarea name="feedback" class="textarea is-fullwidth required" maxlenght="300"></textarea>
				</div>
			</div>
			<div class="field">
				<label class="label is-size-7-touch">Exibição*</label>
				<div class="control has-icons-left">
					<div class="select is-fullwidth">
						<select name="exhibition" onchange="change(this.value)">
							<option value="1">Remetente</option>
							<option value="0">Anônimo</option>
						</select>
						<div id="1" class="loadId">
							<span class="icon is-small is-left">
								<i class="fas fa-user"></i>	
							</span>
						</div>
						<div id="0" class="loadId" style="display: none;">
							<span class="icon is-small is-left">
								<i class="fas fa-user-secret"></i>
							</span>
						</div>	
					</div>
				</div>
			</div>
			<div class="field-body">
				<div class="field is-grouped">
					<div class="control">
						<button name="insert" type="submit" class="button is-primary btn128" value="Insert">Enviar</button>
					</div>
					<div class="control">
						<button name="inserirFeedback" type="reset" class="button is-primary btn128">Limpar</button>
					</div>
				</div>			
	     	</form>
	     	<script type="text/javascript" scr="https://www.google.com/jsapi"></script>
	     	<script type="text/javascript">
	     		google.loader("jquery", "1.4.2");
	     	</script>
	     	<script type="text/javascript">
				$(function(){
					$('#sector').change(function(){
						if( $(this).val() ) {
							$('#recipient').hide();
							$('.carregando').show();
							$.getJSON('loading-users.php?search=',{setor: $(this).val(), ajax: 'true'}, function(j){
								var options = '<option value="Todos">Selecione</option>';	
								for (var i = 0; i < j.length; i++) {
									options += '<option value="' + j[i].id + '">' + j[i].nome_usuario + '</option>';
								}	
								$('#recipient').html(options).show();
								$('.carregando').hide();
							});
						} else {
							$('#recipient').html('<option value="">Selecione</option>');
						}
					});
				});
			</script>
	   	</div>
	</section>	 	
</body>
</html>
<?php

if (isset($_POST["insert"]) != null) {
	$cnx = mysqli_query($phpmyadmin, "INSERT INTO FEEDBACK(REMETENTE_ID, DESTINATARIO_ID, FEEDBACK, COMPORTAMENTAL, PROFISSIONAL, DESEMPENHO, TIPO, SITUACAO, EXIBICAO, ANO_MES, REGISTRO) VALUES(".$_SESSION["userId"].",".$_POST['recipient'].",'".$_POST['feedback']."',".$_POST['behavioral'].",".$_POST['professional'].",".$_POST['performance'].",'".$_POST['type']."','Enviado',".$_POST['exhibition'].",'".date('Y-m')."','".date('Y-m-d')."');");
		
	$erro = mysqli_error($phpmyadmin);
		
	if ($erro == null) {
		echo "<script>alert('Feedback enviado com sucesso!!')</script>";	
	} else {
		?><script>var erro="<?php echo $erro;?>";  alert('Erro ao enviar: '+erro)</script><?php
	}
}

?>