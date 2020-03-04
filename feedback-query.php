<?php
$menuAtivo="Feedback";
include('menu.php');
$tipo= trim($_POST["tipo"]);
$feedback= trim($_POST["feedback"]);
$contador = 0;
if(isset($_POST['consultar']) && $tipo=="feedback"){
	if($feedback=="REMETENTE_ID"){
		$query="SELECT F.ID, U.NOME AS REMETENTE, U2.NOME AS DESTINATARIO, F.TIPO, F.FEEDBACK, F.EXIBICAO, F.PROFISSIONAL, F.COMPORTAMENTAL, F.DESEMPENHO, F.SITUACAO FROM FEEDBACK F INNER JOIN USUARIO U ON U.ID=F.REMETENTE_ID INNER JOIN USUARIO U2 ON U2.ID=F.DESTINATARIO_ID WHERE ".$feedback."=".$_SESSION["userId"]." ORDER BY F.REGISTRO DESC";
	}
	else{
		$query="SELECT F.ID, U.NOME AS REMETENTE, U2.NOME AS DESTINATARIO, F.TIPO, F.FEEDBACK, F.EXIBICAO, F.PROFISSIONAL, F.COMPORTAMENTAL, F.DESEMPENHO, F.SITUACAO FROM FEEDBACK F INNER JOIN USUARIO U ON U.ID=F.REMETENTE_ID INNER JOIN USUARIO U2 ON U2.ID=F.DESTINATARIO_ID WHERE ".$feedback."=".$_SESSION["userId"]." AND F.SITUACAO IN('Aprovado','Lido') ORDER BY F.REGISTRO DESC";
	}	
	$x=0;
	$cnx=mysqli_query($phpmyadmin, $query);
	while($feed= $cnx->fetch_array()){
		$vtId[$x]=$feed["ID"];
		$vtRemetente[$x]=$feed["REMETENTE"];
		$vtDestinatario[$x]=$feed["DESTINATARIO"];
		$vtTipo[$x]=$feed["TIPO"];
		$vtProfissional[$x]=$feed["PROFISSIONAL"];
		$vtComportamental[$x]=$feed["COMPORTAMENTAL"];
		$vtDesempenho[$x]=$feed["DESEMPENHO"];
		$vtExibicao[$x]=$feed["EXIBICAO"];
		$vtSituacao[$x]=$feed["SITUACAO"];
		$vtFeedback[$x]=$feed["FEEDBACK"];
		$x++;
		$contador=$x;
	}
	if(mysqli_num_rows($cnx)==0){
		?><script type="text/javascript">			
			alert('Nenhum feedback encontrado nesta consulta!');
			window.location.href=window.location.href;
		</script> <?php		
	}	
}
else if(isset($_POST['consultar']) && $tipo=="solicitacao"){
	if($feedback=="REMETENTE_ID"){
		$query="SELECT S.ID, U.NOME, S.MENSAGEM, S.SITUACAO FROM SOLICITACAO S INNER JOIN USUARIO U ON U.ID=S.DESTINATARIO_ID WHERE ".$feedback."=".$_SESSION["userId"]." ORDER BY S.REGISTRO DESC";
	}
	else{
		$query="SELECT S.ID, U.NOME, S.MENSAGEM, S.SITUACAO FROM SOLICITACAO S INNER JOIN USUARIO U ON U.ID=S.REMETENTE_ID WHERE ".$feedback."=".$_SESSION["userId"]." ORDER BY S.REGISTRO DESC";
	}
	$x=0;
	$cnx=mysqli_query($phpmyadmin, $query);
	while($feed= $cnx->fetch_array()){
		$vtId[$x]=$feed["ID"];
		$vtDestinatario[$x]=$feed["NOME"];		
		$vtFeedback[$x]=$feed["MENSAGEM"];
		$vtSituacao[$x]=$feed["SITUACAO"];
		$x++;
		$contador=$x;
	}
	if(mysqli_num_rows($cnx)==0){
		?><script type="text/javascript">			
			alert('Nenhuma Solicitação encontrada nesta consulta!');
			window.location.href=window.location.href;
		</script> <?php		
	}
}	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Consultar Feedback</title>
	<script type="text/javascript" src="/js/lib/dummy.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/result-light.css">   
</head>
<body>	
<hr/>
<section class="section" id="topo">
<?php if(isset($_POST['consultar'])==null ): ?>	
	<form id="form1" action="feedback-query.php" method="POST">
		<div class="field is-horizontal">
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Tipo:</label>
				</div>
				<div class="field-body">
					<div class="field" style="max-width:17em;">							
						<div class="control">
							<div class="select">
								<select name="tipo">								
									<option value="feedback">Feedback</option>
									<option value="solicitacao">Solicitação</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div> &nbsp;&nbsp;&nbsp;
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Feedback:</label>
				</div>
				<div class="field-body">
					<div class="field" style="max-width:17em;">							
						<div class="control">
							<div class="select">
								<select name="feedback">								
									<option value="REMETENTE_ID">Enviado(s)</option>
									<option value="DESTINATARIO_ID">Recebido(s)</option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="field is-horizontal">
				<div class="field-label"></div>
				<div class="field-body">
					<div class="field">
						<div class="control">
							<button name="consultar" type="submit" class="button is-primary">Consultar</button>
						</div>
					</div>
				</div>
			</div>
		</div>						
	</form>
<?php endif; ?>
<?php if(isset($_POST['consultar']) && $contador!=0) : ?>	
	<div class="table__wrapper">
	<table class="table is-bordered pricing__table is-fullwidth is-size-7-touch">	
	<tr>
		<th>N°</th>
		<?php if($feedback=="DESTINATARIO_ID"):?><th>Remetente</th><?php endif;?>
		<?php if($feedback=="REMETENTE_ID"):?><th>Destinatário</th><?php endif;?>
		<?php if($tipo=="feedback"): ?>
		<th>Tipo</th>
		<th>Pro</th>
		<th>Com</th>
		<th>Des</th>
		<th>Feedback</th>
		<?php endif;?>
		<?php if($tipo=="solicitacao"): ?>
		<th>Mensagem</th>		
		<?php endif;?>
		<th>Situação</th>
	</tr>
	<?php
 	for( $i = 0; $i < sizeof($vtId); $i++ ) : ?>
	<tr>
		<td><?php echo $i+1;?></td>		
		<?php if($feedback=="DESTINATARIO_ID"):?><td><?php if($vtExibicao[$i]==1){echo $vtRemetente[$i];} else if($tipo=="solicitacao"){echo $vtDestinatario[$i];} else{echo "Anônimo";}?></td><?php endif;?>
		<?php if($feedback=="REMETENTE_ID"):?><td><?php echo $vtDestinatario[$i]?></td><?php endif;?>
		<?php if($tipo=="feedback"): ?>
		<td><?php echo $vtTipo[$i]?></td>
		<td><?php echo $vtProfissional[$i]?></td> 
		<td><?php echo $vtComportamental[$i]?></td> 
		<td><?php echo $vtDesempenho[$i]?></td> 
		<?php endif;?>
		<td><?php echo $vtFeedback[$i]?></td>
  		<td><?php echo $vtSituacao[$i]?></td>  		
	</tr>
<?php endfor;?>
	</table>	
	<a href="#topo">		
		<div class=".scrollWrapper">
			<button class="button is-primary" style="width: 100%; display: table;">Ir Ao Topo</button>		
		</div>
	</a>
	<br/>
	<div class="table__wrapper">			
		<div class="field-body">
			<div class="field is-grouped">
				<div class="control">
					<a href="feedback-query.php"><input name="Limpar" type="submit" class="button is-primary" value="Nova consulta"/></a>
				</div>									
			</div>						
		</div>
	</div>
</section>
<?php endif;?>	
</body>
</html>
<?php
if(isset($_POST['consultar']) && $feedback=="DESTINATARIO_ID" && $contador>0){
	$x=0;
	if($tipo=="feedback"){
		$tabela="FEEDBACK";
	}
	else{
		$tabela="SOLICITACAO";
	}
	while( $x< sizeof($vtId)) {
		$upFeedback="UPDATE ".$tabela." SET SITUACAO='Lido' WHERE ID=".$vtId[$x];	
		$cnx=mysqli_query($phpmyadmin, $upFeedback);
		$x++;
	}
}
?>