<?php 
$menuAtivo = 'configuracoes';
require('menu.php');

if($_SESSION["permissao"] == 1) {
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
	<title>Gestão de Desempenho - Remover Pergunta</title>
</head>
<body>
	<section class="section">
	  	<div class="container">
		<?php if (isset($_POST["query"]) == null) { ?>
	   		<form action="question-remove.php" method="POST" id="form" onsubmit="return check()">
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
			
			if ($_POST['cargo'] != "" ) : {?>
					
				<form id="form2" action="" method="POST">	
				<div class="box">Técnicas</div><?php 
				$x = 0; 
				$y = 0;		
				
				$cnx = mysqli_query($phpmyadmin, "SELECT ID, PERGUNTA, SITUACAO FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=".$tecnica." AND CARGO_ID=".$_POST['cargo']." ".$_POST['situacao']." ORDER BY ORDEM;");
				
				if (mysqli_num_rows($cnx) > 0) {
					while ($pergunta = $cnx->fetch_array()) { ?>
						<div class="box">
							<input type="checkbox" name="idTec[]" value="<?php echo $pergunta["ID"];?>"> Remover:
							<div class="field">						
								<div class="control">
									<label><?php echo $pergunta["PERGUNTA"];?></label>									
								</div>			
							</div>							
							<div class="control">
								<label>Situação: <?php echo $pergunta["SITUACAO"];?></label>								
							</div>																				
						</div>
						<?php

						$x++;
					} 
				}	
				//<!--PERGUNTA COMPORTAMENTAL-->
				echo '<div class="box">Comportamentais</div>';
				
				$cnx2 = mysqli_query($phpmyadmin, "SELECT ID, PERGUNTA, SITUACAO FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=".$comportamental." AND CARGO_ID=".$_POST['cargo']." ".$_POST['situacao']." ORDER BY ORDEM;");
				
				if (mysqli_num_rows($cnx2) > 0) {
					while ($pergunta = $cnx2->fetch_array()) { ?>
						<div class="box">
							<input type="checkbox" name="idCom[]" value="<?php echo $pergunta["ID"];?>"> Remover:
							<div class="field">						
								<div class="control">
									<label><?php echo $pergunta["PERGUNTA"];?></label>	
								</div>			
							</div>
							<div class="control">
								<label>Situação: <?php echo $pergunta["SITUACAO"];?></label>
							</div>																				
						</div>
						<?php 
						$y++;
					}
				}//<!--FINAL PERGUNTA COMPORTAMENTAL-->

				$cnx3 = mysqli_query($phpmyadmin, "SELECT ID, PERGUNTA, SITUACAO FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID=2 ".$_POST['situacao']);
				$getComentario = $cnx3->fetch_array();			
				
				?>
					<div class="box">
						<label>Comentário</label>
					</div>	
					<div class="box">
						<input type="checkbox" name="idCome" value="<?php echo $getComentario["ID"];?>"> Remover:	
						<div class="field">
							<label><?php echo $getComentario["PERGUNTA"];?></label>
						</div>
						<div class="control">
							<label>Situação: <?php echo $getComentario["SITUACAO"];?></label>								
						</div>						
					</div>
					<div class="field is-grouped">						  	
						<div class="control">
						   	<button class="button is-link is-light btn128" name="remover" type="submit">Remover</button>
						</div>
					 	<div  class="control">
					  		<a href="question-remove.php" class="button is-link is-light btn128" type="button">Voltar</a>
					  	</div>
					  	<div  class="control">
					  		<a href="register.php" class="button is-link is-light btn128" type="button">Cancelar</a>
					  	</div>
					</div>									
					</form>
				<?php }endif;				
				if (mysqli_num_rows($cnx) == 0 && mysqli_num_rows($cnx2) == 0 && mysqli_num_rows($cnx3) == 0) {					
					echo "<script>alert('Nenhuma pergunta foi encontrada com o filtro aplicado!'); window.location.href='question-remove.php';</script>";

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

if (isset($_POST["remover"]) != null) {	
	$noDown = 0; 
	$selectTotal = 0;
	
	function checkAvalicaoRealizada($tabela, $id){//FUNÇÃO P/ VERIFICAR E DELETAR APENAS PERGUNTAS QUE NÃO HOUVERAM REGISTRO NA TABELA AVAL
		require('connection.php');
		global $noDown;
		
		if ($tabela == "AVAL_PERGUNTA") {
			$checkAvaliacao="SELECT ID FROM AVAL_REALIZADA WHERE AVAL_PERGUNTA_ID=".$id.";";
		} else {
			$checkAvaliacao="SELECT ID FROM AVAL_COMENTARIO WHERE AVAL_PERGUNTA_COM_ID=".$id.";";
		}	
		
		if (mysqli_num_rows(mysqli_query($phpmyadmin, $checkAvaliacao)) == 0) {
			mysqli_query($phpmyadmin, "DELETE FROM ".$tabela." WHERE ID=".$id);
		} else {							
			$noDown++;
		}			
	}

	if (isset($_POST['idTec'])) {
		$x = 0;
		$idTec = array_filter($_POST['idTec']);
		
		while ($x < sizeof($idTec)) {
			checkAvalicaoRealizada("AVAL_PERGUNTA", $idTec[$x]);
			$x++;			
		}		
	}
	
	if (isset($_POST['idCom'])) {
		$y = 0;
		$idCom = array_filter($_POST['idCom']);
		
		while ($y < sizeof($idCom)) {
			checkAvalicaoRealizada("AVAL_PERGUNTA", $idCom[$y]);
			$y++;			
		}
	}
	
	if (isset($_POST['idCome'])) {
		$z = 0;
		$idCome = trim($_POST['idCome']);
		
		while ($z < sizeof($idCome)) {
			checkAvalicaoRealizada("AVAL_PERGUNTA_COM", $idCome[$z]);
			$z++;			
		}
	}

	echo $noDown;				
	
	if ($noDown == 0) {
		echo "<script>alert('Remoção realizada com sucesso!');</script>";
	}
	else if ($noDown == 1) {
		echo "<script>alert('".$noDown." pergunta selecionada já teve avaliação realizada, portanto, não pode ser deletada. Sugestão: altere a situação p/ inativo!');</script>"; 
	} else {
		echo "<script>alert('".$noDown." perguntas selecionadas já tiveram avaliação realizada, portanto, não pode ser deletada. Sugestão: altere a situação p/ inativo!');</script>"; 
	}			
}
