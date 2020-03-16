<?php 
$menuAtivo="configuracoes";
require('menu.php');
if($_SESSION["permissao"]==1){
	echo "<script>alert('Usuário sem permissão')</script>";
	header("Refresh:1;url=home.php");
}
else{
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Conuslta Pergunta</title>
</head>
<body>
	<section class="section">
	  	<div class="container">
	  		<?php if(isset($_POST["consultar"])==null):?>
	   		<form action="question-query.php" method="POST">
	    		<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Tipo:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="tipo">
									<?php $gdDestino="SELECT ID, TIPO FROM AVAL_TIPO WHERE SITUACAO='Ativo' ORDER BY ID";
									$con = mysqli_query($phpmyadmin , $gdDestino); $x=0; 
									while($destino = $con->fetch_array()):{?>
									<option value="<?php echo $vtId[$x] = $destino["ID"]; ?>"><?php echo $vtNome[$x] = $destino["TIPO"]; ?></option>
									<?php $x;} endwhile;?>
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Cargo:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="cargo" id="cargo">
									<option value="">Selecione</option>
									<?php $query = "SELECT ID, NOME FROM CARGO WHERE SITUACAO='Ativo' ORDER BY NOME";
										$cnx = mysqli_query($phpmyadmin, $query);
										while($reCargo = mysqli_fetch_assoc($cnx)) {
											echo '<option value="'.$reCargo['ID'].'">'.$reCargo['NOME'].'</option>';
										}?>
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>								
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Situação:</label>
					</div>
					<div class="field-body">
						<div class="field is-grouped" style="max-width:17em;">							
							<div class="control">
								<div class="select">
									<select name="situacao" id="situacao">
										<option selected="selected" value="Ativo">Ativo</option>
										<option value="Inativo">Inativo</option>
										<option value="">Todas</option>
									</select>	
								</div>
							</div>
							<div class="control">
								<button name="consultar" type="submit" class="button is-primary" value="Filtrar">Consultar</button>
							</div>						
						</div>
					</div>					
				</div>
	     	</form><?php endif;
	     	if(isset($_POST["consultar"])!=null){
				$tipo=trim($_POST['tipo']);
				$cargo=trim($_POST['cargo']);
				$situacao=trim($_POST['situacao']);
				if($cargo!="" ):{?>
					
					<form id="form2" action="" method="POST">	
					<div class="box">Técnicas</div><?php $y=1;		
					$getPergunta="SELECT ID, PERGUNTA FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=3 AND CARGO_ID=".$cargo." ORDER BY ORDEM;";//VERIFICA SE HÁ PERGUNTA P/ CARGO DO USUÁRIO.
					$cnx=mysqli_query($phpmyadmin, $getPergunta);
					while ($pergunta=$cnx->fetch_array()):{ ?>
					<div class="box">	
						<div class="field is-horizontal">
							<div class="text"><?php echo $pergunta["PERGUNTA"];?></div>				
						</div>								
					</div>
				<?php $y++;}endwhile;?>	<!--PERGUNTA COMPORTAMENTAL-->
					<div class="box">Comportamentais</div><?php
					$getPergunta="SELECT ID, PERGUNTA FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=4 AND CARGO_ID=".$cargo." ORDER BY ORDEM;";
					$cnx=mysqli_query($phpmyadmin, $getPergunta);
					while ($pergunta=$cnx->fetch_array()):{ ?>
					<div class="box">	
						<div class="field is-horizontal">
							<div class="text"><?php echo $pergunta["PERGUNTA"];?></div>				
						</div>								
					</div>
				<?php $y++;}endwhile; //<!--FINAL PERGUNTA COMPORTAMENTAL-->
					$getPerComentario="SELECT ID, PERGUNTA FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID=2 AND SITUACAO='Ativo'";
					$cnx7=mysqli_query($phpmyadmin, $getPerComentario);
					$getComentario=$cnx7->fetch_array();					
					?>
					<div class="box">	
						<div class="field">
						  	<label class="label"><?php echo $getComentario["PERGUNTA"];?></label>
						</div>
						<div class="field is-grouped">
						  	<div class="control">
						    	<input type="button" class="button is-link" value="Voltar" onclick="window.location.href='question-query.php'">
						  	</div>						  	
						</div>
					</div>									
					</form>

				<?php }endif;				
				if($cargo==null){
					echo "<script>alert('A seleção do Cargo é obrigatório!!')</script>";
				}	
			}
	     	?>	     	
	   	</div>
	</section>	 	
</body>
</html><?php 
}//ELSE - caso o usuário tenha permissão.