<?php
//session_start();
$menuConfiguracoes="is-active";
include('menu.php');
//<!--- DECLARAÇÃO DAS VARIAVEIS -->
$contador = 0;
$query1="SELECT NOME, SITUACAO FROM CARGO;";
$query2="SELECT NOME, SITUACAO FROM GESTOR;";
$query3="SELECT NOME, SITUACAO FROM SETOR;";
$query4="SELECT NOME, SITUACAO FROM PERMISSAO;";
$x=0;
$cnx=mysqli_query($phpmyadmin, $query1);
while($cargo= $cnx->fetch_array()){
	$vtCNome[$x]=$cargo["NOME"];		
	$vtCSituacao[$x]=$cargo["SITUACAO"];
	$x++;
	$contador=$x;
}
$x=0;
$cnx=mysqli_query($phpmyadmin, $query2);
while($gestor= $cnx->fetch_array()){
	$vtGNome[$x]=$gestor["NOME"];		
	$vtGSituacao[$x]=$gestor["SITUACAO"];
	$x++;
}
$x=0;
$cnx=mysqli_query($phpmyadmin, $query3);
while($setor= $cnx->fetch_array()){
	$vtSNome[$x]=$setor["NOME"];		
	$vtSSituacao[$x]=$setor["SITUACAO"];
	$x++;
}
$x=0;
$cnx=mysqli_query($phpmyadmin, $query4);
while($permissao= $cnx->fetch_array()){
	$vtPNome[$x]=$permissao["NOME"];		
	$vtPSituacao[$x]=$permissao["SITUACAO"];
	$x++;
}

if(mysqli_num_rows($cnx)==0){
	?><script type="text/javascript">			
		alert('Nenhum registrado encontrado nesta consulta!');
		window.location.href=window.location.href;
	</script> <?php		
}	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Gestão de Desempenho - Lista de Opções</title>
	<script type="text/javascript" src="/js/lib/dummy.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/result-light.css">   
</head>
<body>	
<hr/>
	<section class="section" id="topo">
	<div class="table__wrapper">
	<table class="table is-bordered pricing__table is-fullwidth is-size-7-touch">	
	<tr>
		<th>Cargo</th>
		<th>Situação</th>
		<th>Gestor</th>
		<th>Situação</th>
		<th>Setor</th>
		<th>Situação</th>		
		<th>Permissão</th>
		<th>Situação</th>		 			
	</tr>
	<?php
 	for( $i = 0; $i < sizeof($vtCNome); $i++ ) : ?>
 	<tr>	
		<td><?php echo $vtCNome[$i]?></td>
		<td><?php echo $vtCSituacao[$i]?></td>
		<td><?php echo $vtGNome[$i]?></td>
		<td><?php echo $vtGSituacao[$i]?></td>
		<td><?php echo $vtSNome[$i]?></td>
		<td><?php echo $vtSSituacao[$i]?></td>
		<td><?php echo $vtPNome[$i]?></td>
		<td><?php echo $vtPSituacao[$i]?></td>
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
					<a href="register.php"><input name="Voltar" type="submit" class="button is-primary" value="Voltar"/></a>
				</div>					
			</div>						
		</div>
	</div>
</section>	
</body>
</html>