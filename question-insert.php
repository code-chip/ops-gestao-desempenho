<?php 
$menuAtivo="configuracoes";
require('menu.php');
if($_SESSION["permissao"]==1){
	echo "<script>alert('Usuário sem permissão')</script>";
	header("Refresh:1;url=home.php");
}
else{
if(isset($_POST["inserirPergunta"])!=null){
$tipo=trim($_POST['tipo']);
$classificacao=trim($_POST['classificacao']);
$resposta=trim($_POST['resposta']);
$cargo=trim($_POST['cargo']);
$pergunta=trim($_POST['pergunta']);
$situacao=trim($_POST['situacao']);
	if($cargo!="" && $pergunta!=""){
		if($resposta=="checkbox"){
			if($tipo==2){
				$classificacao=$classificacao+2;
			}
			$insPergunta="INSERT INTO AVAL_PERGUNTA(AVAL_TIPO_PERGUNTA_ID, CARGO_ID, PERGUNTA, SITUACAO) VALUES(".$classificacao.",".$cargo.",'".$pergunta."','".$situacao."');";			
		}
		else{
			$insPergunta="INSERT INTO AVAL_PERGUNTA_COM(AVAL_TIPO_ID, CARGO_ID, PERGUNTA, SITUACAO) VALUES(".$tipo.",'".$pergunta."','".$situacao."');";
		}
		echo $insPergunta;
		$cnx= mysqli_query($phpmyadmin, $insPergunta);		
		echo "<script>alert('Pegunta cadastrada com sucesso.')</script>";	
	}
	else if($cargo==""){
		echo "<script>alert('A seleção do Cargo é obrigatório!!')</script>";
	}
	else{
		echo "<script>alert('Preencher o campo Pergunta é obrigatório!!')</script>";
	}	
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">	
	<meta name="viewport" content="width=device-widht, initial-scale=1">
	<title>Gestão de Desempenho - Inserir Pergunta</title>
</head>
<body>
	<section class="section">
	  	<div class="container">
	   		<form action="question-insert.php" method="POST">
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
						<label class="label">Classificação:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="classificacao">									
										<option value="1">Técnicas</option>
										<option value="2">Comportamentais</option>		
									</select>	
								</div>
							</div>						
						</div>
					</div>
				</div>
				<div class="field is-horizontal">
					<div class="field-label is-normal">
						<label class="label">Resposta:</label>
					</div>
					<div class="field-body">
						<div class="field" >							
							<div class="control" style="max-width:17em;">
								<div class="select is-size-7-touch">
									<select name="resposta">									
									<option value="checkbox">Por checkbox</option>
									<option value="comentario">Por comentário</option>
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
						<label class="label">Pergunta:</label>
					</div>
					<div class="field-body">
						<div class="field" style="max-width:17em;">							
							<div class="control">
								<textarea name="pergunta" class="textarea" maxlenght="1000"></textarea>
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
									</select>	
								</div>
							</div>
							<div class="control">
								<button name="inserirPergunta" type="submit" class="button is-primary" value="Filtrar">Inserir</button>
							</div>
							<div class="control">
								<a href="register.php" class="button is-primary">Voltar</a>	
							</div>						
						</div>
					</div>					
				</div>
	     	</form>	     	
	   	</div>
	</section>	 	
</body>
</html><?php }//ELSE - caso o usuário tenha permissão.