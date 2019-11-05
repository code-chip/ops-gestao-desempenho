<style type="text/css">
</style>
<?php
$menuFeedback="is-active";
include('menu.php');
//<!--- DECLARAÇÃO DAS VARIAVEIS -->
$contador = 0;
$query="SELECT * FROM FEEDBACK";
	$x=0;
	$cnx=mysqli_query($phpmyadmin, $query);
	while($feed= $cnx->fetch_array()){
		$vt[$x]=$feed["NOME"];				
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
	</tr>
	<?php
 	for( $i = 0; $i < sizeof($vtNome); $i++ ) : ?>
	<?php $z=$i; $registro=1; while($vtNome[$z]==$vtNome[$z+1]){
		$registro++;
		$repeat=$registro;
		$z++;
	}
	if($repeat>0){ $repeat--;}	
	?>
	<tr>
		<td><?php echo $i+1;?></td>
		<td><?php echo $vtRemetente[$i]?></td>
		<td><?php echo $vtDestinatario[$i]?></td>
		<td><?php echo $vtTipo[$i]?></td>
		<td><?php echo $vtFeedback[$i]?></td>		
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
					<a href="register.php"><input name="Limpar" type="submit" class="button is-primary" value="Voltar"/></a>
				</div>					
			</div>						
		</div>
	</div>
</section>	
</body>
</html>