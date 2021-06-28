<?php 
$menuAtivo = 'configuracoes';
require('menu.php');

if($_SESSION["permissao"]==1){
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
	<title>Gestão de Desempenho - Atualizar Pergunta</title>
</head>
<body>
	<section class="section">
	  	<div class="container">
	  	<?php if (isset($_POST["query"]) == null) { ?>
	   		<form action="question-update.php" method="POST" id="form" onsubmit="return check()">
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
	    <?php }

	    if (isset($_POST["query"]) != null) {
			if ($_POST['type'] == 1) {//OS ID REFERÊNCIA P/ TÉCNICO E COMPORTAMENTAL.
				$tecnica = 1;
				$comportamental = 2;
			} else {
				$tecnica = 3;
				$comportamental = 4;
			}

			if ($_POST['cargo'] != "" ) : {
					
				echo '<form id="form2" action="" method="POST">';	
				echo '<div class="box">Técnicas</div>'; 
				$x = 0; 
				$y = 0;		
					
				$cnx = mysqli_query($phpmyadmin, "SELECT ID, PERGUNTA, SITUACAO FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=".$tecnica." AND CARGO_ID=".$_POST['cargo']." ".$_POST['situacao']." ORDER BY ORDEM;");//VERIFICA SE HÁ PERGUNTA P/ CARGO DO USUÁRIO.
					
				if (mysqli_num_rows($cnx) > 0) {
					while ($pergunta = $cnx->fetch_array()) { ?>
						<div class="box">
							<input type="hidden" name="idTec[]" value="<?php echo $pergunta["ID"];?>">
							<div class="field">						
								<div class="control">
									<textarea name="tecnica[]" class="textarea" maxlength="1000"><?php echo $pergunta["PERGUNTA"];?></textarea>
								</div>			
							</div>							
							<div class="control">
								<div class="select is-fullwidth">
									<select name="situacaoTec[]" id="situacao"><?php 
										if ($pergunta["SITUACAO"] == "Ativo") { 
											echo "<option selected='selected' value='Ativo'>Ativo</option>";
											echo "<option value='Inativo'>Inativo</option>";
										} else {
											echo "<option selected='selected' value='Inativo'>Inativo</option>";
											echo "<option value='Ativo'>Ativo</option>"; 
										}
										?>
									</select>	
								</div>
							</div>																				
						</div>
						<?php 
						
						$x++;
					} 
				} //<!--PERGUNTA COMPORTAMENTAL-->

				echo '<div class="box">Comportamentais</div>';

				$cnx2 = mysqli_query($phpmyadmin, "SELECT ID, PERGUNTA, SITUACAO FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=".$comportamental." AND CARGO_ID=".$_POST['cargo']." ".$_POST['situacao']." ORDER BY ORDEM;");
				
				if (mysqli_num_rows($cnx2) > 0) {
					while ($pergunta = $cnx2->fetch_array()) { ?>
						<div class="box">
							<input type="hidden" name="idCom[]" value="<?php echo $pergunta["ID"];?>">
							<div class="field">						
								<div class="control">
									<textarea name="comportamental[]" class="textarea" placeholder="<?php echo $pergunta["PERGUNTA"];?>" maxlength="1000"><?php echo $pergunta["PERGUNTA"];?></textarea>
								</div>			
							</div>
							<div class="control">
								<div class="select is-fullwidth">
									<select name="situacaoCom[]" id="situacao"><?php 
										if ($pergunta["SITUACAO"] == "Ativo") { 
											echo "<option selected='selected' value='Ativo'>Ativo</option>";
											echo "<option value='Inativo'>Inativo</option>";
										} else {
											echo "<option selected='selected' value='Inativo'>Inativo</option>";
											echo "<option value='Ativo'>Ativo</option>"; 
										}
										?>
									</select>	
								</div>
							</div>																				
						</div>
						<?php 
						$y++;
					} 
				} //<!--FINAL PERGUNTA COMPORTAMENTAL-->
				
				$cnx3 = mysqli_query($phpmyadmin, "SELECT ID, PERGUNTA, SITUACAO FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID=2 ".$_POST['situacao']);
				$getComentario = $cnx3->fetch_array();			
					
				?>
				<div class="box">
					<label>Comentário</label>
				</div>	
				<div class="box">
					<input type="hidden" name="idCome" value="<?php echo $getComentario["ID"];?>">	
					<div class="field">
						<textarea type="text" class="textarea" name="comentario"><?php echo $getComentario["PERGUNTA"];?></textarea>
					</div>
					<div class="control">
						<div class="select is-fullwidth">
							<select name="situacaoCome" id="situacao"><?php 
								if ($getComentario["SITUACAO"] == "Ativo") { 
									echo "<option selected='selected' value='Ativo'>Ativo</option>";
									echo "<option value='Inativo'>Inativo</option>";
								} else {
									echo "<option selected='selected' value='Inativo'>Inativo</option>";
									echo "<option value='Ativo'>Ativo</option>"; 
								}
							?>
							</select>	
						</div>
					</div>						
				</div>
				<div class="field is-grouped">						  	
					<div class="control">
					   	<button name="update" class="button is-link is-light btn128"  type="submit">Atualizar</button>
					</div>
				 	<div  class="control">
				  		<a href="question-update.php" class="button is-link is-light btn128" type="button">Voltar</a>
				  	</div>
				  	<div  class="control">
				  		<a href="register.php" class="button is-link is-light btn128" type="button">Cancelar</a>
				  	</div>
				</div>									
				</form>
				<?php } endif;				
				
				if (mysqli_num_rows($cnx) == 0 && mysqli_num_rows($cnx2) == 0 && mysqli_num_rows($cnx3) == 0) {					
					echo "<script>alert('Nenhuma pergunta foi encontrada com o filtro aplicado!'); window.location.href='question-query.php';</script>";

				} elseif (mysqli_num_rows($cnx) == 0 && mysqli_num_rows($cnx2) == 0 && mysqli_num_rows($cnx3) > 0) {					
					echo "<script>alert('Nenhuma pergunta Técnica ou Comportamental encontrada com o filtro aplicado!');</script>";
				}
			}

	     	?>	     	
	   	</div>
	</section>	 	
</body>
</html>
<?php

if (isset($_POST["update"]) != null) {		 
	if (isset($_POST['idTec'])) {
		$idTec = array_filter($_POST['idTec']);
		$tecnicas = array_filter($_POST['tecnica']);
		$situacaoTec = array_filter($_POST['situacaoTec']);
		
		$x = 0;
		
		while ($x < sizeof($idTec)) {
			mysqli_query($phpmyadmin, "UPDATE AVAL_PERGUNTA SET PERGUNTA='".$tecnicas[$x]."', SITUACAO='".$situacaoTec[$x]."' WHERE ID=".$idTec[$x].";");
			$x++;
		}
	}

	if (isset($_POST['idCom'])) {			
		$idCom = array_filter($_POST['idCom']);
		$comportamentais = array_filter($_POST['comportamental']);
		$situacaoCom = array_filter($_POST['situacaoCom']);
		$y = 0;
	
		while ($y < sizeof($idCom)) {
			mysqli_query($phpmyadmin, "UPDATE AVAL_PERGUNTA SET PERGUNTA='".$comportamentais[$y]."', SITUACAO='".$situacaoCom[$y]."' WHERE ID=".$idCom[$y].";");
			$y++;
		}
	}
	
	if (isset($_POST['idCome'])) {	
		$idCome = trim($_POST['idCome']);
		$comentario = trim($_POST['comentario']);
		$situacaoCome = trim($_POST['situacaoCome']);	
		mysqli_query($phpmyadmin, "UPDATE AVAL_PERGUNTA_COM SET PERGUNTA='".$comentario."', SITUACAO='".$situacaoCome."' WHERE ID=".$idCome.";");
	}	
	
	echo "<script>alert('Atualização realizada com sucesso.')</script>";		

}
