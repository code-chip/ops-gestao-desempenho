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
	<title>Gestão de Desempenho - Conuslta Pergunta</title>
	<style type="text/css" scr="css/personal.css"></style>
	<script type="text/javascript" src="js/myjs.js"></script>
</head>
<body>
	<section class="section">
	  	<div class="container">
	  	<?php if (isset($_POST["consultar"]) == null) :?>
	   		<form action="question-query.php" method="POST" onsubmit="return check()">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Tipo*</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control">
								<div class="select is-size-7-touch">
									<select name="tipo" class="w24-2e"><?php
										$con = mysqli_query($phpmyadmin , "SELECT ID, TIPO FROM AVAL_TIPO WHERE SITUACAO='Ativo' ORDER BY ID"); 
										while ($destino = $con->fetch_array()) {
											echo "<option value=" . $destino["ID"] . ">" . $destino["TIPO"] . "</option>";
										}
										?>
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Cargo*</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control">
								<div class="select is-size-7-touch">
									<select name="cargo" id="cargo" class="required w24-2e">
									<option value="">Selecione</option><?php
										$cnx = mysqli_query($phpmyadmin, "SELECT ID, NOME FROM CARGO WHERE SITUACAO='Ativo' ORDER BY NOME");
										while($reCargo = mysqli_fetch_assoc($cnx)) {
											echo "<option value=" . $reCargo["ID"] . ">" . $reCargo["NOME"] . "</option>";
										}
										?>
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>								
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Situação*</label>
					</div>
					<div class="field-body">
						<div class="field is-grouped">							
							<div class="control">
								<div class="select">
									<select name="situacao" id="situacao" class="w24-2e">
										<option selected="selected" value="AND SITUACAO='Ativo'">Ativo</option>
										<option value="AND SITUACAO='Inativo'">Inativo</option>
										<option value="">Todas</option>
									</select>	
								</div>
							</div>
						</div>
					</div>					
				</div>
				<div class="field-body">
					<div class="field is-grouped"></div>
						<div class="control">
							<button name="consultar" type="submit" class="button is-primary btn128" value="Filtrar">Consultar</button>
						</div>
						<div class="control">
							<a href="register.php" class="button is-primary btn128">Voltar</a>	
						</div>
					</div>
				</div>	
	     	</form>
	    <?php endif;
	     	
	     if (isset($_POST["consultar"]) != null) {
			if ($_POST['tipo'] == 1) {//OS ID REFERÊNCIA P/ TÉCNICO E COMPORTAMENTAL.
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