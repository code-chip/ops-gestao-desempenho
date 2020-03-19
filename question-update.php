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
	<title>Gestão de Desempenho - Atualizar Pergunta</title>
</head>
<body>
	<section class="section">
	  	<div class="container">
	  		<?php if(isset($_POST["consultar"])==null):?>
	   		<form action="question-update.php" method="POST">
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
										<option selected="selected" value="AND SITUACAO='Ativo'">Ativo</option>
										<option value="AND SITUACAO='Inativo'">Inativo</option>
										<option value="">Todas</option>
									</select>	
								</div>
							</div>
							<div class="control">
								<button name="consultar" type="submit" class="button is-primary" value="Filtrar">Consultar</button>
							</div>
							<div>
						  		<a href="register.php" class="button is-primary" type="button">Voltar</a>
						  	</div>						
						</div>
					</div>					
				</div>
	     	</form><?php endif;
	     	if(isset($_POST["consultar"])!=null){
				$tipo=trim($_POST['tipo']);
				$cargo=trim($_POST['cargo']);
				$situacao=trim($_POST['situacao']);
				if($tipo==1){//OS ID REFERÊNCIA P/ TÉCNICO E COMPORTAMENTAL.
					$tecnica=1;
					$comportamental=2;
				}
				else{
					$tecnica=3;
					$comportamental=4;
				}
				if($cargo!="" ):{?>
					
					<form id="form2" action="" method="POST">	
					<div class="box">Técnicas</div><?php $x=0; $y=0;		
					$getPergunta="SELECT ID, PERGUNTA, SITUACAO FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=".$tecnica." AND CARGO_ID=".$cargo." ".$situacao." ORDER BY ORDEM;";//VERIFICA SE HÁ PERGUNTA P/ CARGO DO USUÁRIO.
					$cnx=mysqli_query($phpmyadmin, $getPergunta);
					if(mysqli_num_rows($cnx)>0):{
					while ($pergunta=$cnx->fetch_array()):{ ?>
						<div class="box">
							<input type="hidden" name="idTec[]" value="<?php echo $pergunta["ID"];?>">
							<div class="field">						
								<div class="control">
									<input name="tecnica[]" type="text" class="input" placeholder="<?php echo $pergunta["PERGUNTA"];?>" maxlength="1000" value="<?php echo $pergunta["PERGUNTA"];?>">
								</div>			
							</div>							
							<div class="control">
								<label>Situação:</label>
								<div class="select">
									<select name="situacaoTec[]" id="situacao">
										<?php if($pergunta["SITUACAO"]=="Ativo"):{?>
										<option selected="selected" value="Ativo">Ativo</option>
										<option value="Inativo">Inativo</option><?php }endif; ?>
										<?php if($pergunta["SITUACAO"]=="Inativo"):{?>
										<option selected="selected" value="Inativo">Inativo</option>
										<option value="Ativo">Ativo</option><?php }endif; ?>
									</select>	
								</div>
							</div>																				
						</div>
					<?php $x++;}endwhile; }endif; ?>	<!--PERGUNTA COMPORTAMENTAL-->
					<div class="box">Comportamentais</div><?php
					$getPergunta="SELECT ID, PERGUNTA, SITUACAO FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=".$comportamental." AND CARGO_ID=".$cargo." ".$situacao." ORDER BY ORDEM;";
					$cnx2=mysqli_query($phpmyadmin, $getPergunta);
					if(mysqli_num_rows($cnx2)>0):{
					while ($pergunta=$cnx2->fetch_array()):{ ?>
						<div class="box">
							<input type="hidden" name="idCom[]" value="<?php echo $pergunta["ID"];?>">
							<div class="field">						
								<div class="control">
									<input name="comportamental[]" type="text" class="input" placeholder="<?php echo $pergunta["PERGUNTA"];?>" maxlength="1000" value="<?php echo $pergunta["PERGUNTA"];?>">
								</div>			
							</div>
							<div class="control">
								<label>Situação:</label>
								<div class="select">
									<select name="situacaoCom[]" id="situacao">
										<?php if($pergunta["SITUACAO"]=="Ativo"):{?>
										<option selected="selected" value="Ativo">Ativo</option>
										<option value="Inativo">Inativo</option><?php }endif; ?>
										<?php if($pergunta["SITUACAO"]=="Inativo"):{?>
										<option selected="selected" value="Inativo">Inativo</option>
										<option value="Ativo">Ativo</option><?php }endif; ?>
									</select>	
								</div>
							</div>																				
						</div>
					<?php $y++;}endwhile; }endif; //<!--FINAL PERGUNTA COMPORTAMENTAL-->
					$getPerComentario="SELECT ID, PERGUNTA, SITUACAO FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID=2 ".$situacao;
					$cnx3=mysqli_query($phpmyadmin, $getPerComentario);
					$getComentario=$cnx3->fetch_array();			
					?>
					<div class="box">
						<label>Comentário</label>
					</div>	
					<div class="box">
						<input type="hidden" name="idCome" value="<?php echo $getComentario["ID"];?>">	
						<div class="field">
							<input type="text" name="comentario" class="input" value="<?php echo $getComentario["PERGUNTA"];?>">
						</div>
						<div class="control">
								<label>Situação:</label>
								<div class="select">
									<select name="situacaoCome" id="situacao">
										<?php if($getComentario["SITUACAO"]=="Ativo"):{?>
										<option selected="selected" value="Ativo">Ativo</option>
										<option value="Inativo">Inativo</option><?php }endif; ?>
										<?php if($getComentario["SITUACAO"]=="Inativo"):{?>
										<option selected="selected" value="Inativo">Inativo</option>
										<option value="Ativo">Ativo</option><?php }endif; ?>
									</select>	
								</div>
							</div>						
					</div>
					<div class="field is-grouped">						  	
						<div class="control">
						   	<button class="button is-link is-light" name="atualizar" type="submit">Atualizar</button>
						</div>
					 	<div  class="control">
					  		<a href="question-update.php" class="button is-primary" type="button">Voltar</a>
					  	</div>
					</div>									
					</form>
				<?php }endif;				
				if($cargo==null){
					echo "<script>alert('A seleção do Cargo é obrigatório!!'); window.location.href='question-update.php';</script>";
				}
				else{
					if(mysqli_num_rows($cnx)==0 && mysqli_num_rows($cnx2)==0 && mysqli_num_rows($cnx3)==0){					
					echo "<script>alert('Nenhuma pergunta foi encontrada com o filtro aplicado!'); window.location.href='question-query.php';</script>";

					}
					else if(mysqli_num_rows($cnx)==0 && mysqli_num_rows($cnx2)==0 && mysqli_num_rows($cnx3)>0){					
						echo "<script>alert('Nenhuma pergunta Técnica ou Comportamental encontrada com o filtro aplicado!');</script>";
					}
				}	
			}
	     	?>	     	
	   	</div>
	</section>	 	
</body>
</html><?php
	if(isset($_POST["atualizar"])!=null){
		$tecnicas=array_filter($_POST['tecnica']);
		$comportamentais=array_filter($_POST['comportamental']);
		$situacaoTec=array_filter($_POST['situacaoTec']);
		$situacaoCom=array_filter($_POST['situacaoCom']);
		$idTec=array_filter($_POST['idTec']);
		$idCom=array_filter($_POST['idCom']);
		$idCome=trim($_POST['idCome']);
		$comentario=trim($_POST['comentario']);
		$situacaoCome=trim($_POST['situacaoCome']);
		$x=0; $y=0;
		if($idTec!=null){
			while ($x < sizeof($idTec)) {
				$upPerguntaTec="UPDATE AVAL_PERGUNTA SET PERGUNTA='".$tecnicas[$x]."', SITUACAO='".$situacaoTec[$x]."' WHERE ID=".$idTec[$x].";";
				mysqli_query($phpmyadmin, $upPerguntaTec);
				$x++;
			}
		}
		if($idTec!=null){
			while ($y < sizeof($idCom)) {
				$upPerguntaCom="UPDATE AVAL_PERGUNTA SET PERGUNTA='".$comportamentais[$y]."', SITUACAO='".$situacaoCom[$y]."' WHERE ID=".$idCom[$y].";";
				mysqli_query($phpmyadmin, $upPerguntaCom);
				$y++;
			}
		}	
		$upComentario="UPDATE AVAL_PERGUNTA_COM SET PERGUNTA='".$comentario."', SITUACAO='".$situacaoCome."' WHERE ID=".$idCome.";";
		mysqli_query($phpmyadmin, $upComentario);
		echo "<script>alert('Atualização realizada com sucesso.')</script>";		
	}
}//ELSE - caso o usuário tenha permissão.