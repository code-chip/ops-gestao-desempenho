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
	<title>Gestão de Desempenho - Remover Pergunta</title>
</head>
<body>
	<section class="section">
	  	<div class="container">
	  		<?php if(isset($_POST["consultar"])==null):?>
	   		<form action="question-remove.php" method="POST">
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
					<?php $x++;}endwhile; }endif; ?>	<!--PERGUNTA COMPORTAMENTAL-->
					<div class="box">Comportamentais</div><?php
					$getPergunta="SELECT ID, PERGUNTA, SITUACAO FROM AVAL_PERGUNTA WHERE AVAL_TIPO_PERGUNTA_ID=".$comportamental." AND CARGO_ID=".$cargo." ".$situacao." ORDER BY ORDEM;";
					$cnx2=mysqli_query($phpmyadmin, $getPergunta);
					if(mysqli_num_rows($cnx2)>0):{
					while ($pergunta=$cnx2->fetch_array()):{ ?>
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
					<?php $y++;}endwhile; }endif; //<!--FINAL PERGUNTA COMPORTAMENTAL-->
					$getPerComentario="SELECT ID, PERGUNTA, SITUACAO FROM AVAL_PERGUNTA_COM WHERE AVAL_TIPO_ID=2 ".$situacao;
					$cnx3=mysqli_query($phpmyadmin, $getPerComentario);
					$getComentario=$cnx3->fetch_array();			
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
						   	<button class="button is-link is-light" name="remover" type="submit"> Remover</button>
						</div>
					 	<div  class="control">
					  		<a href="question-remove.php" class="button is-primary" type="button">Voltar</a>
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
	if(isset($_POST["remover"])!=null){	
		$noDown=0; $selectTotal=0;
		function checkAvalicaoRealizada($tabela, $id){//FUNÇÃO P/ VERIFICAR E DELETAR APENAS PERGUNTAS QUE NÃO HOUVERAM REGISTRO NA TABELA AVAL
			require('connection.php');
			global $noDown;
			if($tabela=="AVAL_PERGUNTA"){
				$checkAvaliacao="SELECT ID FROM AVAL_REALIZADA WHERE AVAL_PERGUNTA_ID=".$id.";";
			}
			else{
				$checkAvaliacao="SELECT ID FROM AVAL_COMENTARIO WHERE AVAL_PERGUNTA_COM_ID=".$id.";";
			}	
			if(mysqli_num_rows(mysqli_query($phpmyadmin, $checkAvaliacao))==0){
				$downQuestion="DELETE FROM ".$tabela." WHERE ID=".$id;
				mysqli_query($phpmyadmin, $downQuestion);
			}
			else{							
				$noDown++;
			}			
		}
		if(isset($_POST['idTec'])){
			$x=0;
			$idTec=array_filter($_POST['idTec']);
			while ($x<sizeof($idTec)) {
				checkAvalicaoRealizada("AVAL_PERGUNTA", $idTec[$x]);
				$x++;			
			}		
		}
		if(isset($_POST['idCom'])){
			$y=0;
			$idCom=array_filter($_POST['idCom']);
			while ($y<sizeof($idCom)) {
				checkAvalicaoRealizada("AVAL_PERGUNTA", $idCom[$y]);
				$y++;			
			}
		}
		if(isset($_POST['idCome'])){
			$z=0;
			$idCome=trim($_POST['idCome']);
			while ($z<sizeof($idCome)) {
				checkAvalicaoRealizada("AVAL_PERGUNTA_COM", $idCome[$z]);
				$z++;			
			}
		}		
		echo $noDown;				
		if($noDown==0){
			echo "<script>alert('Remoção realizada com sucesso!');</script>";
		}
		else if($noDown==1){
			echo "<script>alert('".$noDown." pergunta selecionada já teve avaliação realizada, portanto, não pode ser deletada. Sugestão: altere a situação p/ inativo!');</script>"; 
		}
		else{
			echo "<script>alert('".$noDown." perguntas selecionadas já tiveram avaliação realizada, portanto, não pode ser deletada. Sugestão: altere a situação p/ inativo!');</script>"; 
		}			
	}
}//ELSE - caso o usuário tenha permissão.