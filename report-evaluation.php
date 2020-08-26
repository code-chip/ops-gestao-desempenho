<?php

$menuAtivo = 'relatorios';
require('menu.php');

?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Relatório Individual</title>
	<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>
<span id="topo"></span>
<section class="section">
<div class="container">
	<form id="form1" action="report-evaluation.php" method="POST" >
		<div class="field">
			<label class="label is-size-7-touch">Semestre*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
					<select name="periodo" class="is-fullwidth"><?php 								
						$con = mysqli_query($phpmyadmin , "SELECT DATE_FORMAT(REGISTRO,'%m/%Y' ) AS MES FROM AVAL_INDICE GROUP BY 1 ORDER BY 1 DESC");
						while ($sector = $con->fetch_array()) {
							echo '<option value=' . $sector['MES'] . '>' . $sector["MES"] . '</option>';
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
					<select name="atividade">
						<option selected="selected" value="">Colaboradores</option>
						<option value="">Líderes</option>
						<option value="">Individual</option>								
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
		<div class="field-body">
			<div class="field is-grouped">
				<div class="control">
					<a href="report/index2.php" target="_blank" class="button is-primary btn128">Gerar</a>
				</div>
				<div class="control">
					<a href="report/index3.php" target="_blank" class="button is-primary btn128">Gerar 2</a>
				</div>
				<div class="control">
					<button name="query" type="submit" class="button is-primary btn128">Gerar</button>
				</div>
				<div class="control">
					<button name="clear" type="submit" class="button is-primary btn128">Limpar</button>
				</div>
			</div>
		</div>		
	</form><!--FINAL DO FORMULÁRIO-->		
</div>
</section>
</body>
</html>

