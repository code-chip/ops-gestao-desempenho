<?php

$menuAtivo = 'configuracoes';
require('menu.php');

if ($_SESSION['permissao'] == 1) {
	echo "<script>alert('Usuário sem permissão!'); window.location.href='register.php'; </script>";
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
	<title>Gestão de Desempenho - Inserir Pergunta</title>
	<script type="text/javascript">
		function disable(value) {
			if (value == "comentario") {
				document.getElementById("role").style.display = "none";
				document.getElementById("classification").style.display = "none";
			}
		}
	</script>
</head>
<body>
<div>	
	<section class="section">
		<div class="container">
			<h3 class="title"><i class="fas fa-calendar-plus"></i> Inserir Pergunta</h3>
		<hr>
	<main>
	<form id="form" action="question-insert.php" method="POST" onsubmit="return check()">
		<div class="field">
			<label class="label is-size-7-touch">Tipo*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
			  		<select name="type" class="is-fullwidth" autofocus><?php
						$cnx = mysqli_query($phpmyadmin , "SELECT ID, TIPO FROM AVAL_TIPO WHERE SITUACAO = 'Ativo' ORDER BY ID"); 
						while($destino = $cnx->fetch_array()) { 
							echo "<option value=" . $destino["ID"] . ">" . $destino["TIPO"] . "</option>";
						} 
						?>
					</select>
				</div>
				<div>
					<span class="icon is-small is-left" >
					  	<i class="fas fa-tape"></i>
					</span>
				</div>
			</div>
		</div>
		<div class="field" id="classification">
			<label class="label is-size-7-touch">Classificação*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
			  		<select name="classification" class="is-fullwidth">
						<option value="1">Técnicas</option>
						<option value="2">Comportamentais</option>		
					</select>
				</div>
				<div>
					<span class="icon is-small is-left" >
					  	<i class="fas fa-book"></i>
					</span>
				</div>
			</div>
		</div>
		<div class="field">
			<label class="label is-size-7-touch">Resposta por*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
			  		<select name="answer" class="is-fullwidth" onchange="change(this.value), disable(this.value)">
						<option value="checkbox">Checkbox</option>
						<option value="comentario">Comentário</option>
					</select>
				</div>
				<div class="loadId" id="checkbox">
					<span class="icon is-small is-left">
					  	<i class="fas fa-check-circle"></i>
					</span>
				</div>
				<div class="loadId" id="comentario" style="display: none;">
					<span class="icon is-small is-left">
					  	<i class="fas fa-comments"></i>
					</span>
				</div>
			</div>
		</div>
		<div class="field" id="role">
			<label class="label is-size-7-touch">Cargo*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
			  		<select name="role" class="is-fullwidth"><?php
						$cnx = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM CARGO WHERE SITUACAO='Ativo' ORDER BY NOME");
						while($role = mysqli_fetch_assoc($cnx)) {
							echo "<option value=" . $role["ID"]. ">" . $role["NOME"] . "</option>";
						}?>
					</select>
				</div>
				<div >
					<span class="icon is-small is-left" >
					  	<i class="fas fa-suitcase-rolling"></i>
					</span>
				</div>
			</div>
		</div>
		<div class="field">
			<label class="label is-size-7-touch">Pergunta*</label>
			<div class="field-body">
				<div class="field">							
					<div class="control is-fullwidth has-icons-right" id="question">
						<textarea name="question" class="textarea required" maxlenght="1000" onkeypress="addLoadField('question')" onkeyup="rmvLoadField('question')" type="text" placeholder="Executa movimentos ágeis e com naturalidade em todos as áreas (checkout, separação, caixas e recebimento). *"  onblur="checkAdress(form.question, 'msgOk1','msgNok1')" id="input1"></textarea>
						<div id="msgNok1" style="display:none;">
					    	<span class="icon is-small is-right">
					      		<i class="fas fa-fw"></i>
					    	</span>
					    	<p class="help is-danger">A pergunta é obrigatória</p>		    	
					   	</div>
					   	<div id="msgOk1" style="display:none;">
					    	<span class="icon is-small is-right">
					      		<i class="fas fa-check"></i>
					    	</span>
					   	</div>
					</div>
											
				</div>
			</div>
		</div>	
		<div class="field">
			<label class="label is-size-7-touch">Situação*</label>
			<div class="control has-icons-left">
				<div class="select is-fullwidth">
			  		<select name="situation" class="is-fullwidth">
						<option value="Ativo">Ativo</option>
						<option value="Inativo">Inativo</option>
					</select>
				</div>
				<div >
					<span class="icon is-small is-left" >
					  	<i class="fas fa-sort"></i>
					</span>
				</div>
			</div>
		</div>
		<div class="field-body is-fullwidth">
			<div class="field is-grouped is-fullwidth">
				<div class="control is-fullwidth">
					<button name="insert" type="submit" class="button is-primary btn128" value="Inserir">Inserir</button>
				</div>
				<div class="control">
					<button name="clear" type="reset" class="button is-primary btn128">Limpar</button>
				</div>
				<div class="control">
					<a href="register.php" class="button is-primary btn128">Cancelar</a>										
				</div>									
			</div>
		</div>							
	</form>
	</main>	
</div>
</section>
</div>
</body>
</html>
<?php

if (isset($_POST["insert"]) != null) {
	
	if ($_POST['answer'] == 'checkbox') {
		if ($_POST['type'] == 2) {
			$_POST['classification'] = $_POST['classification'] + 2;
		}

		$question = "INSERT INTO AVAL_PERGUNTA(AVAL_TIPO_PERGUNTA_ID, CARGO_ID, PERGUNTA, SITUACAO) VALUES(" . $_POST['classification'] . "," . $_POST['role'] . ",'" . $_POST['question'] . "','" . $_POST['situation'] . "');";			
	} else {
		$question = "INSERT INTO AVAL_PERGUNTA_COM(AVAL_TIPO_ID, PERGUNTA, SITUACAO) VALUES(" . $_POST['type'] . ",'" . $_POST['question'] . "','" . $_POST['situation'] . "');";
	}
	
	$cnx = mysqli_query($phpmyadmin, $question);		
	echo "<script>alert('Pegunta cadastrada com sucesso.')</script>";	
}

?>