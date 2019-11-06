<style type="text/css">
</style>
<?php
$menuFeedback="is-active";
include('menu.php');
//<!--- DECLARAÇÃO DAS VARIAVEIS -->
$contador = 0;
$query="SELECT F.ID, U.NOME AS REMETENTE, U2.NOME AS DESTINATARIO, TIPO, FEEDBACK FROM FEEDBACK F INNER JOIN USUARIO U ON U.ID=F.REMETENTE_ID
INNER JOIN USUARIO U2 ON U2.ID=F.DESTINATARIO_ID WHERE APROVADO_POR IS NULL;";
	$x=0;
	$cnx=mysqli_query($phpmyadmin, $query);
	while($feed= $cnx->fetch_array()){
		$vtId[$x]=$feed["ID"];
		$vtRemetente[$x]=$feed["REMETENTE"];
		$vtDestinatario[$x]=$feed["DESTINATARIO"];
		$vtTipo[$x]=$feed["TIPO"];
		$vtFeedback[$x]=$feed["FEEDBACK"];				
		$x++;
		$contador=$x;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Feedback Pendente</title>
	<script type="text/javascript" src="/js/lib/dummy.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/result-light.css">   
</head>
<body>	
<hr/>
<form method="POST" action="feedback-approval.php" id="form1">
	<section class="section" id="topo">
	<div class="table__wrapper">
	<table class="table is-bordered pricing__table is-fullwidth is-size-7-touch">	
	<tr>
		<th>N°</th>
		<th>Remetente</th>
		<th>Destinatário</th>
		<th>Tipo</th>
		<th>Feedback</th>
		<th>Aprovar</th> 			
	</tr>
	<?php
 	for( $i = 0; $i < sizeof($vtRemetente); $i++ ) : ?>
	<tr>
		<td><?php echo $i+1;?></td>
		<td><?php echo $vtRemetente[$i]?></td>
		<td><?php echo $vtDestinatario[$i]?></td>
		<td><?php echo $vtTipo[$i]?></td>
		<td><?php echo $vtFeedback[$i]?></td>
		<td>
  			<div class="select">
  				<select name="id[]">
  					<option value="1">Sim</option>
  					<option value="2">Não</option>
  				</select>					
			</div>	
  		</td>		
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
			<div class="field">				
				<div class="control">
					<input name="aprovar" type="submit" class="button is-primary" value="Aprovar"/>
				</div>					
			</div>						
		</div>
	</div>
</section>
</form>	
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