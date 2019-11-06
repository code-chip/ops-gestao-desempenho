<?php
$menuFeedback="is-active";
include('menu.php');
$situacao= trim($_POST["situacao"]);
$contador = 0;
if(isset($_POST['consultar'])){
$query="SELECT F.ID, U.NOME AS REMETENTE, U2.NOME AS DESTINATARIO, TIPO, FEEDBACK, U3.NOME AS APROVADO_POR FROM FEEDBACK F INNER JOIN USUARIO U ON U.ID=F.REMETENTE_ID
INNER JOIN USUARIO U2 ON U2.ID=F.DESTINATARIO_ID INNER JOIN USUARIO U3 ON U3.ID=F.APROVADO_POR WHERE ".$situacao;
	$x=0;
	$cnx=mysqli_query($phpmyadmin, $query);
	while($feed= $cnx->fetch_array()){
		$vtId[$x]=$feed["ID"];
		$vtRemetente[$x]=$feed["REMETENTE"];
		$vtDestinatario[$x]=$feed["DESTINATARIO"];
		$vtTipo[$x]=$feed["TIPO"];
		$vtFeedback[$x]=$feed["FEEDBACK"];
		$vtAprovadoPor[$x]=$feed["APROVADO_POR"];				
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
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Aprovação Feedback</title>
	<script type="text/javascript" src="/js/lib/dummy.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/result-light.css">   
</head>
<body>	
<hr/>
<section class="section" id="topo">
<?php if($situacao =="" && isset($_POST['consultar'])==null ): ?>	
	<form id="form1" action="feedback-approval.php" method="POST">
		<div class="field is-horizontal">
			<div class="field is-horizontal">
				<div class="field-label is-normal">
					<label class="label">Situação:</label>
				</div>
				<div class="field-body">
					<div class="field" style="max-width:17em;">							
						<div class="control">
							<div class="select">
								<select name="situacao">								
									<option value="APROVADO_POR IS NULL">Aguardando</option>
									<option value="APROVADO_POR=2">Reprovado</option>
									<option value="APROVADO_POR=1">Aprovado</option>
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
<form method="POST" action="feedback-approval.php" id="form2">	
	<div class="table__wrapper">
	<table class="table is-bordered pricing__table is-fullwidth is-size-7-touch">	
	<tr>
		<th>N°</th>
		<th>Remetente</th>
		<th>Destinatário</th>
		<th>Tipo</th>
		<th>Feedback</th>
		<?php if($situacao=="APROVADO_POR IS NULL"):?><th>Aprovar</th><?php endif;?>
		<?php if($situacao=="APROVADO_POR=1"):?><th>Aprovado por</th><?php endif;?>
		<?php if($situacao=="APROVADO_POR=2"):?><th>Reprovado por</th><?php endif;?>    			
	</tr>
	<?php
 	for( $i = 0; $i < sizeof($vtRemetente); $i++ ) : ?>
	<tr>
		<td><?php echo $i+1;?></td>
		<td><?php echo $vtRemetente[$i]?></td>
		<td><?php echo $vtDestinatario[$i]?></td>
		<td><?php echo $vtTipo[$i]?></td>
		<td><?php echo $vtFeedback[$i]?></td>
		<?php if($situacao=="APROVADO_POR IS NULL"):?><td>
  			<div class="select">
  				<select name="id[]">
  					<option value="">...</option>
  					<option value="1">Sim</option>
  					<option value="2">Não</option>
  				</select>					
			</div>	
  		</td><?php endif;?>
  		<?php if($situacao!="APROVADO_POR IS NULL"):?><td><?php echo $vtAprovadoPor[$i]?></td><?php endif;?>
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
					<a href="feedback-approval.php"><input name="Limpar" type="submit" class="button is-primary" value="Nova consulta"/></a>
				</div>
				<div class="control">
					<input name="aprovar" type="submit" class="button is-primary" value="Aprovar"/>
				</div>					
			</div>						
		</div>
	</div>
</section>
</form>
<?php endif;?>	
</body>
</html>
<?php 
if(isset($_POST["aprovar"])){
	$ids=array_filter($_POST["id"]);
	$x=0;
	while ($x< sizeof($ids)) {
		$upFeedback="UPDATE FEEDBACK SET APROVADO_POR=".$_SESSION["userId"].", SITUACAO='Aprovado' WHERE ID=".$ids[$x];
		$cnx= mysqli_query($phpmyadmin, $upFeedback);
		$x++;
	}
	if($x>0){
		$x=$x+1;
		?><script type="text/javascript">			
			alert('Foi atualizado(s) '<?php echo $x;?>' feedback(s)!');
			window.location.href=window.location.href;
		</script> <?php		
	}
	else{
		?><script type="text/javascript">			
			alert('Nenhum feedback foi atualizado!');
			window.location.href=window.location.href;
		</script> <?php	
	}
}
?>