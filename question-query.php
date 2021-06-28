<?php 

$menuAtivo = 'configuracoes';
require('menu.php');

if ($_SESSION["permissao"] == 1) {
	echo "<script>alert('Usuário sem permissão'); window.location.href='register.php'; </script>";
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
	<title>Gestão de Desempenho - Conuslta Pergunta</title>
</head>
<body>
	<section class="section">
	  	<div class="container">
	  	<?php if (isset($_POST["query"]) == null) :?>
	   		<form action="question-query.php" method="POST" id="form" onsubmit="return check()">
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
				<div class="field">
					<label class="label is-size-7-touch">Cargo*</label>
					<div class="control has-icons-left">
						<div class="select is-fullwidth" id="cargo">
							<select name="cargo" class="required is-fullwidth ">
								<option value="">Selecione</option><?php
								$cnx = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM CARGO WHERE SITUACAO='Ativo' ORDER BY NOME");
								while($reCargo = mysqli_fetch_assoc($cnx)) {
									echo "<option value=" . $reCargo["ID"] . ">" . $reCargo["NOME"] . "</option>";
								}
								?>
							</select>
							<span class="icon is-small is-left">
								<i class="fas fa-suitcase-rolling"></i>
							</span>
						</div>						
					</div>
				</div>								
				<div class="field">
					<label class="label is-size-7-touch">Situação*</label>
					<div class="control has-icons-left">
						<div class="select is-fullwidth">
							<select name="situacao" id="situacao" class="is-fullwidth">
								<option selected="selected" value="AND SITUACAO='Ativo'">Ativo</option>
								<option value="AND SITUACAO='Inativo'">Inativo</option>
								<option value="">Todas</option>
							</select>
							<span class="icon is-left">
								<i class="fas fa-sort"></i>
							</span>	
						</div>
					</div>					
				</div>
				<div class="field-body">
					<div class="field is-grouped">
						<div class="control">
							<button name="query" type="submit" class="button is-primary btn128" value="filter">Consultar</button>
						</div>
						<div class="control">
							<button name="clear" type="reset" class="button is-primary btn128" onclick="clearForm();">Limpar</button>
						</div>
						<div class="control">
							<a href="register.php" class="button is-primary btn128">Cancelar</a>										
						</div>									
					</div>
				</div>
	     	</form>
	    <?php endif;
	     	
	     if (isset($_POST["query"]) != null) {
			if ($_POST['type'] == 1) {//OS ID REFERÊNCIA P/ TÉCNICO E COMPORTAMENTAL.
				$tecnica = 1;
				$comportamental = 2;
			} else {
				$tecnica = 3;
				$comportamental = 4;
			}
				
			if ($_POST['cargo'] != "") {					
				 echo '
				 <form id="form2" action="" method="POST">	
					<div class="box">Técnicas</div>'; 
					
					$y = 1;		
					$cnx = mysqli_query($phpmyadmin, "SELECT ID, PERGUNTA FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=".$tecnica." AND CARGO_ID=".$_POST['cargo']." ".$_POST['situacao']." ORDER BY ORDEM;");
					
					if (mysqli_num_rows($cnx) > 0) {
						while ($pergunta = $cnx->fetch_array()){
							echo "
							<div class='box'>	
								<div class='field is-horizontal'>
									<div class='text'>" . $pergunta["PERGUNTA"] . "</div>				
								</div>								
							</div>";
							$y++;
						} 
					}  

					echo "
					<div class='box'>Comportamentais</div>";
					
					$cnx2 = mysqli_query($phpmyadmin, "SELECT ID, PERGUNTA FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=".$comportamental." AND CARGO_ID=".$_POST['cargo']." ".$_POST['situacao']." ORDER BY ORDEM;");
					
					if (mysqli_num_rows($cnx2) > 0) {
						while ($pergunta = $cnx2->fetch_array()) {
							echo "
							<div class='box'>	
								<div class='field is-horizontal'>
									<div class='text'>" . $pergunta["PERGUNTA"] . "</div>				
								</div>								
							</div>";
							$y++;
						}
					} //<!--FINAL PERGUNTA COMPORTAMENTAL-->
					
					$cnx3 = mysqli_query($phpmyadmin, "SELECT ID, PERGUNTA FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID=2 ".$_POST['situacao']);
					$getComentario = $cnx3->fetch_array();					
					
					echo "
					<div class='box'>	
						<div class='field'>
						  	<label class='label'>" . $getComentario["PERGUNTA"] . "</label>
						</div>						
					</div>
					<div class='field is-grouped'>
						<div class='control'>
							<button type='submit' class='button is-link btn128'>Voltar</button>
						</div>
						<div class='control'>
							<a href='register.php' class='button is-link btn128'>Cancelar</a>
						</div>
					</div>						  	
					</form>";

				}
											
				if (mysqli_num_rows($cnx) == 0 && mysqli_num_rows($cnx2) == 0 && mysqli_num_rows($cnx3) == 0) {					
					echo "<script>alert('Nenhuma pergunta foi encontrada com o filtro aplicado!'); window.location.href='question-query.php';</script>";

				} else if (mysqli_num_rows($cnx) == 0 && mysqli_num_rows($cnx2) == 0 && mysqli_num_rows($cnx3) > 0) {					
					echo "<script>alert('Nenhuma pergunta Técnica ou Comportamental encontrada com o filtro aplicado!');</script>";
				}							
			}
	     	?>	     	
	   	</div>
	</section>	 	
</body>
</html>