<?php

$menuAtivo = 'relatorios';
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
	<title>Gestão de Desempenho - Relatório Individual</title>
</head>
<body>
<span id="topo"></span>
<section class="section">
<div class="container">
	<form id="form1" action="report-evaluation.php" method="POST" >
		<div class="field">
			<label class="label is-size-7-touch">Ciclo*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
					<select name="yearMonth" class="is-fullwidth"><?php 								
						$con = mysqli_query($phpmyadmin , "SELECT DATE_FORMAT(REGISTRO,'%m/%Y' ) AS MES, ANO_MES FROM AVAL_INDICE GROUP BY 1 ORDER BY 1 DESC");
						while ($sector = $con->fetch_array()) {
							echo '<option value=' . $sector['ANO_MES'] . '>' . $sector["MES"] . '</option>';
					 	}
						?>
					</select>
					<span class="icon is-small is-left">
						<i class="fas fa-calendar-alt"></i>
					</span>	
				</div>
			</div>
		</div>				
		<div class="field">
			<label class="label is-size-7-touch">Avaliação*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
					<select name="report" onchange="change(this.value)"><?php 
						if ($_SESSION["permissao"] > 1) {
							echo "
							<option selected='selected' value='subordinate'>Colaboradores</option>
							<option value='leader'>Líderes</option>";
						}
						echo "				
						<option value='private'>Individual</option>";
					?>									
					</select>
					<span class="icon is-small is-left">
						<i class="fas fa-diagnoses"></i>
					</span>
				</div>						
			</div>
		</div>
		<div class="field loadId" id="subordinate">
			<div class="field">
				<label class="label is-size-7-touch">Líder colaboradores*</label>
				<div class="control has-icons-left">
					<div class="select is-fullwidth">
						<select name="leader" class="required" id="leader" autofocus>
							<option value="">Selecione</option><?php
							$cnx = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM USUARIO WHERE ID IN(SELECT GESTOR_ID FROM AVAL_INDICE AI GROUP BY 1) ORDER BY NOME");
							while($leader = mysqli_fetch_assoc($cnx)) {
								echo '<option value="'.$leader['ID'].'">'.$leader['NOME'].'</option>';
							}
							?>
						</select>	
					</div>
					<span class="icon is-small is-left">
						<i class="fas fa-user-tie"></i>
					</span>
				</div>						
			</div>
		</div>	
		<div class="field loadId" id="private" style="display: none;">
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
						<select name="user" id="user" class="required">
							<option selected="selected" value="Todos">Selecione</option>
						</select>
						<span class="icon is-small is-left">
							<i class="fas fa-user-circle"></i>
						</span>	
					</div>
				</div>
			</div>
		</div>
		<div class="field-body">
			<div class="field is-grouped">
				<div class="control">
					<button name="query" type="submit" class="button is-primary btn128" value="query">Gerar</button>
				</div>
				<div class="control">
					<button name="reset" type="reset" class="button is-primary btn128" onclick="change()">Limpar</button>
				</div>
			</div>
		</div>		
	</form><!--FINAL DO FORMULÁRIO-->
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

if (isset($_POST['query'])) {
	$_SESSION['file'] = $_POST['report'];
	$_SESSION['filter'] = $_POST['yearMonth'];

	if ($_SESSION['permissao'] == 1) {
		$_SESSION['filter'] .= "_".$_SESSION["userId"];
	} else if ($_POST['report'] == 'private') {
		$_SESSION['filter'] .= "_".$_POST['user'];
	} else if ($_POST['report'] == 'subordinate') {
		$_SESSION['filter'] .= "_".$_POST['leader'];
	}

	echo "<script>window.open('report/evaluation.php', '_blank');</script>";
	die();
}
