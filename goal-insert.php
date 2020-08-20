<?php 

$menuAtivo = 'meta';
require('menu.php');

if ($_SESSION["permissao"] == 1) {
	echo "<script>alert('Usuário sem permissão'); window.location.href='home.php'; </script>";
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<script type="text/javascript" src="js/myjs.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	<style type="text/css" src="css/personal.css"></style>
	<title>Gestão de Desempenho - Inserir Meta</title>
</head>
<body>
	<section class="section">
	  	<div class="container">
	   		<form action="goal-insert.php" method="POST" onsubmit="return check()">
	    		<div class="field">
					<label class="label is-size-7-touch">Meta*</label>
					<div class="control has-icons-left">
						<input type="text" class="input desempenho required" name="goal">
						<span class="icon is-small is-left">
							<i class="fas fa-bullseye"></i>
						</span>
					</div>
				</div>	
				<div class="field">
					<label class="label is-size-7-touch">Atividade*</label>
					<div class="control has-icons-left">
						<div class="select is-fullwidth">
							<select name="activity">
								<?php $gdAtividade="SELECT ID, NOME FROM ATIVIDADE WHERE SITUACAO='Ativo' ORDER BY NOME";
								$con = mysqli_query($phpmyadmin , $gdAtividade); 
								while($atividade = $con->fetch_array()):{?>
								<option value="<?php echo $atividade["ID"]; ?>"><?php echo $atividade["NOME"]; ?></option>
								<?php $x;} endwhile;?>
							</select>
							<span class="icon is-small is-left">
								<i class="fas fa-diagnoses"></i>
							</span>	
						</div>
					</div>
				</div>
				<div class="field">
					<label class="label is-size-7-touch">Setor*</label>
					<div class="control has-icons-left">
						<div class="select is-fullwidth">
							<select name="sector" id="sector" class="required">
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
							<select name="user" id="user" class="required">
								<option selected="selected" value="Todos">Todos do Setor</option>
							</select>
							<span class="icon is-small is-left">
								<i class="fas fa-user-circle"></i>
							</span>	
						</div>
					</div>					
				</div>
				<div class="field">
					<label class="label is-size-7-touch">Descrição*</label>
					<div class="control">
						<textarea name="description" class="textarea required" maxlength="500"></textarea>
					</div>
				</div>
				<div class="field">
					<label class="label is-size-7-touch">Execução*</label>
					<div class="control has-icons-left">
						<input class="input registro required" type="text" name="execution" value="<?php echo date('Y-m-d',strtotime('+1 day'))?>">
						<span class="icon is-small is-left">
							<i class="fas fa-calendar-alt"></i>
						</span>
					</div>					
				</div>
				<div class="field-body">
					<div class="field is-grouped">
						<div class="control">
							<button name="insert" type="submit" class="button is-primary btn128" value="Insert">Inserir</button>
						</div>
						<div class="control">
							<button name="clear" type="reset" class="button is-primary btn128" onclick="clearForm()">Limpar</button>
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
					$('#sector').change(function(){
						if( $(this).val() ) {
							$('#user').hide();
							$('.carregando').show();
							$.getJSON('loading-users.php?search=',{setor: $(this).val(), ajax: 'true'}, function(j){
								var options = '<option value="Todos">Todos do Setor</option>';	
								for (var i = 0; i < j.length; i++) {
									options += '<option value="' + j[i].id + '">' + j[i].nome_usuario + '</option>';
								}	
								$('#user').html(options).show();
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
</html>
<?php

if (isset($_POST["insert"]) != null) {
	if ($_POST['user'] == "Todos") {
		$cnx = mysqli_query($phpmyadmin, "SELECT ID FROM USUARIO WHERE SETOR_ID = " . $_POST['sector'] . " AND SITUACAO<>'Desligado';");
		while ($idUsuario = $cnx->fetch_array()) {
			$cx = mysqli_query($phpmyadmin, "INSERT INTO META(META, ATIVIDADE_ID, SETOR_ID, DESCRICAO, USUARIO_ID, EXECUCAO, CADASTRO_EM, DESEMPENHO) VALUES(".$_POST['goal'].",".$_POST['activity'].",".$_POST['sector'].",'".$_POST['description']."',".$idUsuario["ID"].",'".$_POST['execution']."','".date('Y-m-d')."',0);");
		}
	} else {
		$cnx = mysqli_query($phpmyadmin, "INSERT INTO META(META, ATIVIDADE_ID, SETOR_ID, DESCRICAO, USUARIO_ID, EXECUCAO, CADASTRO_EM, DESEMPENHO) VALUES(".$_POST['goal'].",".$_POST['activity'].",".$_POST['sector'].",'".$_POST['description']."',".$_POST['user'].",'".$_POST['execution']."','".date('Y-m-d')."',0);");
	}

	if ($erro == null) {
		echo "<script>alert('Meta cadastrada com sucesso!!'); </script>";	
	} else {
		echo "<script>alert('Erro ao cadastrar meta.'); </script>";
	}
}

?>