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
	if(mysqli_num_rows($cnx)==0){
		?><script type="text/javascript">			
			alert('Nenhum feedback aguardando aprovação no momento!');
			window.location.href=window.location.href;
		</script> <?php		
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
		<td><label class="checkbox">
  				<input name="id[]" type="checkbox" value="<?php echo $vtId[$i]?>">
  				Sim
  			</label>  </td>		
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
</body>
</html>
<?php 
if(isset($_POST["aprovar"])!=null){

}
?>